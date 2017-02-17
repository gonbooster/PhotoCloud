<?php
	session_start();
	session_unset();
	session_destroy(); //destruir las sesiones
	header('Location: index.php');
?>