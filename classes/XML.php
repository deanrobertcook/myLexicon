<?php
/**
 * Class XML attempts to encapsulate some of the functionality I need when working with
 * the XML document. However, I have a feeling that I am not gaining as much out of this
 * class as I had hoped, since the DOMDocument class already provides good coverage of 
 * the funtionality I need. I may in fact just be making things more complex.
 * 
 * I still need to figure out how to best save my data in the XML file. If I have an 
 * <examples></examples> tag, so I can store individual <example> tags within, then how
 * do I determine that examples has children? Or should I leave it how it is, and simply 
 * scatter as many <example> tags as I like within the <term>?
 * @author Dean
 *
 */
class XML {
	private $xmlPath = "xml/";
	private $xmlDoc;
	private $xpath;
	
	public function __construct($xmlName) {
		$doc = new DOMDocument();
		$doc->preserveWhiteSpace = false;
		$doc->formatOutput = true;
		$doc->load($this->xmlPath . $xmlName . ".xml");
		
		if ($doc->doctype->name != $xmlName || $doc->doctype->systemId != $xmlName.".dtd") {
			throw new Exception("incorrect document type");
		}
	
		if ($doc->validate()) {
			$this->xmlDoc = $doc;
			$this->xmlPath = $this->xmlPath . $xmlName . ".xml";
			$this->xpath = new DOMXPath($doc);
		} else {
			throw new Exception("Document did not validate");
		}
	}
	
	public function printXML() {
		echo $this->xmlDoc->saveXML();
	}
	
	public function getListOfNodes($xPathExpression) {
		//$this->printXML();
		$nodes = $this->xpath->evaluate($xPathExpression);
		$nodesArray = array();
		foreach ($nodes as $node) {
			array_push($nodesArray, $node->nodeValue);
		}
		return $nodesArray;
	}
	
	public function getChildValuesByParentID($parentID, $childNode) {
		$node = $this->xmlDoc->getElementById($parentID);
		$values = array();
		$i = 0;
		while ($node->getElementsByTagName($childNode)->item($i) != null) {
			array_push($values, $node->getElementsByTagName($childNode)->item(0)->nodeValue);
			$i++;
		}
		return $values;
	}
	
	
}