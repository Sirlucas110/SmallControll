<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "Produto"
if(empty($Search['product'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o nome do Produto !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Categoria"
if(empty($Search['category'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Categoria !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

// Checar o campo "Preço"
if(empty($Search['price'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Preço !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Quantidade de produto"
if(empty($Search['quantity'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo quantidade !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$Read = $pdo->prepare("SELECT produto_categoria, produto_nome FROM " . DB_PRODUCT . " WHERE produto_categoria = :produto_categoria AND produto_nome = :produto_nome");
$Read->bindValue(':produto_categoria', $Search['category']);
$Read->bindValue(':produto_nome', $Search['product']);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines >= 1){
    $message = ['status'=> 'info', 'message'=> 'Este produto já está registrado!', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Excluir imagem anterior
if($_FILES['files']['name'] == ''){
    $CreateFileName = '';
}else{

    //Captura o nome do arquivo
    $FileName = strip_tags(mb_strtolower($_FILES['files']['name']));

    //Recupera a extensão do arquivo
    $FileExtension = strip_tags($_FILES['files']['type']);

    //Pega o diretório temporário onde o arquivo está
    $FilePath = strip_tags($_FILES['files']['tmp_name']);

    //Pega o tamanho do arquivo
    $FileSize = strip_tags($_FILES['files']['size']);

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
        return false;
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

$Token = rand(10, 100). rand(1000, 10000);
$Price = str_replace(',', '.', $Search['price']);
$Create = $pdo->prepare("INSERT INTO " . DB_PRODUCT . "(produto_nome, produto_preco, produto_quantidade, produto_categoria, produto_capa, produto_status, produto_sessao)
VALUES( :produto_nome, :produto_preco, :produto_quantidade, :produto_categoria, :produto_capa, :produto_status, :produto_sessao)");
$Create->bindValue(':produto_nome', $Search['product']);
$Create->bindValue(':produto_preco', $Price);
$Create->bindValue(':produto_quantidade', $Search['quantity']);
$Create->bindValue(':produto_categoria', $Search['category']);
$Create->bindValue(':produto_capa', $CreateFileName);
$Create->bindValue(':produto_status', 1);
$Create->bindValue(':produto_sessao', $Token);
$Create->execute();

$message = ['status' => 'success', 'message' => 'Produto cadastrado com sucesso!', 'redirect'=> 'products'];
echo json_encode($message);
return; 
