<div class="divisor1">
	<p class="text-right noPrint"> <a href="#" onclick="window.print()" class="btn_search radius" title="Imprimir este relatório"><i class="fa fa-print"></i></a></p>
	<h1 class="font-text-min font-weight-medium"  style="margin: 10px 0 !important;">Relatório de Usuários</h1>
	<table style="width: 96% !important; margin: 10px 2% !important;">
		
	<?php 			
				switch($tpReports){
					case 1: // Hoje
						$inicial = date('Y-m-d 00:00:00');
						$final = date('Y-m-d 23:59:59');
						$conditions = "usuarios_data BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						
						break;
					case 2: // Da semana
						$inicial = date('Y-m-d 00:00:00', strtotime('- 7days'));
						$final = date('Y-m-d 23:59:59');
						$conditions = "usuarios_data BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					case 3: // Do mês 
						$inicial = date('Y-m-01 00:00:00');
   						$final =  date('Y-m-31 23:59:59');
						$conditions = "usuarios_data BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					case 4: // Do ano 
						$inicial = date('Y-01-01 00:00:00');
   						$final =  date('Y-12-31 23:59:59');
						$conditions = "usuarios_data BETWEEN '{$inicial}' AND '{$final}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					default: // Do período 
						$conditions = "usuarios_data BETWEEN '{$dateInitial}' AND '{$dateFinal}'";

						$Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
						$Read->execute();

						$Lines = $Read->rowCount();
						break;
					}
			if($Lines == 0){
				echo '<div id="status-container" class="status-top-right text-center"><div class="status status-info"><div class="status-message"> <span class="fa fa-info-circle"></span> Não foi encontrado nenhum resultado! </div></div></div>';
				
			}
			foreach($Read as $Show):
				$User = strip_tags($Show['usuarios_nome']);				
				$Email = strip_tags($Show['usuarios_email']);
				$register = date('d-m-Y H:i', strtotime($Show['usuarios_data']));
				$Status = ($Show['usuarios_status'] == 1 ? 'Ativo' : 'Inativo');
				$usuarios_nivel = $Show['usuarios_nivel'];
        switch ($usuarios_nivel) {
            case 10:
                $Level = 'Super Administrador';
                break;
            case 9:
                $Level = 'Administrador';
                break;
            case 2:
                $Level = 'Estoquista';
                break;
            default:
                $Level = 'Operador';
                break;
        }
			?>
		<tr>
			<td>
				<p class="font-text-sub"><b>Usuário:</b></p>
				<p><?= $User ?></p>
			</td>
			
			<td>
			<p class="font-text-sub"><b>Status:</b></p><p class="font-text-sub"><span class="btn_edit radius" style=padding:3px 4px !important;"><?= $Status ?></span></p>
			</td>
			
			<td>
				<p class="font-text-sub"><b>Nível:</b></p>
				<p><?= $Level ?></p>
			</td>

			<td>
				<p class="font-text-sub"><b>Email:</b></p>
				<p><?= $Email ?></p>
			</td>

			<td>
				<p class="font-text-sub"><b>Cadastrado:</b></p>
				<p><?= $register ?></p>
			</td>
			
		</tr>
		
		<?php endforeach; ?>
	</table>
</div>