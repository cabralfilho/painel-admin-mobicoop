<?php 

	$servidor = "localhost";
	$usuario = "root";
	$senha = "";
	$banco = "mobicoop";

	$conecta = mysqli_connect($servidor,$usuario,$senha,$banco);

	if(mysqli_connect_errno()){
		die("Conecção Falhou ".mysqli_connect_errno());
	}
?>