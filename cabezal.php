<?php
$sql = "select * from empresa where nrcuit = '$nrcuit'";
$result = mysql_db_query("uv0472_aplicativo",$sql,$db);
$row = mysql_fetch_array($result);

$rconsu = $row['rramaa'];

$sqldesrama = "select * from ramas where codram = '$rconsu'";
$rdesrama = mysql_db_query("uv0472_aplicativo",$sqldesrama,$db);
$resultado = mysql_fetch_array($rdesrama);

?>
 <p align="center"><img border="0" src="img/top.jpg" width="700" height="120"></p>
 <table border="0" width="100%">
    <tr>
      <td width="100%" align="center"><table width="700" border="0">
        <tr>
          <td>
		   <?php
		  	$PagActual = $_SERVER['PHP_SELF'];  
			$compara = "menug.php";
		  	if( strpos( $PagActual, $compara ) != false ) {   
				print("<div align='right'><a href='../logout.php'>SALIR</a></div>");
			} else {
				print("<div align='right'><a href='logout.php'>SALIR</a></div>");
			}
		   	print("<div align='right'><a href='cambioContrasenia.php'>Cambiar Contrase�a</a></div>");
		  ?>
		  
		  
		  </td>
        </tr>
      </table>
        <table border="0" width="700">
          <tr>
            <td width="19%">
              <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><b>Nombre:</b></font></td>
            <td colspan="3">
              <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><? echo $row['nombre']; ?></font></td>
          </tr>
          <tr>
            <td width="19%">
              <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><b>Domicilio:</b></font></td>
            <td colspan="3">
              <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><? echo $row['domile']?></font></td>
          </tr>
          <tr>
            <td width="19%"><font face="Verdana" size="2"><b>Localidad:</b></font></td>
            <td width="27%"><font face="Verdana" size="2"><? echo $row['locali']?></font></td>
            <td width="16%"><font face="Verdana" size="2"><b>C�digo Postal:</b></font></td>
            <td width="38%"><font face="Verdana" size="2"><? echo $row['copole']?></font></td>
          </tr>
          <tr>
<?
$provincia = array ("PROVINCIA", "CAPITAL FEDERAL", "BUENOS AIRES", "MENDOZA", "NEUQUEN", "SALTA", "ENTRE RIOS", "MISIONES", "CHACO", "SANTA FE", "CORDOBA", "SAN JUAN", "RIO NEGRO", "CORRIENTES", "SANTA CRUZ", "CHUBUT", "FORMOSA", "LA PAMPA", "SANTIAGO DEL ESTERO", "JUJUY", "TUCUMAN", "TIERRA DEL FUEGO", "SAN LUIS", "LA RIOJA", "CATAMARCA");
$pro = $row["provin"];
?>		  
            <td width="19%"><font face="Verdana" size="2"><b>Provincia:</b></font></td>
            <td width="27%"><font face="Verdana" size="2"><? echo $provincia [$pro] ?></font></td>
            
          <td width="16%"><font face="Verdana" size="2"><b>Actividad:</b></font></td>
            <td width="38%"><font face="Verdana" size="2"><? echo $row['activi']?></font></td>
          </tr>
          <tr>
            <td width="19%"><p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><b>CUIT:</b></font>
              <?
$cui01 = substr($row['nrcuit'],0,2);
$cui02 = substr($row['nrcuit'],2,8);
$cui03 = substr($row['nrcuit'],10,1);
?>
            </td>
            <td>
              <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"> <? echo $cui01."-".$cui02."-".$cui03 ?></font></td>
            <td><font face="Verdana" size="2"><b>Rama:</b></font></td>
            <td width="38%"><font face="Verdana" size="2"><? echo $resultado['descri']?></font></td>
          </tr>
</table>