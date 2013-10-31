@extends('layouts.scaffold')

@section('main')

<h1>Create Vocab</h1>

{{ Form::open(array('route' => 'vocabs.store')) }}
	<ul>
        <li>
            {{ Form::label('word', 'Word:') }}
            {{ Form::text('word') }}
        </li>

        <li>
            {{ Form::label('type', 'Type:') }}
            {{ Form::text('type') }}
        </li>

        <li>
            {{ Form::label('translations', 'Translations:') }}
            {{ Form::textarea('translations') }}
        </li>

		<li>
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


