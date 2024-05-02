<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Search = strip_tags(filter_input(INPUT_GET, 'val', FILTER_SANITIZE_STRIPPED));

if(empty($Search)){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo de busca !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

/* $Read = $pdo->prepare("SELECT a.produto_id, a.produto_nome, a.produto_preco, a.produto_categoria, a.produto_status, a.produto_quantidade, b.categoria_id, b.categoria_nome
FROM " . DB_PRODUCT . " a INNER JOIN ". DB_CATEGORY ." b ON (b.categoria_id = a.produto_categoria)
WHERE a.produto_id = :produto_id AND a.produto_status = :produto_status");
$Read->bindValue(':produto_id', $Search);
$Read->bindValue(':produto_status', 1);
$Read->execute(); */

$Read = $pdo->prepare("SELECT produto_id, produto_nome, produto_preco, produto_categoria, produto_status, produto_quantidade
FROM " . DB_PRODUCT . " WHERE produto_id = :produto_id AND produto_status = :produto_status");
$Read->bindValue(':produto_id', $Search);
$Read->bindValue(':produto_status', 1);
$Read->execute();
$Lines = $Read->rowCount();

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Nenhum resultado encontrado.', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

foreach($Read as $Show){
    $Price = number_format($Show['produto_preco'], 2, ',' , '.');
    $Category = strip_tags($Show['produto_categoria']);
    $ProductId = strip_tags($Show['produto_id']);
    $ProductName = strip_tags($Show['produto_nome']);
    $Quantity = strip_tags($Show['produto_quantidade']);
}
$Read = $pdo->prepare("SELECT categoria_id, categoria_nome FROM " . DB_CATEGORY );
$Read->execute();
$LinesCat = $Read->rowCount();
foreach($Read as $Cat){
    $Cname[] = strip_tags($Cat['categoria_nome']);
    $Cid[] = strip_tags($Cat['categoria_id']);
}

for($i = 0; $i < $LinesCat; $i++){
    $message = ['status'=> 'success', 
        'product_id'=> strip_tags($ProductId),
        'product_category'=> strip_tags($Category),
        'product'=> strip_tags($ProductName),
        'category_id'=> strip_tags($Cid[$i]),
        'category'=> strip_tags($Cname[$i]),
        'quantity'=> strip_tags($Quantity),
        'price'=> strip_tags($Price)];
    $result[$i] = $message;
}    
//var_dump($result);
echo json_encode($result);
return;
