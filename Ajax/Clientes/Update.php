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

//Checa se o e-mail é válido  do cliente
if(!filter_var($Search['email'], FILTER_VALIDATE_EMAIL)){      
    $message = ['status'=> 'info', 'message'=> 'Favor, digite um e-mail válido', 'redirect' => '', 'lines' => 0];     
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


// Verificar o tipo de documento
if($Search['doc'] == 1){
    $doc = strip_tags($Search['cpf']);
}else{
    $doc = strip_tags($Search['cnpj']);
}

$Read = $pdo->prepare("SELECT cliente_id, cliente_imagem FROM ".DB_CLIENTS." WHERE cliente_id = :cliente_id");
$Read->bindValue(':cliente_id', $Search['client_id']);
$Read->execute();

$Lines = $Read->rowCount();
foreach($Read as $Show){

}
$Img = strip_tags($Show ['cliente_imagem']);

if($Lines == 0){
    $message = ['status'=> 'info', 'message'=> 'Este cliente não está registrado!', 'redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}


// Excluir imagem anterior
if($_FILES['file']['name'] == ''){
    $CreateFileName = $Img;
    //Verificar se a imagem foi cadastrada no registro anterior
    if($_FILES['files']['name'] != ''){
        unlink('../../Images/Clients/' . $Img);
    }
}else{

    if($Img != '' && file_exists('../../Images/Clients/' . $Img)){
        unlink('../../Images/Clients/' . $Img);
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

    $Update = $pdo->prepare("UPDATE " . DB_CLIENTS . " SET cliente_imagem = :cliente_imagem, cliente_nome = :cliente_nome, cliente_email = :cliente_email, cliente_endereco = :cliente_endereco, cliente_numero = :cliente_numero, cliente_bairro = :cliente_bairro, cliente_cep = :cliente_cep, cliente_cidade = :cliente_cidade, cliente_estado = :cliente_estado, cliente_documento = :cliente_documento, cliente_telefone = :cliente_telefone WHERE cliente_id = :cliente_id");
    $Update->bindValue(':cliente_imagem', $CreateFileName);
    $Update->bindValue(':cliente_nome', $Search['client']);
    $Update->bindValue(':cliente_email', $Search['email']);
    $Update->bindValue(':cliente_endereco', $Search['address']);
    $Update->bindValue(':cliente_numero', $Search['number']);
    $Update->bindValue(':cliente_bairro', $Search['neighborhood']);
    $Update->bindValue(':cliente_cep', $Search['zipcode']);
    $Update->bindValue(':cliente_cidade', $Search['city']);
    $Update->bindValue(':cliente_estado', $Search['state']);
    $Update->bindValue(':cliente_documento', $doc);
    $Update->bindValue(':cliente_telefone', $Search['phone']);
    $Update->bindValue(':cliente_id', $Search['client_id']);
    $Update->execute();

    $message = ['status' => 'success', 'message' => 'Cliente atualizado com sucesso!', 'redirect'=> 'clients'];
    echo json_encode($message);
    return;

