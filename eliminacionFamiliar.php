<?php session_save_path("sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: caducaSes.php");
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
include("lib/conexion.php");
$sql = "delete from familia
where nrcuit = '$nrcuit' and
nrcuil = '$nrcuil' and
id = '$id'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);

//Ejecucion de la sentencia SQL
$db = mysql_connect($host,$user,$pass);
$sql = "select * from empresa where nrcuit = '$nrcuit'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$row = mysql_fetch_array($result);


?>

<body bgcolor="#E4C192" link="#62641A" vlink="#62641A" alink="#CF8B34">
 	<?php include("cabezal.php"); ?>
        <table border="0" width="700">
          <tr>
            
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>GRUPO 
              FAMILIAR</strong></font></div></td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><b><font color="#CF8B34"><?php include("menuLateral.php"); ?></font></b></font></p></td>
            
<?php 
include("lib/conexion.php");
$cuil01 = substr($nrcuil,0,2);
$cuil02 = substr($nrcuil,2,8);
$cuil03 = substr($nrcuil,10,1);
$sql = "select * from empleados where nrcuil = '$nrcuil'
and nrcuit = '$nrcuit'";
$res = mysql_db_query("uv0472_aplicativo",$sql,$db);
$nom=mysql_fetch_array($res);
?>            
          <td width="516" valign="top"><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <? echo $cuil01?>-<? echo $cuil02?>-<? echo $cuil03?>  <? echo $nom['apelli'];?>, <? echo $nom['nombre'];?></strong></font></p>
            <p align="center"><font color="#800000" size="2" face="Arial, Helvetica, sans-serif"><strong>REGISTRO 
              BORRADO</strong></font></p>
            <p> 

            </p>
            <p><font size="2" face="Arial, Helvetica, sans-serif"><strong><a href="listagrupoFamiliar.php?nrcuil=<? echo $nrcuil;?>"><font color="#800000">Volver</font></a></strong></font>
<p></td>
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
