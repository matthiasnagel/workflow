<?php

class VocabTest extends TestCase {

	public function setUp() {
	}

    public function testDummy() {
        $this->assertTrue((boolean) 1);
    }

	private function prepareForTests(){
		Artisan::call('migrate');
	}

}
