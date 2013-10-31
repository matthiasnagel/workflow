<?php

class VocabsController extends BaseController {

	/**
	 * Vocab Repository
	 *
	 * @var Vocab
	 */
	protected $vocab;

	public function __construct(Vocab $vocab)
	{
		$this->vocab = $vocab;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$vocabs = $this->vocab->all();

		return View::make('vocabs.index', compact('vocabs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('vocabs.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Vocab::$rules);

		if ($validation->passes())
		{
			$this->vocab->create($input);

			return Redirect::route('vocabs.index');
		}

		return Redirect::route('vocabs.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$vocab = $this->vocab->findOrFail($id);

		return View::make('vocabs.show', compact('vocab'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$vocab = $this->vocab->find($id);

		if (is_null($vocab))
		{
			return Redirect::route('vocabs.index');
		}

		return View::make('vocabs.edit', compact('vocab'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Vocab::$rules);

		if ($validation->passes())
		{
			$vocab = $this->vocab->find($id);
			$vocab->update($input);

			return Redirect::route('vocabs.show', $id);
		}

		return Redirect::route('vocabs.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->vocab->find($id)->delete();

		return Redirect::route('vocabs.index');
	}

}
