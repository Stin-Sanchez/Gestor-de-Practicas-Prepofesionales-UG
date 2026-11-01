<?php
declare(strict_types=1);

namespace App\Models\Repositories;

use PDO;

final class PdoUsuarioRepository
{
    public function __construct(private PDO $db) {}

    /** @return array{id:int, nombre:string, rol:string, password_hash:string}|null */
    public function buscarActivoPorEmail(string $email): ?array
    {
        $st = $this->db->prepare(
            'SELECT id, nombre, rol, password_hash FROM usuarios WHERE email = ? AND activo = 1'
        );
        $st->execute([$email]);
        return $st->fetch() ?: null;
    }
}
