<?php

namespace Lexemes\Model;

use Lexemes\Model\Entity\Lexeme;
use Lexemes\Model\Entity\Meaning;
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
		return $this->createMeaningsArrayFromExecutedStatement($stmt);
	}
	
	private function createMeaningsArrayFromExecutedStatement($stmt) {
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
	
	public function getMeaningsForLexemeID($lexemeID) {
		$stmt = $this->pdo->prepare("SELECT * FROM word_list_verbose WHERE targetid = ?");
		$stmt->bindValue(1, $lexemeID);
		$stmt->execute();
		$meanings = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$targetLexeme = (new Lexeme(
					$row['target_language'],
					$row['target_type'],
					$row['target_entry']))->setID($row['targetid']);
			$baseLexeme = (new Lexeme(
					$row['base_language'],
					$row['base_type'],
					$row['base_entry']))->setID($row['baseid']);
			$meaning = new Meaning($targetLexeme, $baseLexeme);
			$meaning->setFrequency($row['frequency']);
			$meaning->setId($row['meaningid']);
			$meanings[] = $meaning;
		}		
		return $meanings;
	}
}