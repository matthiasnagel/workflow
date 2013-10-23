<?php

/**
 * Description of VocabFileParser
 *
 * @author rellek
 */
class VocabFileParser {

    private $dbHandler;

    public function __construct($testMode = false) {
        require_once 'VocabDbAccess.php';
        $this->dbHandler = new VocabDbAccess($testMode);
    }

    public function addVocabByFiles($files) {
        if (is_array($files)) {
            foreach ($files as $file) {
                $this->parseFile($file);
            }
        } else {
            $this->parseFile($files);
        }
    }

    private function parseFile($file) {
        $parseHandler = file($file);
        $vocabStack = array();

        foreach ($parseHandler as $parsedLine) {
            $lineAsAnArray = explode(";", $parsedLine);
            if ($this->isLineArrayWellFormed($lineAsAnArray)) {
                array_push($vocabStack, $this->makeVocab($lineAsAnArray));
            }
        }
        
        $this->dbHandler->insertVocab($vocabStack);
    }

    private function isLineArrayWellFormed($line) {
        $validTypes = array('noun', 'verb', 'adjective');
        if (!in_array($line[1], $validTypes)) {
            return false;
        }

        if (empty($line[0]) || empty($line[2])) {
            return false;
        }
            
        // further checks in private methods
        return true;
    }
    
    private function makeVocab($line) {
        require_once 'Vocab.php';
        return new Vocab($line[0], $line[1], explode(', ', $line[2]));
    }
}