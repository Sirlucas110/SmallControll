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

$Read = $pdo->prepare("SELECT usuarios_id, usuarios_nome, usuarios_email, usuarios_status, usuarios_nivel FROM ". DB_USERS ." WHERE usuarios_nome = :usuarios_nome AND usuarios_status = :usuarios_status");
$Read->bindValue(':usuarios_nome', $Search);
$Read->bindValue(':usuarios_status', 1);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Nenhum resultado encontrado.', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$resultArray = [];
foreach($Read as $Show){
        $Status = ($Show['usuarios_status'] == 1 ? 'Ativo' : 'Inativo');
        
        // Verificar e trabalhar o nivel de acesso
        $usuarios_nivel = $Show['usuarios_nivel'];
        switch ($usuarios_nivel) {
            case 10:
                $Level = 'Super Administrador';
                break;
            case 9:
                $Level = 'Administrador';
                break;
            case 2:
                $Level = 'Estoquista';
                break;
            default:
                $Level = 'Operador';
                break;
        }
        $message = [
        'status'=> 'success', 
        'message' => 'Usuario encontrado',
        'usuario_nome'=> strip_tags($Show['usuarios_nome']), 
        'usuario_email'=> strip_tags($Show['usuarios_email']) ,
        'usuario_status'=> strip_tags($Status) ,
        'usuario_nivel'=> strip_tags($Level),
        'usuario_id'=> strip_tags($Show['usuarios_id'])
    ];
    echo json_encode($message);
    return;
}