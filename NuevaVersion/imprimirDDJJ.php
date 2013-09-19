<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');
include('lib/php/funciones.php');

$nrcuit = $_SESSION['userCuit'];
$control = $_GET['control'];
$tipo = $_GET['tipo'];

$consultaEmpresa = "select 
empresa.nrcuit,
empresa.nombre,
empresa.domile,
empresa.locali,
provincia.descripcion,
empresa.copole,
empresa.activi
from empresa, provincia 
where 
empresa.nrcuit = $nrcuit and
empresa.provin = provincia.id";

if ($sentencia = $mysqli->prepare($consultaEmpresa)) {
	$sentencia->execute();
    $sentencia->bind_result($cuit, $nombre, $domile, $locali, $provin, $copole, $activi);
	$sentencia->fetch();
	$datosEmpresa = array('cuit' => $cuit, 'nombre' => $nombre, 'domile' => $domile, 'locali' => $locali, 'provin' => $provin, 'copole' => $copole, 'activi' => $activi);
	$sentencia->close();
} 

if($tipo == "sindocu") {
	$detalleDDJJsd = "select nrcuil, remune, apo060, apo100, apo150 from ddjj where nrcuit = $nrcuit and nrctrl = $control and nrcuil != '99999999999'";
	if ($sentencia = $mysqli->prepare($detalleDDJJsd)) {
   		$sentencia->execute();
    	$sentencia->bind_result($nrcuil, $remune, $apo060, $apo100, $apo150);
		$i = 0;
		while ($sentencia->fetch()) {
			$detalle[$i] = array('nrcuil' => $nrcuil, 'nombre' => '', 'fecini' => '', 'remune' => $remune, 'apo060' => $apo060, 'apo100' => $apo100, 'apo150' => $apo150);
			$i = $i + 1;
		}
		$sentencia->close();
	}

	$totales = "select periodos.anio, periodos.descripcion, ddjj.remune, ddjj.apo060, ddjj.apo100, ddjj.apo150,  ddjj.totapo, ddjj.recarg, ddjj.totapo+ddjj.recarg as totdep
					from ddjj, periodos 
					where 
					ddjj.nrcuit = $nrcuit and 
					ddjj.nrctrl = $control and 
					ddjj.nrcuil = '99999999999' and
					ddjj.perano = periodos.anio and
					ddjj.permes = periodos.mes";
	$respuesta = $mysqli -> query($totales);
	$totalData = $respuesta -> fetch_assoc();
}

if($tipo == "condocu") {
	$consultaDDJJ = "select * from ddjjcondocu where nrcuit = $nrcuit and nrctrl = $control";
}
if($tipo == "valida") {
	$consultaDDJJ = "select * from validas, ppjj where nrcuit = $nrcuit and nrctrl = $control";
}

for($i=0; $i < sizeof($detalle); $i++){
	$nrcuil = $detalle[$i]['nrcuil'];
	$consultaEmpleado = "select * from empleados where nrcuit = $nrcuit and nrcuil = $nrcuil";
	$respuesta = $mysqli -> query($consultaEmpleado);
	$cant = $respuesta -> num_rows;
	if ($cant == 0) {
		$consultaEmpleado = "select * from empleadosdebaja where nrcuit = $nrcuit and nrcuil = $nrcuil";
		$respuesta = $mysqli -> query($consultaEmpleado);
		$cant = $respuesta -> num_rows;
		if ($cant == 0) {
			$detalle[$i]['nombre'] = "EMPLEADO ELIMINADO";
			$detalle[$i]['fecini'] = "-";
		} else {
			$empleadoData = $respuesta -> fetch_assoc();
			$detalle[$i]['nombre'] = $empleadoData['apelli']." ".$empleadoData['nombre'];
			$detalle[$i]['fecini'] = invertirFecha($empleadoData['fecing']);
		}
	} else {
		$empleadoData = $respuesta -> fetch_assoc();
		$detalle[$i]['nombre'] = $empleadoData['apelli']." ".$empleadoData['nombre'];
		$detalle[$i]['fecini'] = invertirFecha($empleadoData['fecing']);
	}
} 

//var_dump($detalle);
//var_dump($datosEmpresa);

$twig->display('imprimirDDJJ.html',array("datosEmpresa" => $datosEmpresa, "detalleDDJJ" => $detalle, "totales" => $totalData));

?>