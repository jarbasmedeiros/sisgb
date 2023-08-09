@extends('adminlte::page')
@section('title', 'Mapa Força')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">Mapa Força</div>
            <div class="panel-body">
            @php 
                $t_nu_previsto = 0;
                $t_nu_existente = 0;
                $t_nu_claros = 0;
                $t_nu_excedente = 0;
                $t_nu_jpms = 0;
                $t_nu_licencaespecial = 0;
                $t_nu_ferias = 0;
                $t_nu_adisposicao = 0;
                $t_nu_emcurso = 0;
                $t_nu_naforca = 0;
                $t_nu_outros = 0;
                $t_nu_aptocomrestricao = 0;
                $t_nu_pronto = 0;
            @endphp
                    
                        <table class="table table-bordered"><!--Primeira volta do for-->
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="14">QUADRO ORGANIZACIONAL - MAPA FORÇA ( {{$policial->st_unidade}} )</th>
                                    </tr>
                                    <tr class="bg-primary">
                                            <th class="col-md-3">Posto/Grad</th>
                                            <th class="col-md-3">Previsto</th>
                                            <th class="col-md-3">Existente</th>
                                            <th class="col-md-3">Claros</th>
                                            <th class="col-md-3">Excedente</th>
                                            <th class="col-md-3">JPMS</th>
                                            <th class="col-md-3">Licença Especial</th>
                                            <th class="col-md-3">Férias</th>
                                            <th class="col-md-3">À dispocição</th>
                                            <th class="col-md-3">Curso</th>
                                            <th class="col-md-3">Força Nacional</th>
                                            <th class="col-md-3">Outros Destinos</th>
                                            <th class="col-md-3">Pronto c/ Restrição</th>
                                            <th class="col-md-3">Pronto Emprego</th>
                                        </tr>
                                </thead>
                                @foreach ($vagas as $v)
                                @php 
                                    $t_nu_previsto += $v->nu_previsto;
                                    $t_nu_existente += $v->nu_existente;
                                    $t_nu_claros += $v->nu_claros;
                                    $t_nu_excedente += $v->nu_excedente;
                                    $t_nu_jpms += $v->nu_jpms;
                                    $t_nu_licencaespecial += $v->nu_licencaespecial;
                                    $t_nu_ferias += $v->nu_ferias;
                                    $t_nu_adisposicao += $v->nu_adisposicao;
                                    $t_nu_emcurso += $v->nu_emcurso;
                                    $t_nu_naforca += $v->nu_naforca;
                                    $t_nu_outros += $v->nu_outros;
                                    $t_nu_aptocomrestricao += $v->nu_aptocomrestricao;
                                    $t_nu_pronto += $v->nu_pronto;
                                @endphp
                                    <tr>
                                            <td class="text-center">{{$v->st_postograduacao}}</td>
                                            <td class="text-center">{{$v->nu_previsto}}</td>
                                            <td class="text-center">{{$v->nu_existente}}</td>
                                            <td class="text-center">{{$v->nu_claros}}</td>
                                            <td class="text-center">{{$v->nu_excedente}}</td>
                                            <td class="text-center">{{$v->nu_jpms}}</td>
                                            <td class="text-center">{{$v->nu_licencaespecial}}</td>
                                            <td class="text-center">{{$v->nu_ferias}}</td>
                                            <td class="text-center">{{$v->nu_adisposicao}}</td>
                                            <td class="text-center">{{$v->nu_emcurso}}</td>
                                            <td class="text-center">{{$v->nu_naforca}}</td>
                                            <td class="text-center">{{$v->nu_outros}}</td>
                                            <td class="text-center">{{$v->nu_aptocomrestricao}}</td>
                                            <td class="text-center">{{$v->nu_pronto}}</td>
                                    </tr>
                                @endforeach
                        
                        <tr class="bg-info">
                                            <th class="text-center">TOTAL</th>
                                            <th class="text-center">{{$t_nu_previsto}}</th>
                                            <th class="text-center">{{$t_nu_existente}}</th>
                                            <th class="text-center">{{$t_nu_claros}}</th>
                                            <th class="text-center">{{$t_nu_excedente}}</th>
                                            <th class="text-center">{{$t_nu_jpms}}</th>
                                            <th class="text-center">{{$t_nu_licencaespecial}}</th>
                                            <th class="text-center">{{$t_nu_ferias}}</th>
                                            <th class="text-center">{{$t_nu_adisposicao}}</th>
                                            <th class="text-center">{{$t_nu_emcurso}}</th>
                                            <th class="text-center">{{$t_nu_naforca}}</th>
                                            <th class="text-center">{{$t_nu_outros}}</th>
                                            <th class="text-center">{{$t_nu_aptocomrestricao}}</th>
                                            <th class="text-center">{{$t_nu_pronto}}</th>
                        </tr>
                    </table>

                            <a href="{{url('rh/mapaforcaPDF')}}" target="_blanck" class="btn btn-primary"><span class="fa fa-file-pdf-o"></span> Gerar PDF</a>
                            
                    <a href="{{url('/home')}}" class="col-md-1 btn btn-warning">
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </a>
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
    <style>
        th, input{text-align:center;}
        .foot{text-align: right;}
        a, button{margin:5px;}
    </style>
@stop