<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Search = strip_tags(filter_input(INPUT_GET, 'searching', FILTER_SANITIZE_STRIPPED));
$Type = strip_tags(filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRIPPED));

if(empty($Search)){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo de busca !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// ENTRADA
if($Type == 'Entrada'){
    $Read = $pdo->prepare("SELECT entrada_nf, entrada_codigo, entrada_quantidade, entrada_produto_id, entrada_produto_nome, entrada_status FROM " . DB_STOCKIN . " WHERE entrada_produto_id = :entrada_produto_id");
    $Read->bindValue(':entrada_produto_id', $Search);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }

    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['entrada_codigo']);
        $produto[] = strip_tags($Show['entrada_produto_nome']);
        $quantity[] = strip_tags($Show['entrada_quantidade']);
        $status[] = strip_tags($Show['entrada_status'] == 1 ? 'Ativo' : 'Inativo');
        $id[] = strip_tags($Show['entrada_produto_id']);
        $operacao[] = 'Entrada';
    }
    
    $message = ['status' => 'success', 'pedido' => $pedido, 'produto' => $produto, 'quantity' => $quantity, 'stat' => $status, 'id' => $id, 'operacao' => $operacao];
    echo json_encode($message);
    return; 

}

// SAIDA
if($Type == 'Saída'){
    $Read = $pdo->prepare("SELECT saida_nf, saida_codigo, saida_id, saida_produto_nome, saida_quantidade, saida_status FROM " . DB_STOCKOUT . " WHERE saida_id = :saida_id");
    $Read->bindValue(':saida_id', $Search);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }

    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['saida_codigo']);
        $quantity[] = strip_tags($Show['saida_quantidade']);
        $produto[] = strip_tags($Show['saida_produto_nome']);
        $nf[] = strip_tags($Show['saida_nf']);
        $status[] = strip_tags($Show['saida_status'] == 1 ? 'Ativo' : 'Inativo');
        $id[] = strip_tags($Show['saida_id']);
        $operacao[] = 'Saída';
    }
    
    $message = ['status' => 'success', 'pedido' => $pedido, 'produto' => $produto, 'quantity' => $quantity, 'stat' => $status, 'id' => $id, 'operacao' => $operacao];
    echo json_encode($message);
    return;
}

// DEVOLUÇÃO 
if($Type == 'Devolução'){
    $Read = $pdo->prepare("SELECT devolucao_nf, devolucao_codigo, devolucao_id, devolucao_quantidade, devolucao_produto_nome, devolucao_motivo, devolucao_nf, devolucao_fornecedor, devolucao_valor_nf, devolucao_status FROM " . DB_DEVOLUTION . " WHERE devolucao_id = :devolucao_id");
    $Read->bindValue(':devolucao_id', $Search);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }

    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['devolucao_codigo']);
        $quantity[] = strip_tags($Show['devolucao_quantidade']);
        $produto[] = strip_tags($Show['devolucao_produto_nome']);
        $nf[] = strip_tags($Show['devolucao_nf']);
        $nfValor[] = strip_tags($Show['devolucao_valor_nf']);
        $motivo[] = strip_tags($Show['devolucao_motivo']);
        $fornecedor[] = strip_tags($Show['devolucao_fornecedor']);        
        $status[] = strip_tags($Show['devolucao_status'] == 1 ? 'Ativo' : 'Inativo');
        $id[] = strip_tags($Show['devolucao_id']);
        $operacao[] = 'Devolução';
    }
    
    $message = ['status' => 'success', 'pedido' => $pedido, 'produto' => $produto, 'quantity' => $quantity, 'stat' => $status, 'id' => $id, 'operacao' => $operacao, 'nf' => $nf, 'nfValor' => $nfValor, 'motivo' => $motivo, 'fornecedor' => $fornecedor];
    echo json_encode($message);
    return; 
}

// CANCELADO 
if($Type == 'Cancelado'){
    $Read = $pdo->prepare("SELECT a.entrada_nf, a.entrada_codigo, a.entrada_produto_id, a.entrada_produto_nome, a.entrada_status, b.saida_nf, b.saida_codigo, b.saida_id, b.saida_status, c.devolucao_nf, c.devolucao_codigo, c.devolucao_id, c.devolucao_status FROM si_entrada a INNER JOIN si_saida b ON (b.saida_nf = a.entrada_nf) INNER JOIN si_devolucao c ON (c.devolucao_nf = a.entrada_nf) WHERE a.entrada_status = :entrada_status");
    $Read->bindValue(':entrada_status', 0);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }
    
    $pedido = [];
    $nf = [];
    $status = [];
    $id = [];
    $operacao = [];
    
    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['entrada_codigo']);
        $nf[] = strip_tags($Show['entrada_nf']);
        $status[] = strip_tags($Show['entrada_status'] == 1 ? 'Ativo' : 'Inativo');
        $id[] = strip_tags($Show['entrada_produto_id']);
        $operacao[] = 'Entrada';

        $pedido[] = strip_tags($Show['saida_codigo']);
        $nf[] = strip_tags($Show['saida_nf']);
        $status[] = strip_tags($Show['saida_status'] == 1 ? 'Ativo' : 'Inativo');
        $id[] = strip_tags($Show['saida_id']);
        $operacao[] = 'Saída';

        $pedido[] = strip_tags($Show['devolucao_codigo']);
        $nf[] = strip_tags($Show['devolucao_nf']);
        $status[] = strip_tags($Show['devolucao_status'] == 1 ? 'Ativo' : 'Inativo');
        $id[] = strip_tags($Show['devolucao_id']);
        $operacao[] = 'Devolução';

    }    
    $message = ["pedido" => $pedido, 'produto' => $produto, "stat" => $status, "id" => $id, "operacao" => $operacao];
    echo json_encode($message);
    return;
}
