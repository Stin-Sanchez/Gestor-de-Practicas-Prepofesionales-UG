# Gestión de Prácticas Preprofesionales (G06)

PHP 8.3 + MySQL 8.4, arquitectura MVC, todo en Docker. Documentación del equipo en [`docs/`](docs/).

## Requisitos

| Necesitas | Detalle |
|---|---|
| **Docker** con **Compose v2** | Comprueba con `docker --version` y `docker compose version`. En Windows: Docker Desktop (backend WSL 2) o Docker dentro de WSL. En Linux/Mac: Docker Engine / Docker Desktop. |
| **Git** | Para clonar y trabajar por ramas. |
| Puertos libres | `8081` (app) y `3307` (MySQL, solo para tu cliente de BD). |
| ~1 GB de disco | Imágenes de PHP y MySQL. |

**No necesitas** instalar PHP, Composer, Apache ni MySQL: todo corre dentro de los contenedores.
`make` es opcional (en Windows normalmente no está); abajo van los comandos de Docker directos.

## Levantar en local

```bash
git clone <url-del-repo> && cd gestion-practicas
cp .env.example .env          # Windows PowerShell: Copy-Item .env.example .env
docker compose up -d --build  # la primera vez tarda unos minutos
```

Abrir **http://127.0.0.1:8081** — usuario de prueba: `estudiante@ug.edu.ec` / `estudiante123`.

El `schema.sql` y los datos de prueba de `seeds.sql` se cargan solos la primera vez que se crea la BD.

| Acción | Comando |
|---|---|
| Ver logs | `docker compose logs -f app` |
| Correr los tests | `docker compose exec app sh -c "composer install && vendor/bin/phpunit"` |
| Apagar | `docker compose down` |
| Reiniciar la BD desde cero (borra datos) | `docker compose down -v && docker compose up -d --build` |
| Entrar a MySQL | `docker compose exec db mysql -uroot -p practicas` |

Si el puerto `8081` o `3307` está ocupado, cambia el lado izquierdo en `compose.yaml` / `compose.override.yaml`.

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
| `database/` | `schema.sql`, `seeds.sql` (datos de prueba) y `migrations/` (cambios posteriores). |
| `docs/` | Arquitectura y base de datos. |

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
Caddy y los backups se configuran manualmente en el server. Usar contraseñas reales en el `.env` y **no** cargar los datos de prueba de `seeds.sql`.

## Crear un usuario admin

Ejecutar desde WSL, Git Bash o Linux (en PowerShell las comillas se rompen):

```bash
docker compose exec app php -r 'require "vendor/autoload.php"; App\Core\Database::connect()->prepare("INSERT INTO usuarios (nombre,email,password_hash,rol) VALUES (?,?,?,\"admin\")")->execute(["Admin","admin@ug.edu.ec",password_hash("CAMBIAR",PASSWORD_DEFAULT)]);'
```
