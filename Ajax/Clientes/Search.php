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

$Read = $pdo->prepare("SELECT cliente_nome, cliente_email, cliente_telefone, cliente_endereco, cliente_numero, cliente_bairro, 
       cliente_cep, cliente_cidade, cliente_estado, cliente_documento, cliente_telefone FROM " . DB_CLIENTS . " 
                                WHERE cliente_id = :cliente_id");
$Read->bindValue(':cliente_id', $Search);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Nenhum resultado encontrado.', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

foreach($Read as $Show){
    $Doc = strlen($Show['cliente_documento']);

    // Verificar se é CPF ou CNPJ
    if($Doc == 14){
        $Document = 1;
    }else{
        $Document = 2;
    }

    $message = ['status'=> 'success', 
        'client'=> strip_tags($Show['cliente_nome']), 
        'doc'=> strip_tags($Document),
        'document'=> strip_tags($Show['cliente_documento']),
        'email'=> strip_tags($Show['cliente_email']),
        'phone'=> strip_tags($Show['cliente_telefone']),
        'zipcode'=> strip_tags($Show['cliente_cep']),
        'address'=> strip_tags($Show['cliente_endereco']),        
        'number'=> strip_tags($Show['cliente_numero']),
        'neighborhood'=> strip_tags($Show['cliente_bairro']),
        'city'=> strip_tags($Show['cliente_cidade']),
        'state'=> strip_tags($Show['cliente_estado'])];
    echo json_encode($message);
    return;
}