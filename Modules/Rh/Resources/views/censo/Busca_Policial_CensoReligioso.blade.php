@extends('adminlte::page')
@section('title', 'SISGP - Censo Religioso')
@section('content')

<div class="tab-pane active" id="novo_policial">
    <h4 class="tab-title">Censo Religioso</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('rh/religiao/censosgtdiante') }}" >
    {{ csrf_field() }}
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Informe a Sua Religião</legend>
            <div class="row">
                <div class="form-group col-md-3">
                    <br>
                    <label for="busca">Busque o Policial:</label>
                    <input type="text" class='form-control' name='busca' id='busca' required>
                </div>
            </div>
        </fieldset>
        <div class="form-group">
            <div class="col-md-4">
                <a class="btn btn-warning" href="{{url('/')}}" style='margin-right: 10px;'>
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-fw fa-save"></i> Buscar
                </button>
            </div>
        </div>
    </form>
</div>
@endsection