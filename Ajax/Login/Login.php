<?php
    session_start();
    include_once '../../includes/config.php';
    require_once '../../vendor/autoload.php';
    
    use GuzzleHttp\Client;
    
    $Post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
    $PostFilters = array_map('strip_tags', $Post);
    
    $message = null;
    
    $counter = (isset($_SESSION['counter']) ? $_SESSION['counter'] : 0);
    //$counter = 0;
    //unset($_SESSION['blocked']);    
    //var_dump($PostFilters);
    //Responsavel por calulcar o numero de tentativas de login
    if($counter == TIMESBLOCKED && $_SESSION['blocked'] == 0) {
        $_SESSION['counter'] = TIMESBLOCKED + 1;
        $message = ['status' => 'warning', 'message'=>'Você só possui mais uma tentativa', 'redirect'=>''];
        echo json_encode($message);
        return;
    }else{
        $_SESSION['counter'] = $counter + 1;
    }

    //Bloqueio de acesso
    
    //Verifica se o email é valido
    $Email = $PostFilters['login_email'];
    if(!$Email || empty($Email) || $Email == null || !filter_var($Email, FILTER_VALIDATE_EMAIL)){

        $message = ['status' => 'info', 'message'=>'Email invalido !', 'redirect'=>''];
        echo json_encode($message);
        return;
    }

    //Verifica o RECAPTCHA
    if (isset($_POST['g-recaptcha-response']) and isset($_POST['username']) and isset($_POST['password'])) {//garante que todos os campos foram preenchidos
        $captcha_data = $_POST['g-recaptcha-response'];
        if ($captcha_data) {//Verificação do reCaptcha
            $resposta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=DIGITE-SUA-CHAVE-SECRETA-GERADA-PELO-GOOGLE-AQUI=" . $captcha_data . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
            if ($resposta) {//validação do reCaptcha
                $username = strtolower($helper->validation($_POST['username']));
                $password = $helper->validation($_POST['password']);
                $user = new User();//--->meu objeto que acessa o banco de dados usando PDO
                $userValidated = $user->checkPasswordHash($username);//--->método do meu objeto que procura o usuario no bacno de dados (SELECT * FROM tbl_Users WHERE username = $username)
                if ($userValidated){//verifica se o email existe, se existir...
                    if ($userValidated->status == 1){//verifica se a conta está bloqueada ou não
                        echo 'Essa conta está bloqueada, criar botão para reenviar o email de recuperação...';
                    }else{
                    $hash = $userValidated->password;//retorna o hash do password
                    if (password_verify($password, $hash)) {//compara a senha e o hash que foi criado usando password_hash() e salvo no banco de dados
                        echo 'Password é válido, inserir código que inicia as sessões e chama a próxima página';//-->insira seu código
                    } else {//caso o password estjeja errado, perde uma tentativa
                        if ($attempt != 1){//se a tentativa restante for igual a 1, a proxima vez será direcionado para a página de recuperação de senha
                            $attempt--;
                            echo 'Usuário e senha não combinam, você tem mais '.$attempt.' tentativas';//mostra o número de tentativas restante
                        }else{//bloqueia a conta e chama a página de recuperação de senha
                            echo 'inserir código que bloqueia a conta e abre pagina de recuperaçao de senha';//-->insira seu código de bloqueio
                        }
                    }
                    }
                }else{//se o email não existir, perde uma tentativa mas não avisa se o erro foi no email ou na senha
                    if ($attempt != 0){
                        $attempt--;
                        echo 'Usuário e senha não combinam, você tem mais '.$attempt.' tentativas';//mostra o número de tentativas restante
                    }else{//bloqueia a conta e chama a página de recuperação de senha
                        echo 'inserir código que bloqueia a conta e abre pagina de recuperaçao de senha';//-->insira seu código de bloqueio
                    }
                }
            } else {
                echo "Validação não concluída, tente novamente.";
                exit;
            }
        } else {
            echo "Validação não concluída, tente novamente.";
            exit;
        }
    }
     
        //Consulta para verificar se o email já existe
        $Read = $pdo->prepare("SELECT user_id, user_email, user_password, user_firstname, user_level, user_token FROM ".DB_LOGIN."  WHERE user_email = :user_email");
        $Read->bindValue(':user_email', $Email);
        $Read->execute();

        $Lines = $Read->rowCount();
        
        if($Lines == 0 ){
            $_SESSION['counter'] = $counter + 1;
            
            if($counter == TIMESBLOCKED){
                $message = ['status' => 'warning', 'message'=>'Você só possui mais uma tentativa', 'redirect'=>''];
                echo json_encode($message);
                return;
            }else{
                $message = ['status' => 'info', 'message'=>'Email ou senha incorretos', 'redirect'=>''];
                echo json_encode($message);
                return;
            }
        }
        //Recuperando os dados
        foreach($Read as $Show){}
        
        //Verificar e checar a senha
        $VerifyPass = password_verify($PostFilters['login_password'], $Show['user_password']);

        if($VerifyPass){        
            // Cria as sessões de acesso
            $_SESSION['user_id'] = $Show['user_id'];
            $_SESSION['user_firstname'] = $Show['user_firstname'];
            $_SESSION['user_email'] = $Show['user_email'];
            $_SESSION['user_level'] = $Show['user_level'];
            $_SESSION['user_token'] = $Show['user_token'];
            $_SESSION['logged'] = 1;
            //var_dump($_SESSION);
            unset($_SESSION['counter']);
            
            $message = ['status' => 'success', 'message'=>'Login realizado com sucesso!', 'redirect'=>'../dashboard'];
            echo json_encode($message);
            return;
        } else{
            $message = ['status' => 'info', 'message'=>'Email ou senha incorretos!', 'redirect'=>''];
            echo json_encode($message);
            return;
        }
    
?>