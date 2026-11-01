<?php
declare(strict_types=1);

/** Escapa texto para HTML. Usar en TODA salida de datos en las vistas. */
function e(mixed $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}
