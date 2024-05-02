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

unset($_SESSION['stock']);

// ENTRADA
if($Search['type'] == 1 && empty($Search['searching'])){
    $Read = $pdo->prepare("SELECT entrada_nf, entrada_codigo, entrada_produto_id, entrada_status FROM " . DB_STOCKIN . " WHERE entrada_status = :entrada_status");
    $Read->bindValue(':entrada_status', 1);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }

    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['entrada_codigo']);
        $nf[] = strip_tags($Show['entrada_nf']);
        $status[] = strip_tags($Show['entrada_status'] == 1 ? 'Aguardando' : 'Liberado');
        $id[] = strip_tags($Show['entrada_produto_id']);
        $operacao[] = 'Entrada';
    }
    
    $message = ['status' => 'success', 'pedido' => $pedido, 'nf' => $nf, 'stat' => $status, 'id' => $id, 'operacao' => $operacao];
    echo json_encode($message);
    return; 

}

// SAIDA
if($Search['type'] == 2 && empty($Search['searching'])){
    $Read = $pdo->prepare("SELECT saida_nf, saida_codigo, saida_id, saida_status FROM " . DB_STOCKOUT . " WHERE saida_status = :saida_status");
    $Read->bindValue(':saida_status', 1);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }

    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['saida_codigo']);
        $nf[] = strip_tags($Show['saida_nf']);
        $status[] = strip_tags($Show['saida_status'] == 1 ? 'Aguardando' : 'Liberado');
        $id[] = strip_tags($Show['saida_id']);
        $operacao[] = 'Saída';
    }
    
    $message = ['status' => 'success', 'pedido' => $pedido, 'nf' => $nf, 'stat' => $status, 'id' => $id, 'operacao' => $operacao];
    echo json_encode($message);
    return; 
}

// DEVOLUÇÃO 
if($Search['type'] == 3 && empty($Search['searching'])){
    $Read = $pdo->prepare("SELECT devolucao_nf, devolucao_codigo, devolucao_id, devolucao_status FROM " . DB_DEVOLUTION . " WHERE devolucao_status = :devolucao_status");
    $Read->bindValue(':devolucao_status', 1);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }

    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['devolucao_codigo']);
        $nf[] = strip_tags($Show['devolucao_nf']);
        $status[] = strip_tags($Show['devolucao_status'] == 1 ? 'Aguardando' : 'Liberado');
        $id[] = strip_tags($Show['devolucao_id']);
        $operacao[] = 'Saída';
    }
    
    $message = ['status' => 'success', 'pedido' => $pedido, 'nf' => $nf, 'stat' => $status, 'id' => $id, 'operacao' => $operacao];
    echo json_encode($message);
    return; 
}

// CANCELADO 
if($Search['type'] == 3 && empty($Search['searching'])){
    $Read = $pdo->prepare("SELECT a.entrada_nf, a.entrada_codigo, a.entrada_produto_id, a.entrada_status, b.saida_nf, b.saida_codigo, b.saida_id, b.saida_status, c.devolucao_nf, c.devolucao_codigo, c.devolucao_id, c.devolucao_status FROM si_entrada a INNER JOIN si_saida b ON (b.saida_nf = a.entrada_nf) INNER JOIN si_devolucao c ON (c.devolucao_nf = a.entrada_nf) WHERE a.entrada_status = :entrada_status");
    $Read->bindValue(':entrada_status', 0);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }
    
    $pedido = [];
    $nf = [];
    $status = [];
    $id = [];
    $operacao = [];
    
    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['entrada_codigo']);
        $nf[] = strip_tags($Show['entrada_nf']);
        $status[] = strip_tags($Show['entrada_status'] == 1 ? 'Aguardando' : 'Liberado');
        $id[] = strip_tags($Show['entrada_produto_id']);
        $operacao[] = 'Entrada';

        $pedido[] = strip_tags($Show['saida_codigo']);
        $nf[] = strip_tags($Show['saida_nf']);
        $status[] = strip_tags($Show['saida_status'] == 1 ? 'Aguardando' : 'Liberado');
        $id[] = strip_tags($Show['saida_id']);
        $operacao[] = 'Saída';

        $pedido[] = strip_tags($Show['devolucao_codigo']);
        $nf[] = strip_tags($Show['devolucao_nf']);
        $status[] = strip_tags($Show['devolucao_status'] == 1 ? 'Aguardando' : 'Liberado');
        $id[] = strip_tags($Show['devolucao_id']);
        $operacao[] = 'Devolução';

    }    
    $message = ["pedido" => $pedido, "nf" => $nf, "stat" => $status, "id" => $id, "operacao" => $operacao];
    echo json_encode($message);
    return;
}

// PEDIDO
if($Search['type'] == 'n' && !empty($Search['searching'])){
    $Read = $pdo->prepare("SELECT a.entrada_nf, a.entrada_codigo, a.entrada_produto_id, a.entrada_status, b.saida_nf, b.saida_codigo, b.saida_id, b.saida_status, c.devolucao_nf, c.devolucao_codigo, c.devolucao_id, c.devolucao_status 
    FROM si_entrada a 
    INNER JOIN si_saida b ON (b.saida_nf = a.entrada_nf OR b.saida_nf = '')
    INNER JOIN si_devolucao c ON (c.devolucao_nf = a.entrada_nf OR c.devolucao_nf = '')
    WHERE a.entrada_nf = :entrada_nf");
    $Read->bindValue(':entrada_nf', $Search['searching']);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0){
        $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
        echo json_encode($message);
        return; 
    }
    
    foreach($Read as $Show){
        $pedido[] = strip_tags($Show['entrada_codigo']);
        $nf[] = strip_tags($Show['entrada_nf']);
        $status[] = strip_tags($Show['entrada_status'] == 1 ? 'Aguardando' : 'Liberado');
        $id[] = strip_tags($Show['entrada_produto_id']);
        $operacao[] = 'Entrada';

        $pedido[] = strip_tags($Show['saida_codigo']);
        $nf[] = strip_tags($Show['saida_nf']);
        $status[] = strip_tags($Show['saida_status'] == 1 ? 'Aguardando' : 'Liberado');
        $id[] = strip_tags($Show['saida_id']);
        $operacao[] = 'Saída';

        $pedido[] = strip_tags($Show['devolucao_codigo']);
        $nf[] = strip_tags($Show['devolucao_nf']);
        $status[] = strip_tags($Show['devolucao_status'] == 1 ? 'Aguardando' : 'Liberado');
        $id[] = strip_tags($Show['devolucao_id']);
        $operacao[] = 'Devolução';

    }
    
    $message = ["pedido" => $pedido, "nf" => $nf, "stat" => $status, "id" => $id, "operacao" => $operacao];
    echo json_encode($message);
    return; 
}

// PEDIDO + TIPO DE OPERAÇÃO
if($Search['type'] != 'n' && !empty($Search['searching'])){
    if($Search['type'] == 1){ //ENTRADA
        $Read = $pdo->prepare("SELECT entrada_nf, entrada_codigo, entrada_produto_id, entrada_status
        FROM si_entrada WHERE entrada_nf = :entrada_nf");
        $Read->bindValue(':entrada_nf', $Search['searching']);
        $Read->execute();

        $Lines = $Read->rowCount();

        if($Lines == 0){
            $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
            echo json_encode($message);
            return; 
        }
        
        foreach($Read as $Show){
            $pedido[] = strip_tags($Show['entrada_codigo']);
            $nf[] = strip_tags($Show['entrada_nf']);
            $status[] = strip_tags($Show['entrada_status'] == 1 ? 'Aguardando' : 'Liberado');
            $id[] = strip_tags($Show['entrada_produto_id']);
            $operacao[] = 'Entrada';

        }
        $message = ["pedido" => $pedido, "nf" => $nf, "stat" => $status, "id" => $id, "operacao" => $operacao];
        echo json_encode($message);
        return; 
    }else if($Search['type'] == 2){ // SAÍDA
        $Read = $pdo->prepare("SELECT saida_nf, saida_codigo, saida_id, saida_status
        FROM si_saida WHERE saida_nf = :saida_nf");
        $Read->bindValue(':saida_nf', $Search['searching']);
        $Read->execute();

        $Lines = $Read->rowCount();

        if($Lines == 0){
            $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
            echo json_encode($message);
            return; 
        }
        
        foreach($Read as $Show){
            $pedido[] = strip_tags($Show['saida_codigo']);
            $nf[] = strip_tags($Show['saida_nf']);
            $status[] = strip_tags($Show['saida_status'] == 1 ? 'Aguardando' : 'Liberado');
            $id[] = strip_tags($Show['saida_id']);
            $operacao[] = 'Saída';

           
        }
        $message = ["pedido" => $pedido, "nf" => $nf, "stat" => $status, "id" => $id, "operacao" => $operacao];
        echo json_encode($message);
        return; 
    }else if($Search['type'] == 3){ // DEVOLUÇÃO
            $Read = $pdo->prepare("SELECT devolucao_nf, devolucao_codigo, devolucao_id, devolucao_status
            FROM si_devolucao WHERE devolucao_nf = :devolucao_nf");
            $Read->bindValue(':devolucao_nf', $Search['searching']);
            $Read->execute();
    
            $Lines = $Read->rowCount();

            if($Lines == 0){
                $message = ["status" => "info", "message" => "Não foi encontrado nenhum resultado!", "Lines" => 0];
                echo json_encode($message);
                return; 
            }
            
            foreach($Read as $Show){
                $pedido[] = strip_tags($Show['devolucao_codigo']);
                $nf[] = strip_tags($Show['devolucao_nf']);
                $status[] = strip_tags($Show['devolucao_status'] == 1 ? 'Aguardando' : 'Liberado');
                $id[] = strip_tags($Show['devolucao_id']);
                $operacao[] = 'Devolução';
    
                
            }
        $message = ["pedido" => $pedido, "nf" => $nf, "stat" => $status, "id" => $id, "operacao" => $operacao];
        echo json_encode($message);
        return; 
    }else if($Search['type'] == 4){ // CANCELADO   
        $message = ["status" => "info", "message" => "Não é possivel buscar NF no estado cancelado", "Lines" => 0];
    }
    
        echo json_encode($message);
        return; 
}
