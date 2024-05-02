<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "Numero do pedido"
if(empty($Search['numberOrders'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o numero do pedido !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Numero da Nota Fiscal"
if(empty($Search['numberInvoices'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o numero da Nota Fiscal !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Tipo de remessa"
if(empty($Search['typeOrders']) || $Search['typeOrders'] == 'n'){
    $message = ['status'=> 'info', 'message'=> 'Por favor, selecione um tipo de remessa !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Cidade"
if(empty($Search['citys'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Cidade !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "UF"
if(empty($Search['states'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Estado !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "status"
if(empty($Search['types']) || $Search['types'] == 'n'){
    $message = ['status'=> 'info', 'message'=> 'Por favor, selecione o status!', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Valor da nota fiscal"
if(empty($Search['prices'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Valor da nota fiscal !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Verifica se a sessão ja existe
$Read = $pdo->prepare("SELECT pedido_nf, pedido_produto_nome FROM " . DB_ORDERS . " WHERE pedido_produto_nome = :pedido_produto_nome AND pedido_nf = :pedido_nf");
$Read->bindValue(':pedido_nf', $Search['numberInvoices']);
$Read->bindValue(':pedido_produto_nome', $Search['products']);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines >= 1){
    $message = ['status'=> 'info', 'message'=> 'Este produto já consta no pedido!', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

//Atualizar os dados sem inserção de novo produto
if($Search['products'] == '' || empty($Search['products'])){

    $Price = str_replace(['.', ','] , ['', '.'], $Search['prices']);
    //Atualização do pedido
    $Update = $pdo->prepare("UPDATE " . DB_ORDERS . " SET pedido_sessao = :pedido_sessao, pedido_nf = :pedido_nf, pedido_remessa = :pedido_remessa, pedido_cidade = :pedido_cidade, pedido_uf = :pedido_uf, pedido_valor_total = :pedido_valor_total, pedido_status = :pedido_status WHERE pedido_numero = :pedido_numero");
    $Update->bindValue(':pedido_sessao', $Search['numberOrders']);
    $Update->bindValue(':pedido_nf', $Search['numberInvoices']);
    $Update->bindValue(':pedido_remessa', $Search['typeOrders']);
    $Update->bindValue(':pedido_cidade', $Search['citys']);
    $Update->bindValue(':pedido_uf', $Search['states']);
    $Update->bindValue(':pedido_valor_total', $Price);
    $Update->bindValue(':pedido_status', $Search['types']);
    $Update->bindValue(':pedido_numero', $Search['numberOrders']);
    $Update->execute();

    //Atualiza com inserção de novo produto
}else{

    //Consulta na tabela de produtos
    $ReadProd = $pdo->prepare("SELECT * FROM " . DB_PRODUCT . " WHERE produto_nome = :produto_nome");
    $ReadProd->bindValue(':produto_nome', $Search['products']);
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
    $Price = str_replace(['.', ','] , ['', '.'], $Search['prices']);

    $StockQuantity = strip_tags($Search['quantitys']);
    $StockBack = strip_tags($Show['produto_quantidade']);

    $Token = rand(100000, 100000000);

    //Calculo da separação do estoque 
    $StockNow = $StockBack - $StockQuantity;
    //Inserção do pedido
    
    $Update = $pdo->prepare("INSERT INTO " . DB_ORDERS . "(pedido_sessao, pedido_numero, pedido_nf, pedido_remessa, pedido_cidade, pedido_uf, pedido_produto_id, pedido_produto_nome, pedido_quantidade, pedido_quantidade_estoque, pedido_valor, pedido_valor_total, pedido_status)
    VALUES(:pedido_sessao, :pedido_numero, :pedido_nf, :pedido_remessa, :pedido_cidade, :pedido_uf, :pedido_produto_id, :pedido_produto_nome, :pedido_quantidade, :pedido_quantidade_estoque, :pedido_valor, :pedido_valor_total, :pedido_status)");
    $Update->bindValue(':pedido_sessao', $Search['numberOrders']);
    $Update->bindValue(':pedido_nf', $Search['numberInvoices']);
    $Update->bindValue(':pedido_remessa', $Search['typeOrders']);
    $Update->bindValue(':pedido_cidade', $Search['citys']);
    $Update->bindValue(':pedido_uf', $Search['states']);
    $Update->bindValue(':pedido_produto_id', $Show['produto_id']);
    $Update->bindValue(':pedido_produto_nome', $Search['products']);
    $Update->bindValue(':pedido_quantidade', $Search['quantitys']);
    $Update->bindValue(':pedido_quantidade_estoque', $StockNow);
    $Update->bindValue(':pedido_valor', $Show['produto_preco']);
    $Update->bindValue(':pedido_valor_total', $Price);
    $Update->bindValue(':pedido_status', $Search['types']);
    $Update->bindValue(':pedido_numero', $Search['numberOrders']);
    
    $Update->execute();

    $Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_quantidade = :produto_quantity WHERE produto_nome = :produto_nome");
    $Update -> bindValue(':produto_quantity', $StockNow);
    $Update -> bindValue(':produto_nome', $Search['products']);
    $Update -> execute();
}


$message = ['status' => 'success', 'message' => 'Operação atualizada com sucesso!', 'redirect'=> 'orders'];
echo json_encode($message);
return; 
