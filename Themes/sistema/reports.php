<?php 
	include_once 'includes/config.php';
	$pages = 'reports.php';
?>

<!-- Não imprimir menu, header e footer -->
<style media="print">
	@media print{
		.noPrint{
		   display: none !important;
		}
	   
		table td{padding: 1% 0%; border: 2px solid #eee !important; font-size: 1em;}
	}
	
</style>

<main>
	<section class="content_left noPrint">
		<!-- Chama o menu da página-->
		<?php require 'includes/left.php';?>
	</section>
	
	<section class="content_right">
		<!-- Chama o cabeçalho da página-->
		<?php require 'includes/header.php';?>
		
		<article class="bgcolor-white">
			
			<div class="searching">
				<form method="post" id="form_search" class="noPrint">
					<div class="espaco-min"></div>
					<h2 class="text-margin text-center">Escolha as opções abaixo para sua consulta.</h2>
					<div class="divisor4">
						<label for="searching">Busca Por Tipo:</label>
						<select name="searching" id="searching" required>
							<option value="n"> Escolha uma opção</option>
							<option value="1"> Produtos</option>
							<option value="2"> Entrada </option>
							<option value="3"> Saída </option>
							<option value="4"> Nota Fiscal </option>
							<option value="5"> Fornecedores </option>
							<option value="6"> Clientes </option>
							<option value="7"> Usuários </option>
							<option value="8"> Acessos </option>
						</select>
					</div>
					
					<div class="divisor4">
						<label for="type"> Período: </label>
						<select name="type" id="type" required>
							<option value="n"> Escolha uma opção </option>
							<option value="1"> De Hoje </option>
							<option value="2"> Da Semana </option>
							<option value="3"> Do Mês </option>
							<option value="4"> Do Ano </option>
							<option value="5"> Do Período </option>
						</select>
					</div>
					
					<div class="divisor4 date" style="display:none">
						<div class="divisor2" style="margin: 0 !important;">
							<label for="initial">Data Inicial</label>
							<input type="date" id="initial" name="initial">
						</div>
						
						<div class="divisor2" style="margin: 0 !important;">
							<label for="final">Data Final</label>
							<input type="date" id="final" name="final">
						</div>
						
					</div>
					
					<div class="divisor4">
						<br><button name="btn_reports" id="btn_reports" class="btn_edit radius" style="float: left"><i class="fa fa-search"></i> Pesquisar</button>
					</div>
					
					<div class="clear"></div>
					<div class="espaco-min"></div>
				</form>
				
				<?php
					if(isset($_POST['btn_reports'])){
						//Através da escolha das opções mostra o relatório aqui.
						$srcReports = strip_tags(filter_input(INPUT_POST, 'searching', FILTER_SANITIZE_STRIPPED));
						$tpReports = strip_tags(filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRIPPED));

						if(empty($srcReports) || empty($tpReports) || $srcReports == 'n' || $tpReports == 'n'){
							echo '<div id="status-container" class="status-top-right text-center"><div class="status status-info"><div class="status-message"> <span class="fa fa-info-circle"></span> Selecione o tipo de relatório e o período </div></div></div>';
							header("Refresh: 1.5; url=reports");
							exit();
						}
						switch ($srcReports) {
							case 1: // Relatório de Produtos
								$table = 'si_produtos';
								$dateInitial = strip_tags(filter_input(INPUT_POST, 'initial' , FILTER_SANITIZE_STRIPPED));
								$Final = strip_tags(filter_input(INPUT_POST, 'final' , FILTER_SANITIZE_STRIPPED));
								$dateFinal = date('Y-m-d', strtotime($Final . '+1Day'));
								include 'reports-products.php';
								break;
							case 2: // Relatório de Entrada 
								$table = 'si_entrada';
								$dateInitial = strip_tags(filter_input(INPUT_POST, 'initial' , FILTER_SANITIZE_STRIPPED));
								$Final = strip_tags(filter_input(INPUT_POST, 'final' , FILTER_SANITIZE_STRIPPED));
								$dateFinal = date('Y-m-d', strtotime($Final . '+1Day'));
								include 'reports-input.php';
								break;
							case 3: // Relatório de Saída 
								$table = 'si_saida';
								$dateInitial = strip_tags(filter_input(INPUT_POST, 'initial' , FILTER_SANITIZE_STRIPPED));
								$Final = strip_tags(filter_input(INPUT_POST, 'final' , FILTER_SANITIZE_STRIPPED));
								$dateFinal = date('Y-m-d', strtotime($Final . '+1Day'));
								include 'reports-output.php';
								break;
							case 4: // Relatório de NF 
								$table = 'si_pedidos';
								$dateInitial = strip_tags(filter_input(INPUT_POST, 'initial' , FILTER_SANITIZE_STRIPPED));
								$Final = strip_tags(filter_input(INPUT_POST, 'final' , FILTER_SANITIZE_STRIPPED));
								$dateFinal = date('Y-m-d', strtotime($Final . '+1Day'));
								include 'reports-stock.php';
								break;
							case 5: // Relatório de Fornecedores 
								$table = 'si_fornecedores';
								$dateInitial = strip_tags(filter_input(INPUT_POST, 'initial' , FILTER_SANITIZE_STRIPPED));
								$Final = strip_tags(filter_input(INPUT_POST, 'final' , FILTER_SANITIZE_STRIPPED));
								$dateFinal = date('Y-m-d', strtotime($Final . '+1Day'));
								include 'reports-providers.php';
								break;
							case 6: // Relatório de Clientes
								$table = 'si_clientes';
								$dateInitial = strip_tags(filter_input(INPUT_POST, 'initial' , FILTER_SANITIZE_STRIPPED));
								$Final = strip_tags(filter_input(INPUT_POST, 'final' , FILTER_SANITIZE_STRIPPED));
								$dateFinal = date('Y-m-d', strtotime($Final . '+1Day'));
								include 'reports-clients.php';
								break;
							case 7: // Relatório de Usuários 
							$table = 'si_usuarios';	
							$dateInitial = strip_tags(filter_input(INPUT_POST, 'initial' , FILTER_SANITIZE_STRIPPED));
							$Final = strip_tags(filter_input(INPUT_POST, 'final' , FILTER_SANITIZE_STRIPPED));
							$dateFinal = date('Y-m-d', strtotime($Final . '+1Day'));
							include 'reports-users.php';
								break;
							default:
							$table = 'si_registros_acessos';
							$dateInitial = strip_tags(filter_input(INPUT_POST, 'initial', FILTER_SANITIZE_STRIPPED));
							$Final = strip_tags(filter_input(INPUT_POST, 'final', FILTER_SANITIZE_STRIPPED));
							$dateFinal = date('Y-m-d', strtotime($Final .'+1Day'));
							include 'reports-access.php';
							break;
						}
					}					
				?>
			</div>
			<div class="espaco-min"></div>
		</article>
		<div class="espaco-min"></div>
	</section>
	<div class="clear"></div>
</main>
