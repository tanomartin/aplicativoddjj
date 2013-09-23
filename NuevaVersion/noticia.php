<?php session_save_path("sesiones");
	session_start();
	$root = '';
	
	// Incluyo el template engine
	include('includes/templateEngine.inc.php');
	include('lib/php/conexion.php');
	$id = $_GET['id'];
	$consulta = "SELECT * FROM noticias WHERE id=$id";
	$respuesta = $mysqli -> query($consulta);
	$noticia = $respuesta -> fetch_assoc();
	
	// Cargo la plantilla
	$twig->display('noticia.html',array("noticia" => $noticia));


?>