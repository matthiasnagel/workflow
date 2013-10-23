<?php

/**
 * Description of VocabDbAccess
 * @author rellek
 */
class VocabDbAccess {

    private $settings;
    private $mysql;
    private $testMode;

    public function __construct($testMode = false) {
        $this->testMode = $testMode;

        $ini = __DIR__ . '/../setup/config.ini';
        $this->settings = parse_ini_file($ini);
        if ($this->testMode) {
            $this->settings['dbName'] = $this->settings['dbName'] . '_dev';
        } else {
            $this->settings['dbName'] = $this->settings['dbName'] . '_app';
        }
        $this->connect();
    }

    public function __destruct() {
        $this->disconnect();
    }

    private function connect() {
        $this->mysql = mysqli_connect(
                $this->settings['dbHost'], $this->settings['dbUser'],
                $this->settings['dbPass'], $this->settings['dbName']
        );
    }

    private function disconnect() {
        mysqli_close($this->mysql);
    }

    public function insertVocab($vocabs) {
        foreach ($vocabs as $vocab) {
            $query = 'INSERT INTO vocab '
                    . '(word, vtype, translations) '
                    . 'VALUES'
                    . '("' . $vocab->getWord()
                    . '","' . $vocab->getType()
                    . '","' . utf8_decode(implode(", ", $vocab->getTranslations()))
                    . '")';
            mysqli_query($this->mysql, $query);
        }
        if (mysqli_errno($this->mysql)) {
            return false;
        } else {
            return true;
        }
    }

    public function getDbHandle() {
        if ($this->testMode) {
            return $this->mysql;
        } else {
            throw new Exception("This method is only available in test mode");
        }
    }
}