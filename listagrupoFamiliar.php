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
            <td width="168" valign="top"><font face="Verdana" size="1"><b><font color="#CF8B34"><?php include("menuLateral.php"); ?></p></td>
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
$sql = "select * from familia where nrcuil = '$nrcuil'
and nrcuit = '$nrcuit'
order by nrcuil,codpar,fecnac";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$nfilas = mysql_num_rows($result);
if ($nfilas < 1) {
print ("<font face=Verdana size=2>Cantidad de Familiares Registrados: 0</font>");
} else {
Print ("<font face=Verdana size=2>Cantidad de Familiares Registrados: ".$nfilas."</font>");
}

print ("<br>");
print ("<br>");

print ("<table border=1 width=100% bordercolorlight=#D08C35 bordercolordark=#D08C35 bordercolor=#CD8C34 cellpadding=2 cellspacing=0>");

print ("
<td width=15%><font face=Verdana size=1><b>Documento</b></font></td>
<td width=40%><font face=Verdana size=1><b>Apellido y Nombre</b></font></td>
<td width=15%><font face=Verdana size=1><b>Fecha Nac.</b></font></td>
<td width=30%><font face=Verdana size=1><b>Parentesco</b></font></td>
</tr>
");

$i = 1;
 while ($row=mysql_fetch_array($result)) {
$cuil[$i-1] = $row["nrcuil"];

print ("<td width=15%><font face=Verdana size=1>".(int)$row["nrodoc"]."</font></td>");
$totnom = sprintf("%s %s", $row["apelli"],$row["nombre"]);
print ("<td width=50%><font face=Verdana size=1><b><a href=muestraFamiliar.php?id=".$row["id"]."&nrcuil=".$row["nrcuil"].">".$totnom."</b></font></td>");
$fec01 = substr($row["fecnac"],0,4);
$fec02 = substr($row["fecnac"],5,2);
$fec03 = substr($row["fecnac"],8,2);
print ("<td width=15%><font face=Verdana size=1>".$fec03."/".$fec02."/".$fec01."</font></td>");
print ("<td width=30%><font face=Verdana size=1>".$row['codpar']."</font></td>");
print ("</tr>");
$i++;
}

print ("</table>");
?>
            </p>
<p><font size="2" face="Arial, Helvetica, sans-serif"><strong><a href="cargaFamiliar.php?nrcuil=<? echo $nrcuil;?>">Agregar 
              Registro de Familiar</a></strong></font></td>
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
