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

$Read = $pdo->prepare("SELECT fornecedor_id, fornecedor_nome, fornecedor_email, fornecedor_telefone, fornecedor_endereco, fornecedor_number , fornecedor_neighborhood,fornecedor_cep, fornecedor_cidade, fornecedor_estado, fornecedor_documento, fornecedor_telefone FROM ". DB_PROVIDERS ." WHERE fornecedor_id = :fornecedor_id");
$Read->bindValue(':fornecedor_id', $Search);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Nenhum resultado encontrado.', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

foreach($Read as $Show){
    $message = ['status'=> 'success', 
        'provider_id'=> strip_tags($Show['fornecedor_id']),
        'nome'=> strip_tags($Show['fornecedor_nome']),
        'email'=> strip_tags($Show['fornecedor_email']),
        'phone'=> strip_tags($Show['fornecedor_telefone']),
        'zipcode'=> strip_tags($Show['fornecedor_cep']),
        'address'=> strip_tags($Show['fornecedor_endereco']),
        'number'=> strip_tags($Show['fornecedor_number']),
        'neighborhood'=> strip_tags($Show['fornecedor_neighborhood']),
        'city'=> strip_tags($Show['fornecedor_cidade']),
        'state'=> strip_tags($Show['fornecedor_estado']),
        'document'=> strip_tags($Show['fornecedor_documento'])];
    echo json_encode($message);
    return;
}