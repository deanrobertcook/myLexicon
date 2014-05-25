<?php
class Lexicon {
	private $xmlPath = "lexicon/";
	private $xmlDoc;
	private $xpath;
	
	public function __construct($fileName) {
		$doc = new DOMDocument();
		$doc ->load($this->xmlPath . $fileName);
		
		if ($doc->doctype->name != "lexicon" || $doc->doctype->systemId != "lexicon.dtd") {
			throw new Exception("incorrect document type");
		}
	
		if ($doc->validate()) {
			$this->xmlDoc = $doc;
			$this->xmlPath = $this->xmlPath . $fileName;
			$this->xpath = new DOMXPath($doc);
		} else {
			throw new Exception("Document did not validate");
		}
	}
	
	public function printXML() {
		echo var_dump($this->xmlDoc);
	}
	
	public function getCategoryList() {
		$categories = $this->xpath->evaluate("/lexicon/category/name");
		$categoryNames = Array();
		foreach ($categories as $category) {
			array_push($categoryNames, $category->nodeValue);
		}
		return $categoryNames;
	}
	
	public function getWordList($categoryName) {
		$terms = $this->xpath->evaluate("/lexicon/category[name='$categoryName']/term");
		$termsArray = Array();
		foreach ($terms as $term) {
			$english = $term->getElementsByTagName("english")->item(0)->nodeValue;
			$german = $term->getElementsByTagName("german")->item(0)->nodeValue;
			
			$examples = $term->getElementsByTagName("example");
			$exampleArray = array();
			
			foreach ($examples as $example) {
				array_push($exampleArray, $example->nodeValue);
			}
			
			array_push($termsArray, new Term($english, $german, $exampleArray));
		}
		return $termsArray;
	}
	
	public function __destruct() {
		unset($this->xmlDoc);
	}
}