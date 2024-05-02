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

$Read = $pdo->prepare("SELECT fornecedor_id, fornecedor_nome, fornecedor_email, fornecedor_status, fornecedor_cadastro FROM ". DB_PROVIDERS ." WHERE fornecedor_nome = :fornecedor_nome AND fornecedor_status = :fornecedor_status");
$Read->bindValue(':fornecedor_nome', $Search);
$Read->bindValue(':fornecedor_status', 1);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Nenhum resultado encontrado.', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$resultArray = [];
foreach($Read as $Show){
        $Status = ($Show['fornecedor_status'] == 1 ? 'Ativo' : 'Inativo');
        $Date = date('d/m/Y H:i', strtotime($Show['fornecedor_cadastro']));
        
        $message = ['status'=> 'success', 
        'message' => 'Fornecedor encontrado',
        'fornecedor_nome'=> strip_tags($Show['fornecedor_nome']), 
        'fornecedor_email'=> strip_tags($Show['fornecedor_email']) ,
        'fornecedor_status'=> strip_tags($Status) ,
        'created' => strip_tags($Date) ,
        'fornecedor_id'=> strip_tags($Show['fornecedor_id'])
    ];
    echo json_encode($message);
    return;
}