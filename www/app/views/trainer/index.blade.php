@extends('layouts.scaffold')

@section('main')

	<h1>Trainer</h1>

	@if (Session::has('result'))
		<p><strong>Result:</strong></p>
		<p>
			@if (Session::get('result')==FALSE)
				{{ '<span style="color: red;">Wrong</span>: '.Session::get('solutions') }}
			@else
				{{ '<span style="color: green;">Right</span>: '.Session::get('solutions') }}
			@endif
		</p>
	@endif

	<p><strong>Vocab:</strong></p>
	<p>{{ Session::get('word') }} ({{ Session::get('type') }})</p>

	{{ Form::open(array('action' => 'TrainerController@check')) }}
		<ul>
	        <li>
	            {{ Form::label('translation', 'Translation:') }}
	            {{ Form::text('translation') }}
	        </li>
			<li>
				{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
			</li>
		</ul>
	{{ Form::close() }}

	<p><span style="color: green;">Right</span>: {{ Session::get('right') }}</p>
	<p><span style="color: red;">Wrong</span>: {{ Session::get('wrong') }}</p>
	<br>
	<a href="{{ URL::to('trainer/reset') }}">Reset stats</a>

@stop
