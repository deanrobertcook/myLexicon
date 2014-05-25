<?php
class Validate {
	private $passed = false,
			$errors = array();
	
	public function check($source, $items=array()) {
		foreach($items as $item => $rules) {
			foreach($rules as $rule => $ruleValue) {
				$value = $source[$item];
				$item = escape($item);
				
				if ($rule === 'required' && empty($value)) {
					$this->addError("$item is required");
				} else if (!empty($value)) {
					switch ($rule) {
						case 'min':
							if (strlen($value) < $ruleValue) {
								$this->addError("$item must be a minimum of $ruleValue characters");
							}
						break;
						case 'max':
							if (strlen($value) > $ruleValue) {
								$this->addError("$item must be a maximum of $ruleValue characters");
							}
						break;
						case 'matches':
							if ($value != $source[$ruleValue]) {
								$this->addError("$ruleValue value must match $item");
							}
						break;
						case 'unique':
							
						break;
					}
				}
			}
		}
		
		if (empty($this->errors)) {
			$this->passed = true;
		}
		
		return $this;
	}
	
	private function addError($error) {
		$this->errors[] = $error;
	}
	
	public function errors() {
		return $this->errors;
	}
	
	public function passed() {
		return $this->passed;
	}
}