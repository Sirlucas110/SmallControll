<?php
    ob_start();
    require '../Developers/Config.php';
    $_SESSION['blocked'] = 0;
    //Verifica a existencia de login via sessões
    if(!$_SESSION['user_name'] || !$_SESSION['user_level'] || !$_SESSION['user_email'] || !$_SESSION['user_token'] || !$_SESSION['user_id'] ||!$_SESSION['logged'] && !$_SESSION['user_level'] <= 8 ||  $_SESSION['blocked'] == 1) {
        session_destroy();
        unset($_SESSION['user_name']);
        unset($_SESSION['user_level']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_token']);
        unset($_SESSION['logged']);
        header('location: .. /login.php');
    }
    //var_dump($_SESSION['user_name'], $_SESSION['user_level'], $_SESSION['user_email'], $_SESSION['user_token'], $_SESSION['user_id'], $_SESSION['logged'], $_SESSION['blocked']);
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Login Auth 2.0</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
    <meta name="robots" content="noindex, nofollow"/>

    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	
	<link rel="stylesheet" href="../Views/Views.css">
</head>

<body>
    <div class="result"></div>
		<main>
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
			<article class="container_login bgcolor-white-dark">
				<p class="admin_paragraph"><span class="fa fa-times-circle"></span> <a href="?action=logout" class="admin_link" id="logout">Logout</a></p>
				
				<div class="espaco-min"></div>
				
				<h1 class="font-text-medium-extra text-center"><span class="fa fa-mug-hot"></span> Painel Administrativo</h1>
			</article>
		</main>
		
        <script src="../Views/jquery.js"></script>
        <script src="../Views/Views.js"></script>
        <script src="../Ajax/Ajax.js"></script>
    </body>
</html>

