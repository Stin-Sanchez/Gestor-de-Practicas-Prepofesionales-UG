<?php
declare(strict_types=1);

namespace App\Models\Services;

use App\Models\Entities\RegistroHoras;
use App\Models\Repositories\RegistroHorasRepository;
use DateTimeImmutable;
use DomainException;

final class RegistrarHorasService
{
    private const MAX_HORAS_DIA = 8;

    public function __construct(private RegistroHorasRepository $repo) {}

    public function registrar(int $usuarioId, int $asignacionId, string $fecha, float $horas, string $actividad): int
    {
        if (!$this->repo->asignacionPerteneceA($asignacionId, $usuarioId)) {
            throw new DomainException('Asignación no válida.');
        }

        $f = DateTimeImmutable::createFromFormat('!Y-m-d', $fecha)
            ?: throw new DomainException('Fecha inválida.');

        if ($f > new DateTimeImmutable('today')) {
            throw new DomainException('No se pueden registrar horas futuras.');
        }

        $registro = new RegistroHoras($asignacionId, $f, $horas, $actividad);

        if ($this->repo->horasDelDia($asignacionId, $f) + $horas > self::MAX_HORAS_DIA) {
            throw new DomainException('Superas ' . self::MAX_HORAS_DIA . ' horas en ese día.');
        }

        return $this->repo->guardar($registro);
    }

    public function asignaciones(int $usuarioId): array { return $this->repo->asignacionesDe($usuarioId); }

    public function listar(int $usuarioId): array { return $this->repo->listarDe($usuarioId); }
}
