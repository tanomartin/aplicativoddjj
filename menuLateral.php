<strong>
<a href="home.php">Home</a><br>
<a href="listaEmpleados.php">Listar Empleados</a><br>
<a href="altaEmpleado.php">Alta de Empleados</a><br>
<a href="modificacionEmpresa.php">Modificar Empresa</a><br>
<a href="listaddjjAnteriores.php">Realizar D.D.J.J.</a><br>
</strong>
<p>
<?php
$sqlLateral = "select * from habilita where nrcuit = '$nrcuit'";
$resLateral = mysql_query($sqlLateral,$db);
$rowLateral = mysql_fetch_array($resLateral);
if ($rowLateral['autori'] == "S") {
	print ("<font face=Verdana size=1><b><font color=#CF8B34><a href=modulog/menug.php>"."Módulo Grandes Empresas"."</font></b></font>");
}
?>
</p>