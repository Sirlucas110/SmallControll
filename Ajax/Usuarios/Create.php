<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "Usuario"
if(empty($Search['username'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o nome do Usuario !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Email"
if(empty($Search['useremail'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo E-mail !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
//Checa se o e-mail é válido  do usuário
if(!filter_var($Search['useremail'], FILTER_VALIDATE_EMAIL)){      
    $message = ['status'=> 'info', 'message'=> 'Favor, digite um e-mail válido', 'redirect' => '', 'lines' => 0];     
    echo json_encode($message);     
    return; 
}
// Checar o campo "senha"
if(empty($Search['userpass'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo senha !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "senha"
if(empty($Search['userpass'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo senha !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Nivel de acesso"
if(empty($Search['userlevel'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo de nivel de acesso !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$Read = $pdo->prepare("SELECT usuarios_email, usuarios_nome FROM ".DB_USERS." WHERE usuarios_email = :usuarios_email AND usuarios_nome = :usuarios_nome");
$Read->bindValue(':usuarios_email', $Search['useremail']);
$Read->bindValue(':usuarios_nome', $Search['username']);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines >= 1){
    $message = ['status'=> 'info', 'message'=> 'Este usuário já está registrado!', 'redirect'=> '', 'lines' => 0];
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
    $_UP['pasta'] = '../../Images/Users/';

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
$Password = password_hash($Search['userpass'], PASSWORD_DEFAULT);
$Create = $pdo->prepare("INSERT INTO " . DB_USERS . "(usuarios_imagem, usuarios_nome, usuarios_email, usuarios_senha, usuarios_status, usuarios_nivel, token)
VALUES(:usuarios_imagem, :usuarios_nome, :usuarios_email, :usuarios_senha, :usuarios_status, :usuarios_nivel, :token)");
$Create->bindValue(':usuarios_imagem', $CreateFileName);
$Create->bindValue(':usuarios_nome', $Search['username']);
$Create->bindValue(':usuarios_email', $Search['useremail']);
$Create->bindValue(':usuarios_senha', $Password);
$Create->bindValue(':usuarios_status', 1);
$Create->bindValue(':usuarios_nivel', $Search['userlevel']);
$Create->bindValue(':token', $Token);
$Create->execute();

$message = ['status' => 'success', 'message' => 'Usuário cadastrado com sucesso!', 'redirect'=> 'users'];
echo json_encode($message);
return; 
