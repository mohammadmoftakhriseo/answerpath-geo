<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class SiteSetting
{
    private static array $cache = [];

    public static function get(string $key, mixed $default = null): mixed
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $row = Database::one("SELECT setting_value FROM site_settings WHERE setting_key = ? LIMIT 1", [$key]);
        if ($row) {
            self::$cache[$key] = $row['setting_value'];
            return $row['setting_value'];
        }

        return $default;
    }

    public static function set(string $key, string $value): bool
    {
        self::$cache[$key] = $value;
        $exists = Database::one("SELECT id FROM site_settings WHERE setting_key = ? LIMIT 1", [$key]);
        if ($exists) {
            return Database::execute("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?", [$value, $key]);
        }
        return Database::execute("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)", [$key, $value]);
    }

    public static function all(): array
    {
        $rows = Database::query("SELECT setting_key, setting_value FROM site_settings");
        $settings = [];
        foreach ($rows as $r) {
            $settings[$r['setting_key']] = $r['setting_value'];
        }
        return $settings;
    }
}
