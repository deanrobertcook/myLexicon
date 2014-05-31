<?php
class View {
	private $lexicon;
	
	public function __construct(Lexicon $lexicon) {
		$this->lexicon = $lexicon;
		
		$this->categories = $this->lexicon->getCategoryList();
	}
	
	public function outputHeader($pageName) {
		//TODO, think of a neater way to put out this header and have dynamically generated links??
		?>
		<!DOCTYPE html>
		<head>
			<meta http-equiv="content-type" content="charset=utf-8">
			<script src="/myLexicon/js/jquery-2.1.0.js"></script>
			<script src="/myLexicon/js/script.js"></script>
			<link rel="stylesheet" href="/myLexicon/style/blankStyles.css" type="text/css" />
			<link rel="stylesheet" href="/myLexicon/style/style.css" type="text/css" />
		</head>
		
		<body>
		<div id="header">
			<h1>myLexicon</h1>
			<h2><?php echo $pageName;?></h2>
			<a href="/myLexicon">Home</a><br>
			<a href="/myLexicon/addTerm">Add new term.</a><br>
			<a href="/myLexicon/editTerm">Edit a term.</a><br>
			<a href="/myLexicon/addCategory">Add new category.</a>
		</div>
		<div id="content">
		<?php
	}
	
	public function outputFooter(){
		//TODO make a footer
		?>
		</div>
		<div id="footer">
			<p>Footer</p>
		</div>
		</body>
		</html>
		<?php
	}
	
	private function constructTable($categoryName, $displayFields) {
		$terms = $this->lexicon->getTerms($categoryName, $displayFields);
		?><div class='catTableDiv'>
			<h2><?php echo $this->lexicon->getCategoryDisplay($categoryName);?></h2>
			<table>
				<tr><?php 
				//TODO, allow these titles to be more easily modifiable, say be a settings.xml sheet
				foreach ($displayFields as $displayFieldType => $displayFieldName) {
					?><th class="<?php echo $displayFieldType; ?>"><?php echo $displayFieldName; ?></th><?php
				}
				?>
					<th class="buttonColumn"></th>
				</tr><?php 
				$rowCount = 0;
				foreach ($terms as $term) {
					?><tr id="row<?php echo $rowCount;?>"><?php
					$fields = $term->getFields();
					foreach ($fields as $fieldType => $fieldName) {
						?><td><?php 
						$values = $term->getFieldValue($fieldType);
						if (sizeof($values) == 1) {
							echo $values;
						} else {
							for ($j = 0; $j < sizeof($values); $j++) {
								echo $values[$j]. "<br>";
							}
						}
						?></td><?php 				
					}
					?>
						<td class="buttonColumn">
							<button	onclick="editTerm(<?php echo $rowCount;?>, <?php echo $term->id();?>)">
								<img width="20px" src="/myLexicon/resources/images/edit.png" >
							</button>
							<button	onclick="deleteTerm(<?php echo $rowCount;?>, <?php echo $term->id();?>)">
								<img width="20px" src="/myLexicon/resources/images/delete.png" >
							</button>
						</td>
					</tr><?php
					$rowCount++;
				}				
				?>		
			</table>
		</div>
		<?php 
	}
	
	private function addTableConsole($categoryName) {
		?>
		<div class="tableConsole">
			<button id="newRowButton" onclick="newRow('<?php echo $categoryName?>')">Quick Add</button>	
		</div>
		<?php 
	}
	
	private function constructContentsItem($categoryName, $categoryDisplay) {
		return "<span class='menuItem'><a href='/myLexicon/displayCategory/$categoryName'>" . $categoryDisplay .
			" (" . $this->lexicon->getTermCount($categoryName) . ")</a></span>";
	}
	
	public function outputCategory($categoryName, $displayFields) {
		
		$this->constructTable($categoryName, $displayFields);
		$this->addTableConsole($categoryName);
	}
	
	public function outputContents() {
		$html = "<div id='menu'>";
		$categories = $this->lexicon->getCategoryList();
		foreach ($categories as $categoryName => $categoryDisplay) {
			$html.= $this->constructContentsItem($categoryName, $categoryDisplay);
		}
		$html .= "</div>";
		echo $html;
	}
	
	public function addTermForm($errorMessages = array()) {
		foreach ($errorMessages as $error) {
			?><h3 id="errorMessage"><?php echo $error?></h3> <?php 
		}
		?>
		<form id="addTermForm" action="/myLexicon/addTerm/true" method="post">
		<div class='field'>
			<label for="category">Category</label>
			<select name="category">
				<option value="">--Select Category--</option>
				<?php 
				foreach ($this->lexicon->getCategoryList() as $category) {
					?>
					<option value="<?php echo $category?>"><?php echo tidyWord($category)?></option>
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
		<?php
	}

	public function addCategoryForm($errorMessages = array()) {
		foreach ($errorMessages as $error) {
			?><h3 id="errorMessage"><?php echo $error?></h3> <?php 
		}
		?><form id="addTermForm" action="/myLexicon/addCategory/true" method="post">
		<div class='field'>
			<label for="category">Category</label>
			<input type="text" name="category" value="" autocomplete="off">
		</div>
		<input type="submit" value="Add Category">
		</form>
		<?php
	}	
	
	public function editTermForm($errorMessages = array(), $presetValues = array()) {
		foreach ($errorMessages as $error) {
			?><h3 id="errorMessage"><?php echo $error?></h3> <?php 
		}
		if (empty($presetValues)) {
			?>
			<form id="addTermForm" action="/myLexicon/editTerm/true" method="post">
			<div class='field'>
				<label for="termId">Term ID:</label>
				<input type="text" name="termId" id="termId" value="" autocomplete="off">
			</div>
			<input type="submit" name="find" value="Find Term">
			</form>
			<?php 
		} else {
			foreach ($presetValues as $key => $value) {
				?>
				<form id="addTermForm" action="/myLexicon/editTerm/true" method="post">
				<?php 
				if ($key == "termId" || $key == "category") {
					?>
					<div class='field'>
						<label for="<?php echo $key?>"><?php echo tidyWord($key)?></label>
						<input type="text" readonly="readonly" name="<?php echo $key?>" value="<?php echo tidyWord($value)?>" autocomplete="off">
					</div>
					<?php 
				} else {
				?>
				<div class='field'>
					<label for="<?php echo $key?>"><?php echo tidyWord($key)?></label>
					<input type="text" name="<?php echo $key?>" value="<?php echo $value?>" autocomplete="off">
				</div>
				<?php 
				}	
			}
			?>
			<input type="submit" name="save" value="Save Term">
			<input type="submit" name="delete" value="Delete Term">
			</form>
			<?php 
		}
	}
}