# Base de datos (MySQL 8.4)

Esquema completo en `database/schema.sql`.

## Relaciones principales

```
empresas ─< convenios ─< vacantes ─< asignaciones >─ estudiantes >─ usuarios
                                          │
                  ┌───────────────┬───────┴────────┬──────────────┐
            registros_horas   evaluaciones     documentos     validaciones
```
`asignaciones` también referencia a `usuarios` como tutor académico y tutor empresarial. `notificaciones` cuelga de `usuarios`.

## Tablas por módulo

| Módulo | Tablas |
|---|---|
| 1 Seguridad | `usuarios` (rol: admin, coordinador, tutor_academico, tutor_empresarial, estudiante) |
| 2 Convenios | `empresas`, `convenios`, `vacantes` |
| 3 Asignación | `estudiantes`, `asignaciones` |
| 4 Horas | `registros_horas` (estado: pendiente, aprobado, rechazado) |
| 5 Evaluaciones | `evaluaciones`, `documentos` |
| 6 Reportes | `validaciones`, `notificaciones` |

## Cambiar el esquema

`schema.sql` solo se ejecuta al **crear** el volumen de la BD, así que editarlo no actualiza a quien ya tiene datos.

1. Crear `database/migrations/NNN_descripcion.sql` (numeración correlativa, ej. `002_add_certificados.sql`).
2. Aplicarla: `docker compose exec -T db mysql -uroot -p<DB_ROOT_PASS> practicas < database/migrations/002_add_certificados.sql`.
3. Avisar al grupo para que la apliquen o reinicien su BD (`down -v`).

## Datos de prueba

`database/seeds.sql`: un estudiante (`estudiante@ug.edu.ec` / `estudiante123`) con una práctica en TechCorp y 3 registros de horas. Solo para desarrollo.
