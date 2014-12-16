<?php

namespace LexemesTest\Service;

use Lexemes\Model\Lexeme;
use Lexemes\Model\Meaning;
use Lexemes\Service\MeaningService;
use LexemesTest\DBTestClass;

class MeaningServiceTest extends DBTestClass {
	public function getDataSet() {
		return $this->createMySQLXMLDataSet(__DIR__ . '/MeaningServiceFixture.xml');
	}
	
	public function testInsertMeaning() {
		$meaningService = new MeaningService();
		
		$targetLexeme = new Lexeme('de', 'verb', 'anwenden');
		$baseLexeme = new Lexeme('en', 'verb', 'to apply');
		$meaning = new Meaning($targetLexeme, $baseLexeme);
		$meaningService->saveMeaning($meaning);
		
		$queryTable = $this->getConnection()->createQueryTable(
				'word_list_verbose', "SELECT userid, frequency, targetid, target_language, target_type, target_entry, baseid, base_language, base_type, base_entry FROM word_list_verbose WHERE meaningid = 2"
		);
		$expectedTable =  $this->createXMLDataSet(__DIR__ . '/WordList1Entry.xml')->getTable('word_list_verbose');
		
		$this->assertTablesEqual($expectedTable, $queryTable);
		
	}
	
	public function testFindMeaningsForLexeme() {
		$meaningService = new MeaningService();
		
		$lexemeID = 1;
		$expectedMeanings = array(
			(new Meaning(
					(new Lexeme('de', 'verb', 'kaufen'))->setID(1),
					(new Lexeme('en', 'verb', 'to buy'))->setID(2)
			))->setFrequency(1));
		
		$actualMeanings = $meaningService->findMeaningsForLexeme($lexemeID);
		$this->assertEquals($expectedMeanings, $actualMeanings);
	}
	
	public function testFindAllMeanings() {
		$meaningService = new MeaningService();
		
		$expectedMeanings = array(
			(new Meaning(
					(new Lexeme('de', 'verb', 'kaufen'))->setID(1),
					(new Lexeme('en', 'verb', 'to buy'))->setID(2)
			))->setFrequency(1));
		
		$actualMeanings = $meaningService->findAllMeanings();
		$this->assertEquals($expectedMeanings, $actualMeanings);
	}		
}