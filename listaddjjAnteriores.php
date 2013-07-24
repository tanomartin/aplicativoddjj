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
            <td width="690" colspan="2" bgcolor="#CF8B34">&nbsp;</td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><b><font color="#CF8B34"> <?php include("menuLateral.php"); ?></td>
            <td width="516" valign="top"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong><u>Declaraciones 
              Juradas Anteriores:</u></strong></font></p>
              <p><font size="2" face="Arial, Helvetica, sans-serif"><a href="carganuevaDdjj.php"><strong>Cargar 
                una DDJJ nueva</strong></a></font></p>
              <p> 
              <?
			$sql = "select * from validas where nrcuit = '$nrcuit' order by perano DESC, permes DESC";
			$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
			$nfilas = mysql_num_rows($result);
			if ($nfilas < 1) {
				$nfilas = 0;
			}			
			?>
            </p>
            <table border=1 width=100% bordercolorlight=#D08C35 bordercolordark=#D08C35 bordercolor=#CD8C34 cellpadding=2 cellspacing=0>
              <td width=25%><div align="center"><font face=Verdana size=1><b>Año</b></font></div></td>
              <td width=25%><div align="center"><font face=Verdana size=1><b>Mes</b></font></div></td>
              <td width=25%><div align="center"><font face=Verdana size=1><b>Cantidad 
                  CUILES</b></font></div></td>
              <td width=25%><div align="center"><font face=Verdana size=1><b>Total 
                  Aportado</b></font></div></td>
              </tr>
              <?php
$i = 1;
 while ($row=mysql_fetch_array($result)) {


print ("<td width=25%><font face=Verdana size=1>".$row['perano']."</font></td>");

print ("<td width=25%><font face=Verdana size=1><b>".$row['permes']."</b></font></td>");

print ("<td width=25%><font face=Verdana size=1>".$row['nfilas']."</font></td>");
print ("<td width=25%><font face=Verdana size=1><a href=cargaanteriorDdjj.php?nrctrlold=".$row['nrctrl'].">".$row['totapo']."</font></td>");
print ("</tr>");
$i++;
}

?>
            </table>


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
