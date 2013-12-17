@extends('layouts.scaffold')

@section('main')

        <h1>Trainer</h1>

        @if (( $int_tries>0 && $bool_result==false) || $int_tries==0 && $bool_result==true )
                <h4 class="top-buffer">Result</h4>
                <p>
                @if ($bool_result==true)
                        <div class="alert alert-success" style="width: 400px; text-align: center;">Right!</div>
                        <p>Solutions: {{{ Session::get('translations') }}}</p>
                @else
                        <div class="alert alert-warning" style="width: 400px; text-align: center;">Wrong!</div>
                        <p>Try it again! Number of your tries: {{{ $int_tries }}}.</p>
                @endif
                </p>
        @endif


        <h4 class="top-buffer">Vocab</h4>
        <p><strong>{{{ $str_vocab_word }}}</strong> ({{{ $str_vocab_type }}})</p>


        <h4 class="top-buffer">Translation</h4>
        {{ Form::open(array('action' => 'TrainerController@check')) }}
        <p>
                {{ Form::text('translation', '', array('class' => 'form-control', 'style' => 'width: 400px;')) }}
        </p>
        <p>
                {{ Form::submit('Check it!', array('class' => 'btn btn-info')) }}
        </p>
        {{ Form::close() }}


        <h4 class="top-buffer">Overall Stats</h4>
        <p>
                <span>Right</span>: <strong>{{{ $int_all_right }}}</strong>
        </p>
        <p>
                <span>Wrong</span>: <strong>{{{ $int_all_wrong }}}</strong>
        </p>

        <a href="{{ URL::to('trainer/next') }}" class="btn btn-warning" style="margin-top: 30px;">Okay, give me the next vocab!</a>

        <a href="{{ URL::to('trainer/reset') }}" class="btn btn-danger" style="margin-top: 30px;">Reset Stats</a>
@stop