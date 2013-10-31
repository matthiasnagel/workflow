<?php

class VocabsTableSeeder extends Seeder {

	private $parser;
	private $file;

	public function run()
	{
		$this->parser = new VocabFileParser;
		$this->file = app_path().'/database/data/data.txt';
		$this->parser->parse($this->file);

		$vocabs = [];
		$raw = $this->parser->parsed;

		foreach($raw as $vocab){
			$vocabs[] = array(
				'word' => $vocab['word'],
				'type' => $vocab['type'],
				'translations' => $vocab['translations']	
			);
		}

		DB::table('vocabs')->delete();
		DB::table('vocabs')->insert($vocabs);
	}

}
