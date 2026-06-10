<?php
// ============================================================
// CAPA DE CONTROLADOR — Autenticación
// Responsabilidad: recibir la petición HTTP, recoger campos
// del formulario, pedirle al Modelo que valide y actúe,
// y decidir qué vista mostrar o a dónde redirigir.
//
// Lo que este controlador NO hace (delegado al Modelo):
//   - Escribir en $_SESSION (→ Usuario::iniciarSesion)
//   - Destruir la sesión   (→ Usuario::cerrarSesion)
//   - Buscar usuarios      (→ Usuario::buscarPorEmail)
// ============================================================

require_once __DIR__ . '/../../core/Controlador.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthControlador extends Controlador
{
    // ── Login ────────────────────────────────────────────────
    public function login(): void
    {
        if ($this->sesionActiva()) {
            $this->redirigir('?c=dashboard&a=inicio');
        }

        $errores  = [];
        $anterior = [];

        if ($this->esPOST()) {
            $datos = [
                'email'    => $this->campo('email'),
                'password' => $this->campo('password'),
            ];
            $anterior = $datos;

            $modelo = new Usuario();

            // Paso 1 — validar formato de campos
            if ($modelo->validarCredenciales($datos)) {

                // Paso 2 — buscar el usuario en el almacén
                $usuario = Usuario::buscarPorEmail($datos['email']);

                if ($usuario === false) {
                    // El email no existe en el sistema
                    $errores['email'] = 'No existe una cuenta con este correo.';

                } elseif ($usuario['password'] !== $datos['password']) {
                    // El email existe pero la contraseña no coincide
                    $errores['password'] = 'Contraseña incorrecta.';

                } else {
                    // Credenciales correctas: el Modelo gestiona la sesión
                    Usuario::iniciarSesion($usuario);
                    $this->redirigir('?c=dashboard&a=inicio');
                }

            } else {
                $errores = $modelo->getErrores();
            }
        }

        $this->vista('auth/login', compact('errores', 'anterior'));
    }

    // ── Registro ─────────────────────────────────────────────
    public function registro(): void
    {
        if ($this->sesionActiva()) {
            $this->redirigir('?c=dashboard&a=inicio');
        }

        $errores  = [];
        $anterior = [];
        $exito    = false;

        if ($this->esPOST()) {
            $datos = [
                'nombre'    => $this->campo('nombre'),
                'apellido'  => $this->campo('apellido'),
                'email'     => $this->campo('email'),
                'telefono'  => $this->campo('telefono'),
                'dni'       => $this->campo('dni'),
                'perfil'    => $this->campo('perfil'),
                'password'  => $this->campo('password'),
                'password2' => $this->campo('password2'),
            ];
            $anterior = $datos;

            $modelo = new Usuario();

            if ($modelo->validarRegistro($datos)) {
                $modelo->guardar();
                $exito    = true;
                $anterior = [];
            } else {
                $errores = $modelo->getErrores();
            }
        }

        $this->vista('auth/registro', compact('errores', 'anterior', 'exito'));
    }

    // ── Cerrar sesión ────────────────────────────────────────
    // El Modelo destruye la sesión; el controlador solo redirige.
    public function salir(): void
    {
        Usuario::cerrarSesion();
        $this->redirigir('?c=auth&a=login');
    }
}
