<?php
class View {
	private $categories;
	private $lexicon;
	
	public function __construct() {
		$this->lexicon = new Lexicon("lexicon.xml");
		
		$this->categories = $this->lexicon->getCategoryList();
	}
	
	private function constructTable($categoryName) {
		$terms = $this->lexicon->getWordList($categoryName);
		
		$html = "<div class='tableDiv'>";
		$html .= "<h2>$categoryName</h2>";
		$html .= "<table>";
			$html .= "<tr>";
				$html .= "<th>Englischen Begriff</th>";
				$html .= "<th>Deutschen Begriff</th>";
				$html .= "<th>Examples</th>";
			$html .= "</tr>";
			
		foreach ($terms as $term) {
			$html .= "<tr>";
				for ($i = 0; $i < sizeof($term->fields); $i++) {
					$html .= "<td>";
					if (sizeof($term->values[$i]) == 1) {
						$html .= $term->values[$i];
					} else {
						for ($j = 0; $j < sizeof($term->values[$i]); $j++) {
							$html .= $term->values[$i][$j]. "<br>";
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
		return "<a href='displayTerms.php?category=$categoryName'>$categoryName</a>";
	}
	
	public function output($category) {
		echo $this->constructTable($category);
// 		foreach ($this->categories as $category) {
// 			echo $this->constructTable($category);
// 		}
	}
	
	public function outputContents() {
		$html = "<div id='menu'>";
		foreach ($this->categories as $category) {
			$html.= $this->constructContentsItem($category);
		}
		$html .= "</div>";
		echo $html;
	}
}