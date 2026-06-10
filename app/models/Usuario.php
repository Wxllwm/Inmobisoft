<?php
// ============================================================
// CAPA DE MODELO — Entidad Usuario
// Define los campos, reglas de validación y operaciones
// sobre el "almacén" de usuarios (sesión en vez de BD).
//
// RESPONSABILIDADES DE ESTA CLASE:
//   1. Validar datos de registro y login (reglas de negocio)
//   2. Buscar usuarios en el almacén
//   3. Guardar usuarios en el almacén
//   4. Gestionar el ciclo de vida de la sesión autenticada
//      (iniciar sesión, cerrarla, obtener el usuario actual)
//
// El controlador NO debe tocar $_SESSION directamente.
// ============================================================

class Usuario
{
    // ── Propiedades de la entidad ────────────────────────────
    public int    $id       = 0;
    public string $nombre   = '';
    public string $apellido = '';
    public string $email    = '';
    public string $telefono = '';
    public string $dni      = '';
    public string $password = '';
    public string $perfil   = '';   // 'arrendador' | 'inquilino'

    // Acumula los errores de validación
    private array $errores = [];

    // ════════════════════════════════════════════════════════
    // VALIDACIONES — Registro de cuenta nueva
    // ════════════════════════════════════════════════════════
    public function validarRegistro(array $datos): bool
    {
        $this->errores = [];

        // -- NOMBRE --------------------------------------------------
        $nombre = trim($datos['nombre'] ?? '');
        if ($nombre === '') {
            $this->errores['nombre'] = 'El nombre es obligatorio.';
        } elseif (strlen($nombre) < 2 || strlen($nombre) > 50) {
            $this->errores['nombre'] = 'El nombre debe tener entre 2 y 50 caracteres.';
        } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
            $this->errores['nombre'] = 'El nombre solo puede contener letras.';
        } else {
            $this->nombre = $nombre;
        }

        // -- APELLIDO ------------------------------------------------
        $apellido = trim($datos['apellido'] ?? '');
        if ($apellido === '') {
            $this->errores['apellido'] = 'El apellido es obligatorio.';
        } elseif (strlen($apellido) < 2 || strlen($apellido) > 50) {
            $this->errores['apellido'] = 'El apellido debe tener entre 2 y 50 caracteres.';
        } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellido)) {
            $this->errores['apellido'] = 'El apellido solo puede contener letras.';
        } else {
            $this->apellido = $apellido;
        }

        // -- EMAIL ---------------------------------------------------
        $email = strtolower(trim($datos['email'] ?? ''));
        if ($email === '') {
            $this->errores['email'] = 'El correo electrónico es obligatorio.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errores['email'] = 'El formato del correo no es válido.';
        } elseif ($this->emailExiste($email)) {
            $this->errores['email'] = 'Este correo ya está registrado en el sistema.';
        } else {
            $this->email = $email;
        }

        // -- TELÉFONO ------------------------------------------------
        $telefono = trim($datos['telefono'] ?? '');
        if ($telefono === '') {
            $this->errores['telefono'] = 'El teléfono es obligatorio.';
        } elseif (!preg_match('/^9\d{8}$/', $telefono)) {
            $this->errores['telefono'] = 'Ingresa un celular peruano válido (9 dígitos, empieza con 9).';
        } else {
            $this->telefono = $telefono;
        }

        // -- DNI -----------------------------------------------------
        $dni = trim($datos['dni'] ?? '');
        if ($dni === '') {
            $this->errores['dni'] = 'El DNI es obligatorio.';
        } elseif (!preg_match('/^\d{8}$/', $dni)) {
            $this->errores['dni'] = 'El DNI debe tener exactamente 8 dígitos numéricos.';
        } elseif ($this->dniExiste($dni)) {
            $this->errores['dni'] = 'Este DNI ya está registrado en el sistema.';
        } else {
            $this->dni = $dni;
        }

        // -- PERFIL --------------------------------------------------
        $perfil = trim($datos['perfil'] ?? '');
        if (!in_array($perfil, ['arrendador', 'inquilino'])) {
            $this->errores['perfil'] = 'Debes seleccionar un perfil (arrendador o inquilino).';
        } else {
            $this->perfil = $perfil;
        }

        // -- CONTRASEÑA ----------------------------------------------
        $pw  = $datos['password']  ?? '';
        $pw2 = $datos['password2'] ?? '';

        if ($pw === '') {
            $this->errores['password'] = 'La contraseña es obligatoria.';
        } elseif (strlen($pw) < 8) {
            $this->errores['password'] = 'La contraseña debe tener al menos 8 caracteres.';
        } elseif (!preg_match('/[A-Z]/', $pw)) {
            $this->errores['password'] = 'La contraseña debe incluir al menos una letra mayúscula.';
        } elseif (!preg_match('/[0-9]/', $pw)) {
            $this->errores['password'] = 'La contraseña debe incluir al menos un número.';
        } elseif ($pw !== $pw2) {
            $this->errores['password2'] = 'Las contraseñas no coinciden.';
        } else {
            $this->password = $pw;
        }

        return empty($this->errores);
    }

    // ════════════════════════════════════════════════════════
    // VALIDACIONES — Inicio de sesión (solo formato de campos)
    // Separado de la búsqueda en almacén (ver buscarPorEmail)
    // ════════════════════════════════════════════════════════
    public function validarCredenciales(array $datos): bool
    {
        $this->errores = [];

        $email = strtolower(trim($datos['email'] ?? ''));
        $pw    = $datos['password'] ?? '';

        if ($email === '') {
            $this->errores['email'] = 'El correo es obligatorio.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errores['email'] = 'Formato de correo inválido.';
        }

        if ($pw === '') {
            $this->errores['password'] = 'La contraseña es obligatoria.';
        }

        return empty($this->errores);
    }

    // ════════════════════════════════════════════════════════
    // OPERACIONES DE DATOS — Almacén (sesión)
    // ════════════════════════════════════════════════════════

    // Guarda el usuario nuevo en el almacén
    public function guardar(): int
    {
        $id = siguienteId();
        $_SESSION['usuarios'][$id] = [
            'id'       => $id,
            'nombre'   => $this->nombre,
            'apellido' => $this->apellido,
            'email'    => $this->email,
            'telefono' => $this->telefono,
            'dni'      => $this->dni,
            'password' => $this->password,
            'perfil'   => $this->perfil,
        ];
        return $id;
    }

    // Busca un usuario por email en el almacén.
    // Devuelve el array del usuario o false si no existe.
    public static function buscarPorEmail(string $email): array|false
    {
        $email = strtolower(trim($email));
        foreach ($_SESSION['usuarios'] as $u) {
            if ($u['email'] === $email) return $u;
        }
        return false;
    }

    // ════════════════════════════════════════════════════════
    // GESTIÓN DE SESIÓN AUTENTICADA
    // El controlador delega aquí todo lo relacionado con
    // $_SESSION para no acoplarse al mecanismo de almacenamiento.
    // Si mañana cambias a JWT o BD, solo editas estas 3 funciones.
    // ════════════════════════════════════════════════════════

    // Inicia la sesión guardando el ID del usuario autenticado
    public static function iniciarSesion(array $usuarioData): void
    {
        $_SESSION['usuario_id'] = $usuarioData['id'];
    }

    // Destruye la sesión activa (logout)
    public static function cerrarSesion(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    // Devuelve los datos del usuario actualmente autenticado
    public static function obtenerActual(): array
    {
        $id = $_SESSION['usuario_id'] ?? null;
        return $id ? ($_SESSION['usuarios'][$id] ?? []) : [];
    }

    // ── Devuelve los errores de validación ───────────────────
    public function getErrores(): array
    {
        return $this->errores;
    }

    // ── Helpers privados ─────────────────────────────────────

    private function emailExiste(string $email): bool
    {
        foreach ($_SESSION['usuarios'] as $u) {
            if ($u['email'] === $email) return true;
        }
        return false;
    }

    private function dniExiste(string $dni): bool
    {
        foreach ($_SESSION['usuarios'] as $u) {
            if ($u['dni'] === $dni) return true;
        }
        return false;
    }
}
