<?php
    ob_start();
    session_start();
    require 'includes/config.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title><?= $titleSite ?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="robots" content="index, follow"/>
		<meta name="description" content="<?= $description; ?>"/>
        <meta name="base" content="<?= $configBase ?>">

		<meta itemprop="name" content="<?= $titleSite ?>"/>
        <meta itemprop="description" content="<?= $description; ?>"/>
        <meta itemprop="image" content="<?= $configBase ?>Images/General/default.png"/>

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">

		<link href="<?= $configBase; ?>" rel="base" >
		
        <script src="<?= $configBase; ?>js/jquery.js"></script>
	</head>
<body>

    <div class="result"></div>

	<?php require "{$themePathSite}/index.php"; ?>

    <script src="<?= $configBase; ?>js/maskinput.js"></script>
    <script src="<?= $configBase; ?>js/jquery-money.js"></script>
    <script src="<?= $configBase; ?>js/jquery-form.js"></script>
    <script src="<?= $configBase; ?>js/views.js"></script>
    <script src="<?= $configBase; ?>Ajax/ajax.js"></script>

</body>
</html>

<?php
ob_end_flush();
