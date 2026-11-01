<?php
declare(strict_types=1);

use App\Controllers\{AuthController, HorasController};

// 'MÉTODO /ruta' => [Controlador, método, roles permitidos]  (roles vacío = pública)
return [
    'GET /'          => [AuthController::class,  'inicio',  []],
    'GET /login'     => [AuthController::class,  'form',    []],
    'POST /login'    => [AuthController::class,  'login',   []],
    'POST /logout'   => [AuthController::class,  'logout',  []],

    'GET /horas'     => [HorasController::class, 'index',   ['estudiante']],
    'POST /horas'    => [HorasController::class, 'crear',   ['estudiante']],
];
