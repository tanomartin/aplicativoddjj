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
include("lib/conexion.php");;
?>

<body bgcolor="#E4C192" link="#62641A" vlink="#62641A" alink="#CF8B34">
 <?php include("cabezal.php"); ?>
        <table border="0" width="700">
          <tr>
            <td width="690" colspan="2" bgcolor="#CF8B34">&nbsp;</td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><font color="#CF8B34">
			  <?php include("menuLateral.php"); ?>
		</td>
<?php
$nrcuil = $_GET['nrcuil'];
$sql = "select * from empleados where nrcuit = '$nrcuit' and nrcuil = '$nrcuil'";
$result = mysql_query($sql,$db);
$row=mysql_fetch_array($result);

$cui01 = substr($row['nrcuit'],0,2);
$cui02 = substr($row['nrcuit'],2,8);
$cui03 = substr($row['nrcuit'],10,1);
?>            
          <td width="516" valign="top"> <p><strong><font size="2" face="Arial, Helvetica, sans-serif">Datos 
              del Empleado:</font></strong></p>

            <table width="100%">
              <tr> 
<?php
$cui01 = substr($row['nrcuit'],0,2);
$cui02 = substr($row['nrcuit'],2,8);
$cui03 = substr($row['nrcuit'],10,1);
?>
                <td width="217"><b><font face="Verdana" size="1">CUIT</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $cui01."-".$cui02."-".$cui03; ?></font></td>
              </tr>
              <tr> 
<?php
$cuil01 = substr($row['nrcuil'],0,2);
$cuil02 = substr($row['nrcuil'],2,8);
$cuil03 = substr($row['nrcuil'],10,1);
?>
                <td width="217"><b><font face="Verdana" size="1">CUIL</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $cuil01."-".$cuil02."-".$cuil03; ?></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Nombre</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['nombre']; ?></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Apellido</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['apelli']; ?></font></td>
              </tr>
              <tr> 
<?php
$fec01 = substr($row['fecing'],0,4);
$fec02 = substr($row['fecing'],5,2);
$fec03 = substr($row['fecing'],8,2);
  ?>
                <td width="217"><b><font face="Verdana" size="1">Fecha de Ingreso</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $fec03."/".$fec02."/".$fec01;?></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Tipo y Número 
                  de Documento</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['tipdoc']." ".$row['nrodoc']; ?></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Sexo</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['ssexxo']; ?></font></td>
              </tr>
              <tr> 
<?php
$fecn01 = substr($row['fecnac'],0,4);
$fecn02 = substr($row['fecnac'],5,2);
$fecn03 = substr($row['fecnac'],8,2);
?>
                <td width="217"><b><font face="Verdana" size="1">Fecha de Nacimiento</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $fecn03."/".$fecn02."/".$fecn01;?></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Estado Civil</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['estciv']; ?></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Dirección</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['direcc']; ?></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Localidad</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['locale']; ?></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Código Postal</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['copole']; ?></font></td>
              </tr>
              <tr> 
                <?php $pro = $row["provin"]; ?>
                <td width="217"><b><font face="Verdana" size="1">Provincia</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $provincia [$pro] ?></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Nacionalidad</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['nacion']; ?></font></td>
              </tr>
              <tr> 
<?php
$cat = $row['catego'];
$sqll = "select * from categorias where codram = '$rconsu' and codcat = '$cat'";
$res = mysql_query($sqll,$db);
$pow=mysql_fetch_array($res);
	  ?>			  
                <td width="217"><b><font face="Verdana" size="1">Categoría</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $pow['descri']; ?></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Activo</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['activo']; ?></font></td>
              </tr>
            </table>
            <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong><a href="modificacionEmpleado.php?nrcuil=<?php echo $nrcuil ?>">Modificar</a> 
              - <a href="muestraeliminacionEmpleado.php?nrcuil=<?php echo $nrcuil ?>"><font color="#660033">Eliminar Registro</font></a> 
              - <a href="listagrupoFamiliar.php?nrcuil=<?php echo $nrcuil ?>">Grupo Familiar</a></strong></font></p>
            <p>&nbsp;</p></td>
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
