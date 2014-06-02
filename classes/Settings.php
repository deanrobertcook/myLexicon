<?php
class Settings {
	private $xmlPath = "xml/settings";
	private $xsdNameSpace = "http://localhost/myLexicon/xml/settings";
	private $xmlDoc;
	private $xpath;
	
	private $siteRoot = "/myLexicon/";
	
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
	
	public function setTargetLanguage($language) {		
		//unset current target as target
		$oldLanguage = $this->xpath->evaluate("//xs:languages/xs:language[@target='target']")->item(0);
		$oldLanguage->removeAttribute("target");
		
		//set chosen language as new target
		$chosenLanguage = $this->xpath->evaluate("//xs:languages/xs:language[text()='$language']")->item(0);
		$chosenLanguage->setAttribute("target", "target");
		
		$this->xmlDoc->save($this->xmlPath);
	}
	
	public function getTargetLanguage() {
		return $this->xpath->evaluate("//xs:languages/xs:language[@target='target']")->item(0)->nodeValue;
	}
	
	public function setBaseLanguage($language) {
		//unset current target as target
		$oldLanguage = $this->xpath->evaluate("//xs:languages/xs:language[@base='base']")->item(0);
		$oldLanguage->removeAttribute("base");
		
		//set chosen language as new target
		$chosenLanguage = $this->xpath->evaluate("//xs:languages/xs:language[text()='$language']")->item(0);
		$chosenLanguage->setAttribute("base", "base");
		
		$this->xmlDoc->save($this->xmlPath);
	}
	
	public function getBaseLanguage() {
		return $this->xpath->evaluate("//xs:languages/xs:language[@base='base']")->item(0)->nodeValue;
	}
	
	public function getLanguagesAvailable() {
		$languageNodes = $this->xmlDoc->getElementsByTagName("languages")->item(0)->childNodes;
		$languages = array();
		foreach($languageNodes as $languageNode) {
			$language = $languageNode->nodeValue;
			$languages[] = $language;
		}
		return $languages;
	}
	
	private function sortByOrder($a, $b) {
		return (int) $a->getElementsByTagName("order")->item(0)->nodeValue - 
			(int) $b->getElementsByTagName("order")->item(0)->nodeValue;
	}
	
	/**
	 * Finds all available field types within the settings document and returns them
	 * in their specified order, whether set to display, required or not. 
	 */
	public function getAllFields() {
		$fieldNodes = $this->xpath->evaluate("//xs:field");
		$fieldArray = iterator_to_array($fieldNodes);
		
		usort($fieldArray, "self::sortByOrder");
		
		$fields = array();
		foreach ($fieldArray as $fieldNode) {
			$fieldType = $fieldNode->getElementsByTagName("type")->item(0)->nodeValue;
			$fieldDisplay = $this->getFieldDisplay($fieldType);
			$fields[$fieldType] = $fieldDisplay;
		}
		return $fields;
	}
	
	public function getFieldsToDisplay() {
		$displayFieldNodes = $this->xpath->evaluate("//xs:field[xs:display='true']");
		$displayFieldArray = iterator_to_array($displayFieldNodes);
		
		usort($displayFieldArray, "self::sortByOrder");
		
		$fields = array();
		foreach ($displayFieldArray as $displayNode) {
			$fieldType = $displayNode->getElementsByTagName("type")->item(0)->nodeValue;
			$fieldDisplay = $this->getFieldDisplay($fieldType);
			$fields[$fieldType] = $fieldDisplay;
		}
		return $fields;
	}
	
	public function reorderField($fieldType, $newOrder) {
		$currentOrder = $this->xpath->evaluate(
				"//xs:field[xs:type='$fieldType']/xs:order")->item(0)->nodeValue;
		
		$fullArray = $this->getAllFields();
		$fieldRemoved = array_splice($fullArray, $currentOrder, 1);
		$bottomHalf = array_splice($fullArray, $newOrder);
		
		$fullArray = array_merge($fullArray, $fieldRemoved, $bottomHalf);
		
		$fieldNodes = $this->xpath->evaluate("//xs:field");
		foreach ($fieldNodes as $fieldNode) {
			$fieldType = $fieldNode->getElementsByTagName("type")->item(0)->nodeValue;
			$fieldOrder = $fieldNode->getElementsByTagName("order")->item(0);
			$fieldOrder->nodeValue = array_search($fieldType, array_keys($fullArray));
		}
		
		//$this->xmlDoc->save($this->xmlPath);
	}
	
	private function getFieldDisplay($fieldType) {
		$fieldDisplayNode = $this->xpath->evaluate(
			"//xs:field[xs:type='$fieldType']/xs:".$this->getTargetLanguage())->item(0);
		if ($fieldDisplayNode == null) {
			return $fieldType."(!)";
		} else {
			return $fieldDisplayNode->nodeValue;
		}
	}
	
	public function getFieldSize($fieldType) {
		$fieldSize = $this->xpath->evaluate("//xs:field[xs:type='$fieldType']/xs:size")
		->item(0)->nodeValue;
		return $fieldSize;
	}
	
	public function setFieldDisplay($fieldType, $display) {
		$this->xpath->evaluate("//xs:field[xs:type='$fieldType']/xs:display")
		->item(0)->nodeValue = $display;
		$this->xmlDoc->save($this->xmlPath);
	}
	
	public function getCategoryDisplay($categoryName) {
		$displayNode = $this->xpath->evaluate(
			"//xs:category[xs:name='$categoryName']/xs:".$this->getTargetLanguage())->item(0);
		if ($displayNode == null) {
			return $categoryName."(!)";
		} else {
			return $displayNode->nodeValue;
		}
	}
	
	public function getLinks() {
		$linkNodes = $this->xpath->evaluate("//xs:links/xs:link");
		
		$links = array();
		foreach ($linkNodes as $linkNode) {
			$linkDisplay = $linkNode->getElementsByTagName($this->getTargetLanguage())->item(0);
			
			//if language not set for link
			if ($linkDisplay == null) {
				$linkDisplay = $linkNode->getElementsByTagName("name")->item(0)->nodeValue;
				$linkDisplay = tidyWord($linkDisplay)."(!)";
			} else {
				$linkDisplay = $linkDisplay->nodeValue;
			}
			
			$linkPath = $linkNode->getElementsByTagName("path")->item(0)->nodeValue;
			$links[$linkDisplay] = $this->siteRoot . $linkPath;
		}
		return $links;
	}
	
	public function getLinkDisplay($linkName) {
		$displayNode = $this->xpath->evaluate(
			"//xs:link[xs:name='$linkName']/xs:".$this->getTargetLanguage())->item(0);
		if ($displayNode == null) {
			return tidyWord($linkName)."(!)";
		} else {
			return $displayNode->nodeValue;
		}
	}
}




