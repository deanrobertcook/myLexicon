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
		<div id="header">
			<h1>myLexicon</h1>
			<h2><?php echo $pageName?></h2>
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
		<?php
	}
	
	private function constructTable($categoryName, $displayFields) {
		$terms = $this->lexicon->getTerms($categoryName, $displayFields);
		
		$html = "<div class='catTableDiv'>";
		$html .= "<h2>" . tidyWord($categoryName) . "</h2>";
		$html .= "<table>";
			$html .= "<tr>";
			//TODO, allow these titles to be more easily modifiable, say be a settings.xml sheet
			foreach ($displayFields as $displayField) {
				$html .= "<th>" . tidyWord($displayField) . "</th>";
			}
			$html .= "</tr>";
			
		foreach ($terms as $term) {
			$html .= "<tr>";
				$fields = $term->getFields();
				for ($i = 0; $i < sizeof($fields); $i++) {
					$html .= "<td>";
					$values = $term->getFieldValue($fields[$i]);
					if (sizeof($values) == 1) {
						$html .= $values;
					} else {
						for ($j = 0; $j < sizeof($values); $j++) {
							$html .= $values[$j]. "<br>";
						}
					}
					$html .= "</td>";
				}
			$html .= "</tr>";
		}
		$html .= "</table>";
		$html .= "</div>";
		return $html;
	}
	
	private function constructContentsItem($categoryName) {
		return "<span class='menuItem'><a href='/myLexicon/displayCategory/$categoryName'>" . tidyWord($categoryName) .
			" (" . $this->lexicon->getTermCount($categoryName) . ")</a></span>";
	}
	
	public function outputCategory($category, $displayFields) {
		
		echo $this->constructTable($category, $displayFields);
	}
	
	public function outputContents() {
		$html = "<div id='menu'>";
		$categories = $this->lexicon->getCategoryList();
		foreach ($categories as $category) {
			$html.= $this->constructContentsItem($category);
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
			<form id="addTermForm" action="/myLexicon/editTerm/find" method="post">
			<div class='field'>
				<label for="termId">termId</label>
				<input type="text" name="termId" id="termId" value="" autocomplete="off">
			</div>
			<input type="submit" value="Find Term">
			<?php 
		} else {
			foreach ($presetValues as $key => $value) {
				?>
				<form id="addTermForm" action="/myLexicon/editTerm/save" method="post">
				<?php 
				if ($key == "termId") {
					?>
					<div class='field'>
						<label for="<?php echo $key?>"><?php echo $key?></label>
						<input type="text" readonly="readonly" name="<?php echo $key?>" value="<?php echo $value?>" autocomplete="off">
					</div>
					<?php 
				} else {
				
				?>
				<div class='field'>
					<label for="<?php echo $key?>"><?php echo $key?></label>
					<input type="text" name="<?php echo $key?>" value="<?php echo $value?>" autocomplete="off">
				</div>
				
				<?php 
				}	
			}
			?>
			<input type="submit" value="Save Term">
			<?php 
		}
		?>
		<!--<div class='field'>
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
		</div>  -->
		
		</form>
		<?php
	}
}