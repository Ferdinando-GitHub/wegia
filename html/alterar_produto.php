<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}
	
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once "personalizacao_display.php";

include_once '../dao/Conexao.php';
include_once '../dao/CategoriaDAO.php';
include_once '../dao/UnidadeDAO.php';
include_once '../dao/ProdutoDAO.php';
	
	if(!isset($_SESSION['unidade'])) {
		extract($_REQUEST);
		header('Location: ../controle/control.php?metodo=listarTodos&nomeClasse=UnidadeControle&nextPage=../html/alterar_produto.php?id_produto='.$id_produto);
	}
	if(!isset($_SESSION['categoria'])){
		extract($_REQUEST);
		header('Location: ../controle/control.php?metodo=listarTodos&nomeClasse=CategoriaControle&nextPage=../html/alterar_produto.php?id_produto='.$id_produto);	
	}
	if(!isset($_SESSION['produto'])) {
		extract($_REQUEST);
		header('Location: ../controle/control.php?metodo=listarId&nomeClasse=ProdutoControle&nextPage=../html/alterar_produto.php?id_produto='.$id_produto.'&id_produto='.$id_produto);
	}

	if(isset($_SESSION['produto']) && isset($_SESSION['categoria']) && isset($_SESSION['unidade'])){
		$produto = $_SESSION['produto'];
		$unidade = $_SESSION['unidade'];
		$categoria = $_SESSION['categoria'];

		unset($_SESSION['produto']);
		unset($_SESSION['categoria']);
		unset($_SESSION['unidade']);
	}
?>
<!doctype html>
<html class="fixed">
<head>

	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Home</title>

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">
	
	<!-- Theme CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="../assets/vendor/modernizr/modernizr.js"></script>
	
	<script src="../assets/vendor/jquery/jquery.min.js"></script>
	<script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
	<script type="text/javascript">
		$(function () {
	      $("#header").load("header.php");
	      $(".menuu").load("menu.html");
	    });	
	</script>

</head>
<body>
	<div id="header"></div>
        <!-- end: header -->
        <div class="inner-wrapper">
          <!-- start: sidebar -->
          <aside id="sidebar-left" class="sidebar-left menuu"></aside>
	<!-- end: sidebar -->
			<section role="main" class="content-body">
				<header class="page-header">
					<h2>Perfil</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Páginas</span></li>
							<li><span>Perfil</span></li>
						</ol>
						<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<!-- start: page -->
				<div class="row">
					<div class="col-md-4 col-lg-3" style="width: 230px;">
						<section class="panel">
							<div class="panel-body" style="display:none;">
								<div class="thumb-info mb-md"></div>
							</div>
						</section>
					</div>
					<div class="col-md-8 col-lg-6">
						<div class="tabs">
							<ul class="nav nav-tabs tabs-primary">
								<li class="active">
									<a href="#overview" data-toggle="tab">Visão Geral</a>
								</li>

								<li>
									<a href="#edit" data-toggle="tab">Editar Dados</a>
								</li>
							</ul>
								
							<div class="tab-content" style="width: 660px;">
								<div id="overview" class="tab-pane active">
									<div>
										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions">
													<a href="#" class="fa fa-caret-down"></a>
												</div>
												<h2 class="panel-title">Visão Geral</h2>
											</header>
												 
											<div class="panel-body" style="display: block;">
												<ul class="nav nav-children" id="info">
													<li id="nome">Nome do Produto:</li>
													<li id="Categoria">Categoria:</li>
													<li id="Unidade">Unidade:</li>
													<li id="Codigo">Codigo:</li>
													<li id="Valor">Valor:</li>
												</ul>
											</div>
										</section>
									</div>
								</div>
									
								<div id="edit" class="tab-pane">
									<form id="formulario" action="../controle/control.php">
										<input type="hidden" name="nomeClasse" value="ProdutoControle">
										<input type="hidden" name="metodo" value="alterarProduto">
										<input type="hidden" name="id_produto" id="id_produto">
										<input type="hidden" name="nextPage" id="nextPage">
										<fieldset>
											<div class="form-group"><br>
												<label class="col-md-3 control-label">Nome do produto</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="descricao" id="produto">
												</div>
											</div>
										
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Categoria</label>
												<a href="adicionar_categoria.php">
													<i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i>
												</a>
												<div class="col-md-6">
													<select name="id_categoria" id="id_categoria" class="form-control input-lg mb-md">
													</select>
												</div>	
											</div>
												
											<div class="form-group">
												<label class="col-md-3 control-label" >Unidade</label>
												<a href="adicionar_unidade.php"><i class="fas fa-plus w3-xlarge" style="margin-top: 0.75vw"></i></a>
												<div class="col-md-6">
													<select name="id_unidade" id="id_unidade" class="form-control input-lg mb-md">
													</select>
												</div>	
											</div>
												
											<div class="form-group">
												<label class="col-md-3 control-label" for="profileCompany">Código</label>
												<div class="col-md-8">
													<input type="text" name="codigo" class="form-control" minlength="11" id="codigo" id="profileCompany">
												</div>
											</div>
												
											<div class="form-group">
												<label class="col-md-3 control-label" for="profileCompany">Valor</label>
												<div class="col-md-8">
													<input type="text" name="preco" class="form-control" id="valor" id="profileCompany" maxlength="13" placeholder="Ex: 22.00" onkeypress="return Onlynumbers(event)" >

												</div>
											</div>
											
											<div class="panel-footer">
												<div class="row">
													<div class="col-md-9 col-md-offset-3">
														<button type="button" class="btn btn-primary" id="botaoEditarIP" onclick="return editar_produto()">Editar</button>
                                    					<input type="submit" class="btn btn-primary" disabled="true"  value="Salvar" id="botaoSalvarIP">
														<input type="reset" class="btn btn-default">  
													</div>
												</div>
											</div>
										</fieldset>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
</body>

</html>