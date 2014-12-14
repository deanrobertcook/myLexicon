<?php
namespace Lexemes\Form;

use Zend\Form\Form;

class MeaningForm extends Form {
	public function __construct($name = null, $options = array()) {
		parent::__construct('album');
		$this->setAttribute('method', 'post');
		$this->add(array(
			'name' => 'id',
			'type' => 'hidden',
		));
//		$this->add(array(
//			'name' => 'target_language',
//			'type' => 'text',
//			'options' => array(
//				'label' => 'Target Language',
//			),
//		));
		$this->add(array(
			'name' => 'target_type',
			'type' => 'text',
			'options' => array(
				'label' => 'Target Type',
			),
		));
		$this->add(array(
			'name' => 'target_entry',
			'type' => 'text',
			'options' => array(
				'label' => 'Target Entry',
			),
		));
//		$this->add(array(
//			'name' => 'base_language',
//			'type' => 'text',
//			'options' => array(
//				'label' => 'Base Language',
//			),
//		));
		$this->add(array(
			'name' => 'base_type',
			'type' => 'text',
			'options' => array(
				'label' => 'Base Type',
			),
		));
		$this->add(array(
			'name' => 'base_entry',
			'type' => 'text',
			'options' => array(
				'label' => 'Base Entry',
			),
		));
		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
				'value' => 'Go',
				'id' => 'submitbutton',
			),
		));
	}
}