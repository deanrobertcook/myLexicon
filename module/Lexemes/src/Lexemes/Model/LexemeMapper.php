<?php

namespace Lexemes\Model;

class LexemeMapper
{

	private $pdo = null;

	public function __construct($PDO)
	{
		$this->pdo = $PDO;
	}

	public function getLexemeById($id)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM lexemes WHERE id = ?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		$row = $stmt->fetch();
		return $this->createLexemeFromQueryRow($row);
	}

	public function getAllLexemes($targetLanguage, $baseLanguage)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM lexemes WHERE language = ? OR language = ?");
		$stmt->bindValue(1, $targetLanguage);
		$stmt->bindValue(2, $baseLanguage);
		$stmt->execute();
		$lexemes = array();
		while ($row = $stmt->fetch()) {
			$lexemes[] = $this->createLexemeFromQueryRow($row);
		}
		return $lexemes;
	}

	private function createLexemeFromQueryRow($row)
	{
		return array(
			'id' => $row['id'],
			'language' => $row['language'],
			'type' => $row['type'],
			'entry' => $row['entry'],
		);
	}

	public function saveLexeme($lexemeData)
	{
		
		$id = $this->checkIfLexemeExists($lexemeData['language'], $lexemeData['type'], $lexemeData['entry']);
		if ($id == NULL) {
			$stmt = $this->pdo->prepare("INSERT INTO lexemes (language, type, entry) VALUES (?, ?, ?)");
			$stmt->bindValue(1, $lexemeData['language']);
			$stmt->bindValue(2, $lexemeData['type']);
			$stmt->bindValue(3, $lexemeData['entry']);

			$stmt->execute();
			$id = $this->pdo->lastInsertId("id");
		}
		return $id;
	}

	public function checkIfLexemeExists($language, $type, $entry)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM lexemes WHERE language = ? AND type = ? AND entry = ?");
		$stmt->bindValue(1, $language);
		$stmt->bindValue(2, $type);
		$stmt->bindValue(3, $entry);
		$stmt->execute();
		$row = $stmt->fetch();
		return $row['id'];
	}

}
