<?php session_save_path("sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: caducaSes.php");
include("lib/conexion.php");
?>
<html>
<META HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache"> 
<style>
<!--
A:link {text-decoration: none}
A:visited {text-decoration: none}
A:hover {text-decoration:underline; color:#CF8B34}
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
<head>

<title>.: U.S.I.M.R.A. :.</title>
</head>


<?php
$datos = array_values($_POST);

$nombre = $datos [0];
$nombre = strtoupper($nombre);
$domile = $datos [1];
$domile = strtoupper($domile);
$locali = $datos [2];
$locali = strtoupper($locali);
$provin = $datos [3];
$copole = $datos [4];
$copole = strtoupper($copole);
$telfon = $datos [5];
$emails = $datos [6];
$activi = $datos [7];
$fecin01 = $datos [8];
$fecin02 = $datos [9];
$fecin03 = $datos [10];
$fecini = $fecin03.$fecin02.$fecin01;

//Ejecucion de la sentencia SQL
$sql = "update empresa
set nombre = '$nombre',
domile = '$domile',
locali = '$locali',
provin = '$provin',
copole = '$copole',
telfon = '$telfon',
emails = '$emails',
activi = '$activi',
fecini = '$fecini'
where nrcuit = '$nrcuit'
";
$result = mysql_query($sql,$db);

?>

<body bgcolor="#E4C192" link="#62641A" vlink="#62641A" alink="#CF8B34">
 		<?php include("cabezal.php"); ?>
        <table border="0" width="700">
          <tr>
            
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>DATOS 
              DE EMPRESA</strong></font></div></td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1" color="#CF8B34"><?php include("menuLateral.php"); ?></font></p></td>
            <td width="516" valign="top"><p>&nbsp;</p>
            <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>&iexcl;Datos 
              actualizados con exito!</strong></font></p>
              <p>&nbsp;</p>
			</td>
          </tr>
          <tr>
            
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Copyright 
              2007 <strong>U.S.I.M.R.A.</strong> - Todos los derechos reservados</font></div></td>
          </tr>
        </table>
        <p></td>
    </tr>
  </table>



</body>

</html>
