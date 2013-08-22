<?php session_save_path("sesiones");
session_start();

function invertirFecha($fecha) {
	$dia = substr($fecha,8,2);
	$mes = substr($fecha,5,2);
	$anio = substr($fecha,0,4);
	$fechainv = $dia."/".$mes."/".$anio;
	return($fechainv);
}

function fechaParaGuardar($fecha) {
	if ($fecha == "") {
		return("0000-00-00");
	}
	$dia = substr($fecha,0,2);
	$mes = substr($fecha,3,2);
	$anio = substr($fecha,6,4);
	$fechaLista = $anio."-".$mes."-".$dia;
	return($fechaLista);
}

function getParentescos(){
	$paren[0] = array('codigo' => NULL, 'descri' =>  "Seleccione Parentesco");
	$paren[1] = array('codigo' => "CONYUGE", 'descri' =>  "CONYUGE"); 
	$paren[2] = array('codigo' => "CONCUBINO", 'descri' =>  "CONCUBINO"); 
	$paren[3] = array('codigo' => "FAMILIAR A CARGO", 'descri' =>  "FAMILIAR A CARGO"); 
	$paren[4] = array('codigo' => "HIJO", 'descri' =>  "HIJO"); 
	return($paren);
}

?>