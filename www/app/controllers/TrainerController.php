<?php

class TrainerController extends BaseController {

	private $trainer;

	/**
	 * Create a trainer.
	 */
    public function __construct() {
        $this->trainer = new VocabTrainer();
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return View
	 */
	public function index()
	{

        // $data = array(
        //     'result' => $guess,
        //     'currentVocab' => $this->getNextVocab(),
        //     'currentVocabFails' => $this->getNumberOfFailAttemptsForCurrentVocab(),
        //     'overallFails' => $this->getNumberOfOverallFailAttempts(),
        //     'overallCorrect' => $this->getNumberOfOverallTotalCorrectSolutions(),
        // );
        // return View::make('trainer.index', compact('data'));

		$to = (($this->trainer->getCurrentVocab()->type=='verb')?'to ':'');

		return View::make('trainer.index', array(
			'str_vocab_word'	=> $to.$this->trainer->getCurrentVocab()->word,
			'str_vocab_type' 	=> $this->trainer->getCurrentVocab()->type,
			'str_vocab_translations' => $this->trainer->getCurrentVocab()->translations,
			'bool_result'		=> Session::get('result', false),
			'int_tries' 		=> $this->trainer->getNumberOfFailAttemptsForCurrentVocab(),
			'int_all_right'		=> $this->trainer->getNumberOfOverallTotalCorrectSolutions(),
			'int_all_wrong'		=> $this->trainer->getNumberOfOverallFailAttempts(),
		));
	}

	/**
	 * Check the value.
	 *
	 * @return Redirect
	 */
	public function check()
	{
		Session::flash('translations', $this->trainer->getCurrentVocab()->translations);

		$result = $this->trainer->check(trim(Input::get('translation')));
		if($result){
			$this->trainer->getNextVocab();
			$this->trainer->noteSuccess();
		}

		Session::flash('result', $result);
		return Redirect::to('trainer');
	}

	/**
	 * Reset stats.
	 *
	 * @return Redirect
	 */
	public function reset()
	{
		$this->trainer->resetStats();
		return Redirect::to('trainer');
	}

	/**
	 * Next vocab.
	 *
	 * @return Redirect
	 */
	public function next()
	{
		$this->trainer->getNextVocab();
		$this->trainer->noteFail();
		return Redirect::to('trainer');
	}

}