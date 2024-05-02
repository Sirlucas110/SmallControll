<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Search = strip_tags(filter_input(INPUT_GET, 'val', FILTER_SANITIZE_STRIPPED));

$Read = $pdo->prepare("SELECT fornecedor_id, fornecedor_img FROM ".DB_PROVIDERS." WHERE fornecedor_id = :fornecedor_id");
$Read->bindValue(':fornecedor_id', $Search);
$Read->execute();

$Lines = $Read->rowCount();
foreach($Read as $Show){

}
$Img = strip_tags($Show['fornecedor_img']);

if($Img != '' && file_exists('../../Images/Providers/' . $Img)){
    unlink('../../Images/Providers/' . $Img);
}
$Delete = $pdo->prepare("DELETE FROM ".DB_PROVIDERS." WHERE fornecedor_id = :fornecedor_id");
$Delete->bindValue(':fornecedor_id', $Search);
$Delete->execute();

$message = ['status'=> 'success', 'message' => 'Fornecedor Deletado!' ,'redirect' => 'providers'];

echo json_encode($message);
return;