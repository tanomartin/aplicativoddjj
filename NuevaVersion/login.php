<?php session_save_path("sesiones");
session_start();

// Directorio Raíz de la app
// Es utilizado en templateEngine.inc.php
$root = '';

// Incluyo el template engine
include('includes/templateEngine.inc.php');

// Cargo la plantilla
$twig->display('login.html');
?>