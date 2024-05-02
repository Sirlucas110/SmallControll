<div class="divisor1">
	<p class="text-right noPrint"> <a href="#" onclick="window.print()" class="btn_search radius" title="Imprimir este relatório"><i class="fa fa-print"></i></a></p>
	<h1 class="font-text-min font-weight-medium"  style="margin: 10px 0 !important;">Relatório de Produtos</h1>
	<table style="width: 96% !important; margin: 10px 2% !important;">
		
	<?php
            //Hoje
            if($tpReports == 1){
                $inicial = date('Y-m-d 00:00:00');
                $final =  date('Y-m-d 23:59:59');
                $conditions = "produto_cadastro BETWEEN '{$inicial}' AND '{$final}'";

                $Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
                $Read->execute();

                $Lines = $Read->rowCount();
            }

            //Da Semana
            if($tpReports == 2){
                $inicial = date('Y-m-d 00:00:00', strtotime('-7days'));
                $final =  date('Y-m-d 23:59:59');
                $conditions = "produto_cadastro BETWEEN '{$inicial}' AND '{$final}'";

                $Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
                $Read->execute();

                $Lines = $Read->rowCount();
            }

            //Do Mês
            if($tpReports == 3){
                $inicial = date('Y-m-01 00:00:00');
                $final =  date('Y-m-31 23:59:59');
                $conditions = "produto_cadastro BETWEEN '{$inicial}' AND '{$final}'";

                $Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
                $Read->execute();

                $Lines = $Read->rowCount();
            }

            //Do Ano
            if($tpReports == 4){
                $inicial = date('Y-01-01 00:00:00');
                $final =  date('Y-12-31 23:59:59');
                $conditions = "produto_cadastro BETWEEN '{$inicial}' AND '{$final}'";

                $Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
                $Read->execute();

                $Lines = $Read->rowCount();
            }

            //Do Período
            if($tpReports == 5){
                $conditions = "produto_cadastro BETWEEN '{$dateInitial}' AND '{$dateFinal}'";

                $Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
                $Read->execute();

                $Lines = $Read->rowCount();
            }

            if($Lines == 0){
				echo '<div id="status-container" class="status-top-right text-center"><div class="status status-info"><div class="status-message"> <span class="fa fa-info-circle"></span> Não foi encontrado nenhum resultado! </div></div></div>';
				
			}

            foreach($Read as $Show):
                $product = strip_tags($Show['produto_nome']);
                $quantity  = strip_tags($Show['produto_quantidade']) . ' unidades';
                $price = number_format($Show['produto_preco'], 2, ',' , '.');
				$register = date('d-m-Y H:i', strtotime($Show['produto_cadastro']));
                ?>
		<tr>
			<td>
				<p class="font-text-sub"><b>Produtos:</b></p>
				<p><?= $product ?></p>
			</td>
			
			<td>
				<p class="font-text-sub"><b>Quantidade:</b></p>
				<p><?= $quantity ?></p>
			</td>
			
			<td>
				<p class="font-text-sub"><b>Preço:</b></p>
				<p><?= $price ?></p>
			</td>
			
			<td>
				<p class="font-text-sub"><b>Cadastrado:</b></p>
				<p><?= $register ?></p>
			</td>
			
		</tr>
		
		<?php endforeach; ?>
	</table>
</div>