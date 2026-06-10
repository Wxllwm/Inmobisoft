<?php
// ============================================================
// CAPA DE DATOS — Almacén en Sesión (simula base de datos)
// En producción esto sería PDO + MySQL
// ============================================================

function inicializarDatos(): void
{
    // Solo inicializa una vez por sesión
    if (isset($_SESSION['_iniciado'])) return;

    // Usuarios de prueba precargados
    $_SESSION['usuarios'] = [
        1 => [
            'id'       => 1,
            'nombre'   => 'Carlos',
            'apellido' => 'Mendoza',
            'email'    => 'arrendador@demo.pe',
            'telefono' => '987654321',
            'dni'      => '12345678',
            'password' => '12345678Aa',
            'perfil'   => 'arrendador',
        ],
        2 => [
            'id'       => 2,
            'nombre'   => 'Lucía',
            'apellido' => 'Torres',
            'email'    => 'inquilino@demo.pe',
            'telefono' => '912345678',
            'dni'      => '87654321',
            'password' => '12345678Aa',
            'perfil'   => 'inquilino',
        ],
    ];

    $_SESSION['_siguiente_id'] = 3;
    $_SESSION['_iniciado']     = true;
}

function siguienteId(): int
{
    return $_SESSION['_siguiente_id']++;
}
