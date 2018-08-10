<?php require_once("conecxao.php");?>
<?php 

	session_start();

	if(isset($_POST["email"])){
		$email = $_POST["email"];
		$senha = $_POST["senha"];
		
		if(isset($_POST["lembrarEmail"])){
			$lembrarEmail = $_POST["lembrarEmail"];
			
			if($lembrarEmail == "on"){
				$_SESSION["email"] = $email;
			}
		}else{
			unset($_SESSION["email"]);
		}
		$senhaMD5 = md5("754f9968bf5f5f68d7dea029889b7415".$senha);
		
		$login = "SELECT * FROM usuarios WHERE email = '{$email}' AND senha='{$senhaMD5}'";
        
		$acesso = mysqli_query($conecta,$login);

		if(!$acesso){
			die("Falha na consulta ao banco.");
		}
		
		$informacao = mysqli_fetch_assoc($acesso);
		
		if(empty($informacao)){
			$mensagem = "Email ou Senha Incorretos!";
			
		}else{
			$_SESSION["usuario"] = $informacao["IDUSUARIO"];			
			header("location: index.php");
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Painel Mobicoop | Entrar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- Login.css -->
  <link rel="stylesheet" href="dist/css/login.css">
	
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page" style="height: 0%;">
<div class="login-box">
  <div class="login-logo">
    <a href="https://mobicoop.com.br"><img src="dist/img/logo-mobicoop.png" alt="" style="width: 250px;margin: 30px;"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">

    <form action="login.php" method="post">
		<!-- Usuário -->
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
		<!-- Senha -->
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="senha"  placeholder="Senha">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
		<!-- Lembrar Usuario -->
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="lembrarEmail" <?php if(isset($_SESSION["email"])){ echo "checked"; } ?>> Lembrar Email
            </label>
          </div>
        </div>
		  <!-- Entrar -->
        <div class="col-xs-4">
          <button type="submit" value="entrar" class="btn btn-primary btn-block btn-flat">Entrar</button>
        </div>
      </div>
    </form>

    <a href="#">Esqueci Minha Senha.</a><br>
	<?php 
	  if( isset($mensagem) ){
	  	echo "<p class='mensagemErro'>".$mensagem."</p>";
	  }
	?>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function() {
		$("#email").val("<?php if(isset($_SESSION["email"])){ echo $_SESSION["email"]; }else{ echo "";} ?>");
	});
</script>
</body>
</html>
