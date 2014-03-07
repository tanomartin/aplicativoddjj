<?php
$host = "localhost";
$user = "XXXXX";
$pass = "XXXXX";
$db = mysql_connect($host,$user,$pass);
mysql_select_db('ospimrem_aplicativo');
$nrcuit = $_SESSION['nrcuit'];

?>