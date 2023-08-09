@extends('adminlte::page')

@section('title', 'Home')

@section('content')
<div class="row">
    @if(true)
        @if(isset($mural) && count($mural)>0)
            <div class="col-md-12">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Mural</legend>
                    <br>
                    @foreach($mural as $conteudo)
                    @if($conteudo->nu_diasrestantes > 6)
                        <div class="box box-primary">
                    @elseif ($conteudo->nu_diasrestantes > 3)
                        <div class="box box-warning">
                    @else
                        <div class="box box-danger">
                    @endif
                            <div class="box-header with-border">
                                <h3 class="box-title"><strong>{{$conteudo->st_titulo}}</strong></h3>
                            </div>
                            <div class="box-body">
                                <p>{!!$conteudo->st_msg!!}</p>
                            </div>
                        </div>
                    @endforeach
                </fieldset>
            </div>
        @endif
    @else
        <div class="col-md-12">


        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Lista de férias que finalizam nos próximos 15 dias</legend>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-3">Nome</th>
                        <th class="col-md-2">Matícula</th>
                        <th class="col-md-2">QTD Dias</th>
                        <th class="col-md-2">Início</th>
                        <th class="col-md-2">Fim</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($feriaslicencas) && count($feriaslicencas)> 0)
                    @foreach($feriaslicencas->feriasSaindo as $fs)<!-- Array dentro de array -->
                        <tr>
                            <th>{{$fs->st_nome}}</th>
                            <th>{{$fs->st_matricula}}</th>
                            <th>{{$fs->nu_dias}}</th>
                            <th>{{\Carbon\Carbon::parse($fs->dt_inicio)->format('d/m/Y')}}</th>
                            <th>{{\Carbon\Carbon::parse($fs->dt_fim)->format('d/m/Y')}}</th>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Lista de férias que iniciam nos próximos 15 dias</legend>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-3">Nome</th>
                        <th class="col-md-2">Matícula</th>
                        <th class="col-md-2">QTD Dias</th>
                        <th class="col-md-2">Início</th>
                        <th class="col-md-2">Fim</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($feriaslicencas) && count($feriaslicencas)> 0)
                    @foreach($feriaslicencas->feriasEntrando as $fe)
                        <tr>
                            <th>{{$fe->st_nome}}</th>
                            <th>{{$fe->st_matricula}}</th>
                            <th>{{$fe->nu_dias}}</th>
                            <th>{{\Carbon\Carbon::parse($fe->dt_inicio)->format('d/m/Y')}}</th>
                            <th>{{\Carbon\Carbon::parse($fe->dt_fim)->format('d/m/Y')}}</th>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Lista de licenças que finalizam nos próximos 15 dias</legend>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-3">Nome</th>
                        <th class="col-md-2">Matícula</th>
                        <th class="col-md-2">QTD Dias</th>
                        <th class="col-md-2">Início</th>
                        <th class="col-md-2">Fim</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($feriaslicencas) && count($feriaslicencas)> 0)
                    @foreach($feriaslicencas->licencaSaindo as $ls)
                        <tr>
                            <th>{{$ls->st_nome}}</th>
                            <th>{{$ls->st_matricula}}</th>
                            <th>{{$ls->nu_dias}}</th>
                            <th>{{\Carbon\Carbon::parse($ls->dt_inicio)->format('d/m/Y')}}</th>
                            <th>{{\Carbon\Carbon::parse($ls->dt_fim)->format('d/m/Y')}}</th>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Lista de licenças que iniciam nos próximos 15 dias</legend>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-3">Nome</th>
                        <th class="col-md-2">Matícula</th>
                        <th class="col-md-2">QTD Dias</th>
                        <th class="col-md-2">Início</th>
                        <th class="col-md-2">Fim</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($feriaslicencas) && count($feriaslicencas)> 0)
                    @foreach($feriaslicencas->licencaEntrando as $le)
                        <tr>
                            <th>{{$le->st_nome}}</th>
                            <th>{{$le->st_matricula}}</th>
                            <th>{{$le->nu_dias}}</th>
                            <th>{{\Carbon\Carbon::parse($le->dt_inicio)->format('d/m/Y')}}</th>
                            <th>{{\Carbon\Carbon::parse($le->dt_fim)->format('d/m/Y')}}</th>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </fieldset>    
       
    </div>
    @endif
</div>
@stop