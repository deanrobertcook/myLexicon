<?php

require_once 'core/init.php';
$lexicon = new Lexicon("lexicon.xml");

if (Input::exists()) {
	$lexicon->addCategory(Input::get("category"));
}

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
		<h2>Add Category</h2>
		<a href="index.php">Home</a>
	</div>
	<div id="content">
		<form id="addTermForm" action="" method="post">
		<div class='field'>
			<label for="category">Category</label>
			<input type="text" name="category" value="" autocomplete="off">
		</div>
		<input type="submit" value="Add Category">
		</form>
	</div>
</body>


</html>
