<?php
class View {
	private $lexicon;
	
	public function __construct() {
		$this->lexicon = new Lexicon("lexicon.xml");
		
		$this->categories = $this->lexicon->getCategoryList();
	}
	
	private function constructTable($categoryName) {
		//TODO Allow the user to modify the display fields by submitting a form or something
		$displayFields = array(
			"english",
			"german",
			"example",
		);
		
		$terms = $this->lexicon->getTerms($categoryName, $displayFields);
		
		$html = "<div class='tableDiv'>";
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
		return "<a href='displayTerms.php?category=$categoryName'>" . tidyWord($categoryName) . "</a>";
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
}