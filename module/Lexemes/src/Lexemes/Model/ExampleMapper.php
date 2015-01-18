<?php

namespace Lexemes\Model;

class ExampleMapper extends AbstractMapper
{
	public function readExample($id)
	{
		$sql = "SELECT * FROM examples WHERE id = ?";
		$params = array($id);
		return $this->select($sql, $params);
	}

	public function readAllExamples()
	{
		$sql = "SELECT * FROM examples";
		$params = array();
		$results = $this->select($sql, $params);
		return $results;
	}

	public function createExample($exampleData)
	{
		$sql = "INSERT INTO examples (meaningId, exampleTarget, exampleBase) VALUES (?, ?, ?)";
		$params = array(
			$exampleData['meaningId'],
			$exampleData['exampleTarget'],
			$exampleData['exampleBase'],
		);
		$id = $this->checkIfExampleExists($params);
		if (!$id) {
			$id = $this->insert($sql, $params);
		}
		return $id;
	}
	
	private function checkIfExampleExists($params)
	{
		$sql = "SELECT id FROM examples WHERE meaningId = ? AND exampleTarget = ? AND exampleBase = ?";
		return parent::checkIfExists($sql, $params);
	}

	public function updateExample($id, $exampleData)
	{
		$oldData = $this->readExample($id);
		$oldData['meaningId'] = isset($exampleData['meaningId']) ? $exampleData['meaningId'] : $oldData['meaningId'];
		$oldData['exampleTarget'] = isset($exampleData['exampleTarget']) ? $exampleData['exampleTarget'] : $oldData['exampleTarget'];
		$oldData['exampleBase'] = isset($exampleData['exampleBase']) ? $exampleData['exampleBase'] : $oldData['exampleBase'];
		
		$stmt = $this->pdo->prepare("UPDATE examples SET meaningId = ?, exampleTarget = ?, exampleBase = ? WHERE id = ?");
		$stmt->bindValue(1, $oldData['meaningId']);
		$stmt->bindValue(2, $oldData['exampleTarget']);
		$stmt->bindValue(3, $oldData['exampleBase']);
		$stmt->bindValue(4, $oldData['id']);
		$stmt->execute();
	}

}
