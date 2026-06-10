<?php
// ============================================================
// CAPA DE CONTROLADOR — Dashboard
// Página principal tras iniciar sesión
// ============================================================

require_once __DIR__ . '/../../core/Controlador.php';

class DashboardControlador extends Controlador
{
    public function inicio(): void
    {
        $this->requiereSesion(); // protege la ruta
        $usuario = $this->usuarioActual();
        $this->vista('dashboard/inicio', compact('usuario'));
    }
}
