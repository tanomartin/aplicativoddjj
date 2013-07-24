<html>

<head>
<style>
<!--
A:link {text-decoration: none}
A:visited {text-decoration: none}
A:hover {text-decoration:underline; color:FCF63C}
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
<title>.: U.S.I.M.R.A. :.</title>
</head>

<body bgcolor="#E4C192" link="#D5913A" vlink="#CF8B34" alink="#D18C35">
  <p align="center" style="margin-bottom: 0"><img border="0" src="img/top.jpg" width="700" height="120"></p>
  <p align="center">&nbsp;</p>
  <p align="center">&nbsp;</p>
  <form method="POST" action="verificayenviaMail.php">

  <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">
  <?php 
  $err=$_GET['err'];
  if ($err == 1) {
  	print("<p style='word-spacing: 0; margin-top: 0; margin-bottom: 0' align='center'><b><font size='2' color='#FF0000' face='Verdana'>¡DATOS
  INCORRECTOS!</font></b></p>");
  }
  if ($err == 2) { ?>
	<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0" align="center"><font size="2" face="Verdana"><b>¡La
consulta se ralizado con exito!</b></font></p>
  <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0" align="center"><font size="2" face="Verdana">En
  instantes recibirá en la dirección de mail registrada previamente el dato de
  su contraseña.</font></p>
<p align="center"><b><font face="Verdana" size="2"><a href="login.php"><font color="#62641A">Volver</font></a></font></b></p>
 <?php }  ?>
  </p>
  <?php if ($err != 2) { ?>	
  <table border="0" width="100%">
    <tr>
      <td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">&nbsp;</p>
      </td>
      <td width="25%" align="right">
        <p align="center"><font face="Verdana" size="2"><b>E-mail Registrado:&nbsp;</b></font></p>
      </td>
      <td width="25%">
        <p align="left"><input name="user" type="text" id="user" style="background-color: #E4C192" size="20"></td>
      <td width="25%">&nbsp;</td>
    </tr>
    <tr>
      <td width="25%">&nbsp;</td>
      <td width="25%" align="right">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0" align="center"><b><font face="Verdana" size="2">Usuario</font></b></p>
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0" align="center"><b><font face="Verdana" size="1">(CUIT
        sin guiones)</font><font face="Verdana" size="2">:&nbsp;</font></b></p>
      </td>
      <td width="25%">
        <p align="left"><input name="pass" id="pass" style="background-color: #E4C192" size="20"></td>
      <td width="25%">&nbsp;</td>
    </tr>
    <tr>
      <td width="25%"></td>
      <td width="25%" align="right"></td>
      <td width="25%">
        <input type="submit" value="Ingresar" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37"></td>
      <td width="25%"></td>
    </tr>
    <tr>
      <td width="25%"></td>
      <td width="50%" align="right" colspan="2">&nbsp;</td>
      <td width="25%"></td>
    </tr>
    <tr>
      <td width="25%"></td>
      <td width="50%" align="right" colspan="2">
        <p align="center"><b><font face="Verdana" size="2"><a href="login.php"><font color="#62641A">Volver</font></a></font></b></td>
      <td width="25%"></td>
    </tr>
  </table>
  <?php } ?>
  
</form>

</body>

</html>
