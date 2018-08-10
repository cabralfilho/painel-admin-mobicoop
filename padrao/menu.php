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
		
		$paginaSelecionada = $_SESSION["pagina"];
        
        if(isset($_SESSION["subPagina"])){
            $subPaginaSelecionada = $_SESSION["subPagina"];
        }
		
	}
?>
<aside class="main-sidebar">
    <!-- Menu Esquerdo: sidebar.less -->
    <section class="sidebar">
      <!-- Menu Esquerdo: Info do Usuário -->
      <div class="user-panel">
		  <!-- Avatar do Usuário -->
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
		  <!-- Info do Usuário -->
        <div class="pull-left info">
		  <!-- Nome do Usuário -->
          <p><?php echo $nomeUsuario ?></p>
		  <small>Administrador</small>
        </div>
      </div>
      <!-- Menu Esquerdo:Lista com Link das Paginas -->
      <ul class="sidebar-menu" data-widget="tree">
		 <!-- Class Active na Pagina Atual -->
		<li class="header"></li>
        <li <?php if($paginaSelecionada == "index"){ echo 'class="active"';}?> >
			<a href="index.php"><i class="fa fa-home"></i> <span>Inicio</span></a>
		</li>
		  
		<li class="header">MENUS</li>
        <li class="treeview  <?php if($paginaSelecionada == "usuarios"){ echo 'active';}?> ">
          <a href="#">
            <i class="fa fa-users"></i><span>Usuários</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if(isset($subPaginaSelecionada) && $subPaginaSelecionada == "listaUsuarios"){ echo "class='active'";}?>>
                <a href="usuarios.php"><i class="fa fa-list-ul"></i>Listar Usuarios</a>
            </li>
            <li <?php if(isset($subPaginaSelecionada) && $subPaginaSelecionada == "cadastroUsuario"){ echo "class='active'";}?>>
                <a href="cadastrarUsuario.php"><i class="fa fa-plus"></i>Cadastrar Usuário</a>
            </li>
          </ul>
        </li>
        <li class="treeview  <?php if($paginaSelecionada == "cooperativas"){ echo 'active';}?> ">
          <a href="#">
            <i class="fa fa-cubes"></i><span>Cooperativas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if(isset($subPaginaSelecionada) && $subPaginaSelecionada == "listaCooperativas"){ echo "class='active'";}?>>
                <a href="cooperativas.php"><i class="fa fa-list-ul"></i>Listar Cooperativas</a>
            </li>
            <li <?php if(isset($subPaginaSelecionada) && $subPaginaSelecionada == "cadastroCooperativa"){ echo "class='active'";}?>>
                <a href="cadastrarCooperativa.php"><i class="fa fa-plus"></i>Cadastrar Cooperativa</a>
            </li>
          </ul>
        </li>
        <li class="treeview  <?php if($paginaSelecionada == "nucleos"){ echo 'active';}?> ">
          <a href="#">
            <i class="fa fa-circle-o"></i><span>Núcleos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if(isset($subPaginaSelecionada) && $subPaginaSelecionada == "listaNucleos"){ echo "class='active'";}?>>
                <a href="cooperativas.php"><i class="fa fa-list-ul"></i>Listar Núcleos</a>
            </li>
            <li <?php if(isset($subPaginaSelecionada) && $subPaginaSelecionada == "cadastroNucleo"){ echo "class='active'";}?>>
                <a href="cadastrarCooperativa.php"><i class="fa fa-plus"></i>Cadastrar Núcleo</a>
            </li>
          </ul>
        </li>
        <li class="treeview  <?php if($paginaSelecionada == "cotas"){ echo 'active';}?> ">
          <a href="#">
            <i class="fa fa-link"></i><span>Cotas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if(isset($subPaginaSelecionada) && $subPaginaSelecionada == "listaCotas"){ echo "class='active'";}?>>
                <a href="cooperativas.php"><i class="fa fa-list-ul"></i>Listar Cotas</a>
            </li>
            <li <?php if(isset($subPaginaSelecionada) && $subPaginaSelecionada == "cadastroNucleo"){ echo "class='active'";}?>>
                <a href="cadastrarCooperativa.php"><i class="fa fa-plus"></i>Cadastrar Cota</a>
            </li>
          </ul>
        </li>
		<li class="header">AÇÕES</li>
		<li <?php if($paginaSelecionada == "relatorios"){ echo 'class="active"';}?> >
			<a href="#"><i class="fa fa-file-excel-o"></i> <span>Relatórios</span></a>
		</li>
		<li <?php if($paginaSelecionada == "emailAlerta"){ echo 'class="active"';}?> >
			<a href="#"><i class="fa fa-envelope"></i> <span>Email Alerta</span></a>
		</li>
		<li class="header"></li>
      </ul>
    </section>
  </aside>