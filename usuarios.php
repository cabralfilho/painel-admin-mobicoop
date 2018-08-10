<?php
//testa Login
	header('Access-Control-Allow-Origin: *');  
	session_start();

	if(!isset($_SESSION["usuario"])){
		header("location:login.php");
		break;
	}

	$_SESSION["pagina"] = "usuarios";
    $_SESSION["subPagina"] = "listaUsuarios";

	require_once("conecxao.php");
	$utf8 = mysqli_query($conecta,"SET NAMES 'utf8'");
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

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
        <small>Listagem de Usuário Mobicoop</small>
      </h1>
    </section>

    <!-- Corpo do Conteúdo -->
    <section class="content container-fluid ">
      <div class="col-md-12">
		<!-- Formulario de Cadastro / Edição -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Filtrar Usuários</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="usuarios.php">
              <div class="box-body">
				  <!-- Linha 01 -->
				<div class="form-group">
				  <label for="estadoPessoa" class="col-sm-1 control-label">Cooperativa:</label>
                  <div class="col-sm-3">
					<select class="form-control" style="width: 100%;" id="filtroCooperativas" name="filtroCooperativas">
						<option value="0"> Selecione</option>
					</select>
                  </div>
				  <label for="municipioPessoa" class="col-sm-1 control-label">Núcleo:</label>
                  <div class="col-sm-3">
					<select class="form-control" style="width: 100%;" id="filtroNucleos" name="filtroNucleos">
						<option value="0"> Selecione</option>
					</select>
                  </div>
				  <label for="municipioPessoa" class="col-sm-1 control-label">Cota:</label>
                  <div class="col-sm-3">
					<select class="form-control" style="width: 100%;" id="filtroCotas" name="filtroCotas">
						<option value="0"> Selecione</option>
					</select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Filtrar</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
		  <?php 
		  
		  	$pessoasSQL = "SELECT a.idPessoa,a.nome as nome,e.descricao as cooperativa,f.descricao as nucleo,g.descricao as cota,";
            $pessoasSQL .= " a.preCadastrado, a.cooperado, a.consultor";
		  	$pessoasSQL .= " FROM pessoas a";
		  
		  	$pessoasSQL .= " JOIN pessoasxcooperativas b ON b.IDPESSOA = a.IDPESSOA";
			$pessoasSQL .= " JOIN pessoasxnucleos c ON c.IDPESSOA = a.IDPESSOA";
		    $pessoasSQL .= " JOIN pessoasxcotas d ON d.IDPESSOA = a.IDPESSOA";
		    
		    $pessoasSQL .= " JOIN cooperativas e ON b.IDCOOPERATIVA = e.IDCOOPERATIVA";
		    $pessoasSQL .= " JOIN nucleos f ON c.IDNUCLEO = f.IDNUCLEO";
		  	$pessoasSQL .= " JOIN cotas g ON d.IDCOTA = g.IDCOTA";
		  
		  	if(isset($_POST["filtroCooperativas"]) && $_POST["filtroCooperativas"]>0){
				$filtroCooperativa = $_POST["filtroCooperativas"];
				$pessoasSQL .= " WHERE e.IDCOOPERATIVA = {$filtroCooperativa}";
			}
		  	if(isset($_POST["filtroNucleos"]) && $_POST["filtroNucleos"]>0){
				$filtroNucleo = $_POST["filtroNucleos"];
				$pessoasSQL .= " AND f.IDNUCLEO = {$filtroNucleo}";
			}
		  	if(isset($_POST["filtroCotas"]) && $_POST["filtroCotas"]>0){
				$filtroCota = $_POST["filtroCotas"];
				$pessoasSQL .= " AND g.IDCOTA = {$filtroCota}";
			}
          
		  	$pessoas = mysqli_query($conecta,$pessoasSQL);
		  ?>

          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Lista de Usuários</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="listaUsuarios" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Tipo Usuário</th>
                  <th>Cooperativa</th>
                  <th>Núcleo</th>
                  <th>Cota</th>
				  <th>Ação</th>
                </tr>
                </thead>
                <tbody>
					<?php while($listaPessoas = mysqli_fetch_assoc($pessoas)){
    
                        if($listaPessoas["cooperado"] == 1){
                            $tipoPessoa = "Cooperado";
                        }else if($listaPessoas["preCadastrado"] == 1){ 
                            $tipoPessoa = "Pré-Cadastrado";
                        }else{
                            $tipoPessoa = "Consultor";
                        }
    
                    ?>
                <tr>
                  <td><?php echo $listaPessoas["idPessoa"]?></td>
                  <td><?php echo $listaPessoas["nome"]?></td>
                  <td><?php echo $tipoPessoa?></td>
                  <td><?php echo $listaPessoas["cooperativa"]?></td>
                  <td><?php echo $listaPessoas["nucleo"]?></td>
                  <td><?php echo $listaPessoas["cota"]?></td>
				  <td><a href="editar.php?idPessoa=<?php echo $listaPessoas["idPessoa"]?>"><button class="btn btn-flat btn-info pull-right">Perfil</button></a></td>
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
    $(document).ready(function() {
		$('#listaUsuarios').DataTable( {
			"ordering": true,
			"language": {
				   "url": "bower_components/datatables.net/portugues-brasil-lang.json"
			   }
		});	
	});
</script>
<!-- Script dos filtros -->
<script>
	function getCooperativas() {
		$.getJSON("https://www.mobicoop.com.br/scripts/getCooperativas.php", function (data) {
			var lista = data;
			//limpando o conteudo do Select
			$("#filtroCooperativas").empty();
			$("#filtroCooperativas").append("<option value='0'>Selecione</option>");
			//percorre resultado montando o Select
			if (lista.length > 0) {
				for (var linha = 0; linha < lista.length; linha++) {
					var registro = lista[linha];
					if(registro.idCooperativa != <?php if(isset($filtroCooperativa)){echo $filtroCooperativa;}else{echo "0";} ?>){
						$("#filtroCooperativas").append(
							"<option value='"+ registro.idCooperativa +"'>"
							+ registro.descricao +"</option>"
						);
					}else{
						$("#filtroCooperativas").append(
							"<option  value='"+ registro.idCooperativa +"' selected >"+ registro.descricao +"</option>"
						);
						$("#filtroCooperativas").val(registro.idCooperativa);
					}
				}
			}		
		});
	}
	function getNucleos(idCooperativa) {
		$.getJSON("https://mobicoop.com.br/scripts/getNucleos.php?cooperativa="+idCooperativa, function (data) {
			var lista = data;
			//limpando o conteudo do Select
			$("#filtroNucleos").empty();
			$("#filtroNucleos").append("<option value='0'>Selecione</option>");
			//percorre resultado montando o Select
			if (lista.length > 0) {
				for (var linha = 0; linha < lista.length; linha++) {
					var registro = lista[linha];
					if(registro.idNucleo != <?php if(isset($filtroNucleo)){echo $filtroNucleo;}else{echo "0";} ?>){
						$("#filtroNucleos").append(
							"<option value='"+ registro.idNucleo +"'>"+ registro.descricao +"</option>"
						);
					}else{
						$("#filtroNucleos").append(
							"<option  value='"+ registro.idNucleo +"' selected >"+ registro.descricao +"</option>"
						);
						$("#filtroNucleos").val(registro.idNucleo);
					}
				}
			}		
		});
}
	function getCotas(idNucleo) {
		$.getJSON("https://mobicoop.com.br/scripts/getCotas.php?nucleo="+idNucleo, function (data) {
			var lista = data;
			//limpando o conteudo do Select
			$("#filtroCotas").empty();
			$("#filtroCotas").append("<option value='0'>Selecione</option>");
			//percorre resultado montando o Select
			if (lista.length > 0) {
				for (var linha = 0; linha < lista.length; linha++) {
					var registro = lista[linha];
					if(registro.idCota != <?php if(isset($filtroCota)){echo $filtroCota;}else{echo "0";} ?>){
						$("#filtroCotas").append(
							"<option value='"+ registro.idCota +"'>"+ registro.descricao +"</option>"
						);
					}else{
						$("#filtroCotas").append(
							"<option  value='"+ registro.idCota +"' selected >"+ registro.descricao +"</option>"
						);
						$("#filtroCotas").val(registro.idCota);
					}
				}
			}		
		});
}
$(document).ready(function () {
	getCooperativas();
	
	if(<?php if(isset($filtroCooperativa)){echo $filtroCooperativa;}else{echo "0";} ?> > 0){
		getNucleos(<?php if(isset($filtroCooperativa)){echo $filtroCooperativa;}else{echo "0";} ?>);
	}
	if(<?php if(isset($filtroNucleo)){echo $filtroNucleo;}else{echo "0";} ?> > 0){
		getCotas(<?php if(isset($filtroNucleo)){echo $filtroNucleo;}else{echo "0";} ?>);   
	}
	
});
$("#filtroCooperativas").change(function(){ 
    getNucleos($("#filtroCooperativas").val());
	$("#filtroCotas").empty();
});
$("#filtroNucleos").change(function(){ 
	getCotas($("#filtroNucleos").val());
});  
</script>
</body>
</html>