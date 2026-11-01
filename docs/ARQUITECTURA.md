# Arquitectura

MVC con el Modelo subdividido para que ninguna clase mezcle reglas de negocio con SQL.

## Flujo de una petición

```
Navegador → public/index.php → Router (¿sesión? ¿rol?)
  → Controller → Service → Repository → MySQL
  → Controller → View → HTML
```

`public/index.php` es el único lugar donde se crean objetos con `new` y se conectan entre sí (composition root).

## Qué puede y qué no puede cada capa

| Capa | Puede | No puede |
|---|---|---|
| **Controller** | leer `$_POST`/sesión, llamar al Service, elegir vista | SQL, reglas de negocio |
| **Service / Entity** | aplicar reglas y validar | conocer `$_POST`, `$_SESSION` o HTML |
| **Repository** | ejecutar SQL con consultas preparadas | decidir reglas de negocio |
| **View** | mostrar datos con `e()` | llamar a la BD o a un Repository |

Los Services dependen de la **interfaz** del repositorio, no de PDO: por eso se prueban sin base de datos
(ver `tests/Unit/RegistrarHorasServiceTest.php`).

## Seguridad básica (obligatoria en todos los módulos)

- Consultas siempre preparadas (`?`), nunca concatenar variables en el SQL.
- Toda salida en vistas pasa por `e()`.
- Todo formulario `POST` lleva `<input type="hidden" name="csrf" value="<?= e(Auth::csrfToken()) ?>">` y el controlador llama `$this->exigirCsrf()`.
- Los roles permitidos se declaran en `config/routes.php`.
- Si un dato pertenece a un usuario (ej. una asignación), el Service verifica que sea suyo antes de operar.
