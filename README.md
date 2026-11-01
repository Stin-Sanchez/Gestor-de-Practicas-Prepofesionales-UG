# Gestión de Prácticas Preprofesionales (G06)

PHP 8.3 + MariaDB, arquitectura MVC, en Docker detrás de Caddy.

## Levantar en local

```bash
cp .env.example .env     # cambia las contraseñas
make up                  # docker compose up -d --build
```
Abrir http://127.0.0.1:8081

## Estructura

| Carpeta | Contenido |
|---|---|
| `app/Controllers` | Reciben la petición, llaman al Service, devuelven vista. Sin SQL. |
| `app/Models/Entities` | Objetos con sus reglas. |
| `app/Models/Services` | Reglas de negocio. Dependen de la **interfaz** del repositorio. |
| `app/Models/Repositories` | Único lugar con SQL (PDO). |
| `app/Views` | HTML + PHP de presentación. Siempre `e()` al imprimir datos. |
| `app/Core` | Router, Controller base, Auth (sesión + CSRF), Database. |
| `config/` | `routes.php` (rutas y roles), `php.ini`, `php.dev.ini` y `vhost.conf` (Apache), montados por Docker. |
| `public/index.php` | Front controller y composition root (aquí se arma cada dependencia). |
| `database/` | `schema.sql` (primer arranque) y `migrations/` (cambios posteriores). |

## Agregar un módulo (receta)

1. Entidad en `Models/Entities`, interfaz + `Pdo…Repository` en `Models/Repositories`, servicio en `Models/Services`.
2. Controlador en `Controllers`, vistas en `Views/<modulo>/`.
3. Registrar rutas en `config/routes.php` y el `new …` en el `match` de `public/index.php`.
4. Un test en `tests/Unit` con repositorio falso (ver `RegistrarHorasServiceTest`).

Módulo de referencia: **horas** (`HorasController`, `RegistrarHorasService`, `PdoRegistroHorasRepository`).

## Reglas del equipo

- Una rama por módulo: `feature/horas`, `feature/convenios`… y pull request.
- Cambios de BD: archivo numerado en `database/migrations/` (`002_add_x.sql`); no editar `schema.sql` ya desplegado.
- Nunca subir `.env`.

## Producción (server)

```bash
docker compose -f compose.yaml up -d --build
```
Caddy y los backups se configuran manualmente en el server.

## Crear el primer usuario admin

```bash
docker compose exec app php -r 'require "vendor/autoload.php"; App\Core\Database::connect()->prepare("INSERT INTO usuarios (nombre,email,password_hash,rol) VALUES (?,?,?,\"admin\")")->execute(["Admin","admin@ug.edu.ec",password_hash("CAMBIAR",PASSWORD_DEFAULT)]);'
```
