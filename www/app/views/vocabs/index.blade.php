@extends('layouts.scaffold')

@section('main')

<h1>All Vocabs</h1>

<p>{{ link_to_route('vocabs.create', 'Add new vocab') }}</p>

@if ($vocabs->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Word</th>
				<th>Type</th>
				<th>Translations</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($vocabs as $vocab)
				<tr>
					<td>{{{ $vocab->word }}}</td>
					<td>{{{ $vocab->type }}}</td>
					<td>{{{ $vocab->translations }}}</td>
                    <td>{{ link_to_route('vocabs.edit', 'Edit', array($vocab->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('vocabs.destroy', $vocab->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no vocabs
@endif

@stop
