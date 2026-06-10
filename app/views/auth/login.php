<?php
$titulo = 'Iniciar Sesión';
require __DIR__ . '/../layouts/cabecera.php';
?>

<div class="auth-pagina">

  <!-- Panel izquierdo decorativo -->
  <div class="auth-panel">
    <span class="icono">🏠</span>
    <div class="logo">INMOBI<em>SOFT</em></div>
    <p class="slogan">Sistema Integral de<br>Gestión de Alquileres</p>
    <div class="chips">
      <span>🏘 Arrendadores</span>
      <span>🔑 Inquilinos</span>
      <span>📄 Contratos</span>
      <span>💳 Pagos</span>
    </div>
  </div>

  <!-- Formulario de login -->
  <div class="auth-derecha">
    <div class="auth-tarjeta">
      <h2>Bienvenido de vuelta</h2>
      <p class="subtitulo">Ingresa tus credenciales para acceder al sistema</p>

      <!-- Mensaje de error general -->
      <?php if (!empty($errores)): ?>
        <div class="alerta alerta-err">⚠ Verifica los datos ingresados.</div>
      <?php endif; ?>

      <form method="POST" novalidate>

        <!-- Campo: Email -->
        <div class="campo">
          <label for="email">Correo electrónico</label>
          <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars($anterior['email'] ?? '') ?>"
            placeholder="correo@ejemplo.pe"
            class="<?= isset($errores['email']) ? 'error' : '' ?>"
            autocomplete="email"
          >
          <?php if (!empty($errores['email'])): ?>
            <span class="msg-error">⚠ <?= htmlspecialchars($errores['email']) ?></span>
          <?php endif; ?>
        </div>

        <!-- Campo: Contraseña -->
        <div class="campo">
          <label for="password">Contraseña</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="••••••••"
            class="<?= isset($errores['password']) ? 'error' : '' ?>"
            autocomplete="current-password"
          >
          <?php if (!empty($errores['password'])): ?>
            <span class="msg-error">⚠ <?= htmlspecialchars($errores['password']) ?></span>
          <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primario">Iniciar sesión →</button>
      </form>

      <div class="separador">¿No tienes cuenta?</div>
      <a href="?c=auth&a=registro" class="btn btn-borde">Crear cuenta nueva</a>

      <p style="margin-top:1.1rem;font-size:.75rem;color:var(--muted);text-align:center">
        Demo: <strong>arrendador@demo.pe</strong> o <strong>inquilino@demo.pe</strong><br>
        Contraseña: <strong>12345678Aa</strong>
      </p>
    </div>
  </div>

</div>
</body>
</html>
