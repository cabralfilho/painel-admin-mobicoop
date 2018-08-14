<?php
	session_start();

	if(!isset($_SESSION["usuario"])){
		header("location:login.php");
		break;
	}

	require_once("conecxao.php");

    $idPessoa = $_GET["idPessoa"];
    $idCota = $_POST["idCota"];

    
    if(isset($idPessoa) && isset($idCota)){
        $SQL = "INSERT INTO pessoasxcotas (idPessoa, idCota)";
        $SQL .= " VALUES({$idPessoa},{$idCota})";
        
        echo $SQL;
        $conectSQL = mysqli_query($conecta, $SQL);
        
        if(!$conectSQL){
            die("Erro ao inserir pessoaxcotas");
        }else{
            header("location:editar.php?idPessoa={$idPessoa}#listaCotas");
        }
        
    }
?>