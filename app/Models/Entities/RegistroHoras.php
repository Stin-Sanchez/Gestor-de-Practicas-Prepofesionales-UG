<?php
declare(strict_types=1);

namespace App\Models\Entities;

use DateTimeImmutable;
use DomainException;

final class RegistroHoras
{
    public function __construct(
        public readonly int $asignacionId,
        public readonly DateTimeImmutable $fecha,
        public readonly float $horas,
        public readonly string $actividad,
        public readonly string $estado = 'pendiente',
        public readonly ?int $id = null,
    ) {
        if ($horas <= 0 || $horas > 8) {
            throw new DomainException('Las horas deben estar entre 0 y 8.');
        }
        if (trim($actividad) === '') {
            throw new DomainException('Describe la actividad realizada.');
        }
    }
}
