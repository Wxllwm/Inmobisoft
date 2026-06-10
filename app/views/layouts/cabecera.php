<?php $titulo = $titulo ?? 'INMOBISOFT'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($titulo) ?> — INMOBISOFT</title>
<style>
/* ── Reset y base ─────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
  font-family: 'Segoe UI', system-ui, sans-serif;
  background: #f0f4ff;
  color: #1e2a3b;
  min-height: 100vh;
  font-size: 15px;
  line-height: 1.5;
}
a { text-decoration: none; color: inherit; }

/* ── Variables de color ───────────────────────── */
:root {
  --azul:    #1a56db;
  --azul2:   #1447c0;
  --marino:  #0f2744;
  --verde:   #0e9f6e;
  --rojo:    #e02424;
  --ambar:   #d97706;
  --borde:   #dce4f0;
  --fondo:   #f0f4ff;
  --tarjeta: #ffffff;
  --muted:   #6b7a94;
  --r:       10px;
  --sombra:  0 2px 16px rgba(15,39,68,.09);
  --sombra2: 0 8px 32px rgba(15,39,68,.15);
}

/* ── Auth layout ──────────────────────────────── */
.auth-pagina { display: flex; min-height: 100vh; }

.auth-panel {
  flex: 0 0 42%;
  background: var(--marino);
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  padding: 3rem; position: relative; overflow: hidden;
}
.auth-panel::before {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse at 25% 75%, rgba(26,86,219,.4) 0%, transparent 60%),
    radial-gradient(ellipse at 80% 20%, rgba(14,159,110,.22) 0%, transparent 55%);
}
.auth-panel > * { position: relative; z-index: 1; }
.auth-panel .logo {
  font-size: 2.4rem; font-weight: 800;
  color: #fff; letter-spacing: -1px;
}
.auth-panel .logo em { color: #60a5fa; font-style: normal; }
.auth-panel .slogan {
  color: rgba(255,255,255,.68); font-size: .95rem;
  margin-top: .5rem; text-align: center; line-height: 1.6;
}
.auth-panel .icono { font-size: 4rem; margin-bottom: 1.5rem; }
.auth-panel .chips {
  display: flex; flex-wrap: wrap; gap: .4rem;
  justify-content: center; margin-top: 1.8rem;
}
.auth-panel .chips span {
  background: rgba(255,255,255,.12);
  border: 1px solid rgba(255,255,255,.2);
  border-radius: 20px; padding: .26rem .75rem;
  font-size: .73rem; color: rgba(255,255,255,.82);
}

.auth-derecha {
  flex: 1;
  display: flex; align-items: center; justify-content: center;
  padding: 2rem;
}
.auth-tarjeta {
  width: 100%; max-width: 450px;
  background: var(--tarjeta);
  border-radius: var(--r);
  box-shadow: var(--sombra2);
  padding: 2.4rem;
  border: 1px solid var(--borde);
}
.auth-tarjeta h2 { color: var(--marino); margin-bottom: .25rem; font-size: 1.4rem; }
.auth-tarjeta .subtitulo { color: var(--muted); font-size: .85rem; margin-bottom: 1.6rem; }

/* ── Formulario ───────────────────────────────── */
.campo { margin-bottom: .95rem; }
.campo label {
  display: block; font-size: .79rem; font-weight: 600;
  color: var(--marino); margin-bottom: .3rem; letter-spacing: .2px;
}
.campo input, .campo select {
  width: 100%; padding: .6rem .9rem;
  border: 1.5px solid var(--borde); border-radius: 8px;
  font-size: .93rem; font-family: inherit; color: #1e2a3b;
  background: #fff; transition: border-color .18s, box-shadow .18s;
}
.campo input:focus, .campo select:focus {
  outline: none;
  border-color: var(--azul);
  box-shadow: 0 0 0 3px rgba(26,86,219,.13);
}
.campo input.error, .campo select.error { border-color: var(--rojo) !important; }
.campo .msg-error {
  color: var(--rojo); font-size: .77rem;
  margin-top: .25rem; display: block;
}
.campo .pista { color: var(--muted); font-size: .74rem; margin-top: .22rem; }

.fila-2 { display: grid; grid-template-columns: 1fr 1fr; gap: .92rem; }

/* Perfil radio buttons */
.perfil-grupo { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-bottom: .92rem; }
.perfil-opcion input[type="radio"] { display: none; }
.perfil-opcion label {
  display: flex; flex-direction: column; align-items: center; gap: .28rem;
  padding: .68rem; border: 1.5px solid var(--borde); border-radius: 8px;
  cursor: pointer; font-size: .82rem; font-weight: 500;
  transition: all .18s; text-align: center;
}
.perfil-opcion label .icono-perfil { font-size: 1.4rem; }
.perfil-opcion input:checked + label {
  border-color: var(--azul);
  background: rgba(26,86,219,.07); color: var(--azul);
}
.perfil-opcion label:hover { border-color: var(--azul); }

/* ── Botones ──────────────────────────────────── */
.btn {
  display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
  padding: .62rem 1.2rem; border: none; border-radius: 8px;
  font-size: .9rem; font-weight: 600; cursor: pointer;
  font-family: inherit; transition: all .18s;
  text-decoration: none; white-space: nowrap;
}
.btn-primario {
  background: var(--azul); color: #fff; width: 100%; margin-top: .3rem;
}
.btn-primario:hover {
  background: var(--azul2); transform: translateY(-1px);
  box-shadow: 0 4px 14px rgba(26,86,219,.38);
}
.btn-borde {
  background: transparent; border: 1.5px solid var(--azul);
  color: var(--azul); width: 100%; margin-top: .45rem;
}
.btn-borde:hover { background: var(--azul); color: #fff; }

/* ── Alertas ──────────────────────────────────── */
.alerta {
  padding: .8rem 1rem; border-radius: 8px;
  font-size: .86rem; margin-bottom: 1.1rem;
  display: flex; gap: .45rem; align-items: flex-start;
}
.alerta-ok  { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.alerta-err { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

.separador { text-align: center; color: var(--muted); font-size: .8rem; margin: .9rem 0; position: relative; }
.separador::before, .separador::after {
  content: ''; display: inline-block; width: 35%;
  height: 1px; background: var(--borde); vertical-align: middle; margin: 0 .42rem;
}

/* ── Barra de demo ────────────────────────────── */
.barra-demo {
  background: #1a3a60; color: rgba(255,255,255,.8);
  font-size: .77rem; padding: .48rem 1.4rem; text-align: center;
}
.barra-demo strong { color: #60a5fa; }

/* ── Navbar ───────────────────────────────────── */
.navbar {
  background: var(--marino); padding: .78rem 1.8rem;
  display: flex; align-items: center; justify-content: space-between;
  position: sticky; top: 0; z-index: 100;
  box-shadow: 0 2px 12px rgba(0,0,0,.18);
}
.navbar .logo { font-size: 1.18rem; color: #fff; font-weight: 800; letter-spacing: -.5px; }
.navbar .logo em { color: #60a5fa; font-style: normal; }
.nav-usuario { display: flex; align-items: center; gap: .7rem; }
.nav-avatar {
  width: 30px; height: 30px; border-radius: 50%;
  background: var(--azul); color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: .74rem; font-weight: 700;
}
.nav-nombre { color: rgba(255,255,255,.85); font-size: .82rem; }
.nav-perfil {
  background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
  border-radius: 20px; padding: .18rem .6rem;
  font-size: .68rem; color: #fff; font-weight: 500;
}
.btn-salir {
  background: rgba(255,255,255,.14); border: 1.5px solid rgba(255,255,255,.32);
  border-radius: 7px; color: #fff; font-size: .78rem; font-weight: 600;
  padding: .3rem .75rem; cursor: pointer; font-family: inherit;
  transition: background .18s; text-decoration: none;
  display: inline-flex; align-items: center; gap: .3rem;
}
.btn-salir:hover { background: rgba(220,30,30,.5); }

/* ── Dashboard ────────────────────────────────── */
.pagina { max-width: 860px; margin: 0 auto; padding: 2rem 1.4rem; }
.pagina h1 { color: var(--marino); margin-bottom: .4rem; font-size: 1.7rem; }
.pagina .bienvenida { color: var(--muted); margin-bottom: 1.8rem; font-size: .9rem; }

.tarjeta-info {
  background: var(--tarjeta); border: 1px solid var(--borde);
  border-radius: var(--r); box-shadow: var(--sombra);
  padding: 1.4rem 1.6rem; margin-bottom: 1rem;
}
.tarjeta-info h3 { font-size: .9rem; color: var(--muted); margin-bottom: .8rem; text-transform: uppercase; letter-spacing: .4px; font-weight: 600; }

.grid-datos { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem 2rem; }
.fila-dato .etiqueta { font-size: .77rem; color: var(--muted); }
.fila-dato .valor { font-size: .92rem; font-weight: 600; color: var(--marino); }

.chip-perfil {
  display: inline-flex; align-items: center; gap: .35rem;
  padding: .32rem .85rem; border-radius: 20px;
  font-size: .82rem; font-weight: 600; margin-top: .3rem;
}
.chip-arrendador { background: #dbeafe; color: #1e40af; }
.chip-inquilino  { background: #d1fae5; color: #065f46; }

.tarjeta-azul {
  background: var(--marino); border-radius: var(--r);
  padding: 1.4rem 1.6rem; color: #fff;
}
.tarjeta-azul h3 { color: #60a5fa; margin-bottom: .6rem; font-size: .88rem; }
.tarjeta-azul p  { font-size: .84rem; opacity: .78; line-height: 1.7; }

/* ── Responsive ───────────────────────────────── */
@media (max-width: 768px) {
  .auth-panel { display: none; }
  .fila-2, .perfil-grupo, .grid-datos { grid-template-columns: 1fr; }
  .navbar { padding: .78rem 1rem; }
  .pagina { padding: 1.2rem .9rem; }
}
</style>
</head>
<body>
