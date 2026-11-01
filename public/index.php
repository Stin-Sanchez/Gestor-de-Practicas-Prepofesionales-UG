<?php
declare(strict_types=1);

// Front controller + composition root: aquí (y solo aquí) se arman las dependencias.

use App\Controllers\{AuthController, HorasController};
use App\Core\{Auth, Database, Router};
use App\Models\Repositories\{PdoRegistroHorasRepository, PdoUsuarioRepository};
use App\Models\Services\RegistrarHorasService;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$pdo = Database::connect();

$make = fn(string $c) => match ($c) {
    AuthController::class  => new AuthController(new PdoUsuarioRepository($pdo)),
    HorasController::class => new HorasController(
        new RegistrarHorasService(new PdoRegistroHorasRepository($pdo))
    ),
};

try {
    (new Router(require __DIR__ . '/../config/routes.php', $make))
        ->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Throwable $e) {
    error_log((string) $e);
    http_response_code(500);
    echo 'Error interno.';
}
