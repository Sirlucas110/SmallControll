<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "Numero do pedido"
if(empty($Search['numberOrder'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o numero do pedido !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Situação"
if(empty($Search['typeOrder']) || $Search['typeOrder'] == 'n'){
    $message = ['status'=> 'info', 'message'=> 'Por favor, selecione a Situação!', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

if($Search['typeOrder'] == 2){
    $Status = 3;
}else{
    $Status = 4;
}

//Atualização do pedido
$Update = $pdo->prepare("UPDATE " . DB_ORDERS . " SET os_situation = :os_situation, pedido_status = :pedido_status WHERE pedido_numero = :pedido_numero");
$Update->bindValue(':os_situation', $Search['typeOrder']);
$Update->bindValue(':pedido_status', $Status);
$Update->bindValue(':pedido_numero', $Search['numberOrder']);
$Update->execute();

$message = ['status' => 'success', 'message' => 'Operação atualizada com sucesso!', 'redirect'=> 'services'];
echo json_encode($message);
return; 
