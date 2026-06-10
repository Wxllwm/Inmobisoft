<?php
// ============================================================
// NÚCLEO — Enrutador
// Lee ?c=controlador&a=accion y ejecuta el método correcto
// ============================================================

class Enrutador
{
    public static function despachar(): void
    {
        // Leer parámetros de la URL (solo letras, seguro)
        $c = preg_replace('/[^a-zA-Z]/', '', $_GET['c'] ?? 'auth');
        $a = preg_replace('/[^a-zA-Z]/', '', $_GET['a'] ?? 'login');

        // Construir nombre de clase: "auth" → "AuthControlador"
        $clase   = ucfirst(strtolower($c)) . 'Controlador';
        $archivo = __DIR__ . '/../app/controllers/' . $clase . '.php';

        if (!file_exists($archivo)) {
            http_response_code(404);
            die("Controlador no encontrado: $clase");
        }

        require_once $archivo;
        $objeto = new $clase();

        if (!method_exists($objeto, $a)) {
            http_response_code(404);
            die("Acción no encontrada: $a en $clase");
        }

        $objeto->$a(); // Ejecuta la acción
    }
}
