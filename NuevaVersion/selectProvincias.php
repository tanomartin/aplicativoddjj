<?php 
include('lib/php/conexion.php');
$provincias='<option title ="Seleccione un valor" value="">Provincia - Seleccione un valor</option>';
$consulta = "SELECT * FROM provincia";
if ($sentencia = $mysqli->prepare($consulta)) {
	$sentencia->execute();
	$sentencia->bind_result($codigo, $descri);
	while ($sentencia->fetch()) {
		$provincias.="<option title ='$descri' value='$codigo'>".$descri."</option>";
	}
}
//echo json_encode($provincia);
echo $provincias;