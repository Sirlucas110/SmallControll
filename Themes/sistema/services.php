<?php 
	include_once 'includes/config.php';
	$pages = 'services';
?>
	<main>
		<!-- Modal visualizar pedido -->
		<div class="new" style="display:none">
			<div class="modal_container radius">
				<p class="text-right">
					<br><a href="#" title="Fechar a modal" class="btn_delete radius modal-close"><i class="fa fa-times-circle"></i></a>
				</p>
				
				<h1 class="text-center font-text-min">Dados do Pedido</h1>
				
				<form method="post" enctype="multipart/form-data" id="form_Order">
					
					<div class="divisor2">
						<label for="numberOrder">Nº Pedido*</label>
						<input type="text" name="numberOrder" id="numberOrder" readonly required>
					</div>
					
					<div class="divisor2">
						<label for="typeOrder">Tipo de Situação*</a></label>
						<select name="typeOrder" id="typeOrder" required>
							<option value="n">Selecione uma opção</option>
							<option value="1"> Liberado </option>
							<option value="2"> Despachado </option>
							<option value="3"> Cancelado </option>
						</select>
					</div>
					
					<div class="clear"></div>
					
					<div class="divisor1">
						<h1 class="font-text-min font-weight-medium"  style="margin: 10px 2% !important;">Lista do Pedido</h1>
						<div class="loaderOrder">
						<table style="width: 96% !important; margin: 10px 2% !important;">
							<tbody>
								<?php
								$Session = strip_tags($_SESSION['order']);
								$Read = $pdo->prepare("SELECT pedido_id, pedido_sessao, pedido_numero, pedido_nf, pedido_produto_id, pedido_produto_nome, pedido_quantidade, pedido_quantidade_estoque, pedido_valor FROM " .DB_ORDERS. " WHERE pedido_sessao = :pedido_sessao OR pedido_numero = :pedido_numero");
								$Read->bindValue(':pedido_sessao', $Session);
								$Read->bindValue(':pedido_numero', $Session);
								$Read->execute();

								$Lines = $Read->rowCount();

								if($Lines == 0){
									echo '<tr><td>Não há nenhum produto nesse pedido!</td></tr>';
								}

								foreach($Read as $Show):


								?>
								<tr>
									<td>
										<p class="font-text-sub"><b>Produto:</b></p>
										<p><?= strip_tags($Show['pedido_produto_nome']) ?></p>
									</td>
									
									<td>
										<p class="font-text-sub"><b>Quantidade:</b></p>
										<p><?= strip_tags($Show['pedido_quantidade']) ?></p>
									</td>
									
									<td>
										<p class="font-text-sub"><b>Valor:</b></p>
										<p>R$ <?= strip_tags(number_format($Show['pedido_valor'], 2, ',', '.')) ?></p>
									</td>
								</tr>
								<?php endforeach;?>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="divisor2">
						<br><button name="btn_editservices" id="btn_editservices" class="btn_new radius"><i class="fa fa-pen"></i> Pedido Coletado</button>
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
					<form method="post" id="form_searchOS">
						<div class="espaco-min"></div>
						<h2 class="text-margin text-center">Digite o termo abaixo ou selecione uma opção para sua consulta.</h2>
						<div class="divisor3">
							<label for="searching">Busca Por Nº do Pedido:</label>
							<input type="text" name="searching" id="searching" placeholder="Ex. 12345" required>
						</div>
						
						<div class="divisor3">
							<label for="type">Busca Por Situação:</label>
							<select name="type" id="type" required>
								<option value="n"> Escolha uma opção </option>
								<option value="1"> Liberado </option>
								<option value="2"> Despachado </option>
								<option value="3"> Cancelado </option>
							</select>
						</div>

                        <br>
						<div class="divisor3" style="display: flex; justify-content: center; align-items: center;">
							<button name="btn_searchOS" id="btn_searchOS" class="btn_edit radius" style="float: left"><i class="fa fa-search"></i> Pesquisar</button>
						</div>
						
						<div class="clear"></div>
						<div class="espaco-min"></div>
					</form>
					
					<table class="rowOS"></table>
					
				</div>
				<div class="espaco-min"></div>
			</article>
			<div class="espaco-min"></div>
		</section>
	<div class="clear"></div>
	</main>
