<?php
/* 
 * @author rellek
 * @note insert interactive shell here
 */

require_once 'src/VocabFileParser.php';
$parser = new VocabFileParser();
$parser->addVocabByFiles("test.txt");