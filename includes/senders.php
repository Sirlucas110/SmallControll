<?php
	//Requisição de página externa com as classes do PHPMAILER
	require 'PHPMailer/class.phpmailer.php';
	
	//Requisição de página externa com as classes para o envio via SMTP.
	require 'PHPMailer/class.smtp.php';
	
	$email = EMAILSITE;
	//Instanciamos o objeto PHPMAILER.
	$mail = new PHPMailer();
	$mail -> CharSet ="utf-8"; //trata os tipos de caracteres do e-mail
	$mail -> IsSMTP (); //Verifica se o envio é via SMTP
	$mail -> Host  =  "smtp.gmail.com" ; //Host do servidor de e-mail
	$mail -> SMTPAuth  =  true ; //Haverá autenticação com login e senha?
	$mail -> SMTPSecure  =  'ssl' ; //Qual é o tipo de criptografia SSL ou TLS
	$mail -> Username  =  "seuemail@servidor.com" ; //E-mail usado no login de autenticação.
	$mail -> Password  =  "suasenha" ; //Sua senha usada no login de autenticação.
	$mail -> Port  =  000 ; //Porta de serviço do servidor.
	$mail -> IsHTML (true); //Corpo do texto será HTML?
	$mail ->AddReplyTo("seuemail@servidor.com", $_SESSION['usuario']); //Endereço de e-mail para o envio de respostas.

	$mail->From = $email; //Da onde está partindo o e-mail
	$mail->Sender = $email; //E-mail do remetente
	$mail->FromName = $email; //Nome do remetente
	 
	$mail->AddAddress($email); //E-mail do destinatário
	$mail->AddBCC('seu@email.com.br','Sistema de Controle de Estoque'); //Envio de cópia oculta.

	$mail->Subject  = TITLE." - Pedido de Compra de Materiais"; //Assunto
	/*Construção do layout em HTML do e-mail, passando as informações do extrato do pedido para o cliente. */
	$mail->Subject  = 'Pedido de Compra de Materiais'; 
	$mail->Body = '<span style="color: #000; font-size: 14px; font-family: Verdana">Olá '.TITLE.'<br><br>';
	$mail->Body .=''.$observacoes.'<br>Enviado: '.date("d/m/Y H:i:s").'</span>';
	//A variável enviado manda o e-mail.
	$enviado = $mail->Send();
	
	//Se o e-mail foi enviado, executa a instrução ECHO
	if($enviado):
		echo '<p class="alert-ok color-white">O Pedido de Compra de Materiais foi enviado por e-mail com sucesso!</p>';
	else:
		echo '<p class="alert-error color-white">Ocorreu um erro: Não foi possível enviar o Pedido de Compra de Materiais por e-mail!</p>';
	endif;
?>