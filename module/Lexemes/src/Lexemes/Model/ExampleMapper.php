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
		return $this->select($sql, $params);
	}

	public function createExample($exampleData)
	{
		$id = $this->checkIfExampleExists($exampleData['meaningId'], $exampleData['exampleTarget'], $exampleData['exampleBase']);
		if ($id == NULL) {
			$stmt = $this->pdo->prepare("INSERT INTO examples (meaningId, exampleTarget, exampleBase) VALUES (?, ?, ?)");
			$stmt->bindValue(1, $exampleData['meaningId']);
			$stmt->bindValue(2, $exampleData['exampleTarget']);
			$stmt->bindValue(3, $exampleData['exampleBase']);

			$stmt->execute();
			$id = $this->pdo->lastInsertId("id");
		}
		return $id;
	}

	public function checkIfExampleExists($meaningId, $exampleTarget, $exampleBase)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM examples WHERE meaningId = ? AND exampleTarget = ? AND exampleBase = ?");
		$stmt->bindValue(1, $meaningId);
		$stmt->bindValue(2, $exampleTarget);
		$stmt->bindValue(3, $exampleBase);
		$stmt->execute();
		$row = $stmt->fetch();
		return $row['id'];
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
