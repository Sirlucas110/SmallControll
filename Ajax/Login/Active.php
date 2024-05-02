<?php
    require '../../Developers/Config.php';

    $message = null;

    //Verifica se o email é valido
    $Email = $_COOKIE['LE'];

    if(!$Email || empty($Email) || $Email == null || filter_var($Email, FILTER_VALIDATE_EMAIL)){
        $message = ['status' => 'error', 'message'=>'Seu email é invalido!', 'redirect'=>''];
        echo json_encode($message);
        return;
    }

    //Consulta para verificar se o email já existe
    $Read = $pdo->prepare("SELECT user_id, user_level, user_email, user_password, user_firstname, user_lastname, user_token FROM users WHERE user_email = :user_email");
    $Read->bindValue(':user_email', $Email);
    $Read->execute();

    $Lines = $Read->rowCount();

    if($Lines == 0 ){
        $message = ['status' => 'info', 'message'=>'Seu email é invalido!', 'redirect'=>''];
        echo json_encode($message);
        return;       
    }

    //Recuperando os dados
    foreach($Read as $Show){}

    //Verificar e checar a senha
    $VerifyPass = password_verify($_COOKIE['LP'], $Show['user_password']);

    //Verifica se o model de lembrar senha está ativo
    if($VerifyPass){
        
        // Cria as sessões de acesso
        $_SESSION['user_id'] = $Show['user_id'];
        $_SESSION['user_name'] = $Show['user_firstname']. ' ' . $Show['user_lastname'];
        $_SESSION['user_email'] = $Show['user_email'];
        $_SESSION['user_level'] = $Show['user_level'];
        $_SESSION['user_token'] = $Show['user_token'];
        $_SESSION['logged'] = 1;
        
        unset($_SESSION['counter']);
        header('location: ../../Admin/home.php');

    }else{
        $message = ['status' => 'error', 'message'=>'Ocorreu um erro! Email ou senha incorretos!', 'redirect'=>'Admin/home.php'];
        echo json_encode($message);
        return;
    }
?>
