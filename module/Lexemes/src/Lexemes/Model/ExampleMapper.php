<?php

namespace Lexemes\Model;

class ExampleMapper extends AbstractMapper
{
	public function readExample($id)
	{
		$sql = "SELECT * FROM examples WHERE id = ?";
		$params = array($id);
		$example = $this->select($sql, $params);
		$example = $this->injectMeaningIntoExample($example);
		return $example;
	}

	public function readAllExamples()
	{
		$sql = "SELECT * FROM examples";
		$params = array();
		$results = $this->select($sql, $params);
		$examples = array();
		foreach ($results as $example) {
			$examples[] = $this->injectMeaningIntoExample($example);
		}
		return $examples;
	}
	
	private function injectMeaningIntoExample($example) {
		$meanings = $this->findAssociatedMeanings($example['id']);
		$meaningIds = array();
		foreach($meanings as $meaning) {
			$meaningIds[] = ($meaning['id']);
		}
		$example['meaningIds'] = $meaningIds;
		return $example;
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
		$sql = "INSERT INTO examples (exampleTarget, exampleBase) VALUES (?, ?)";
		$params = array(
			$exampleData['exampleTarget'],
			isset($exampleData['exampleBase']) ? $exampleData['exampleBase'] : NULL,
		);
		$id = $this->checkIfExampleExists($exampleData['exampleTarget']);
		if (!$id) {
			$id = $this->insert($sql, $params);
		}
		$this->linkExampleToMeaning($exampleData['meaningId'], $id);
		return $id;
	}
	
	protected function checkIfExampleExists($exampleTarget)
	{
		$sql = "SELECT id FROM examples WHERE exampleTarget = ?";
		return parent::checkIfExists($sql, array($exampleTarget));
	}
	
	private function linkExampleToMeaning($meaningId, $exampleId) {
		$sql = "INSERT INTO examplesToMeanings (meaningId, exampleId) VALUES (?, ?)";
		$params = array(
			$meaningId,
			$exampleId,
		);
		$id = $this->checkIfLinkExists($params);
		if (!$id) {
			$this->insert($sql, $params);
		}
		//else nothing
	}
	
	private function checkIfLinkExists($params) {
		$sql = "SELECT id FROM examplesToMeanings WHERE meaningId = ? AND exampleId = ?";
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
