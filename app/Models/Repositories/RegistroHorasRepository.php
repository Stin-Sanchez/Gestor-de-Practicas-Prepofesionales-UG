<?php
declare(strict_types=1);

namespace App\Models\Repositories;

use App\Models\Entities\RegistroHoras;
use DateTimeImmutable;

interface RegistroHorasRepository
{
    public function guardar(RegistroHoras $r): int;

    public function horasDelDia(int $asignacionId, DateTimeImmutable $fecha): float;

    public function asignacionPerteneceA(int $asignacionId, int $usuarioId): bool;

    /** @return array<int, array{id:int, empresa:string}> */
    public function asignacionesDe(int $usuarioId): array;

    /** @return array<int, array<string, mixed>> */
    public function listarDe(int $usuarioId): array;
}
