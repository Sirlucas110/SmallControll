<?php
    session_start();
    include_once '../../includes/config.php';
    $Post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
    $PostFilters = array_map('strip_tags', $Post);
    $pages = 'new-password';
    $message = null;
    
    //Verifica se o email é valido
    $Email = $PostFilters['login_email'];
    $Password = $PostFilters['login_password'];
    $Retype = $PostFilters['login_retype'];

    if(!$Email || empty($Email) || $Email == null){

        $message = ['status' => 'info', 'message'=>'Email invalido !', 'redirect'=>''];
        echo json_encode($message);
        return;
    }

    //Consulta para verificar se o email já existe
    $Read = $pdo->prepare("SELECT user_id, user_email, user_password, user_firstname, user_lastname, user_token FROM users WHERE user_email = :user_email");
    $Read->bindValue(':user_email', $Email);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0 ){
        $message = ['status' => 'info', 'message'=>'Email inexistente ou invalido!', 'redirect'=>''];
        echo json_encode($message);
        return;
    }

    //Verifica se os campos de senha batem
    if($Password != $Retype){
        $message = ['status' => 'info', 'message'=>'Senha e confirmação não são as mesmas!', 'redirect'=>''];
        echo json_encode($message);
        return;
    }

    //Criptografar a senha
    $NewPassword = password_hash($Password, PASSWORD_DEFAULT);

    //Atualiza no banco de dados
    $Update = $pdo->prepare("UPDATE users SET user_password = :user_password WHERE user_email = :user_email");
    $Update -> bindValue(':user_password', $NewPassword);
    $Update -> bindValue(':user_email', $Email); 
    $Update -> execute();
    if($Update){        
        $message = ['status' => 'success', 'message'=>'Senha alterada com sucesso!', 'redirect'=>'login.php'];
        echo json_encode($message);
        return;
    }else{
        $message = ['status' => 'error', 'message'=>'Ocorreu um problema, tente novamente', 'redirect'=>''];
        echo json_encode($message);
        return;        
    }
?>
