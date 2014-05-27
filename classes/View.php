<?php
class View {
	private $lexicon;
	
	public function __construct(Lexicon $lexicon) {
		$this->lexicon = $lexicon;
		
		$this->categories = $this->lexicon->getCategoryList();
	}
	
	public function outputHeader($pageName) {
		?>
		<div id="header">
			<h1>myLexicon</h1>
			<h2><?php echo $pageName?></h2>
			<a href="/myLexicon">Home</a><br>
			<a href="/myLexicon/addTerm">Add new term.</a><br>
			<a href="/myLexicon/addCategory">Add new category.</a>
		</div>
		<div id="content">
		<?php
	}
	
	public function outputFooter(){
		?>
		</div>
		<div id="footer">
			<p>Footer</p>
		</div>
		<?php
	}
	
	private function constructTable($categoryName) {
		//TODO Allow the user to modify the display fields by submitting a form or something
		$displayFields = array(
			"english",
			"german",
			"example",
		);
		
		$terms = $this->lexicon->getTerms($categoryName, $displayFields);
		
		$html = "<div class='catTableDiv'>";
		$html .= "<h2>" . tidyWord($categoryName) . "</h2>";
		$html .= "<table>";
			$html .= "<tr>";
			//TODO, allow these titles to be more easily modifiable, say be a settings.xml sheet
				$html .= "<th>Englischen Begriff</th>";
				$html .= "<th>Deutschen Begriff</th>";
				$html .= "<th>Examples</th>";
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
	
	public function outputCategory($category) {
		echo $this->constructTable($category);
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
	
	public function addTermForm($errorMessage) {
		?>
		<h3 id="errorMessage"><?php echo $errorMessage?></h3>
		<form id="addTermForm" action="/myLexicon/addTerm/termAdded" method="post">
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

	public function addCategoryForm($errorMessage) {
		?>
		<h3 id="errorMessage"><?php echo $errorMessage?></h3>
		<form id="addTermForm" action="/myLexicon/addCategory/categoryAdded" method="post">
		<div class='field'>
			<label for="category">Category</label>
			<input type="text" name="category" value="" autocomplete="off">
		</div>
		<input type="submit" value="Add Category">
		</form>
		<?php
	}	
}