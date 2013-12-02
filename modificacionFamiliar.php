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
$sql = "select * from empresa where nrcuit = '$nrcuit'";
$result = mysql_query($sql,$db);
$row = mysql_fetch_array($result);
?>

<body bgcolor="#E4C192" link="#62641A" vlink="#62641A" alink="#CF8B34">
 	<?php include("cabezal.php"); ?>
        <table border="0" width="700">
          <tr>
            
          <td width="690" colspan="2" bgcolor="#CF8B34"><div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>GRUPO 
              FAMILIAR - MODIFICAR REGISTRO</strong></font></div></td>
          </tr>
          <tr>
            <td width="168" valign="top"><p><font face="Verdana" size="1"><b><font color="#CF8B34"><?php include("menuLateral.php"); ?></font></b></font></p></td>
            
<?php
$nrcuil = $_GET['nrcuil'];
$cuil01 = substr($nrcuil,0,2);
$cuil02 = substr($nrcuil,2,8);
$cuil03 = substr($nrcuil,10,1);
$sql = "select * from empleados where nrcuil = '$nrcuil' and nrcuit = '$nrcuit'";
$res = mysql_query($sql,$db);
$nom=mysql_fetch_array($res);
?>            
          <td width="516" valign="top"><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php echo $cuil01?>-<?php echo $cuil02?>-<?php echo $cuil03?>  <?php echo $nom['apelli'];?>, <?php echo $nom['nombre'];?></strong></font></p>
            <p> 
              <?php
			  	$id = $_GET['id'];
				$sql = "select * from familia where id = '$id'
				order by nrcuil,codpar,fecnac";
				$result = mysql_query($sql,$db);
				$row=mysql_fetch_array($result);
				?>


            </p>
            <form name="form1" method="post" action="grabamodificacionFamiliar.php?id=<?php echo $id;?>&nrcuil=<?php echo $nrcuil;?>">

            <table width="100%" border="0">
              <tr> 
                  <td width="37%"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nombre:</font></strong></td>
                <td width="63%"><input type="text" name="textfield" value="<?php echo $row['nombre'];?>" style="text-transform: uppercase"></td>
              </tr>
              <tr> 
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Apellido:</font></strong></td>
                <td><input type="text" name="textfield2" value="<?php echo $row['apelli'];?>" style="text-transform: uppercase"></td>
              </tr>
              <tr> 
                  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Parentesco:</font></strong></td>
                  <td>
<select size=1 name=D3>
    <option selected value="<?php echo $row['codpar'];?>"><?php echo $row['codpar'];?></option>
    <option>CONYUGE</option>
    <option>CONCUBINO</option>
    <option>FAMILIAR A CARGO</option>
    <option>HIJO</option>
</select>				  
				  </td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Sexo:</font></strong></td>
                  <td>
<select size=1 name=D2>
    <option selected value="<?php echo $row['ssexxo'];?>"><?php echo $row['ssexxo'];?></option>
    <option value=MASCULINO>MASCULINO</option>
    <option value=FEMENINO>FEMENINO</option>
</select>				  
				  </td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
                  de Nacimiento:</font></strong></td>
                  <td>
<?php
$fecn01 = substr($row['fecnac'],0,4);
$fecn02 = substr($row['fecnac'],5,2);
$fecn03 = substr($row['fecnac'],8,2);
?>
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
/ <input name="T6" type="text" value="<?php echo $fecn01;?>" size="4" maxlength="4"></font>				  
				  </td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
                  de Ingreso:</font></strong></td>
                  <td>
                <?php
$fec01 = substr($row['fecing'],0,4);
$fec02 = substr($row['fecing'],5,2);
$fec03 = substr($row['fecing'],8,2);
  ?>
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
/ <input name="T3" type="text" value="<?php echo $fec01;?>" size="4" maxlength="4"></font>				  
				  </td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Tipo 
                  y Nro. de Documento:</font></strong></td>
                  <td>
<select size=1 name=D1>
    <option selected value="<?php echo $row['tipdoc'];?>"><?php echo $row['tipdoc'];?></option>
    <option value=DNI>DNI</option>
    <option value=LE>LE</option>
    <option value=LC>LC</option>
    <option value=CI>CI</option>
  </select>
<input name=T7 type=text value="<?php echo $row['nrodoc']?>" size=15 maxlength="8">

</td>
              </tr>
              <tr> 
                <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Beneficiario:</font></strong></td>
                  <td>
<select name=D89 size=1 id="D89">
    <option selected value="<?php echo $row['benefi']; ?>"><?php echo $row['benefi']; ?></option>
    <option>SI</option>
    <option>NO</option>
  </select>				  
				  </td>
              </tr>
            </table>
<input type="submit" value="Ingresar" name="B1" style="background-color: #E4C192; border-style: solid; border-color: #D28E37">			
 </form>
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
