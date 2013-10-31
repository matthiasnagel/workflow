@extends('layouts.scaffold')

@section('main')

<h1>Edit Vocab</h1>
{{ Form::model($vocab, array('method' => 'PATCH', 'route' => array('vocabs.update', $vocab->id))) }}
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
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('vocabs.show', 'Cancel', $vocab->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
