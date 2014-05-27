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
		$this->view->outputHeader("Terms");
		$this->view->outputCategory($categoryName[0]);
		$this->view->outputFooter();
	}
	
	public function addTerm($termAdded = null) {
		$errorMessage = null;
		$output = false;
		if ($termAdded != null && $termAdded[0] == "termAdded") {
			if (Input::exists()) {
				$validate = new Validate();
				$validation = $validate->check($_POST, array(
					'category' => array('required' => true),
					'english' => array('required' => true),
					'german' => array('required' => true),
				));
				if ($validation->passed()) {
					$term = new Term($this->lexicon->nextTermId());
					$term->addField("english", Input::get("english"));
					$term->addField("german", Input::get("german"));
					$term->addField("example", Input::get("example"));
					$this->lexicon->addTerm(Input::get("category"), $term);
					//Redirect::to("/myLexicon");
					$output = true;
				} else {
					$errorMessage = "Validation failed";
					$output = true;
				}
			} else {
				$errorMessage = "No input found, please try adding Term again.";
				$output = true;
			}
		} else {
			$output = true;
		}

		if ($output) {
			$this->view->outputHeader("Add Term");
			$this->view->addTermForm($errorMessage);
			$this->view->outputFooter();
		}
	}
	
	public function addCategory($categoryAdded = null) {
		$errorMessage = null;
		$output = false;
		if ($categoryAdded != null && $categoryAdded[0] == "categoryAdded") {
			if (Input::exists()) {
				$validate = new Validate();
				$validation = $validate->check($_POST, array(
					'category' => array('required' => true),
				));
				if ($validation->passed()) {
					//echo unTidyWord(Input::get("category"));
					$this->lexicon->addCategory(unTidyWord(Input::get("category")));
					//Redirect::to("/myLexicon");
					$output = true;
				} else {
					$errorMessage = "Validation failed";
					$output = true;
				}
			} else {
				$errorMessage = "No input found, please try adding Term again.";
				$output = true;
			}
		} else {
			$output = true;
		}

		if ($output) {
			$this->view->outputHeader("Add Category");
			$this->view->addCategoryForm($errorMessage);
			$this->view->outputFooter();
		}
	}
}