<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "Nota Fiscal de Entrada"
if(empty($Search['invoiceNew'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo de Nota Fiscal de Entrada !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Valor da nota fiscal"
if(empty($Search['invoiceValueNew'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo de valor da Nota Fiscal !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Produto"
if(empty($Search['productNew'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o nome do Produto !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Quantidade"
if(empty($Search['quantityNew'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Quantidade !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "unidade de medida"
if(empty($Search['unity'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Unidade de Medida !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "validade"
if(empty($Search['vality'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Validade !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Fornecedor"
if(empty($Search['provider'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Fornecedor !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Tipo de operação"
if(empty($Search['typeNew']) || $Search['typeNew'] == 'n'){
    $message = ['status'=> 'info', 'message'=> 'Por favor, selecione o tipo de operação !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "status"
if(empty($Search['statusNew']) || $Search['statusNew'] == 'n'){
    $message = ['status'=> 'info', 'message'=> 'Por favor, selecione o status!', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

unset($_SESSION['stock']);
$_SESSION['stock'] = rand(100, 10000).time();
$Session = $_SESSION['stock'];

// ENTRADA
if($Search['typeNew'] == 1){
    $Read = $pdo->prepare("SELECT entrada_sessao FROM " . DB_STOCKIN . " WHERE entrada_sessao = :entrada_sessao");
    $Read->bindValue(':entrada_sessao', $Session);
    $Read->execute();
}

// SAIDA
if($Search['typeNew'] == 2){
    $Read = $pdo->prepare("SELECT saida_sessao FROM " . DB_STOCKOUT . " WHERE saida_sessao = :saida_sessao");
    $Read->bindValue(':saida_sessao', $Session);
    $Read->execute();
}

// DEVOLUÇÃO 
if($Search['typeNew'] == 3){
    $Read = $pdo->prepare("SELECT devolucao_sessao FROM " . DB_DEVOLUTION . " WHERE devolucao_sessao = :devolucao_sessao");
    $Read->bindValue(':devolucao_sessao', $Session);
    $Read->execute();
}

$Lines = $Read->rowCount();

if($Lines >= 1){
    $message = ['status'=> 'info', 'message'=> 'Esta operação já foi registrada!', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
//Consulta na tabela de produtos
$ReadProd = $pdo->prepare("SELECT * FROM " . DB_PRODUCT . " WHERE produto_nome = :produto_nome");
$ReadProd->bindValue(':produto_nome', $Search['productNew']);
$ReadProd->execute();

$LinesProd = $ReadProd -> rowCount();

if($Lines >= 1){
    $message = ['status'=> 'info', 'message'=> 'Este produto está inativo ou nao existe mais!', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return;
}

foreach($ReadProd as $Show){}

$Price = strip_tags($Show['produto_preco']);
$Category = strip_tags($Show['produto_categoria']);
$PriceInvoice = str_replace(['.', ','] , ['', '.'], $Search['invoiceValueNew']);

$StockQuantity = strip_tags($Search['quantityNew']);
$StockBack = strip_tags($Show['produto_quantidade']);

$Token = rand(100000, 100000000);
// GRAVAR DADOS DE ENTRADA
if($Search['typeNew'] == 1){
    $StockNow = $StockBack + $StockQuantity;
    $Create = $pdo->prepare("INSERT INTO " . DB_STOCKIN . "(entrada_produto_nome, entrada_quantidade, entrada_quantidade_estoque_atual, entrada_quantidade_estoque, entrada_medidas, entrada_validade, entrada_nf, entrada_codigo, entrada_fornecedor, entrada_valor_nf, entrada_sessao, entrada_status)
    VALUES(:entrada_produto_nome, :entrada_quantidade, :entrada_quantidade_estoque_atual, :entrada_quantidade_estoque, :entrada_medidas, :entrada_validade, :entrada_nf, :entrada_codigo, :entrada_fornecedor, :entrada_valor_nf, :entrada_sessao, :entrada_status)");
    $Create->bindValue(':entrada_produto_nome', $Search['productNew']);
    $Create->bindValue(':entrada_quantidade', $StockQuantity);
    $Create->bindValue(':entrada_quantidade_estoque_atual', $StockBack);
    $Create->bindValue(':entrada_quantidade_estoque', $StockNow);
    $Create->bindValue(':entrada_medidas', $Search['unity']);
    $Create->bindValue(':entrada_validade', $Search['vality']);
    $Create->bindValue(':entrada_nf', $Search['invoiceNew']);
    $Create->bindValue(':entrada_codigo', $Token);
    $Create->bindValue(':entrada_fornecedor', $Search['provider']);
    $Create->bindValue(':entrada_valor_nf', $PriceInvoice);
    $Create->bindValue(':entrada_sessao', $Session);
    $Create->bindValue(':entrada_status', $Search['statusNew']);
    $Create->execute();

    $Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_quantidade = :produto_quantity WHERE produto_nome = :produto_nome");
    $Update -> bindValue(':produto_quantity', $StockNow);
    $Update -> bindValue(':produto_nome', $Search['productNew']);
    $Update -> execute();
}

// GRAVAR DADOS DE SAIDA
if($Search['typeNew'] == 2){
    $StockNow = $StockBack - $StockQuantity;
    $Create = $pdo->prepare("INSERT INTO " . DB_STOCKOUT . "(saida_produto_nome, saida_quantidade, saida_quantidade_estoque_atual, saida_quantidade_estoque, saida_medidas, saida_validade, saida_nf, saida_codigo, saida_fornecedor, saida_valor_nf, saida_sessao, saida_status)
    VALUES(:saida_produto_nome, :saida_quantidade, :saida_quantidade_estoque_atual, :saida_quantidade_estoque, :saida_medidas, :saida_validade, :saida_nf, :saida_codigo, :saida_fornecedor, :saida_valor_nf, :saida_sessao, :saida_status)");
    $Create->bindValue(':saida_produto_nome', $Search['productNew']);
    $Create->bindValue(':saida_quantidade', $StockQuantity);
    $Create->bindValue(':saida_quantidade_estoque_atual', $StockBack);
    $Create->bindValue(':saida_quantidade_estoque', $StockNow);
    $Create->bindValue(':saida_medidas', $Search['unity']);
    $Create->bindValue(':saida_validade', $Search['vality']);
    $Create->bindValue(':saida_nf', $Search['invoiceNew']);
    $Create->bindValue(':saida_codigo', $Token);
    $Create->bindValue(':saida_fornecedor', $Search['provider']);
    $Create->bindValue(':saida_valor_nf', $PriceInvoice);
    $Create->bindValue(':saida_sessao', $Session);
    $Create->bindValue(':saida_status', $Search['statusNew']);
    $Create->execute();

    $Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_quantidade = :produto_quantity WHERE produto_nome = :produto_nome");
    $Update -> bindValue(':produto_quantity', $StockNow);
    $Update -> bindValue(':produto_nome', $Search['productNew']);
    $Update -> execute();
}

// GRAVAR DADOS DE DEVOLUÇÃO
if($Search['typeNew'] == 3){
    $Create = $pdo->prepare("INSERT INTO " . DB_DEVOLUTION . "(devolucao_produto_nome, 	devolucao_quantidade, devolucao_medidas,  devolucao_motivo, devolucao_nf, devolucao_validade, devolucao_codigo, devolucao_fornecedor, devolucao_valor_nf, devolucao_sessao, devolucao_status)
    VALUES(:devolucao_produto_nome, :devolucao_quantidade, :devolucao_medidas, :devolucao_motivo, :devolucao_nf, :devolucao_validade, :devolucao_codigo, :devolucao_fornecedor, :devolucao_valor_nf, :devolucao_sessao, :devolucao_status)");
    $Create->bindValue(':devolucao_produto_nome', $Search['productNew']);
    $Create->bindValue(':devolucao_quantidade', $Search['quantityNew']);
    $Create->bindValue(':devolucao_medidas', $Search['unity']);
    $Create->bindValue(':devolucao_motivo', $Search['observation']);
    $Create->bindValue(':devolucao_nf', $Search['invoiceNew']);
    $Create->bindValue(':devolucao_validade', $Search['vality']);
    $Create->bindValue(':devolucao_codigo', $Token);
    $Create->bindValue(':devolucao_fornecedor', $Search['provider']);
    $Create->bindValue(':devolucao_valor_nf', $PriceInvoice);
    $Create->bindValue(':devolucao_sessao', $Session);
    $Create->bindValue(':devolucao_status', $Search['statusNew']);
    $Create->execute();
}

$message = ['status' => 'success', 'message' => 'Operação cadastrada com sucesso!', 'redirect'=> 'stock'];
echo json_encode($message);
return; 
