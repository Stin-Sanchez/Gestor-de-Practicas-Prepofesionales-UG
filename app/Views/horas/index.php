<?php use App\Core\Auth; ?>
<h1>Mis horas</h1>

<?php if ($asignaciones === []): ?>
  <p>Aún no tienes una práctica asignada.</p>
<?php else: ?>
<form method="post" action="/horas">
  <input type="hidden" name="csrf" value="<?= e(Auth::csrfToken()) ?>">
  <label>Empresa
    <select name="asignacion_id" required>
      <?php foreach ($asignaciones as $a): ?>
        <option value="<?= e($a['id']) ?>"><?= e($a['empresa']) ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Fecha <input type="date" name="fecha" max="<?= date('Y-m-d') ?>" required></label>
  <label>Horas <input type="number" name="horas" min="0.5" max="8" step="0.5" required></label>
  <label>Actividad <textarea name="actividad" maxlength="500" required></textarea></label>
  <button>Registrar</button>
</form>
<?php endif; ?>

<table>
  <thead><tr><th>Fecha</th><th>Horas</th><th>Actividad</th><th>Estado</th></tr></thead>
  <tbody>
  <?php foreach ($registros as $r): ?>
    <tr>
      <td><?= e($r['fecha']) ?></td>
      <td><?= e($r['horas']) ?></td>
      <td><?= e($r['actividad']) ?></td>
      <td><?= e($r['estado']) ?><?= $r['observacion'] ? ' — ' . e($r['observacion']) : '' ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
