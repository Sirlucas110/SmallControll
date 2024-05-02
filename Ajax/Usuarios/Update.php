<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo do "Nome"

if(empty($Search['username'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo nome do usuario !', 'Redirect'=> '', 'lines' => 0];
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
 
// Checar o campo "Level"
if(empty($Search[userlevel])){
    $message = ['status'=> 'info', 'message'=> 'Escolha uma opção de nivel de acesso !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$Read = $pdo->prepare("SELECT usuarios_id, usuarios_imagem FROM ".DB_USERS." WHERE usuarios_id = :usuarios_id");
$Read->bindValue(':usuarios_id', $Search['user_id']);
$Read->execute();

$Lines = $Read->rowCount();
foreach($Read as $Show){

}
$Img = strip_tags($Show ['usuarios_imagem']);

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Este usuario não está registrado!', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}


// Excluir imagem anterior
if($_FILES['file']['name'] == ''){
    $CreateFileName = $Img;
    //Verificar se a imagem foi cadastrada no registro anterior
    if($_FILES['files']['name'] != ''){
        unlink('../../Images/Users/' . $Img);
    }
}else{

    if($Img != '' && file_exists('../../Images/Users/' . $Img)){
        unlink('../../Images/Users/' . $Img);
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

    $Update = $pdo->prepare("UPDATE " . DB_USERS . " SET usuarios_imagem = :usuarios_imagem, usuarios_nome = :usuarios_nome, usuarios_email = :usuarios_email, usuarios_nivel = :usuarios_nivel WHERE usuarios_id = :usuarios_id");
    $Update->bindValue(':usuarios_imagem', $CreateFileName);
    $Update->bindValue(':usuarios_nome', $Search['username']);
    $Update->bindValue(':usuarios_email', $Search['useremail']);
    $Update->bindValue(':usuarios_nivel', $Search['userlevel']);
    $Update->bindValue(':usuarios_id', $Search['user_id']);
    $Update->execute();

    $message = ['status' => 'success', 'message' => 'Usuario atualizado com sucesso!', 'redirect'=> 'users'];
    echo json_encode($message);
    return;

