<?php 
include('lib/php/conexion.php');
$actividades='<option title ="Seleccione un valor" value="">Actividad - Seleccione un valor</option>';
$consulta = "SELECT * FROM actividad";
if ($sentencia = $mysqli->prepare($consulta)) {
	$sentencia->execute();
	$sentencia->bind_result($id, $descripcion);
	while ($sentencia->fetch()) {
		$actividades.="<option title ='$descripcion' value='$id'>".$descripcion."</option>";
	}
}
//echo json_encode($provincia);
echo $actividades;