<?php
session_save_path("sesiones");
session_start();
session_unset();
session_destroy();
header ("Location: login.php");
?>