<?php

class TrainerController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(!Session::has('right')){
			Session::put('right', 0);
			Session::put('wrong', 0);
		}
		if(!Session::has('word') || Session::has('result')){
			$vocab = Vocab::orderBy(DB::raw('RAND()'))->first(); // rand ftw \o/
			Session::put('word', $vocab->word);
			Session::put('type', $vocab->type);

			Session::put('translations', trim($vocab->translations));
		}
		return View::make('trainer.index');
	}

	/**
	 * Check the value.
	 *
	 * @return Response
	 */
	public function check()
	{
		$solutions = preg_split('/[, ]+/', Session::get('translations'));
		$translation = Input::get('translation');
		
		$result = FALSE;
		foreach($solutions as $solution){
			if($solution==$translation){ // tolerant!
				$result = TRUE;
				break;
			}
		}

		if($result){
			$this->incrRight();
		} else {
			$this->incrWrong();
		}

		Session::flash('result', $result);
		Session::flash('solutions', Session::get('word').' = '.Session::get('translations'));

		return Redirect::to('trainer');
	}

	/**
	 * Increment right value.
	 *
	 * @return void
	 */
	private function incrRight()
	{
		$counter = (int)Session::get('right');
		return Session::put('right', ++$counter);
	}

	/**
	 * Increment false value.
	 *
	 * @return void
	 */
	private function incrWrong()
	{
		$counter = (int)Session::get('wrong');
		return Session::put('wrong', ++$counter);
	}

	/**
	 * Reset stats.
	 *
	 * @return Response
	 */
	public function resetStats()
	{
		Session::flush();
		return Redirect::to('trainer');
	}

}
