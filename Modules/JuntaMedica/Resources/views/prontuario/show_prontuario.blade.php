@extends('adminlte::page')

@section('title', 'Prontuário')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">PRONTUÁRIO (CR-MÉDICA)</div>
                <div class="panel-body">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Identificação do Paciente</legend>
                                <div class="form-group">
                                    <label for="st_cpf"
                                        class="col-md-2 col-md-offset-1 control-label">CPF</label>
                                    <div class="col-md-7">
                                        <input id="st_cpf" type="text" class="form-control" readonly="true"
                                            placeholder="Unidade" name="st_cpf" value="{{ $prontuario->st_cpf }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="st_matricula"
                                        class="col-md-2 col-md-offset-1 control-label">Matrícula</label>
                                    <div class="col-md-7">
                                        <input id="st_matricula" type="text" class="form-control" readonly="true"
                                            placeholder="Matrícula" name="st_matricula"
                                            value="{{ $prontuario->st_matricula }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="st_postograduacao"
                                        class="col-md-2 col-md-offset-1 control-label">Post/Grad</label>
                                    <div class="col-md-7">
                                        <input id="st_postograduacao" type="text" class="form-control" readonly="true"
                                            placeholder="Unidade" name="st_postograduacao" value="{{ $prontuario->st_postograduacao }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="st_nome" class="col-md-2 col-md-offset-1 control-label">Nome</label>

                                    <div class="col-md-7">
                                        <input id="st_nome" type="text" class="form-control" placeholder="Nome"
                                            name="st_nome" value="{{ $prontuario->st_nome }}" readonly="true"/>
                                        @if ($errors->has('st_nome'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_nome') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bo_acompanhamento" class="col-md-2 col-md-offset-1 control-label">Acompanhamento</label>
                                    <div class="col-md-7">
                                        <input id="bo_acompanhamento" type="text" class="form-control" readonly="true"
                                            placeholder="Unidade" name="bo_acompanhamento" value="{{ $prontuario->bo_acompanhamento? 'Sim': 'Não' }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="st_unidade" class="col-md-2 col-md-offset-1 control-label">Unidade</label>
                                    <div class="col-md-7">
                                        <input id="st_unidade" type="text" class="form-control" readonly="true"
                                            placeholder="Unidade" name="st_unidade" value="{{ $prontuario->st_unidade }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="st_orgao"
                                        class="col-md-2 col-md-offset-1 control-label">Orgão</label>
                                    <div class="col-md-7">
                                        <input id="st_orgao" type="text" class="form-control" readonly="true"
                                            placeholder="Unidade" name="st_orgao" value="{{ $prontuario->st_orgao }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="st_cidade"
                                        class="col-md-2 col-md-offset-1 control-label">Cidade (Residência)</label>
                                    <div class="col-md-7">
                                        <input id="st_cidade" type="text" class="form-control" readonly="true"
                                            placeholder="Unidade" name="st_cidade" value="{{ $prontuario->st_cidade }}"/>
                                            <br/>
                                    </div>
                                </div>
                                <div>
                                    <a class="btn btn-primary fa fa-refresh" href="{{route('sincronizarProntuario', ['idProntuario' => $prontuario->id, 'cpf' =>  $prontuario->st_cpf])}}"></a>
                                </div>
                                <div class="col-md-12 text-center mb-5">
                                    <a href="{{ route('imprimirPdfFichaDeEvolucao', $prontuario->id) }}" title="PDF" class="btn btn-primary" target="_blank" rel="noopener">
                                        <i class="glyphicon glyphicon-print"></i> Visualizar Ficha de Evolução
                                    </a>
                                </div>
                            </fieldset>
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Registros de Atendimentos pela Junta Médica</legend>
                                <div class="form-group ">
                                    <div class="col-md-2  col-md-offset-4"></div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th colspan="6">Lista de atedimentos registrados na CR-Médica</th>
                                                <th colspan="1">
                                                    @can('JPMS')
                                                        <a class="btn btn-primary" title="Iniciar Atendimento" href="{{url('juntamedica/atendimento/criar/preatendimento/'.$prontuario->id)}}">
                                                            <i class="glyphicon glyphicon-plus"></i> Novo atendimento
                                                        </a>
                                                    @endcan
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="col-md-1">Data</th>
                                                <th class="col-md-4">Parecer</th>
                                                <th class="col-md-2">Médico</th>
                                                <th class="col-md-1">Início</th>
                                                <th class="col-md-1">Término</th>
                                                <th class="col-md-1">Dias</th>
                                                @can('JPMS')
                                                <th class="col-md-1">AÇÕES</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($prontuario->atendimentos) && count($prontuario->atendimentos) > 0)
                                            @foreach($prontuario->atendimentos as $atendimentos)
                                            @if(empty($atendimentos->dt_retornou) && $atendimentos->dt_termino < date('Y-m-d') &&  !empty($atendimentos->dt_termino) )
                                           
                                            <tr style="color: red; font-weight: bold" data-toggle="tooltip" data-html="true" title="Retorno atrasado">
                                            @else
                                            <tr>
                                            @endif
                                           
                                                @if($atendimentos->st_parecer===null)
                                                    <td colspan="6"><span class="label label-danger">Aguardando atendimento médico</span></td>
                                                @else
                                                    <td>{{(empty($atendimentos->dt_parecer))?'': date('d/m/Y', strtotime($atendimentos->dt_parecer))}}</td>
                                                    <td class="text-left">{{$atendimentos->st_parecer}}</td>
                                                    <td class="text-left">{{$atendimentos->st_perito}}</td>
                                                    <td>{{(empty($atendimentos->dt_inicio))?'': date('d/m/Y', strtotime($atendimentos->dt_inicio))}}</td>
                                                    <td>{{(empty($atendimentos->dt_termino))?'': date('d/m/Y', strtotime($atendimentos->dt_termino))}}</td>
                                                    <td>{{$atendimentos->nu_dias}}</td>
                                                @endif
                                                @can('JPMS')
                                                <td>
                                                    <a class="btn btn-primary" title="Visualizar" href="{{url('juntamedica/atendimento/'.$atendimentos->id.'/visualizar')}}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-info" title="Retorno" href="{{url('juntamedica/atendimento/criar/preatendimento/'.$prontuario->id.'?bo_retorno=true&idAtendimento='.$atendimentos->id)}}">
                                                        <i class="fa fa-reply"></i>
                                                    </a>
                                                </td>
                                                @endcan
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <a href="javascript:history.back()" id="a-voltar" class="col-md-1 btn btn-warning" title="Voltar">
                <i class="glyphicon glyphicon-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</div>
<script src="{{asset('js/juntamedica.js') }}"></script>
@stop

@section("css")
<style>
    th, td {
        text-align: center;
    }

    label {
        margin-top: 06px;
    }

    #a-voltar {
        margin-left: 10px
    }
    .mb-5{
        margin-bottom: 5px;
    }
</style>
@stop