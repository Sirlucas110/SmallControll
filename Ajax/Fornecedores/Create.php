<?php
session_start();

include_once '../../includes/config.php';

$message = '';

$Searching = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
$Search = array_map('strip_tags', $Searching);

// Checar o campo "Fornecedor"
if(empty($Search['company'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o nome do Fornecedor !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Email"
if(empty($Search['email'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo E-mail !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Telefone"
if(empty($Search['phone'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Telefone !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "CNPJ"
if(empty($Search['cnpj'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo CNPJ !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "CEP"
if(empty($Search['zipcode'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo CEP !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "ENDEREÇO"
if(empty($Search['address'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Endereço !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Numero"
if(empty($Search['number'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Numero !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Bairro"
if(empty($Search['neighborhood'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Bairro !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Cidade"
if(empty($Search['city'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Cidade !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}
// Checar o campo "Estado"
if(empty($Search['state'])){
    $message = ['status'=> 'info', 'message'=> 'Por favor, preencha o campo Estado !', 'Redirect'=> '', 'lines' => 0];
    echo json_encode($message);
    return; 
}

$Read = $pdo->prepare("SELECT fornecedor_documento, fornecedor_nome FROM ".DB_PROVIDERS." WHERE fornecedor_documento = :fornecedor_documento AND fornecedor_nome = :fornecedor_nome");
$Read->bindValue(':fornecedor_documento', $Search['cnpj']);
$Read->bindValue(':fornecedor_nome', $Search['company']);
$Read->execute();

$Lines = $Read->rowCount();

if($Lines >= 1){
    $message = ['status'=> 'info', 'message'=> 'Este fornecedor já está registrado!', 'redirect'=> '', 'lines' => 0];
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
    $_UP['pasta'] = '../../Images/Providers/';

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
$Create = $pdo->prepare("INSERT INTO " . DB_PROVIDERS . "(fornecedor_img, fornecedor_nome, fornecedor_email, fornecedor_endereco, fornecedor_number, fornecedor_neighborhood, fornecedor_cep, fornecedor_cidade, fornecedor_estado, fornecedor_documento, fornecedor_telefone, fornecedor_status, fornecedor_sessao)
VALUES(:fornecedor_img, :fornecedor_nome, :fornecedor_email, :fornecedor_endereco, :fornecedor_number, :fornecedor_neighborhood, :fornecedor_cep, :fornecedor_cidade, :fornecedor_estado, :fornecedor_documento, :fornecedor_telefone, :fornecedor_status, :fornecedor_sessao)");
$Create->bindValue(':fornecedor_img', $CreateFileName);
$Create->bindValue(':fornecedor_nome', $Search['company']);
$Create->bindValue(':fornecedor_email', $Search['email']);
$Create->bindValue(':fornecedor_endereco', $Search['address']);
$Create->bindValue(':fornecedor_number', $Search['number']);
$Create->bindValue(':fornecedor_neighborhood', $Search['neighborhood']);
$Create->bindValue(':fornecedor_cep', $Search['zipcode']);
$Create->bindValue(':fornecedor_cidade', $Search['city']);
$Create->bindValue(':fornecedor_estado', $Search['state']);
$Create->bindValue(':fornecedor_documento', $Search['cnpj']);
$Create->bindValue(':fornecedor_telefone', $Search['phone']);
$Create->bindValue(':fornecedor_status', 1);
$Create->bindValue(':fornecedor_sessao', $_SESSION['user_id']);
$Create->execute();

$message = ['status' => 'success', 'message' => 'Fornecedor cadastrado com sucesso!', 'redirect'=> 'providers'];
echo json_encode($message);
return; 
