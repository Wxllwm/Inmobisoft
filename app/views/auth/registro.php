<?php
$titulo = 'Registrar Cuenta';
require __DIR__ . '/../layouts/cabecera.php';
?>

<div class="auth-pagina">

  <!-- Panel izquierdo decorativo -->
  <div class="auth-panel">
    <span class="icono">✍️</span>
    <div class="logo">INMOBI<em>SOFT</em></div>
    <p class="slogan">Únete y gestiona tus<br>propiedades o alquileres</p>
    <div class="chips">
      <span>✅ Registro gratuito</span>
      <span>🔒 Datos seguros</span>
      <span>📱 100% digital</span>
    </div>
  </div>

  <!-- Formulario de registro -->
  <div class="auth-derecha">
    <div class="auth-tarjeta">
      <h2>Crear cuenta nueva</h2>
      <p class="subtitulo">Todos los campos son obligatorios</p>

      <!-- Mensaje de éxito -->
      <?php if ($exito): ?>
        <div class="alerta alerta-ok">
          ✅ ¡Cuenta creada exitosamente!
          <a href="?c=auth&a=login" style="color:var(--verde);font-weight:600;margin-left:.3rem">
            Iniciar sesión →
          </a>
        </div>
      <?php endif; ?>

      <?php if (!$exito): ?>
      <form method="POST" novalidate>

        <!-- Nombre y Apellido -->
        <div class="fila-2">
          <div class="campo">
            <label for="nombre">Nombre</label>
            <input
              type="text"
              id="nombre"
              name="nombre"
              value="<?= htmlspecialchars($anterior['nombre'] ?? '') ?>"
              placeholder="Ej: María"
              class="<?= isset($errores['nombre']) ? 'error' : '' ?>"
            >
            <?php if (!empty($errores['nombre'])): ?>
              <span class="msg-error">⚠ <?= htmlspecialchars($errores['nombre']) ?></span>
            <?php endif; ?>
          </div>

          <div class="campo">
            <label for="apellido">Apellido</label>
            <input
              type="text"
              id="apellido"
              name="apellido"
              value="<?= htmlspecialchars($anterior['apellido'] ?? '') ?>"
              placeholder="Ej: García"
              class="<?= isset($errores['apellido']) ? 'error' : '' ?>"
            >
            <?php if (!empty($errores['apellido'])): ?>
              <span class="msg-error">⚠ <?= htmlspecialchars($errores['apellido']) ?></span>
            <?php endif; ?>
          </div>
        </div>

        <!-- Email -->
        <div class="campo">
          <label for="email">Correo electrónico</label>
          <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars($anterior['email'] ?? '') ?>"
            placeholder="tucorreo@ejemplo.pe"
            class="<?= isset($errores['email']) ? 'error' : '' ?>"
            autocomplete="email"
          >
          <?php if (!empty($errores['email'])): ?>
            <span class="msg-error">⚠ <?= htmlspecialchars($errores['email']) ?></span>
          <?php endif; ?>
        </div>

        <!-- Teléfono y DNI -->
        <div class="fila-2">
          <div class="campo">
            <label for="telefono">Teléfono celular</label>
            <input
              type="tel"
              id="telefono"
              name="telefono"
              value="<?= htmlspecialchars($anterior['telefono'] ?? '') ?>"
              placeholder="9XXXXXXXX"
              maxlength="9"
              class="<?= isset($errores['telefono']) ? 'error' : '' ?>"
            >
            <?php if (!empty($errores['telefono'])): ?>
              <span class="msg-error">⚠ <?= htmlspecialchars($errores['telefono']) ?></span>
            <?php endif; ?>
          </div>

          <div class="campo">
            <label for="dni">DNI</label>
            <input
              type="text"
              id="dni"
              name="dni"
              value="<?= htmlspecialchars($anterior['dni'] ?? '') ?>"
              placeholder="12345678"
              maxlength="8"
              class="<?= isset($errores['dni']) ? 'error' : '' ?>"
            >
            <?php if (!empty($errores['dni'])): ?>
              <span class="msg-error">⚠ <?= htmlspecialchars($errores['dni']) ?></span>
            <?php endif; ?>
          </div>
        </div>

        <!-- Perfil -->
        <div class="campo">
          <label>Selecciona tu perfil</label>
          <div class="perfil-grupo">
            <div class="perfil-opcion">
              <input
                type="radio" id="arrendador" name="perfil" value="arrendador"
                <?= (($anterior['perfil'] ?? '') === 'arrendador') ? 'checked' : '' ?>
              >
              <label for="arrendador">
                <span class="icono-perfil">🏘</span>
                Arrendador
                <small style="color:var(--muted);font-size:.7rem;font-weight:400">Ofrezco propiedades</small>
              </label>
            </div>
            <div class="perfil-opcion">
              <input
                type="radio" id="inquilino" name="perfil" value="inquilino"
                <?= (($anterior['perfil'] ?? '') === 'inquilino') ? 'checked' : '' ?>
              >
              <label for="inquilino">
                <span class="icono-perfil">🔑</span>
                Inquilino
                <small style="color:var(--muted);font-size:.7rem;font-weight:400">Busco alquilar</small>
              </label>
            </div>
          </div>
          <?php if (!empty($errores['perfil'])): ?>
            <span class="msg-error">⚠ <?= htmlspecialchars($errores['perfil']) ?></span>
          <?php endif; ?>
        </div>

        <!-- Contraseñas -->
        <div class="fila-2">
          <div class="campo">
            <label for="password">Contraseña</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="••••••••"
              class="<?= isset($errores['password']) ? 'error' : '' ?>"
              autocomplete="new-password"
            >
            <span class="pista">Mín. 8 caracteres, 1 mayúscula y 1 número</span>
            <?php if (!empty($errores['password'])): ?>
              <span class="msg-error">⚠ <?= htmlspecialchars($errores['password']) ?></span>
            <?php endif; ?>
          </div>

          <div class="campo">
            <label for="password2">Confirmar contraseña</label>
            <input
              type="password"
              id="password2"
              name="password2"
              placeholder="••••••••"
              class="<?= isset($errores['password2']) ? 'error' : '' ?>"
              autocomplete="new-password"
            >
            <?php if (!empty($errores['password2'])): ?>
              <span class="msg-error">⚠ <?= htmlspecialchars($errores['password2']) ?></span>
            <?php endif; ?>
          </div>
        </div>

        <button type="submit" class="btn btn-primario">Registrarme →</button>
      </form>
      <?php endif; ?>

      <div class="separador">¿Ya tienes cuenta?</div>
      <a href="?c=auth&a=login" class="btn btn-borde">Iniciar sesión</a>
    </div>
  </div>

</div>
</body>
</html>
