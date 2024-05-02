<?php 
	include_once '../includes/sessoes.php';
	$pages = 'relatorio-produtos-fornecedor.php';
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
				<h1 class="font-text-light-extra text-center font-weight-heavy bgcolor-dark color-white">RELATÓRIO DE FORNECEDOR CADASTRADO NO SISTEMA <?= strtoupper(TITLE)?></h1>
				
				<div class="espaco-min"></div>
			<h3 class="font-text-light-extra text-center font-weight-medium color-red-light space-letter">Digite o nome do fornecedor que deseja editar</h3>
				
				<form method="post" >
					<input type="text" name="pesquisa"  id="pesquisar" autocomplete="on" placeholder="Digite o nome do fornecedor para a edição..."><br>
					<button value="buscar" name="buscar" class="bgcolor-green-dark color-white">Buscar Fornecedor!</button>
				
				
				  <script type="text/javascript">
					$(document).ready(function() {
						 
						// Captura o retorno do arquivo.php
						$.getJSON('retornaFornecedores.php', function(data){
							var cliente = [];
							 
							// Armazena na array capturando somente o nome do usuário
							$(data).each(function(key, value) {
								cliente.push(value.fornecedor_nome);
							});
							 
							// Chamo o Auto complete do JQuery ui setando o id do input, array com os dados e o mínimo de caracteres para disparar o AutoComplete
							$('#pesquisar').autocomplete({ source: cliente, minLength: 1});
						});
					});
				</script>
				</form>
				
				<?php
					if(isset($_POST['buscar'])):
						$fornecedor = filter_input(INPUT_POST, 'pesquisa');
						
						$consulta = $pdo->prepare("SELECT * FROM ".DB_FORNECEDORES." WHERE fornecedor_nome = :user");
						$consulta -> bindValue(':user', $fornecedor);
						$consulta -> execute();
						
						foreach($consulta as $mostra):
				?>
				<div class="espaco-min"></div>
				
				<div class="divisor bgcolor-white-dark color-dark info_dados">
					<h3 class="bgcolor-dark-full font-text-light-extra text-center font-weight-medium color-white space-letter text-left">Informações do Fornecedor: </h3>
					<p class="font-text-light-extra text-center font-weight-medium color-blue-dark space-letter text-left">Fornecedor: <b><?= $mostra['fornecedor_nome']?></b></p>
					<p class="font-text-light-extra text-center font-weight-medium color-blue-dark  space-letter text-left">E-mail: <b><?= $mostra['fornecedor_email']?></b></p>
					<p class="font-text-light-extra text-center font-weight-medium color-blue-dark  space-letter text-left">Data de Cadastro: <b><?= date('d/m/Y', strtotime($mostra['fornecedor_cadastro']))?></b></p>
					<p class="font-text-light-extra text-center font-weight-medium space-letter text-left"><a href="imprimir-relatorio-produto-fornecedor?ref=<?= $mostra['fornecedor_id']?>" class="color-white link-bgcolor-blue-b" target="_blank">Imprimir Relatório!</a> </p>
					
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