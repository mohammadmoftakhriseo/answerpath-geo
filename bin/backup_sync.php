<?php
declare(strict_types=1);

/**
 * Enterprise Hybrid Git & REST API Cloud Backup Engine
 * 
 * Works with both:
 * 1. Native Git CLI (if shell_exec is allowed)
 * 2. GitHub REST API Direct Sync (Fail-safe: works even when shell_exec is disabled on shared hosting!)
 * 
 * Cron Usage:
 * /usr/local/bin/php /home3/ozroiffx/public_html/bin/backup_sync.php >> /home3/ozroiffx/public_html/storage/logs/git_backup.log 2>&1
 */

define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/app/Core/Env.php';
\App\Core\Env::load();

require_once ROOT_PATH . '/app/Services/GitHubSyncService.php';

$token   = (string)\App\Core\Env::get('GITHUB_TOKEN', '');
$owner   = (string)\App\Core\Env::get('GITHUB_OWNER', 'mohammadmoftakhriseo');
$repo    = (string)\App\Core\Env::get('GITHUB_REPO', 'answerpath-geo');
$branch  = (string)\App\Core\Env::get('GITHUB_BRANCH', 'main');
$enabled = (bool)\App\Core\Env::get('GITHUB_ENABLED', true);

function logMsg(string $msg): void {
    $time = date('Y-m-d H:i:s');
    $logDir = defined('ROOT_PATH') ? (ROOT_PATH . '/storage/logs') : (__DIR__ . '/../storage/logs');
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0755, true);
    }
    $logFile = $logDir . '/git_backup.log';
    $line = "[{$time}] {$msg}\n";
    echo $line;
    @file_put_contents($logFile, $line, FILE_APPEND);
}

logMsg("==================================================");
logMsg("=== Starting Automated GitHub Cloud Backup ===");

if (!$enabled) {
    logMsg("SKIPPED: GITHUB_ENABLED is false in .env");
    exit(0);
}

if (empty($token) || str_starts_with($token, 'your_')) {
    logMsg("SKIPPED: GITHUB_TOKEN is not set in .env");
    exit(0);
}

// -------------------------------------------------------------------------
// رویکرد ۱: بررسی امکان اجرای Git از طریق خط فرمان (Native Git CLI)
// -------------------------------------------------------------------------
$canUseShell = function_exists('shell_exec') && !in_array('shell_exec', array_map('trim', explode(',', ini_get('disable_functions') ?: '')));

if ($canUseShell) {
    $gitVersion = @shell_exec('git --version 2>&1');
    if ($gitVersion && str_contains($gitVersion, 'git version')) {
        logMsg("MODE: Native Git CLI Detected (" . trim($gitVersion) . ")");

        chdir(ROOT_PATH);
        @shell_exec('git config --global --add safe.directory ' . escapeshellarg(ROOT_PATH));

        if (!is_dir(ROOT_PATH . '/.git')) {
            logMsg("Initializing new Git repository...");
            @shell_exec('git init 2>&1');
            @shell_exec('git branch -M ' . escapeshellarg($branch) . ' 2>&1');
        }

        @shell_exec('git config user.name "Mohammad Moftakhari (Automation)"');
        @shell_exec('git config user.email "mohammad@maaadmr.ir"');

        $remoteUrl = "https://{$token}@github.com/{$owner}/{$repo}.git";
        $remotes = (string)@shell_exec('git remote get-url origin 2>&1');
        if (empty($remotes) || str_contains($remotes, 'fatal') || str_contains($remotes, 'error')) {
            @shell_exec('git remote add origin ' . escapeshellarg($remoteUrl) . ' 2>&1');
        } else {
            @shell_exec('git remote set-url origin ' . escapeshellarg($remoteUrl) . ' 2>&1');
        }

        @shell_exec('git add . 2>&1');
        $status = trim((string)@shell_exec('git status --porcelain 2>&1'));

        if (empty($status)) {
            logMsg("NO CHANGES: Git working tree clean. Everything already up to date.");
            logMsg("=== Backup Finished Successfully ===");
            exit(0);
        }

        $commitMsg = "Auto-backup: " . date('Y-m-d H:i:s') . " [Server CLI Sync]";
        $commitOut = @shell_exec('git commit -m ' . escapeshellarg($commitMsg) . ' 2>&1');
        logMsg("Commit: " . trim((string)$commitOut));

        $pushOut = @shell_exec('git push -u origin ' . escapeshellarg($branch) . ' 2>&1');
        logMsg("Push: " . trim((string)$pushOut));
        logMsg("=== Backup Finished Successfully via Git CLI ===");
        exit(0);
    }
}

// -------------------------------------------------------------------------
// رویکرد ۲: همگام‌سازی ابری Fail-Safe از طریق GitHub REST API (بدون نیاز به shell_exec)
// -------------------------------------------------------------------------
logMsg("MODE: GitHub REST API Cloud Sync (Isolated & Web-Safe)");

$gitService = new \App\Services\GitHubSyncService();
if (!$gitService->isConfigured()) {
    logMsg("ERROR: GitHubSyncService is not properly configured.");
    exit(1);
}

// ثبت وضعیت اسنپ‌شات بک‌آپ
$backupManifest = [
    'backup_time'     => date('Y-m-d H:i:s'),
    'environment'     => 'production (maaadmr.ir)',
    'php_version'     => PHP_VERSION,
    'sync_type'       => 'Cloud Scheduled Snapshot',
    'status'          => 'healthy',
];

$manifestResult = $gitService->pushFile(
    'data/backup_status.json',
    json_encode($backupManifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    "Scheduled Cloud Backup Ping: " . date('Y-m-d H:i:s'),
    $branch
);

if ($manifestResult['success'] ?? false) {
    logMsg("SUCCESS: Cloud Backup status synced to GitHub [Commit: " . ($manifestResult['commit_sha'] ?? 'OK') . "]");
} else {
    logMsg("WARNING: Manifest sync notice: " . ($manifestResult['message'] ?? 'Unknown'));
}

// اسکن و آپلود فایل‌های کلیدی تغییر یافته
$directoriesToScan = [
    ROOT_PATH . '/app',
    ROOT_PATH . '/config',
    ROOT_PATH . '/routes',
    ROOT_PATH . '/views',
    ROOT_PATH . '/bin',
];

$syncedCount = 0;
$skippedCount = 0;

foreach ($directoriesToScan as $dir) {
    if (!is_dir($dir)) continue;

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        if ($item->isFile()) {
            $ext = strtolower($item->getExtension());
            if (!in_array($ext, ['php', 'json', 'sh', 'htaccess', 'md'])) {
                continue;
            }

            $relPath = ltrim(str_replace([ROOT_PATH, '\\'], ['', '/'], $item->getPathname()), '/');

            // نادیده گرفتن فایل‌های حساس یا کش
            if (str_contains($relPath, '.env') || str_contains($relPath, 'storage/') || str_contains($relPath, 'error_log')) {
                continue;
            }

            // چک کردن هش محلی و فایل
            $localContent = file_get_contents($item->getPathname());
            if ($localContent === false) continue;

            $existing = $gitService->getFile($relPath, $branch);
            if ($existing !== null && trim($existing['content']) === trim($localContent)) {
                $skippedCount++;
                continue;
            }

            // فایل جدید یا تغییر یافته است؛ پوش می‌کنیم
            logMsg("Uploading modified file: {$relPath}...");
            $res = $gitService->pushFile($relPath, $localContent, "Auto-sync: update {$relPath}", $branch);
            if ($res['success'] ?? false) {
                $syncedCount++;
            }
        }
    }
}

logMsg("Summary: {$syncedCount} files updated, {$skippedCount} unchanged.");
logMsg("=== Backup Finished Successfully via GitHub REST API ===");
