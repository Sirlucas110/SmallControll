<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Search = strip_tags(filter_input(INPUT_GET, 'val', FILTER_SANITIZE_STRIPPED));

$Read = $pdo->prepare("SELECT usuarios_id, usuarios_imagem FROM ".DB_USERS." WHERE usuarios_id = :usuarios_id");
$Read->bindValue(':usuarios_id', $Search);
$Read->execute();

$Lines = $Read->rowCount();
foreach($Read as $Show){

}
$Img = strip_tags($Show ['usuarios_imagem']);

if($Img != '' && file_exists('../../Images/Users/' . $Img)){
    unlink('../../Images/Users/' . $Img);
}
$Delete = $pdo->prepare("DELETE FROM ".DB_USERS." WHERE usuarios_id = :usuarios_id");
$Delete->bindValue(':usuarios_id', $Search);
$Delete->execute();

$message = ['status'=> 'success', 'message' => 'Usuário Deletado!' ,'redirect' => 'users'];

echo json_encode($message);
return;