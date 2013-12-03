<?php
$host = "localhost";
$user = "ospimrem_charly";
$pass = "arce4651";
$db = mysql_connect($host,$user,$pass);
mysql_select_db('ospimrem_aplicativo');
$nrcuit = $_SESSION['nrcuit'];

?>