<?php

namespace Lexemes\Mapper;

use Lexemes\Model\Lexeme;
use Lexemes\Model\Meaning;
use PDO;

class MeaningMapper {
	private $pdo = null;
	
	public function __construct() {
		$this->pdo = new PDO("mysql:host=localhost;dbname=myLexiconTest;charset=UTF8", "root", "PASSWORD_HERE");
	}
	
	public function getAllMeanings() {
		$stmt = $this->pdo->prepare("SELECT * FROM word_list_verbose ORDER BY frequency DESC, date_entered DESC");
		$stmt->execute();
		$meanings = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$targetLexeme = new Lexeme(
					$row['target_language'],
					$row['target_type'],
					$row['target_entry']);
			$baseLexeme = new Lexeme(
					$row['base_language'],
					$row['base_type'],
					$row['base_entry']);
			$meaning = new Meaning($targetLexeme, $baseLexeme);
			$meaning->setFrequency($row['frequency']);
			$meanings[] = $meaning;
		}		
		return $meanings;
	}
	
	public function insertMeaning(Meaning $meaning) {
		$targetid = $meaning->getTargetLexeme()->getID();
		$baseid = $meaning->getBaseLexeme()->getID();
		
		$stmt = $this->pdo->prepare("INSERT INTO meanings (userid, targetid, baseid) VALUES (1, ?, ?) ON DUPLICATE KEY UPDATE frequency = frequency + 1;");
		$stmt->bindValue(1, $targetid);
		$stmt->bindValue(2, $baseid);
		
		$stmt->execute();
	}
}