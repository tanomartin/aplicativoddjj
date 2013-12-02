<?php session_save_path("../sesiones");
session_start();
if($_SESSION['nrcuit'] == null)
	header ("Location: ../caducaSes.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Carga Archivo</title>
</head>

<body bgcolor="#E4C192">
<p align="center"><img border="0" src="top.jpg" width="700" height="120" /></p>
<table width="700" height="128" border="1" align="center">
  <tr>
    <td width="683" height="27"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><em>Carga de Archivos Declaraci&oacute;n Jurada </em></strong></font></div></td>
  </tr>
  <tr>
    <td height="71"><form action="subidaArcDj.php" method="post" enctype="multipart/form-data">
      <p align="center">
        <input type="file" name="archivo" />
        </p>
        <p align="center">
          <input type="submit" name="Submit" value="Enviar" />
        </p>
        <p align="center"><?php print ("<a href=menug.php>".VOLVER); ?> </p>
    </form></td>
  </tr>
    <td height="20" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Copyright 
    2007 <strong>U.S.I.M.R.A.</strong> - Todos los derechos reservados</font></div></td>
</table>

</body>
</html>
