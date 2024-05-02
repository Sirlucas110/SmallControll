<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Search = strip_tags(filter_input(INPUT_GET, 'val', FILTER_SANITIZE_STRIPPED));

$Read = $pdo->prepare("SELECT cliente_id, cliente_imagem FROM ".DB_CLIENTS." WHERE cliente_id = :cliente_id");
$Read->bindValue(':cliente_id', $Search);
$Read->execute();

$Lines = $Read->rowCount();
foreach($Read as $Show){

}
$Img = strip_tags($Show['cliente_imagem']);

if($Img != '' && file_exists('../../Images/Clients/' . $Img)){
    unlink('../../Images/Clients/' . $Img);
}
$Delete = $pdo->prepare("DELETE FROM ".DB_CLIENTS." WHERE cliente_id = :cliente_id");
$Delete->bindValue(':cliente_id', $Search);
$Delete->execute();

$message = ['status'=> 'success', 'message' => 'Cliente Deletado!' ,'redirect' => 'clients'];

echo json_encode($message);
return;