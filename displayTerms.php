<?php
/*
 * Blank index.php file for a new website/app
 * There are also blank template folders to avoid having to refind all of these basic parts to an app.
 */
require_once 'core/init.php';
$display = new View();

?>
<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="charset=utf-8">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="js/script.js"></script>
	<link rel="stylesheet" href="style/blankStyles.css" type="text/css" />
	<link rel="stylesheet" href="style/style.css" type="text/css" />
</head>

<body>
	<div id="header">
		<h1>myLexicon</h1>
		<h2>View Terms</h2>
		<a href="index.php">Home</a><br>
		<a href="addTerm.php">Add new term</a><br>
		<a href="tempCatAdder.php">Add new category.</a>
	</div>
	<div id="content">
		<?php 
		$display->output(Input::get('category'));
		?>
	</div>
</body>


</html>
