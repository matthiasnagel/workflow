<?php

class VocabException extends Exception {
    public function __construct($message, $code, $previous) {
        parent::__construct($message, $code, $previous);
    }
}
?>
