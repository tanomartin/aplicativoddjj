<html>

<head>
<style>
<!--
A:link {text-decoration: none}
A:visited {text-decoration: none}
A:hover {text-decoration:underline; color:FCF63C}
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
	SCROLLBAR-DARKSHADOW-COLOR: #CD8C34;
	color: #000000;
}
.Estilo1 {
	color: #FF0000;
	font-weight: bold;
}
</STYLE>
<title>.: U.S.I.M.R.A. :.</title>
</head>

<body bgcolor="#E4C192" link="#D5913A" vlink="#CF8B34" alink="#D18C35">
  <p align="center" style="margin-bottom: 0"><img border="0" src="img/top.jpg" width="700" height="120"></p>

  <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font color="#E4C192">m</font></p>

  <form method="POST" action="verificaEmpresa.php">

  <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">&nbsp;</p>
	
  <table border="0" width="100%">
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" align="right">
	  <?php
	  	$err= $_GET['err'];
	  	if ($err == 1) {
			print("<p align='center' style='word-spacing: 0; margin-top: 0; margin-bottom: 0'><strong><font color='#FF0000' size='2' face='Arial, Helvetica, sans-serif'>DATOS INCORRECTOS</font></strong></p>");
		}
		if ($err == 2) {
			print("<p align='center' style='word-spacing: 0; margin-top: 0; margin-bottom: 0'><strong><font color='#FF0000' size='2' face='Arial, Helvetica, sans-serif'>SESIÓN CADUCADA</font></strong></p>");
		}
	  ?>
	  
	  </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="19%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">&nbsp;</p>      </td>
      <td width="30%" align="right"><font face="Verdana" size="2"><b>Usuario:&nbsp;&nbsp;</b></font></td>
      <td width="30%">
        <p align="left"><input name="user" type="text" id="user" style="background-color: #E4C192" size="20"></td>
      <td width="21%">&nbsp;</td>
    </tr>
    <tr>
      <td width="19%">&nbsp;</td>
      <td width="30%" align="right"><font face="Verdana" size="2"><b>Contraseña:&nbsp;&nbsp;&nbsp;</b></font></td>
      <td width="30%">
        <p align="left"><input name="pass" type="password" id="pass" style="background-color: #E4C192" size="20"></td>
      <td width="21%">&nbsp;</td>
    </tr>
    <tr>
      <td width="19%"></td>
      <td width="30%" align="right"></td>
      <td width="30%">
        <input type="submit" value="Ingresar" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37"></td>
      <td width="21%"></td>
    </tr>
    <tr>
      <td width="19%"></td>
      <td align="right" colspan="2"><div align="center" class="Estilo1">AVISO: ESTA NUEVA VERSION DEL APLICATIVO REQUIERE ACTIVAR EL PERMISO DE VENTANAS EMERGENTES DE SU NAVEGADOR PARA NUESTRO SITIO </div></td>
      <td width="21%"></td>
    </tr>
    <tr>
      <td width="19%"></td>
      <td align="right" colspan="2">
        <p align="center"><b><font face="Verdana" size="2"><a href="altaEmpresa.php"><font color="#62641A">Registrarse como
        nuevo</font></a></font></b><p align="center"><b><a href="pedidoContrasenia.php"><font color="#62641A" face="Verdana" size="1">¿OLVIDO
        SU CONTRASEÑA?</font></a></b></td>
      <td width="21%"></td>
    </tr>
  </table>
</form>

</body>

</html>
