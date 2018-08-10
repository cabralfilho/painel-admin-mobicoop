<?php
//testa Login
	session_start();

	if(!isset($_SESSION["usuario"])){
		header("location:login.php");
		break;
	}

	$_SESSION["pagina"] = "usuarios";
//buscas no banco
	require_once("conecxao.php");
	$estados = mysqli_query($conecta,"SET NAMES 'utf8'");

//busca dados usuario (table pessoas)
    $pessoaSQL = "SELECT idPessoa, nome, cpf, email, telefone, idUf, idMunicipio, bairro, logradouro, numero, complemento,";
    $pessoaSQL .= " preCadastrado, cooperado, consultor";
    $pessoaSQL .=" FROM pessoas";
    $pessoaSQL .= " WHERE idPessoa = ".$_GET["idPessoa"];

    $pessoaQ = mysqli_query($conecta,$pessoaSQL);
    if(!$pessoaQ){
        die("Falha na consulta ao banco.");
    }	

	$pessoa = mysqli_fetch_assoc($pessoaQ);

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
		die("Erro No Banco ''");
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
        <small>Edição</small>
      </h1>
    </section>

    <!-- Corpo do Conteúdo -->
    <section class="content container-fluid ">
      <div class="col-md-12">
		<!-- Formulario de Cadastro / Edição -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edição de Usuário</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" >
              <div class="box-body">
				  <!-- Linha 01 -->
				<div class="form-group">
                  <label for="idPessoa" class="col-sm-1 control-label">ID:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="idPessoa" name="idPessoa" placeholder="0" disabled>
                  </div>
                  <label for="nomePessoa" class="col-sm-1 control-label">Nome:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nomePessoa" name="nomePessoa" placeholder="Nome Completo">
                  </div>
                </div>
				  <!-- Linha 02 -->
                <div class="form-group">
                  <label for="cpfPessoa" class="col-sm-1 control-label">CPF:</label>
                  <div class="col-sm-3">
                    <input type="number" class="form-control" id="cpfPessoa" name="cpfPessoa" placeholder="58462268095">
                  </div>
				  <label for="emailPessoa" class="col-sm-1 control-label">Email:</label>
                  <div class="col-sm-3">
                    <input type="email" class="form-control" id="emailPessoa" name="emailPessoa" placeholder="usuario@dominio.com">
                  </div>
				  <label for="telefonePessoa" class="col-sm-1 control-label">Telefone:</label>
                  <div class="col-sm-3">
					<input type="tel" class="form-control" id="telefonePessoa" name="telefonePessoa" placeholder="51988722246">
                  </div>
                </div>
				  <!-- Linha 03 -->
				<div class="form-group">
				  <label for="estadoPessoa" class="col-sm-1 control-label">Estado:</label>
                  <div class="col-sm-3">
					<select class="form-control" style="width: 100%;" id="estadoPessoa" name="estadoPessoa">
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
					<select class="form-control" style="width: 100%;" id="municipioPessoa" name="municipioPessoa">
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
					<input type="text" class="form-control" id="bairroPessoa" name="bairroPessoa" placeholder="Estância">
                  </div>
                </div>
				<!-- Linha 04 -->
                <div class="form-group">
                  <label for="logradouroPessoa" class="col-sm-1 control-label">Logradouro:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="logradouroPessoa" name="logradouroPessoa" placeholder="Rua ...">
                  </div>
				  <label for="numeroPessoa" class="col-sm-1 control-label">Número:</label>
                  <div class="col-sm-2">
                    <input type="number" class="form-control" id="numeroPessoa" name="numeroPessoa" placeholder="271">
                  </div>
				  <label for="complementoPessoa" class="col-sm-1 control-label">Complem...:</label>
                  <div class="col-sm-3">
					<input type="text" class="form-control" id="complementoPessoa" name="complementoPessoa" placeholder="Escola ..., Mercado ...">
                  </div>
                </div>
                <!-- Linha 04 -->
                <div class="form-group">
                  <div class="iradio col-sm-2">
                    <label>
                      <input type="radio" name="tipoPessoa" id="cooperado" value="cooperado">
                      Cooperado
                    </label>
                  </div>
                  <div class="iradio col-sm-2">
                    <label>
                      <input type="radio" name="tipoPessoa" id="preCadastrado" value="preCadastrado">
                      Pré-Cadastrado
                    </label>
                  </div>
                  <div class="iradio col-sm-2">
                    <label>
                      <input type="radio" name="tipoPessoa" id="consultor" value="consultor">
                      Consultor
                    </label>
                  </div>
                </div>
                  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-danger">Deletar</button>
                <?php
                  if(isset($pessoa['consultor']) && $pessoa['consultor'] == 1){
                  echo "<button type='submit' class='btn btn-seccess'>Gerar Senha</button>";
                  }
                ?>
                <button type="submit" class="btn btn-info pull-right">Salvar</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
		   <?php 
		  
		  	$pessoasSQL = "SELECT a.idPessoa,b.nome as nome,f.descricao as cooperativa,g.descricao as nucleo,h.descricao as cota";
		  	$pessoasSQL .= " FROM pessoasxpai a";
		  
		  	$pessoasSQL .= " JOIN pessoas b ON b.IDPESSOA = a.IDPESSOA";
		  
		  	$pessoasSQL .= " JOIN pessoasxcooperativas c ON c.IDPESSOA = a.IDPESSOA";
			$pessoasSQL .= " JOIN pessoasxnucleos d ON d.IDPESSOA = a.IDPESSOA";
		    $pessoasSQL .= " JOIN pessoasxcotas e ON e.IDPESSOA = a.IDPESSOA";
		    
		    $pessoasSQL .= " JOIN cooperativas f ON c.IDCOOPERATIVA = f.IDCOOPERATIVA";
		    $pessoasSQL .= " JOIN nucleos g ON d.IDNUCLEO = g.IDNUCLEO";
		  	$pessoasSQL .= " JOIN cotas h ON e.IDCOTA = h.IDCOTA";
		  	$pessoasSQL .= " WHERE a.IDPAI = ".$_GET["idPessoa"];
		  
		  	$pessoas = mysqli_query($conecta,$pessoasSQL);
		  ?>

          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Lista de "Filhos"</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="listaFilhos" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Cooperativa</th>
                  <th>Núcleo</th>
                  <th>Cota</th>
				  <th>Ação</th>
                </tr>
                </thead>
                <tbody>
					<?php while($listaPessoas = mysqli_fetch_assoc($pessoas)){?>
                <tr>
                  <td><?php echo $listaPessoas["idPessoa"]?></td>
                  <td><?php echo $listaPessoas["nome"]?></td>
                  <td><?php echo $listaPessoas["cooperativa"]?></td>
                  <td><?php echo $listaPessoas["nucleo"]?></td>
                  <td><?php echo $listaPessoas["cota"]?></td>
				  <td><a href="editar.php?idPessoa=<?php echo $listaPessoas["idPessoa"]?>"><button class="btn btn-flat btn-info pull-right">Abrir</button></a></td>
                </tr>
					<?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>	
          <!-- Lista de Cooperativas -->
        <?php 
		  
		  	$cooperativasSQL = "SELECT a.idPessoa, a.idCooperativa, b.descricao as cooperativa";
		  	$cooperativasSQL .= " FROM pessoasxcooperativas a";
		  
		  	$cooperativasSQL .= " JOIN cooperativas b ON b.idCooperativa = a.idCooperativa";

		  	$cooperativasSQL .= " WHERE a.idPessoa = ".$_GET["idPessoa"];
		  
		  	$cooperativas = mysqli_query($conecta,$cooperativasSQL);
		  ?>

          <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title">Cooperativas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="listaCooperativas" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID Cooperativa</th>
                  <th>Nome</th>
				  <th>Ação</th>
                </tr>
                </thead>
                <tbody>
					<?php while($listaCooperativas = mysqli_fetch_assoc($cooperativas)){?>
                <tr>
                  <td><?php echo $listaCooperativas["idCooperativa"]?></td>
                  <td><?php echo $listaCooperativas["cooperativa"]?></td>
				  <td><a href="editarCooperativa.php?idCooperativa=<?php echo $listaCooperativas["idCooperativa"]?>"><button class="btn btn-flat btn-info pull-right">Abrir</button></a></td>
                </tr>
					<?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <?php 
		  
		  	$nucleosSQL = "SELECT a.idPessoa, a.idNucleo, b.descricao as nucleo";
		  	$nucleosSQL .= " FROM pessoasxnucleos a";
		  
		  	$nucleosSQL .= " JOIN nucleos b ON b.idNucleo= a.idNucleo";

		  	$nucleosSQL .= " WHERE a.idPessoa = ".$_GET["idPessoa"];
		  
		  	$nucleos = mysqli_query($conecta,$nucleosSQL);
		  ?>

          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Núcleos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="listaNucleos" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID Núcleo</th>
                  <th>Nome</th>
				  <th>Ação</th>
                </tr>
                </thead>
                <tbody>
					<?php while($listaNucleos = mysqli_fetch_assoc($nucleos)){?>
                <tr>
                  <td><?php echo $listaNucleos["idNucleo"]?></td>
                  <td><?php echo $listaNucleos["nucleo"]?></td>
				  <td><a href="editarNucleo.php?idNucleo=<?php echo $listaNucleos["idNucleo"]?>"><button class="btn btn-flat btn-info pull-right">Abrir</button></a></td>
                </tr>
					<?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <?php 
		  
		  	$cotasSQL = "SELECT a.idPessoa, a.idCota, b.descricao as cota";
		  	$cotasSQL .= " FROM pessoasxcotas a";
		  
		  	$cotasSQL .= " JOIN cotas b ON b.idCota= a.idCota";

		  	$cotasSQL .= " WHERE a.idPessoa = ".$_GET["idPessoa"];
		  
		  	$cotas = mysqli_query($conecta,$cotasSQL);
		  ?>

          <div class="box box-default">
            <div class="box-header">
              <h3 class="box-title">Cotas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="listaCotas" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID Cota</th>
                  <th>Nome</th>
				  <th>Ação</th>
                </tr>
                </thead>
                <tbody>
					<?php while($listaCota = mysqli_fetch_assoc($cotas)){?>
                <tr>
                  <td><?php echo $listaCota["idCota"]?></td>
                  <td><?php echo $listaCota["cota"]?></td>
				  <td><a href="editarCota.php?idCota=<?php echo $listaCota["idCota"]?>"><button class="btn btn-flat btn-info pull-right">Abrir</button></a></td>
                </tr>
					<?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
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
   function montaTela(){

    $('#idPessoa').val(<?php if(isset($pessoa["idPessoa"])){echo $pessoa["idPessoa"];}else{ echo 0;} ?>);
    $('#nomePessoa').val("<?php if(isset($pessoa["nome"])){echo $pessoa["nome"];}else{ echo "";} ?>");
    $('#cpfPessoa').val(<?php if(isset($pessoa["cpf"])){echo $pessoa["cpf"];}else{ echo 0;} ?>);
    $('#emailPessoa').val("<?php if(isset($pessoa["email"])){echo $pessoa["email"];}else{ echo "";} ?>");
    $('#telefonePessoa').val(<?php if(isset($pessoa["telefone"])){echo $pessoa["telefone"];}else{ echo 0;} ?>);
    $('#estadoPessoa').val(<?php if(isset($pessoa["idUf"])){echo $pessoa["idUf"];}else{ echo 0;} ?>);
    $('#municipioPessoa').val("<?php if(isset($pessoa["idMunicipio"])){echo $pessoa["idMunicipio"];}else{ echo 0;} ?>");
    $('#bairroPessoa').val("<?php if(isset($pessoa["bairro"])){echo $pessoa["bairro"];}else{ echo "";} ?>");
    $('#logradouroPessoa').val("<?php if(isset($pessoa["logradouro"])){echo $pessoa["logradouro"];}else{ echo "";} ?>");
    $('#numeroPessoa').val(<?php if(isset($pessoa["numero"])){echo $pessoa["numero"];}else{ echo 0;} ?>);
    $('#complementoPessoa').val("<?php if(isset($pessoa["complemento"])){echo $pessoa["complemento"];}else{ echo "";} ?>");
    <?php 
        if(isset($pessoa['cooperado']) && $pessoa['cooperado'] == 1){
            echo "$('#cooperado').attr('checked', true);";
        }else if(isset($pessoa['preCadastrado']) && $pessoa['preCadastrado'] == 1){ 
            echo "$('#preCadastrado').attr('checked', true);";
        }else{
            echo "$('#consultor').attr('checked', true);";
        } 
    ?>
}
    $(document).ready(function() {
		$('#listaFilhos').DataTable( {
			"ordering": true,
			"language": {
				   "url": "bower_components/datatables.net/portugues-brasil-lang.json"
			   }
		});
        $('#listaCooperativas').DataTable( {
			"ordering": true,
			"language": {
				   "url": "bower_components/datatables.net/portugues-brasil-lang.json"
			   }
		});	
        $('#listaNucleos').DataTable( {
			"ordering": true,
			"language": {
				   "url": "bower_components/datatables.net/portugues-brasil-lang.json"
			   }
		});	
        $('#listaCotas').DataTable( {
			"ordering": true,
			"language": {
				   "url": "bower_components/datatables.net/portugues-brasil-lang.json"
			   }
		});	
	});
    montaTela();    
</script>
</body>
</html>