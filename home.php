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
El día 3 de diciembre, nos encontramos con la novedad de que el aplicativo no estaba funcionando adecuadamente. El problema tuvo carácter generalizado, todas las empresas que ingresaron al aplicativo experimentaron la misma situación. El inconveniente tuvo su origen en la manipulación de los servidores, en donde alojamos la base de datos y el aplicativo, sin previo aviso por parte de la empresa que provee el servicio de hosting. El departamento de sistemas tomo conocimiento de la situación a partir de los llamados telefónicos y emails recibidos de parte de los usuarios del aplicativo, lo que nos avoco de manera inmediata a la investigación del origen del problema. Detectado el mismo, se procedió a dar de baja el acceso al aplicativo y a trabajar de manera denodada en la protección y consolidación de la información alojada en la base de datos y en los ajustes de todos los módulos que componen el sistema, a la nueva realidad planteada por los cambios de servidores. El esfuerzo en la solución del problema nos permitió volver a dejar el aplicativo parcialmente operativo antes de las 18:00 hs. del mismo día y definitivamente operativo el día 6 de diciembre. Un posterior trabajo analítico y comparativo nos permite aseverar que en el 100% de los casos, las boletas de pago generadas están completamente respaldadas, por lo cual no corre riesgo la imputación en la cuenta corriente de cada usuario (empresa). Pero el 3,37% de los usuarios (24 empresas sobre un universo de 8094) han quedado afectados en el detalle de las declaraciones juradas generadas entre los días <font color=#FF0000>26/11/2013</font> y <font color=#FF0000>28/11/2013</font>. Este es el caso para su C.U.I.T., por lo cual estamos procediendo a esta comunicación en forma personalizada. Reiteramos que NO están en riesgo los pagos ingresados con las boletas generadas esos días, ni la imputación respectiva en su cuenta corriente, pero podrá notar que los periodos relacionados a las declaraciones juradas objeto de las boletas generadas por Ud. esos dos días, no tendrán el detalle asociado a su conformación (ausencia de valores de remuneración y alícuotas de aportes por C.U.I.L.)";
					$rowAviso = mysql_fetch_assoc($resAviso);
					$perdioPeridodo = $rowAviso['periodo'];
					if ($perdioPeridodo == 1) {	
						$mensaje = $mensaje.", ni la identificación del mes pertinente (designación nominal de meses superiores a 40)";
			 	    }
					$mensaje = $mensaje.". Por esto,  el departamento de sistemas le ofrece la posibilidad de reconstruir puntualmente esos detalles a partir de la información que Ud. pueda proveer, para lo cual, abrimos de esta manera un canal de comunicación directa con Ud. a través de la siguiente dirección de correo electrónico: <font color=#0033FF> sistemas@usimra.com.ar</font>. Le solicitamos, si fuese de su interés, que envié un email a esa dirección, identificando a la empresa por su C.U.I.T. y razón social, y especificando, además, el nombre y apellido de una persona de contacto directo y un numero telefónico por si fuera necesaria alguna comunicación personal.<br><br> 
Esperando que pueda ser comprendido que fuimos ajenos a la situación provocada, solicitando desde ya las disculpas pertinentes y agradeciendo de antemano la predisposición y paciencia de vuestra parte, dejamos saludos cordiales y quedamos a disposición para cualquier inquietud planteada al respecto.<br><br>"?>
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
