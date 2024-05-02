<?php 
	include_once '../includes/sessoes.php';
	$pages = 'relatorio-produtos-clientes.php';
?>
<!doctype html>
<html lang="pt-br">
	<head> 
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title><?= TITLE ?></title>
		
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">
			
		<style>*{font-family: Monteserrat;}</style>
		
		<link rel="stylesheet" href="css/framework.css">
		<link rel="stylesheet" href="css/estilo.css">
		
	</head>
	
	<body>
	<main>
		<section class="content_left">
			<!-- Chama o menu da página-->
			<?php require '../includes/left.php';?>
		</section>
		
		<section class="content_right">
			<!-- Chama o cabeçalho da página-->
			<?php require '../includes/header.php';?>
			
			<article class="bgcolor-white">
				<h1 class="font-text-light-extra text-center font-weight-heavy bgcolor-dark color-white">RELATÓRIO DE CLIENTE CADASTRADO NO SISTEMA <?= strtoupper(TITLE)?></h1>
				
				<div class="espaco-min"></div>
				<h3 class="font-text-light-extra text-center font-weight-medium color-red-light space-letter">Digite o nome do cliente desejado</h3>
				
				<form method="post" >
					<input type="text" name="pesquisa"  id="pesquisar" autocomplete="on" placeholder="Digite o nome do cliente que desejar ter o relatório..."><br>
					<button value="buscar" name="buscar" class="bgcolor-green-dark color-white">Buscar Cliente!</button>
				
				
				   <script type="text/javascript">
					$(document).ready(function() {
						 
						// Captura o retorno do arquivo.php
						$.getJSON('retornaClientes.php', function(data){
							var cliente = [];
							 
							// Armazena na array capturando somente o nome do usuário
							$(data).each(function(key, value) {
								cliente.push(value.cliente_nome);
							});
							 
							// Chamo o Auto complete do JQuery ui setando o id do input, array com os dados e o mínimo de caracteres para disparar o AutoComplete
							$('#pesquisar').autocomplete({ source: cliente, minLength: 1});
						});
					});
				</script>
				</form>
				
				<?php
					if(isset($_POST['buscar'])):
						$cliente = filter_input(INPUT_POST, 'pesquisa');
						
						$consulta = $pdo->prepare("SELECT * FROM ".DB_CLIENTES." WHERE cliente_nome = :user");
						$consulta -> bindValue(':user', $cliente);
						$consulta -> execute();
						
						foreach($consulta as $mostra):
				?>
				<div class="espaco-min"></div>
				
				<div class="divisor bgcolor-white-dark color-dark info_dados">
					<h3 class="bgcolor-dark-full font-text-light-extra text-center font-weight-medium color-white space-letter text-left">Informações do Cliente: </h3>
					<p class="font-text-light-extra text-center font-weight-medium color-blue-dark space-letter text-left">Cliente: <b><?= $mostra['cliente_nome']?></b></p>
					<p class="font-text-light-extra text-center font-weight-medium color-blue-dark  space-letter text-left">E-mail: <b><?= $mostra['cliente_email']?></b></p>
					<?php if($mostra['cliente_status'] == 1): ?>
					<p class="font-text-light-extra text-center font-weight-medium color-blue-dark  space-letter text-left">Status: <b>Ativo</b></p>
					<?php else: ?>
					<p class="font-text-light-extra text-center font-weight-medium color-blue-dark  space-letter text-left">Status: <b>Inativo</b></p>
					<?php endif; ?>
					<p class="font-text-light-extra text-center font-weight-medium color-blue-dark  space-letter text-left">Data de Cadastro: <b><?= date('d/m/Y', strtotime($mostra['cliente_cadastro']))?></b></p>
					<p class="font-text-light-extra text-center font-weight-medium space-letter text-left"><a href="imprimir-relatorio-produtos-clientes?ref=<?= $mostra['cliente_id']?>" class="color-white link-bgcolor-blue-b" target="_blank">Imprimir Relatório!</a> </p>
					
					<?php 
					endforeach;
					endif;
					?>
					<div class="espaco-min"></div>
				</div>
				<div class="espaco-min"></div>
			</article>
	<div class="clear"></div>
	</main>
	
	<!-- Chama o rodapé da página-->
	<?php require '../includes/footer.php';?>
	</body>
</html>