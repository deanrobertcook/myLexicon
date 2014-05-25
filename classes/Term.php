<?php
class Term {
	public $englishTerm;
	public $germanTerm;
	public $examples;
	
	public function __construct($english, $german, array $examples) {
		$this->englishTerm = $english;
		$this->germanTerm = $german;
		$this->examples = $examples;
	}
	
	public function printTerm () {
		echo $this->englishTerm, "<br>";
		echo $this->germanTerm, "<br>";
		foreach ($this->examples as $example) {
			echo $example, "<br>";
		}
	}
}