<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VocabTrainer
 *
 * @author rellek
 */
class VocabTrainer extends BaseController {

    private $provider;
    private $bufferSize = 5; // this belongs in a config file #dev
    private $usedVocabIds;
    private $bufferedVocabs;
    private $currentVocab;
    private $currentVocabFails;
    private $totalFails;
    private $totalSolved;

    public function __construct() {
        $this->provider = new VocabProvider();
        $this->loadSession();
    }

    public function __destruct() {
        $this->saveSession();
    }

    public function training($guess = null) {
        if ($guess !== null) {
            $guess = $this->solveAttempt($guess);
        }
    }

    public function getNextVocab() {
        if ($this->isVocabBufferEmpty()) {
            $this->dispenseVocabs($this->bufferSize);
        }
        $this->currentVocab = array_pop($this->bufferedVocabs);
        $this->currentVocabFails = 0;
        return $this->currentVocab;
    }

    public function getCurrentVocab() {
        return $this->currentVocab;
    }

    public function check($guess="") {
        if(trim($guess)!="" && strstr(Session::get('translations'), trim($guess))!==false){
            $this->currentVocabFails = 0;
            return true;
        }
        $this->currentVocabFails++;
        return false;        
    }

    public function getNumberOfFailAttemptsForCurrentVocab() {
        return $this->currentVocabFails;
    }

    public function getNumberOfOverallFailAttempts() {
        return $this->totalFails;
    }

    public function getNumberOfOverallTotalCorrectSolutions() {
        return $this->totalSolved;
    }

    private function loadSession() {
        $this->usedVocabIds = Session::get('usedVocabIds', function() {return array();});
        $this->bufferedVocabs = Session::get('bufferedVocabs', []);
        $this->currentVocab = Session::get('currentVocab', null);
        $this->currentVocabFails = Session::get('currentVocabFails', 0);
        $this->totalFails = Session::get('totalFails', 0);
        $this->totalSolved = Session::get('totalSolved', 0);
    }

    private function saveSession() {
        Session::put('usedVocabIds', $this->usedVocabIds);
        Session::put('bufferedVocabs', $this->bufferedVocabs);
        Session::put('currentVocab', $this->currentVocab);
        Session::put('currentVocabFails', $this->currentVocabFails);
        Session::put('totalFails', $this->totalFails);
        Session::put('totalSolved', $this->totalSolved);
    }

    private function isVocabBufferEmpty() {
        return !(boolean) $this->bufferedVocabs;
    }

    public function noteSuccess() {
        $this->totalSolved++;
    }

    public function noteFail() {
        $this->totalFails++;
    }

    public function resetStats() {
        $this->getNextVocab();
        $this->totalSolved = 0;
        $this->totalFails = 0;
        $this->currentVocabFails = 0;
    }

    private function dispenseVocabs($amount) {
        $this->bufferedVocabs = $this->provider->provide($amount, (array) $this->usedVocabIds);
        foreach ($this->bufferedVocabs as $used) {
            $this->usedVocabIds[] = $used->id;
        }

    }

}
