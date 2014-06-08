<?php
class Controller {
	private $view;
	private $settings;
	private $lexicon;
	
	public function __construct() {
		$this->settings = new Settings();
		$this->lexicon = new Lexicon();
		$this->view = new View($this->lexicon, $this->settings);
	}
	
	public function test() {
		$this->settings->reorderField("plural", 4);
	}
	
	public function defaultAction($params = null) {
		$this->view->outputHeader("home");
		$this->view->outputContents();
		$this->view->outputFooter();
	}
	
	public function displayCategory($params) {
		//TODO Allow the user to modify the display fields by submitting a form or something
		//$displayFields = $this->settings->getFieldsToDisplay();
		
		$this->view->outputHeader("terms");
		$this->view->outputCategory($params[0]);
		$this->view->outputFooter();
	}
	
	public function changeSettings($params = null) {
		$errorMessages = array();
		$output = false;
		if ($params != null && $params[0] == "true") {
			if (Input::exists()) {
				$validate = new Validate();
				$validation = $validate->check($_POST, array(
					
				));
				if ($validation->passed()) {
					$values = Input::getAll();
					
					if (Input::get("targetLanguage")) {
						$this->settings->setTargetLanguage(Input::get("targetLanguage"));
					}
					if (Input::get("baseLanguage")) {
						$this->settings->setBaseLanguage(Input::get("baseLanguage"));
					}
					if (Input::get("fieldsToDisplay")) {
						$allFields = $this->settings->getAllFields();
						$displayFields = Input::get("fieldsToDisplay");
						foreach ($allFields as $fieldType => $fieldName) {
							
							if (array_search($fieldType, $displayFields) === false) {
								$this->settings->setFieldDisplay($fieldType, "false");
							} else {
								$this->settings->setFieldDisplay($fieldType, "true");
							}
						}
					}
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
				$this->view->outputHeader("settings");
				$this->view->changeSettingsForm($errorMessages);
				$this->view->outputFooter();
			} else {
				Redirect::to("/myLexicon");
			}
		} else {
			//TODO ajax call;
		}
	}
	
	public function addTerm($params = null) {
		$errorMessages = array();
		$output = false;
		$termId;
		if ($params != null && $params[0] == "true") {
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
				$this->view->outputHeader("add_term");
				$this->view->addTermForm($errorMessages);
				$this->view->outputFooter();
			} else {
				Redirect::to("/myLexicon");
			}
		} else {
			echo $termId;
		}
		
	}
	
	public function addCategory($params = null) {
		$errorMessages = array();
		$output = false;
		if ($params != null && $params[0] == "true") {
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
			$this->view->outputHeader("add_category");
			$this->view->addCategoryForm($errorMessages);
			$this->view->outputFooter();
		}
	}
	
	public function editTerm($params = null) {
		$errorMessages = array();
		$presetValues = array();
		$output = false;
		if ($params != null && $params[0] == "true") { 

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
						foreach($fields as $fieldType => $fieldName) {
							$presetValues[$fieldType] = $term->getFieldValue($fieldType);
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
					//'termId' => array('required' => true),
				));
				if ($validation->passed()) {
					$termId = Input::get("termId");
					if ($this->lexicon->termExists($termId)) {
						$term = $this->lexicon->findTerm($termId);
						
						$values = Input::getAll($ignore = array(
							//ignore these entries when retrieving input
							"ajax",
							"save",
							"category",
							"termId", 
						));
						$term->setValues($values);
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
				$this->view->outputHeader("edit_term");
				$this->view->editTermForm($errorMessages, $presetValues);
				$this->view->outputFooter();
			} else {
				
			}
		}
	}
}