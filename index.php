<?php
/*
 * Blank index.php file for a new website/app
 * There are also blank template folders to avoid having to refind all of these basic parts to an app.
 */
require_once 'core/init.php';
$router = new Router();
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="charset=utf-8">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="/myLexicon/js/script.js"></script>
	<link rel="stylesheet" href="/myLexicon/style/blankStyles.css" type="text/css" />
	<link rel="stylesheet" href="/myLexicon/style/style.css" type="text/css" />
</head>

<body>
	<?php 
		$router->runController();
	?>
</body>


</html>
