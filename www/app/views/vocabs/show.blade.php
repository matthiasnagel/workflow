@extends('layouts.scaffold')

@section('main')

<h1>Show Vocab</h1>

<p>{{ link_to_route('vocabs.index', 'Return to all vocabs') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Word</th>
				<th>Type</th>
				<th>Translations</th>
		</tr>
	</thead>

	<tbody>
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
	</tbody>
</table>

@stop
