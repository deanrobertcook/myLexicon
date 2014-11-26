<?php

namespace Lexemes\Model;

interface LexemeInterface {
	public function getLanguage();
	
	public function getType();
	
	public function getEntry();
}