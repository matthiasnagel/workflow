<?php

/**
 * Description of Vocab
 *
 * @author rellek
 */
class Vocab {

    private $id, $word, $type, $translations;

    public function __construct($word, $type, $translations, $id = null) {
        $this->word = $word;
        $this->type = $type;
        $this->translations = $translations;
        $this->id = $id;
    }

    public function getId() {
        if ($this->id === null) {
            require_once 'VocabException.php';
            throw new VocabException('Id not set for this Vocab!');
        } else {
            return $this->id;
        }
    }

    public function getWord() {
        return $this->word;
    }

    public function getType() {
        return $this->type;
    }

    public function getTranslations() {
        return $this->translations;
    }

}
