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
	
	public function getAllMeanings() {
		$stmt = $this->pdo->prepare("SELECT * FROM word_list_verbose ORDER BY frequency DESC, date_entered DESC");
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