@extends('boletim::boletim.template_boletim')

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

 <!-- inicio fragmento listagem policiais-->
 @yield('fragmento_scripts')
 <!-- término fragmento listagem policiais-->