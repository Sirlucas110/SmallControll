<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "cliente"
if(empty($Search['client'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo cliente !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Email"
if(empty($Search['email'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo E-mail !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "CPF"
if(empty($Search['cpf']) && $Search['doc'] == 1){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo CPF !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "CNPJ"
if(empty($Search['cnpj']) && $Search['doc'] == 2){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo CNPJ !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

//Verifica se há algum documento anexado
/* if($_FILES['files']['name'] == ''){
    $message = [
            "message" => "Favor, anexe uma foto no cadastro do cliente",
            "status" => "info",
            "redirect" => ""
            ];
    echo json_encode($message);
    return;
    $fileCount = 'no';
} */ 

// Verificar o tipo de documento
if($Search['doc'] == 1){
    $doc = strip_tags($Search['cpf']);
}else{
    $doc = strip_tags($Search['cnpj']);
}
$Read = $pdo->prepare("SELECT cliente_documento FROM ".DB_CLIENTS." WHERE cliente_documento = :cliente_documento");
$Read->bindValue(':cliente_documento', $doc);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines >= 1){
    $message = ['status'=> 'info', 'message'=> 'Este cliente já está registrado!', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
    // Excluir imagem anterior
if($_FILES['file']['name'] == ''){
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
    $_UP['pasta'] = '../../Images/Clients/';

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

$token = rand(100, 1000). '-' . $Search['client'];
$Create = $pdo->prepare("INSERT INTO " . DB_CLIENTS . "(cliente_imagem, cliente_nome, cliente_email, cliente_endereco, cliente_numero, cliente_bairro, cliente_cep, cliente_cidade, cliente_estado, cliente_documento, cliente_telefone, cliente_token, cliente_status, cliente_sessao)
VALUES(:cliente_imagem, :cliente_nome, :cliente_email, :cliente_endereco, :cliente_numero, :cliente_bairro, :cliente_cep, :cliente_cidade, :cliente_estado, :cliente_documento, :cliente_telefone, :cliente_token, :cliente_status, :cliente_sessao)");

$Create->bindValue(':cliente_imagem', $CreateFileName);
$Create->bindValue(':cliente_nome', $Search['client']);
$Create->bindValue(':cliente_email', $Search['email']);
$Create->bindValue(':cliente_endereco', $Search['address']);
$Create->bindValue(':cliente_numero', $Search['number']);
$Create->bindValue(':cliente_bairro', $Search['neighborhood']);
$Create->bindValue(':cliente_cep', $Search['zipcode']);
$Create->bindValue(':cliente_cidade', $Search['city']);
$Create->bindValue(':cliente_estado', $Search['state']);
$Create->bindValue(':cliente_documento', $doc);
$Create->bindValue(':cliente_telefone', $Search['phone']);
$Create->bindValue(':cliente_token', $token);
$Create->bindValue(':cliente_status', 1);
$Create->bindValue(':cliente_sessao', $_SESSION['user_id']);
$Create->execute();

$message = ['status' => 'success', 'message' => 'Cliente cadastrado com sucesso!', 'redirect'=> 'clients'];
echo json_encode($message);
return; 
