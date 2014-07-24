<?php session_save_path("sesiones");
session_start();

include('lib/php/verificaSesion.php');
include('lib/php/verificaConexion.php');
$root = '';
// Incluyo el template engine
include('includes/templateEngine.inc.php');
include('lib/php/funciones.php');

$nrcuit = $_SESSION['userCuit'];
if (isset($_GET['control']) && isset($_GET['tipo'])) {
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
		$detalleDDJJ = "select nrcuil, remune, apo060, apo100, apo150 from ddjj where nrcuit = $nrcuit and nrctrl = $control and nrcuil != '99999999999'";
		if ($sentencia = $mysqli->prepare($detalleDDJJ)) {
			$sentencia->execute();
			$sentencia->bind_result($nrcuil, $remune, $apo060, $apo100, $apo150);
			$i = 0;
			$totRemu = 0;
			while ($sentencia->fetch()) {
				$detalle[$i] = array('nrcuil' => $nrcuil, 'nombre' => '', 'fecini' => '', 'remune' => $remune, 'apo060' => $apo060, 'apo100' => $apo100, 'apo150' => $apo150);
				$i = $i + 1;
				$totRemu = $totRemu + $remune;
			}
			$sentencia->close();
		}
	
		$totales = "select periodos.anio, periodos.mes, periodos.descripcion, ddjj.remune, ddjj.apo060, ddjj.apo100, ddjj.apo150,  ddjj.totapo, ddjj.recarg, ddjj.totapo+ddjj.recarg as totdep
						from ddjj, periodos 
						where 
						ddjj.nrcuit = $nrcuit and 
						ddjj.nrctrl = $control and 
						ddjj.nrcuil = '99999999999' and
						ddjj.perano = periodos.anio and
						ddjj.permes = periodos.mes";
		$respuesta = $mysqli -> query($totales);
		$totalrow = $respuesta -> fetch_assoc();
		$totalData = array('mes' => $totalrow['mes'], 'descripcion' => $totalrow['descripcion'], 'anio' => $totalrow['anio'], 'remune' => number_format($totRemu,2,',','.'), 'apo060' => $totalrow['apo060'], 'apo100' => $totalrow['apo100'], 'apo150' => $totalrow['apo150'], 'totapo' => $totalrow['totapo'], 'recarg' => $totalrow['recarg'], 'totdep' => $totalrow['totdep']);
	}
	
	if($tipo == "condocu") {
		$detalleDDJJ = "select nrcuil, remune, apo060, apo100, apo150 from ddjjcondocu where nrcuit = $nrcuit and nrctrl = $control and nrcuil != '99999999999'";
		if ($sentencia = $mysqli->prepare($detalleDDJJ)) {
			$sentencia->execute();
			$sentencia->bind_result($nrcuil, $remune, $apo060, $apo100, $apo150);
			$i = 0;
			$totRemu = 0;
			while ($sentencia->fetch()) {
				$detalle[$i] = array('nrcuil' => $nrcuil, 'nombre' => '', 'fecini' => '', 'remune' => $remune, 'apo060' => $apo060, 'apo100' => $apo100, 'apo150' => $apo150);
				$totRemu = $totRemu + $remune;
				$i = $i + 1;
			}
			$sentencia->close();
		}
	
		$totales = "select periodos.anio, periodos.mes, periodos.descripcion, ddjjcondocu.remune, ddjjcondocu.apo060, ddjjcondocu.apo100, ddjjcondocu.apo150,  ddjjcondocu.totapo, ddjjcondocu.recarg, ddjjcondocu.totapo+ddjjcondocu.recarg as totdep
						from ddjjcondocu, periodos 
						where 
						ddjjcondocu.nrcuit = $nrcuit and 
						ddjjcondocu.nrctrl = $control and 
						ddjjcondocu.nrcuil = '99999999999' and
						ddjjcondocu.perano = periodos.anio and
						ddjjcondocu.permes = periodos.mes";
		$respuesta = $mysqli -> query($totales);
		$totalrow = $respuesta -> fetch_assoc();
		$totalData = array('mes' => $totalrow['mes'], 'descripcion' => $totalrow['descripcion'], 'anio' => $totalrow['anio'], 'remune' => number_format($totRemu,2,',','.'), 'apo060' => $totalrow['apo060'], 'apo100' => $totalrow['apo100'], 'apo150' => $totalrow['apo150'], 'totapo' => $totalrow['totapo'], 'recarg' => $totalrow['recarg'], 'totdep' => $totalrow['totdep']);
	}
	
	if($tipo == "valida") {
		$detalleDDJJ = "select nrcuil, remune, apo060, apo100, apo150 from ppjj where nrcuit = $nrcuit and nrctrl = $control and nrcuil != '99999999999'";
		if ($sentencia = $mysqli->prepare($detalleDDJJ)) {
			$sentencia->execute();
			$sentencia->bind_result($nrcuil, $remune, $apo060, $apo100, $apo150);
			$i = 0;
			$totRemu = 0;
			while ($sentencia->fetch()) {
				$detalle[$i] = array('nrcuil' => $nrcuil, 'nombre' => '', 'fecini' => '', 'remune' => $remune, 'apo060' => $apo060, 'apo100' => $apo100, 'apo150' => $apo150);
				$totRemu = $totRemu + $remune;
				$i = $i + 1;
			}
			$sentencia->close();
		}
		
		$totales = "select periodos.anio, periodos.mes, periodos.descripcion, validas.remune, validas.apo060, validas.apo100, validas.apo150,  validas.totapo, validas.recarg, validas.totapo+validas.recarg as totdep
						from validas, periodos 
						where 
						validas.nrcuit = $nrcuit and 
						validas.nrctrl = $control and 
						validas.nrcuil = '99999999999' and
						validas.perano = periodos.anio and
						validas.permes = periodos.mes";
		$respuesta = $mysqli -> query($totales);
		$totalrow = $respuesta -> fetch_assoc();
		$totalData = array('mes' => $totalrow['mes'], 'descripcion' => $totalrow['descripcion'], 'anio' => $totalrow['anio'], 'remune' => number_format($totRemu,2,',','.'), 'apo060' => $totalrow['apo060'], 'apo100' => $totalrow['apo100'], 'apo150' => $totalrow['apo150'], 'totapo' => $totalrow['totapo'], 'recarg' => $totalrow['recarg'], 'totdep' => $totalrow['totdep']);
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
} else {
	$twig->display('accesoDirecto.html',array("userName" => $_SESSION['userNombre']));
}

?>