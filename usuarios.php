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
    require_once("funcoes.php");

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

          <!-- /.box -->
		  <?php 
		  
		  	$pessoasSQL = "SELECT a.idPessoa,a.nome, a.cpf, a.email, a.telefone";
		  	$pessoasSQL .= " FROM pessoas a";          
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
                  <th>CPF</th>
                  <th>Email</th>
                  <th>Telefone</th>
				  <th>Ação</th>
                </tr>
                </thead>
                <tbody>
					<?php while($listaPessoas = mysqli_fetch_assoc($pessoas)){ ?>
                <tr>
                  <td><?php echo $listaPessoas["idPessoa"];?></td>
                  <td><?php echo $listaPessoas["nome"];?></td>
                  <td><?php echo mask($listaPessoas["cpf"],'###.###.###-##')?></td>
                  <td><?php echo $listaPessoas["email"];?></td>
                  <td><?php echo mask($listaPessoas["telefone"],'(##) #.####-####');?></td>
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
</body>
</html>