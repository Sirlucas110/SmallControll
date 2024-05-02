<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_STRIPPED);    
$Val = filter_input(INPUT_GET, 'val',FILTER_SANITIZE_STRIPPED);

// ENTRADA
if($Val == 'Entrada'){

        //Consulta na tabela da operação
        $ReadProd = $pdo->prepare("SELECT * FROM " . DB_STOCKIN . " WHERE entrada_produto_id = :entrada_produto_id");
        $ReadProd->bindValue(':entrada_produto_id', $Id);
        $ReadProd->execute();

        $LinesProd = $ReadProd -> rowCount();

        if($LinesProd == 0){
            $message = ['status'=> 'info', 'message'=> 'Esta operação está inativa ou nao existe mais!', 'redirect'=> '', 'lines' => 0];
            
            //Deleta sem movimentação da tabela de entrada
            $DeleteProd = $pdo->prepare("DELETE FROM " . DB_STOCKIN . " WHERE entrada_produto_id = :entrada_produto_id");
            $DeleteProd->bindValue(':entrada_produto_id', $Id);
            $DeleteProd->execute();
            
            echo json_encode($message);
            return;
        }

        foreach($ReadProd as $Show){}

        $product = strip_tags($Show['entrada_produto_nome']);
        $qtd = strip_tags($Show['entrada_quantidade']);

        //Consultar na tabela do produto
        $ReadProd = $pdo->prepare("SELECT * FROM " . DB_PRODUCT . " WHERE produto_nome = :produto_nome");
        $ReadProd->bindValue(':produto_nome', $product);
        $ReadProd->execute();

        $LinesProd = $ReadProd -> rowCount();
        if($LinesProd == 0){
            $message = ['status'=> 'info', 'message'=> 'Este produto está inativo ou não existe!', 'redirect'=> '', 'lines' => 0];
            
            echo json_encode($message);
            return;
        }

        foreach($ReadProd as $Show){}
        $productId = strip_tags($Show['produto_id']);
        $productQtd = strip_tags($Show['produto_quantidade']);

        //Calculo de movimentação da operação
        $calc = $productQtd - $qtd;

        //Operação na tabela produto (subtração) 
        $Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_quantidade = :produto_quantity WHERE produto_id = :produto_id");
        $Update -> bindValue(':produto_quantity', $calc);
        $Update -> bindValue(':produto_id', $productId);
        $Update -> execute();

        //Exclusão do ID da tabela da operação entrada
        $DeleteProd = $pdo->prepare("DELETE FROM " . DB_STOCKIN . " WHERE entrada_produto_id = :entrada_produto_id");
        $DeleteProd->bindValue(':entrada_produto_id', $Id);
        $DeleteProd->execute();
        
    $message = ['status' => 'success', 'message' => 'Operação excluída com sucesso!', 'redirect'=> 'stock'];
    echo json_encode($message);
    return;
}

//SAÍDA 
if($Val == 'Saída'){

    //Consulta na tabela da operação
    $ReadProd = $pdo->prepare("SELECT * FROM " . DB_STOCKOUT . " WHERE saida_id = :saida_id");
    $ReadProd->bindValue(':saida_id', $Id);
    $ReadProd->execute();

    $LinesProd = $ReadProd -> rowCount();

    if($LinesProd == 0){
        $message = ['status'=> 'info', 'message'=> 'Esta operação está inativa ou nao existe mais!', 'redirect'=> '', 'lines' => 0];
        
        //Deleta sem movimentação da tabela de saida
        $DeleteProd = $pdo->prepare("DELETE FROM " . DB_STOCKOUT . " WHERE saida_id = :saida_id");
        $DeleteProd->bindValue(':saida_id', $Id);
        $DeleteProd->execute();
        
        echo json_encode($message);
        return;
    }

    foreach($ReadProd as $Show){}

    $product = strip_tags($Show['saida_produto_nome']);
    $qtd = strip_tags($Show['saida_quantidade']);

    //Consultar na tabela do produto
    $ReadProd = $pdo->prepare("SELECT * FROM " . DB_PRODUCT . " WHERE produto_nome = :produto_nome");
    $ReadProd->bindValue(':produto_nome', $product);
    $ReadProd->execute();

    $LinesProd = $ReadProd -> rowCount();
    if($LinesProd == 0){
        $message = ['status'=> 'info', 'message'=> 'Este produto está inativo ou não existe!', 'redirect'=> '', 'lines' => 0];
        
        echo json_encode($message);
        return;
    }

    foreach($ReadProd as $Show){}
    $productId = strip_tags($Show['produto_id']);
    $productQtd = strip_tags($Show['produto_quantidade']);

    //Calculo de movimentação da operação
    $calc = $productQtd + $qtd;

    //Operação na tabela produto (subtração) 
    $Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_quantidade = :produto_quantity WHERE produto_id = :produto_id");
    $Update -> bindValue(':produto_quantity', $calc);
    $Update -> bindValue(':produto_id', $productId);
    $Update -> execute();

    //Exclusão do ID da tabela da operação saida
    $DeleteProd = $pdo->prepare("DELETE FROM " . DB_STOCKOUT . " WHERE saida_id = :saida_id");
    $DeleteProd->bindValue(':saida_id', $Id);
    $DeleteProd->execute();
    
$message = ['status' => 'success', 'message' => 'Operação excluída com sucesso!', 'redirect'=> 'stock'];
echo json_encode($message);
return;
}

//DEVOLUÇÃO
if($Val == 'Devolução'){

    //Consulta na tabela da operação
    $ReadProd = $pdo->prepare("SELECT * FROM " . DB_DEVOLUTION . " WHERE devolucao_id = :devolucao_id");
    $ReadProd->bindValue(':devolucao_id', $Id);
    $ReadProd->execute();

    $LinesProd = $ReadProd -> rowCount();

    if($LinesProd == 0){
        $message = ['status'=> 'info', 'message'=> 'Esta operação está inativa ou nao existe mais!', 'redirect'=> '', 'lines' => 0];
        
        //Deleta sem movimentação da tabela de devolução
        $DeleteProd = $pdo->prepare("DELETE FROM " . DB_DEVOLUTION . " WHERE devolucao_id = :devolucao_id");
        $DeleteProd->bindValue(':devolucao_id', $Id);
        $DeleteProd->execute();
        
        echo json_encode($message);
        return;
    }

    foreach($ReadProd as $Show){}

    $product = strip_tags($Show['devolucao_produto_nome']);
    $qtd = strip_tags($Show['devolucao_quantidade']);

    //Consultar na tabela do produto
    $ReadProd = $pdo->prepare("SELECT * FROM " . DB_PRODUCT . " WHERE produto_nome = :produto_nome");
    $ReadProd->bindValue(':produto_nome', $product);
    $ReadProd->execute();

    $LinesProd = $ReadProd -> rowCount();
    if($LinesProd == 0){
        $message = ['status'=> 'info', 'message'=> 'Este produto está inativo ou não existe!', 'redirect'=> '', 'lines' => 0];
        
        echo json_encode($message);
        return;
    }

    foreach($ReadProd as $Show){}
    $productId = strip_tags($Show['produto_id']);
    $productQtd = strip_tags($Show['produto_quantidade']);

    //Calculo de movimentação da operação
    $calc = $productQtd + $qtd;

    //Operação na tabela produto (subtração) 
    $Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_quantidade = :produto_quantity WHERE produto_id = :produto_id");
    $Update -> bindValue(':produto_quantity', $calc);
    $Update -> bindValue(':produto_id', $productId);
    $Update -> execute();

    //Exclusão do ID da tabela da operação devolução
    $DeleteProd = $pdo->prepare("DELETE FROM " . DB_DEVOLUTION . " WHERE devolucao_id = :devolucao_id");
    $DeleteProd->bindValue(':devolucao_id', $Id);
    $DeleteProd->execute();
    
$message = ['status' => 'success', 'message' => 'Operação excluída com sucesso!', 'redirect'=> 'stock'];
echo json_encode($message);
return;
}


