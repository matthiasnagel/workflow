@extends('layouts.scaffold')

@section('main')

        <h1>Trainer</h1>

        @if ($result !== null)
                <p><strong>Result:</strong></p>
                <p>
                        @if ($result===false)
                                {{ '<span style="color: red;">Incorrect</span>: ' }}
                        @else
                                {{ '<span style="color: green;">Correct</span>: ' }}
                        @endif
                </p>
        @endif

        <p><strong>Vocab:</strong></p>
        

@stop