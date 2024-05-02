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

$Read = $pdo->prepare("SELECT cliente_id, cliente_nome, cliente_email, cliente_status, cliente_cadastro FROM ".DB_CLIENTS." WHERE cliente_nome = :cliente_nome AND cliente_status = :cliente_status");
$Read->bindValue(':cliente_nome', $Search);
$Read->bindValue(':cliente_status', 1);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Nenhum resultado encontrado.', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$resultArray = [];
foreach($Read as $Show){
    $register = ($Show['cliente_cadastro'] == '' || $Show['cliente_cadastro'] == '0000-00-00 00:00:00') ? '-' : date('d/m/Y H:i', strtotime($Show['cliente_cadastro']));
    $status = ($Show['cliente_status'] == 0 ? 'INATIVO' : 'ATIVO');

    $message = [
        'status'=> 'success', 
        'message' => 'cliente encontrado',
        'cliente_nome'=> strip_tags($Show['cliente_nome']), 
        'cliente_email'=> strip_tags($Show['cliente_email']) ,
        'cliente_status'=> strip_tags($status) ,
        'cliente_cadastro'=> strip_tags($register),
        'cliente_id'=> strip_tags($Show['cliente_id'])
    ];
    echo json_encode($message);
    return;
}