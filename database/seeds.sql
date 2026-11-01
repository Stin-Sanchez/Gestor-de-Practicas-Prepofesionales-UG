-- Datos de PRUEBA (solo desarrollo). Corren una vez, al crear el volumen de la BD.
-- Para aplicarlos a una BD ya creada:
--   docker compose exec -T db mysql -uroot -p<DB_ROOT_PASS> practicas < database/seeds.sql
-- Estudiante de prueba: estudiante@ug.edu.ec / estudiante123
SET NAMES utf8mb4;

INSERT IGNORE INTO usuarios (nombre, email, password_hash, rol) VALUES
  ('Estudiante Prueba', 'estudiante@ug.edu.ec',
   '$2y$10$01WNZ8mvtZtJ.c572lCgX.HTOf0qLsBEA1snJJiZ5XJoKiLNhQkMG', 'estudiante');

INSERT IGNORE INTO empresas (nombre, ruc, direccion, contacto_nombre, contacto_email)
VALUES ('TechCorp S.A.', '0991234567001', 'Av. Principal 123, Guayaquil', 'María Pérez', 'rrhh@techcorp.test');

INSERT INTO convenios (empresa_id, fecha_inicio, fecha_fin, estado)
SELECT id, '2026-01-01', '2027-01-01', 'vigente' FROM empresas WHERE ruc = '0991234567001'
  AND NOT EXISTS (SELECT 1 FROM convenios c WHERE c.empresa_id = empresas.id);

INSERT INTO vacantes (convenio_id, titulo, descripcion, cupos)
SELECT c.id, 'Soporte técnico', 'Mesa de ayuda y mantenimiento de equipos', 3
FROM convenios c JOIN empresas e ON e.id = c.empresa_id WHERE e.ruc = '0991234567001'
  AND NOT EXISTS (SELECT 1 FROM vacantes v WHERE v.convenio_id = c.id);

INSERT IGNORE INTO estudiantes (usuario_id, cedula, carrera, nivel)
SELECT id, '0912345678', 'Ingeniería en Software', 7 FROM usuarios WHERE email = 'estudiante@ug.edu.ec';

INSERT INTO asignaciones (estudiante_id, vacante_id)
SELECT es.id, v.id
FROM estudiantes es
JOIN usuarios u ON u.id = es.usuario_id AND u.email = 'estudiante@ug.edu.ec'
JOIN vacantes v ON v.titulo = 'Soporte técnico'
WHERE NOT EXISTS (SELECT 1 FROM asignaciones a WHERE a.estudiante_id = es.id);

-- Algunas horas de ejemplo
INSERT INTO registros_horas (asignacion_id, fecha, horas, actividad, estado, observacion)
SELECT a.id, '2026-10-26', 4, 'Instalación de software en laboratorio', 'aprobado', NULL FROM asignaciones a
  WHERE NOT EXISTS (SELECT 1 FROM registros_horas)
UNION ALL
SELECT a.id, '2026-10-27', 6, 'Configuración de red y cableado', 'pendiente', NULL FROM asignaciones a
  WHERE NOT EXISTS (SELECT 1 FROM registros_horas)
UNION ALL
SELECT a.id, '2026-10-28', 3, 'Soporte a usuarios', 'rechazado', 'Falta detallar actividades' FROM asignaciones a
  WHERE NOT EXISTS (SELECT 1 FROM registros_horas);
