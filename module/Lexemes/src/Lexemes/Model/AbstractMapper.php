<?php

namespace Lexemes\Model;

use Zend\Db\Adapter\Adapter;

class AbstractMapper
{

	protected $adapter = null;

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
	}

	public function select($sql, $params)
	{
		$resultSet = $this->adapter->query($sql, $params);
		$results = null;
		if ($resultSet->count() == 1) {
			$results = $resultSet->toArray()[0];
		} else {
			$results = $resultSet->toArray();
		}
		return $results;
	}

}
