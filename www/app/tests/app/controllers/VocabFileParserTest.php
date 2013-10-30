<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VocabFileParserTest
 *
 * @author rellek
 */
class VocabFileParserTest extends TestCase {

    public function setUp() {
        parent::setUp();
        $this->parser = new VocabFileParser;
    }

    public function testParseSingleFile() {
        $file = __DIR__ . '/VocabFileParserTestFile_1.txt';
        // contains: 
        // word;noun;Wort
        // bear;noun;Wildtier, Bär, gefährliches Wesen

        $provider = new VocabProvider;
        $vocab1 = $provider->makeVocab(array(
            'word' => "word",
            'type' => "noun",
            'translations' => "Wort\n"
        ));
        $vocab2 = $provider->makeVocab(array(
            'word' => "bear",
            'type' => "noun",
            'translations' => "Wildtier, Bär, gefährliches Wesen\n"
        ));

        $this->parser->parse($file); // this is to test
        $this->assertEquals(array($vocab1, $vocab2), $this->parser->getParsed());
    }

    public function testParseMultiFiles() {
        $files = array(
            __DIR__ . '/VocabFileParserTestFile_1.txt',
            __DIR__ . '/VocabFileParserTestFile_2.txt'
        );
    }

}
