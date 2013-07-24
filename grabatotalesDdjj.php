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
<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
<body topmargin="20" leftmargin="0">

<table border="0" width="100%" height="100%">
  <tr>
    <td width="100%" valign="top" align="left"><img border="0" src="img/membreteboleta.jpg" width="650" height="150">
      <table border="0" width="650">
        <tr>
          <td width="100%">



<p align="left"> 
<?php
print ("<form method=POST action=generacionBoleta.php?nrctrlh=".$ctrlh.">");
$sql = "select * from empresa where nrcuit = '$nrcuit'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$nfilas = mysql_num_rows($result);



$row=mysql_fetch_array($result);
$provincia = array ("PROVINCIA", "CAPITAL FEDERAL", "BUENOS AIRES", "MENDOZA", "NEUQUEN", "SALTA", "ENTRE RIOS", "MISIONES", "CHACO", "SANTA FE", "CORDOBA", "SAN JUAN", "RIO NEGRO", "CORRIENTES", "SANTA CRUZ", "CHUBUT", "FORMOSA", "LA PAMPA", "SANTIAGO DEL ESTERO", "JUJUY", "TUCUMAN", "TIERRA DEL FUEGO", "SAN LUIS", "LA RIOJA", "CATAMARCA");
$pro = $row["provin"];

print ("  <table border=0 width=650>");
print ("    <tr>");
print ("      <td width=100% align=left>");
print ("        <p style=word-spacing: 0; margin-top: 0; margin-bottom: 0>&nbsp;</p>");
print ("        <table border=0 width=650>");
print ("          <tr>");
print ("            <td width=25%>");
print ("              <p style=word-spacing: 0; margin-top: 0; margin-bottom: 0><font face=Verdana size=2><b>Nombre:</b></font></td>");
print ("            <td width=75% colspan=3>");
print ("              <p style=word-spacing: 0; margin-top: 0; margin-bottom: 0><font face=Verdana size=2>".$row["nombre"]."</font></td>");
print ("          </tr>");
print ("          <tr>");
print ("            <td width=25%>");
print ("              <p style=word-spacing: 0; margin-top: 0; margin-bottom: 0><font face=Verdana size=2><b>Domicilio:</b></font></td>");
print ("            <td width=75% colspan=3>");
print ("              <p style=word-spacing: 0; margin-top: 0; margin-bottom: 0><font face=Verdana size=2>".$row["domile"]."</font></td>");
print ("          </tr>");
print ("          <tr>");
print ("            <td width=25%><font face=Verdana size=2><b>Localidad:</b></font></td>");
print ("            <td width=25%><font face=Verdana size=2>".$row["locali"]."</font></td>");
print ("            <td width=25%><font face=Verdana size=2><b>Código Postal:</b></font></td>");
print ("            <td width=25%><font face=Verdana size=2>".$row["copole"]."</font></td>");
print ("          </tr>");
print ("          <tr>");
print ("            <td width=25%><font face=Verdana size=2><b>Provincia:</b></font></td>");
print ("            <td width=25%><font face=Verdana size=2>".$provincia [$pro]."</font></td>");
print ("            <td width=25%><font face=Verdana size=2><b>Actividad:</b></font></td>");
print ("            <td width=25%><font face=Verdana size=2>".$row["activi"]."</font></td>");
print ("          </tr>");
print ("          <tr>");
print ("            <td width=25%>");
print ("              <p style=word-spacing: 0; margin-top: 0; margin-bottom: 0><font face=Verdana size=2><b>CUIT:</b></font></td>");
print ("            <td width=75% colspan=3>");

$cuitt01 = substr($row['nrcuit'],0,2);
$cuitt02 = substr($row['nrcuit'],2,8);
$cuitt03 = substr($row['nrcuit'],10,1);

print ("              <p style=word-spacing: 0; margin-top: 0; margin-bottom: 0><font face=Verdana size=2>".$cuitt01."-".$cuitt02."-".$cuitt03."</font></td>");
print ("          </tr>");
print ("        </table>");

			  
//  print ("Número de CUIT: ".$nrcuit);
//print ("<br>");
// print ("Número de Registros: ".$filas);
print ("<br>");
print ("<br>");
print ("<br>");
$datos = array_values($HTTP_POST_VARS);

$permes = $datos [0];
$perano = $datos [1];

$sqlPeriodoDescrip = "select * from periodos where anio = $perano and mes = $permes";
$resPeriodoDescrip = mysql_db_query("uv0472_aplicativo",$sqlPeriodoDescrip,$db);
$rowPeriodoDescrip = mysql_fetch_array($resPeriodoDescrip);

$nfilas = ($filas*7) + 2;
print ("<font face=Verdana size=2><b>Período: ".$rowPeriodoDescrip['descripcion']." ".$perano."</b></font>");
print ("<br>");
print ("<br>");
print ("<br>");



//Encabezado de la tabla
print ("<table border=1 width=650 bordercolor=#000000 bordercolorlight=#000000 bordercolordark=#000000 cellspacing=0 cellpadding=0>");
print ("  <tr>");
print ("    <td width=96 bgcolor=#999999><p align=center><font face=Verdana size=1><b>CUIL</b></font></td>");
print ("    <td width=182 bgcolor=#999999><p align=center><font face=Verdana size=1><b>NOMBRE</b></font></td>");
print ("    <td width=89 bgcolor=#999999><p align=center><font face=Verdana size=1><b>FECHA DE INGRESO</b></font></td>");
print ("    <td width=100 bgcolor=#999999><p align=center><font face=Verdana size=1><b>REMUNERACION</b></font></td>");
print ("    <td width=57 bgcolor=#999999><p align=center><font face=Verdana size=1><b>Art.32  0,6%</b></font></td>");
print ("    <td width=57 bgcolor=#999999><p align=center><font face=Verdana size=1><b>Art.32 bis  1%</b></font></td>");
print ("    <td width=57 bgcolor=#999999><p align=center><font face=Verdana size=1><b>Art.32 bis  1,5%</b></font></td>");
print ("  </tr>");


$i=2;
while($i < $nfilas) {
$cuil [$i]= $datos[$i];
$nom [$i+1] = $datos[$i+1];
$fechain [$i+2] = $datos[$i+2];
$remune [$i+3] = $datos[$i+3];
$ap060 [$i+4] = $datos[$i+4];
$ap100 [$i+5] = $datos[$i+5];
$ap150 [$i+6] = $datos[$i+6];



$nrcuil = $cuil [$i];
$nombre = $nom [$i+1];
$fecha = $fechain [$i+2];
$rem = $remune [$i+3];
$apo060 = $ap060 [$i+4];
$apo100 = $ap100 [$i+5];
$apo150 = $ap150 [$i+6];






//TABLA

print ("<table border=0 width=650>");
print ("  <tr>");

$cuill01 = substr($nrcuil,0,2);
$cuill02 = substr($nrcuil,2,8);
$cuill03 = substr($nrcuil,10,1);

print ("    <td width=96><p align=center><font face=Verdana size=1>".$cuill01."-".$cuill02."-".$cuill03."</font></td>");
print ("    <td width=182><font face=Verdana size=1>".$nombre."</font></td>");
$fec01 = substr($fecha,0,4);
$fec02 = substr($fecha,5,2);
$fec03 = substr($fecha,8,2);
print ("    <td width=89><p align=left><font face=Verdana size=1>".$fec03."/".$fec02."/".$fec01."</font></td>");
print ("    <td width=100><p align=right><font face=Verdana size=1>$".number_format($rem, 2, ",", "")."</font></td>");
print ("    <td width=57><p align=right><font face=Verdana size=1>$".number_format($apo060, 2, ",", "")."</font></td>");
print ("    <td width=57><p align=right><font face=Verdana size=1>$".number_format($apo100, 2, ",", "")."</font></td>");
print ("    <td width=57><p align=right><font face=Verdana size=1>$".number_format($apo150, 2, ",", "")."</font></td>");
print ("  </tr>");
print ("</table>");





$i = $i+7;
}

$parapo = $datos [$nfilas];
$tot060 = $datos [$nfilas + 1];
$tot100 = $datos [$nfilas + 2];
$tot150 = $datos [$nfilas + 3];
$totrem = $datos [$nfilas + 4];
$recarg = $datos [$nfilas + 5];

//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
$observ = $datos [$nfilas + 6];

$totapo = $parapo + $recarg;
$totapo = $totapo;
//print ("<br>");

//Encabezado de la tabla
print ("<table border=1 width=650 bordercolor=#000000 bordercolorlight=#000000 bordercolordark=#000000 cellspacing=0 cellpadding=0>");
print ("  <tr>");
print ("    <td width=379 bgcolor=#999999><p align=center><font face=Verdana size=1><b>TOTALES</b></font></td>");
print ("    <td width=100 bgcolor=#999999><p align=right><font face=Verdana size=1><b>$".number_format($totrem, 2, ",", "")."</b></font></td>");
print ("    <td width=57 bgcolor=#999999><p align=right><font face=Verdana size=1><b>$".number_format($tot060, 2, ",", "")."</b></font></td>");
print ("    <td width=57 bgcolor=#999999><p align=right><font face=Verdana size=1><b>$".number_format($tot100, 2, ",", "")."</b></font></td>");
print ("    <td width=57 bgcolor=#999999><p align=right><font face=Verdana size=1><b>$".number_format($tot150, 2, ",", "")."</b></font></td>");
print ("  </tr>");
print ("</table>");


print ("<table border=1 width=650 bordercolor=#000000 bordercolorlight=#000000 bordercolordark=#000000 cellspacing=0 cellpadding=0>");
print ("  <tr>");
print ("    <td width=379 bgcolor=#999999><p align=center><font face=Verdana size=1><b>TOTAL APORTES Y CONTRIBUCIONES</b></font></td>");
print ("    <td width=283 bgcolor=#C0C0C0><p align=right><font face=Verdana size=1><b>$".number_format($parapo, 2, ",", "")."</b></font></td>");
print ("  </tr>");
print ("</table>");


print ("<table border=1 width=650 bordercolor=#000000 bordercolorlight=#000000 bordercolordark=#000000 cellspacing=0 cellpadding=0>");
print ("  <tr>");
print ("    <td width=379 bgcolor=#999999><p align=center><font face=Verdana size=1><b>RECARGOS</b></font></td>");
print ("    <td width=283 bgcolor=#C0C0C0><p align=right><font face=Verdana size=1><b>$".number_format($recarg, 2, ",", "")."</b></font></td>");
print ("  </tr>");
print ("</table>");

print ("<table border=1 width=650 bordercolor=#000000 bordercolorlight=#000000 bordercolordark=#000000 cellspacing=0 cellpadding=0>");
print ("  <tr>");
print ("    <td width=379 bgcolor=#C0C0C0><p align=center><font face=Verdana size=1><b>TOTAL A DEPOSITAR</b></font></td>");
print ("    <td width=283 bgcolor=#C0C0C0><p align=right><font face=Verdana size=1><b>$".number_format($totapo, 2, ",", "")."</b></font></td>");
print ("  </tr>");
print ("</table>");

$nrcuil9 = "99999999999";

$sql = "INSERT INTO ddjj (nrcuit,nrcuil,permes,perano,remune,apo060,apo100,apo150,totapo,nfilas,recarg,nrctrl,observ)

VALUES ('$nrcuit','$nrcuil9','$permes','$perano','$totrem','$tot060','$tot100','$tot150','$totapo','$filas','$recarg','$ctrlh','$observ')";

$result = mysql_db_query("uv0472_aplicativo",$sql,$db);






print ("  <p><input type=submit value=Procesar&nbsp;Boleta name=B1></p>");
print ("</form>");


mysql_close();





?>
          </td>
        </tr>
      </table>
     
  </tr>
</table>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<input type="button" name="imprimir" value="Imprimir" onClick="window.print();">
</body>

</html>