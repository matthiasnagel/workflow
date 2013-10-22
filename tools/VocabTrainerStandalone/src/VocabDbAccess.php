<?php

/**
 * Description of VocabDbAccess
 *
 * @author rellek
 */
class VocabDbAccess {

    private $settings;
    private $mysql;

    public function __construct() {
        $ini = __DIR__ . '/../setup/config.ini';
        $this->settings = parse_ini_file($ini);
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
        return $this->mysql;
    }

}
