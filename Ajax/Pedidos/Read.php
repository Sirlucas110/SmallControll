<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "Nota Fiscal de Entrada"
if(empty($Search['searching']) && $Search['type'] == 'n'){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo de numero do pedido ou tipo de operação !', 'Redirect'=>'', 'lines' => 0];
    echo json_encode($message);
    return; 
}

unset($_SESSION['order']);

// PEDIDO
if($Search['type'] == 'n' && !empty($Search['searching'])){
    $Read = $pdo->prepare("SELECT pedido_id, pedido_numero, pedido_nf, pedido_cidade, pedido_uf, pedido_remessa, pedido_status
    FROM si_pedidos WHERE pedido_numero = :pedido_numero");
    $Read->bindValue(':pedido_numero', $Search['searching']);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }
    
    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['pedido_numero']);
        $nf[] = strip_tags($Show['pedido_nf']);
        $_SESSION['order'] = strip_tags($Show['pedido_numero']);

        // Verificar o tipo de status
        if($Show['pedido_status'] == 1){
            $status[] = 'Pendente';
        }elseif($Show['pedido_status'] == 2){
            $status[] = 'Aguardando';
        }elseif($Show['pedido_status'] == 3){
            $status[] = 'Despachado';
        }else{
            $status[] = 'Devolvido';
        }
        $id[] = strip_tags($Show['pedido_id']);
        $uf[] = $Show['pedido_cidade'] . '/' . $Show['pedido_uf']; 

        $message = ["pedido" => $pedido, "nf" => $nf, "stat" => $status, "id" => $id, "uf" => $uf];
    }    
    
    echo json_encode($message);
    return; 
}

//TIPO DE STATUS
if($Search['type'] != 'n' && empty($Search['searching'])){

    $Read = $pdo->prepare("SELECT pedido_id, pedido_numero, pedido_nf, pedido_cidade, pedido_uf, pedido_remessa, pedido_status
    FROM si_pedidos WHERE pedido_status = :pedido_status");
    $Read->bindValue(':pedido_status', $Search['type']);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }
    
    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['pedido_numero']);
        $nf[] = strip_tags($Show['pedido_nf']);
        $_SESSION['order'] = strip_tags($Show['pedido_numero']);

        // Verificar o tipo de remessa
        if($Show['pedido_status'] == 1){
            $status[] = 'Pendente';
        }elseif($Show['pedido_status'] == 2){
            $status[] = 'Aguardando';
        }elseif($Show['pedido_status'] == 3){
            $status[] = 'Despachado';
        }else{
            $status[] = 'Devolvido';
        }
        $id[] = strip_tags($Show['pedido_id']);
        $uf[] = $Show['pedido_cidade'] . '/' . $Show['pedido_uf']; 

        $message = ["pedido" => $pedido, "nf" => $nf, "stat" => $status, "id" => $id, "uf" => $uf];
    }    
    
    echo json_encode($message);
    return; 
    
}
