<?php
	session_start();
	unset($_SESSION["usuario"]);
	unset($_SESSION["pagina"]);
    unset($_SESSION["subPagina"]);
	header("location:login.php");

	mysqli_free_result();
?>