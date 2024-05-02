<?php
	$_SESSION['user_id'] = 1;
	$_SESSION['user_level'] = 10;
	$configUrlModal = explode("/", strip_tags(filter_input(INPUT_GET, "route", FILTER_DEFAULT)));
    $configUrlModal[0] = (!empty($configUrlModal[0]) ? $configUrlModal[0] : "services");
	$pages = $configUrlModal[0];
	$_SESSION['user_id'] = '1';
	//Se for a página de Login, entra a página de estilo.css próprio para o sistema de login
	if($pages == 'login' || $pages == 'new-password' || $pages == 'mail-pass'){ 
		echo'<link rel="stylesheet" href="'.$configBase .'css/login.css">
			 <link rel="stylesheet" href="'.$configBase .'css/framework.css">';
	}else{
		echo'<link rel="stylesheet" href="'.$configBase . '/css/estilo.css">
			 <link rel="stylesheet" href="'.$configBase . '/css/framework.css">';
	}
		
	//ROUTERS
	require "router.php";
	
	//Footer
	if($pages == 'login' || $pages == 'new-password' || $pages == 'mail-pass'){}else{
		require "includes/footer.php";
	}
   
?>