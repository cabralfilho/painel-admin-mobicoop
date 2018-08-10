<?php 
	require_once("conecxao.php");
	if(isset($_SESSION["usuario"])){
		$idUsuario = $_SESSION["usuario"];
		
		$sql = "SELECT nome FROM usuarios WHERE idusuario = {$idUsuario}";
		
		$nome = mysqli_query($conecta, $sql);
		
		if(!$nome){
			die("Falha no Banco");
		}
		
		$nome = mysqli_fetch_assoc($nome);
		
		$nomeUsuario = $nome["nome"];
		
	}
?>
<header class="main-header">
    <!-- Logo -->
    <a href="index.html" class="logo">
      <!-- Mini logo para Menu Esquerdo Pequeno 50x50px -->
      <span class="logo-mini"><img style="width:60%" alt="logo mobicoop branco" src="dist/img/icon-branco.png"></span>
      <!-- Logo Normal -->
      <span class="logo-lg"><img style="width:75%" alt="logo mobicoop branco" src="dist/img/logo-mobicoop-branco.png"></span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Botão do Menu Esquerdo-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Abrir Menu</span>
      </a>
      <!-- Menu Direito do Navbar -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Menu do Informações Usuário -->
          <li class="dropdown user user-menu">
            <!-- Botão do Menu -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- Avatar do Usuario -->
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <!-- Nome do Usuario (Dispositivos Grandes) -->
              <span class="hidden-xs"><?php echo $nomeUsuario ?></span>
            </a>
			  <!-- Dropdown do Menu de Informações Usuário -->
            <ul class="dropdown-menu">
              <!-- Avatar do usuário (Grande) -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
				  <!-- Descrição do Usuário -->
                <p>
                  <?php echo $nomeUsuario ?>
					<br>Administrador
                </p>
              </li>
              <!-- Botões de Ação -->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="sair.php" class="btn btn-default btn-flat">Sair</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Botão de Sair -->
          <li>
            <a href="sair.php"><i class="fa fa-sign-out"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>