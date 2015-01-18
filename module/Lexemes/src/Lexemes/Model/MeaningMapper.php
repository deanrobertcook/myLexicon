<?php

namespace Lexemes\Model;

class MeaningMapper extends AbstractMapper
{

	public function readMeaning($id)
	{
		$sql = "SELECT * FROM lexicon WHERE meaningId = ?";
		$params = array(
			$id
		);
		$row = $this->select($sql, $params);
		$meaning = $this->mapMeaningFromLexiconView($row);
		return $meaning;
		
	}

	public function readAllMeanings($targetLanguage, $baseLanguage)
	{
		$sql = "SELECT * FROM lexicon WHERE targetLanguage = ? AND baseLanguage = ? ORDER BY frequency DESC, dateEntered DESC";
		$params = array(
			$targetLanguage,
			$baseLanguage
		);
		$rows = $this->select($sql, $params);
		$meanings = [];
		foreach ($rows as $row) {
			$meanings[] = $this->mapMeaningFromLexiconView($row);
		}
		return $meanings;
	}

	private function mapMeaningFromLexiconView($row)
	{
		return array(
			'id' => $row['meaningId'],
			'targetId' => $row['targetId'],
			'baseId' => $row['baseId'],
			'frequency' => $row['frequency'],
			'dateEntered' => $row['dateEntered']
		);
	}

	public function createMeaning($meaningData)
	{
		$sql = "INSERT INTO meanings (userId, targetId, baseId, frequency, dateEntered)" . 
			"VALUES (1, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE frequency = frequency + ?";
		$params = array(
			$meaningData['targetId'],
			$meaningData['baseId'],
			$meaningData['frequency'],
			$meaningData['dateEntered'],
			$meaningData['frequency'],
		);
		
		$id = $this->insert($sql, $params);
		return $id;
	}

}
