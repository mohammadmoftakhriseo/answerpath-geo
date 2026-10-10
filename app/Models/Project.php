<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Project
{
    public static function all(): array
    {
        return Database::query("SELECT * FROM projects ORDER BY display_order ASC, id DESC");
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::one("SELECT * FROM projects WHERE slug = ? LIMIT 1", [$slug]);
    }

    public static function findById(int $id): ?array
    {
        return Database::one("SELECT * FROM projects WHERE id = ? LIMIT 1", [$id]);
    }

    public static function create(array $data): bool
    {
        $sql = "INSERT INTO projects (title, slug, client_name, category, short_summary, description, results_metrics, featured_image, is_featured, display_order, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        return Database::execute($sql, [
            $data['title'],
            $data['slug'],
            $data['client_name'] ?? '',
            $data['category'] ?? 'SEO & Project Management',
            $data['short_summary'] ?? '',
            $data['description'] ?? '',
            $data['results_metrics'] ?? '{}',
            $data['featured_image'] ?? null,
            $data['is_featured'] ?? 1,
            $data['display_order'] ?? 0,
            $data['status'] ?? 'published'
        ]);
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE projects SET title = ?, slug = ?, client_name = ?, category = ?, short_summary = ?, description = ?, results_metrics = ?, featured_image = ?, is_featured = ?, display_order = ?, status = ? WHERE id = ?";
        return Database::execute($sql, [
            $data['title'],
            $data['slug'],
            $data['client_name'] ?? '',
            $data['category'] ?? 'SEO & Project Management',
            $data['short_summary'] ?? '',
            $data['description'] ?? '',
            $data['results_metrics'] ?? '{}',
            $data['featured_image'] ?? null,
            $data['is_featured'] ?? 1,
            $data['display_order'] ?? 0,
            $data['status'] ?? 'published',
            $id
        ]);
    }

    public static function delete(int $id): bool
    {
        return Database::execute("DELETE FROM projects WHERE id = ?", [$id]);
    }
}
