<? session_save_path("../sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: ../caducaSes.php");
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


<?
include ("conexion.php");
//Ejecucion de la sentencia SQL
$sql = "select * from empresa where nrcuit = '$nrcuit'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$row = mysql_fetch_array($result);
?>

<body bgcolor="#E4C192" link="#62641A" vlink="#62641A" alink="#CF8B34">
  <?php include("../cabezal.php"); ?>
        <table border="0" width="700">
          <tr>
            <td width="690" colspan="2" bgcolor="#CF8B34">&nbsp;</td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><b><font color="#CF8B34">
					  <a href="cargaArchivoEmp.php">Importar Empleados</a><br>
                      <a href="cargaArchivoFam.php">Importar Familia</a><br>
                      <a href="cargaArchivoDj.php">Importar D.D.J.J.</a><br>
            </font></b></font></p>
              <p><font face="Verdana" size="2"><b><font color="#CF8B34">               
			   <a href="../home.php">Menu Principal</a></font></b></font></p></td>
          <td width="516" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif">M&oacute;dulo Grandes Empresas </font></strong><font face="Arial, Helvetica, sans-serif">&nbsp; 
            </font>
            <p><font size="2" face="Arial, Helvetica, sans-serif">Herramienta para importar empleados, familia y declaraciones juradas para grandes empresas </font></p>
             
            <p><a href="instrucGrandes.pdf" onClick="window.open(this.href,'Acuerdos','resizable=YES, Scrollbars=YES, width=800,height=600, top=100, left=100'); return false">Descargar Instructivo Grandes Empresas</a><br></p>
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
