<?php

namespace Lexemes\Model;

use PDO;

class MeaningMapper {
	private $pdo = null;
	
	public function __construct($PDO) {
		$this->pdo = $PDO;
	}
	
	public function getAllMeanings($targetLanguage, $baseLanguage) {
		$stmt = $this->pdo->prepare("SELECT * FROM word_list_verbose WHERE target_language = ? AND base_language = ? ORDER BY frequency DESC, date_entered DESC");
		$stmt->bindValue(1, $targetLanguage);
		$stmt->bindValue(2, $baseLanguage);
		$stmt->execute();
		return $this->createMeaningsFromExecutedStatement($stmt);
	}
	
	public function getMeaningById($id) {
		$stmt = $this->pdo->prepare("SELECT * FROM word_list_verbose WHERE meaningid = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		return $this->createMeaningsFromExecutedStatement($stmt);
	}
	
	private function createMeaningsFromExecutedStatement($stmt) {
		$meanings = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$meanings[] = array(
				'id' => $row['meaningid'],
				'targetLexemeId' => $row['targetid'],
				'baseLexemeId' => $row['baseid'],
				'frequency' => $row['frequency'],
				'dateEntered' => $row['date_entered']
			);
		}		
		return $meanings;
	}
	
	public function insertMeaning($targetID, $baseID) {		
		$stmt = $this->pdo->prepare("INSERT INTO meanings (userid, targetid, baseid) VALUES (1, ?, ?) ON DUPLICATE KEY UPDATE frequency = frequency + 1;");
		$stmt->bindValue(1, $targetID);
		$stmt->bindValue(2, $baseID);
			
		$stmt->execute();
	}
}