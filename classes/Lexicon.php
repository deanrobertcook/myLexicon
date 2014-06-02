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
	private $xmlPath = "xml/lexicon";
	private $xsdNameSpace = "http://localhost/myLexicon/xml/lexicon";
	private $xmlDoc;
	private $xpath;
	
	//TODO, decide whether this class should hold onto a list of settings/categories etc. when intially 
	//constructed so as to avoid constant looking up of the XML, or whether it will be too tricky to 
	//keep the class synced with the underlying XML
	
	public function __construct() {
		$doc = new DOMDocument();
		$doc->preserveWhiteSpace = false;
		$doc->formatOutput = true;
		$doc->load($this->xmlPath . ".xml");

		if ($doc->schemaValidate($this->xmlPath . ".xsd")) {
			$this->xmlDoc = $doc;
			$this->xmlPath = $this->xmlPath . ".xml";
			$this->xpath = new DOMXPath($doc);
			$this->xpath->registerNamespace("xs", $this->xsdNameSpace);
		} else {
			throw new Exception("Document did not validate");
		}
	}
	
	private function getList($xpathExpression) {
		$nodes = $this->xpath->evaluate("/xs:lexicon/xs:category" . $xpathExpression);
		$nodesArray = array();
		foreach ($nodes as $node) {
			$nodesArray[] = $node->nodeValue;
		}
		return $nodesArray;
	}
	
	public function getCategoryList() {
		$categories = $this->getList("/xs:name");
		sort($categories, SORT_STRING);
		return $categories;
	}
	
	public function getTerms($categoryName, $specifiedFields = null) {
		$termIds = $this->getList("[xs:name='$categoryName']/xs:term/@termId");
		$terms = array();
		
		foreach ($termIds as $termId) {
			$termId = str_split($termId, 4)[1];
			$newTerm = new Term($termId, $specifiedFields);
			$fields = $newTerm->getFields();
			foreach ($fields as $fieldType => $fieldName) {
				$fieldValue = $this->getList(
						"/xs:term[@termId='term$termId']/xs:field[xs:type='$fieldType']/xs:value");
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
		$termIds = $this->getList("[xs:name='$categoryName']/xs:term/@termId");
		return sizeof($termIds);
	}
	
	public function addTerm(Term $term) {
		if ($this->termExists($term->id())) {
			Throw new Exception("Term with id: '". $term->id() ."' already exists");
		} else {
			$categoryName = $term->getCategory();
			$categoryNode = $this->xpath->evaluate("//xs:category[xs:name='$categoryName']")->item(0);
			
			$termNode = $this->xmlDoc->createElement("term");
			$termNode->setAttribute("termId", "term".$term->id());
			$categoryNode->appendChild($termNode);
			
			foreach ($term->getFields() as $fieldType => $fieldValue) {
				$fieldNode = $this->createField($fieldType, $fieldValue);
				$termNode->appendChild($fieldNode);
			}
			
			$this->xmlDoc->save($this->xmlPath);
		}
	}
	
	private function createField($fieldType, $fieldValue) {
		$fieldNode = $this->xmlDoc->createElement("field");
		$typeNode =  $this->xmlDoc->createElement("type", $fieldType);
		$fieldNode->appendChild($typeNode);
		
		$valueNode = $this->xmlDoc->createElement("value", $fieldValue);
		$fieldNode->appendChild($valueNode);
		
		return $fieldNode;
		 
	}
	
	public function findTerm($termId) {
		$termNode = $this->xmlDoc->getElementById("term" . $termId);
		$fieldNodes = $termNode->getElementsByTagName("field");
		
		//fill out a term object using the XML informations
		$term = new Term($termId);
		foreach ($fieldNodes as $fieldNode) {
			$type = $fieldNode->getElementsByTagName("type")->item(0)->nodeValue;
			$value = $fieldNode->getElementsByTagName("value")->item(0)->nodeValue;
			
			$term->addField($type, $value);
		}
		
		//find the Term's parent category, save to the term
		$category = $termNode->parentNode->getElementsByTagName("name")->item(0)->nodeValue;
		$term->setCategory($category);
		return $term;
	}
	
	public function updateTerm(Term $term) {
		if ($this->termExists($term->id())) {
			$termNode = $this->xmlDoc->getElementById("term" . $term->id());
			$newValues = $term->getFields();
			
			foreach ($newValues as $fieldType => $fieldValue) {
				$fieldNode = $this->xpath->evaluate("//xs:field[xs:type='$fieldType']")->item(0);
				if ($fieldNode == null) {
					$fieldNode = $this->createField($fieldType, $fieldValue);
					$termNode->appendChild($fieldNode);
				} else {
					$valueNode = $this->xpath->evaluate("//xs:field[xs:type='$fieldType']/xs:value")->item(0);
					$valueNode->nodeValue = $fieldValue;
				}
			}
			$this->xmlDoc->save($this->xmlPath);
		} else {
			Throw new Exception("Term with id: '". $term->id() ."' does not exist.");
		}
	}
	
	public function deleteTerm($termId) {
		if ($this->termExists($termId)) {
			$categoryNode = $this->xpath->evaluate("//xs:category[xs:term[@termId='term$termId']]")->item(0);
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
		$termIds = $this->getList("/xs:term/@termId");
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
			
			$nameNode = $this->xmlDoc->createElement("name", $categoryName);
			$categoryNode->appendChild($nameNode);
			
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
		var_dump($categories);
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