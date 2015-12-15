<?PHP
	session_start();
	session_destroy();
	echo '<script>window.location = "/Consiment_Web/index.php";</script>';
?>