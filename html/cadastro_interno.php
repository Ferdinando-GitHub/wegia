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

	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Cadastro de Atendido</title>

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

	<!-- Vendor -->
	<script src="../assets/vendor/jquery/jquery.min.js"></script>
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

	<!-- javascript functions -->
	<script src="../Functions/onlyNumbers.js"></script>
	<script src="../Functions/onlyChars.js"></script>
	<script src="../Functions/enviar_dados.js"></script>
	<script src="../Functions/mascara.js"></script>
	<script src="../Functions/lista.js"></script>

	<!-- jquery functions -->
	<script>
		function testaCPF(strCPF) { //strCPF é o cpf que será validado. Ele deve vir em formato string e sem nenhum tipo de pontuação.
            var strCPF = strCPF.replace(/[^\d]+/g,''); // Limpa a string do CPF removendo espaços em branco e caracteres especiais. 
                                                        // PODE SER QUE NÃO ESTEJA LIMPANDO COMPLETAMENTE. FAVOR FAZER O TESTE!!!!
            var Soma;
            var Resto;
            Soma = 0;
            if (strCPF == "00000000000") return false;
            
            for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;
            
            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
            
            Soma = 0;
            for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;
            
            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
            return true;
    	}
	
	    function validarCPF(strCPF){
	    	if (!testaCPF(strCPF)){
    			$('#cpfInvalido').show();
    			document.getElementById("enviar").disabled = true;
    		}else{
    			$('#cpfInvalido').hide();
    			document.getElementById("enviar").disabled = false;
    		}
	    }
    
    	function desabilitar_cpf(){

    		if($("#nao_cpf").prop("checked")){
	    		document.getElementById("cpf").readOnly = true;
    			document.getElementById("enviar").disabled = false;
    			document.getElementById("imgCpf").style.display="none";
 		   	}else{
    			document.getElementById("cpf").readOnly = false;
    			document.getElementById("enviar").disabled = true;
    			document.getElementById("imgCpf").style.display="block";
    		}
		}

	    function registro_geral(){
    		if($("#registro").prop("checked"))
    		{
	    		document.getElementById("rg").readOnly=true;
    			document.getElementById("orgao").readOnly=true;
				document.getElementById("profileCompany").readOnly=true;
				document.getElementById("imgRg").style.display="none";
    		}else{
    			document.getElementById("rg").readOnly=false;
	    		document.getElementById("orgao").readOnly=false;
				document.getElementById("profileCompany").readOnly=false;
				document.getElementById("imgRg").style.display="block";
    		}
    	}

    	$(function () {
	        $("#header").load("header.php");
	        $(".menuu").load("menu.html");
	      });
	</script>
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
							<li><span>Cadastros</span></li>
							<li><span>Interno</span></li>
						</ol>
						<a class="sidebar-right-toggle"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<!-- start: page -->
				<div class="row">
					<div class="col-md-4 col-lg-3">
						<section class="panel">
							<div class="panel-body">
								<div class="thumb-info mb-md">
									<?php
										if($_SERVER['REQUEST_METHOD'] == 'POST'){
											if(isset($_FILES['imgperfil'])){
												$image = file_get_contents ($_FILES['imgperfil']['tmp_name']);
												session_start();
												$_SESSION['imagem']=$image;
	        									echo '<img src="data:image/gif;base64,'.base64_encode($image).'" class="rounded img-responsive" alt="John Doe">';
											}	
										}else{
									?>
											<img src="../img/semfoto.jpg" class="rounded img-responsive" alt="John Doe">
									<?php 
											}
									?>
									<i class="fas fa-camera-retro btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"></i>
									<div class="container">
										<div class="modal fade" id="myModal" role="dialog">
										    <div class="modal-dialog">
											    <!-- Modal content-->
											    <div class="modal-content">
											        <div class="modal-header">
											         	<button type="button" class="close" data-dismiss="modal">&times;</button>
											        	<h4 class="modal-title">Adicionar uma Foto</h4>
											        </div>
											    	<div class="modal-body">
											        	<form action="#" method="POST" enctype="multipart/form-data" >
											        		<div class="form-group">
																<label class="col-md-4 control-label" for="imgperfil">Carregue uma imagem de perfil:</label>
																<div class="col-md-8">
																	<input type="file" name="imgperfil" size="60" id="imgform" class="form-control">
																</div>
															</div>
											               	<div class="modal-footer">
											        			<input type="submit" id="formsubmit" value="Ok">
											        		</div>
											        	</form>
											    	</div>
											 	</div>
											</div>
										</div>
									</div>
								</div>
								<div class="widget-toggle-expand mb-md">
									<div class="widget-header">
										<div class="widget-content-expanded">
											<ul class="simple-todo-list">
											</ul>
										</div>
									</div>
								</div>
								<h6 class="text-muted"></h6>
							</div>
						</section>
					</div>

					<div class="col-md-8 col-lg-8">
						<div class="tabs">
							<ul class="nav nav-tabs tabs-primary">
								<li class="active">
									<a href="#overview" data-toggle="tab">Cadastro de Atendido</a>
								</li>
								<li>
									<a href="#documentacao" data-toggle="tab">Documentação</a>
								</li>
							</ul>
							<div class="tab-content">
								<div id="overview" class="tab-pane active">
									<h4 class="mb-xlg">Informações Pessoais</h4>
									<form id="formulario" action="../controle/control.php" enctype="multipart/form-data" method="POST">
										<div class="form-group">
											<label class="col-md-3 control-label">Nome</label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="nome" id="nome" id="profileFirstName" onkeypress="return Onlychars(event)" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Sobrenome</label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="sobrenome" id="sobrenome" onkeypress="return Onlychars(event)" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Sexo</label>
											<div class="col-md-8">
												<input type="radio" name="sexo" id="radio1" value="m" style="margin-top: 10px margin-left: 15px;" required><i class="fa fa-male" style="font-size: 20px;" required></i>
													<input type="radio" name="sexo" id="radio2"  value="f" style="margin-top: 10px; margin-left: 15px;"><i class="fa fa-female" style="font-size: 20px;"></i> 
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" >Nome Contato</label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="nomeContato" id="nomeContato" id="profileFirstName" onkeypress="return Onlychars(event)">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany">Telefone contato 1</label>
											<div class="col-md-8">
												<input type="text" class="form-control" maxlength="14" minlength="14" name="telefone1" id="telefone1" id="profileCompany" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany">Telefone contato 2</label>
											<div class="col-md-8">
												<input type="text" class="form-control" maxlength="14" minlength="14" name="telefone2" id="telefone2" id="profileCompany" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany">Telefone contato 3</label>
											<div class="col-md-8">
												<input type="text" class="form-control" maxlength="14" minlength="14" name="telefone3" id="telefone3" id="profileCompany" placeholder="Ex: (22)99999-9999" onkeypress="return Onlynumbers(event)" onkeyup="mascara('(##)#####-####',this,event)" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany">Nascimento</label>
											<div class="col-md-8">
												<input type="date" placeholder="dd/mm/aaaa" maxlength="10" class="form-control" name="nascimento" id="nascimento"  max=<?php echo date('Y-m-d'); ?> required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileName">Nome do Pai</label>
											<div class="col-md-8">
												<input type="text" name="pai" class="form-control"  onkeypress="return Onlychars(event)" id="pai" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileFirstName">Nome da Mãe</label>
											<div class="col-md-8">
												<input type="text" name="nomeMae" class="form-control" id="mae" id="profileFirstName" onkeypress="return Onlychars(event)" >
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="inputSuccess">Tipo Sanguíneo</label>
											<div class="col-md-6">
												<select name="sangue" id="sangue" class="form-control input-lg mb-md">
													<option selected disabled value="blank">Selecionar</option>
													<option value="A+">A+</option>
													<option value="A-">A-</option>
													<option value="B+">B+</option>
													<option value="B-">B-</option>
													<option value="O+">O+</option>
													<option value="O-">O-</option>
													<option value="AB+">AB+</option>
													<option value="AB-">AB-</option>
												</select>
											</div>	
										</div><br/>
									</div>
									<div id="documentacao" class="tab-pane">
										<h4 class="mb-xlg doch4">Documentação</h4>

										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany">Número do RG</label>
											<div class="col-md-4">
												<input type="text" class="form-control" name="rg" id="rg" onkeypress="return Onlynumbers(event)" placeholder="Ex: 22.222.222-2" required>
											</div>
											<div class="col-md-3"> 
												<label>Não possui RG
												<input type="checkbox" id="registro" name="naoPossuiRegistroGeral"  style="margin-left: 4px" onclick="return registro_geral()"></label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany">Órgão Emissor</label>
											<div class="col-md-6">
												<input type="text" name="orgaoEmissor" class="form-control" id="orgao" onkeypress="return Onlychars(event)">
											</div>
										</div>
											
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany">Data de Expedição</label>
											<div class="col-md-6">
													<input type="date" class="form-control" maxlength="10" placeholder="dd/mm/aaaa" id="profileCompany" name="dataExpedicao" id="data_expedicao"  max=<?php echo date('Y-m-d'); ?> required>
											</div>
										</div>
											
										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany">Número do CPF</label>
											<div class="col-md-4">
												<input type="text" class="form-control" id="cpf" name="numeroCPF" placeholder="Ex: 222.222.222-22" maxlength="14" onblur="validarCPF(this.value)" onkeypress="return Onlynumbers(event)" onkeyup="mascara('###.###.###-##',this,event)" required>
											</div>
											<div class="col-md-3"> 
												<label>Não possui CPF
												<input type="checkbox" id="nao_cpf" name="naoPossuiCpf"  style="margin-left: 4px" onclick="return desabilitar_cpf()">
													</label>
											</div>													
										</div>

										<div class="form-group">
											<label class="col-md-3 control-label" for="profileCompany"></label>
											<div class="col-md-6">
												<p id="cpfInvalido" style="display: none; color: #b30000">CPF INVÁLIDO!</p>
											</div>														
										</div>
											
										<hr class="dotted short">
										<div class="form-group">
											<label class="col-md-3 control-label">Benefícios</label>
	
											<div class="col-md-8 " >
												<div class="">
													<label>
														<input type="checkbox" name="certidao" value="Possui" id="certidao-checkbox" >Certidão de Nascimento			
													</label><br>
													<label>
														<input type="checkbox" name="certidaoCasamento" value="Possui" id="certidaoCasamento-checkbox" >Certidão de Casamento			
													</label><br>
													<label>
														<input type="checkbox" name="curatela" value="Possui" id="curatela-checkbox" >Curatela
													</label><br>
													<label>
														<input type="checkbox" name="inss" value="Possui" id="inss-checkbox" >INSS
													</label><br>
													
													<label>
														<input type="checkbox" name="loas" value="Possui" id="loas-checkbox" >LOAS
													</label><br>
													
													<label>
														<input type="checkbox" name="funrural" value="Possui" id="funrural-checkbox" >FUNRURAL
													</label><br>														
													<label>
														<input type="checkbox" name="tituloEleitor" value="Possui" id="tituloEleitor-checkbox" >Título de Eleitor
														<input type="hidden" name="nomeClasse" value="InternoControle">
														<input type="hidden" name="metodo" value="incluir">
													</label><br>
													
													<label>
														<input type="checkbox" name="ctps" value="Possui" id="ctps-checkbox" >CTPS
													</label><br>
													
													<label>
														<input type="checkbox" name="saf" value="Possui" id="saf-checkbox" >SAF
													</label><br>
													
													<label>
														<input type="checkbox" name="sus" value="Possui" id="sus-checkbox" >SUS
													</label><br>

													<label>
														<input type="checkbox" name="bpc" value="Possui" id="bpc-checkbox" >BPC
													</label><br>
												</div>
											</div><br>
											<hr class="dotted short">
											<h4 class="mb-xlg doch4" id="label-imagens" style="display: none;">Imagens</h4> 
											<div class="form-group" id="imgRg" style="display: block;">
												<label class="col-md-4 control-label" id="label-rg" for="imgRg" >RG:</label>
												<div class="col-md-8">
													<input type="file" name="imgRg" size="60"  class="form-control" >
												</div>
											</div>
											<div class="form-group" id="imgCpf"  style="display: block;">
												<label class="col-md-4 control-label" for="imgCpf" id="label-cpf">CPF:</label>
												<div class="col-md-8">
													<input type="file" name="imgCpf" size="60" class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgCertidaoNascimento" style="display: none;">
												<label class="col-md-4 control-label" for="imgCertidaoNascimento" id="label-certidao">Certidão de Nascimento:</label>
												<div class="col-md-8">
													<input type="file" name="imgCertidaoNascimento" size="60"  class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgCertidaoCasamento"  style="display: none;">
												<label class="col-md-4 control-label" for="imgCertidaoCasamento" id="label-CertidaoCasamento">Certidao de Casamento:</label>
												<div class="col-md-8">
													<input type="file" name="imgCertidaoCasamento" size="60" class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgCuratela" style="display: none;">
												<label class="col-md-4 control-label" id="label-curatela" for="imgCuratela">Curatela:</label>
												<div class="col-md-8">
													<input type="file" name="imgCuratela" size="60"  class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgInss" style="display: none;">
												<label class="col-md-4 control-label"  for="imgInss" id="label-inss">INSS:</label>
												<div class="col-md-8">
													<input type="file" name="imgInss" size="60"  class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgLoas" style="display: none;">
												<label class="col-md-4 control-label" id="label-loas"  for="imgLoas">LOAS:</label>
												<div class="col-md-8">
													<input type="file" name="imgLoas" size="60" class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgFunrural" style="display: none;">
												<label class="col-md-4 control-label" id="label-funrural" for="imgFunrural">FUNRURAL:</label>
												<div class="col-md-8">
													<input type="file" name="imgFunrural" size="60" class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgTituloEleitor" style="display: none;">
												<label class="col-md-4 control-label" id="label-titulo" for="imgTituloEleitor">Título de Eleitor:</label>
												<div class="col-md-8">
													<input type="file" name="imgTituloEleitor" size="60" class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgCtps" style="display: none;">
												<label class="col-md-4 control-label" id="label-ctps" for="imgCtps">CTPS:</label>
												<div class="col-md-8">
													<input type="file" name="imgCtps" size="60" class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgSaf" style="display: none;">
												<label class="col-md-4 control-label" id="label-saf" for="imgSaf">SAF:</label>
												<div class="col-md-8">
													<input type="file" name="imgSaf" size="60" class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgSus" style="display: none;">
												<label class="col-md-4 control-label" id="label-sus" for="imgSus">SUS:</label>
												<div class="col-md-8">
													<input type="file" name="imgSus" size="60" class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgBpc"  style="display: none;">
												<label class="col-md-4 control-label" for="imgBpc">BPC:</label>
												<div class="col-md-8">
													<input type="file" name="imgBpc" size="60"class="form-control">
												</div>
											</div>
											<div class="form-group" id="imgBpc"  style="display: none;">
												<label class="col-md-4 control-label" for="imgRg">BPC:</label>
												<div class="col-md-8">
													<input type="file" name="imgRg" size="60"class="form-control">
												</div>
											</div>
										</div><br/>

										<section class="panel">
											<header class="panel-heading">
												<div class="panel-actions">
													<a href="#" class="fa fa-caret-down"></a>
												</div>

												<h2 class="panel-title">Informações do Interno</h2>
											</header>
											<div class="panel-body" style="display: block;">
												<section class="simple-compose-box mb-xlg ">

														<textarea name="observacao" data-plugin-textarea-autosize placeholder="Observações" rows="1" style="height: 10vw"></textarea>
												</section>
											</div>
										</section>
									</div>
									</form>
									<div class="panel-footer">
										<div class="row">
											<div class="col-md-9 col-md-offset-3">
												<button id="enviar" class="btn btn-primary"  type="submit" disabled="true" >Enviar</button>  
											</div>
										</div>
									</div>										
								</div>
							</div>
						</div>
					</div>
						
				</div>
					<!-- end: page -->
			</section>
		</div>

		<aside id="sidebar-right" class="sidebar-right">
			<div class="nano">
				<div class="nano-content">
					<a href="#" class="mobile-close visible-xs">Collapse <i class="fa fa-chevron-right"></i></a>	
				</div>
			</div>
		</aside>
	</section>
	<!-- Vendor -->
	  <script src="../assets/vendor/jquery/jquery.js"></script>
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
</body>
</html>
