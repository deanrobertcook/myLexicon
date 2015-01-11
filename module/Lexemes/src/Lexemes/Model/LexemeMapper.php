<?php

namespace Lexemes\Model;

class LexemeMapper {
	private $pdo = null;
	
	public function __construct($PDO) {
		$this->pdo = $PDO;
	}
	
	public function getLexemeById($id) {
		$stmt = $this->pdo->prepare("SELECT * FROM lexemes WHERE id = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		$row = $stmt->fetch();
		return $this->createLexemeFromQueryRow($row);
	}
	
	public function getAllLexemes() {
		$stmt = $this->pdo->prepare("SELECT * FROM lexemes");
		$stmt->execute();
		$lexemes = array();
		while ($row = $stmt->fetch()) {
			$lexemes[] = $this->createLexemeFromQueryRow($row);
		}
		return $lexemes;
	}
	
	private function createLexemeFromQueryRow($row) {
		return array(
			'id' => $row['id'],
			'language' => $row['language'],
			'type' => $row['type'],
			'entry' => $row['entry'],
		);
	}
}