@extends('adminlte::page')
@section('title', 'Novo Plano de Férias')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="row">
            
    </div>
        <div class="panel panel-primary">
            <div class="panel-heading">Novo Plano de Férias </div>
            <div class="panel-body">
                <form role="form" method="POST" action="{{ url('rh/planoferias/enviar') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="container">
                    <div class="row">
                        <!-- Campo Ano -->
                        <div class="form-group col-md-4{{ $errors->has('st_ano') ? ' has-error' : '' }} ">
                            <label for="st_ano">Ano referência</label>
                            <input id="st_ano" type="text" class="form-control" required="true"  placeholder="Informe o ano" name="st_ano">
                            @if ($errors->has('st_ano'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_ano') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    {{-- Pega o parada de numero de turmas e usa para criar o campos de forma dinamica --}}
                    @for ($index = 1; $index <= $numeroDeTurmasMinimo; $index++)
                        <div class="row">
                            <div class="form-group col-md-1">
                                <label for="st_ano">{{$index}}ª Turma</label>
                                <!-- <input id="st_turma_1" type="text" class="form-control st_turma" required="true"  placeholder="Informe a turma" name="st_turma"> -->
                            </div>
                            <div class="form-group col-md-3">
                                <label for="st_ano">Data início do planejamento</label>
                                {{-- esse campo serve apenas para identificar a ID da turma --}}
                                <input type="hidden" name="st_turmas[{{$index}}][st_turma]" value="{{$index}}">
                                <input id="dt_inicio_{{$index}}" type="date" class="form-control dt_inicio" required="true"  name="st_turmas[{{$index}}][dt_inicio]" >
                            </div>
                            <div class="form-group col-md-2">
                                <label for="st_ano">Data fim do planejamento</label>
                                <input id="dt_fim_{{$index}}" type="date" class="form-control st_fim" required="true"name="st_turmas[{{$index}}][dt_fim]" >
                            </div>
                            
                            <div class="col-md-3 .offset-md-3">
                                <label for="st_ano">Data início do pagamento</label>
                                <input id="dt_inicio_{{$index}}" type="date" class="form-control dt_inicio" required="true"  name="st_turmas[{{$index}}][dt_iniciopagamento]" >
                            </div>
                            <div class="col-md-3 .offset-md-4">
                                <label for="st_ano">Data fim do pagamento</label>
                                <input id="dt_fim_{{$index}}" type="date" class="form-control st_fim" required="true"name="st_turmas[{{$index}}][dt_fimpagamento]" >
                            </div>
                            
                        </div>
                          
                    @endfor
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
                </div>
                </form>
        </div>
</div>


</div>
@stop
@section('css')
    <style>
        #btnNovoQuadro{
            float:right;
            margin-bottom:1%;
            margin-right:1%;
        }
    </style>
@stop