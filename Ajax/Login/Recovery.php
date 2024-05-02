<?php
    session_start();
    include_once '../../includes/config.php';
    $Post = filter_input_array(INPUT_POST,  FILTER_SANITIZE_STRIPPED);
    $PostFilters = array_map('strip_tags', $Post);
    
    $message = null;

    //Verifica se o email é valido
    $Email = $PostFilters['login_email'];
    if(!$Email || empty($Email) || $Email == null){

        $message = ['status' => 'info', 'message'=>'Email ou token incorretos ou não registrado!', 'redirect'=>''];
        echo json_encode($message);
        return;
    }

    //Recupera o token digitado no formulário
    $Token = $PostFilters['login_token']; 
    
    //Consulta para verificar se o email já existe
    $Read = $pdo->prepare("SELECT user_email, user_token FROM users WHERE user_email = :user_email AND user_token = :user_token");
    $Read->bindValue(':user_email', $Email);
    $Read->bindValue(':user_token', $Token);
    $Read->execute();

    $Lines = $Read->rowCount();

    //Notifica o usuario sobre o email ou token incorreto
    if($Lines == 0 ){
        $message = ['status' => 'info', 'message'=>'Email ou token incorreto ou não cadastrado!', 'redirect'=>''];
        echo json_encode($message);
        return;
    }

    //Verifica se o token inserido é o mesmo da base de dados.
    if(strlen($Token) >= 10){
        $valid = 'Confirmed'; 
    }else{
        $message = ['status' => 'info', 'message'=>'Seu token é invalido!', 'redirect'=>''];
        echo json_encode($message);
        return;
    }

    //Em caso afirmativo em relação as outras condições, vamos redirecionar para a pagina de nova senha
    if($valid == 'Confirmed' && $Lines == 1){
        $message = ['status' => 'success', 'message'=>'Email e token verificados!', 'redirect'=>'new-password.php?email='.$Email.''];
        echo json_encode($message);
        return;
    }else{
        $message = ['status' => 'error', 'message'=>'Seu token ou email bé invalido!', 'redirect'=>''];
        echo json_encode($message);
        return;
    }


    //PHPMailer
    $Subject = '[SmallControl] Recuperação de Senha';
    $Body = "<h1>Recuperação de senha </h1>
    <p>Para redefinir sua senha clique no link abaixo</p>
    <p><a href='http://localhost/smallcontrol/login//new-password.php?email=".$Email."&token=".$Token." target='_blank'>Clique aqui para mudar sua senha</a></p>
    <p>Caso não tenha solicitado, desconsidere este email.</p>
    <p>Atenciosamente,</p>
    <p><b>Equipe Smallcontrol</b></p>" ;

    require "../../Developers/PHPMailer/class.phpmailer.php";
    require "../../Developers/PHPMailer/class.smtp.php";

    $mail = new PHPMailer();
    $mail -> Host = MAIL_HOST ;
    $mail -> SMTPAuth = true ;    
    $mail -> SMTPSecure = MAIL_SECURE ;
    $mail -> Username = MAIL_USER ;
    $mail -> Password = MAIL_PASS ; 
    $mail -> Port = MAIL_PORT;
    $mail -> IsHTML (true);
    $mail -> CharSet ="utf-8";

    $mail ->AddReplyTo(MAIL_RESPONSE);

    $mail ->From = MAIL_RESPONSE ;
    $mail ->Sender = MAIL_RESPONSE ;
    $mail ->FromName = "Suporte SmallControl";

    $mail ->AddAddress($Email);
    $mail ->AddBCC(MAIL_RESPONSE);

    $mail ->Subject = $Subject;

    $mail ->Body = $Body;
    $sender = $mail->Send();

    if($sender){
        $message = ['status' => 'success', 'message'=>'Foi encaminhado um email com o link!', 'redirect'=>''];
        echo json_encode($message);
        return;
    }else{
        $message = ['status' => 'error', 'message'=>'Ocorreu um erro, entre em contato com o admin!', 'redirect'=>''];
        echo json_encode($message);
        return;
    }
?>
