<?php

namespace Lexemes\Model;

class ExampleMapper
{

	private $pdo = null;

	public function __construct($PDO)
	{
		$this->pdo = $PDO;
	}

	public function readExample($id)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM examples WHERE id = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		$row = $stmt->fetch();
		return $this->getExampleDataFromRow($row);
	}

	public function readAllExamples()
	{
		$stmt = $this->pdo->prepare("SELECT * FROM examples");
		$stmt->execute();
		$examples = array();
		while ($row = $stmt->fetch()) {
			$examples[] = $this->getExampleDataFromRow($row);
		}
		return $examples;
	}

	private function getExampleDataFromRow($row)
	{
		return array(
			'id' => $row['id'],
			'meaningId' => $row['meaningid'],
			'exampleTarget' => $row['example_target'],
			'exampleBase' => $row['example_base'],
		);
	}

	public function createExample($exampleData)
	{
		$id = $this->checkIfExampleExists($exampleData['meaningId'], $exampleData['exampleTarget'], $exampleData['exampleBase']);
		if ($id == NULL) {
			$stmt = $this->pdo->prepare("INSERT INTO examples (meaningid, example_target, example_base) VALUES (?, ?, ?)");
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
		$stmt = $this->pdo->prepare("SELECT * FROM examples WHERE meaningid = ? AND example_target = ? AND example_base = ?");
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
