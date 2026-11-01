<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function render(string $vista, array $datos = []): void
    {
        extract($datos, EXTR_SKIP);
        ob_start();
        require __DIR__ . "/../Views/$vista.php";
        $contenido = ob_get_clean();
        require __DIR__ . '/../Views/layouts/main.php';
    }

    protected function redirect(string $url): never
    {
        header("Location: $url");
        exit;
    }

    protected function flash(string $tipo, string $msg): void
    {
        $_SESSION['flash'] = [$tipo, $msg];
    }

    /** Aborta con 403 si el token CSRF del formulario no coincide. */
    protected function exigirCsrf(): void
    {
        if (!Auth::csrfValido($_POST['csrf'] ?? null)) {
            http_response_code(403);
            exit('Token inválido, recarga la página.');
        }
    }
}
