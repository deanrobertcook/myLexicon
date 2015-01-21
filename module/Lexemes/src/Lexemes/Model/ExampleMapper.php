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
		return $this->injectMeaningsIntoExamples($results);
	}
	
	private function injectMeaningsIntoExamples($results) {
		$examples = array();
		foreach ($results as $example) {
			$meanings = $this->findAssociatedMeanings($example['id']);
			$meaningIds = array();
			foreach($meanings as $meaning) {
				$meaningIds[] = ($meaning['id']);
			}
			$example['meanings'] = $meaningIds;
			$examples[] = $example;
		}
		
		return $examples;
	}
	
	private function findAssociatedMeanings($exampleId) {
		$sql = "SELECT * FROM examplesToMeanings WHERE id = ?";
		$params = array($exampleId);
		$examplesToMeaningMap = $this->select($sql, $params);
		if (isset($examplesToMeaningMap['id'])) {
			$examplesToMeaningMap = array($examplesToMeaningMap);
		}
		return $examplesToMeaningMap;
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
	
	protected function checkIfExampleExists($params)
	{
		$sql = "SELECT id FROM examples WHERE meaningId = ? AND exampleTarget = ? AND exampleBase = ?";
		return parent::checkIfExists($sql, $params);
	}

	public function updateExample($id, $exampleData)
	{
		$oldData = $this->readExample($id);
		$sql = "UPDATE examples SET meaningId = ?, exampleTarget = ?, exampleBase = ? WHERE id = ?";
		$params = array(
			isset($exampleData['meaningId']) ? $exampleData['meaningId'] : $oldData['meaningId'],
			isset($exampleData['exampleTarget']) ? $exampleData['exampleTarget'] : $oldData['exampleTarget'],
			isset($exampleData['exampleBase']) ? $exampleData['exampleBase'] : $oldData['exampleBase'],
			$id,
		);
		
		return $this->update($sql, $params);
	}

}
