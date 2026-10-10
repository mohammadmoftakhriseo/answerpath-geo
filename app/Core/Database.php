<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * Robust Thread-Safe PDO Database Singleton
 */
class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $root = defined('\ROOT_PATH') ? \ROOT_PATH : (defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2));
            $configFile = $root . '/config/database.php';
            if (!file_exists($configFile)) {
                throw new \RuntimeException("Database configuration file missing.");
            }

            $config = require $configFile;

            $dsn = sprintf(
                '%s:host=%s;port=%d;dbname=%s;charset=%s',
                $config['driver'] ?? 'mysql',
                $config['host'] ?? 'localhost',
                $config['port'] ?? 3306,
                $config['database'] ?? '',
                $config['charset'] ?? 'utf8mb4'
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $config['username'] ?? '',
                    $config['password'] ?? '',
                    $config['options'] ?? []
                );
            } catch (PDOException $e) {
                error_log("[Database Connection Error] " . $e->getMessage());
                throw new \RuntimeException("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    public static function query(string $sql, array $params = []): array
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function one(string $sql, array $params = []): ?array
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public static function execute(string $sql, array $params = []): bool
    {
        $stmt = self::getConnection()->prepare($sql);
        return $stmt->execute($params);
    }

    public static function lastInsertId(): string
    {
        return self::getConnection()->lastInsertId();
    }
}
