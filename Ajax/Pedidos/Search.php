<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input(INPUT_GET, 'val', FILTER_SANITIZE_STRIPPED);

//unset($_SESSION['order']);


$Read = $pdo->prepare("SELECT pedido_id, pedido_numero, pedido_nf, pedido_cidade, pedido_uf, pedido_remessa, pedido_valor_total, pedido_status
FROM si_pedidos WHERE pedido_id = :pedido_id");
$Read->bindValue(':pedido_id', $Searching);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines == 0){
    $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
    echo json_encode($message);
    return; 
}

foreach($Read as $Show){}
    $pedido = strip_tags($Show['pedido_numero']);
    $nf = strip_tags($Show['pedido_nf']);
    $_SESSION['order'] = strip_tags($Show['pedido_numero']);
    $status = strip_tags($Show['pedido_status']);
    $type = strip_tags($Show['pedido_remessa']);
    $id = strip_tags($Show['pedido_id']);
    $uf = strip_tags($Show['pedido_uf']);
    $city = strip_tags($Show['pedido_cidade']); 
    $price = number_format($Show['pedido_valor_total'], 2, ',' , '.');

    $message = ["numberOrder" => $pedido, "numberInvoice" => $nf, "city" => $city, "state" => $uf, "price" => $price, "statusOrder" => $status, "type" => $type];
    echo json_encode($message);
    return; 


