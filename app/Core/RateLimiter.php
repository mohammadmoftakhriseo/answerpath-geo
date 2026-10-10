<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Enterprise Sliding-Window IP Rate Limiter
 * Guards sensitive endpoints (Login, Leads, Roadmaps, Admin) against Brute Force & DoS attacks
 */
class RateLimiter
{
    private static string $storageDir = '';

    private static function getStorageDir(): string
    {
        if (empty(self::$storageDir)) {
            $root = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            self::$storageDir = $root . '/storage/locks/rate_limit';
            if (!is_dir(self::$storageDir)) {
                @mkdir(self::$storageDir, 0755, true);
            }
        }
        return self::$storageDir;
    }

    private static function getFilePath(string $key): string
    {
        $safeKey = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $key);
        $hash = md5($key);
        return self::getStorageDir() . "/rl_{$safeKey}_{$hash}.json";
    }

    /**
     * Check if the rate limit has been exceeded
     *
     * @param string $key Unique identifier (e.g. "login:1.2.3.4" or "lead:1.2.3.4")
     * @param int $maxAttempts Maximum allowed requests within the window
     * @param int $decaySeconds Window duration in seconds
     * @return bool True if too many attempts, False if within limit
     */
    public static function tooManyAttempts(string $key, int $maxAttempts, int $decaySeconds = 60): bool
    {
        $file = self::getFilePath($key);
        if (!file_exists($file)) {
            return false;
        }

        $content = @file_get_contents($file);
        if (!$content) {
            return false;
        }

        $data = json_decode($content, true);
        if (!is_array($data) || empty($data['timestamps'])) {
            return false;
        }

        $now = time();
        $cutoff = $now - $decaySeconds;

        // Filter timestamps within the decay window
        $validTimestamps = array_values(array_filter($data['timestamps'], fn($t) => $t > $cutoff));

        if (count($validTimestamps) !== count($data['timestamps'])) {
            @file_put_contents($file, json_encode(['timestamps' => $validTimestamps]), LOCK_EX);
        }

        return count($validTimestamps) >= $maxAttempts;
    }

    /**
     * Record a hit/attempt for the rate limiter
     */
    public static function hit(string $key, int $decaySeconds = 60): int
    {
        $file = self::getFilePath($key);
        $now = time();
        $cutoff = $now - $decaySeconds;

        $timestamps = [];
        if (file_exists($file)) {
            $content = @file_get_contents($file);
            if ($content) {
                $data = json_decode($content, true);
                if (is_array($data) && !empty($data['timestamps'])) {
                    $timestamps = array_filter($data['timestamps'], fn($t) => $t > $cutoff);
                }
            }
        }

        $timestamps[] = $now;
        @file_put_contents($file, json_encode(['timestamps' => array_values($timestamps)]), LOCK_EX);

        // Periodically purge stale rate limit files (1 in 50 requests)
        if (mt_rand(1, 50) === 1) {
            self::purgeStaleFiles(86400);
        }

        return count($timestamps);
    }

    /**
     * Clear the rate limit for a key (e.g. after successful login)
     */
    public static function clear(string $key): void
    {
        $file = self::getFilePath($key);
        if (file_exists($file)) {
            @unlink($file);
        }
    }

    /**
     * Get remaining available attempts
     */
    public static function retriesLeft(string $key, int $maxAttempts, int $decaySeconds = 60): int
    {
        $file = self::getFilePath($key);
        if (!file_exists($file)) {
            return $maxAttempts;
        }

        $content = @file_get_contents($file);
        if (!$content) {
            return $maxAttempts;
        }

        $data = json_decode($content, true);
        if (!is_array($data) || empty($data['timestamps'])) {
            return $maxAttempts;
        }

        $now = time();
        $cutoff = $now - $decaySeconds;
        $valid = array_filter($data['timestamps'], fn($t) => $t > $cutoff);

        return max(0, $maxAttempts - count($valid));
    }

    /**
     * Get seconds until key is available again
     */
    public static function availableIn(string $key, int $decaySeconds = 60): int
    {
        $file = self::getFilePath($key);
        if (!file_exists($file)) {
            return 0;
        }

        $content = @file_get_contents($file);
        if (!$content) {
            return 0;
        }

        $data = json_decode($content, true);
        if (!is_array($data) || empty($data['timestamps'])) {
            return 0;
        }

        $oldest = min($data['timestamps']);
        $now = time();
        $diff = ($oldest + $decaySeconds) - $now;

        return max(0, $diff);
    }

    /**
     * Purge files older than max age
     */
    public static function purgeStaleFiles(int $maxAgeSeconds = 3600): void
    {
        $dir = self::getStorageDir();
        $files = glob($dir . '/rl_*.json');
        if (!$files) return;

        $now = time();
        foreach ($files as $f) {
            if ($now - filemtime($f) > $maxAgeSeconds) {
                @unlink($f);
            }
        }
    }
}
