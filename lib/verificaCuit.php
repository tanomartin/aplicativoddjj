<?php
function validacuit($cuit)
{	
	$coeficiente[0]=5;
	$coeficiente[1]=4;
	$coeficiente[2]=3;
	$coeficiente[3]=2;
	$coeficiente[4]=7;
	$coeficiente[5]=6;
	$coeficiente[6]=5;
	$coeficiente[7]=4;
	$coeficiente[8]=3;
	$coeficiente[9]=2;
	$sumador = 0;
	$verificador = substr($cuit, 10, 1); //tomo el digito verificador
	for ($i=0; $i <=9; $i=$i+1) { 
		$sumador = $sumador + (substr($cuit, $i, 1)) * $coeficiente[$i];//separo cada digito y lo multiplico por el coeficiente
	}
	$resultado = $sumador % 11;
	if ($resultado == 1){ 
		return 0;
	} else {
		if ($resultado == 0){
			$nrofinal = $resultado;
		}else{					 
			$nrofinal = 11 - $resultado;  //saco el digito verificador
		}
		$veri_nro = intval($verificador);
		if ($veri_nro <> $nrofinal){
			return 0;
		}
		else{ 
			return 1;
		}
	}		 
}
?>