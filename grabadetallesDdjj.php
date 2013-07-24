<?php session_save_path("sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: caducaSes.php");
include("lib/conexion.php");
?>
<html>
<head>
<title>.: U.S.I.M.R.A. :.</title>
</head>

<body bgcolor="#E4C192" link="#000000">
  <p align="center"><img border="0" src="img/top.jpg" width="700" height="120"></p>

<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">

<p>
<?php
$_SESSION['nrcuit'] = $nrcuit;
$_SESSION['aut'] = 'pepepascual';
$ctrlh =  date("YmdHis");
?>

<form method="post" action="grabatotalesDdjj.php?filas=<? echo $filas;?>&ctrlh=<? echo $ctrlh;?>">
    
<?php
$datos = array_values($HTTP_POST_VARS);
$permes = $datos [1];
print ("<input type=hidden name=a1 size=20 value=".$permes.">");
$perano = $datos [0];
print ("<input type=hidden name=a2 size=20 value=".$perano.">");

$sqlPeriodoDescrip = "select * from periodos where anio = $perano and mes = $permes";
$resPeriodoDescrip = mysql_db_query("uv0472_aplicativo",$sqlPeriodoDescrip,$db);
$rowPeriodoDescrip = mysql_fetch_array($resPeriodoDescrip);

$nfilas = ($filas*4) + 2;
print ("<font face=Verdana size=2><b>Período: ".$rowPeriodoDescrip['descripcion']." ".$perano."</b></font>");
print ("<br>");
print ("<br>");
print ("<br>");

//Encabezado de la tabla
print ("<table border=0 width=700>");
print ("  <tr>");
print ("    <td width=96 bgcolor=#D6943F><p align=center><font face=Verdana size=1><b>CUIL</b></font></td>");
print ("    <td width=232 bgcolor=#D6943F><p align=center><font face=Verdana size=1><b>NOMBRE</b></font></td>");
print ("    <td width=89 bgcolor=#D6943F><p align=center><font face=Verdana size=1><b>FECHA DE INGRESO</b></font></td>");
print ("    <td width=100 bgcolor=#D6943F><p align=center><font face=Verdana size=1><b>REMUNERACION</b></font></td>");
print ("    <td width=57 bgcolor=#D6943F><p align=center><font face=Verdana size=1><b>Art.32 0,6%</b></font></td>");
print ("    <td width=57 bgcolor=#D6943F><p align=center><font face=Verdana size=1><b>Art.32 bis 1%</b></font></td>");
print ("    <td width=57 bgcolor=#D6943F><p align=center><font face=Verdana size=1><b>Art.32 bis 1,5%</b></font></td>");
print ("  </tr>");
//print ("</table>");

$totapo = 0.00;
$tot060 = 0.00;
$tot100 = 0.00;
$tot150 = 0.00;
$totrem = 0.00;
$por060 = 0.00;
$por100 = 0.00;
$por150 = 0.00;

//verifico que aportes tengo que calcular y cargo variables.
$sqlRemu = "select * from extraordinarios where anio = $perano and mes = $permes";
$resRemu = mysql_db_query("uv0472_aplicativo",$sqlRemu,$db);
$nfiRemu = mysql_num_rows($resRemu);
if ($nfiRemu == 1) {
	$rowRemu=mysql_fetch_array($resRemu);
	if ($rowRemu['retiene060'] == 1) {
		$por060 = 0.006;
	}
	if ($rowRemu['retiene100'] == 1) {
		$por100 = 0.010;
	} 
	if ($rowRemu['retiene150'] == 1) {
		$por150 = 0.015;
	}
} else {
	$por060 = 0.006;
	$por100 = 0.010;
	$por150 = 0.015;
}

$i=2;
while($i < $nfilas) {
$cuil [$i]= $datos[$i];
print ("<input type=hidden name=Z".$i." size=20 value=".$cuil [$i].">");

$nombre = $datos [$i+1];
print ("<input type=hidden name=M".$i." size=20 value=\"".$nombre."\">");
$fecha = $datos [$i+2];
print ("<input type=hidden name=N".$i." size=20 value=".$fecha.">");

$remune [$i+3] = $datos[$i+3];
$rem = $remune [$i+3];
if ($nfiRemu == 1 && $rowRemu['tipo'] == 1) {
	$rem = $rem*$rowRemu['valor'];
}
print ("<input type=hidden name=Y".$i." size=20 value=".$rem.">");

$apo060 = $rem * $por060 ;
$apo100 = $rem * $por100;
$apo150 = $rem * $por150;

$nrcuil = $cuil [$i];


$sql = "INSERT INTO ddjj (nrcuit,nrcuil,permes,perano,remune,apo060,apo100,apo150,nrctrl)
VALUES ('$nrcuit','$nrcuil','$permes','$perano','$rem','$apo060','$apo100','$apo150','$ctrlh')";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);


//TABLA
$sql = "SELECT * from ddjj where
nrcuit = '$nrcuit' and
nrcuil = '$nrcuil' and
permes = '$permes' and
perano = '$perano' and
nrctrl = '$ctrlh'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$row=mysql_fetch_array($result);



print ("<input type=hidden name=W".$i." size=20 value=".$row['apo060'].">");
print ("<input type=hidden name=L".$i." size=20 value=".$row['apo100'].">");
print ("<input type=hidden name=K".$i." size=20 value=".$row['apo150'].">");

$tot060 = $tot060 + $row['apo060'];
$tot100 = $tot100 + $row['apo100'];
$tot150 = $tot150 + $row['apo150'];
$totrem = $totrem + $row['remune'];

$totapo = $totapo + $row['apo060'] + $row['apo100'] + $row['apo150'];

print ("<table border=0 width=700>");
print ("  <tr>");

$cuill01 = substr($nrcuil,0,2);
$cuill02 = substr($nrcuil,2,8);
$cuill03 = substr($nrcuil,10,1);

print ("    <td width=96><p align=center><font face=Verdana size=1>".$cuill01."-".$cuill02."-".$cuill03."</font></td>");
print ("    <td width=232><font face=Verdana size=1>".$nombre."</font></td>");
$fec01 = substr($fecha,0,4);
$fec02 = substr($fecha,5,2);
$fec03 = substr($fecha,8,2);
print ("    <td width=89><p align=left><font face=Verdana size=1>".$fec03."/".$fec02."/".$fec01."</font></td>");
print ("    <td width=100><p align=right><font face=Verdana size=1>$".number_format($row['remune'], 2, ",", "")."</font></td>");
print ("    <td width=57><p align=right><font face=Verdana size=1>$".number_format($row['apo060'], 2, ",", "")."</font></td>");
print ("    <td width=57><p align=right><font face=Verdana size=1>$".number_format($row['apo100'], 2, ",", "")."</font></td>");
print ("    <td width=57><p align=right><font face=Verdana size=1>$".number_format($row['apo150'], 2, ",", "")."</font></td>");
print ("  </tr>");
print ("</table>");





$i = $i+4;
}



//Encabezado de la tabla
print ("<table border=0 width=700>");
print ("  <tr>");
//print ("    <td width=96 bgcolor=#D6943F><p align=center><font face=Verdana size=1><b> </b></font></td>");
//print ("    <td width=232 bgcolor=#D6943F><p align=center><font face=Verdana size=1><b> </b></font></td>");
print ("    <td width=417 bgcolor=#D6943F><p align=center><font face=Verdana size=1><b>TOTALES</b></font></td>");
print ("    <td width=100 bgcolor=#D6943F><p align=right><font face=Verdana size=1><b>$".number_format($totrem, 2, ",", "")."</b></font></td>");
print ("    <td width=57 bgcolor=#D6943F><p align=right><font face=Verdana size=1><b>$".number_format($tot060, 2, ",", "")."</b></font></td>");
print ("    <td width=57 bgcolor=#D6943F><p align=right><font face=Verdana size=1><b>$".number_format($tot100, 2, ",", "")."</b></font></td>");
print ("    <td width=57 bgcolor=#D6943F><p align=right><font face=Verdana size=1><b>$".number_format($tot150, 2, ",", "")."</b></font></td>");
print ("  </tr>");
print ("</table>");


print ("<table border=0 width=700>");
print ("  <tr>");
print ("    <td width=417 bgcolor=#DEAA63><p align=center><font face=Verdana size=1><b>TOTAL APORTES Y CONTRIBUCIONES</b></font></td>");
print ("    <td width=283 bgcolor=#DEAA63><p align=right><font face=Verdana size=1><b>$".number_format($totapo, 2, ",", "")."</b></font></td>");
print ("  </tr>");
print ("</table>");
print ("<br>");





print ("<input type=hidden name=H2 size=20 value=".$totapo.">");
print ("<input type=hidden name=G2 size=20 value=".$tot060.">");
print ("<input type=hidden name=O2 size=20 value=".$tot100.">");
print ("<input type=hidden name=P2 size=20 value=".$tot150.">");
print ("<input type=hidden name=U2 size=20 value=".$totrem.">");






print ("Recargos  :  ");
print ("<input type=text name=T1 size=10 value=0.00><br>
<input type=text name=S1 size=15 value=Observaciones>");
print ("<br>");

//NOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO

$mfilas = $datos [$nfilas];
$o = 0;
$u = 1;
if ($mfilas < 10000) { //control rustico... por si las mosacas
	while($o < $mfilas) {
		$incuil = $datos[$nfilas+$u];
		$motivo = $datos[$nfilas+$u+1];
		$sql2 = "INSERT INTO inactivos (nrcuit,nrcuil,permes,perano,motivo,nrctrl)
		VALUES ('$nrcuit','$incuil','$permes','$perano','$motivo','$ctrlh')";
		$resu = mysql_db_query("uv0472_aplicativo",$sql2,$db);
		$o = $o+1;
		$u = $u+2;
	}
}

mysql_close();


?>

<input type="submit" value="Procesar Declaración Jurada" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37">
</form>

<div align="center">
<a href="carganuevaDdjj.php" ><font color="#CD8C34" face="Verdana" size="2"><b>Volver</b></font></a> 


</p>


</p>

</body>

</html>