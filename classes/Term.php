<?php
/**
 * Class Term encapsulates a term in the lexicon. Only the fields listed
 * in the constructor will be fetched and displayed in myLexicon. This allows
 * extra information for a word to be gathered without the need to worry
 * about displaying it for the time being.
 * 
 * Array allFields will be used to keep track of every field that I have defined in 
 * the DTD as required. This will be useful when adding a word to myLexicon, as I 
 * want to force the user to add as much information about the word as possible, even
 * if it won't necessarily be displayed. 
 * @author Dean
 *
 */
class Term {
	public $fields;
	public $values;
	
	public $allFields;
	
	public function __construct() {
		$this->fields = array(
			"english",
			"german",
		);
		
		$this->allFields = array(
			"english",
			"german",
			"example",
		);
	}
	
	public function printTerm () {
		for ($i = 0; $i < sizeof($this->fields); $i++) {
			echo $this->values[i], "<br>";
		}
	}
	
	public function getFields() {
		return $this->fields;
	}
}