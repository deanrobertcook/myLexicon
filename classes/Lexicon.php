<?php
/**
 * The Lexicon class provides a representation of the data provided in the XML sheet. It generates/maintains
 * a list of all of the categories added to myLexicon, and when requested, will also generate all of the
 * terms associated with a given category.
 * 
 * Note, I should be attempting to REMOVE ALL TRACES of XML from this class, and use much more abstracted
 * database terms instead. This way, I can quite easily port the application over to say a mySQL database
 * or something else if I so decide. 
 * @author Dean
 *
 */

class Lexicon {
	private $xml;
	private $categories;
	
	public function __construct() {
		$this->xml = new XML("lexicon");
		
		$this->categories = $this->xml->getListOfNodes("/lexicon/category/name");
		sort($this->categories, SORT_STRING);
		
	}
	
	public function getCategoryList() {
		return $this->categories;
	}
	
	public function getWordList($category) {
		$termIds = $this->xml->getListOfNodes("//category[name='$category']/term/@id");
		$terms = array();
		
		foreach ($termIds as $termId) {
			$newTerm = new Term();
			for ($i = 0; $i < sizeof($newTerm->fields); $i++) {
				$nextValue = $this->xml->getChildValuesByParentID($termId, $newTerm->fields[$i]);
				if (sizeof($nextValue) == 1) {
					$newTerm->values[$i] = $nextValue[0];
				} else {
					$newTerm->values[$i] = $nextValue;
				}
			}
			array_push($terms, $newTerm);
		}
		return $terms;
	}
	
	public function addWord($category, $term) {
		$newTerm = $this->xmlDoc->createElement("term");
		
		$this->xpath->evaluate("/lexicon/category[name='$category']")
			->item(0)->appendChild($newTerm);
		
		$englishTerm = $this->xmlDoc->createElement("english", $term->englishTerm);
		$newTerm->appendChild($englishTerm);
		
		$germanTerm = $this->xmlDoc->createElement("german", $term->germanTerm);
		$newTerm->appendChild($germanTerm);
		
		foreach ($term->examples as $example) {
			$englishTerm = $this->xmlDoc->createElement("example", $example);
			$newTerm->appendChild($englishTerm);
		}
		
		$this->xmlDoc->save($this->xmlPath);
	}
	
	public function addCategory($categoryName) {
		$newCategory = $this->xmlDoc->createElement("category");
		$this->xmlDoc->documentElement->appendChild($newCategory);
		
		$name = $this->xmlDoc->createElement("name", $categoryName);
		$newCategory->appendChild($name);
		
		$this->xmlDoc->save($this->xmlPath);
	}
	
	public function __destruct() {
		unset($this->xmlDoc);
	}
}