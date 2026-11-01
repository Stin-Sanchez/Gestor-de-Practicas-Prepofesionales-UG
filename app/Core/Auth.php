<?php
declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function login(int $id, string $rol, string $nombre): void
    {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $id;
        $_SESSION['rol']        = $rol;
        $_SESSION['nombre']     = $nombre;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function check(): bool { return isset($_SESSION['usuario_id']); }
    public static function id(): int     { return (int) ($_SESSION['usuario_id'] ?? 0); }
    public static function rol(): string { return $_SESSION['rol'] ?? ''; }

    public static function csrfToken(): string
    {
        return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
    }

    public static function csrfValido(?string $token): bool
    {
        return $token !== null && hash_equals($_SESSION['csrf'] ?? '', $token);
    }
}
