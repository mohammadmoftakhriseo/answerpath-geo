<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class User
{
    public static function findByUsername(string $username): ?array
    {
        return Database::one("SELECT * FROM users WHERE username = ? LIMIT 1", [$username]);
    }

    public static function findById(int $id): ?array
    {
        return Database::one("SELECT * FROM users WHERE id = ? LIMIT 1", [$id]);
    }
}
