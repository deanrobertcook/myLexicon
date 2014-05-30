<?php
class Controller {
	private $view;
	private $lexicon;
	
	public function __construct() {
		$this->lexicon = new Lexicon();
		$this->view = new View($this->lexicon);
	}
	
	public function defaultAction($params = null) {
		$this->view->outputHeader("Home");
		$this->view->outputContents();
		$this->view->outputFooter();
	}
	
	public function displayCategory($categoryName) {
		//TODO Allow the user to modify the display fields by submitting a form or something
		$displayFields = array(
			"english",
			"german",
			"example",
		);
		
		$this->view->outputHeader("Terms");
		$this->view->outputCategory($categoryName[0], $displayFields);
		$this->view->outputFooter();
	}
	
	public function addTerm($input = null) {
		$errorMessages = array();
		$output = false;
		if ($input != null && $input[0] == "true") {
			if (Input::exists()) {
				$validate = new Validate();
				$validation = $validate->check($_POST, array(
					'category' => array('required' => true),
					'english' => array('required' => true),
					'german' => array('required' => true),
				));
				if ($validation->passed()) {
					$term = new Term($this->lexicon->nextTermId());
					//TODO automate all of this using arrays/loops...
						$term->addField("english", Input::get("english"));
						$term->addField("german", Input::get("german"));
						$term->addField("example", Input::get("example"));
					$term->setCategory(Input::get("category"));
					$this->lexicon->addTerm($term);
					$output = true;
				} else {
					$errorMessages = $validation->errors();
					$output = true;
				}
			} else {
				$output = true;
			}
		} else {
			$output = true;
		}

		if ($output) {
			$this->view->outputHeader("Add Term");
			$this->view->addTermForm($errorMessages);
			$this->view->outputFooter();
		}
	}
	
	public function addCategory($input = null) {
		$errorMessages = array();
		$output = false;
		if ($input != null && $input[0] == "true") {
			if (Input::exists()) {
				$validate = new Validate();
				$validation = $validate->check($_POST, array(
					'category' => array('required' => true),
				));
				if ($validation->passed()) {
					$this->lexicon->addCategory(unTidyWord(Input::get("category")));
					$output = true;
				} else {
					$errorMessages = $validation->errors();
					$output = true;
				}
			} else {
				$output = true;
			}
		} else {
			$output = true;
		}

		if ($output) {
			$this->view->outputHeader("Add Category");
			$this->view->addCategoryForm($errorMessages);
			$this->view->outputFooter();
		}
	}
	
	public function editTerm($input = null) {
		$errorMessages = array();
		$presetValues = array();
		
		$output = false;
		if ($input != null) { 
			if ($input[0] == "find") {
				if (Input::exists()) {
					$validate = new Validate();
					$validation = $validate->check($_POST, array(
						'termId' => array('required' => true),
						//'english' => array('required' => true),
						//'german' => array('required' => true),
					));
					if ($validation->passed()) {
						$termId = Input::get("termId");
						if ($this->lexicon->termExists($termId)) {
							$term = $this->lexicon->findTerm($termId);
							$fields = $term->getFields();
							
							$presetValues["termId"] = $termId;
							$presetValues["category"] = $term->getCategory();
							foreach($fields as $field) {
								$presetValues[$field] = $term->getFieldValue($field);
							}
							
						} else {
							$errorMessages[] = "Term does not exist!";
						}
						
						$output = true;
					} else {
						$errorMessages = $validation->errors();
						$output = true;
					}
				} else {
					$output = true;
				}
			} else if ($input[0] == "save") {
				if (Input::exists()) {
					$validate = new Validate();
					$validation = $validate->check($_POST, array(
						'termId' => array('required' => true),
						'english' => array('required' => true),
						'german' => array('required' => true),
					));
					if ($validation->passed()) {
						$termId = Input::get("termId");
						if ($this->lexicon->termExists($termId)) {
							$term = $this->lexicon->findTerm($termId);
							$fields = $term->getFields();
							
							$values = Input::getAll(array(
								"termId", //ignore these entries
							));
							foreach ($values as $inputName => $value) {
								if ($inputName == "category") {
									$term->setCategory($value);
								}
								$term->addField($inputName, $value);
							}
							$this->lexicon->saveTerm($term);
						} else {
							$errorMessages[] = "Term does not exist!";
						}
						$output = true;
					} else {
						$errorMessages = $validation->errors();
						$output = true;
					}
				} else {
					$output = true;
				}
			}
		} else {
			$output = true;
		}

		if ($output) {
			$this->view->outputHeader("Edit Term");
			$this->view->editTermForm($errorMessages, $presetValues);
			$this->view->outputFooter();
		} else {
			Redirect::to("/myLexicon");
		}
	}
}