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

	public function readAllMeanings($targetLanguage, $baseLanguage, $userId)
	{
		$sql = "SELECT * FROM lexicon WHERE targetLanguage = ? AND baseLanguage = ? AND userid = ? ORDER BY frequency DESC, dateEntered DESC";
		$params = array(
			$targetLanguage,
			$baseLanguage,
			$userId,
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
			'id' => intval($row['meaningId']),
			'targetId' => intval($row['targetId']),
			'baseId' => intval($row['baseId']),
			'frequency' => intval($row['frequency']),
			'dateEntered' => $row['dateEntered']
		);
	}

	public function createMeaning($meaningData, $userId)
	{
		$sql = "INSERT INTO meanings (userId, targetId, baseId, frequency, dateEntered)" . 
			"VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE frequency = frequency + ?";
		$params = array(
			$userId,
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
