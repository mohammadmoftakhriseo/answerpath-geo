<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Article
{
    public static function all(): array
    {
        return Database::query("SELECT * FROM articles ORDER BY published_at DESC, id DESC");
    }

    public static function published(): array
    {
        return Database::query("SELECT * FROM articles WHERE status = 'published' ORDER BY published_at DESC, id DESC");
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::one("SELECT * FROM articles WHERE slug = ? AND status = 'published' LIMIT 1", [$slug]);
    }

    public static function findById(int $id): ?array
    {
        return Database::one("SELECT * FROM articles WHERE id = ? LIMIT 1", [$id]);
    }

    public static function create(array $data): bool
    {
        $sql = "INSERT INTO articles (author_id, title, slug, direct_answer, summary, content, featured_image, reading_time, status, published_at, seo_title, seo_description, faq_data, schema_type, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        return Database::execute($sql, [
            $data['author_id'] ?? 1,
            $data['title'],
            $data['slug'],
            $data['direct_answer'] ?? '',
            $data['summary'] ?? '',
            $data['content'] ?? '',
            $data['featured_image'] ?? null,
            $data['reading_time'] ?? 5,
            $data['status'] ?? 'published',
            $data['published_at'] ?? date('Y-m-d H:i:s'),
            $data['seo_title'] ?? $data['title'],
            $data['seo_description'] ?? '',
            $data['faq_data'] ?? '[]',
            $data['schema_type'] ?? 'Article'
        ]);
    }

    public static function update(int $id, array $data): bool
    {
        $existing = self::findById($id);
        $publishedAt = $data['published_at'] ?? ($existing['published_at'] ?? date('Y-m-d H:i:s'));

        $sql = "UPDATE articles SET title = ?, slug = ?, direct_answer = ?, summary = ?, content = ?, featured_image = ?, reading_time = ?, status = ?, published_at = ?, seo_title = ?, seo_description = ?, faq_data = ?, schema_type = ? WHERE id = ?";
        return Database::execute($sql, [
            $data['title'],
            $data['slug'],
            $data['direct_answer'] ?? '',
            $data['summary'] ?? '',
            $data['content'] ?? '',
            $data['featured_image'] ?? null,
            $data['reading_time'] ?? 5,
            $data['status'] ?? 'published',
            $publishedAt,
            $data['seo_title'] ?? $data['title'],
            $data['seo_description'] ?? '',
            $data['faq_data'] ?? '[]',
            $data['schema_type'] ?? 'Article',
            $id
        ]);
    }

    public static function delete(int $id): bool
    {
        return Database::execute("DELETE FROM articles WHERE id = ?", [$id]);
    }
}
