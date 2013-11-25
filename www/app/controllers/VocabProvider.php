<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VocabProvider
 *
 * @author rellek
 */
class VocabProvider extends BaseController {

    public function insertVocab(Vocab $vocab) {
        $vocab->save();
    }

    public function makeVocab(array $record) {
        $vocab = new Vocab;
        $vocab->word = $record['word'];
        $vocab->type = $record['type'];
        $vocab->translations = $record['translations'];
        return $vocab;
    }
    
    public function getTotalVocabNumber() {
        return Vocab::count();
    }
    
    public function provide($number, array $ignoredIds) {
        return Vocab::whereNotIn('id', $ignoredIds)->get($number);
    }
    

}
