<?php

class VocabsTableSeeder extends Seeder {

    private $parser;
    private $files = [];

    public function run() {
        $this->parser = new VocabFileParser;
        $this->gatherParsables();
        $this->parser->parse($this->files); // we can seed from more than a single file

        $vocabs = [];
        $raw = $this->parser->getParsed();

        foreach ($raw as $vocab) {
            $vocabs[] = array(
                'word' => $vocab->word, // these are orm-objects, use it as such
                'type' => $vocab->type,
                'translations' => $vocab->translations
            );
        }

        DB::table('vocabs')->delete();
        DB::table('vocabs')->insert($vocabs);
    }

    private function gatherParsables() {
        $dirHandle = opendir(app_path() . '/database/data/');
        while (($file = readdir($dirHandle)) !== false) {
            array_push($this->files, app_path() . '/database/data/' . $file);
        }
        closedir($dirHandle);
    }

}
