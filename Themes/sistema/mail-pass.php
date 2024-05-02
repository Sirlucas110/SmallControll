<?php
	include_once 'includes/config.php';
	
	$pages = "mail-pass";
?>

<section class="login">
	<article  class="bgcolor-white login_div">

		<form method="post">
			<h1 class="font-text-hard-two text-center color-dark">Esqueceu a Senha:</h1><br>
			<label for="email" class="font-text-light-extra text-left color-dark ">Digite o Seu E-mail:</label><br>
			<input type="email" name="email" placeholder="Digite o seu e-mail cadastrado no sistema..." required  class="font-text-light-extra text-left color-dark bgcolor-white-dark "><br><br>
			<button name="btn-mail" id="btn-mail" class="btn_edit radius">Enviar E-mail!</button>
			<p class="text-center font-text-sub text-margin"><br><a href="login" class="color-dark font-weight-max">Voltar ao Login</a></p>
		</form>

	</article>
<section>
