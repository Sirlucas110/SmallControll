<div class="divisor1">
	<p class="text-right noPrint"> <a href="#" onclick="window.print()" class="btn_search radius" title="Imprimir este relatório"><i class="fa fa-print"></i></a></p>
	<h1 class="font-text-min font-weight-medium"  style="margin: 10px 0 !important;">Relatório de Operações de Pedido</h1>
    <div class="tabless">
        <table style="width: 96% !important; margin: 10px 2% !important;">

            <?php
            //Hoje
            if($tpReports == 1){
                $inicial = date('Y-m-d 00:00:00');
                $final =  date('Y-m-d 23:59:59');
                $conditions = "pedido_cadastro BETWEEN '{$inicial}' AND '{$final}'";

                $Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
                $Read->execute();

                $Lines = $Read->rowCount();
            }

            //Da Semana
            if($tpReports == 2){
                $inicial = date('Y-m-d 00:00:00', strtotime('-7days'));
                $final =  date('Y-m-d 23:59:59');
                $conditions = "pedido_cadastro BETWEEN '{$inicial}' AND '{$final}'";

                $Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
                $Read->execute();

                $Lines = $Read->rowCount();
            }

            //Do Mês
            if($tpReports == 3){
                $inicial = date('Y-m-01 00:00:00');
                $final =  date('Y-m-31 23:59:59');
                $conditions = "pedido_cadastro BETWEEN '{$inicial}' AND '{$final}'";

                $Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
                $Read->execute();

                $Lines = $Read->rowCount();
            }

            //Do Ano
            if($tpReports == 4){
                $inicial = date('Y-01-01 00:00:00');
                $final =  date('Y-12-31 23:59:59');
                $conditions = "pedido_cadastro BETWEEN '{$inicial}' AND '{$final}'";

                $Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
                $Read->execute();

                $Lines = $Read->rowCount();
            }

            //Do Período
            if($tpReports == 5){
                $conditions = "pedido_cadastro BETWEEN '{$dateInitial}' AND '{$dateFinal}'";

                $Read = $pdo->prepare("SELECT * FROM {$table} WHERE {$conditions}");
                $Read->execute();

                $Lines = $Read->rowCount();
            }

            if ($Lines == 0) {
                echo '<div id="status-container" class="status-top-right text-center">
                                        <div class="status status-info"><div class="status-message"> 
                                        <span class="fa fa-info-circle"></span> Não encontramos nenhum resultado 
                                        </div></div></div>';
            }

            foreach($Read as $Show):
                $product = strip_tags($Show['pedido_produto_nome']);
                $quantity  = strip_tags($Show['pedido_quantidade']) . ' unidades';
                $invoice  = strip_tags($Show['pedido_nf']);
                $situation  = strip_tags($Show['os_situation']);
                $register = date('d/m/Y H:i', strtotime($Show['pedido_cadastro']));

                if($situation == 1){
                    $os = 'Liberado';
                }

                if($situation == 2){
                    $os = 'Despachado';
                }

                if($situation == 3){
                    $os = 'Cancelado';
                }

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
                    <p class="font-text-sub"><b>Nota Fiscal:</b></p>
                    <p><?= $invoice ?></p>
                </td>

                <td>
                    <p class="font-text-sub"><b>Situação:</b></p>
                    <p><?= $os ?></p>
                </td>

                <td>
                    <p class="font-text-sub"><b>Cadastrado:</b></p>
                    <p><?= $register ?></p>
                </td>

            </tr>

            <?php endforeach; ?>
        </table>
    </div>
</div>