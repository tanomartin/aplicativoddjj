<?php session_save_path("sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: caducaSes.php");
include("lib/conexion.php");
?>
<html>

<head>

<title>.: U.S.I.M.R.A. :.</title>
<META HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">

<meta http-equiv="" content="text/html; charset=iso-8859-1"></head>
<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
<body topmargin="0" leftmargin="0">

<table border="0" width="100%" height="100%">
  <tr>
    <td width="100%" valign="top" align="center"> 
<?php
require ("numerosaLetras.php");			  
	  
$nota[0] = ("1 - Original: Para el DEPOSITANTE");
$nota[1] = ("1 - Duplicado: Para el BANCO como comprobante de Caja");
$nota[2] = ("3 - Triplicado: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
for ($w = 0; $w <2; $w++) {			  

print ("<table border=1 width=650 bordercolor=#000000 bordercolorlight=#000000 bordercolordark=#000000 cellspacing=0 cellpadding=0>");
print ("  <tr>");
print ("    <td width=650><p align=center><font size=2 face=Arial Narrow>Cta. Cte. <b>Nº 900004/93</b> (F.A.I.M.A. - U.S.I.M.R.A.) BANCO NACION - SUCURSAL CABALLITO</b></font></td>");
print ("  </tr>");
print ("</table>");

print ("<table border=0 width=650");
print ("  <tr>");
print ("    <td width=650><p align=center><font face=Verdana size=2>NOTA DE CREDITO para la Cuenta de Unión de Sindicatos de la Industria Maderera de la República Argentina (U.S.I.M.R.A.) y Federación Argentina de la Industria Maderera y Afines (F.A.I.M.A.) - CCT 335/75 Artículos 32 y 32 bis.</font></td>");
print ("  </tr>");
print ("</table>");


    print ("<table border=1 width=300 bordercolor=#000000 bordercolorlight=#000000 bordercolordark=#000000 cellspacing=0 cellpadding=0><p align=center>");
    print ("  <tr>");
    print ("    <td width=400><p align=center><font size=1 face=Arial Narrow>BANCO DE LA NACION ARGENTINA - Sucursal Caballito - Rivadavia 5199 - C.A.B.A.</b></font></td>");
    print ("  </tr>");
    print ("</table>");


//Ejecucion de la sentencia SQL
$sql = "select * from empresa where nrcuit = '$nrcuit'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);


$row=mysql_fetch_array($result);



print ("<table border=0 width=650>");
print ("  <tr>");
print ("    <td width=100><font face=Verdana size=1>Empleador:</font></td>");
print ("    <td width=300><font face=Verdana size=1>".$row['nombre']."</font></td>");
print ("    <td width=100><font face=Verdana size=1>CUIT:</font></td>");
print ("    <td width=150><font face=Verdana size=1>".$nrcuit."</font></td>");
print ("  </tr>");
print ("  <tr>");
print ("    <td width=100><font face=Verdana size=1>Domicilio:</font></td>");
print ("    <td width=300><font face=Verdana size=1>".$row['domile']."</font></td>");
print ("    <td width=100><font face=Verdana size=1>Localidad:</font></td>");
print ("    <td width=150><font face=Verdana size=1>".$row['locali']."</font></td>");
print ("  </tr>");
print ("</table>");



$sql = "select * from ddjj where nrcuit = '$nrcuit'
and nrcuil = '99999999999'
and nrctrl = '$nrctrlh'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$row=mysql_fetch_array($result);

//number_format(, 2, ",", "")

$nume = $row['totapo'];
$pepe = cfgValorEnLetras($nume);



print ("<table border=1 width=650 bordercolor=#000000 bordercolorlight=#000000 bordercolordark=#000000 cellspacing=0 cellpadding=0>");
print ("  <tr>");
print ("    <td width=141 colspan=4 align=center rowspan=2><font size=1 face=Arial Narrow>Período Liquidado</font></td>");
print ("    <td width=69 rowspan=3 align=center><font size=1 face=Arial Narrow>Cantidad de Personal</font></td>");
print ("    <td width=69 rowspan=3 align=center><font size=1 face=Arial Narrow>Total Salarios</font></td>");
print ("    <td width=69 align=center><font size=1 face=Arial Narrow>Otros Conceptos</font></td>");
print ("    <td width=212 colspan=3 align=center><font face=Arial Narrow size=1>Contribuciones y Aportes CCT 335/75</font></td>");
print ("    <td width=76 rowspan=3 align=center><font face=Arial Narrow size=1>Total del Depósito</font></td>");
print ("  </tr>");
print ("  <tr>");
print ("    <td width=69 rowspan=2 align=center><font face=Arial Narrow size=1>Recargos - Intereses - Otros</font></td>");
print ("    <td width=141 colspan=2 align=center><font face=Arial Narrow size=1>Contribuciones Patronales</font></td>");
print ("    <td width=69 align=center><font face=Arial Narrow size=1>Aporte</font></td>");
print ("  </tr>");
print ("  <tr>");
print ("    <td width=70 align=center colspan=2><font face=Arial Narrow size=1>Mes</font></td>");
print ("    <td width=69 align=center colspan=2><font face=Arial Narrow size=1>Año</font></td>");
print ("    <td width=70 align=center><font face=Arial Narrow size=1>Art.32 0,6%</font></td>");
print ("    <td width=69 align=center><font face=Arial Narrow size=1>Art.32 bis 1%</font></td>");
print ("    <td width=69 align=center><font face=Arial Narrow size=1>Art.32 bis 1,5%</font></td>");
print ("  </tr>");
print ("  <tr>");
print ("    <td width=70 align=center colspan=2><font face=Arial Narrow size=1>".$row['permes']."</font></td>");
print ("    <td width=69 align=center colspan=2><font face=Arial Narrow size=1>".$row['perano']."</font></td>");
print ("    <td width=69 align=center><font face=Arial Narrow size=1>".$row['nfilas']."</font></td>");
print ("    <td width=69 align=center><font face=Arial Narrow size=1>".number_format($row['remune'], 2, ",", ".")."</font></td>");
print ("    <td width=69 align=center><font face=Arial Narrow size=1>".number_format($row['recarg'], 2, ",", ".")."</font></td>");
print ("    <td width=70 align=center><font face=Arial Narrow size=1>".number_format($row['apo060'], 2, ",", ".")."</font></td>");
print ("    <td width=69 align=center><font face=Arial Narrow size=1>".number_format($row['apo100'], 2, ",", ".")."</font></td>");
print ("    <td width=69 align=center><font face=Arial Narrow size=1>".number_format($row['apo150'], 2, ",", ".")."</font></td>");
print ("    <td width=76 align=center><font face=Arial Narrow size=1><b>".number_format($row['totapo'], 2, ",", ".")."</b></font></td>");
print ("  </tr>");
print ("  <tr>");
print ("    <td width=56 align=center>");
print ("      <p align=center><font face=Arial Narrow size=1><b>Efectivo</b></font></td>");
print ("    <td width=12 align=center>&nbsp;</td>");
print ("    <td width=54 align=center><font face=Arial Narrow size=1><b>Cheque</b></font></td>");
print ("    <td width=13 align=center>&nbsp;</td>");
print ("    <td width=491 align=center colspan=7>&nbsp;</td>");
print ("  </tr>");
print ("  <tr>");
print ("    <td width=70 align=center colspan=2><font face=Arial Narrow size=1><b>Son Pesos:</b></font></td>");
print ("    <td width=560 align=left colspan=9><font face=Arial Narrow size=1>&nbsp;".strtoupper($pepe)."-</td>");
print ("  </tr>");
print ("</table>");
print ("<br>");

$nconvenio = 3617;
$ncuasifinal = $nconvenio.$nrcuit.$nrctrlh;
print ("<br>");
//print $ncuasifinal;
print ("<br>");

$npart3total = 0;
$npart1total = 0;

for ($i=0; $i < 29; $i++) {
$npor3 = substr($ncuasifinal,$i,1);
$npor33 = $npor3 * 3;
$npart3total = $npart3total + $npor33;
$i = $i + 1;
$npor1 = substr($ncuasifinal,$i,1);
$npart1total = $npart1total + $npor1;
}
//print $npart3total;
//print ("<br>");
//print $npart1total;
//print ("<br>");
$npartot = $npart1total + $npart3total;
//print $npartot;

$largonpar = strlen($npartot);

//print $largonpar;
$ndigito = $largonpar -1;
$nverifi01 = substr($npartot,$ndigito,1);
print ("<br>");

if ($nverifi01 == 0) {
$dverifi = 0;} else {
$dverifi = 10 - $nverifi01;
}
//print $dverifi;
//print ("<br>");








//impresion de codigo de barra
print ("<table border=0 width=650>");
print ("  <tr><td width=100%><p align=center>");


print ("<img border=0 src=img/x.jpg width=10 height=28>");
for ($i=0; $i < 29; $i++) {
$poscuit = substr($ncuasifinal,$i,1);
print ("<img border=0 src=img/".$poscuit.".jpg width=10 height=28>");
}
print ("<img border=0 src=img/".$dverifi.".jpg width=10 height=28>");
print ("<img border=0 src=img/x.jpg width=10 height=28>");
print ("<br>");
print $ncuasifinal.$dverifi;



print ("	</td></tr>");
print ("</table>");

print ("<table border=0 width=650>");
print ("  <tr>");
print ("    <td width=650><p align=left><font size=1 face=Arial Narrow>".$nota[$w]."</font></td>");
print ("<br>");

print ("  </tr>");
print ("    <td width=650><p align=center><font size=1 face=Arial Narrow><img border=0 src=img/tijera.jpg width=30 height=17>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </font></td>");
print ("<br>");
print ("<br>");
print ("<br>");
print ("  <tr>");
print ("  </tr>");

print ("</table>");

print ("<br>");



}
mysql_close();





?>
   </td> 
  </tr>
</table>


</p></font>


</p>

<p>
  <input type="button" name="imprimir" value="Imprimir" onClick="window.print();">
</p>
<p><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="home.php">VOLVER</a></strong></font></p>
</body>

</html>