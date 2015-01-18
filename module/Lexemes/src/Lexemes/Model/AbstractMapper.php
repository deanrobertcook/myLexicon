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
		$statement = $this->adapter->createStatement($sql);
		$resultSet = $statement->execute($params);
		$results = null;
		if ($resultSet->count() == 1) {
			$results = $resultSet->current();
		} else {
			$results = $this->getAllResults($resultSet);
		}
		return $results;
	}
	
	private function getAllResults($resultSet) {
		$count = $resultSet->count();
		$results = array();
		for ($i = 0; $i < $count; $i++) {
			$results[] = $resultSet->next();
		}
		return $results;
	}
	
	public function checkIfExists($sql, $params) {
		$result = $this->select($sql, $params);
		if (isset($result['id'])) {
			return $result['id'];
		} else {
			return false;
		}
	}
	
	public function insert($sql, $params) {
		$statement = $this->adapter->createStatement($sql);
		$resultSet = $statement->execute($params);
		$id = $resultSet->getGeneratedValue();
		return $id;
	}
}
