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
</head>


<?php
include("lib/conexion.php");
?>

<body bgcolor="#E4C192" link="#62641A" vlink="#62641A" alink="#CF8B34">
  <?php include("cabezal.php"); ?>
        <table border="0" width="700">
          <tr>
            
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>MODIFICAR 
              REGISTRO DE EMPLEADO</strong></font></div></td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><font color="#CF8B34"> <?php include("menuLateral.php"); ?> </p></td>
<?php
$nrcuil = $_GET['nrcuil'];
$sql = "select * from empleados where nrcuit = '$nrcuit' and nrcuil = '$nrcuil'";
$result = mysql_query($sql,$db);
$row=mysql_fetch_array($result);

$cui01 = substr($row['nrcuit'],0,2);
$cui02 = substr($row['nrcuit'],2,8);
$cui03 = substr($row['nrcuit'],10,1);
?>            
          <td width="516" valign="top"> <p><strong><font size="2" face="Arial, Helvetica, sans-serif">Datos 
              del Empleado:</font></strong></p>
 <form method="POST" action="grabamodificacionEmpleado.php">
            <table width="100%">
              <tr> 
                <?php
$cui01 = substr($row['nrcuit'],0,2);
$cui02 = substr($row['nrcuit'],2,8);
$cui03 = substr($row['nrcuit'],10,1);
?>
                <td width="217"><b><font face="Verdana" size="1">CUIT</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $cui01."-".$cui02."-".$cui03; ?></font></td>
              </tr>
              <tr> 
                <?php
$cuil01 = substr($row['nrcuil'],0,2);
$cuil02 = substr($row['nrcuil'],2,8);
$cuil03 = substr($row['nrcuil'],10,1);
?>



                <td width="217"><b><font face="Verdana" size="1">CUIL</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $cuil01."-".$cuil02."-".$cuil03; ?><input type=hidden name=a2 size=20 value="<?php echo $row['nrcuil'];?>"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Nombre</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><input type="text" name="T1" size="20" value="<?php echo $row['nombre']; ?>" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Apellido</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><input type="text" name="T2" size="20" value="<?php echo $row['apelli']; ?>" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 
                <?php
$fec01 = substr($row['fecing'],0,4);
$fec02 = substr($row['fecing'],5,2);
$fec03 = substr($row['fecing'],8,2);
  ?>
                <td width="217"><b><font face="Verdana" size="1">Fecha de Ingreso</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2">
<select size=1 name=R9>
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
<select size=1 name=R16>
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
/ <input type="text" name="T3" size="4" value="<?php echo $fec01;?>"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Tipo y Número 
                  de Documento</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2">
				<select size=1 name=D1>
    <option selected value="<?php echo $row['tipdoc'];?>"><?php echo $row['tipdoc'];?></option>
    <option value=DNI>DNI</option>
    <option value=LE>LE</option>
    <option value=LC>LC</option>
    <option value=CI>CI</option>
  </select>
<input name=T7 type=text value="<?php echo $row['nrodoc'];?>" size=15 maxlength="8">				
				
				
				
			</font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Sexo</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><select size=1 name=D2>
    <option selected value="<?php echo $row['ssexxo'];?>"><?php echo $row['ssexxo'];?></option>
    <option value=MASCULINO>MASCULINO</option>
    <option value=FEMENINO>FEMENINO</option>
  </select></font></td>
              </tr>
              <tr> 
                <?php
$fecn01 = substr($row['fecnac'],0,4);
$fecn02 = substr($row['fecnac'],5,2);
$fecn03 = substr($row['fecnac'],8,2);
?>
                <td width="217"><b><font face="Verdana" size="1">Fecha de Nacimiento</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2">
				
				<select size=1 name=R1>
          <option selected><?php echo $fecn03; ?></option>
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
          <option selected><?php echo $fecn02; ?></option>
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
/ <input name="T6" type="text" value="<?php echo $fecn01;?>" size="4" maxlength="4"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Estado Civil</font></b></td>
                <td width="298">
<select size=1 name=D3>
    <option selected value="<?php echo $row['estciv'];?>"><?php echo $row['estciv'];?></option>
    <option value=SOLTERO>SOLTERO</option>
    <option value=CASADO>CASADO</option>
    <option value=SEPARADO>SEPARADO</option>
    <option value=DIVORCIADO>DIVORCIADO</option>
    <option value=VIUDO>VIUDO</option>
  </select>				
				
				</td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Dirección</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T10" size="20" value="<?php echo $row['direcc']; ?>" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Localidad</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T11" size="20" value="<?php echo $row['locale']; ?>" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 
                <td width="217"><b><font face="Verdana" size="1">Código Postal</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif"><input type="text" name="T12" size="20" value="<?php echo $row['copole']; ?>" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 
                <?php $pro = $row["provin"]; ?>
                <td width="217"><b><font face="Verdana" size="1">Provincia</font></b></td>
                <td width="298"><font size="2" face="Arial, Helvetica, sans-serif">
<select name="D6" size="1" id="D6">
          <option selected value="<?php echo $pro;?>"><?php echo $provincia [$pro] ?></option>
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
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2"><input type="text" name="T13" size="20" value="<?php echo $row['nacion']; ?>" style="text-transform: uppercase"></font></td>
              </tr>
              <tr> 
      <?php
$cat = $row['catego'];
$sqll = "select * from categorias where codram = '$rconsu' and codcat = '$cat'";
$res = mysql_query($sqll,$db);	  
$pow=mysql_fetch_array($res);	  
	  
	  ?>
	  
	            <td width="217"><b><font face="Verdana" size="1">Categoría</font></b></td>
                <td width="298"><font face="Arial, Helvetica, sans-serif" size="2">
<select name=D7 size=1 id="D7">
    <option selected value="<?php echo $cat;?>"><?php echo $pow['descri'];?></option>

<?php
$sqll = "select * from categorias where codram = '$rconsu'";
$res = mysql_query($sqll,$db);

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
    <option selected value="<?php echo $row['activo'];?>"><?php echo $row['activo'];?></option>
    <option>SI</option>
    <option>NO</option>

  </select>				
</font></td>
              </tr>

            </table>
            <p align="left"></p>
<input type="submit" value="Ingresar" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37">
</form>
			<p>&nbsp;</p></td>

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
