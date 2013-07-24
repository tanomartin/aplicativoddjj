<?php session_save_path("sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: caducaSes.php");
include("lib/conexion.php");
$error = $_GET['error'];
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
.Estilo2 {font-size: 12px}
</STYLE>

<script language="javascript" type="text/javascript">

function validar(formulario) {
	var contraActual = formulario.contraActual.value;
	var contraNueva = formulario.nuevaContra.value;
	var repiteContra = formulario.repiteContra.value;
	if (contraActual == "") {
		alert("Debe ingresar la contraseña actual");
		formulario.contraActual.focus();
		return false;
	} 
	if (contraNueva != repiteContra) {
		alert("Las contraseñas no coinciden");
		formulario.nuevaContra.value = "";
		formulario.repiteContra.value = "";
		formulario.nuevaContra.focus();
		return false;
	}
	if (contraNueva.length < 8) {
		alert("La nueva contraseña debe tener como mínimo 8 caracteres");
		formulario.nuevaContra.value = "";
		formulario.repiteContra.value = "";
		formulario.nuevaContra.focus();
		return false;
	}
	if (contraActual == contraNueva) {
		alert("La nueva contraseña no debe ser igual a la Actual");
		formulario.nuevaContra.value = "";
		formulario.repiteContra.value = "";
		formulario.nuevaContra.focus();
		return false;
	}
	return true;
}

</script>

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
            <td width="168" valign="top"><p><font face="Verdana" size="1"><b><font color="#CF8B34"><?php include("menuLateral.php"); ?></td>
          <td width="516" valign="top"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>Cambio de contrase&ntilde;a</strong></font></p>
            <p>
              <?php 
					
					if ($error == 2) {
						print("<div style='color:#0066CC'><b> El cambio de contraseña se realizó correctamente </b></div>");
					}
				?>
            </p>
            <form id="cambioContra" name="cambioContra" method="POST" action="verificaCambioContrasenia.php"  onSubmit="return validar(this)" >
			<table width="476" border="0">
              <tr>
                <td width="160">Contrase&ntilde;a Actual
                <label></label></td>
                <td colspan="2"><input name="contraActual" type="password" id="contraActual">
                <?php 
					if ($error == 1) {
						print("<div style='color:#FF0000'><b> La contraseña actual ingresada es incorrecta </b></div>");
					}
				?></td>
              </tr>
              <tr>
                <td>Nueva Contrase&ntilde;a                </td>
                <td colspan="2"><input name="nuevaContra" type="password" id="nuevaContra"> 
                  <span class="Estilo2">(M&iacute;nimo 8 caracteres)</span> </td>
              </tr>
              <tr>
                <td>Repita Nueva Contrase&ntilde;a                </td>
                <td width="175"><input name="repiteContra" type="password" id="repiteContra"></td>
                <td width="119"><div align="right">
                  <input type="submit" value="Cambiar" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37">
                </div></td>
              </tr>
            </table>
			</form>
          </tr>
          <tr>
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Copyright 
              2007 <strong>U.S.I.M.R.A.</strong> - Todos los derechos reservados</font></div></td>
          </tr>
        </table>
</body>
</html>
