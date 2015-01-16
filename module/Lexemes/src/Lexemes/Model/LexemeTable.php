<?php

namespace Lexemes\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;



class LexemeTable extends AbstractTableGateway
{
	public function __construct() {
		$this->table = 'lexemes';
		$this->featureSet = new FeatureSet();
		$this->featureSet->addFeature(new GlobalAdapterFeature());
		$this->initialize();
	}
}
