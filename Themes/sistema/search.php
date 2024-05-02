<?php 
	include_once 'includes/config.php';
	$pages = 'search';
?>

	<main>
		<section class="content_left">
			<!-- Chama o menu da página-->
			<?php require 'includes/left.php';?>
		</section>
		
		<section class="content_right more">
			<!-- Chama o cabeçalho da página-->
			<?php require 'includes/header.php';?>
			
			<article class="bgcolor-white">
				
				<div class="searching">
					<form method="post" id="form_search">
						<div class="espaco-min"></div>
						<h2 class="text-margin text-center">Digite o termo abaixo e selecione uma opção para sua consulta.</h2>
						<div class="divisor3">
							<label for="searching">Digite o termo:</label>
							<input type="text" name="searching" id="searching" placeholder="Ex. josé da silva" required>
						</div>
						
						<div class="divisor3">
							<label for="type">Busca Por Tipo:</label>
							<select name="type" id="type" required>
								<option value="n"> Escolha uma opção </option>
								<option value="1"> Produto </option>
								<option value="2"> Cliente </option>
								<option value="3"> Fornecedor </option>
								<option value="2"> Estoque </option>
								<option value="5"> Pedido </option>
							</select>
						</div>
						
						<div class="divisor3">
							<br><button name="btn_search" id="btn_search" class="btn_edit radius"><i class="fa fa-search"></i> Pesquisar</button>
						</div>
						
						<div class="clear"></div>
						<div class="espaco-min"></div>
					</form>
					
					<table>
						<tr>
							<td>
								<p class="font-text-sub"><b>Nome/Empresa:</b></p>
								<p>José da Silva</p>
							</td>
							
							<td>
								<p class="font-text-sub"><b>Perfil:</b></p>
								<p>Cliente</p>
							</td>
							
							<td>
								<p class="font-text-sub"><b>E-mail:</b></p>
								<p>jose@gmail.com</p>
							</td>
							
							<td>
								<p class="font-text-sub"><b>Status:</b></p>
								<p class="font-text-min">
									<span class="active radius"> ATIVO </span>
								</p>
							</td>
							
							<td>
								<p class="font-text-sub"><b>Cadastrado:</b></p>
								<p class="font-text-min">12/02/2022</p>
							</td>
						</tr>
					</table>
					
				</div>
				<div class="espaco-min"></div>
			</article>
			<div class="espaco-min"></div>
		</section>
	<div class="clear"></div>
	</main>