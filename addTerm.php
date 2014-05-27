<?php

require_once 'core/init.php';
$lexicon = new Lexicon("lexicon.xml");

if (Input::exists()) {
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
			'english' => array('required' => true),
			'german' => array('required' => true),
	));
	
	if ($validation->passed()) {	
		$term = new Term($lexicon->nextTermId());
		$term->addField("english", Input::get("english"));
		$term->addField("german", Input::get("german"));
		$term->addField("example", Input::get("example"));
		
		$lexicon->addTerm(Input::get("category"), $term);
		//Redirect::to("index.php");
		
	} else {
		foreach ($validation->errors() as $error) {
			echo $error, "<br>";
		}
	}
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
		<h2>Add Word</h2>
		<a href="index.php">Home</a>
	</div>
	<div id="content">
		<form id="addTermForm" action="" method="post">
		<div class='field'>
			<label for="category">Category</label>
			<select name="category">
				<option value="">--Select Category--</option>
				<?php 
				foreach ($lexicon->getCategoryList() as $category) {
					?>
					<option value="<?php echo $category?>"><?php echo $category?></option>
					<?php 
				}
				?>
			</select>
		</div>
		<div class='field'>
			<label for="english">English Term</label>
			<input type="text" name="english" id="english" value="" autocomplete="off">
		</div>
		<div class='field'>
			<label for="german">German Term</label>
			<input type="text" name="german" value="" autocomplete="off">
		</div>
		<div class='field'>
			<label for="example">Examples</label>
			<input type="text" name="example" value="" autocomplete="off">
		</div>
		<input type="submit" value="Add Term">
		</form>
	</div>
</body>


</html>
