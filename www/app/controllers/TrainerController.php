<?php

class TrainerController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(!Session::has('word') || Session::has('result')){
			$vocab = Vocab::orderBy(DB::raw('RAND()'))->first();
			Session::put('word', $vocab->word);
			Session::put('type', $vocab->type);
			Session::put('translations', trim($vocab->translations));
		}
		return View::make('trainer.index');
	}

	public function check()
	{
		$solutions = preg_split('/[, ]+/', Session::get('translations'));
		$translation = strtolower(Input::get('translation'));
		$result = FALSE;
		foreach($solutions as $solution){
			if(strtolower($solution)==$translation){ // tolerant!
				$result = TRUE;
				break;
			}
		}
		Session::flash('result', $result);
		Session::flash('solutions', Session::get('word').' = '.Session::get('translations'));
		return Redirect::to('trainer');
	}

}
