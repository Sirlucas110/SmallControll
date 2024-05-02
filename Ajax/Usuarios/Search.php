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

$Read = $pdo->prepare("SELECT usuarios_id, usuarios_nome, usuarios_email, usuarios_status, usuarios_nivel FROM " . DB_USERS . " 
                                WHERE usuarios_id = :usuarios_id");
$Read->bindValue(':usuarios_id', $Search);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Nenhum resultado encontrado.', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

foreach($Read as $Show){
    $message = ['status'=> 'success', 
        'user'=> strip_tags($Show['usuarios_nome']),
        'email'=> strip_tags($Show['usuarios_email']),
        'level'=> strip_tags($Show['usuarios_nivel'])];
    echo json_encode($message);
    return;
}