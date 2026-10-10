<?php
declare(strict_types=1);

namespace App\Core;

use App\Models\User;

/**
 * Enterprise Secure Authentication Manager
 * Hardened with Session Fixation Defense and Complete Session Invalidation
 */
class Auth
{
    private const SESSION_KEY = '_auth_user_id';

    public static function attempt(string $username, string $password): bool
    {
        $cleanUsername = trim($username);
        if ($cleanUsername === '' || $password === '') {
            return false;
        }

        $user = User::findByUsername($cleanUsername);
        if (!$user) {
            return false;
        }

        $hash = $user['password'] ?? $user['password_hash'] ?? '';
        if (empty($hash)) {
            return false;
        }

        if (password_verify($password, $hash)) {
            // Regenerate session ID to eliminate Session Fixation attacks
            Session::regenerate(true);

            Session::set(self::SESSION_KEY, (int)$user['id']);
            Session::set('_auth_user', [
                'id'       => (int)$user['id'],
                'username' => $user['username'],
                'name'     => $user['name'] ?? $user['username'],
                'role'     => $user['role'] ?? 'admin'
            ]);
            return true;
        }

        return false;
    }

    public static function check(): bool
    {
        return Session::has(self::SESSION_KEY) && !empty(Session::get(self::SESSION_KEY));
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }
        return Session::get('_auth_user');
    }

    public static function id(): ?int
    {
        $id = Session::get(self::SESSION_KEY);
        return $id ? (int)$id : null;
    }

    public static function logout(): void
    {
        Session::destroy();
    }
}
