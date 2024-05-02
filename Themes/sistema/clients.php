<?php
    ob_start();
	//session_start();
	include_once 'includes/config.php';
	$pages = 'clients';
  	$_SESSION['blocked'] = 0;
    //Verifica a existencia de login via sessões
    if(!$_SESSION['user_firstname'] || !$_SESSION['user_level'] || !$_SESSION['user_email'] || !$_SESSION['user_token'] || !$_SESSION['user_id'] ||!$_SESSION['logged'] && $_SESSION['user_level'] <= 8 ||  $_SESSION['blocked'] == 1) {
        session_destroy();
        unset($_SESSION['user_firstname']);
        unset($_SESSION['user_level']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_token']);
        unset($_SESSION['logged']);
        header('location:../login.php');
    }
	//var_dump($_SESSION['user_firstname'], $_SESSION['user_level'], $_SESSION['user_email'], $_SESSION['user_token'], $_SESSION['user_id'], $_SESSION['logged'], $_SESSION['blocked']); 
?>

	<main>
		<!-- Modal Edição de Dados -->
		<div class="modal" style="display:none">

			<div class="modal_container radius">
				<p class="text-right">
					<br><a href="#" title="Fechar a modal" class="btn_delete radius modal-close"><i class="fa fa-times-circle"></i></a>
				</p>
				
				<h1 class="text-center font-text-min">Editar Dados do Cliente</h1>
				
				<form method="post" enctype="multipart/form-data" id="form_editclient">
					<input type="hidden" id="client_id" name="client_id">

					<div class="divisor2">
						<label for="imagem">Foto do Cliente</label><br>
						<input type="file" name="file" id="file" accept="image/*">
					</div>
						
					<div class="divisor2">
						<label for="client">Nome do Cliente</label><br>
						<input type="text" name="client" id="client" value="">
					</div>
						
					<div class="divisor2">
						<label for="email">E-mail</label><br>
						<input type="email" name="email" id="email" value="">
					</div>
						
					<div class="divisor2">	
						<label for="phone">Telefone</label><br>
						<input type="text" name="phone" maxlength="14" class="phone" id="phone" value="">
					</div>
						
					<div class="divisor2">	
						<label for="doc">Escolha o Tipo de Documento</label><br>
						<select name="doc" id="doc">
							<option value="n">Selecione uma opção</option>
							<option	value="1">CPF</option>
							<option	value="2">CNPJ</option>
						</select>
					</div>
						
					<div class="divisor2 cpf">	
						<label for="cpf">CPF</label><br>
						<input type="text" name="cpf" maxlength="14" id="cpf" class="cpf">
					</div>
						
					<div class="divisor2 cnpj" style="display:none">	
						<label for="cnpj">CNPJ</label><br>
						<input type="text" name="cnpj" maxlength="18" id="cnpj" class="cnpj" >
					</div>
						
					<div class="divisor2">	
						<label for="zipcode">CEP</label><br>
						<input type="text" name="zipcode" maxlength="9" id="zipcode" class="zipcode" >
					</div>
						
					<div class="divisor2">	
						<label for="address">Endereço Completo</label><br>
						<input type="text" name="address" id="address"  class="address" required value="">
					</div>
						
					<div class="divisor2">	
						<label for="number">Número do Endereço</label><br>
						<input type="text" name="number" id="number" required value="">
					</div>
						
					<div class="divisor2">	
						<label for="neighborhood">Bairro</label><br>
						<input type="text" name="neighborhood" id="neighborhood" class="neighborhood" required>
					</div>
						
					<div class="divisor2">	
						<label for="city">Cidade</label><br>
						<input type="text" name="city" id="city" class="city" required value="">
					</div>
						
					<div class="divisor2">	
						<label for="state">Estado</label><br>
						<input type="text" name="state" id="state" class="state" required value="">
						
					</div>
					
					<div class="divisor2">
						<br><button name="btn_editclient" id="btn_editclient" class="btn_edit radius"><i class="fa fa-pen"></i> Atualizar Dados</button>
					</div>
					
				</form>
				
				<div class="clear"></div>
				<div class="espaco-medium"></div>
			</div>
		</div>
		
		<!-- Modal Novo Usuário -->
		<div class="new" style="display:none;">
			<div class="modal_container radius">
				<p class="text-right">
					<br><a href="#" title="Fechar a modal" class="btn_delete radius modal-close"><i class="fa fa-times-circle"></i></a>
				</p>
				
				<h1 class="text-center font-text-min">Dados do Novo Cliente</h1>
				
				<form method="post" enctype="multipart/form-data" id="form_clientNew">
					<div class="divisor2">
						<label for="imagem">Foto do Cliente</label><br>
						<input type="file" name="files"  accept="image/*" onchange="loadFile(event)">
					</div>
						
					<div class="divisor2">
						<label for="client">Nome do Cliente</label><br>
						<input type="text" name="client" id="client" >
					</div>
						
					<div class="divisor2">
						<label for="email">E-mail</label><br>
						<input type="email" name="email" id="email" >
					</div>
						
					<div class="divisor2">	
						<label for="phone">Telefone</label><br>
						<input type="text" name="phone" maxlength="14" class="phone" id="phone" >
					</div>
						
					<div class="divisor2">	
						<label for="doc">Escolha o Tipo de Documento</label><br>
						<select name="doc" id="doc">
							<option value="n">Selecione uma opção</option>
							<option	value="1">CPF</option>
							<option	value="2">CNPJ</option>
						</select>
					</div>
						
					<div class="divisor2 cpf">	
						<label for="cpf">CPF</label><br>
						<input type="text" name="cpf" maxlength="14" id="cpf" class="cpf">
					</div>
						
					<div class="divisor2 cnpj" style="display:none">	
						<label for="cnpj">CNPJ</label><br>
						<input type="text" name="cnpj" maxlength="18" id="cnpj" class="cnpj">
					</div>
						
					<div class="divisor2">	
						<label for="zipcode">CEP</label><br>
						<input type="text" name="zipcode" maxlength="9" id="zipcode" class="zipcode">
					</div>
						
					<div class="divisor2">	
						<label for="address">Endereço Completo</label><br>
						<input type="text" name="address" id="address"  class="address">
					</div>
						
					<div class="divisor2">	
						<label for="number">Número do Endereço</label><br>
						<input type="text" name="number" id="number">
					</div>
						
					<div class="divisor2">	
						<label for="neighborhood">Bairro</label><br>
						<input type="text" name="neighborhood" id="neighborhood" class="neighborhood">
					</div>
						
					<div class="divisor2">	
						<label for="city">Cidade</label><br>
						<input type="text" name="city" id="city" class="city">
					</div>
						
					<div class="divisor2">	
						<label for="state">Estado</label><br>
						<input type="text" name="state" id="state" class="state">
						
					</div>
					
					<div class="divisor2">
						<br><button name="btn_newclient" id="btn_newclient" class="btn_new radius"><i class="fa fa-pen"></i> Cadastrar Dados</button>
					</div>
					
				</form>
				
				<div class="clear"></div>
				<div class="espaco-medium"></div>
			</div>
		</div>
		
		<!-- Modal Deletar Usuário -->
		<div class="delete" style="display:none">
			<div class="modal_container radius">
				<div class="espaco-medium"></div>
				<h1 class="text-center font-text-min">Você Deseja Remover Este Cliente?</h1>
				<p class="text-center"><br>
					<a href="#" title="Remover este cliente" class="btn_edit radius removeClient" data-id=""><i class="fa fa-check"></i> SIM </a>&nbsp;&nbsp;
					<a href="#" title="Fechar a modal" class="btn_delete radius modal-close"><i class="fa fa-times-circle"></i> NÃO</a>
				</p>
				
				<div class="clear"></div>
				<div class="espaco-medium"></div>
			</div>
		</div>
	
		<section class="content_left">
			<!-- Chama o menu da página-->
			<?php require 'includes/left.php';?>
		</section>
		
		<section class="content_right">
			<!-- Chama o cabeçalho da página-->
			<?php require 'includes/header.php';?>
			
			<article class="bgcolor-white">
				
				<div class="searching">
					<form method="post" id="form_search">
						<div class="espaco-min"></div>
						<h2 class="text-margin text-center">Digite o termo abaixo e selecione uma opção para sua consulta.</h2>
						<div class="divisor2">
							<label for="searching">Busca Por Cliente:</label>
							<input type="text" name="searching" id="searching" placeholder="Ex. josé da silva" required>
						</div>

                        <br>
						<div class="divisor2" style="display: flex; justify-content: center; align-items: center;">
							<button name="btn_search" id="btn_search" class="btn_edit radius" style="float: left"><i class="fa fa-search"></i> Pesquisar</button>
							
							<a href="#" class="btn_new radius font-text-sub newClient"><i class="fa fa-plus-circle"></i> NOVO</a>
						</div>
						
						<div class="clear"></div>
						<div class="espaco-min"></div>
					</form>
					
					<div class="tabless">
						<table class="row"></table>
					</div>
					
				</div>
				<div class="espaco-min"></div>
			</article>
			
			<div class="espaco-min"></div>
		</section>
	<div class="clear"></div>
	</main>
	