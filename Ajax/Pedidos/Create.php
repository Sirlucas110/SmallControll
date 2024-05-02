<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "Numero do pedido"
if(empty($Search['numberOrder'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o numero do pedido !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Numero da Nota Fiscal"
if(empty($Search['numberInvoice'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o numero da Nota Fiscal !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Tipo de remessa"
if(empty($Search['typeOrder']) || $Search['typeOrder'] == 'n'){
    $message = ['status'=> 'info', 'message'=> 'Por favor, selecione um tipo de remessa !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Cidade"
if(empty($Search['city'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Cidade !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "UF"
if(empty($Search['state'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Estado !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "status"
if(empty($Search['type']) || $Search['type'] == 'n'){
    $message = ['status'=> 'info', 'message'=> 'Por favor, selecione o status!', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "produto"
if(empty($Search['product'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo produto !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Quantidade"
if(empty($Search['quantity'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Quantidade !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Valor da nota fiscal"
if(empty($Search['price'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Valor da nota fiscal !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Verifica se a sessão ja existe

$Read = $pdo->prepare("SELECT pedido_nf, pedido_produto_nome FROM " . DB_ORDERS . " WHERE pedido_produto_nome = :pedido_produto_nome AND pedido_nf = :pedido_nf");
$Read->bindValue(':pedido_nf', $Search['numberInvoice']);
$Read->bindValue(':pedido_produto_nome', $Search['product']);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines >= 1){
    $message = ['status'=> 'info', 'message'=> 'Este produto já consta no pedido!', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
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

$Price = strip_tags($Show['produto_preco']);
$ProductId = strip_tags($Show['produto_id']);
$Price = str_replace(['.', ','] , ['', '.'], $Search['price']);

$StockQuantity = strip_tags($Search['quantity']);
$StockBack = strip_tags($Show['produto_quantidade']);

$Token = rand(100000, 100000000);

//Calculo da separação do estoque 
$StockNow = $StockBack - $StockQuantity;

//Inserção do pedido
$Create = $pdo->prepare("INSERT INTO " . DB_ORDERS . "(pedido_sessao, pedido_numero, pedido_nf, pedido_remessa, pedido_cidade, pedido_uf, pedido_produto_id, pedido_produto_nome, pedido_quantidade, pedido_quantidade_estoque, pedido_valor, pedido_valor_total, pedido_status)
VALUES(:pedido_sessao, :pedido_numero, :pedido_nf, :pedido_remessa, :pedido_cidade, :pedido_uf, :pedido_produto_id, :pedido_produto_nome, :pedido_quantidade, :pedido_quantidade_estoque, :pedido_valor, :pedido_valor_total, :pedido_status)");
$Create->bindValue(':pedido_sessao', $Search['numberOrder']);
$Create->bindValue(':pedido_numero', $Search['numberOrder']);
$Create->bindValue(':pedido_nf', $Search['numberInvoice']);
$Create->bindValue(':pedido_remessa', $Search['typeOrder']);
$Create->bindValue(':pedido_cidade', $Search['city']);
$Create->bindValue(':pedido_uf', $Search['state']);
$Create->bindValue(':pedido_produto_id', $Show['produto_id']);
$Create->bindValue(':pedido_produto_nome', $Search['product']);
$Create->bindValue(':pedido_quantidade', $Search['quantity']);
$Create->bindValue(':pedido_quantidade_estoque', $StockNow);
$Create->bindValue(':pedido_valor', $Show['produto_preco']);
$Create->bindValue(':pedido_valor_total', $Price);
$Create->bindValue(':pedido_status', $Search['type']);
$Create->execute();

$Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_quantidade = :produto_quantity WHERE produto_nome = :produto_nome");
$Update -> bindValue(':produto_quantity', $StockNow);
$Update -> bindValue(':produto_nome', $Search['product']);
$Update -> execute();


$message = ['status' => 'success', 'message' => 'Operação cadastrada com sucesso!', 'redirect'=> ''];
echo json_encode($message);
return; 
