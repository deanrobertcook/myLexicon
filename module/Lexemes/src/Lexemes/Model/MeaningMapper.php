<?php

namespace Lexemes\Model;

use PDO;

class MeaningMapper extends AbstractMapper
{

	public function readMeaning($id)
	{
		$sql = "SELECT * FROM lexicon WHERE meaningId = ?";
		$params = array(
			$id
		);
		$row = $this->select($sql, $params);
		$meaning = $this->createMeaningsFromQueryRow($row);
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
			$meanings[] = $this->createMeaningsFromQueryRow($row);
		}
		return $meanings;
	}

	private function createMeaningsFromQueryRow($row)
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
		$stmt = $this->pdo->prepare("INSERT INTO meanings (userId, targetId, baseId, frequency, dateEntered) VALUES (1, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE frequency = frequency + ?;");
		$stmt->bindValue(1, $meaningData['targetId']);
		$stmt->bindValue(2, $meaningData['baseId']);
		$stmt->bindValue(3, $meaningData['frequency']);
		$stmt->bindValue(4, $meaningData['dateEntered']);
		$stmt->bindValue(5, $meaningData['frequency']);

		$stmt->execute();
		$id = $this->pdo->lastInsertId("id"); //DOES THIS WORK IF ONLY FREQUENCY IS UPDATED???
		//Yes, yes it does
		return $id;
	}

}
