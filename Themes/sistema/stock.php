<?php 
	include_once 'includes/config.php';
	$pages = 'stock';
?>

	<main>
		<!-- Modal Edição de Dados -->
		<div class="modal" style="display:none">
			<div class="modal_container radius">
				<p class="text-right">
					<br><a href="#" title="Fechar a modal" class="btn_delete radius modal-close"><i class="fa fa-times-circle"></i></a>
				</p>
				
				<h1 class="text-center font-text-min">Editar Dados do Estoque</h1>
				
				<form method="post" enctype="multipart/form-data" id="form_editStock">
					<input type="hidden" name="idStock" id="idStock" value="" required>
					<input type="hidden" name="qtdStock" id="qtdStock" value="" required>
					
					<div class="divisor2">
						<label for="product">Produto*</label>
						<input type="text" name="product" id="productEditStock" required>
					</div>
					
					<div class="divisor2">
						<label for="quantity">Quantidade*</label>
						<input type="text" name="quantity" id="quantityEditStock" required>
					</div>
					
					<div class="divisor2">
						<label for="type">Tipo de Operação*</label>
						<select name="type" id="typeEditStock" required>
							<option value="n">Selecione uma opção</option>
							<option value="1">Entrada</option>
							<option value="2">Saída</option>
							<option value="3">Devolução</option>
						</select>
					</div>
					
					<div class="divisor2">
						<label for="status">Status*</label>
						<select name="status" id="statusEditStock" required>
							<option value="n">Selecione uma opção</option>
							<option value="1">Aguardando</option>
							<option value="2">Liberado</option>
						</select>
					</div>

					<div class="inputDevolution" style="display: none">
						<div class="divisor3">
							<label for="nfEditStock">Nota Fiscal*</label>
							<input type="text" name="nfEditStock" id="nfEditStock">
						</div>

						<div class="divisor3">
							<label for="nfValueEditStock">Valor da Nota Fiscal*</label>
							<input type="text" name="nfValueEditStock" id="nfValueEditStock" class="money">
						</div>

						<div class="divisor3">
							<label for="providerEditStock">Fornecedor*</label>
							<input type="text" name="providerEditStock" id="providerEditStock">
						</div>
						<div class="clear"></div>
						<div class="divisor1">
							<label for="msgEditStock">Motivo*</label>
							<textarea name="msgEditStock" id="msgEditStock"></textarea>
						</div>
					</div>
					
					<div class="divisor2">
						<br><button name="btn_editstock" id="btn_editstock" class="btn_edit radius"><i class="fa fa-pen"></i> Atualizar Dados</button>
					</div>
				</form>
				
				<div class="clear"></div>
				<div class="espaco-medium"></div>
			</div>
		</div>
		
		<!-- Modal Novo Estoque -->
		<div class="new" style="display:none;">
			<div class="modal_container radius">
				<p class="text-right">
					<br><a href="#" title="Fechar a modal" class="btn_delete radius modal-close"><i class="fa fa-times-circle"></i></a>
				</p>
				
				<h1 class="text-center font-text-min">Dados do Novo Estoque</h1>
				
				<form method="post" enctype="multipart/form-data" id="form_newStock">
					
					<div class="divisor3">
						<label for="invoiceNew">Nota Fiscal*</label>
						<input type="text" name="invoiceNew" id="invoiceNew" required>
					</div>

					<div class="divisor3">
						<label for="invoiceValueNew">Valor da Nota Fiscal*</label>
						<input type="text" name="invoiceValueNew" id="invoiceValueNew" required class="money">
					</div>

					<div class="divisor3">
						<label for="product">Produto*</label>
						<input type="text" name="productNew" id="productNew" required>
					</div>
					
					<div class="divisor3">
						<label for="quantity">Quantidade*</label>
						<input type="text" name="quantityNew" id="quantityNew" required>
					</div>
					
					<div class="divisor3">
						<label for="unity">Medida*</label>
						<input type="text" name="unity" id="unity" required>
					</div>

					<div class="divisor3">
						<label for="vality">Validade*</label>
						<input type="text" name="vality" id="vality" required>
					</div>

					<div class="divisor3">
						<label for="provider">Fornecedor*</label>
						<input type="text" name="provider" id="provider" required>
					</div>

					<div class="divisor3">
						<label for="type">Tipo de Operação*</label>
						<select name="typeNew" id="typeNew" required>
							<option value="n">Selecione uma opção</option>
							<option value="1">Entrada</option>
							<option value="2">Saída</option>
							<option value="3">Devolução</option>
						</select>
					</div>
					
					<div class="divisor3">
						<label for="statusNew">Status*</label>
						<select name="statusNew" id="statusNew" required>
							<option value="n">Selecione uma opção</option>
							<option value="1">Aguardando</option>
							<option value="2">Liberado</option>
						</select>
					</div>

					<div class="divisor2 activeInputs" style="display: none">
						<label for="sender">Data de despacho*</label>
						<input type="date" name="sender" id="sender">
					</div>

					<div class="divisor2 activeInputs" style="display: none">
						<label for="product_sender">Produto Liberado*</label>
						<input type="text" name="product_sender" id="product_sender">
					</div>

					<div class="divisor1 activeInputs" style="display: none">
						<label for="observation">Motivo*</label>
						<textarea name="observation" id="observation"></textarea>
					</div>
					
					<div class="divisor2">
						<br><button name="btn_newstock" id="btn_newstock" class="btn_new radius"><i class="fa fa-pen"></i> Cadastrar Dados</button>
					</div>
				</form>
				
				<div class="clear"></div>
				<div class="espaco-medium"></div>
			</div>
		</div>
		
		<!-- Modal Deletar Estoque -->
		<div class="delete" style="display:none">
			<div class="modal_container radius">
				<div class="espaco-medium"></div>
				<h1 class="text-center font-text-min">Você Deseja Remover Esta Operação?</h1>
				<p class="text-center"><br>
					<a href="#" title="Remover esta operação" class="btn_edit radius removeStock"><i class="fa fa-check"></i> SIM </a>&nbsp;&nbsp;
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
					<form method="post" id="formSearchStock">
						<div class="espaco-min"></div>
						<h2 class="text-margin text-center">Digite o termo abaixo ou selecione uma opção para sua consulta.</h2>
						<div class="divisor3">
							<label for="searching">Digite o nº da Nota Fiscal:</label>
							<input type="text" name="searching" id="searching" placeholder="Ex. 12345" required>
						</div>
						
						<div class="divisor3">
							<label for="type">Busca Por Tipo:</label>
							<select name="type" id="type" required>
								<option value="n"> Escolha uma opção </option>
								<option value="1"> Entrada </option>
								<option value="2"> Saída </option>								
								<option value="3"> Devolução </option>
							</select>
						</div>

						<br>
						<div class="divisor3" style="display: flex; justify-content: center; align-items: center;">
							<button name="btn_search" id="btnSearchStock" class="btn_edit radius btnSearchStock" style="float: left"><i class="fa fa-search"></i> Pesquisar</button>
							
							<a href="#" class="btn_new radius font-text-sub newStock"><i class="fa fa-plus-circle"></i> NOVO</a>
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
