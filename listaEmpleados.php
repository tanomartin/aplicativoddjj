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
            <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>LISTADO EMPLEADOS </strong></font></div></td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><font color="#CF8B34"> <?php include("menuLateral.php"); ?> </td>
					<?php
					$sql = "select * from empleados where nrcuit = '$nrcuit'";
					$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
					$nfilas = mysql_num_rows($result);
					if ($nfilas < 1) {
					$nfilas = 0;
					}
					?>            
          <td width="516" valign="top"> <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>Cantidad 
              de empleados registrados:</strong></font> <strong><font size="2" face="Arial, Helvetica, sans-serif"><? echo $nfilas; ?></font></strong></p>

			<table border=1 width=100% bordercolorlight=#D08C35 bordercolordark=#D08C35 bordercolor=#CD8C34 cellpadding=2 cellspacing=0>
			
			<td width=20%><font face=Verdana size=1><b>CUIL</b></font></td>
			<td width=50%><font face=Verdana size=1><b>Apellido y Nombre</b></font></td>
			<td width=20%><font face=Verdana size=1><b>Fecha Ingreso</b></font></td>
			<td width=10%><font face=Verdana size=1><b>Activo</b></font></td>
			</tr>
			
			<?php
			$i = 1;
			 while ($row=mysql_fetch_array($result)) {
			$cuil[$i-1] = $row["nrcuil"];
			
			$cuill01 = substr($row["nrcuil"],0,2);
			$cuill02 = substr($row["nrcuil"],2,8);
			$cuill03 = substr($row["nrcuil"],10,1);
			
			print ("<td width=20%><font face=Verdana size=1>".$cuill01."-".$cuill02."-".$cuill03."</font></td>");
			$totnom = sprintf("%s %s", $row["apelli"],$row["nombre"]);
			print ("<td width=50%><font face=Verdana size=1><b><a href=muestraEmpleado.php?nrcuil=".$row["nrcuil"].">".$totnom."</b></font></td>");
			$fec01 = substr($row["fecing"],0,4);
			$fec02 = substr($row["fecing"],5,2);
			$fec03 = substr($row["fecing"],8,2);
			print ("<td width=20%><font face=Verdana size=1>".$fec03."/".$fec02."/".$fec01."</font></td>");
			print ("<td width=10%><font face=Verdana size=1>".$row['activo']."</font></td>");
			print ("</tr>");
			$i++;
			}
			
			?>			
			</table>
              <p>&nbsp;</p>
			</td>
          </tr>
          <tr>
            
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Copyright 
              2007 <strong>U.S.I.M.R.A.</strong> - Todos los derechos reservados</font></div></td>
          </tr>
</table>
        </body>

</html>
