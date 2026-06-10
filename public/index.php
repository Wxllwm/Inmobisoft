<?php
// ============================================================
// CAPA DE PRESENTACIÓN — Punto de entrada único
// Toda petición HTTP pasa por aquí
// ============================================================
session_start();

require_once __DIR__ . '/../config/datos.php';
require_once __DIR__ . '/../core/Controlador.php';
require_once __DIR__ . '/../core/Enrutador.php';

inicializarDatos();   // Carga usuarios demo en sesión
Enrutador::despachar(); // Lee URL y llama al controlador
