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


<body bgcolor="#E4C192" link="#62641A" vlink="#62641A" alink="#CF8B34">
 		<?php include("cabezal.php"); ?>
        <table border="0" width="700">
          <tr>
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>DATOS DE EMPRESA</strong></font></div></td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1" color="#CF8B34"><?php include("menuLateral.php");  ?></p></td>
            <td width="516" valign="top"><p>&nbsp;</p>
            <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>Datos de la Empresa </strong></font></p>
            <form name="form1" method="post" action="grabamodificacionEmpresa.php">
              <table width="100%" border="0">
                <tr> 
                  <td width="45%"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nombre</font></strong></td>
                  <td width="55%"><strong><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T1" size="30" value="<?php echo $row['nombre']; ?>" style="text-transform: uppercase"></font></strong></td>
                </tr>
                <tr> 
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Domicilio</font></strong></td>
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T2" size="30" value="<?php echo $row['domile']; ?>" style="text-transform: uppercase"></font></strong></td>
                </tr>
                <tr> 
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Localidad</font></strong></td>
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T3" size="30" value="<?php echo $row['locali']; ?>" style="text-transform: uppercase"></font></strong></td>
                </tr>
                <tr> 
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Provincia</font></strong></td>
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                    <select name="D6" size="1" id="D6">
                      <option selected value="<?php echo $pro; ?>"><?php echo $provincia [$pro]; ?></option>
                      <option value="1">CAPITAL FEDERAL</option>
                      <option value="2">BUENOS AIRES</option>
                      <option value="3">MENDOZA</option>
                      <option value="4">NEUQUEN</option>
                      <option value="5">SALTA</option>
                      <option value="6">ENTRE RIOS</option>
                      <option value="7">MISIONES</option>
                      <option value="8">CHACO</option>
                      <option value="9">SANTA FE</option>
                      <option value="10">CORDOBA</option>
                      <option value="11">SAN JUAN</option>
                      <option value="12">RIO NEGRO</option>
                      <option value="13">CORRIENTES</option>
                      <option value="14">SANTA CRUZ</option>
                      <option value="15">CHUBUT</option>
                      <option value="16">FORMOSA</option>
                      <option value="17">LA PAMPA</option>
                      <option value="18">SANTIAGO DEL ESTERO</option>
                      <option value="19">JUJUY</option>
                      <option value="20">TUCUMAN</option>
                      <option value="21">TIERRA DEL FUEGO</option>
                      <option value="22">SAN LUIS</option>
                      <option value="23">LA RIOJA</option>
                      <option value="24">CATAMARCA</option>
                    </select>
                    </font></strong></td>
                </tr>
                <tr> 
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">C&oacute;digo 
                    Postal</font></strong></td>
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T4" size="10" value="<?php echo $row['copole']; ?>" style="text-transform: uppercase"></font></strong></td>
                </tr>
                <tr> 
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Tel&eacute;fono</font></strong></td>
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T5" size="20" value="<?php echo $row['telfon']; ?>" style="text-transform: uppercase"></font></strong></td>
                </tr>
                <tr> 
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">E-mail</font></strong></td>
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T6" size="30" value="<?php echo $row['emails']; ?>"></font></strong></td>
                </tr>
                <tr> 
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Actividad</font></strong></td>
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                  
<select size="1" name="textfield8" >
                      <option>Aberturas</option>
                      <option>Aglomerados</option>
                      <option>Articulos Deportivos</option>
                      <option>Articulos para la Ense&ntilde;anza</option>
                      <option>Aserradero</option>
                      <option>Ataudes</option>
                      <option>Bancos y Pupitres</option>
                      <option>Carpinteria en General</option>
                      <option>Carretes y Bobinas</option>
                      <option>Casas y Casillas Prefabricadas</option>
                      <option>Colocaciones e Instalaciones</option>
                      <option>Corcho</option>
                      <option>Corralones</option>
                      <option>Deposito y/o Venta de Maderas</option>
                      <option>Elaboracion de Carbon y Le&ntilde;a</option>
                      <option>Elementos para la Construccion</option>
                      <option>Embalajes</option>
                      <option>Encofrados</option>
                      <option>Envases</option>
                      <option>Escaleras</option>
                      <option>Escobas</option>
                      <option>Estuches</option>
                      <option>Fabricacion y/o Venta de Muebles</option>
                      <option>Fibras para la Industria del Papel</option>
                      <option>Herramientas</option>
                      <option>Instrumentos Musicales</option>
                      <option>Lustrado</option>
                      <option>Molduras</option>
                      <option>Pallets</option>
                      <option>Parquets</option>
                      <option>Pisos</option>
                      <option>Plataformas</option>
                      <option>Revestimientos</option>
                      <option>Tableros</option>
                      <option>Tallado</option>
                      <option>Tapiceria</option>
                      <option>Torneria</option>
                      <option>Utiles Escolares</option>
                      <option selected><?php echo $row['activi']; ?></option>
                      <option>Otros</option>
                    </select>                    
					</font></strong></td>
                </tr>
                <tr> 
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
                    de Inicio</font></strong></td>
                  <td> <strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                    <?php
$fec01 = substr($row['fecini'],0,4);
$fec02 = substr($row['fecini'],5,2);
$fec03 = substr($row['fecini'],8,2);
?>
                    <select size=1 name=R1>
                      <option selected><?php echo $fec03; ?></option>
                      <option>01</option>
                      <option>02</option>
                      <option>03</option>
                      <option>04</option>
                      <option>05</option>
                      <option>06</option>
                      <option>07</option>
                      <option>08</option>
                      <option>09</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                      <option>21</option>
                      <option>22</option>
                      <option>23</option>
                      <option>24</option>
                      <option>25</option>
                      <option>26</option>
                      <option>27</option>
                      <option>28</option>
                      <option>29</option>
                      <option>30</option>
                      <option>31</option>
                    </select>
                    / 
                    <select size=1 name=R2>
                      <option selected><?php echo $fec02; ?></option>
                      <option>01</option>
                      <option>02</option>
                      <option>03</option>
                      <option>04</option>
                      <option>05</option>
                      <option>06</option>
                      <option>07</option>
                      <option>08</option>
                      <option>09</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                    </select>
                    / 
                    <input name="T7" type="text" value="<?php echo $fec01; ?>" size="4" maxlength="4">
                    </font></strong></td>
                </tr>
              </table>
			<input type="submit" value="Modificar" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37">
              </form>
            <p>&nbsp;</p>
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
