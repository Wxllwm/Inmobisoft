<?php

// Cambio de prueba Jenkins
$titulo = 'Dashboard';
require __DIR__ . '/../layouts/cabecera.php';
$ini = strtoupper(substr($usuario['nombre'], 0, 1) . substr($usuario['apellido'], 0, 1));
?>

<!-- Barra de demo -->
<div class="barra-demo">
  🧪 <strong>MAQUETA</strong> — Demo:
  <strong>arrendador@demo.pe</strong> o <strong>inquilino@demo.pe</strong> /
  clave: <strong>12345678Aa</strong>
</div>

<!-- Navbar -->
<nav class="navbar">
  <a href="?c=dashboard&a=inicio" class="logo">INMOBI<em>SOFT</em></a>
  <div class="nav-usuario">
    <div class="nav-avatar"><?= htmlspecialchars($ini) ?></div>
    <span class="nav-nombre"><?= htmlspecialchars($usuario['nombre']) ?></span>
    <span class="nav-perfil"><?= htmlspecialchars($usuario['perfil']) ?></span>
    <a href="?c=auth&a=salir" class="btn-salir">⏻ Cerrar sesión</a>
  </div>
</nav>

<!-- Contenido principal -->
<div class="pagina">
  <h1>¡Hola, <?= htmlspecialchars($usuario['nombre']) ?>! 👋</h1>
  <p class="bienvenida">Has iniciado sesión correctamente en INMOBISOFT.</p>

  <!-- Datos del usuario registrado -->
  <div class="tarjeta-info">
    <h3>📋 Datos de tu cuenta</h3>
    <div class="grid-datos">
      <div class="fila-dato">
        <div class="etiqueta">Nombre completo</div>
        <div class="valor"><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?></div>
      </div>
      <div class="fila-dato">
        <div class="etiqueta">DNI</div>
        <div class="valor"><?= htmlspecialchars($usuario['dni']) ?></div>
      </div>
      <div class="fila-dato">
        <div class="etiqueta">Correo electrónico</div>
        <div class="valor"><?= htmlspecialchars($usuario['email']) ?></div>
      </div>
      <div class="fila-dato">
        <div class="etiqueta">Teléfono</div>
        <div class="valor"><?= htmlspecialchars($usuario['telefono']) ?></div>
      </div>
      <div class="fila-dato">
        <div class="etiqueta">Perfil</div>
        <div class="valor">
          <span class="chip-perfil chip-<?= $usuario['perfil'] ?>">
            <?= $usuario['perfil'] === 'arrendador' ? '🏘 Arrendador' : '🔑 Inquilino' ?>
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Info del sistema -->
  <div class="tarjeta-azul">
    <h3>🏠 Sobre INMOBISOFT</h3>
    <p>
      Sistema de gestión de alquileres inmobiliarios que digitaliza el proceso de arrendamiento.
      Permite a los arrendadores publicar propiedades y a los inquilinos buscar y solicitar alquileres.
    </p>
  </div>
</div>

</body>
</html>
