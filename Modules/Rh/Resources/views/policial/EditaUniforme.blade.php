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
@endsection

@extends('rh::policial.Form_edita_policial')

@section('title', 'SISGP - Uniformes')

@section('tabcontent')
<div class="tab-pane active" id="uniformes">
    <h4 class="tab-title">Uniformes - {{ $policial->st_nome }}</h4>
    <hr class="separador">
    @include('rh::policial/FormEditaUniforme')
</div>
@endsection
