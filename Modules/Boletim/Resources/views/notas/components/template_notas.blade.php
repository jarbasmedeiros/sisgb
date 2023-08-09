@extends('adminlte::page')

@section('css')
    <link href="{{ asset('assets/css/layout.css') }}" rel="stylesheet">
@stop

@section('content')
    @yield('content_dinamic')
@stop

@section('js')
    <!-- Java script para o modulo boletim -->
    <script src="{{ asset('js/notas.js') }}"></script>
   
   
<!--     @stack('js_boletim')
    @yield('js_boletim') -->
    <!-- inicio fragmento scritps-->
    @yield('fragmento_scripts')
    <!-- término fragmento scripts-->
@stop


@php 
    use app\utis\Funcoes;
@endphp
@section('title', 'Elaborar Nota')

 <!-- inicio fragmento listagem policiais-->
 @section('fragmento_infomacoes_nota')
 <!-- término fragmento listagem policiais-->

    <!-- inicio fragmento listagem policiais-->
    @yield('fragmento_infomacoes_nota')
    <!-- término fragmento listagem policiais-->
    
    <!-- inicio fragmento listagem policiais-->
    @yield('fragmento_policias_notas')
    <!-- término fragmento listagem policiais-->

 <!-- inicio fragmento listagem policiais-->
 @yield('fragmento_modais')
 <!-- término fragmento listagem policiais-->

