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
<script>
function valida_envia(){ 
    //valido el cuit01 
    if (document.fvalida.a2.value.length==0){ 
       alert("Tiene que ingresar el CUIL correctamente") 
       document.fvalida.a2.focus() 
       return false; 
    } 
    //valido el cuit02 
    if (document.fvalida.a22.value.length==0){ 
       alert("Tiene que ingresar el CUIL correctamente") 
       document.fvalida.a22.focus() 
       return false; 
    } 
        //valido el cuit03 
    if (document.fvalida.a23.value.length==0){ 
       alert("Tiene que ingresar el CUIL correctamente") 
       document.fvalida.a23.focus() 
       return false; 
    }     
    //valido el nombre 
    if (document.fvalida.T1.value.length==0){ 
       alert("Tiene que ingresar el Nombre") 
       document.fvalida.T1.focus() 
       return false; 
    } 

    //valido el apellido 
    if (document.fvalida.T2.value.length==0){ 
       alert("Tiene que ingresar el Apellido") 
       document.fvalida.T2.focus() 
       return false; 
    } 
        //valido la Fecha de ingreso 
    if (document.fvalida.T3.value.length==0){ 
       alert("Tiene que ingresar la Fecha de Ingreso ") 
       document.fvalida.T3.focus() 
       return false; 
    } 
        //valido el DOC 
    if (document.fvalida.T7.value.length==0){ 
       alert("Tiene que ingresar el Nro. de Documento") 
       document.fvalida.T7.focus() 
       return false; 
    } 
        //valido la Fecha de Nacimiento 
    if (document.fvalida.T6.value.length==0){ 
       alert("Tiene que ingresar la Fecha de Nacimiento") 
       document.fvalida.T6.focus() 
       return false; 
    } 
        //valido la direccion 
    if (document.fvalida.T10.value.length==0){ 
       alert("Tiene que ingresar la Dirección") 
       document.fvalida.T10.focus() 
       return false; 
    } 
        //valido la localidad 
    if (document.fvalida.T11.value.length==0){ 
       alert("Tiene que ingresar la Localidad") 
       document.fvalida.T11.focus() 
       return false; 
    } 
		//valido el CP    
	if (document.fvalida.T12.value.length==0){ 
       alert("Tiene que ingresar Código Postal") 
       document.fvalida.T12.focus() 
       return false; 
    } 
    	//valido la nacionalidad
	if (document.fvalida.T13.value.length==0){ 
       alert("Tiene que ingresar la Nacionalidad") 
       document.fvalida.T11.focus() 
       return false; 
    } 	


} 
</script>
</head>


<?php
include("lib/conexion.php");
$sql = "select * from empresa where nrcuit = '$nrcuit'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$row = mysql_fetch_array($result);
$rama = $row['rramaa'];


?>

<body bgcolor="#E4C192" link="#62641A" vlink="#62641A" alink="#CF8B34">
	 <?php include("cabezal.php"); ?>
        <table border="0" width="700">
          <tr>
            
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>CARGAR 
              NUEVO REGISTRO DE EMPLEADO</strong></font></div></td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><font color="#CF8B34"><?php include("menuLateral.php"); ?></font></p></td>
          <td width="516" valign="top"> <p><strong><font size="2" face="Arial, Helvetica, sans-serif">Datos 
              del Empleado:</font></strong></p>
            <?php 
				$err = $_GET['err'];
				if ($err == 1) {
					print("<p><font color='#CD8C34' face='Verdana' size='2'><b>CUIL inválido</b></font></p>");
				}
			?>
			
            <form name="fvalida" method="POST" action="grabaEmpleado.php" onSubmit="javascript:return valida_envia();">
            <table width="100%">
              <tr> 

                <td width="217"><b><font face="Verdana" size="1">CUIT</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><? echo $cui01."-".$cui02."-".$cui03; ?></font></td>
              </tr>
              <tr> 




                <td width="217"><b><font face="Verdana" size="1">CUIL</font></b></td>
                  <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"> 
                    <strong> 
                    <input name="a2" type="text" size="2" maxlength="2">
                    - 
                    <input name="a22" type="text" size="10" maxlength="8">
                    - 
                    <input name="a23" type="text" size="2" maxlength="1">
                    </strong> </font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Nombre</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><input type="text" name="T1" size="20" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Apellido</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><input type="text" name="T2" size="20" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 

                <td width="217"><b><font face="Verdana" size="1">Fecha de Ingreso</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2">
<select size=1 name=R9>
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
<select size=1 name=R16>
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
/ <input name="T3" type="text" size="4" maxlength="4"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Tipo y Número 
                  de Documento</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2">
				<select size=1 name=D1>
                      <option value="DNI">DNI</option>
                      <option value="LE">LE</option>
                      <option value="LC">LC</option>
                      <option value="CI">CI</option>
                </select>
<input name=T7 type=text size=15 maxlength="8">				
				
				
				
			</font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Sexo</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><select size=1 name=D2>
                      <option value="MASCULINO">MASCULINO</option>
                      <option value="FEMENINO">FEMENINO</option>
                    </select></font></td>
              </tr>
              <tr> 

                <td width="217"><b><font face="Verdana" size="1">Fecha de Nacimiento</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2">
				
				<select size=1 name=R1>
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
/ <input name="T6" type="text" size="4" maxlength="4"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Estado Civil</font></b></td>
                <td width="298">
<select size=1 name=D3>
                      <option value="SOLTERO">SOLTERO</option>
                      <option value="CASADO">CASADO</option>
                      <option value="SEPARADO">SEPARADO</option>
                      <option value="DIVORCIADO">DIVORCIADO</option>
                      <option value="VIUDO">VIUDO</option>
                  </select>				
				
				</td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Dirección</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T10" size="20" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Localidad</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T11" size="20" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Código Postal</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T12" size="20" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 

                <td width="217"><b><font face="Verdana" size="1">Provincia</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif">
<select name="D6" size="1" id="D6">
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
</font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Nacionalidad</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><input type="text" name="T13" size="20" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 

	  
	            <td width="217"><b><font face="Verdana" size="1">Categoría</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2">
<?php
$sqll = "select * from categorias where codram = '$rama'";
$res = mysql_db_query("uv0472_aplicativo",$sqll,$db);
//$row = mysql_fetch_array($result);
?>
<select name=D7 size=1 id="D7">
<?php
 while ($pow=mysql_fetch_array($res)) {
?>
<option value="<?php echo $pow['codcat'];?>"><?php echo $pow['descri'];?></option> 
<?php
}
?>
</select>				
				
				
				
				</font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Activo</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2">
<select size=1 name=D8>
                      <option>SI</option>
                      <option>NO</option>
                </select>				
</font></td>
              </tr>

        </table>
            <input type="submit" value="Ingresar" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37">
 </form>
			</td>

          </tr>
          <tr>
            
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Copyright 
              2007 <strong>U.S.I.M.R.A.</strong> - Todos los derechos reservados</font></div></td>
          </tr>
</table>
        </body>

</html>
