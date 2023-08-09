@extends('adminlte::page')
@section('title', 'Distribuir efetivo')
@section('content')
<div class="container">
    <form role="form" method="POST" action="{{ url('rh/planoferias/'.$ano.'/distibuirefetivo') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
        <div class="row">
            <!-- Campo Ano -->
            <div class="form-group col-md-4{{ $errors->has('ano') ? ' has-error' : '' }} ">
                <label for="ano">Ano:</label>
                <input id="ano" type="text" class="form-control" readonly required="true"  placeholder="Informe o ano" name="ano" value="{{ $ano }}">
                @if ($errors->has('ano'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_ano') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <!-- Campo Turmas -->
            <div class="form-group col-md-4{{ $errors->has('ano') ? ' has-error' : '' }} ">
            <label for="turma">Selecione a turma:</label>
            <select class="form-control" name="st_turma" required>
                <option></option>
                @foreach ($turmas as $turma)
                    <option value="{{ $turma->st_turma }}"> Turma {{ $turma->st_turma }}</option>
                @endforeach
            </select>
            </div>
        </div>

        <div class="row">
            <!-- Campo Turmas -->
            <div class='col-md-4' style='padding: 10px; background-color: lightgray; border-radius:10px'>
                <p>Baixe a <a target="_blank" href='{{ url("planilhas/padrao/planilha_generica_com_pm.xlsx")}}'><i class="fa fa-save"></i> Planilha Padrão</a>, a preencha e a envie pelo botão abaixo:</p>
                <div class="form-group col-md-4{{ $errors->has('st_efetivo') ? ' has-error' : '' }} " style='margin-bottom:20px'>
                    <label for="arquivo">Planilha:</label>
                    <input type="file" name='arquivo' id='arquivo'>
                    @if ($errors->has('st_efetivo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_efetivo') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <!-- Campo Turmas -->
                <!-- Campo Ano -->
            <div class="form-group col-md-4{{ $errors->has('st_efetivo') ? ' has-error' : '' }} ">
                <label for="st_efetivo">Ou digite as matrículas separadas por vírgula:</label>
                <textarea class="col-md-12" id="st_efetivo"  placeholder="Informe as matrículas seperadas por vírgula, sem pontos e sem espaços" 
                name="st_efetivo" rows="4"></textarea>
                @if ($errors->has('st_efetivo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_efetivo') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-4">
                    <a class="btn btn-warning" href="{{url('/rh/planoferias')}}" style='margin-right: 10px;'>
                        <i class="fa fa-arrow-left"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-fw fa-save"></i> Salvar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@stop