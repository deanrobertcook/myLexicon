<?php
/**
 * The Lexicon class provides a representation of the data provided in the XML sheet. It generates/maintains
 * a list of all of the categories added to myLexicon, and when requested, will also generate all of the
 * terms associated with a given category.
 * 
 * I finally decided to put all of the XML stuff in the lexicon class, since I was effectively just making
 * a copy of the XML class with the lexicon class; it didn't provide me with a clear separation of concerns.
 * That said, this class is pretty big, so maybe I'll consdier chopping it up at some point
 * @author Dean
 *
 */

class Lexicon {
	private $xmlPath = "xml/";
	private $xmlName = "lexicon";
	private $xmlDoc;
	private $xpath;
	
	public function __construct() {
		$doc = new DOMDocument();
		$doc->preserveWhiteSpace = false;
		$doc->formatOutput = true;
		$doc->load($this->xmlPath . $this->xmlName . ".xml");
		
		if ($doc->doctype->name != $this->xmlName || $doc->doctype->systemId != $this->xmlName.".dtd") {
			throw new Exception("incorrect document type");
		}
	
		if ($doc->validate()) {
			$this->xmlDoc = $doc;
			$this->xmlPath = $this->xmlPath . $this->xmlName . ".xml";
			$this->xpath = new DOMXPath($doc);
		} else {
			throw new Exception("Document did not validate");
		}
	}
	
	private function getList($xpathExpression) {
		$nodes = $this->xpath->evaluate("/lexicon/category" . $xpathExpression);
		$nodesArray = array();
		foreach ($nodes as $node) {
			$nodesArray[] = $node->nodeValue;
		}
		return $nodesArray;
	}
	
	public function getCategoryList() {
		$categories = $this->getList("/@name");
		sort($categories, SORT_STRING);
		return $categories;
	}
	
	public function getTerms($categoryName, $specifiedFields = null) {
		$termIds = $this->getList("[@name='$categoryName']/term/@termId");
		$terms = array();
		
		foreach ($termIds as $termId) {
			$termId = str_split($termId, 4)[1];
			$newTerm = new Term($termId, $specifiedFields);
			$fields = $newTerm->getFields();
			foreach ($fields as $fieldType => $fieldName) {
				$fieldValue = $this->getList("/term[@termId='term$termId']/field[@type='$fieldType']");
				if (sizeof($fieldValue) == 1) {
					$newTerm->addField($fieldType, $fieldValue[0]);
				} else {
					$newTerm->addField($fieldType, $fieldValue);
				}
			}
			$terms[] = $newTerm;			
		}
		return $terms;
	}
	
	public function getTermCount($categoryName) {
		$termIds = $this->getList("[@name='$categoryName']/term/@termId");
		return sizeof($termIds);
	}
	
	public function addTerm(Term $term) {
		if ($this->termExists($term->id())) {
			Throw new Exception("Term with id: '". $term->id() ."' already exists");
		} else {
			$category = $term->getCategory();
			$categoryNode = $this->xpath->evaluate("//category[@name='$category']")->item(0);
			
			$termNode = $this->xmlDoc->createElement("term");
			$termNode->setAttribute("termId", "term".$term->id());
			$categoryNode->appendChild($termNode);
			
			foreach ($term->getFields() as $fieldType => $fieldName) {
				$fieldNode = $this->xmlDoc->createElement("field", $term->getFieldValue($fieldType));
				$fieldNode->setAttribute("type", $fieldType);
				$termNode->appendChild($fieldNode);
			}
			
			$this->xmlDoc->save($this->xmlPath);
		}
	}
	
	public function findTerm($termId) {
		$termNode = $this->xmlDoc->getElementById("term" . $termId);
		$fieldNodes = $termNode->getElementsByTagName("field");
		
		//fill out a term object using the XML informations
		$term = new Term($termId);
		foreach ($fieldNodes as $fieldNode) {
			$term->addField($fieldNode->getAttribute("type"), $fieldNode->nodeValue);
		}
		
		//find the Term's parent category, save to the term
		$category = $termNode->parentNode->getAttribute("name");
		$term->setCategory($category);
		
		return $term;
	}
	
	public function updateTerm(Term $term) {
		if ($this->termExists($term->id())) {
			$termNode = $this->xmlDoc->getElementById("term" . $term->id());
			$fieldNodes = $termNode->getElementsByTagName("field");
			foreach ($fieldNodes as $fieldNode) {
				$fieldType = $fieldNode->getAttribute("type");
				$fieldNode->nodeValue = $term->getFieldValue($fieldType);
			}
			
			$this->xmlDoc->save($this->xmlPath);
		} else {
			Throw new Exception("Term with id: '". $term->id() ."' does not exist.");
		}
	}
	
	public function deleteTerm($termId) {
		if ($this->termExists($termId)) {
			$categoryNode = $this->xpath->evaluate("//category[term[@termId='term$termId']]")->item(0);
			$termNode = $this->xmlDoc->getElementById("term".$termId);
			
			$categoryNode->removeChild($termNode);
			$this->xmlDoc->save($this->xmlPath);
		} else {
			Throw new Exception("Term with id: '". $termId ."' does not exist.");
		}
	}
	
	public function termExists($id) {
		$values = $this->getTermIds();
		for ($i = 0; $i < sizeof($values); $i++) {
			if ($id == $values[$i]) { 
				return true;
			}
		}
		return false;
	}
	
	private function getTermIds() {
		$termIds = $this->getList("/term/@termId");
		$values = array();
		for ($i = 0; $i < sizeof($termIds); $i++) {
			$termId = $termIds[$i];
			$termId = str_split($termId, 4);
			$termId = intval($termId[1]);
			$values[] = $termId;
		}
		sort($values, SORT_ASC);
		return $values;
	}
	
	public function addCategory($categoryName) {
		if ($this->categoryExists($categoryName)) {
			throw new Exception("Category with name: '". $categoryName ."' already exists.");
		} else {
			$categoryNode = $this->xmlDoc->createElement("category");
			$categoryNode->setAttribute("name", $categoryName);
			$this->xmlDoc->documentElement->appendChild($categoryNode);
			$this->xmlDoc->save($this->xmlPath);
		}
	}
	
	public function editCategoryName($oldName, $newName) {
		if ($this->categoryExists($oldName)) {
			//TODO edit category name
		} else {
			Throw new Exception("Category with name: '". $oldName ."' does not exist.");
		}
	}
	
	private function categoryExists($name) {
		$categories = $this->getCategoryList();
		for ($i = 0; $i < sizeof($categories); $i++) {
			if ($name == $categories[$i]) {
				return true;
			}
		}
		return false;
	}
	
	public function nextTermId() {
		$values = $this->getTermIds();
		if (sizeof($values) == 0) {
			return 0;
		} else {
			for ($i = 0; $i < sizeof($values); $i++) {
				if ($i < $values[$i]) {
					return $i;
				}
			}
			return max($values) + 1;
		}
	}
	
	public function printXML() {
		echo $this->xmlDoc->saveXML();
	}
	
	public function __destruct() {
		unset($this->xmlDoc);
	}
}