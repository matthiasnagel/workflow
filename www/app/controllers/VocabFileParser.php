<?php

/**
 * Description of VocabFileParser
 *
 * @author rellek
 */
class VocabFileParser extends BaseController {

    private $parsed;
    private $provider;

    public function parse($files) {
        $this->reset();

        if (is_array($files)) {
            foreach ($files as $file) {
                $this->parseFile($file);
            }
        } else {
            $this->parseFile($files);
        }
    }

    public function getParsed() {
        return $this->parsed;
    }

    private function reset() {
        $this->parsed = array();
        $this->provider = new VocabProvider();
    }

    private function parseFile($file) {
        $parseHandler = file($file);
        $vocabStack = array();

        foreach ($parseHandler as $parsedLine) {
            $record = explode(";", $parsedLine);
            if ($this->isRecordWellFormed($record)) {
                $sugarRecord = $this->beautifyRecord($record);
                array_push($vocabStack, $this->provider->makeVocab($sugarRecord));
            } else {
                // exception?
                echo "The line $parsedLine is not well-formed, not parsed!";
            }
        }

        //array_merge($this->parsed, $vocabStack);
        $this->parsed = array_merge($this->parsed, $vocabStack);
    }

    private function beautifyRecord($record) {
        $sugarRecord = array(
            'word' => trim($record[0]),
            'type' => trim($record[1]),
            'translations' => trim($record[2])
        );
        return $sugarRecord;
    }

    private function isRecordWellFormed($line) {
        $validTypes = array('noun', 'verb', 'adjective');
        if (!in_array($line[1], $validTypes)) {
            return false;
        }

        if (empty($line[0]) || empty($line[2])) {
            return false;
        }

        // further checks
        return true;
    }

}
