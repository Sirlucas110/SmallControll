<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo nome da Categoria
if(empty($Search['categoryName'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o nome da Categoria !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
//Verificar se a categoria ja existe
$Read = $pdo->prepare("SELECT categoria_nome FROM " . DB_CATEGORY . " WHERE categoria_nome = :categoria_nome");
$Read->bindValue(':categoria_nome', $Search['categoryName']);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines >= 1){
    $message = ['status'=> 'info', 'message'=> 'Esta categoria já está registrada!', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$Token = rand(10, 100). rand(1000, 10000);
$Create = $pdo->prepare("INSERT INTO " . DB_CATEGORY . "(categoria_nome, categoria_sessao) VALUES (:categoria_nome, :categoria_sessao)");
$Create->bindValue(':categoria_nome', $Search['categoryName']);
$Create->bindValue(':categoria_sessao', $Token);
$Create->execute();

$message = ['status' => 'success', 'message' => 'Categoria cadastrada  com sucesso!', 'redirect'=> 'products'];
echo json_encode($message);
return; 
