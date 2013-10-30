<?php

/**
 * Description of VocabProviderTest
 *
 * @author rellek
 */
class VocabProviderTest extends TestCase {

    protected $vocabProvider;
    protected $vocab;

    public function setUp() {
        parent::setUp();
        $this->vocabProvider = new VocabProvider;

        $record = array(
            'word' => "working",
            'type' => "noun",
            'translations' => "Arbeiten, Arbeit, Bearbeitung, Betrieb, Handhabung"
        );
        $this->vocab = $this->vocabProvider->makeVocab($record);
    }

    public function testMakeVocab() {
        $this->assertEquals("working", $this->vocab->word);
        $this->assertEquals("noun", $this->vocab->type);
        $this->assertStringEndsWith(", Handhabung", $this->vocab->translations);
    }

    public function testInsertVocab() {
        $this->vocab->save(); // this is to test
        $inDb = Vocab::where('word', '=', 'working')->get();
        // we expect 1 item -> 0th item in result.
        $vocab = $inDb[0];
        $this->assertEquals($this->vocab->type, $vocab->type);
        $this->assertEquals($this->vocab->translations, $vocab->translations);
        // if test was successful, just delete the entry
        $inDb[0]->delete();
    }

}
