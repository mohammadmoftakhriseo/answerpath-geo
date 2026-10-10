<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Enterprise Lightweight .env Environment Loader
 * Securely loads environment variables into $_ENV, $_SERVER, and getenv()
 */
class Env
{
    private static bool $loaded = false;

    public static function load(?string $path = null): void
    {
        if (self::$loaded) {
            return;
        }

        $root = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $filePath = $path ?: ($root . '/.env');

        if (!file_exists($filePath) || !is_readable($filePath)) {
            self::$loaded = true;
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            self::$loaded = true;
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip comments and empty lines
            if ($line === '' || str_starts_with($line, '#') || str_starts_with($line, ';')) {
                continue;
            }

            // Split into KEY = VALUE
            $pos = strpos($line, '=');
            if ($pos === false) {
                continue;
            }

            $key = trim(substr($line, 0, $pos));
            $value = trim(substr($line, $pos + 1));

            if ($key === '') {
                continue;
            }

            // Strip surrounding quotes
            if (
                (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                (str_starts_with($value, "'") && str_ends_with($value, "'"))
            ) {
                $value = substr($value, 1, -1);
            }

            // Parse boolean and null keywords
            $parsedValue = match (strtolower($value)) {
                'true', '(true)'   => true,
                'false', '(false)' => false,
                'null', '(null)'   => null,
                'empty', '(empty)' => '',
                default            => $value
            };

            // Set environment variables safely
            if (!isset($_ENV[$key])) {
                $_ENV[$key] = $parsedValue;
            }
            if (!isset($_SERVER[$key])) {
                $_SERVER[$key] = $parsedValue;
            }
            putenv("{$key}={$value}");
        }

        self::$loaded = true;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::load();

        if (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        }

        if (array_key_exists($key, $_SERVER)) {
            return $_SERVER[$key];
        }

        $val = getenv($key);
        if ($val !== false) {
            return match (strtolower((string)$val)) {
                'true', '(true)'   => true,
                'false', '(false)' => false,
                'null', '(null)'   => null,
                'empty', '(empty)' => '',
                default            => $val
            };
        }

        return $default;
    }
}
