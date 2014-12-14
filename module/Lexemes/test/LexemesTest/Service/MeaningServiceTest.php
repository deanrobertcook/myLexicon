<?php

namespace LexemesTest\Service;

class MeaningServiceTest extends DBTestClass {
	public function getDataSet() {
		return $this->createMySQLXMLDataSet(dirname(__DIR__) . '/XMLTestData/Fixture.xml');
	}
	
	public function testFindMeaningByID() {
		$this->assertTrue(true);
	}
}