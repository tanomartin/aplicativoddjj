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
<STYLE>
BODY {
SCROLLBAR-FACE-COLOR: #E4C192; 
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
<body bgcolor="#E4C192" link="#62641A" vlink="#62641A" alink="#CF8B34">
 		<?php include("cabezal.php"); ?>
	    <table border="0" width="700">
          <tr>
            <td width="690" colspan="2" bgcolor="#CF8B34">&nbsp;</td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><b><font color="#CF8B34"> <?php include("menuLateral.php"); ?></td>
          <td width="516" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Bienvenidos 
            al Aplicativo DDJJ </strong></font><font face="Arial, Helvetica, sans-serif"> 
            <p><font size="2">La herramienta en l&iacute;nea de U.S.I.M.R.A. para 
              la generaci&oacute;n de Declaraciones Juradas y Boletas de Pago 
              de las Resoluciones de Seguro de Vida y Sepelio.</font></p>
            <p><font size="2"><b><font color="#FF0000">Novedad: </font>Para la liquidación de los períodos no Remunerativos
			deberá fijarse en la lista desplegable de selección de mes del año correspondiente 
			el índice que refiere al No Remunerativo Respectivo</b></p></font>   
            <p><a href="manual_aplicativo_ddjj.pdf" onclick="window.open(this.href,'Acuerdos','resizable=YES, Scrollbars=YES', width=800,height=600, top=100, left=100); return false">Descargar Instructivo</a></p>
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
