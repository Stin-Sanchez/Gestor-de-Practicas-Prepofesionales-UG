<?php use App\Core\Auth; ?>
<h1>Iniciar sesión</h1>
<form method="post" action="/login">
  <input type="hidden" name="csrf" value="<?= e(Auth::csrfToken()) ?>">
  <label>Correo <input type="email" name="email" required autofocus></label>
  <label>Contraseña <input type="password" name="password" required></label>
  <button>Entrar</button>
</form>
