<?php

namespace Lexemes\Mapper;

use Lexemes\Model\LexemeInterface;

interface LexemeMapperInterface {

	public function find($id);

	public function findAll();
	
	public function save(LexemeInterface $lexeme);
	
	public function delete(LexemeInterface $lexeme);
}
