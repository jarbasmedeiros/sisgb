@extends('adminlte::page')
@section('title', 'Ficha de Reconhecimento')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div>
                    <label>Ficha de Reconhecimento dos sargentos da PM / RN</label>
                </div>
            </div>
            <div class="panel-body">
                <form id="form" class="form-contact" role="form" method="POST" action="{{url('promocao/analisarrecurso/'.$idQuadro.'/atividade/'.$idAtividade.'/policial/'.$idPolicial)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Dados do policial</legend>
                        <br />
                        <div class="form-row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-2">Graduação</th>
                                        <th class="col-xs-2">QPMP</th>
                                        <th class="col-xs-2">Matrícula</th>
                                        <th class="col-xs-2">Nº Praça </th>
                                        <th class="col-xs-2">Data de Nascimento </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    @php 
                                    dd($policialDoQuadro);
                                    @endphp
                                    <th><span class="form-control">{{$policialDoQuadro->st_postgrad}}</span></th>
                                    <th><span class="form-control">{{$policialDoQuadro->st_qpmp}}</span></th>
                                    <th><span class="form-control">{{$policialDoQuadro->st_matricula}}</span></th>
                                    <th><span class="form-control">{{$policialDoQuadro->st_numpraca}}</span></th>
                                    <th><span class="form-control">{{date('d/m/Y', strtotime($policialDoQuadro->dt_nascimento))}}</span></th>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-6">Nome</th>
                                        <th class="col-xs-4">OPM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><span class="form-control">{{$policialDoQuadro->st_policial}}</span></th>
                                        <th><span class="form-control">{{$policialDoQuadro->st_opm}}</span></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Pontuações</legend>
                        <br>
                        @php
                            $contMedalha = 0;
                            $contInstrucao = 0;
                            $contPunicao = 0;
                            $contCurso = 0;
                            $contArquivo = 0;
                        @endphp
                        @foreach($pontuacoes as $key => $pontuacao)
                            @switch($pontuacao->nu_item)
                                @case(1) <!-- Tempo como Sargento -->
                                    @if($pontuacao->nu_ordem == 1)
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="col-xs-3">1 - Tempo de Serviço nas Graduações de Sargento</th>
                                                    <th class="col-xs-4">Tempo em Meses</th>
                                                    <th>BG de Publicação</th>
                                                    <th class="col-xs-1">Aceitar</th>
                                                    <th class="col-xs-1">Homologado</th>
                                                    <th class="col-xs-1">Pontos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>{{$pontuacao->st_label}}</th>
                                                    <th class="form-inline">
                                                    @if($pontuacao->st_criterio)
                                                        Data da Promoção: <input class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" name="TEMPOSGT[st_criterio]" type="date" value="{{date('Y-m-d', strtotime($pontuacao->st_criterio))}}" required>
                                                    @else
                                                        Data da Promoção: <input class="form-control camposObrigatorios" name="TEMPOSGT[st_criterio]" type="date" required>
                                                    @endif
                                                    </th>
                                                    <th>
                                                        <input name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                                    </th>
                                                    <th>
                                                        <input type="radio" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                        <input type="radio" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="glyphicon glyphicon-ok"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="glyphicon glyphicon-remove"></span>
                                                            @endif
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                            @if(!empty($pontuacao->vl_pontos))
                                                                {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                            @endif
                                                        </span>
                                                    </th>
                                                </tr>
                                    @elseif($pontuacao->nu_ordem == 2)
                                                <tr>
                                                    <th>{{$pontuacao->st_label}}</th>
                                                    <th class="form-inline">
                                                    @if($pontuacao->st_criterio)
                                                        Data da Promoção: <input class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" name="TEMPOGRADUACAO[st_criterio]" type="date" value="{{date('Y-m-d', strtotime($pontuacao->st_criterio))}}" required>
                                                    @else
                                                        Data da Promoção: <input class="form-control camposObrigatorios" name="TEMPOGRADUACAO[st_criterio]" type="date" required>
                                                    @endif
                                                    </th>
                                                    <th>
                                                        <input name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                                    </th>
                                                    <th>
                                                        <input type="radio" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                        <input type="radio" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="glyphicon glyphicon-ok"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="glyphicon glyphicon-remove"></span>
                                                            @endif
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                            @if(!empty($pontuacao->vl_pontos))
                                                                {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                            @endif
                                                        </span>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                    @break
                                @case(2) <!-- Nota de Curso de Formacao -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="col-xs-3">2 - Nota Obtida no Último Curso de Formação ou Aperfeiçoamento</th>
                                                <th>Nota</th>
                                                <th>BG de Publicação Ata de Conclusão</th>
                                                <th class="col-xs-1">Aceitar</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                    Curso:
                                                    <select name="{{$pontuacao->st_nomeinterno}}[st_label]" class="form-control select2-container camposObrigatorios  {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="CFSD" {{($pontuacao->st_label == "CFSD") ? 'selected' : ''}}>CFSD</option>
                                                        <option value="CFC" {{($pontuacao->st_label == "CFC") ? 'selected' : ''}}>CFC</option>
                                                        <option value="CNP" {{($pontuacao->st_label == "CNP") ? 'selected' : ''}}>CNP</option>
                                                        <option value="EHS" {{($pontuacao->st_label == "EHS") ? 'selected' : ''}}>EHS</option>
                                                        <option value="CFS" {{($pontuacao->st_label == "CFS") ? 'selected' : ''}}>CFS</option>
                                                        <option value="CAS" {{($pontuacao->st_label == "CAS") ? 'selected' : ''}}>CAS</option>
                                                    </select>
                                                </th>
                                                <th class="form-inline">
                                                    <input name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="number" value="{{$pontuacao->st_criterio}}" step="0.01" min="0" max="10" required>
                                                </th>
                                                <th>
                                                    <input name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                                </th>
                                                <th>
                                                    <input type="radio" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                    <input type="radio" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        @endif
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                        @if(!empty($pontuacao->vl_pontos))
                                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @break
                                @case(3) <!-- Comportamento -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="col-xs-2">3 - Comportamento</th>
                                                <th>BG de Publicação</th>
                                                <th class="col-xs-1">Aceitar</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <select name="COMPORTAMENTO[st_criterio]" class="form-control select2-container camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option selected="selected" value="">Selecione...</option>
                                                        <option value="COMPORTAMENTOMAU" {{($pontuacao->st_criterio == "COMPORTAMENTOMAU") ? 'selected' : ''}}>Insuficiente ou Mau</option>
                                                        <option value="COMPORTAMENTOBOM" {{($pontuacao->st_criterio == "COMPORTAMENTOBOM") ? 'selected' : ''}}>Bom</option>
                                                        <option value="COMPORTAMENTOOTIMO" {{($pontuacao->st_criterio == "COMPORTAMENTOOTIMO") ? 'selected' : ''}}>Ótimo</option>
                                                        <option value="COMPORTAMENTOEXCEPCIONAL" {{($pontuacao->st_criterio == "COMPORTAMENTOEXCEPCIONAL") ? 'selected' : ''}}>Excepcional</option>
                                                    </select>
                                                </th>
                                                <th>
                                                    <input name="COMPORTAMENTO[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                                </th>
                                                <th>
                                                    <input type="radio" name="COMPORTAMENTO[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                    <input type="radio" name="COMPORTAMENTO[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="glyphicon glyphicon-ok"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="glyphicon glyphicon-remove"></span>
                                                            @endif
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                        @if(!empty($pontuacao->vl_pontos))
                                                                {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                            @endif
                                                    </span>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="col-xs-2">4 - Medalha</th>
                                                    <th>BG de Publicação da Concessão</th>
                                                    <th class="col-xs-1">Aceitar</th>
                                                    <th class="col-xs-1">Homologado</th>
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    @break
                                @case(4) <!-- Medalhas -->
                                    @php
                                        $contMedalha++;
                                    @endphp
                                        <tr id="medalha_{{$pontuacao->id}}">
                                            @if($contMedalha > 1)
                                                <th>
                                                    <select id= "medalha{{$contMedalha}}" name="MEDALHA{{$contMedalha}}[st_criterio]" class="form-control select2-container camposObrigatorios selectAdcional {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option value="" selected>Selecione...</option>
                                                        <optgroup label="Tempo">
                                                            <option value="MEDALHA10" {{($pontuacao->st_criterio == "MEDALHA10") ? 'selected' : ''}}>10 Anos</option>
                                                            <option value="MEDALHA20" {{($pontuacao->st_criterio == "MEDALHA20") ? 'selected' : ''}}>20 Anos</option>
                                                            <option value="MEDALHA30" {{($pontuacao->st_criterio == "MEDALHA30") ? 'selected' : ''}}>30 Anos</option>
                                                        </optgroup> 
                                                        <optgroup label="Condecoração Meritória">
                                                            <option value="MEDALHAMERITO1" {{($pontuacao->st_criterio == "MEDALHAMERITO1") ? 'selected' : ''}}>Medalha 1</option>
                                                            <option value="MEDALHAMERITO2" {{($pontuacao->st_criterio == "MEDALHAMERITO2") ? 'selected' : ''}}>Medalha 2</option>
                                                            <option value="MEDALHAMERITO3" {{($pontuacao->st_criterio == "MEDALHAMERITO3") ? 'selected' : ''}}>Medalha 3</option>
                                                            <option value="MEDALHAMERITO4" {{($pontuacao->st_criterio == "MEDALHAMERITO4") ? 'selected' : ''}}>Medalha 4</option>
                                                            <option value="MEDALHAMERITO5" {{($pontuacao->st_criterio == "MEDALHAMERITO5") ? 'selected' : ''}}>Medalha 5</option>
                                                            <option value="MEDALHAMERITO6" {{($pontuacao->st_criterio == "MEDALHAMERITO6") ? 'selected' : ''}}>Medalha 6</option>
                                                            <option value="MEDALHAMERITO7" {{($pontuacao->st_criterio == "MEDALHAMERITO7") ? 'selected' : ''}}>Medalha 7</option>
                                                            <option value="MEDALHAMERITO8" {{($pontuacao->st_criterio == "MEDALHAMERITO8") ? 'selected' : ''}}>Medalha 8</option>
                                                            <option value="MEDALHAMERITO9" {{($pontuacao->st_criterio == "MEDALHAMERITO9") ? 'selected' : ''}}>Medalha 9</option>
                                                            <option value="MEDALHAMERITO10" {{($pontuacao->st_criterio == "MEDALHAMERITO10") ? 'selected' : ''}}>Medalha 10</option>
                                                        </optgroup>
                                                    </select>
                                                </th>
                                            @else
                                                <th>
                                                    <select id= "medalha{{$contMedalha}}" name="MEDALHA{{$contMedalha}}[st_criterio]" class="form-control select2-container camposObrigatorios selectAdcional {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="SEMMEDALHA" {{($pontuacao->st_criterio == "SEMMEDALHA") ? 'selected' : ''}}>Sem medalha</option>
                                                        <optgroup label="Tempo">
                                                            <option value="MEDALHA10" {{($pontuacao->st_criterio == "MEDALHA10") ? 'selected' : ''}}>10 Anos</option>
                                                            <option value="MEDALHA20" {{($pontuacao->st_criterio == "MEDALHA20") ? 'selected' : ''}}>20 Anos</option>
                                                            <option value="MEDALHA30" {{($pontuacao->st_criterio == "MEDALHA30") ? 'selected' : ''}}>30 Anos</option>
                                                        </optgroup> 
                                                        <optgroup label="Condecoração Meritória">
                                                            <option value="MEDALHAMERITO1" {{($pontuacao->st_criterio == "MEDALHAMERITO1") ? 'selected' : ''}}>Medalha 1</option>
                                                            <option value="MEDALHAMERITO2" {{($pontuacao->st_criterio == "MEDALHAMERITO2") ? 'selected' : ''}}>Medalha 2</option>
                                                            <option value="MEDALHAMERITO3" {{($pontuacao->st_criterio == "MEDALHAMERITO3") ? 'selected' : ''}}>Medalha 3</option>
                                                            <option value="MEDALHAMERITO4" {{($pontuacao->st_criterio == "MEDALHAMERITO4") ? 'selected' : ''}}>Medalha 4</option>
                                                            <option value="MEDALHAMERITO5" {{($pontuacao->st_criterio == "MEDALHAMERITO5") ? 'selected' : ''}}>Medalha 5</option>
                                                            <option value="MEDALHAMERITO6" {{($pontuacao->st_criterio == "MEDALHAMERITO6") ? 'selected' : ''}}>Medalha 6</option>
                                                            <option value="MEDALHAMERITO7" {{($pontuacao->st_criterio == "MEDALHAMERITO7") ? 'selected' : ''}}>Medalha 7</option>
                                                            <option value="MEDALHAMERITO8" {{($pontuacao->st_criterio == "MEDALHAMERITO8") ? 'selected' : ''}}>Medalha 8</option>
                                                            <option value="MEDALHAMERITO9" {{($pontuacao->st_criterio == "MEDALHAMERITO9") ? 'selected' : ''}}>Medalha 9</option>
                                                            <option value="MEDALHAMERITO10" {{($pontuacao->st_criterio == "MEDALHAMERITO10") ? 'selected' : ''}}>Medalha 10</option>
                                                        </optgroup>
                                                    </select>
                                                </th>
                                            @endif
                                                <th>
                                                    <input id="bgMedalha" name="MEDALHA{{$contMedalha}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                                </th>
                                                <th>
                                                    <input type="radio" name="MEDALHA{{$contMedalha}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                    <input type="radio" name="MEDALHA{{$contMedalha}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        @endif
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                        @if(!empty($pontuacao->vl_pontos))
                                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                        @endif
                                                    </span>
                                                </th>
                                                @if($pontuacao->nu_ordem != 1)
                                                    <th class="col-md-1">
                                                        <button class="btn btn-danger" title="Remover Medalha" name="removeMedalha_{{$pontuacao->id}}" id="removeMedalha_{{$pontuacao->id}}" onclick="removeMedalha({{$pontuacao->id}})">Remover</button>
                                                    </th>
                                                @else
                                                    <th class="col-md-1">
                                                    </th>
                                                @endif
                                            </tr>
                                        @if($pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                            <!-- Fechando tabela de medalhas -->
                                                <tr id="linhaFinalMedalha">
                                                    <th>
                                                        <button class="btn btn-success" name="adicionaMedalha" id="adicionaMedalha" title="Adicionar Medalha" onclick="adicionaLinha('Medalha')" type="button">
                                                            <i class="fa fa-plus"></i> Adicionar
                                                        </button>
                                                    </th>
                                                        <th></th><th></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    @break
                                @case(5) <!-- Doacao de sangue -->
                                    <!-- Criando tabela de doacao de sangue -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="col-xs-2">5 - Doação de Sangue</th>
                                                <th>BG de Publicação</th>
                                                <th class="col-xs-1">Aceitar</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                    <select id="sangue" name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control select2-container {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="SIM" {{($pontuacao->st_criterio == "SIM") ? 'selected' : ''}}>Sim</option>
                                                        <option value="NAO" {{($pontuacao->st_criterio == "NAO") ? 'selected' : ''}}>Não</option>
                                                    </select>
                                                </th>
                                                <th>
                                                    <input id="bgSangue" name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                                </th>
                                                <th>
                                                    <input type="radio" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                    <input type="radio" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        @endif
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                        @if(!empty($pontuacao->vl_pontos))
                                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="col-xs-2">6 - Atividade de Instrutor ou Monitor</th>
                                                    <th>Carga Horária</th>
                                                    <th>Data de início</th>
                                                    <th>Data de término</th>
                                                    <th>BG de Designação</th>
                                                    <th class="col-xs-1">Aceitar</th>
                                                    <th class="col-xs-1">Homologado</th>
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    @break
                                @case(6) <!-- Atividades de Instrutor ou Monitor -->
                                    @php
                                        $contInstrucao++;
                                    @endphp
                                        <tr id="atividade_{{$pontuacao->id}}">
                                            @if($contInstrucao > 1)
                                                <th>
                                                    <select id="atividade{{$contInstrucao}}" name="INSTRUCAO{{$contInstrucao}}[st_label]" class="form-control select2-container camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="INSTRUTOR" {{($pontuacao->st_label == "INSTRUTOR") ? 'selected' : ''}}>Instrutor</option>
                                                        <option value="MONITOR" {{($pontuacao->st_label == "MONITOR") ? 'selected' : ''}}>Monitor</option>
                                                    </select>
                                                </th>
                                            @else
                                                <th>
                                                    <select id="atividade{{$contInstrucao}}" name="INSTRUCAO{{$contInstrucao}}[st_label]" class="form-control select2-container camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option value="" selected>Selecione...</option>
                                                        <option value="Sem atividade" {{($pontuacao->st_label == "Sem atividade") ? 'selected' : ''}}>Sem atividade</option>'
                                                        <option value="INSTRUTOR" {{($pontuacao->st_label == "INSTRUTOR") ? 'selected' : ''}}>Instrutor</option>
                                                        <option value="MONITOR" {{($pontuacao->st_label == "MONITOR") ? 'selected' : ''}}>Monitor</option>
                                                    </select>
                                                </th>
                                            @endif
                                            <th>
                                                <input name="INSTRUCAO{{$contInstrucao}}[st_criterio]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="number" value="{{$pontuacao->st_criterio}}" required>
                                            </th>
                                            <th>
                                                @if(!empty($pontuacao->st_campo))
                                                    <input name="INSTRUCAO{{$contInstrucao}}[st_campo1]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="date" value="{{explode(';', $pontuacao->st_campo)[0]}}" required>
                                                @else
                                                    <input name="INSTRUCAO{{$contInstrucao}}[st_campo1]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="date" value="" required>
                                                @endif
                                            </th>
                                            <th>
                                                @if(!empty($pontuacao->st_campo))
                                                    <input name="INSTRUCAO{{$contInstrucao}}[st_campo2]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="date" value="{{explode(';', $pontuacao->st_campo)[1]}}" required>
                                                @else
                                                    <input name="INSTRUCAO{{$contInstrucao}}[st_campo2]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="date" value="" required>
                                                @endif
                                            </th>
                                            <th>
                                                <input name="INSTRUCAO{{$contInstrucao}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                            </th>
                                            <th>
                                                <input type="radio" name="INSTRUCAO{{$contInstrucao}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                <input type="radio" name="INSTRUCAO{{$contInstrucao}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                            </th>
                                            <th class="text-center">
                                                @if($pontuacao->bo_pontohomologado)
                                                    @if($pontuacao->bo_pontoaceito == "1")
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    @elseif($pontuacao->bo_pontoaceito == "0")
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    @endif
                                                @endif
                                            </th>
                                            <th>
                                                <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                    @if(!empty($pontuacao->vl_pontos))
                                                        {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                    @endif
                                                </span>
                                            </th>
                                            @if($pontuacao->nu_ordem != 1)
                                                <th class="col-md-1">
                                                    <button class="btn btn-danger" title="Remover Atividade" name="removeAtividade_{{$pontuacao->id}}" id="removeAtividade_{{$pontuacao->id}}" onclick="removeAtividade({{$pontuacao->id}})">Remover</button>
                                                </th>
                                            @else
                                                <th class="col-md-1">
                                                </th>
                                            @endif
                                        </tr>
                                        @if($pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                                    <tr id="linhaFinalAtividade">
                                                        <th>
                                                            <button class="btn btn-success" name="adicionaAtividade" id="adicionaAtividade" title="Adicionar Atividade" onclick="adicionaLinha('Atividade')" type="button">
                                                                <i class="fa fa-plus"></i> Adicionar
                                                            </button>
                                                        </th><th></th><th></th><th></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    @break
                                @case(7) <!-- TAF -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="col-xs-2">7 - Teste de Condicionamento Físico</th>
                                                <th>BG de Publicação</th>
                                                <th class="col-xs-1">Aceitar</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                    Resultado: 
                                                    <select id="taf" name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control select2-container {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option selected="selected" value="">Selecione...</option>
                                                        <option value="FALTOU" {{($pontuacao->st_criterio == "FALTOU") ? 'selected' : ''}}>Faltou</option>
                                                        <option value="APTO" {{($pontuacao->st_criterio == "APTO") ? 'selected' : ''}}>Apto</option>
                                                        <option value="INAPTO" {{($pontuacao->st_criterio == "INAPTO") ? 'selected' : ''}}>Inapto</option>
                                                    </select>
                                                </th>
                                                <th>
                                                    <input id="bgTaf" name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                                </th>
                                                <th>
                                                    <input type="radio" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                    <input type="radio" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        @endif
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                        @if(!empty($pontuacao->vl_pontos))
                                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @break
                                @case(8) <!-- Curso Superior -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="col-xs-2">8 - Aprimoramento</th>
                                                <th>BG de Designação</th>
                                                <th class="col-xs-1">Aceitar</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <select id="formacao" name="FORMACAO[st_criterio]" class="form-control select2-container {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option selected="selected" value="">Selecione...</option>
                                                        <option value="SEMFORMACAO" {{($pontuacao->st_criterio == "SEMFORMACAO") ? 'selected' : ''}}>Sem formação</option>
                                                        <option value="FORMACAOGRADUADO" {{($pontuacao->st_criterio == "FORMACAOGRADUADO") ? 'selected' : ''}}>Graduação</option>
                                                        <option value="FORMACAOESPECIALISTA" {{($pontuacao->st_criterio == "FORMACAOESPECIALISTA") ? 'selected' : ''}}>Especialização</option>
                                                        <option value="FORMACAOMESTRE" {{($pontuacao->st_criterio == "FORMACAOMESTRE") ? 'selected' : ''}}>Mestrado</option>
                                                        <option value="FORMACAODOUTOR" {{($pontuacao->st_criterio == "FORMACAODOUTOR") ? 'selected' : ''}}>Doutorado</option>
                                                    </select>
                                                </th>
                                                <th>
                                                    <input id="bgFormacao" name="FORMACAO[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                                </th>
                                                <th>
                                                    <input type="radio" name="FORMACAO[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                    <input type="radio" name="FORMACAO[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        @endif
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                        @if(!empty($pontuacao->vl_pontos))
                                                                {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                            @endif
                                                    </span>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="col-xs-3">9 - Curso com Aplicabilidade à Caserna</th>
                                                    <th class="col-xs-2">Nome do curso</th>
                                                    <th>BG de Designação</th>
                                                    <th class="col-xs-1">Aceitar</th>
                                                    <th class="col-xs-1">Homologado</th>
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th class="col-md-1">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    @break
                                @case(9) <!-- Cursos com Aplicabilidade à Caserna -->
                                    @php
                                        $contCurso++;
                                    @endphp
                                        <tr id="curso_{{$pontuacao->id}}">
                                            @if($contCurso > 1)
                                                <th>
                                                    <select id="curso{{$contCurso}}" name="CURSO{{$contCurso}}[st_label]" class="form-control select2-container selectAdcional {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option selected="selected" value="">Selecione...</option>
                                                        <option value="CURSO30" {{($pontuacao->st_label == "CURSO30") ? 'selected' : ''}}>CH igual ou superior a 30h</option>
                                                        <option value="CURSO60" {{($pontuacao->st_label == "CURSO60") ? 'selected' : ''}}>CH igual ou superior a 60h</option>
                                                        <option value="CURSO100" {{($pontuacao->st_label == "CURSO100") ? 'selected' : ''}}>CH igual ou superior a 100h</option>
                                                    </select>
                                                </th>
                                            @else
                                                <th>
                                                    <select id="curso{{$contCurso}}" name="CURSO{{$contCurso}}[st_label]" class="form-control select2-container selectAdcional {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option selected="selected" value="">Selecione...</option>
                                                        <option value="Sem curso" {{($pontuacao->st_label == "Sem curso") ? 'selected' : ''}}>Sem curso</option>
                                                        <option value="CURSO30" {{($pontuacao->st_label == "CURSO30") ? 'selected' : ''}}>CH igual ou superior a 30h</option>
                                                        <option value="CURSO60" {{($pontuacao->st_label == "CURSO60") ? 'selected' : ''}}>CH igual ou superior a 60h</option>
                                                        <option value="CURSO100" {{($pontuacao->st_label == "CURSO100") ? 'selected' : ''}}>CH igual ou superior a 100h</option>
                                                    </select>
                                                </th>
                                            @endif
                                            <th>
                                                <input name="CURSO{{$contCurso}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} curso" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                            </th>
                                            <th>
                                                <input name="CURSO{{$contCurso}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} curso" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                            </th>
                                            <th>
                                                <input type="radio" name="CURSO{{$contCurso}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                <input type="radio" name="CURSO{{$contCurso}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                            </th>
                                            <th class="text-center">
                                                @if($pontuacao->bo_pontohomologado)
                                                    @if($pontuacao->bo_pontoaceito == "1")
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    @elseif($pontuacao->bo_pontoaceito == "0")
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    @endif
                                                @endif
                                            </th>
                                            <th>
                                                <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                    @if(!empty($pontuacao->vl_pontos))
                                                        {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                    @endif
                                                </span>
                                            </th>
                                            @if($pontuacao->nu_ordem != 1)
                                                <th class="col-md-1">
                                                    <button class="btn btn-danger" title="Remover Curso" name="removeCurso_{{$pontuacao->id}}" id="removeCurso_{{$pontuacao->id}}" onclick="removeCurso({{$pontuacao->id}})">Remover</button>
                                                </th>
                                            @else
                                                <th class="col-md-1">
                                                </th>
                                            @endif
                                        </tr>
                                        @if($pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                                    <tr id="linhaFinalCurso">
                                                        <th>
                                                            <button class="btn btn-success" name="adicionaCurso" id="adicionaCurso" title="Adicionar Curso" onclick="adicionaLinha('Curso')" type="button">
                                                                <i class="fa fa-plus"></i> Adicionar
                                                            </button>
                                                        </th><th></th><th></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    @break
                                @case(10) <!-- Contribuição Científica -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="col-xs-3">10 - Contribuição Científica de Caráter Técnico Profissional (Aprovada pela Diretoria de Ensino da PMRN)</th>
                                                <th>BG de Publicação</th>
                                                <th class="col-xs-1">Aceitar</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <select id="cientifico" name="CIENTIFICO[st_criterio]" class="form-control select2-container {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option selected="selected" value="">Selecione...</option>
                                                        <option value="SEMCIENTIFICO" {{($pontuacao->st_criterio == "SEMCIENTIFICO") ? 'selected' : ''}}>Sem formação superior</option>
                                                        <option value="CIENTIFICOGRADUACAO" {{($pontuacao->st_criterio == "CIENTIFICOGRADUACAO") ? 'selected' : ''}}>TCC em Graduação</option>
                                                        <option value="CIENTIFICOESPECIALIZACAO" {{($pontuacao->st_criterio == "CIENTIFICOESPECIALIZACAO") ? 'selected' : ''}}>TCC em Especialização</option>
                                                        <option value="CIENTIFICOMESTRADO" {{($pontuacao->st_criterio == "CIENTIFICOMESTRADO") ? 'selected' : ''}}>TCC em Mestrado</option>
                                                        <option value="CIENTIFICODOUTOR" {{($pontuacao->st_criterio == "CIENTIFICODOUTOR") ? 'selected' : ''}}>TCC em Doutorado</option>
                                                        <option value="CIENTIFICOARTIGO" {{($pontuacao->st_criterio == "CIENTIFICOARTIGO") ? 'selected' : ''}}>Artigo Publicado em Periódicos</option>
                                                        <option value="CIENTIFICOLIVRO" {{($pontuacao->st_criterio == "CIENTIFICOLIVRO") ? 'selected' : ''}}>Livro Publicado</option>
                                                    </select>
                                                </th>
                                                <th>
                                                    <input id="bgCientifico" name="CIENTIFICO[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                                </th>
                                                <th>
                                                    <input type="radio" name="CIENTIFICO[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                    <input type="radio" name="CIENTIFICO[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        @endif
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                        @if(!empty($pontuacao->vl_pontos))
                                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                        @endif
                                                    </span>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="col-xs-3">11 - Punições</th>
                                                <th>BG de Designação</th>
                                                <th class="col-xs-1">Aceitar</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                                <th class="col-xs-1">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    @break
                                @case(11) <!-- Punições -->
                                    @php
                                        $contPunicao++;
                                    @endphp
                                        <tr id="punicao_{{$pontuacao->id}}">
                                            @if($contPunicao > 1)
                                                <th>
                                                    <select id="punicao" name="PUNICAO{{$contPunicao}}[st_criterio]" class="form-control select2-container camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option selected="selected" value="">Selecione...</option>
                                                        <option value="REPREENSAO" {{($pontuacao->st_criterio == "REPREENSAO") ? 'selected' : ''}}>Repreensão</option>
                                                        <option value="DETENCAO" {{($pontuacao->st_criterio == "DETENCAO") ? 'selected' : ''}}>Detenção</option>
                                                        <option value="PRISAO" {{($pontuacao->st_criterio == "PRISAO") ? 'selected' : ''}}>Prisão</option>
                                                    </select>
                                                </th>
                                            @else
                                                <th>
                                                    <select id="punicao" name="PUNICAO{{$contPunicao}}[st_criterio]" class="form-control select2-container camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" required>
                                                        <option selected="selected" value="">Selecione...</option>
                                                        <option value="SEMPUNICAO" {{($pontuacao->st_criterio == "SEMPUNICAO") ? 'selected' : ''}}>Sem punição</option>
                                                        <option value="REPREENSAO" {{($pontuacao->st_criterio == "REPREENSAO") ? 'selected' : ''}}>Repreensão</option>
                                                        <option value="DETENCAO" {{($pontuacao->st_criterio == "DETENCAO") ? 'selected' : ''}}>Detenção</option>
                                                        <option value="PRISAO" {{($pontuacao->st_criterio == "PRISAO") ? 'selected' : ''}}>Prisão</option>
                                                    </select>
                                                </th>
                                            @endif
                                                <th>
                                                    <input id="bgPunicao" name="PUNICAO{{$contPunicao}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}" required>
                                                </th>
                                                <th>
                                                    <input type="radio" name="PUNICAO{{$contPunicao}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> Sim
                                                    <input type="radio" name="PUNICAO{{$contPunicao}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> Não
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        @endif
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control">
                                                        @if(!empty($pontuacao->vl_pontos))
                                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                        @endif
                                                    </span>
                                                </th>
                                                @if($pontuacao->nu_ordem != 1)
                                                    <th class="col-md-1">
                                                        <button class="btn btn-danger" title="Remover Punição" name="removePunicao_{{$pontuacao->id}}" id="removePunicao_{{$pontuacao->id}}" onclick="removePunicao({{$pontuacao->id}})">Remover</button>
                                                    </th>
                                                @else
                                                    <th>
                                                    </th>
                                                @endif
                                            </tr>
                                            @break
                                @default
                                    <h1>ERRO</h1>
                                    @break
                            @endswitch
                        @endforeach
                        <tr id="linhaFinalPunicao">
                                    <th>
                                        <button class="btn btn-success" name="adicionaPunicao" id="adicionaPunicao" title="Adicionar Punição" onclick="adicionaLinha('Punicao')" type="button">
                                            <i class="fa fa-plus"></i> Adicionar
                                        </button>
                                    </th><th></th><th></th>
                                </tr>
                            </tbody>
                        </table>
                        <div style="text-align: right;">
                            <span class="form-control total"><B>TOTAL GERAL DE PONTOS: {{collect($pontuacoes)->sum('vl_pontos')}}</B></span>
                        </div>
                        <br>
                    </fieldset>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Envio de documentos</legend>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="col-xs-4">Arquivos</th>
                                    <th>Descrição</th>
                                    <th class="col-xs-1">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($arquivos) && count($arquivos) > 0)
                                    @foreach($arquivos as $a)
                                        @php
                                            $contArquivo++;
                                        @endphp
                                        <tr id="arquivo_{{$contArquivo}}">
                                            <th>
                                            <span>
                                                <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}">{{$a->st_arquivo .'.pdf'}}</a>
                                                <input id="ARQUIVO{{$contArquivo}}[id]" type="text" class="form-control-file" name="ARQUIVO{{$contArquivo}}[id]" value="{{$a->id}}" hidden>
                                            </span>
                                            </th>
                                            <th>
                                                <input type="text" class="form-control" name="ARQUIVO{{$contArquivo}}[st_descricao]" placeholder="Digite a descrição" value="{{$a->st_descricao}}">
                                            </th>
                                            <th class="col-md-1">
                                                <button onclick="idDocumentoParaRemocao({{$a->id}}, {{$idAtividade}}, {{$a->ce_policial}})" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger">
                                                    Remover
                                                </button>
                                            </th>
                                        </tr>
                                    @endforeach
                                @else
                                    @php
                                        $contArquivo++;
                                    @endphp
                                    <tr id="arquivo_{{$contArquivo}}">
                                        <th>
                                        <span>
                                            <label for="ARQUIVO'+contadorArquivo+'[st_path]">O documento deve ser do tipo PDF e não deve exceder o tamnho de 512 KB.</label>
                                            <input id="ARQUIVO{{$contArquivo}}" type="file" class="form-control-file" name="ARQUIVO{{$contArquivo}}[st_path]" accept="application/pdf" required>
                                        </span>
                                        </th>
                                        <th>
                                            <input type="text" class="form-control" name="ARQUIVO{{$contArquivo}}[st_descricao]" placeholder="Digite a descrição" required>
                                        </th>
                                        <th></th>
                                    </tr>
                                @endif
                                <tr id="linhaFinalArquivo">
                                    <th>
                                        <button class="btn btn-success" name="adicionaArquivo" id="adicionaArquivo" title="Adicionar Arquivo" onclick="adicionaLinha('Arquivo')" type="button">
                                            <i class="fa fa-plus"></i> Adicionar Arquivo
                                        </button>
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Avaliação do recurso</legend>
                        <br>
                        <div class="form-group">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Recurso</legend>
                                <div class="form-group">
                                    <textarea name="st_recurso" disabled style="background-color: white;" class="formcontrol col-xs-12">{{$fichaPolicial->st_recurso != null?strip_tags($fichaPolicial->st_recurso):''}}</textarea>
                                </div>
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Parecer</legend>
                                <div id="parecerRecurso" class="form-group">
                                    <label class="col-xs-3">
                                        <input type="radio" name="st_parecerrecurso" value="DEFERIDO" required {{$fichaPolicial->st_parecerrecurso == "DEFERIDO"?"checked":""}}> Deferido
                                    </label>
                                    <label class="col-xs-3">
                                        <input type="radio" name="st_parecerrecurso" value="INDEFERIDO" {{$fichaPolicial->st_parecerrecurso == "INDEFERIDO"?"checked":""}}> Indeferido
                                    </label>
                                </div>
                                <br>
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Despacho</legend>
                                <div id="respostaRecurso" class="form-group">
                                    <textarea class="form-control ckeditor" rows="3" id="st_respostarecurso" name="st_respostarecurso" placeholder="Digite os recursos..." required>{{$fichaPolicial->st_respostarecurso}}</textarea>
                                </div>
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <a href="{{url('promocao/listaanalisarrecurso/'.$idQuadro.'/'.$idAtividade)}}" title="Voltar" class="btn btn-warning">
                                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                            </a>
                            <button type="submit" title="Enviar" class="btn btn-primary">
                                <span class="fa fa-save"></span> Salvar
                            </button>
                            @if(!empty($fichaPolicial->st_parecerrecurso) || !empty($fichaPolicial->st_respostarecurso))
                                <button type="button" title="Enviar" class="btn btn-primary" data-toggle="modal" data-target="#modalConfirmarRecurso">
                                    <span class="fa fa-send"></span> Avaliar
                                </button>
                            @endif
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Modal para concluir envio do recurso-->
<div class="modal fade" id="modalConfirmarRecurso" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmar o envio do recurso</h4>
            </div>
            <div class="modal-body bg-danger">
                <h4 class="modal-title">Atenção!</h4>
                <div classe>
                    Ao confirmar esta ação, não será possível alterá-lo.
                    <br><br>
                    Deseja continuar?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" title="Não" class="btn btn-warning" data-dismiss="modal">Não</button>
                <button type="button" title="Sim" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirRecurso" data-dismiss="modal">
                    Sim
                </button>
            </div>
        </div>
    </div>
</div>
<!--Modal para confirmação do envio do recurso-->
<div class="modal fade" id="modalConcluirRecurso" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Assinar o envio do recurso</h4>
            </div>
            <div class="modal-body bg-danger">
                <h4 class="modal-title">Atenção!</h4>
                <div classe>
                    É necessario assinar eletronicamente o envio do recurso.
                </div>
            </div>
            <div class="modal-body">
                <form role="form" id="concluirRecurso" method="POST">
                    {{csrf_field()}}
                    <h4>Informe a Senha:</h4>
                    <input id="password" type="password" class="form-control" name="password" value="" placeholder="Digite sua senha..." required>
                    <br>
                    <div class="modal-footer">
                        <button type="button" title="Cancelar" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                        <button type="button" title="Enviar Recurso" class="btn btn-primary" onclick="enviarRecurso({{$idQuadro}}, {{$idAtividade}}, {{$idPolicial}})">Assinar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
<style>
    table
    {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th, td 
    {
        text-align: left;
        padding: 8px;
    }
    div 
    {
        overflow-x:auto;
    }
    fieldset 
	{
		border: 1px solid #ddd !important;
		margin: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
    }
    .total
    {
        background-color:#808080;
    }
    b
    {
        color: white;
    }
</style>
@stop
@section('js')
    <script>
        // Exibir a quantidade de caracteres na tela
        var editor = CKEDITOR.replace( 'st_respostarecurso' );
        // The "change" event is fired whenever a change is made in the editor.
        editor.on( 'change', function( evt ) {
            // getData() returns CKEditor's HTML content.
            var conteudo = jQuery(evt.editor.getData()).text();
            $('#caracteres').remove();
            $('#respostaRecurso').css('border', '');
            if(conteudo.length == 1){
                $('#respostaRecurso').append(
                    '<div id="caracteres"><strong>'+conteudo.length+' Caractere.</strong></div>');
            }else if(conteudo.length <= 500){
                $('#respostaRecurso').append(
                    '<div id="caracteres"><strong>'+conteudo.length+' caracteres.</strong></div>');
            }else{
                $('#respostaRecurso').append(
                    '<div id="caracteres"><strong>'+conteudo.length+' caracteres. Atenção! A reposta ao recurso não pode exceder o tamanho de 500 caracteres.</strong></div>');
                $('#respostaRecurso').css('border', 'solid 1px red');
            }
        });
        // Função para concluir homologação da ficha
        function enviarRecurso($idQuadro, $idAtividade, $idPolicial){
            var pass = $("#password").val();
            var text = '<input id="password" type="hidden" class="form-control" name="password" value="'+pass+'" placeholder="Digite sua senha..." required>'
            // alerta o valor do campo
            $(text).insertBefore("#parecerRecurso");
            $("#form").attr("action", "{{url('promocao/finalizaanalisarrecurso')}}/"+$idQuadro+'/atividade/'+$idAtividade+'/policial/'+$idPolicial);
            $("#form").submit();
        };

        // Função para o form do modal de remover documento
        function idDocumentoParaRemocao($idArquivo, $idAtividade, $idPolicial){
            $("#removerDoc").attr("action", "{{url('promocao/escrituradaFicha/atividade')}}/"+$idAtividade+"/arquivo/"+$idArquivo+"/policial/"+$idPolicial);
        }
        function enviarFicha($idQuadro, $idAtividade, $idPolicial){
            $("#form").attr("action", "{{url('promocao/enviarFichaEscriturada')}}/"+$idQuadro+"/"+$idAtividade+"/"+$idPolicial);
        };
        // Cria um array com o valor de todos os selects com a class "selectAdcional"
        function criacaoArraySelects(){
            var s = $('.selectAdcional');
            var valuesSelects = [];
            s.each(function(){
                valuesSelects.push($(this).val());
            });
            return valuesSelects;
        }
        $(document).ready(function() {
            $("select").each(function(e) {
                var id = $(this).prop("id");
                var valor = $(this).val();
                opcao(id, valor);
            });
            valuesSelects = criacaoArraySelects();
        });
        $(document).on("change", "select", function() {
            // pega o id do elemento que está sofrendo alteração
            var id = $(this).prop("id");
            // pega o valor do elemento que está sofrendo alteração
            var valor = $(this).val();
            // Verifica se o valor está contido no array select, no caso se essa opção foi setada mais de uma vez
            if(valuesSelects.includes(valor)){
                alert("Esta opção só pode ser selecionada uma única vez!");
                $('#'+id).prop('value', '');
                $('#'+id).css('border', 'solid 1px red');
            }else{
                $('#'+id).css('border', '');
            }
            // Popula o array com as novas opções
            valuesSelects = criacaoArraySelects();
            opcao(id, valor);
        });
        function opcao(id, valor){
            switch (id) {
                case "medalha1":
                    if (valor === "SEMMEDALHA"){
                        $("#bgMedalha").removeAttr("required");
                        $('#adicionaMedalha').prop('disabled', true);
                    }else{
                        $("#bgMedalha").attr("required", true);
                        $('#adicionaMedalha').prop('disabled', false);
                    }
                    break;
                case "sangue":
                    if (valor === "NAO"){
                        $("#bgSangue").removeAttr("required");
                    }else{
                        $("#bgSangue").attr("required", true);
                    }
                    break;
                case "atividade1":
                    if (valor === "Sem atividade"){
                        $(".atividade").removeAttr("required");
                        $('#adicionaAtividade').prop('disabled', true);
                    }else{
                        $(".atividade").attr("required", true);
                        $('#adicionaAtividade').prop('disabled', false);
                    }
                    break;
                case "formacao":
                    if (valor === "SEMFORMACAO"){
                        $("#bgFormacao").removeAttr("required");
                    }else{
                        $("#bgFormacao").attr("required", true);
                    } 
                    break;
                case "curso1":
                    if (valor === "Sem curso"){
                        $(".curso").removeAttr("required");
                        $('#adicionaCurso').prop('disabled', true);
                    }else{
                        $(".curso").attr("required", true);
                        $('#adicionaCurso').prop('disabled', false);
                    } 
                    break;
                case "cientifico":
                    if (valor === "SEMCIENTIFICO"){
                        $("#bgCientifico").removeAttr("required");
                    }else{
                        $("#bgCientifico").attr("required", true);
                    }
                    break;
                case "punicao":
                    if (valor === "SEMPUNICAO"){
                        $("#bgPunicao").removeAttr("required");
                        $('#adicionaPunicao').prop('disabled', true);
                    }else{
                        $("#bgPunicao").attr("required", true);
                        $('#adicionaPunicao').prop('disabled', false);
                    }
                    break;
            }
        }

        //Funções de controle para remoção de elemento de item
        function removeMedalha(id){
            $('#medalha_'+id).remove();
        }
        function removeAtividade(id){
            $('#atividade_'+id).remove();
        }
        function removePunicao(id){
            $('#punicao_'+id).remove();
        }
        function removeCurso(id){
            $('#curso_'+id).remove();
        }
        function removeArquivo(id){
            $('#arquivo_'+id).remove();
        }
        var idFinal = "{{collect($pontuacoes)->last()->id}}";
        //Variável para controle de atividades de instrução adicionadas
        var contadorInstrucao = parseInt("{{$contInstrucao}}");
        //Variável para controle de atividades de instrução adicionadas
        var contadorMedalha = parseInt("{{$contMedalha}}");
        //Variável para controle de punições adicionadas
        var contadorPunicao = parseInt("{{$contPunicao}}");
        //Variável para controle de punições adicionadas
        var contadorCurso = parseInt("{{$contCurso}}");
        //Variável para controle de Arquivos adicionadas
        var contadorArquivo = parseInt("{{$contArquivo}}");
        
        //Função para adicionar novos elementos nos itens
        function adicionaLinha(local){
            switch(local){
                case 'Medalha':
                    contadorMedalha++;
                    var text = '<tr id="medalha_'+idFinal+'">'+
                                    '<th>'+
                                        '<select id="medalhaAdicional'+contadorMedalha+'" name="MEDALHA'+contadorMedalha+'[st_criterio]" class="form-control select2-container selectAdcional" required>'+
                                            '<option value="" selected>Selecione...</option>'+
                                            '<optgroup label="Tempo">'+
                                                '<option value="MEDALHA10">10 Anos</option>'+
                                                '<option value="MEDALHA20">20 Anos</option>'+
                                                '<option value="MEDALHA30">30 Anos</option>'+
                                            '</optgroup>'+
                                            '<optgroup label="Condecoração Meritória">'+
                                                '<option value="MEDALHAMERITO1">Medalha 1</option>'+
                                                '<option value="MEDALHAMERITO2">Medalha 2</option>'+
                                                '<option value="MEDALHAMERITO3">Medalha 3</option>'+
                                                '<option value="MEDALHAMERITO4">Medalha 4</option>'+
                                                '<option value="MEDALHAMERITO5">Medalha 5</option>'+
                                                '<option value="MEDALHAMERITO6">Medalha 6</option>'+
                                                '<option value="MEDALHAMERITO7">Medalha 7</option>'+
                                                '<option value="MEDALHAMERITO8">Medalha 8</option>'+
                                                '<option value="MEDALHAMERITO9">Medalha 9</option>'+
                                                '<option value="MEDALHAMERITO10">Medalha 10</option>'+
                                            '</optgroup>'+
                                        '</select>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input id="bgMedalhaAdicional" name="MEDALHA'+contadorMedalha+'[st_publicacao]" class="form-control" type="text" required>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input type="radio" name="MEDALHA'+contadorMedalha+'[bo_pontoaceito]"  value="1" required> Sim'+
                                        '<input type="radio" name="MEDALHA'+contadorMedalha+'[bo_pontoaceito]"  value="0"> Não'+
                                    '</th>'+
                                    '<th class="text-center">'+
                                    '</th>'+
                                    '<th>'+
                                        '<span name="MEDALHA'+contadorMedalha+'[st_valor]" class="form-control"></span>'+
                                    '<th class="col-md-1">'+
                                        '<button class="btn btn-danger" title="Remover Medalha" name="removeMedalha_'+idFinal+'" id="removeMedalha_'+idFinal+'" onclick="removeMedalha('+idFinal+')">Remover</button>'+
                                    '</th>'+
                                '</tr>';
                    $(text).insertBefore("#linhaFinalMedalha");
                    idFinal++;
                    break;
                case 'Atividade':
                    contadorInstrucao++;
                    var text = '<tr id="atividade_'+idFinal+'">'+
                                    '<th>'+
                                        '<select id="atividadeAdicional'+contadorInstrucao+'" name="INSTRUCAO'+contadorInstrucao+'[st_label]" class="form-control select2-container atividade" required>'+
                                            '<option selected>Selecione...</option>'+
                                            '<option value="INSTRUTOR">Instrutor</option>'+
                                            '<option value="MONITOR">Monitor</option>'+
                                        '</select>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input id="criterioAtividadeAdicional" name="INSTRUCAO'+contadorInstrucao+'[st_criterio]" class="form-control atividade" type="number" value="" required>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input name="INSTRUCAO'+contadorInstrucao+'[st_campo1]" class="form-control atividade" type="date" value="" required>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input name="INSTRUCAO'+contadorInstrucao+'[st_campo2]" class="form-control atividade" type="date" value="" required>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input id="bgAtividadeAdicional" name="INSTRUCAO'+contadorInstrucao+'[st_publicacao]" class="form-control atividade" type="text" required>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input type="radio" name="INSTRUCAO'+contadorInstrucao+'[bo_pontoaceito]"  value="1" required> Sim'+
                                        '<input type="radio" name="INSTRUCAO'+contadorInstrucao+'[bo_pontoaceito]"  value="0"> Não'+
                                    '</th>'+
                                    '<th class="text-center">'+
                                    '</th>'+
                                    '<th class="col-md-1">'+
                                        '<button class="btn btn-danger" title="Remover Atividade" name="removeAtividade_'+idFinal+'" id="removeAtividade_'+idFinal+'" onclick="removeAtividade('+idFinal+')">Remover</button>'+
                                    '</th>'+
                                '</tr>';
                    
                    $(text).insertBefore("#linhaFinalAtividade");
                    idFinal++;
                    break;
                case 'Punicao':
                    contadorPunicao++;
                    var text = '<tr id="punicao_'+idFinal+'">'+
                                    '<th>'+
                                        '<select id="punicaoAdicional" name="PUNICAO'+contadorPunicao+'[st_criterio]" class="form-control select2-container" required>'+
                                            '<option selected="selected" value="">Selecione...</option>'+
                                            '<option value="REPREENSAO">Repreensão</option>'+
                                            '<option value="DETENCAO">Detenção</option>'+
                                            '<option value="PRISAO">Prisão</option>'+
                                        '</select>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input id="bgPunicaoAdicional" name="PUNICAO'+contadorPunicao+'[st_publicacao]" class="form-control" type="text" required>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input type="radio" name="PUNICAO'+contadorPunicao+'[bo_pontoaceito]"  value="1" required> Sim'+
                                        '<input type="radio" name="PUNICAO'+contadorPunicao+'[bo_pontoaceito]"  value="0"> Não'+
                                    '</th>'+
                                    '<th class="text-center">'+
                                    '</th>'+
                                    '<th class="col-md-1">'+
                                        '<button class="btn btn-danger" title="Remover Punição" name="removePunicao_'+idFinal+'" id="removePunicao_'+idFinal+'" onclick="removePunicao('+idFinal+')">Remover</button>'+
                                    '</th>'+
                                '</tr>';
                    $(text).insertBefore("#linhaFinalPunicao");
                    idFinal++;
                    break;
                case 'Curso':
                    contadorCurso++;
                    var text = '<tr id="curso_'+idFinal+'">'+
                                    '<th>'+
                                        '<select id="cursoAdicional'+contadorCurso+'" name="CURSO'+contadorCurso+'[st_label]" id="CURSO" class="form-control select2-container selectAdcional" required>'+
                                            '<option selected="selected" value="">Selecione...</option>'+
                                            '<option value="CURSO30">CH igual ou superior a 30h</option>'+
                                            '<option value="CURSO60">CH igual ou superior a 60h</option>'+
                                            '<option value="CURSO100">CH igual ou superior a 100h</option>'+
                                        '</select>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input name="CURSO'+contadorCurso+'[st_criterio]" class="form-control curso" type="text" required>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input name="CURSO'+contadorCurso+'[st_publicacao]" class="form-control curso" type="text" required>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input type="radio" name="CURSO'+contadorCurso+'[bo_pontoaceito]"  value="1" required> Sim'+
                                        '<input type="radio" name="CURSO'+contadorCurso+'[bo_pontoaceito]"  value="0"> Não'+
                                    '</th>'+
                                    '<th class="text-center">'+
                                    '</th>'+
                                    '<th class="col-md-1">'+
                                        '<button class="btn btn-danger" title="Remover Curso" name="removeCurso_'+idFinal+'" id="removeCurso_'+idFinal+'" onclick="removeCurso('+idFinal+')">Remover</button>'+
                                    '</th>'+
                                '</tr>';
                    $(text).insertBefore("#linhaFinalCurso");
                    idFinal++;
                    break;
                case 'Arquivo':
                    contadorArquivo++;
                    var text = '<tr id="arquivo_'+idFinal+'">'+
                                    '<th>'+
                                        '<span>'+
                                            '<label for="ARQUIVO'+contadorArquivo+'[st_path]">O documento deve ser do tipo PDF e não deve exceder o tamnho de 512 KB.</label>'+
                                            '<input id="ARQUIVO'+contadorArquivo+'[st_path]" type="file" class="form-control-file" name="ARQUIVO'+contadorArquivo+'[st_path]" accept="application/pdf" required>'+
                                        '</span>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input type="text" class="form-control" name="ARQUIVO'+contadorArquivo+'[st_descricao]" placeholder="Digite a descrição" required>'+
                                    '</th>'+
                                    '<th class="col-md-1">'+
                                        '<button class="btn btn-danger" title="Remover Arquivo" name="removeArquivo_'+idFinal+'" id="removeArquivo_'+idFinal+'" onclick="removeArquivo('+idFinal+')">Remover</button>'+
                                    '</th>'+
                                '</tr>';
                    $(text).insertBefore("#linhaFinalArquivo");
                    idFinal++;
                    break;
            }
        }
    </script>
@stop