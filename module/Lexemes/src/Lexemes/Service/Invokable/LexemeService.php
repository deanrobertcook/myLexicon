<?php

namespace Lexemes\Service\Invokable;

use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Where;

class LexemeService
{

	private $lexemeTable;

	public function __construct($lexemeTable)
	{
		$this->lexemeTable = $lexemeTable;
	}

	public function saveLexeme($lexemeData)
	{
		$this->lexemeTable->insert($lexemeData);
		$lexemeId = $this->lexemeTable->lastInsertValue;
		return $lexemeId;
	}

	public function getLexeme($id)
	{
		$predicates = array(
			new Like("id", $id),
		);
		$where = new Where($predicates);
		return $this->lexemeTable->select($where);
	}

	public function getAllLexemes($targetLanguage, $baseLanguage)
	{
		$predicates = array(
			new Like("language", $targetLanguage),
			new Like("language", $baseLanguage)
		);
		$where = new Where($predicates, PredicateSet::COMBINED_BY_OR);
		return $this->lexemeTable->select($where);
	}

}
