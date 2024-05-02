<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Id = filter_input(INPUT_GET, 'val',FILTER_SANITIZE_STRIPPED);
$Number = filter_input(INPUT_GET, 'order',FILTER_SANITIZE_STRIPPED);

//Consultar na tabela do produto
$ReadProd = $pdo->prepare("SELECT a.pedido_id, a.pedido_produto_id, a.pedido_quantidade, b.produto_id, b.produto_quantidade FROM si_pedidos a INNER JOIN si_produtos b ON (b.produto_id = a.pedido_produto_id) WHERE a.pedido_numero = :pedido_numero");
$ReadProd->bindValue(':pedido_numero', $Number);
$ReadProd->execute();

$LinesProd = $ReadProd -> rowCount();
if($LinesProd == 0){
    $message = ['status'=> 'info', 'message'=> 'Este produto não foi encontrado neste pedido!', 'redirect'=> '', 'lines' => 0];
    
    echo json_encode($message);
    return;
}

foreach($ReadProd as $Show){
    $productId = strip_tags($Show['pedido_produto_id']);
    $productQtd = strip_tags($Show['produto_quantidade']);
    $orderQtd = strip_tags($Show['pedido_quantidade']);

    //Calculo de movimentação da operação
    $calc = $productQtd + $orderQtd;

    //Operação na tabela produto (subtração) 
    $Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_quantidade = :produto_quantity WHERE produto_id = :produto_id");
    $Update -> bindValue(':produto_quantity', $calc);
    $Update -> bindValue(':produto_id', $productId);
    $Update -> execute();
}
//Exclusão do ID da tabela da operação entrada
$DeleteProd = $pdo->prepare("DELETE FROM " . DB_ORDERS . " WHERE pedido_numero = :pedido_numero");
$DeleteProd->bindValue(':pedido_numero', $Number);
$DeleteProd->execute();
    
$message = ['status' => 'success', 'message' => 'Operação excluída com sucesso!', 'redirect'=> 'orders'];
echo json_encode($message);
return;