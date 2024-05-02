<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Search = strip_tags(filter_input(INPUT_POST, 'searching', FILTER_SANITIZE_STRIPPED));

if(empty($Search)){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo de busca !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$Read = $pdo->prepare("SELECT a.produto_id, a.produto_nome, a.produto_preco, a.produto_categoria, a.produto_status, b.categoria_id, b.categoria_nome
FROM " . DB_PRODUCT . " a INNER JOIN ". DB_CATEGORY ." b ON (b.categoria_id = a.produto_categoria)
WHERE a.produto_nome = :produto_nome AND a.produto_status = :produto_status");
$Read->bindValue(':produto_nome', $Search);
$Read->bindValue(':produto_status', 1);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Nenhum resultado encontrado.', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$resultArray = [];
foreach($Read as $Show){
        $Status = ($Show['produto_status'] == 1 ? 'Ativo' : 'Inativo');
        $Price = "R$: " . number_format($Show['produto_preco'], 2, ',', '.');

        $message = [
        'status'=> 'success', 
        'message' => 'Produto encontrado',
        'produto_nome'=> strip_tags($Show['produto_nome']), 
        'categoria_nome'=> strip_tags($Show['categoria_nome']) ,
        'produto_preco'=> strip_tags($Price) ,
        'produto_status'=> strip_tags($Status),
        'produto_id'=> strip_tags($Show['produto_id'])
    ];
    echo json_encode($message);
    return;
}