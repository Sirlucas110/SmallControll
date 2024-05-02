<?php 
	include_once 'includes/config.php';
	$pages = 'products';
?>

<main>
	<!-- Modal Edição de Dados -->
	<div class="modal" style="display:none">
		<div class="modal_container radius">
			<p class="text-right">
				<br><a href="#" title="Fechar a modal" class="btn_delete radius modal-close"><i class="fa fa-times-circle"></i></a>
			</p>
			
			<h1 class="text-center font-text-min">Editar Dados do Produto</h1>
			
			<form method="post" enctype="multipart/form-data" id="form_editProduct">
				<input type="hidden" name="product_id" id="product_id" required>

				<div class="divisor1">
					<input type="file" name="files" id="files" required accept="image/*" onchange="loadFile(event)" style="height: 42px !important; width: 94% !important; margin: 10px 3%!important;">
				</div>
				
				<div class="divisor2">
					<label for="product">Nome Produto</label>
					<input type="text" name="productEdit" id="productEdit" required>
				</div>
				
				<div class="divisor2">
					<label for="categoryEdit">Categoria Produto <a href="#" class="radius btn_search newCategory" style="padding: 2px 4px !important">Nova Categoria</a></label>
					<select name="categoryEdit" id="categoryEdit" required>
						<option value="n">Selecione uma opção</option>
					</select>
				</div>
				
				<div class="divisor2">
					<label for="priceEdit">Preço do Produto em R$</label><br>
					<input type="text" name="priceEdit" id="priceEdit" class="money" required>
				</div>
				
				<div class="divisor2">
					<label for="quantityEdit">Quantidade do Produto</label><br>
					<input type="text" name="quantityEdit" id="quantityEdit" required>
				</div>
				
				<div class="divisor2">
					<br><button name="btn_editproduct" id="btn_editproduct" class="btn_edit radius"><i class="fa fa-pen"></i> Atualizar Dados</button>
				</div>
			</form>
			
			<div class="clear"></div>
			<div class="espaco-medium"></div>
		</div>
	</div>
	
	<!-- Modal Novo Produto -->
	<div class="new" style="display:none;">
		<div class="modal_container radius">
			<p class="text-right">
				<br><a href="#" title="Fechar a modal" class="btn_delete radius modal-close"><i class="fa fa-times-circle"></i></a>
			</p>
			
			<h1 class="text-center font-text-min">Dados do Novo Produto</h1>
			
			<form method="post" enctype="multipart/form-data" id="form_newProduct">
				<div class="divisor1">
					<input type="file" name="files" id="files" required accept="image/*" onchange="loadFile(event)" style="height: 42px !important; width: 94% !important; margin: 10px 3%!important;">
				</div>
				
				<div class="divisor2">
					<label for="product">Nome Produto</label>
					<input type="text" name="product" id="product" required>
				</div>
				
				<div class="divisor2">
					<label for="category">Categoria Produto <a href="#" class="radius btn_search newCategory" style="padding: 2px 4px !important">Nova Categoria</a></label>
					<select name="category" id="category" required>
						<option value="n">Selecione uma opção</option>
						<?php
							$Read = $pdo->prepare("SELECT categoria_id, categoria_nome FROM " . DB_CATEGORY . "");
							$Read -> execute();

							foreach($Read as $Show){
						?>
							<option value="<?= strip_tags($Show['categoria_id'])?>"><?= strip_tags($Show['categoria_nome'])?></option>
						<?php } ?>
					</select>
				</div>
				
				<div class="divisor2">
					<label for="price">Preço do Produto em R$</label><br>
					<input type="text" name="price" id="price" class="money" required>
				</div>
				
				<div class="divisor2">
					<label for="quantity">Quantidade do Produto</label><br>
					<input type="text" name="quantity" id="quantity" required>
				</div>
				
				<div class="divisor2">
					<br><button name="btn_newproduct" id="btn_editproduct" class="btn_new radius"><i class="fa fa-pen"></i> Cadastrar Dados</button>
				</div>
			</form>
			
			<div class="clear"></div>
			<div class="espaco-medium"></div>
		</div>
	</div>
	
	<!-- Modal Deletar Produto -->
	<div class="delete" style="display:none">
		<div class="modal_container radius">
			<div class="espaco-medium"></div>
			<h1 class="text-center font-text-min">Você Deseja Remover Este Produto?</h1>
			<p class="text-center"><br>
				<a href="#" title="Remover este Produto" class="btn_edit radius removeProduct"><i class="fa fa-check"></i> SIM </a>&nbsp;&nbsp;
				<a href="#" title="Fechar a modal" class="btn_delete radius modal-close"><i class="fa fa-times-circle"></i> NÃO</a>
			</p>
			
			<div class="clear"></div>
			<div class="espaco-medium"></div>
		</div>
	</div>
	
	<!-- Modal Nova Categoria -->
	<div class="category" style="display:none">
		<div class="modal_container radius">
		<p class="text-right">
				<br><a href="#" title="Fechar a modal" class="btn_delete radius modal-close-cat"><i class="fa fa-times-circle"></i></a>
			</p>
			
			<h1 class="text-center font-text-min">Dados do Nova Categoria</h1>
			
			<form method="post" enctype="multipart/form-data" id="form_newCategory">
				
				<div class="divisor2">
					<label for="categoryName">Nome Categoria</label>
					<input type="text" name="categoryName" id="categoryName" required>
				</div>
				
				<div class="divisor2">
					<br><button name="btn_newcategory" id="btn_newcategory" class="btn_new radius"><i class="fa fa-pen"></i> Cadastrar Dados</button>
				</div>
			</form>
			
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
				<form method="post" id="form_product">
					<div class="espaco-min"></div>
					<h2 class="text-margin text-center">Digite o termo abaixo e selecione uma opção para sua consulta.</h2>
					<div class="divisor2">
						<label for="searching">Busca Por Produto:</label>
						<input type="text" name="searching" id="searching" placeholder="Ex. açucar refinado" required>
					</div>

                    <br>
					<div class="divisor2" style="display: flex; justify-content: center; align-items: center;">
						<button name="btn_product" id="btn_product" class="btn_edit radius" style="float: left"><i class="fa fa-search"></i> Pesquisar</button>
						
						<a href="#" class="btn_new radius font-text-sub newProduct"><i class="fa fa-plus-circle"></i> NOVO</a>
					</div>
					
					<div class="clear"></div>
					<div class="espaco-min"></div>
				</form>
				
				<table class="row"></table>
				
			</div>
			<div class="espaco-min"></div>
		</article>
	</section>
	<div class="clear"></div>
</main>
	