<?php session_save_path("sesiones");
session_start();

include('lib/php/conexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');

$limiteAnio = date("Y") - 5;
$consultaPeridos = "SELECT periodos.anio, periodos.mes, periodos.descripcion, extraordinarios.relacionmes
FROM periodos
LEFT JOIN extraordinarios ON periodos.anio = extraordinarios.anio and periodos.mes = extraordinarios.mes
WHERE periodos.anio > $limiteAnio
ORDER BY periodos.anio DESC, periodos.mes DESC;";
	
$extras = array();
$periodos = array();
$anios = array();
if ($sentencia = $mysqli->prepare($consultaPeridos)) {
   	$sentencia->execute();
   	$sentencia->bind_result($anio, $mes, $descipcion, $relacionmes);
	while ($sentencia->fetch()) {
		$anios[$anio] = $anio;
		if ($mes > 12) {
			$index = $relacionmes.$mes;
			$extras[$anio][$index] = array('mes' => $mes, 'descipcion' => $descipcion, 'relacionmes' => $relacionmes);
		} else {
			$periodos[$anio][$mes] = array('mes' => $mes, 'descipcion' => $descipcion);
		}
   	}
}

foreach ($anios as $anio) {
	if (isset($extras[$anio])) {
		krsort($extras[$anio]);
	}
}

$twig->display('periodos.html', array("anios"=>$anios, "periodos" => $periodos, "extras" => $extras));

?>