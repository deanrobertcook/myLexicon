<?php
class Settings {
	private $xmlPath = "xml/";
	private $xmlName = "settings";
	private $xmlDoc;
	private $xpath;
	
	private $defaultLanguage;
	private $allFields; //contains a list of all fields
	private $fieldsToDisplay;
	
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
		
		$this->setDefaultLanguage();
		$this->setAllFields();
		$this->setFieldsToDisplay();
	}
	
	public function setDefaultLanguage($language = null) {
		$currentDefault = $this->xpath->evaluate("//languages/target")
			->item(0)->nodeValue;
		
		if ($language == null) {
			$this->defaultLanguage = $currentDefault;
		} else {
			if ($currentDefault != $language) {
				//TODO change the default language so that it saves in the settings
			}
		}
	}
	
	public function getDefaultLanguage() {
		return $this->defaultLanguage;
	}
	
	private function setAllFields() {
		$fieldNodes = $this->xpath->evaluate("//field/type");
		$fields = array();
		foreach ($fieldNodes as $fieldNode) {
			$fields[] = $fieldNode->nodeValue;
		}
		$this->allFields = $fields;
	}
	
	public function getAllFields() {
		return $this->allFields;
	}
	
	public function setFieldsToDisplay($fields = array()) {
		if (empty($fields)) {
			$displayFieldNodes = $this->xpath->evaluate("//field[@display='true']");
			
			foreach ($displayFieldNodes as $displayFieldNode) {
				$fieldType = $displayFieldNode->getElementsByTagName("type")->item(0)->nodeValue;
				$fieldName = $displayFieldNode->getElementsByTagName($this->defaultLanguage)
					->item(0)->nodeValue;
				
				$fields[$fieldType] = $fieldName;
			}
			$this->fieldsToDisplay = $fields;
		} else {
			//TODO change in the XML which fields are to be displayed
		}
	}
	
	public function getFieldsToDisplay() {
		return $this->fieldsToDisplay;
	}
}