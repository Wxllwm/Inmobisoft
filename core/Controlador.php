<?php
// ============================================================
// NÚCLEO — Clase base de Controladores
// Proporciona métodos comunes a todos los controladores.
//
// CAMBIO RESPECTO A LA VERSIÓN ANTERIOR:
//   usuarioActual() ya no accede a $_SESSION directamente.
//   Delega en Usuario::obtenerActual() para que la clase base
//   no quede acoplada a la estructura del almacén de datos.
// ============================================================

class Controlador
{
    // Carga una vista y le pasa variables
    protected function vista(string $ruta, array $datos = []): void
    {
        extract($datos); // convierte claves del array en variables
        $archivo = __DIR__ . '/../app/views/' . $ruta . '.php';
        if (!file_exists($archivo)) {
            die("Vista no encontrada: $ruta");
        }
        require $archivo;
    }

    // Redirige a otra URL
    protected function redirigir(string $url): void
    {
        header("Location: $url");
        exit;
    }

    // ¿El formulario fue enviado?
    protected function esPOST(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Lee un campo POST de forma segura (elimina espacios)
    protected function campo(string $clave, string $defecto = ''): string
    {
        return isset($_POST[$clave]) ? trim($_POST[$clave]) : $defecto;
    }

    // ¿Hay sesión iniciada?
    protected function sesionActiva(): bool
    {
        return isset($_SESSION['usuario_id']);
    }

    // Exige sesión iniciada; si no, redirige al login
    protected function requiereSesion(): void
    {
        if (!$this->sesionActiva()) {
            $this->redirigir('?c=auth&a=login');
        }
    }

    // Devuelve el usuario autenticado actualmente.
    // Delega en el Modelo para no acoplarse al almacén de datos.
    protected function usuarioActual(): array
    {
        return Usuario::obtenerActual();
    }
}
