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
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
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
            al Aplicativo DDJJ </strong></font>
			<font face="Arial, Helvetica, sans-serif"> 
            <p><font size="2">La herramienta en l&iacute;nea de U.S.I.M.R.A. para 
              la generaci&oacute;n de Declaraciones Juradas y Boletas de Pago 
              de las Resoluciones de Seguro de Vida y Sepelio.</font></p>
            <p><font face="Arial, Helvetica, sans-serif"><a href="manual_aplicativo_ddjj.pdf" onClick="window.open(this.href,'Acuerdos','resizable=YES, Scrollbars=YES', width=800,height=600, top=100, left=100); return false">Descargar Instructivo</a></font></p>
            <?php	
		   		$nrcuit = $row['nrcuit'];
		   		$sqlAviso = "select * from ddjjperdidas where nrcuit = '$nrcuit'";
				$resAviso = mysql_query($sqlAviso,$db);
				$canAviso = mysql_num_rows($resAviso);
				if ($canAviso > 0) { 
					print("<p><b><font size='3' color='#FF0000'>&iexcl;&iexcl;&iexcl;AVISO IMPORTANTE!!!</font></b></p>");
					$mensaje = "Estimado Usuario<br><br>
El d�a 3 de diciembre, nos encontramos con la novedad de que el aplicativo no estaba funcionando adecuadamente. El problema tuvo car�cter generalizado, todas las empresas que ingresaron al aplicativo experimentaron la misma situaci�n. El inconveniente tuvo su origen en la manipulaci�n de los servidores, en donde alojamos la base de datos y el aplicativo, sin previo aviso por parte de la empresa que provee el servicio de hosting. El departamento de sistemas tomo conocimiento de la situaci�n a partir de los llamados telef�nicos y emails recibidos de parte de los usuarios del aplicativo, lo que nos avoco de manera inmediata a la investigaci�n del origen del problema. Detectado el mismo, se procedi� a dar de baja el acceso al aplicativo y a trabajar de manera denodada en la protecci�n y consolidaci�n de la informaci�n alojada en la base de datos y en los ajustes de todos los m�dulos que componen el sistema, a la nueva realidad planteada por los cambios de servidores. El esfuerzo en la soluci�n del problema nos permiti� volver a dejar el aplicativo parcialmente operativo antes de las 18:00 hs. del mismo d�a y definitivamente operativo el d�a 6 de diciembre. Un posterior trabajo anal�tico y comparativo nos permite aseverar que en el 100% de los casos, las boletas de pago generadas est�n completamente respaldadas, por lo cual no corre riesgo la imputaci�n en la cuenta corriente de cada usuario (empresa). Pero el 3,37% de los usuarios (24 empresas sobre un universo de 8094) han quedado afectados en el detalle de las declaraciones juradas generadas entre los d�as <font color=#FF0000>26/11/2013</font> y <font color=#FF0000>28/11/2013</font>. Este es el caso para su C.U.I.T., por lo cual estamos procediendo a esta comunicaci�n en forma personalizada. Reiteramos que NO est�n en riesgo los pagos ingresados con las boletas generadas esos d�as, ni la imputaci�n respectiva en su cuenta corriente, pero podr� notar que los periodos relacionados a las declaraciones juradas objeto de las boletas generadas por Ud. esos dos d�as, no tendr�n el detalle asociado a su conformaci�n (ausencia de valores de remuneraci�n y al�cuotas de aportes por C.U.I.L.)";
					$rowAviso = mysql_fetch_assoc($resAviso);
					$perdioPeridodo = $rowAviso['periodo'];
					if ($perdioPeridodo == 1) {	
						$mensaje = $mensaje.", ni la identificaci�n del mes pertinente (designaci�n nominal de meses superiores a 40)";
			 	    }
					$mensaje = $mensaje.". Por esto,  el departamento de sistemas le ofrece la posibilidad de reconstruir puntualmente esos detalles a partir de la informaci�n que Ud. pueda proveer, para lo cual, abrimos de esta manera un canal de comunicaci�n directa con Ud. a trav�s de la siguiente direcci�n de correo electr�nico: <font color=#0033FF> sistemas@usimra.com.ar</font>. Le solicitamos, si fuese de su inter�s, que envi� un email a esa direcci�n, identificando a la empresa por su C.U.I.T. y raz�n social, y especificando, adem�s, el nombre y apellido de una persona de contacto directo y un numero telef�nico por si fuera necesaria alguna comunicaci�n personal.<br><br> 
Esperando que pueda ser comprendido que fuimos ajenos a la situaci�n provocada, solicitando desde ya las disculpas pertinentes y agradeciendo de antemano la predisposici�n y paciencia de vuestra parte, dejamos saludos cordiales y quedamos a disposici�n para cualquier inquietud planteada al respecto.<br><br>"?>
					<p class="Estilo1" align="justify"><font  size="1"><?php echo $mensaje ?></font></p>
			<?php } ?>
			</font></td>
          </tr>
          <tr>
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Copyright 
              2007 <strong>U.S.I.M.R.A.</strong> - Todos los derechos reservados</font></div></td>
          </tr>
        </table>
        </td>
    </tr>
  </table>
</body>
</html>
