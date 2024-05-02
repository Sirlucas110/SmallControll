<div class="divisor1">
	<p class="text-right noPrint"> <a href="#" onclick="window.print()" class="btn_search radius" title="Imprimir este relatório"><i class="fa fa-print"></i></a></p>
	<h1 class="font-text-min font-weight-medium"  style="margin: 10px 0 !important;">Relatório de Clientes</h1>
	<table style="width: 96% !important; margin: 10px 2% !important;">
		
	<?php 			
				switch($tpReports){
					case 1: // Hoje
						$inicial = date('Y-m-d 00:00:00');
						$final = date('Y-m-d 23:59:59');
						$conditions = "cliente_cadastro BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						
						break;
					case 2: // Da semana
						$inicial = date('Y-m-d 00:00:00', strtotime('- 7days'));
						$final = date('Y-m-d 23:59:59');
						$conditions = "cliente_cadastro BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					case 3: // Do mês 
						$inicial = date('Y-m-01 00:00:00');
   						$final =  date('Y-m-31 23:59:59');
						$conditions = "cliente_cadastro BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					case 4: // Do ano 
						$inicial = date('Y-01-01 00:00:00');
   						$final =  date('Y-12-31 23:59:59');
						$conditions = "cliente_cadastro BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					default: // Do período 
						$conditions = "cliente_cadastro BETWEEN '{$dateInitial}' AND '{$dateFinal}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					}
			if($Lines == 0){
				echo '<div id="status-container" class="status-top-right text-center"><div class="status status-info"><div class="status-message"> <span class="fa fa-info-circle"></span> Não foi encontrado nenhum resultado! </div></div></div>';
				
			}
			foreach($Read as $Show):
				$client = strip_tags($Show['cliente_nome']);
				$document = strip_tags($Show['cliente_documento']);
				$register = date('d-m-Y H:i', strtotime($Show['cliente_cadastro']));
				$phone = strip_tags($Show['cliente_telefone']);
				$endereco = $Show['cliente_endereco'] . ', ' . $Show['cliente_numero'] . ', ' . $Show['cliente_bairro']; 
			?>
		<tr>
			<td>
				<p class="font-text-sub"><b>Clientes:</b></p>
				<p><?= $client ?></p>
			</td>
			
			<td>
				<p class="font-text-sub"><b>Telefone:</b></p>
				<p><?= $phone ?></p>
			</td>
			
			<td>
				<p class="font-text-sub"><b>CPF/CNPJ:</b></p>
				<p><?= $document ?></p>
			</td>

			<td>
				<p class="font-text-sub"><b>Endereço:</b></p>
				<p><?= $endereco ?></p>
			</td>
			
			<td>
				<p class="font-text-sub"><b>Cadastrado:</b></p>
				<p><?= $register ?></p>
			</td>			
		</tr>
		
		<?php endforeach; ?>
	</table>
</div>