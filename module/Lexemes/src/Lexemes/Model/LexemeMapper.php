<?php

namespace Lexemes\Model;

use Lexemes\Model\Entity\Lexeme;
use PDO;


class LexemeMapper {
	private $pdo = null;
	
	public function __construct() {
		$this->pdo = new PDO("mysql:host=localhost;dbname=myLexiconTest;charset=UTF8", "root", "PW");
	}
	
	public function insert(Lexeme $lexeme) {
		$language = $lexeme->getLanguage();
		$type = $lexeme->getType();
		$entry = $lexeme->getEntry();
		
		$id = $this->findWithEntryAndType($entry, $type);
		if ($id == NULL) {
			$stmt = $this->pdo->prepare("INSERT INTO lexemes (language, type, entry) VALUES (?, ?, ?)");
			$stmt->bindValue(1, $language);
			$stmt->bindValue(2, $type);
			$stmt->bindValue(3, $entry);
			
			$stmt->execute();
			$id = $this->pdo->lastInsertId("id");
		}
		
		$lexeme->setID($id);		
	}
	
	public function findWithEntryAndType($entry, $type) {
		$stmt = $this->pdo->prepare("SELECT * FROM lexemes WHERE entry = ? AND type = ?");
		$stmt->bindValue(1, $entry);
		$stmt->bindValue(2, $type);
		$stmt->execute();
		$row = $stmt->fetch();
		return $row['id'];
	}
	
	public function findWithID($id) {
		$stmt = $this->pdo->prepare("SELECT * FROM lexemes WHERE id = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		$row = $stmt->fetch();
		$lexeme = new Lexeme($row['language'], $row['type'], $row['entry']);
		$lexeme->setID($row['id']);
		return $lexeme;
	}
}