@extends('juntamedica::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('juntamedica.name') !!}
    </p>
@stop
