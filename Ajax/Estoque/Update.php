<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "Produto"
if(empty($Search['product'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o nome do Produto !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Quantidade de produto"
if(empty($Search['quantity'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo quantidade !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Operação"
if(empty($Search['type']) || $Search['type'] == 'n'){
    $message = ['status'=> 'info', 'message'=> 'Escolha um tipo de operação !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "status"
if(empty($Search['status']) || $Search['status'] == 'n'){
    $message = ['status'=> 'info', 'message'=> 'Escolha um status !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// ENTRADA
if($Search['type'] == 1){

    if($Search['quantity'] == $Search['qtdStock']){
        $Update = $pdo->prepare("UPDATE " . DB_STOCKIN . " SET entrada_produto_nome = :entrada_produto_nome, entrada_status = :entrada_status WHERE entrada_produto_id = :entrada_produto_id");
        $Update->bindValue(':entrada_produto_nome', $Search['product']);
        $Update->bindValue(':entrada_status', $Search['status']);
        $Update->bindValue(':entrada_produto_id', $Search['idStock']);
        $Update->execute();
    }else{
        //Consulta na tabela de produtos
        $ReadProd = $pdo->prepare("SELECT * FROM " . DB_PRODUCT . " WHERE produto_nome = :produto_nome");
        $ReadProd->bindValue(':produto_nome', $Search['product']);
        $ReadProd->execute();

        $LinesProd = $ReadProd -> rowCount();

        if($LinesProd == 0){
            $message = ['status'=> 'info', 'message'=> 'Este produto está inativo ou nao existe mais!', 'redirect'=> '', 'lines' => 0];
            echo json_encode($message);
            return;
        }

        foreach($ReadProd as $Show){}
        $StockNow = strip_tags($Show['produto_quantidade']);
        $Qt = $Search['quantity'];
        $Calc = $Qt - $Search['qtdStock'];
        $QtNow = $StockNow ;
        $QtStock = $QtNow + $Calc;   
        
        $Update = $pdo->prepare("UPDATE " . DB_STOCKIN . " SET entrada_produto_nome = :entrada_produto_nome, entrada_quantidade = :entrada_quantidade, entrada_quantidade_estoque_atual = :entrada_quantidade_estoque_atual, entrada_quantidade_estoque = :entrada_quantidade_estoque, entrada_status = :entrada_status WHERE entrada_produto_id = :entrada_produto_id");
        $Update->bindValue(':entrada_produto_nome', $Search['product']);
        $Update->bindValue(':entrada_quantidade', $Qt);
        $Update->bindValue(':entrada_quantidade_estoque_atual', $QtNow);
        $Update->bindValue(':entrada_quantidade_estoque', $QtStock);
        $Update->bindValue(':entrada_status', $Search['status']);
        $Update->bindValue(':entrada_produto_id', $Search['idStock']);
        $Update->execute();

        $Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_quantidade = :produto_quantity WHERE produto_nome = :produto_nome");
        $Update -> bindValue(':produto_quantity', $QtStock);
        $Update -> bindValue(':produto_nome', $Search['product']);
        $Update -> execute();
    }
    $message = ['status' => 'success', 'message' => 'Dados da operação de entrada atualizados com sucesso!', 'redirect'=> 'stock'];
    echo json_encode($message);
    return;
}

// SAÍDA
if($Search['type'] == 2){

    if($Search['quantity'] == $Search['qtdStock']){
        $Update = $pdo->prepare("UPDATE " . DB_STOCKOUT . " SET saida_produto_nome = :saida_produto_nome, saida_status = :saida_status WHERE saida_id = :saida_id");
        $Update->bindValue(':saida_produto_nome', $Search['product']);
        $Update->bindValue(':saida_status', $Search['status']);
        $Update->bindValue(':saida_id', $Search['idStock']);
        $Update->execute();
    }else{
        //Consulta na tabela de produtos
        $ReadProd = $pdo->prepare("SELECT * FROM " . DB_PRODUCT . " WHERE produto_nome = :produto_nome");
        $ReadProd->bindValue(':produto_nome', $Search['product']);
        $ReadProd->execute();

        $LinesProd = $ReadProd -> rowCount();

        if($LinesProd == 0){
            $message = ['status'=> 'info', 'message'=> 'Este produto está inativo ou nao existe mais!', 'redirect'=> '', 'lines' => 0];
            echo json_encode($message);
            return;
        }

        foreach($ReadProd as $Show){}
        $StockNow = strip_tags($Show['produto_quantidade']);
        $Qt = $Search['quantity'];
        $QtNow = $StockNow;        
        $Calc = abs($Search['quantity'] - $Search['qtdStock']);
        $QtStock = $QtNow - $Calc;   
        //var_dump($QtStock);
        $Update = $pdo->prepare("UPDATE " . DB_STOCKOUT . " SET saida_produto_nome = :saida_produto_nome, saida_quantidade = :saida_quantidade, saida_quantidade_estoque_atual = :saida_quantidade_estoque_atual, saida_quantidade_estoque = :saida_quantidade_estoque, saida_status = :saida_status WHERE saida_id = :saida_id");
        $Update->bindValue(':saida_produto_nome', $Search['product']);
        $Update->bindValue(':saida_quantidade', $Qt);
        $Update->bindValue(':saida_quantidade_estoque_atual', $QtNow);
        $Update->bindValue(':saida_quantidade_estoque', $QtStock);
        $Update->bindValue(':saida_status', $Search['status']);
        $Update->bindValue(':saida_id', $Search['idStock']);
        $Update->execute();

        $Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_quantidade = :produto_quantity WHERE produto_nome = :produto_nome");
        $Update -> bindValue(':produto_quantity', $QtStock);
        $Update -> bindValue(':produto_nome', $Search['product']);
        $Update -> execute();
    }
    $message = ['status' => 'success', 'message' => 'Dados da operação de entrada atualizados com sucesso!', 'redirect'=> 'stock'];
    echo json_encode($message);
    return;
}

// DEVOLUÇÃO
if($Search['type'] == 3){
    $price = str_replace(['.' , ','], ['' , '.'], $Search['nfValueEditStock']);
    $Update = $pdo->prepare("UPDATE " . DB_DEVOLUTION . " SET devolucao_produto_nome = :devolucao_produto_nome, devolucao_status = :devolucao_status, devolucao_quantidade = :devolucao_quantidade, devolucao_valor_nf = :devolucao_valor_nf, devolucao_nf = :devolucao_nf, devolucao_motivo = :devolucao_motivo, devolucao_fornecedor = :devolucao_fornecedor WHERE devolucao_id = :devolucao_id");
    $Update->bindValue(':devolucao_produto_nome', $Search['product']);
    $Update->bindValue(':devolucao_status', $Search['status']);
    $Update->bindValue(':devolucao_quantidade', $Search['quantity']);
    $Update->bindValue(':devolucao_valor_nf', $price);
    $Update->bindValue(':devolucao_nf', $Search['nfEditStock']);
    $Update->bindValue(':devolucao_motivo', $Search['msgEditStock']);
    $Update->bindValue(':devolucao_fornecedor', $Search['providerEditStock']);
    $Update->bindValue(':devolucao_id', $Search['idStock']);
    $Update->execute();
    
    $message = ['status' => 'success', 'message' => 'Dados da operação de entrada atualizados com sucesso!', 'redirect'=> 'stock'];
    echo json_encode($message);
    return;
}