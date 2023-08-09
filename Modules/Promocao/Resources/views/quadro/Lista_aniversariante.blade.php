@extends('adminlte::page')

@section('title', 'Lista de Aniversariantes')
@can('Edita')
@section('content_header')
<div class="row">
    <div class="col-md-12">
        <form id="filtroListaFerias" class="form-inline pull-left" role="form" method="POST" action='{{ url("/rh/servidor/aniversarios/listagem") }}'>
            {{csrf_field()}}
            <div class="form-group">
                <select id="mes" name="mes" required="true" class="form-control">
                    <option value="">Selecione o Mês</option>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>
        <form class="form-inline pull-right" role="form" method="POST" action='{{ url("/rh/servidor/aniversarios/pdf") }}'>
            {{csrf_field()}}
            <div class="form-group">
                <input type="hidden" id="mesImpressao" name="mes" value="{{$mes}}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-print"></i>Imprimir Lista</button>                            
            </div>
        </form>
    </div>
</div>

@stop
@endcan

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan="5">{{$titulo}}</th>                      
                    </tr>
                    <tr>
                        <th class="col-md-1">POSTO/GRAD.</th>
                        <th class="col-md-5">NOME</th>
                        <th class="col-md-3">SETOR</th>
                        <th class="col-md-1">DIA</th>
                        <th class="col-md-1">MÊS</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($an))
                        @foreach($an as $a)
                        <tr>
                            <th>{{$a->st_postograduacao}}</th>
                            <th>{{$a->st_nome}}</th>
                            <th>{{$a->st_sigla}}</th>
                            <th>{{$a->dia}}</th>
                            <th>{{$a->mes}}</th>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop