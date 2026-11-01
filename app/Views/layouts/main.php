<?php
use App\Core\Auth;

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestión de Prácticas</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
  <header>
    <strong>Gestión de Prácticas Preprofesionales</strong>
    <?php if (Auth::check()): ?>
      <form method="post" action="/logout" class="inline">
        <input type="hidden" name="csrf" value="<?= e(Auth::csrfToken()) ?>">
        <span><?= e($_SESSION['nombre']) ?> (<?= e(Auth::rol()) ?>)</span>
        <button>Salir</button>
      </form>
    <?php endif; ?>
  </header>
  <main>
    <?php if ($flash): ?>
      <p class="flash <?= e($flash[0]) ?>"><?= e($flash[1]) ?></p>
    <?php endif; ?>
    <?= $contenido ?>
  </main>
</body>
</html>
