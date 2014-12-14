<?php

namespace LexemesTest\Service;

use Lexemes\Model\Lexeme;
use Lexemes\Service\LexemeService;

class LexemeServiceTest extends DBTestClass {
	
	public function getDataSet() {
		return $this->createMySQLXMLDataSet(dirname(__DIR__) . '/XMLTestData/Fixture.xml');
	}

	public function testSaveLexeme() {
		$lexemeService = new LexemeService();
		$lexeme = new Lexeme('en', 'verb', 'to buy');
		$id = $lexemeService->saveLexeme($lexeme);

		$queryTable = $this->getConnection()->createQueryTable(
				'lexemes', "SELECT language, type, entry FROM lexemes WHERE id = " . $id
		);
		$expectedTable =  $this->createXMLDataSet(dirname(__DIR__) . '/XMLTestData/Lexemes1Entry.xml')->getTable('lexemes');
		
		$this->assertTablesEqual($expectedTable, $queryTable);
	}
	
	public function testRetrieveLexemeByID() {
		$lexemeService = new LexemeService();
		
		$expectedLexeme = new Lexeme('de', 'verb', 'kaufen');
		$expectedLexeme->setID(1);
		
		$actualLexeme = $lexemeService->retrieveLexemeByID(1);

		$this->assertEquals($expectedLexeme, $actualLexeme);
	}
	
	public function testRetrieveLexemeByEntry() {
		
	}

}
