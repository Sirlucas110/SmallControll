<?php

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Recovery Password</title>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
        <meta name="robots" content="noindex, nofollow"/>

        <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,600,700,800' rel='stylesheet' type='text/css'>
		
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" href="Views/Views.css">
			
	</head>
	
	<body>
        <div class="result"></div>
		<main>
			<article class="container_login bgcolor-white">
				<h1 class="font-text-medium-extra"><span class="fa fa-mug-hot"></span> Recuperar a Senha</h1>
				<form method="post" id="form_password">
					<label for="login_email">E-mail: <label>
					<input type="email" name="login_email" id="login_email" required class="radius">
					
					<label for="login_token">Seu Token: <label>
					<input type="text" name="login_token" id="login_token" required class="radius">
					
					<button name="btn_password" class="btn_new color-white radius" id="btn_password"><span class="fa fa-paper-plane"></span> Recuperar!</button>
					<a id="voltar-login" href="login.php" class="color-dark font-text-sub"><u>Voltar Login!</u></a>
				</form>
			</article>
		</main>
		
		<script src="../../Views/jquery.js"></script>
		<script src="../../Views/Views.js"></script>
		<script src="../../Ajax/Ajax.js"></script>
	</body>
</html>