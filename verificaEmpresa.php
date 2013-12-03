<?php session_save_path("sesiones");
session_start();
$datos = array_values($_POST);
include("lib/conexion.php");
$nrcuit = $datos [0];
$claveacc = $datos [1];

$sql = "select * from empresa where nrcuit = '$nrcuit' and claveacc = '$claveacc'";
$result = mysql_query($sql,$db);
$cant = mysql_num_rows($result);
if ($cant > 0) {
	$_SESSION['nrcuit'] = trim($nrcuit," ");
	$_SESSION['aut'] = 'pepepascual';
?>
	<script language=Javascript>
		window.open("home.php",'Aplicativo','resizable=YES, Scrollbars=YES, width=800,height=600, top=100, left=100');
	</script>
<?php
} else {
	session_unset();
	session_destroy();
	//header ('location:login.php?err=1');
}
?>


