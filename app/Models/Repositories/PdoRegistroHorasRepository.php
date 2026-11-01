<?php
declare(strict_types=1);

namespace App\Models\Repositories;

use App\Models\Entities\RegistroHoras;
use DateTimeImmutable;
use PDO;

final class PdoRegistroHorasRepository implements RegistroHorasRepository
{
    public function __construct(private PDO $db) {}

    public function guardar(RegistroHoras $r): int
    {
        $st = $this->db->prepare(
            'INSERT INTO registros_horas (asignacion_id, fecha, horas, actividad, estado)
             VALUES (?, ?, ?, ?, ?)'
        );
        $st->execute([$r->asignacionId, $r->fecha->format('Y-m-d'), $r->horas, $r->actividad, $r->estado]);
        return (int) $this->db->lastInsertId();
    }

    public function horasDelDia(int $asignacionId, DateTimeImmutable $fecha): float
    {
        $st = $this->db->prepare(
            'SELECT COALESCE(SUM(horas),0) FROM registros_horas WHERE asignacion_id = ? AND fecha = ?'
        );
        $st->execute([$asignacionId, $fecha->format('Y-m-d')]);
        return (float) $st->fetchColumn();
    }

    public function asignacionPerteneceA(int $asignacionId, int $usuarioId): bool
    {
        $st = $this->db->prepare(
            'SELECT 1 FROM asignaciones a
             JOIN estudiantes e ON e.id = a.estudiante_id
             WHERE a.id = ? AND e.usuario_id = ?'
        );
        $st->execute([$asignacionId, $usuarioId]);
        return (bool) $st->fetchColumn();
    }

    public function asignacionesDe(int $usuarioId): array
    {
        $st = $this->db->prepare(
            'SELECT a.id, em.nombre AS empresa
             FROM asignaciones a
             JOIN estudiantes e ON e.id = a.estudiante_id
             JOIN vacantes v    ON v.id = a.vacante_id
             JOIN convenios c   ON c.id = v.convenio_id
             JOIN empresas em   ON em.id = c.empresa_id
             WHERE e.usuario_id = ? AND a.estado = "activa"'
        );
        $st->execute([$usuarioId]);
        return $st->fetchAll();
    }

    public function listarDe(int $usuarioId): array
    {
        $st = $this->db->prepare(
            'SELECT rh.fecha, rh.horas, rh.actividad, rh.estado, rh.observacion
             FROM registros_horas rh
             JOIN asignaciones a ON a.id = rh.asignacion_id
             JOIN estudiantes e  ON e.id = a.estudiante_id
             WHERE e.usuario_id = ?
             ORDER BY rh.fecha DESC, rh.id DESC'
        );
        $st->execute([$usuarioId]);
        return $st->fetchAll();
    }
}
