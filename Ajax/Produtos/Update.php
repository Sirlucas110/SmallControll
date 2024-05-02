<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "Produto"
if(empty($Search['productEdit'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o nome do Produto !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Categoria"
if(empty($Search['categoryEdit'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Categoria !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Preço"
if(empty($Search['priceEdit'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Preço !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Quantidade de produto"
if(empty($Search['quantityEdit'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo quantidade !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$Read = $pdo->prepare("SELECT produto_id, produto_capa FROM ".DB_PRODUCT." WHERE produto_id = :produto_id");
$Read->bindValue(':produto_id', $Search['product_id']);
$Read->execute();

$Lines = $Read->rowCount();
foreach($Read as $Show){

}
$Img = strip_tags($Show ['produto_capa']);

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Este produto não está registrado!', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}


// Excluir imagem anterior
if($_FILES['files']['name'] == ''){
    $CreateFileName = $Img;
    //Verificar se a imagem foi cadastrada no registro anterior
    if($_FILES['files']['name'] != ''){
        unlink('../../Images/Products/' . $Img);
    }
}else{

    if($Img != '' && file_exists('../../Images/Products/' . $Img)){
        unlink('../../Images/Products/' . $Img);
    }
    //Captura o nome do arquivo
    $FileName = strip_tags(mb_strtolower($_FILES['file']['name']));

    //Recupera a extensão do arquivo
    $FileExtension = strip_tags($_FILES['file']['type']);

    //Pega o diretório temporário onde o arquivo está
    $FilePath = strip_tags($_FILES['file']['tmp_name']);

    //Pega o tamanho do arquivo
    $FileSize = strip_tags($_FILES['file']['size']);

    //Definimos a pasta para o download do arquivo
    $_UP['pasta'] = '../../Images/Products/';

    //Limpa possíveis caracteres, acentuação e extensões.
    $cover = str_replace(
        array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú',
            'Û', 'Ü', 'ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó',
            'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ý', 'ý', 'þ', 'ÿ', '"', '!', '@', '#', '$', '%', '&', '*', '(', ')', '_', '-', '+', '=', '{',
            '[', '}', ']', '/', '?,', ';', ':', 'ª', 'º', '.docx', '.pdf', '.doc', '.htm', '.jfif', '.jpg', '.jpeg', '.png', '.msg', '.txt', '.xls', '.xlsx', '.tif', '.tiff', '.p7s', '.html', '.dat', '.oft', '.xlsm', '.rar', '.zip'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u',
            'u', 'u', 'u', 'y', '', '', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'n', 'o', 'o',
            'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'y', '', 'y', '', '', '', '', '', '', '', '', '', '', '', '-', '', '', '', '', '', '', '', '', '', '', '', '', '-' . date('d-m-Y H-i-s') . '.docx', '-' . date('d-m-Y H-i-s') . '.pdf', '-' . date('d-m-Y H-i-s') . '.doc', '-' . date('d-m-Y H-i-s') . '.htm', '-' . date('d-m-Y H-i-s') . '.jfif', '-' . date('d-m-Y H-i-s') . '.jpg', '-' . date('d-m-Y H-i-s') . '.jpeg', '-' . date('d-m-Y H-i-s') . '.png', '-' . date('d-m-Y H-i-s') . '.msg', '-' . date('d-m-Y H-i-s') . '.txt', '-' . date('d-m-Y H-i-s') . '.xls', '-' . date('d-m-Y H-i-s') . '.xlsx', '-' . date('d-m-Y H-i-s') . '.tif', '-' . date('d-m-Y H-i-s') . '.tiff', '-' . date('d-m-Y H-i-s') . '.p7s', '-' . date('d-m-Y H-i-s') . '.html', '-' . date('d-m-Y H-i-s') . '.dat', '-' . date('d-m-Y H-i-s') . '.oft', '-' . date('d-m-Y H-i-s') . '.xlsm', '-' . date('d-m-Y H-i-s') . '.rar', '-' . date('d-m-Y H-i-s') . '.zip')
        , $FileName);

    //Checa se a imagem é .zip ou .rar
    $path = pathinfo($FileName);
    $ext = $path['extension'];

    //Verificar as extensões
    if ($ext == 'js' || $ext == 'php' || $ext == 'html' || $ext == 'htm' || $ext == 'xhtml' || $ext == 'css' || $ext == 'ini' || $ext == 'py' || $ext == 'htaccess' || $ext == 'xml' || $ext == 'gz' || $ext == 'json' || $ext == 'go' || $ext == 'jsp' || $ext == 'cs' || $ext == 'asp' || $ext == 'aspx' || $ext == 'bat' || $ext == 'exe' || $ext == 'sql' || $ext == 'c' || $ext == '*' || $ext == 'rb' || $ext == 'erb' || $ext == 'jbuilder' || $ext == 'zip' || $ext == 'rar') {

        $message = [
            "message" => "Este arquivo não é permitido",
            "status" => "error",
            "redirect" => ""
        ];

        //O JSON retorna para o usuário via AJAX a mensagem de sucesso na tela.
        echo json_encode($message);
        return true;
        die;

    }

        $guid = rand(1000, 10000);  
            
        //Cria novo nome para o arquivo (criptografado)
        $CreateFileName = $guid . '-' . hash('sha256', $cover) . rand(10, 200) . '.' . $ext;

        //Definimos a pasta de destino + o nome do arquivo.
        $destiny = $_UP['pasta'] . '' . $CreateFileName;

        //Realizamos o upload
        move_uploaded_file($FilePath, $destiny);
}
    $Price = str_replace(',' , '.', $Search['priceEdit']);
    $Update = $pdo->prepare("UPDATE " . DB_PRODUCT . " SET produto_capa = :produto_capa, produto_nome = :produto_nome, produto_preco = :produto_preco, produto_quantidade = :produto_quantidade, produto_categoria = :produto_categoria WHERE produto_id = :produto_id");
    $Update->bindValue(':produto_capa', $CreateFileName);
    $Update->bindValue(':produto_nome', $Search['productEdit']);
    $Update->bindValue(':produto_preco', $Price);
    $Update->bindValue(':produto_quantidade', $Search['quantityEdit']);
    $Update->bindValue(':produto_categoria', $Search['categoryEdit']);
    $Update->bindValue(':produto_id', $Search['product_id']);
    $Update->execute();

    $message = ['status' => 'success', 'message' => 'Produto atualizado com sucesso!', 'redirect'=> 'products'];
    echo json_encode($message);
    return;

