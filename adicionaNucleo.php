<?php
	session_start();

	if(!isset($_SESSION["usuario"])){
		header("location:login.php");
		break;
	}

	require_once("conecxao.php");

    $idPessoa = $_GET["idPessoa"];
    $idNucleo = $_POST["idNucleo"];

    
    if(isset($idPessoa) && isset($idNucleo)){
        $SQL = "INSERT INTO pessoasxnucleos (idPessoa, idNucleo)";
        $SQL .= " VALUES({$idPessoa},{$idNucleo})";
        
        echo $SQL;
        $conectSQL = mysqli_query($conecta, $SQL);
        
        if(!$conectSQL){
            die("Erro ao inserir pessoaxcooperativa");
        }else{
            header("location:editar.php?idPessoa={$idPessoa}#listaNucleos");
        }
        
    }
?>