@extends('layout')

@section('content')
    @foreach($vocabs as $vocab)
        <p>{{ $vocab->word }}</p>
    @endforeach
@stop