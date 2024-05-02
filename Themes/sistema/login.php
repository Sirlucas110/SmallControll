<?php
ob_start();
include_once 'includes/config.php';
require __DIR__ . '/../../vendor/autoload.php';

//Verifica se o cookie de bloqueio existe.
if(!empty($_COOKIE['Lblocked'])){
    $_SESSION['blocked'] = 1;
    $_SESSION['counter'] = TIMESBLOCKED;
}
//unset($_SESSION['logout']);
$_SESSION['logout'] = '';
$_SESSION['blocked'] = '';
if(!empty($_COOKIE['LE']) && !empty($_COOKIE['LP']) && $_SESSION['logout'] == 0 && $_SESSION['blocked'] == 0) {
   //header('location: Ajax/Login/Active.php');
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Login Smallcontrol</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
    <meta name="robots" content="noindex, nofollow"/>
    <link href="../css/login.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

<div class="result"></div>

    <main <?= (isset($_COOKIE['LE']) && ($_COOKIE['LE'] == '' || $_COOKIE['LE'] == null) ? '' : 'id="body_register"') ?>>
    <?php
		$action = strip_tags(filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRIPPED));

		if($action == 'logout'){
			session_destroy();
			unset($_SESSION['user_name']);
			unset($_SESSION['user_level']);
			unset($_SESSION['user_email']);
			unset($_SESSION['user_id']);
			unset($_SESSION['user_token']);
			unset($_SESSION['logged']);
			header('location: ../login.php');
		}
	?>
        <div class="login-box">
            <img src="<?= $configBase ?><?= $themePathSite ?>/images/logo.png" alt="Logo da Empresa" title="Logo da Empresa">
            <form method="post" id="form_login">
                <div class="user-box">                    
                    <input type="email" name="login_email" id="login_email" required value="<?= (isset($_COOKIE['LE']) ? $_COOKIE['LE'] : ''); ?>">
                    <label for="login_email">E-mail: </label>
                </div>
                <div class="user-box">
                    <input type="password" name="login_password" id="login_password" required value="<?= (isset($_COOKIE['LP']) ? $_COOKIE['LP'] : ''); ?>">
                    <label for="login_password">Senha de Acesso:</label>
                </div>
                <div class="g-recaptcha" data-sitekey="6LcXOcopAAAAAOWXtoB0HQv5E4fbsH5M9U0ayFv0"></div>
                <a name="btn_login" id="btn_login" onclick="return valida()"><span></span><span></span><span></span><span></span>Entrar</a>
				
				<p class="demo">Exemplo: Email: admin@admin.com - Password: admin</p>
            </form>

            <script type="text/javascript">
                function valida(){
                    if(grecaptcha.getResponse() == ""){
                        alert("Por favor, preencha o Recaptcha!")
                        return false;
                    }else{
                        return true;
                    }
                }
            </script>
        
    </div>
    </main>
    <script src="../../Views/jquery.js"></script>
    <script src="../../Views/Views.js"></script>
    <script src="../../Ajax/Ajax.js"></script>
	</body>
</html>
<?php
    ob_end_flush();
?>