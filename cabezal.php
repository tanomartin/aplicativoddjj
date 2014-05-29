<?php
$sql = "select * from empresa where nrcuit = '$nrcuit'";
$result = mysql_query($sql,$db);
$row = mysql_fetch_array($result);

$rconsu = $row['rramaa'];

$sqldesrama = "select * from rama where codram = '$rconsu'";
$rdesrama = mysql_query($sqldesrama,$db);
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
			if( strpos( $PagActual, $compara ) != false ) {   
				print("<div align='right'><a href='../cambioContrasenia.php'>Cambiar Contraseña</a></div>");
			} else {
				print("<div align='right'><a href='cambioContrasenia.php'>Cambiar Contraseña</a></div>");
			}
		  ?>
		  
		  
		  </td>
        </tr>
      </table>
        <table border="0" width="700">
          <tr>
            <td width="19%">
              <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><b>Nombre:</b></font></td>
            <td colspan="3">
              <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><?php echo $row['nombre']; ?></font></td>
          </tr>
          <tr>
            <td width="19%">
              <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><b>Domicilio:</b></font></td>
            <td colspan="3">
              <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><?php echo $row['domile']?></font></td>
          </tr>
          <tr>
            <td width="19%"><font face="Verdana" size="2"><b>Localidad:</b></font></td>
            <td width="27%"><font face="Verdana" size="2"><?php echo $row['locali']?></font></td>
            <td width="16%"><font face="Verdana" size="2"><b>Código Postal:</b></font></td>
            <td width="38%"><font face="Verdana" size="2"><?php echo $row['copole']?></font></td>
          </tr>
          <tr>
<?php $provincia = array ("PROVINCIA", "CAPITAL FEDERAL", "BUENOS AIRES", "MENDOZA", "NEUQUEN", "SALTA", "ENTRE RIOS", "MISIONES", "CHACO", "SANTA FE", "CORDOBA", "SAN JUAN", "RIO NEGRO", "CORRIENTES", "SANTA CRUZ", "CHUBUT", "FORMOSA", "LA PAMPA", "SANTIAGO DEL ESTERO", "JUJUY", "TUCUMAN", "TIERRA DEL FUEGO", "SAN LUIS", "LA RIOJA", "CATAMARCA");
$pro = $row["provin"];
?>		  
            <td width="19%"><font face="Verdana" size="2"><b>Provincia:</b></font></td>
            <td width="27%"><font face="Verdana" size="2"><?php echo $provincia [$pro] ?></font></td>
            
          <td width="16%"><font face="Verdana" size="2"><b>Actividad:</b></font></td>
            <td width="38%"><font face="Verdana" size="2"><?php echo $row['activi']?></font></td>
          </tr>
          <tr>
            <td width="19%"><p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"><b>CUIT:</b></font>
              <?php $cui01 = substr($row['nrcuit'],0,2);
$cui02 = substr($row['nrcuit'],2,8);
$cui03 = substr($row['nrcuit'],10,1);
?>
            </td>
            <td>
              <p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana" size="2"> <?php echo $cui01."-".$cui02."-".$cui03 ?></font></td>
            <td><font face="Verdana" size="2"><b>Rama:</b></font></td>
            <td width="38%"><font face="Verdana" size="2"><?php echo $resultado['descripcion']?></font></td>
          </tr>
</table>