<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Auth, Controller};
use App\Models\Services\RegistrarHorasService;
use DomainException;

final class HorasController extends Controller
{
    public function __construct(private RegistrarHorasService $service) {}

    public function index(): void
    {
        $this->render('horas/index', [
            'registros'    => $this->service->listar(Auth::id()),
            'asignaciones' => $this->service->asignaciones(Auth::id()),
        ]);
    }

    public function crear(): void
    {
        $this->exigirCsrf();

        try {
            $this->service->registrar(
                Auth::id(),
                (int) ($_POST['asignacion_id'] ?? 0),
                (string) ($_POST['fecha'] ?? ''),
                (float) ($_POST['horas'] ?? 0),
                (string) ($_POST['actividad'] ?? ''),
            );
            $this->flash('ok', 'Horas registradas, pendientes de aprobación.');
        } catch (DomainException $e) {
            $this->flash('error', $e->getMessage());
        }

        $this->redirect('/horas');
    }
}
