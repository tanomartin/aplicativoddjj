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
            
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>GRUPO 
              FAMILIAR</strong></font></div></td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><b><font color="#CF8B34"><?php include("menuLateral.php"); ?></font></b></font></p></td>   
<?php
$cuil01 = substr($nrcuil,0,2);
$cuil02 = substr($nrcuil,2,8);
$cuil03 = substr($nrcuil,10,1);
$sql = "select * from empleados where nrcuil = '$nrcuil'
and nrcuit = '$nrcuit'";
$res = mysql_db_query("uv0472_aplicativo",$sql,$db);
$nom=mysql_fetch_array($res);
?>            
          <td width="516" valign="top"><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php echo $cuil01?>-<?php echo $cuil02?>-<?php echo $cuil03?>  <?php echo $nom['apelli'];?>, <?php echo $nom['nombre'];?></strong></font></p>
            <p> 
              <?php
$sql = "select * from familia where id = '$id'
order by nrcuil,codpar,fecnac";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$row=mysql_fetch_array($result);
?>


            </p>
            <table width="100%" border="0">
              <tr> 
                <td width="37%"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nombre:</font></strong></td>
                <td width="63%"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php echo $row['nombre'];?>
                  </font></td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Apellido:</font></strong></td>
                <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['apelli'];?></font></td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Parentesco:</font></strong></td>
                <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
<?php echo $row['codpar'];?>
                  </font></td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Sexo:</font></strong></td>
                <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
<?php echo $row['ssexxo'];?>
                  </font></td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
                  de Nacimiento:</font></strong></td>
                <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php
$fecn01 = substr($row['fecnac'],0,4);
$fecn02 = substr($row['fecnac'],5,2);
$fecn03 = substr($row['fecnac'],8,2);
?>
<?php echo $fecn03;?> / <?php echo $fecn02;?> / <?php echo $fecn01;?>
</font>	
                  </font></td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
                  de Ingreso:</font></strong></td>
                <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php
$fec01 = substr($row['fecing'],0,4);
$fec02 = substr($row['fecing'],5,2);
$fec03 = substr($row['fecing'],8,2);
  ?>
 <?php echo $fec03;?> / <?php echo $fec02;?> / <?php echo $fec01;?> 
</font>	
                  </font></td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Tipo 
                  y Nro. de Documento:</font></strong></td>
                <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
<?php echo $row['tipdoc'];?> <?php echo $row['nrodoc']?>
                  </font></td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Beneficiario:</font></strong></td>
                <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
<?php echo $row['benefi']; ?>
                  </font></td>
              </tr>
            </table>
            <p><font size="2" face="Arial, Helvetica, sans-serif"><strong><a href="muestraeliminacionFamiliar.php?id=<?php echo $id;?>&nrcuil=<?php echo $nrcuil;?>"><font color="#800000">Borrar 
              Familiar</font></a><font color="#800000"> </font>- <a href="modificacionFamiliar.php?id=<?php echo $id;?>&nrcuil=<?php echo $nrcuil;?>">Modificar 
              Familiar</a></strong></font> 
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
