<?php
//testa Login
	session_start();

	if(!isset($_SESSION["usuario"])){
		header("location:login.php");
		break;
	}

	$_SESSION["pagina"] = "usuarios";
    $_SESSION["subPagina"] = "cadastroUsuario";


//buscas no banco
	require_once("conecxao.php");
    require_once("funcoes.php");
    $estados = mysqli_query($conecta,"SET NAMES 'utf8'");

//'função' para editar dados

    if(isset($_POST["nomePessoa"])){
        $nomePessoa = $_POST["nomePessoa"];
        $cpfPessoa = $_POST["cpfPessoa"];
        
        if(!validaCpf($cpfPessoa)){
            die("CPF Inválido");
        }
        $emailPessoa = $_POST["emailPessoa"];
        $telefonePessoa = $_POST["telefonePessoa"];
        $ufPessoa = $_POST["estadoPessoa"];
        $municipioPessoa = $_POST["municipioPessoa"];
        $bairroPessoa = $_POST["bairroPessoa"];
        $logradouroPessoa = $_POST["logradouroPessoa"];
        $numeroPessoa = $_POST["numeroPessoa"];
        $complementoPessoa = $_POST["complementoPessoa"];

        $insertSQL = "INSERT INTO `pessoas`(`NOME`, `CPF`, `EMAIL`, `SENHA`,`TELEFONE`, `IDUF`, `IDMUNICIPIO`, `BAIRRO`, `LOGRADOURO`, `NUMERO`, `COMPLEMENTO`, `CONSULTOR`, `PRECADASTRADO`, `COOPERADO`)";
        
        $insertSQL .= " VALUES (";
        $insertSQL .= " '{$nomePessoa}',";
        $insertSQL .= " '{$cpfPessoa}',";
        $insertSQL .= " '{$emailPessoa}', '',";
        $insertSQL .= " '{$telefonePessoa}',";
        $insertSQL .= " {$ufPessoa},";
        $insertSQL .= " {$municipioPessoa},";
        $insertSQL .= " '{$bairroPessoa}',";
        $insertSQL .= " '{$logradouroPessoa}',";
        $insertSQL .= " '{$numeroPessoa}',";
        $insertSQL .= " '{$complementoPessoa}',";

         if($_POST["tipoPessoa"] == "cooperado"){
            $insertSQL .= " 0,";
            $insertSQL .= " 0,";
            $insertSQL .= " 1";
        }else if($_POST["tipoPessoa"] == "preCadastrado"){
            $insertSQL .= " 0,";
            $insertSQL .= " 1,";
            $insertSQL .= " 0";
        }else{
            $insertSQL .= " 1,";
            $insertSQL .= " 0,";
            $insertSQL .= " 0";
        }

        $insertSQL .= ")";

        $insert = mysqli_query($conecta, $insertSQL);
        
        if(!$insert){
            die("Erro ao inserir");
        }
        
        $idPessoaSQL = "SELECT idPessoa FROM pessoas WHERE cpf ={$cpfPessoa}";
        
        $idPessoa = mysqli_query($conecta, $idPessoaSQL);
        
        $infoIdPessoa = mysqli_fetch_assoc($idPessoa);
        
        $idPessoaNova = $infoIdPessoa["idPessoa"];
        
        header("location:editar.php?idPessoa={$idPessoaNova}");

    }

//busca estados
	$estadosSQL = "SELECT idUf,descricao FROM ufs ORDER BY descricao";
	$estados = mysqli_query($conecta,$estadosSQL);
	if(empty($estados)){
		die("Erro no Banco 'Estados'");
	}
//busca municipios
	$municipiosSQL = "SELECT idMunicipio,descricao FROM municipios ORDER BY descricao";
	$municipios = mysqli_query($conecta,$municipiosSQL);
	if(empty($municipios)){
		die("Erro No Banco 'Municipios'");
	}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Mobicoop | Admin</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
<?php include_once("padrao/header.php");?>
  <!-- Menu Esquerdo -->
<?php include_once("padrao/menu.php");?>

  <!-- Conteudo da Página -->
  <div class="content-wrapper">
    <!-- Header do Conteudo (Page header) -->
    <section class="content-header">
      <h1>
        Usuários
        <small>Cadastro</small>
      </h1>
    </section>

    <!-- Corpo do Conteúdo -->
    <section class="content container-fluid ">
      <div class="col-md-12">
		<!-- Formulario de Cadastro / Edição -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Cadastro de Usuário</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="cadastrarUsuario.php" method="post">
              <div class="box-body">
				  <!-- Linha 01 -->
				<div class="form-group">
                  <label for="idPessoa" class="col-sm-1 control-label">ID:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="idPessoa" name="idPessoa" placeholder="0" disabled>
                  </div>
                  <label for="nomePessoa" class="col-sm-1 control-label">Nome:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nomePessoa" name="nomePessoa" placeholder="Nome Completo" required>
                  </div>
                </div>
				  <!-- Linha 02 -->
                <div class="form-group">
                  <label for="cpfPessoa" class="col-sm-1 control-label">CPF:</label>
                  <div class="col-sm-3">
                    <input type="number" class="form-control" id="cpfPessoa" name="cpfPessoa" placeholder="58462268095" required>
                  </div>
				  <label for="emailPessoa" class="col-sm-1 control-label">Email:</label>
                  <div class="col-sm-3">
                    <input type="email" class="form-control" id="emailPessoa" name="emailPessoa" placeholder="usuario@dominio.com" required>
                  </div>
				  <label for="telefonePessoa" class="col-sm-1 control-label">Telefone:</label>
                  <div class="col-sm-3">
					<input type="tel" class="form-control" id="telefonePessoa" name="telefonePessoa" placeholder="51988722246" required>
                  </div>
                </div>
				  <!-- Linha 03 -->
				<div class="form-group">
				  <label for="estadoPessoa" class="col-sm-1 control-label">Estado:</label>
                  <div class="col-sm-3">
					<select class="form-control" style="width: 100%;" id="estadoPessoa" name="estadoPessoa" required>
						<option value="0"> Selecione</option>
						<?php 
						  	while($listaEstados = mysqli_fetch_assoc($estados)){
						?>
							<option  value ="<?php echo $listaEstados["idUf"] ?>"> 
								<?php echo $listaEstados["descricao"];?> 
							</option>
						<?php
							}
						?>
					</select>
					  
                  </div>
				  <label for="municipioPessoa" class="col-sm-1 control-label">Município:</label>
                  <div class="col-sm-3">
					<select class="form-control" style="width: 100%;" id="municipioPessoa" name="municipioPessoa" required>
						<option value="0"> Selecione</option>
						<?php 
						  	while($listaMunicipios = mysqli_fetch_assoc($municipios)){
						?>
							<option value ="<?php echo $listaMunicipios["idMunicipio"]; ?>"> 
								<?php echo $listaMunicipios["descricao"];?> 
							</option>
						<?php
							}
						?>
					</select>
                  </div>
				  <label for="bairroPessoa" class="col-sm-1 control-label">Bairro:</label>
                  <div class="col-sm-3">
					<input type="text" class="form-control" id="bairroPessoa" name="bairroPessoa" placeholder="Bairro Estância" required>
                  </div>
                </div>
				<!-- Linha 04 -->
                <div class="form-group">
                  <label for="logradouroPessoa" class="col-sm-1 control-label">Logradouro:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="logradouroPessoa" name="logradouroPessoa" placeholder="Rua ..." required>
                  </div>
				  <label for="numeroPessoa" class="col-sm-1 control-label">Número:</label>
                  <div class="col-sm-2">
                    <input type="number" class="form-control" id="numeroPessoa" name="numeroPessoa" placeholder="271" required>
                  </div>
				  <label for="complementoPessoa" class="col-sm-1 control-label">Complem...:</label>
                  <div class="col-sm-3">
					<input type="text" class="form-control" id="complementoPessoa" name="complementoPessoa" placeholder="Escola ..., Mercado ...">
                  </div>
                </div>
                <!-- Linha 05 -->
                <div class="form-group">
                  <div class="iradio col-sm-3">
                    <label>
                      <input type="radio" name="tipoPessoa" id="consultor" value="consultor">
                      Consultor
                    </label>
                  </div>
                  <div class="iradio col-sm-3">
                    <label>
                      <input type="radio" name="tipoPessoa" id="cooperado" value="cooperado">
                      Cooperado
                    </label>
                  </div>
                  <div class="iradio col-sm-3">
                    <label>
                      <input type="radio" name="tipoPessoa" id="preCadastrado" value="preCadastrado" checked>
                      Pré-Cadastrado
                    </label>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Cadastrar Usuário</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->	
	  </div>
    </section>
    <!-- /.corpo do conteudo -->
  </div>
  <!-- /.conteudo da pagina -->

  <!-- Rodapé -->
<?php include_once("padrao/footer.php");?>
</div>
	
<!------------------------ REQUIRED JS SCRIPTS ------------------------>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
   function limpaTela(){

    $('#idPessoa').val(0);
    $('#nomePessoa').val("");
    $('#cpfPessoa').val(0);
    $('#emailPessoa').val("");
    $('#telefonePessoa').val(0);
    $('#estadoPessoa').val(0);
    $('#municipioPessoa').val(0);
    $('#bairroPessoa').val("");
    $('#logradouroPessoa').val("");
    $('#numeroPessoa').val(0);
    $('#complementoPessoa').val("");
    $('#cooperado').attr('checked', false);
    $('#preCadastrado').attr('checked', true);
    $('#consultor').attr('checked', false);
        
}
    $(document).ready(function() {
        limpaTela();
	});
</script>
</body>
</html>