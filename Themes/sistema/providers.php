<?php 
    ob_start();
	//session_start();
	include_once 'includes/config.php';
	$pages = 'providers';
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
 

?>

	<main>
		<!-- Modal Edição de Dados -->
		<div class="modal" style="display:none">

			<div class="modal_container radius">
				<p class="text-right">
					<br><a href="#" title="Fechar a modal" class="btn_delete radius modal-close"><i class="fa fa-times-circle"></i></a>
				</p>
				
				<h1 class="text-center font-text-min">Editar Dados do Fornecedor</h1>
				
				<form method="post" enctype="multipart/form-data" id="form_editprovider">
					<input type="hidden" name="provider_id" id="provider_id" required>
					<div class="divisor2">
						<label for="imagem">Foto do Fornecedor</label><br>
						<input type="file" name="files" id="files" accept="image/*" onchange="loadFile(event)">
					</div>
						
					<div class="divisor2">
						<label for="company">Empresa</label><br>
						<input type="text" name="company" id="company" required>
					</div>
						
					<div class="divisor2">
						<label for="email">E-mail</label><br>
						<input type="email" name="email" id="email" required>
					</div>
						
					<div class="divisor2">	
						<label for="phone">Telefone</label><br>
						<input type="text" name="phone" maxlength="14" class="phone" id="phone" required>
					</div>
					
					<div class="divisor2">	
						<label for="cnpj">CNPJ</label><br>
						<input type="text" name="cnpj" maxlength="18" id="cnpj" class="cnpj">
					</div>
						
					<div class="divisor2">	
						<label for="zipcode">CEP</label><br>
						<input type="text" name="zipcode" maxlength="9" id="zipcode" class="zipcode">
					</div>
						
					<div class="divisor2">	
						<label for="address">Endereço Completo</label><br>
						<input type="text" name="address" id="address"  class="address" required>
					</div>
						
					<div class="divisor2">	
						<label for="number">Número do Endereço</label><br>
						<input type="text" name="number" id="number" required>
					</div>
						
					<div class="divisor2">	
						<label for="neighborhood">Bairro</label><br>
						<input type="text" name="neighborhood" id="neighborhood" class="neighborhood" required>
					</div>
						
					<div class="divisor2">	
						<label for="city">Cidade</label><br>
						<input type="text" name="city" id="city" class="city" required>
					</div>

					<div class="divisor2">
						<label for="state">Estado</label><br>
						<input type="text" name="state" id="state" class="state" required>

					</div>

					<div class="divisor2">
						<br><button name="btn_editprovider" id="btn_editprovider" class="btn_edit radius"><i class="fa fa-pen"></i> Atualizar Dados</button>
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
				
				<h1 class="text-center font-text-min">Dados do Novo Fornecedor</h1>
				
				<form method="post" enctype="multipart/form-data" id="form_providerNew">
					<div class="divisor2">
						<label for="imagem">Foto do Fornecedor</label><br>
						<input type="file" name="files" id="files" required accept="image/*" onchange="loadFile(event)">
					</div>
						
					<div class="divisor2">
						<label for="company">Nome do Fornecedor</label><br>
						<input type="text" name="company" id="company" required>
					</div>
						
					<div class="divisor2">
						<label for="email">E-mail</label><br>
						<input type="email" name="email" id="email" required>
					</div>
						
					<div class="divisor2">	
						<label for="phone">Telefone</label><br>
						<input type="text" name="phone" maxlength="14" class="phone" id="phone" required>
					</div>
					
					<div class="divisor2">	
						<label for="cnpj">CNPJ</label><br>
						<input type="text" name="cnpj" maxlength="18" id="cnpj" class="cnpj">
					</div>
						
					<div class="divisor2">	
						<label for="zipcode">CEP</label><br>
						<input type="text" name="zipcode" maxlength="9" id="zipcode" class="zipcode" required>
					</div>
						
					<div class="divisor2">	
						<label for="address">Endereço Completo</label><br>
						<input type="text" name="address" id="address"  class="address" required>
					</div>
						
					<div class="divisor2">	
						<label for="number">Número do Endereço</label><br>
						<input type="text" name="number" id="number" required>
					</div>
						
					<div class="divisor2">	
						<label for="neighborhood">Bairro</label><br>
						<input type="text" name="neighborhood" id="neighborhood" class="neighborhood" required>
					</div>
						
					<div class="divisor2">	
						<label for="city">Cidade</label><br>
						<input type="text" name="city" id="city" class="city" required>
					</div>
						
					<div class="divisor2">
						<label for="state">Estado</label><br>
						<input type="text" name="state" id="state" class="state" required>
						
					</div>

					<div class="divisor2">
						<br><button name="btn_newprovider" id="btn_newprovider" class="btn_new radius"><i class="fa fa-pen"></i> Cadastrar Dados</button>
					</div>
					
				</form>
				
				<div class="clear"></div>
				<div class="espaco-medium"></div>
			</div>
		</div>
		
		<!-- Modal Deletar Fornecedor -->
		<div class="delete" style="display:none">
			<div class="modal_container radius">
				<div class="espaco-medium"></div>
				<h1 class="text-center font-text-min">Você Deseja Remover Este Fornecedor?</h1>
				<p class="text-center"><br>
					<a href="#" title="Remover este Fornecedor" class="btn_edit radius removeProvider"><i class="fa fa-check"></i> SIM </a>&nbsp;&nbsp;
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
					<form method="post" id="form_search_providers">
						<div class="espaco-min"></div>
						<h2 class="text-margin text-center">Digite o termo abaixo e selecione uma opção para sua consulta.</h2>
						<div class="divisor2">
							<label for="searching"> Buscar por Razão Social:</label>
							<input type="text" name="searching" id="searching" placeholder="Ex. Empresa 1 " required>
						</div>

                        <br>
						<div class="divisor2" style="display: flex; justify-content: center; align-items: center;">
							<button name="btn_search_providers" id="btn_search_providers" class="btn_edit radius" style="float: left"><i class="fa fa-search"></i> Pesquisar</button>
							
							<a href="#" class="btn_new radius font-text-sub newProvider"><i class="fa fa-plus-circle"></i> NOVO</a>
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
	