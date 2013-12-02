<html>

<head>

<title>.: U.S.I.M.R.A. :.</title>
<style>
<!--
A:link {text-decoration: none}
A:visited {text-decoration: none}
A:hover {text-decoration:underline; color:FCF63C}
-->
</style>

<STYLE>BODY {SCROLLBAR-FACE-COLOR: #E4C192; 
SCROLLBAR-HIGHLIGHT-COLOR: #CD8C34; 
SCROLLBAR-SHADOW-COLOR: #CD8C34; 
SCROLLBAR-3DLIGHT-COLOR: #CD8C34; 
SCROLLBAR-ARROW-COLOR: #CD8C34; 
SCROLLBAR-TRACK-COLOR: #CD8C34; 
SCROLLBAR-DARKSHADOW-COLOR: #CD8C34
}
</STYLE>
</head>

<body bgcolor="#E4C192" link="#000000">
	<p align="center"><img border="0" src="img/top.jpg" width="700" height="120"></p>
    <table align=center border=0 cellpadding="5"> 

<?php
$datos = array_values($_POST);

$nrcuit = $datos [0];
$nombre  = $datos [1];
$domile = $datos [2];
$locale = $datos [3];
$provin = $datos [4];
$copole = $datos [5];
$telfon = $datos [6];
$emails = $datos [7];
$activi = $datos [8];
$fecini = $datos [9];
$rramaa = $datos [10];
$claveacc = $datos [11];

//Conexion con la base
include("lib/conexion.php");

//Ejecucion de la sentencia SQL
$sql = "INSERT INTO empresa (nrcuit,nombre,domile,locali,provin,copole,telfon,emails,activi,fecini,rramaa,claveacc)

VALUES ('$nrcuit','$nombre','$domile','$locale','$provin','$copole','$telfon','$emails','$activi','$fecini','$rramaa','$claveacc')";
$result = mysql_query($sql,$db);




print ("<table border=0 width=100%>");
print ("  <tr>");
print ("    <td width=100% align=center><b><font size=2 face=Verdana>Datos cargados satisfactoriamente!!!</font></b></td>");
print ("  </tr>");
print ("  <tr>");
print ("    <td width=100% align=center><b><font size=2 face=Verdana><a href=login.php>Loguearse</font></b></td>");
print ("  </tr>");
print ("</table>");



mysql_close();

?>

</p></font>

 </table> 

</p>

<p>&nbsp;</p></body>

</html>