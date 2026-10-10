<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Faq
{
    public static function all(): array
    {
        return Database::query("SELECT * FROM faqs ORDER BY display_order ASC, id ASC");
    }

    public static function active(): array
    {
        return Database::query("SELECT * FROM faqs WHERE is_active = 1 ORDER BY display_order ASC, id ASC");
    }

    public static function findById(int $id): ?array
    {
        return Database::one("SELECT * FROM faqs WHERE id = ? LIMIT 1", [$id]);
    }

    public static function create(array $data): bool
    {
        $sql = "INSERT INTO faqs (question, answer, section, display_order, is_active, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        return Database::execute($sql, [
            $data['question'],
            $data['answer'],
            $data['section'] ?? 'home',
            $data['display_order'] ?? 0,
            $data['is_active'] ?? 1
        ]);
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE faqs SET question = ?, answer = ?, section = ?, display_order = ?, is_active = ? WHERE id = ?";
        return Database::execute($sql, [
            $data['question'],
            $data['answer'],
            $data['section'] ?? 'home',
            $data['display_order'] ?? 0,
            $data['is_active'] ?? 1,
            $id
        ]);
    }

    public static function delete(int $id): bool
    {
        return Database::execute("DELETE FROM faqs WHERE id = ?", [$id]);
    }
}
