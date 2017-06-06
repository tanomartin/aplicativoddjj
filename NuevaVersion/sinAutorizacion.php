<?php session_save_path("sesiones");
session_start();

$root = '';

// Incluyo el template engine
include('includes/templateEngine.inc.php');

// Cargo la plantilla
$twig->display('sinAutorizacion.html',array("noleidos" => $_SESSION['noleidos'], "userName" => $_SESSION['userNombre']));

?>