<html>

<head>

<style>
<!--
A:link {text-decoration: none}
A:visited {text-decoration: none}
A:hover {text-decoration:underline; color:FCF63C}
-->
</style>
<title>.: U.S.I.M.R.A. :.</title>
<script>
function valida_envia(){ 
    //valido el cuit01 
    if (document.fvalida.T2.value.length==0){ 
       alert("Tiene que ingresar el CUIT correctamente") 
       document.fvalida.T2.focus() 
       return false; 
    } 
    //valido el cuit02 
    if (document.fvalida.T12.value.length==0){ 
       alert("Tiene que ingresar el CUIT correctamente") 
       document.fvalida.T12.focus() 
       return false; 
    } 
        //valido el cuit03 
    if (document.fvalida.T13.value.length==0){ 
       alert("Tiene que ingresar el CUIT correctamente") 
       document.fvalida.T13.focus() 
       return false; 
    }     
    //valido el nombre 
    if (document.fvalida.T3.value.length==0){ 
       alert("Tiene que ingresar el Nombre") 
       document.fvalida.T3.focus() 
       return false; 
    } 

    //valido el domicilio 
    if (document.fvalida.T4.value.length==0){ 
       alert("Tiene que ingresar el Domicilio") 
       document.fvalida.T4.focus() 
       return false; 
    } 
        //valido el Localidad 
    if (document.fvalida.T5.value.length==0){ 
       alert("Tiene que ingresar su Localidad ") 
       document.fvalida.T5.focus() 
       return false; 
    } 
        //valido el Codigo 
    if (document.fvalida.T6.value.length==0){ 
       alert("Tiene que ingresar su Código Postal") 
       document.fvalida.T6.focus() 
       return false; 
    } 
        //valido el Email 
    if (document.fvalida.T7.value.length==0){ 
       alert("Tiene que ingresar su Email") 
       document.fvalida.T7.focus() 
       return false; 
    } 
        //valido la fecha 
    if (document.fvalida.T17.value.length==0){ 
       alert("Tiene que ingresar la Fecha de Inicio") 
       document.fvalida.T17.focus() 
       return false; 
    } 
        //valido el pass 
    if (document.fvalida.T11.value.length==0){ 
       alert("Tiene que ingresar su Contraseña") 
       document.fvalida.T11.focus() 
       return false; 
    } 



} 
</script>

<STYLE>BODY {SCROLLBAR-FACE-COLOR: #E4C192; 
SCROLLBAR-HIGHLIGHT-COLOR: #CD8C34; 
SCROLLBAR-SHADOW-COLOR: #CD8C34; 
SCROLLBAR-3DLIGHT-COLOR: #CD8C34; 
SCROLLBAR-ARROW-COLOR: #CD8C34; 
SCROLLBAR-TRACK-COLOR: #CD8C34; 
SCROLLBAR-DARKSHADOW-COLOR: #CD8C34
}
</STYLE>
</head>

<body bgcolor="#E4C192">
  <p align="center"><img border="0" src="img/top.jpg" width="700" height="120"></p>
  <p>&nbsp;</p>
<form name="fvalida" method="POST" action="verificaDatosEmpresa.php" onSubmit="javascript:return valida_envia();">

<table  width="800" align="center" border="1" width="100%" bordercolorlight="#D08C35" bordercolordark="#D08C35" bordercolor="#CD8C34"cellpadding="2" cellspacing="0">    
	
<tr>    
    <td width="690" colspan="4" bgcolor="#CF8B34">
	<div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>REGISTRO DE NUEVA EMPRESA</strong></font></div>
	</td>
</tr>
<tr>
	<td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><b>Nro. de CUIT</b></font></p>
    </td>
	<td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><input type="text" name="T2" size="4" maxlength="2" style="background-color: #E4C192">-<input type="text" name="T12" size="8" maxlength="8"style="background-color: #E4C192">-<input type="text" name="T13" size="3" maxlength="1" style="background-color: #E4C192"></font></p>
     </td>
     <td width="20%">&nbsp;</td>
     <td width="20%">&nbsp;</td>
</tr>
	
<tr>
      <td width="25%">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">
<font face="Verdana" size="2"><b>Nombre o Razón Social</b></font></p>
      </td>
      <td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><input type="text" name="T3" size="20" maxlength="100" style="background-color: #E4C192; text-transform: uppercase"></font></p>
      </td>
      <td width="20%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
</tr>

<tr>
      <td width="25%">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">
<font face="Verdana" size="2"><b>Domicilio</b></font></p>
      </td>
      <td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><input type="text" name="T4" size="20" maxlength="50" style="background-color: #E4C192; text-transform: uppercase"></font></p>
      </td>
      <td width="20%">&nbsp;</td>
      <td width="20%">&nbsp;</td>
</tr>

<tr>
      <td width="25%">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">
<font face="Verdana" size="2"><b>Localidad</b></font></p>
      </td>
      <td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><input type="text" name="T5" size="20" maxlength="50" style="background-color: #E4C192; text-transform: uppercase"></font></p>
      </td>
      <td width="20%">
<font face="Verdana" size="2"><b>Provincia</b></font></td>
      <td width="30%"><font face="Verdana" size="2"><select size="1" name="D1" style="font-family: Verdana; font-size: 8 pt; font-weight: bold; background-color: #E4C192">
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
        </select></font>
		</td>
</tr>
<tr>
      <td width="25%">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">
<font face="Verdana" size="2"><b>Código Postal</b></font></p>
      </td>
      <td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><input type="text" name="T6" size="20" maxlength="8" style="background-color: #E4C192; text-transform: uppercase"></font></p>
      </td>
      <td width="20%">
<font face="Verdana" size="2"><b>Teléfono</b></font></td>
      <td width="30%"><font face="Verdana" size="2"><b>( <input type="text" name="T10" size="3" maxlength="5" style="background-color: #E4C192">
        ) <input type="text" name="T14" size="3" maxlength="4" style="background-color: #E4C192">-<input type="text" name="T15" size="3" maxlength="4" style="background-color: #E4C192"></b></font></td>
</tr>

<tr>
      <td width="25%">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">
<font face="Verdana" size="2"><b>Email</b></font></p>
      </td>
      <td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><input type="text" name="T7" size="20" maxlength="60" style="background-color: #E4C192"></font></p>
      </td>
      <td width="20%">&nbsp;</td>
      <td width="30%"><font face="Verdana" size="2">ej. (011) 4431-4089</font></td>
</tr>

<tr>
      <td width="25%">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">
<font face="Verdana" size="2"><b>Actividad</b></font></p>
      </td>
      <td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><select size="1" name="D2" style="font-family: Verdana; font-size: 8 pt; font-weight: bold; background-color: #E4C192">
          <option>Aberturas</option>
          <option>Aglomerados</option>
          <option>Articulos Deportivos</option>
          <option>Articulos para la Enseñanza</option>
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
          <option>Elaboracion de Carbon y Leña</option>
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
          <option>Otros</option>
        </select></font></p>
      </td>
      <td width="20%"><font face="Verdana" size="2"><b>&nbsp;Fecha de Inicio</b></font></td>
      <td width="30%"><font face="Verdana" size="2"><b><select size="1" name="T9" style="font-family: Verdana; font-size: 8 pt; font-weight: bold; background-color: #E4C192">
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
        </select>/<select size="1" name="T16" style="font-family: Verdana; font-size: 8 pt; font-weight: bold; background-color: #E4C192">
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
        </select>/<input type="text" name="T17" size="4" maxlength="4" style="background-color: #E4C192"></b></font>
		</td>
</tr>

<tr>
      <td width="25%">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><b>Rama</b></font></p>
      </td>
      <td width="75%" colspan="3">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><select size="1" name="D3" style="font-family: Verdana; font-size: 8 pt; font-weight: bold; background-color: #E4C192">
          <option value="1">Aglomerados</option>
          <option value="2">Maderas Terciadas</option>
          <option value="3">Aserraderos, Envases y Afines</option>
          <option value="4">Muebles, Aberturas, Carpinterías y Demás
          Manufacturas de Madera y Afines</option>
          <option value="5">Corcho</option>
          <option value="6">Otros</option>
        </select></font></p>
      </td>
</tr>

<tr>
      <td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><b>Contraseña</b></font></p>
      </td>
      <td width="25%">
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><input name="T11" size="20" maxlength="10" style="background-color: #E4C192"></font></p>
        <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="1"><b>(10
        carateres máximo)</b></font></p>
      </td>
      <td width="20%">&nbsp;</td>
      <td width="30%">&nbsp;</td>
</tr>
</table>

  <p align="center">
  <input type="submit" value="Enviar" name="B1" style="background-color: #DEAA63; border-style: solid; border-color: #D5913A">
  <input type="reset" value="Restablecer" name="B2" style="background-color: #DEAA63; border-style: solid; border-color: #D79540">
  </p>
</form>
<p align="center">
<br>
<a href="login.php"><font color="#CD8C34" face="Verdana" size="2"><b>Volver</b></font></a>
<br>
</p>

</body>

</html>
