<?php 
include('lib/php/conexion.php');
$ramas='<option title ="Seleccione un valor" value="">Rama - Seleccione un valor</option>';
$consulta = "SELECT * FROM rama";
if ($sentencia = $mysqli->prepare($consulta)) {
	$sentencia->execute();
	$sentencia->bind_result($codigo, $descri);
	while ($sentencia->fetch()) {
		$ramas.="<option title ='$descri' value='$codigo'>".$descri."</option>";
	}
}
//echo json_encode($provincia);
echo $ramas;