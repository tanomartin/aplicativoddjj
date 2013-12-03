<?php session_save_path("sesiones");
session_start();
// Constantes para conexi�n con la base de datos
define("host", 'localhost');
define("user", 'ospimrem_charly');
define("pass", 'arce4651');
define("base", 'ospimrem_newaplicativo');

// Bandera de status de conexion
$errorDbConexion = false;

// Verifico constantes para conexi�n
if(defined('host') && defined('user') && defined('pass') && defined('base'))
{
	// Conexi�n con la base de datos
	$mysqli = new mysqli(host, user, pass, base);
	
	// Verifico si hay error al conectar
	if (mysqli_connect_error()) {
	    $errorDbConexion = true;
	}
	else{
		// Evitando problemas con acentos
		$mysqli -> query('SET NAMES "utf8"');
	}
}
?>