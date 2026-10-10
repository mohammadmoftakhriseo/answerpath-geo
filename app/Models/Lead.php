<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Lead
{
    public static function create(array $data): bool
    {
        $fullName = trim($data['full_name'] ?? (($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')));
        if (empty($fullName)) {
            $fullName = 'درخواست مشاوره / بریف';
        }

        $sql = "INSERT INTO leads (full_name, phone, website_url, service_requested, message, source_cta, current_page, user_journey, referrer, utm_source, utm_medium, utm_campaign, utm_term, utm_content, ip_address, user_agent, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        return Database::execute($sql, [
            $fullName,
            $data['phone'] ?? '',
            $data['website_url'] ?? null,
            $data['service_requested'] ?? 'مشاوره سئو',
            $data['message'] ?? null,
            $data['source_cta'] ?? 'smart_brief',
            $data['current_page'] ?? null,
            $data['user_journey'] ?? null,
            $data['referrer'] ?? null,
            $data['utm_source'] ?? null,
            $data['utm_medium'] ?? null,
            $data['utm_campaign'] ?? null,
            $data['utm_term'] ?? null,
            $data['utm_content'] ?? null,
            $data['ip_address'] ?? '',
            $data['user_agent'] ?? ''
        ]);
    }

    public static function all(): array
    {
        return Database::query("SELECT * FROM leads ORDER BY id DESC");
    }

    public static function findById(int $id): ?array
    {
        return Database::one("SELECT * FROM leads WHERE id = ? LIMIT 1", [$id]);
    }

    public static function updateStatus(int $id, string $status, ?string $notes = null): bool
    {
        return Database::execute("UPDATE leads SET status = ?, admin_notes = ? WHERE id = ?", [$status, $notes, $id]);
    }

    public static function delete(int $id): bool
    {
        return Database::execute("DELETE FROM leads WHERE id = ?", [$id]);
    }
}
