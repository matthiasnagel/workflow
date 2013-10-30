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
            'translations' => "Wort"
        ));
        $vocab2 = $provider->makeVocab(array(
            'word' => "bear",
            'type' => "noun",
            'translations' => "Wildtier, Bär, gefährliches Wesen"
        ));

        $this->parser->parse($file); // this is to test
        $this->assertEquals(array($vocab1, $vocab2), $this->parser->getParsed());
    }

    public function testParseMultiFiles() {
        $files = array(
            __DIR__ . '/VocabFileParserTestFile_1.txt',
            __DIR__ . '/VocabFileParserTestFile_2.txt'
        );
        // file 1 as above, file 2 contains:
        // science;noun;Wissenschaft, Naturwissenschaft, Forschung
        // walk;verb;gehen, laufen, wandern, wandeln, spazieren, spazieren gehen

        $provider = new VocabProvider;
        $vocab1 = $provider->makeVocab(array(
            'word' => "word",
            'type' => "noun",
            'translations' => "Wort"
        ));
        $vocab2 = $provider->makeVocab(array(
            'word' => "bear",
            'type' => "noun",
            'translations' => "Wildtier, Bär, gefährliches Wesen"
        ));

        $vocab3 = $provider->makeVocab(array(
            'word' => "science",
            'type' => "noun",
            'translations' => "Wissenschaft, Naturwissenschaft, Forschung"
        ));
        $vocab4 = $provider->makeVocab(array(
            'word' => "walk",
            'type' => "verb",
            'translations' => "gehen, laufen, wandern, wandeln, spazieren, "
            . "spazieren gehen"
        ));

        $this->parser->parse($files); // this is to test
        $this->assertEquals(
                array($vocab1, $vocab2, $vocab3, $vocab4), $this->parser->getParsed()
        );
    }

}
