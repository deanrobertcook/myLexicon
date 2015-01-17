<?php

namespace Lexemes\Model;

use PDO;

class MeaningMapper
{

	private $pdo = null;

	public function __construct($PDO)
	{
		$this->pdo = $PDO;
	}

	public function readAllMeanings($targetLanguage, $baseLanguage)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM lexicon WHERE targetLanguage = ? AND baseLanguage = ? ORDER BY frequency DESC, dateEntered DESC");
		$stmt->bindValue(1, $targetLanguage);
		$stmt->bindValue(2, $baseLanguage);
		$stmt->execute();
		$meanings = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$meanings[] = $this->createMeaningsFromQueryRow($row);
		}
		return $meanings;
	}

	public function readMeaning($id)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM lexicon WHERE meaningId = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		return $this->createMeaningsFromQueryRow($stmt->fetch(PDO::FETCH_ASSOC));
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
