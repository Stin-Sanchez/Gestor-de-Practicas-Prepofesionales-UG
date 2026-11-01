<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Auth, Controller};
use App\Models\Repositories\PdoUsuarioRepository;

final class AuthController extends Controller
{
    public function __construct(private PdoUsuarioRepository $usuarios) {}

    public function inicio(): void
    {
        $this->redirect(Auth::check() ? '/horas' : '/login');
    }

    public function form(): void
    {
        $this->render('auth/login');
    }

    public function login(): void
    {
        $this->exigirCsrf();

        $u = $this->usuarios->buscarActivoPorEmail(trim($_POST['email'] ?? ''));

        if ($u === null || !password_verify($_POST['password'] ?? '', $u['password_hash'])) {
            $this->flash('error', 'Credenciales incorrectas.');
            $this->redirect('/login');
        }

        Auth::login((int) $u['id'], $u['rol'], $u['nombre']);
        $this->redirect('/');
    }

    public function logout(): void
    {
        $this->exigirCsrf();
        Auth::logout();
        $this->redirect('/login');
    }
}
