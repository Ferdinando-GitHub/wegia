<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header ("Location: ../index.php");
	}
	
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
	require_once "personalizacao_display.php";
?>

<!doctype html>
<html class="fixed">
<head>
	<?php
		include_once '../dao/Conexao.php';
		include_once '../dao/AlmoxarifadoDAO.php';
		include_once '../dao/TipoEntradaDAO.php';
		include_once '../dao/ProdutoDAO.php';
	
		if (!isset($_SESSION['almoxarifado'])) {
			header('Location: ../controle/control.php?metodo=listarTodos&nomeClasse=AlmoxarifadoControle&nextPage=../html/cadastro_saida.php');
		}
		if(!isset($_SESSION['tipo_saida'])){
			header('Location: ../controle/control.php?metodo=listarTodos&nomeClasse=TipoSaidaControle&nextPage=../html/cadastro_saida.php');	
		}
		if(!isset($_SESSION['autocomplete'])) {
			header('Location: ../controle/control.php?metodo=listarDescricao&nomeClasse=ProdutoControle&nextPage=../html/cadastro_saida.php');
		}
		if(!isset($_SESSION['destino'])) {
			header('Location: ../controle/control.php?metodo=listarTodos&nomeClasse=DestinoControle&nextPage=../html/cadastro_saida.php');
		}
		if(isset($_SESSION['almoxarifado']) && isset($_SESSION['tipo_saida']) &&  isset($_SESSION['autocomplete']) && isset($_SESSION['destino'])){

			$almoxarifado = $_SESSION['almoxarifado'];
			$tipo_saida = $_SESSION['tipo_saida'];
			$autocomplete = $_SESSION['autocomplete'];
			$destino = $_SESSION['destino'];

			unset($_SESSION['almoxarifado']);
			unset($_SESSION['tipo_saida']);
			unset($_SESSION['autocomplete']);
			unset($_SESSION['destino']);
		}
	?>
	
	<!-- Basic -->
	<meta charset="UTF-8">
	<title>Cadastro saida</title>

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="../assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="../assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
	<link rel="icon" href="<?php display_campo("Logo",'file');?>" type="image/x-icon" id="logo-icon">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

	<!-- Theme CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="../assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="../assets/vendor/modernizr/modernizr.js"></script>

	<!-- Javascript functions -->
	<script src="../assets/vendor/jquery/jquery.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	<link type="text/css" rel="stylesheet" charset="UTF-8" href="https://translate.googleapis.com/translate_static/css/translateelement.css">

	<script type="text/javascript">
		$(function() {

			var almoxarifado = <?php 
				echo $almoxarifado;
			?>;
				
			var tipo_saida = <?php 
				echo $tipo_saida; 
			?>;
			
			var produtos_autocomplete = <?php
				echo $autocomplete;
			?>;
			
			var destino = <?php
				echo $destino;
			?>;

			$.each(almoxarifado,function(i,item){
				$('#almoxarifado').append('<option value="' + item.id_almoxarifado + '">' + item.descricao_almoxarifado + '</option>');
			})

			$.each(tipo_saida,function(i,item){
				$('#tipo_entrada').append('<option value="' + item.id_tipo + '">' + item.descricao + '</option>');
			})

			$.each(produtos_autocomplete,function(i,item){
				$('#produtos_autocomplete').append('<option value="' + item.id_produto + '-' + item.descricao + '">');
			})

			$.each(destino,function(i,item){
				$('#origens').append('<option value="' + item.id_destino + '-' + item.nome_destino + '">');
			})

			$('#input_produtos').on('input',function(){
				var teste=this.value.split('-');
				$.each(produtos_autocomplete,function(i,item){
					if(teste[0]==item.id_produto && teste[1]==item.descricao)
					{
						$("#valor_unitario").text(item.preco);
						$("#quantidade").focus();
					}
				})
			
			});

			//adicionar tabela
			var conta = 0;
			var verificar = 0;
			$(".add-row").click(function(){
				var val=$("#input_produtos").val();

				var obj=$("#produtos_autocomplete").find("option[value='"+val+"']");

				var produto = $("#input_produtos").val();

				produto = produto.split("-");

 				if(obj !=null && obj.length>0){

 					$.each(produtos_autocomplete,function(i,item){
					if(produto[0]==item.id_produto && produto[1]==item.descricao)
					{
						var quantidade = $("#quantidade").val();
						var preco = parseFloat(item.preco);
						
						conta = conta + 1;

						$("#conta").val(conta);

						var markup = "<tr class='produtoRow'><td class='prod' style='width: 160px;'><input type='text' value='"+val+"' name='id"+conta+"' readonly='readonly'></td><td class='quant'><input type='text' class='number'  id='qtd' maxlength='2' size='2' class='form-control' min='1' value='"+quantidade+"' name='qtd"+conta+"' readonly='readonly'></td><td><input type='text' class='preco' value='"+preco+"' name='valor_unitario"+conta+"'  size='2' readonly='readonly'></td><th><input type='text' size='3' id='total' class='total' value='"+quantidade*preco+"' readonly='readonly'></th><td><button type='button' class='delete-row'>remover</button></td></tr>";
							$("table tbody ").append(markup);
							$("#valor_unitario").empty();
							$("#input_produtos").val("");
							var x=$("#total_total").val();
							x=Number(x);
							x += (quantidade*preco);
							
							$("#total_total").val(x);
							verificar++;
							$("#verifica").val(verificar);				
						}
					})
				}else{
    		 		alert("Produto inválido!");
	    		 	$("#input_produtos").val("");
	    		 	$("#input_produtos").focus();
	    		 	$("#valor_unitario").empty();
	    		 	verificar--;
	    		 	$("#verifica").val(verificar);
    			}
			});

			//remover tabela
			$("table tbody").on('click','.delete-row',function(){
				var valor_menos = $(this).closest('tr').find('th').find('input').val();
				var xx = $("#total_total").val();
				xx = xx - valor_menos;
				$("#total_total").val(xx);
				$(this).closest('tr').remove();
				verificar = verificar - 1;
			});

			// validar origem
			$("#origem").blur(function(){
			var val=$("#origem").val();
			var obj=$("#origens").find("option[value='"+val+"']");
			if(obj !=null && obj.length>0){
				return true;
			}
			else{
				alert("Destino inválido, por favor insira um destino válido");
				$("#origem").val("");
			}
		});
	});
	</script>
	
	<!-- Script para validar formulário -->
	<script>
		function validar(){
			var almox = document.getElementById("almoxarifado");
			var tipo = document.getElementById("tipo_entrada");
			var verificar = document.getElementById("verifica");
			if(almox.value == "blank"){
				alert("Selecione um almoxarifado");
				almox.focus();
				return false;
			}
			else if(tipo.value == "blank"){
				alert("Selecione o tipo da saida")
				tipo.focus();
				return false;
			}
			else if(verificar.value == 0){
				alert("Nenhum produto inserido");
				document.getElementById("input_produtos").focus();
				return false;
			}
		}
		
		$(function () {
	        $("#header").load("header.php");
	        $(".menuu").load("menu.html");
	      });
	</script>

	<!--CSS-->
	<style type="text/css">
		.body{
			position: relative;
		}
		.row{
			display: flex;
			flex-direction: row;
			justify-content: center;
			align-items: center;
		}
		.box{		
			padding-right: 34px;
			border-right-width: 23px;
			right: 50px;
			width: 796px;
		}
	</style>
</head>
<body>
	<section class="body">
		<!-- start: header -->
		<div id="header"></div>
      	<!-- end: header -->
      		<div class="inner-wrapper">
         	<!-- start: sidebar -->
         	<aside id="sidebar-left" class="sidebar-left menuu"></aside>
			<!-- end: sidebar -->
				
			<section role="main" class="content-body">
				<header class="page-header">
					<h2>Cadastro</h2>
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="home.php">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Cadastro</span></li>
							<li><span>Doação</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<!-- start: page -->
				<div class="row">
					<div class="col-md-8 col-lg-8 box">
						<ul class="nav nav-tabs tabs-primary">
							<li class="active">
								<a href="#overview" data-toggle="tab">Cadastro de Doação</a>
							</li>
						</ul>
						<div class="tab-content" style="width: 832px;">
							<div id="overview" class="tab-pane active">
								<form class="form-horizontal" method="post" id="formulario" onsubmit="return validar()" action="../controle/control.php" autocomplete="off">
									<fieldset>
										<div class="info-entrada" >
											<div class="form-group">
												<label class="col-md-3 control-label" >Destino</label>
												<div class="col-md-8">
													<input type="search" list="origens" id="origem" name="destino" class="form-control" autocomplete="off" required>
													<datalist id="origens">
													</datalist>
												</div>
												<a href="cadastro_destino.php"><i class="fas fa-plus w3-xlarge"></i></a>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label" >Almoxarifado</label>
												<div class="col-md-6">
													<select class="form-control " name="almoxarifado" id="almoxarifado">
														<option selected disabled value="blank">Selecionar</option>
													</select>
												</div>
												<a href="adicionar_almoxarifado.php"><i class="fas fa-plus w3-xlarge"></i></a>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label" >Tipo</label>
												<div class="col-md-6">
													<select class="form-control " name="tipo_saida" id="tipo_entrada">
														<option selected disabled value="blank">Selecionar</option>
													</select>
												</div>
												<a href="adicionar_tipoSaida.php"><i class="fas fa-plus w3-xlarge"></i></a>
											</div>
										</div>
										
										<div class="panel-body" >
											<table class="table table-bordered mb-none">
												<thead>
													<tr style="width: 768px;">
														<th>Produto
															<a href="cadastro_produto.php" class="fas fa-plus w3-xlarge" style="float:right;" id="produto" class="produto">
															</a>
														</th>
														<th>quantidade</th>
														<th>valor unitário</th>
														<th>incluir</th>
													</tr>
													<tr>
														<td>
															<input type="search" list="produtos_autocomplete" id="input_produtos" name="produtos_autocomplete" autocomplete="off" size="20" class="form-control">
															<datalist id="produtos_autocomplete">
															</datalist>
														</td>
														<td><input type="number" name="quantidade" style="width: 74px;" value="1" min="1" id="quantidade"></td>
														<td id="valor_unitario"></td>
														<td >	
															<button id="add-row incluir" type="button" class="add-row" >incluir</button>
														</td>
													</tr>
												</thead>
											</table><br>

											<div class="table-responsive">
												<table class="table table-bordered mb-none table">
													<thead>
														<tr>
															
															<th style="width: 160px;">Produto
															<th style="width: 85px;">Quantidade</th>
															<th>Preço</th>
															<th>Total</th>
															<th>Ação</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
													<tfoot>
														<tr >
															<td>Valor total:</td>
															<td id="valor-total">
															<input type="number" id="total_total"  name="total_total" readonly="readonly">
															<input type="hidden" id="conta" name="conta" readonly="readonly">
															<input type="hidden" id="verifica" disabled>
															</td>

														</tr>
													</tfoot>
												</table>
											</div>
										</div>
										<!--<button id="array">Pegar valores da tabela</button>
										<div id="resultado"></div>-->

									</fieldset><br>
									<div class="row">
										<div class="col-md-9 col-md-offset-3">
										    <input type="hidden" name="nomeClasse" value="SaidaControle">			
											<input type="hidden" name="metodo" value="incluir">
											<input type="submit" class="btn btn-primary" >
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- end: page -->
	</section>


	<!-- Vendor -->
	<script src="../assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="../assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
	<!-- Specific Page Vendor -->
	<script src="../assets/vendor/jquery-autosize/jquery.autosize.js"></script>
		
	<!-- Theme Base, Components and Settings -->
	<script src="../assets/javascripts/theme.js"></script>
		
	<!-- Theme Custom -->
	<script src="../assets/javascripts/theme.custom.js"></script>
	
	<!-- Theme Initialization Files -->
	<script src="../assets/javascripts/theme.init.js"></script>
	<script type="text/javascript">
	</script>
</body>
</html>