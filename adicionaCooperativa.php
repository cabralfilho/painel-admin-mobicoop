<?php
	session_start();

	if(!isset($_SESSION["usuario"])){
		header("location:login.php");
		break;
	}

	require_once("conecxao.php");

    $idPessoa = $_GET["idPessoa"];
    $idCooperativa = $_POST["idCooperativa"];

    
    if(isset($idPessoa) && isset($idCooperativa)){
        $SQL = "INSERT INTO pessoasxcooperativas (idPessoa, idCooperativa)";
        $SQL .= " VALUES({$idPessoa},{$idCooperativa})";
        
        echo $SQL;
        $conectSQL = mysqli_query($conecta, $SQL);
        
        if(!$conectSQL){
            die("Erro ao inserir pessoaxcooperativa");
        }else{
            header("location:editar.php?idPessoa={$idPessoa}#listaCooperativas");
        }
        
    }
?>