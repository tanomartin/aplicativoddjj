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
$sql = "select * from empresa where nrcuit = '$nrcuit'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$row = mysql_fetch_array($result);
?>

<body bgcolor="#E4C192" link="#62641A" vlink="#62641A" alink="#CF8B34">
  <?php include("cabezal.php"); ?>
        <table border="0" width="700">
          <tr>
            
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>ELIMINACION 
              DE REGISTRO</strong></font></div></td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><b><font color="#CF8B34"><?php include("menuLateral.php"); ?></font></b></font></p></td>
          <td width="516" valign="top"> <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>&iquest;DESEA 
              ELIMINAR ESTE REGISTRO?</strong><br>
              Recuerde que tambi&eacute;n se borraran los registros de familiares. 
              </font></p>
            <table width="100%" border="0">
              <tr> 
<?php
$sql = "select * from empleados where nrcuit = '$nrcuit' and nrcuil = '$nrcuil'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$row=mysql_fetch_array($result);

$cuil01 = substr($row['nrcuil'],0,2);
$cuil02 = substr($row['nrcuil'],2,8);
$cuil03 = substr($row['nrcuil'],10,1);
?>			  
                <td width="41%"><strong><font size="2" face="Arial, Helvetica, sans-serif">CUIL:</font></strong></td>
                <td width="59%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $cuil01."-".$cuil02."-".$cuil03; ?></font></td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Apellido 
                  y Nombre:</font></strong></td>
                <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['apelli']; ?> <?php echo $row['nombre']; ?></font></td>
              </tr>
              <tr> 
                <?php
$fec01 = substr($row['fecing'],0,4);
$fec02 = substr($row['fecing'],5,2);
$fec03 = substr($row['fecing'],8,2);
  ?>
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
                  de Ingreso:</font></strong></td>
                <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $fec03."/".$fec02."/".$fec01;?></font></td>
              </tr>
            </table>
            <p align="left"><font color="#660033" size="2" face="Arial, Helvetica, sans-serif"><a href="eliminacionEmpleado.php?nrcuil=<?php echo $nrcuil ?>"><strong>ELIMINAR 
              CUIL <?php echo $cuil01."-".$cuil02."-".$cuil03; ?> Y REGISTROS DE 
              FAMILIARES</strong></a></font></p>
            <p>&nbsp;</p>
              <p>&nbsp;</p>
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
