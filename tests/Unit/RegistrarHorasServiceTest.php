<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Entities\RegistroHoras;
use App\Models\Repositories\RegistroHorasRepository;
use App\Models\Services\RegistrarHorasService;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

final class RegistrarHorasServiceTest extends TestCase
{
    private function servicio(bool $esDuenio = true, float $yaRegistrado = 0.0): RegistrarHorasService
    {
        $repo = new class($esDuenio, $yaRegistrado) implements RegistroHorasRepository {
            public array $guardados = [];
            public function __construct(private bool $duenio, private float $dia) {}
            public function guardar(RegistroHoras $r): int { $this->guardados[] = $r; return 1; }
            public function horasDelDia(int $a, DateTimeImmutable $f): float { return $this->dia; }
            public function asignacionPerteneceA(int $a, int $u): bool { return $this->duenio; }
            public function asignacionesDe(int $u): array { return []; }
            public function listarDe(int $u): array { return []; }
        };
        return new RegistrarHorasService($repo);
    }

    public function test_registra_horas_validas(): void
    {
        $this->assertSame(1, $this->servicio()->registrar(1, 1, '2026-10-01', 4, 'Soporte técnico'));
    }

    public function test_rechaza_asignacion_ajena(): void
    {
        $this->expectException(DomainException::class);
        $this->servicio(esDuenio: false)->registrar(1, 99, '2026-10-01', 4, 'x');
    }

    public function test_rechaza_mas_de_8_horas_en_el_dia(): void
    {
        $this->expectException(DomainException::class);
        $this->servicio(yaRegistrado: 6)->registrar(1, 1, '2026-10-01', 3, 'x');
    }

    public function test_rechaza_fecha_futura(): void
    {
        $this->expectException(DomainException::class);
        $this->servicio()->registrar(1, 1, '2999-01-01', 2, 'x');
    }
}
