@extends('adminlte::page')

@section('title', 'Meus Fardamentos')

@section('css')
<style>
    h4 { margin-left: 15px; }
    fieldset { margin: 15px; }
    #voltar, #salvar { margin-left: 30px; 
                       margin-bottom: 15px; }
    .mt5 {margin-top: 5px;}
    .m5 {margin: 5px 0px;}
    .centraliza-texto {text-align: center;}
    th, td { text-align: center; }
    .borda{border: 1px solid #B0C4DE;}
    .center
    {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@stop

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">Meus Fardamentos</div>
            <h4 class="tab-title">Nome: {{ $policial->st_nome }}</h4>
            <h4 class="tab-title">Matrícula: {{ $policial->st_matricula }}</h4>
            <hr class="separador">
            @include('rh::policial/FormEditaUniforme')
        </div>
    </div>
</div>

@stop 

