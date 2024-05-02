<div class="divisor1">
	<p class="text-right noPrint"> <a href="#" onclick="window.print()" class="btn_search radius" title="Imprimir este relatório"><i class="fa fa-print"></i></a></p>
	<h1 class="font-text-min font-weight-medium"  style="margin: 10px 0 !important;">Relatório de Fornecedores</h1>
	<table style="width: 96% !important; margin: 10px 2% !important;">
		
	<?php 			
				switch($tpReports){
					case 1: // Hoje
						$inicial = date('Y-m-d 00:00:00');
						$final = date('Y-m-d 23:59:59');
						$conditions = "fornecedor_cadastro BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						
						break;
					case 2: // Da semana
						$inicial = date('Y-m-d 00:00:00', strtotime('- 7days'));
						$final = date('Y-m-d 23:59:59');
						$conditions = "fornecedor_cadastro BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					case 3: // Do mês 
						$inicial = date('Y-m-01 00:00:00');
   						$final =  date('Y-m-31 23:59:59');
						$conditions = "fornecedor_cadastro BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					case 4: // Do ano 
						$inicial = date('Y-01-01 00:00:00');
   						$final =  date('Y-12-31 23:59:59');
						$conditions = "fornecedor_cadastro BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					default: // Do período 
						$conditions = "fornecedor_cadastro BETWEEN '{$dateInitial}' AND '{$dateFinal}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					}
			if($Lines == 0){
				echo '<div id="status-container" class="status-top-right text-center"><div class="status status-info"><div class="status-message"> <span class="fa fa-info-circle"></span> Não foi encontrado nenhum resultado! </div></div></div>';
				
			}
			foreach($Read as $Show):
				$provider = strip_tags($Show['fornecedor_nome']);
				$document = strip_tags($Show['fornecedor_documento']);
				$register = date('d-m-Y H:i', strtotime($Show['fornecedor_cadastro']));
				$uf = $Show['fornecedor_cidade'] . '/' . $Show['fornecedor_estado']; 
			?>
		<tr>
			<td>
				<p class="font-text-sub"><b>Fornecedores:</b></p>
				<p><?= $provider ?></p>
			</td>
			
			<td>
				<p class="font-text-sub"><b>Cidade/UF:</b></p>
				<p><?= $uf ?></p>
			</td>
			
			<td>
				<p class="font-text-sub"><b>CPF/CNPJ:</b></p>
				<p><?= $document ?></p>
			</td>
			
			<td>
				<p class="font-text-sub"><b>Cadastrado:</b></p>
				<p><?= $register ?></p>
			</td>
			
		</tr>
		
		<?php endforeach; ?>
	</table>
</div>