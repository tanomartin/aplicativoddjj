<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$nrcuit = $_SESSION['userCuit'];


var_dump($_POST);

$twig->display('confirmarPago.html',array("userName" => $_SESSION['userNombre']), "tipoPago" => $_POST('tipoPago'));
?>