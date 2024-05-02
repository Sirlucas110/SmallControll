<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Search = strip_tags(filter_input(INPUT_GET, 'val', FILTER_SANITIZE_STRIPPED));

$Read = $pdo->prepare("SELECT produto_id, produto_capa FROM ".DB_PRODUCT." WHERE produto_id = :produto_id");
$Read->bindValue(':produto_id', $Search);
$Read->execute();

$Lines = $Read->rowCount();

foreach($Read as $Show){}

$Img = strip_tags($Show['produto_capa']);

if($Img != '' && file_exists('../../Images/Products/' . $Img)){
    unlink('../../Images/Products/' . $Img);
}
$Delete = $pdo->prepare("DELETE FROM ".DB_PRODUCT." WHERE produto_id = :produto_id");
$Delete->bindValue(':produto_id', $Search);
$Delete->execute();

$message = ['status'=> 'success', 'message' => 'Produto Deletado!' ,'redirect' => 'products'];

echo json_encode($message);
return;