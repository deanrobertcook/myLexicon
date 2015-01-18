<?php

namespace Lexemes\Model;

class LexemeMapper extends AbstractMapper
{
	public function readLexeme($id)
	{
		$sql = "SELECT * FROM lexemes WHERE id = ?";
		$params = array($id);
		return $this->select($sql, $params);
	}

	public function readAllLexemes($targetLanguage, $baseLanguage)
	{
		$sql = "SELECT * FROM lexemes WHERE language = ? OR language = ?";
		$params = array(
			$targetLanguage,
			$baseLanguage
		);
		return $this->select($sql, $params);
	}
	
	public function createLexeme($lexemeData)
	{
		$sql = "INSERT INTO lexemes (language, type, entry) VALUES (?, ?, ?)";
		$params = array(
			$lexemeData['language'],
			$lexemeData['type'],
			$lexemeData['entry'],
		);
		$id = $this->checkIfLexemeExists($params);
		if (!$id) {
			$id = $this->insert($sql, $params);
		}
		return $id;
	}

	protected function checkIfLexemeExists($params)
	{
		$sql = "SELECT * FROM lexemes WHERE language = ? AND type = ? AND entry = ?";
		return parent::checkIfExists($sql, $params);
	}

	public function updateLexeme($id, $lexemeData)
	{
		$oldData = $this->readLexeme($id);
		$sql = "UPDATE lexemes SET language = ?, type = ?, entry = ? WHERE id = ?";
		$params = array(
			isset($lexemeData['language']) ? $lexemeData['language'] : $oldData['language'],
			isset($lexemeData['type']) ? $lexemeData['type'] : $oldData['type'],
			isset($lexemeData['entry']) ? $lexemeData['entry'] : $oldData['entry'],
			$id,
		);
		return $this->update($sql, $params);
	}

}
