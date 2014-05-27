<?php
/**
 * Class Term encapsulates a term in the lexicon. Only the fields listed
 * in the $fields array will be fetched and displayed in myLexicon. This allows
 * extra information for a word to be gathered without the need to worry
 * about displaying it for the time being.
 * 
 * Array allFields was actually useless upon some thought. If I wish to fetch a term
 * using only a limited number of fields, then I only specify those fields when creating
 * the term object (which will then search the XML with only the fields specified). 
 * 
 * If I want to create a field that maintains all possible fields, then I pass it a fields
 * array that is more expansive, so that when it goes to save the information, it has more than
 * what might be displayed at that point in time. In other words, Term objects created to view
 * data will end up being quite separate form Term objects created to save data. 
 * @author Dean
 *
 */
class Term {
	private $id;
	private $fields;
	private $values;
	
	private $allFields;
	
	public function __construct($id, $specifiedFields = null) {
		$this->id = "term" . $id;
		
		if ($specifiedFields == null) {
			//list the default fields for the Term object
			$this->fields = array(
				"english",
				"german",
				"example",
			);
		} else {
			$this->fields = $specifiedFields;
		}
	}
	
	private function index($fieldType) {
		return array_search($fieldType, $this->fields);
	}
	
	public function id() {
		return $this->id;
	}
	
	public function getFieldValue($fieldType) {
		return $this->values[$this->index($fieldType)];
	}
	
	public function addField($fieldType, $fieldValue) {
		$this->values[$this->index($fieldType)] = $fieldValue;
	}
	
	public function getFields() {
		return $this->fields;
	}
	
	public function printTerm () {
		echo "id: " . $this->id(), "<br>";
		for ($i = 0; $i < sizeof($this->fields); $i++) {
			echo $this->fields[$i] . ": " . $this->values[$i], "<br>";
		}
	}
}