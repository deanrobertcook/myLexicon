<?php
class Controller {
	private $view;
	private $settings;
	private $lexicon;
	
	public function __construct() {
		$this->settings = new Settings();
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
		$displayFields = $this->settings->getFieldsToDisplay();
		
		$this->view->outputHeader("Terms");
		$this->view->outputCategory($categoryName[0], $displayFields);
		$this->view->outputFooter();
	}
	
	public function getSettings() {
		var_dump($this->settings->getFieldsToDisplay());
	}
	
	public function addTerm($input = null) {
		$errorMessages = array();
		$output = false;
		$termId;
		if ($input != null && $input[0] == "true") {
			if (Input::exists()) {
				$validate = new Validate();
				$validation = $validate->check($_POST, array(
					'category' => array('required' => true),
				));
				if ($validation->passed()) {
					$termId = $this->lexicon->nextTermId();
					$values = Input::getAll($ignore = array(
						//ignore these entries when retrieving input
						"ajax",
						"termId", 
						"category",
					));
					$term = new Term($termId, $values);
					$term->setCategory(Input::get("category"));
					$this->lexicon->addTerm($term, $this->settings->getFieldsToDisplay());
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
		
		if (!Input::get("ajax")) {
			if ($output) {
				$this->view->outputHeader("Add Term");
				$this->view->addTermForm($errorMessages);
				$this->view->outputFooter();
			} else {
				Redirect::to("/myLexicon");
			}
		} else {
			echo $termId;
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
		if ($input != null && $input[0] == "true") { 

			if (Input::get("find")) {
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
				
			} else if (Input::get("save")) {
				$validate = new Validate();
				$validation = $validate->check($_POST, array(
					'termId' => array('required' => true),
				));
				if ($validation->passed()) {
					$termId = Input::get("termId");
					if ($this->lexicon->termExists($termId)) {
						$term = $this->lexicon->findTerm($termId);
						
						$values = Input::getAll($ignore = array(
							//ignore these entries when retrieving input
							"ajax",
							"save",
							"termId", 
						));
						foreach ($values as $inputName => $value) {
							if ($inputName == "category") {
								$term->setCategory($value);
							}
							$term->addField($inputName, $value);
						}
						$this->lexicon->updateTerm($term);
					} else {
						$errorMessages[] = "Term does not exist!";
					}
					$output = true;
				} else {
					$errorMessages = $validation->errors();
					$output = true;
				}
				
			} else if (Input::get("delete")) {
				$this->lexicon->deleteTerm(Input::get("termId"));
			}
		} else {
			$output = true;
		}

		if (!Input::get("ajax")) {
			if ($output) {
				$this->view->outputHeader("Edit Term");
				$this->view->editTermForm($errorMessages, $presetValues);
				$this->view->outputFooter();
			} else {
				Redirect::to("/myLexicon");
			}
		}
	}
}