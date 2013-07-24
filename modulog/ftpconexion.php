<?
$ftp_server='ftp.usimra.com.ar';// 
$conectamosftp = ftp_connect($ftp_server);  

$user = "uv0472";
$pass = "trozo299tabea";
$conectar = ftp_login($conectamosftp, $user, $pass);  

?>