@extends('adminlte::page')
@section('title', 'Homologar Ficha de Reconhecimento')
@section('content')

@php
//dd($ficha);
    if (isset($ficha->st_pendenciaficha) && !empty($ficha->st_pendenciaficha)) {
        $pendencias = explode(";", $ficha->st_pendenciaficha);
    } else {
        $pendencias = [];
    }

@endphp
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div>
                    <label>Homologar Ficha de Reconhecimento </label>
                </div>
            </div>
            <div class="panel-body">
                <form id="form" class="form-contact" role="form" method="POST" action="{{url('promocao/homologarfichareconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial)}}">
                    {{csrf_field()}}
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Dados do Policial</legend>
                        <br /> 
                        <div class="form-row">
                            <div class="form-group col-xs-2">
                                <label>Graduação:</label>
                                <span class="form-control" disabled>{{$policialDoQuadro->st_postgrad}}</span>
                            </div>
                           
                            <div class="form-group col-xs-2">
                                <label>QPMP:</label>
                                <span class="form-control" disabled>{{$policialDoQuadro->st_qpmp}}</span>
                            </div>
                            <div class="form-group col-xs-2">
                                <label>Matrícula:</label>
                                <span class="form-control" disabled>{{$policialDoQuadro->st_matricula}}</span>
                            </div>
                           
                            <div class="form-group col-xs-2">
                                <label>Nº Praça:</label>
                                <span class="form-control" disabled>{{$policialDoQuadro->st_numpraca}}</span>
                            </div>
                            <div class="form-group col-xs-2">
                                <label>Data de Nascimento:</label>
                                <span class="form-control" disabled>{{date('d/m/Y', strtotime($policialDoQuadro->dt_nascimento))}}</span>
                            </div>
                            <div class="form-group col-xs-6">
                                <label>Nome:</label>
                                <span class="form-control" disabled>{{$policialDoQuadro->st_policial}}</span>
                            </div>
                            <div class="form-group col-xs-6">
                                <label>OPM:</label>
                                <span class="form-control" disabled>{{$policialDoQuadro->st_unidade}}</span>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Dados da(s) Ficha(s)</legend>
                        <br />
                        <div class="form-row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-2">Ficha</th>
                                        <th class="col-xs-2">Pontuação enviada</th>
                                        <th class="col-xs-2">Pontuação válida</th>
                                        <th class="col-xs-2">Ação </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($policialDoQuadro->fichas as $key => $fichaDoPm)
                                        <tr>
                                           
                                             <th><span class="form-control" disabled>{{$fichaDoPm->st_ficha}}</span></th>
                                            <th><span class="form-control" disabled>{{$fichaDoPm->vl_pontosdaficha}}</span></th>
                                            <th><span class="form-control" disabled>{{$fichaDoPm->vl_pontosvalidosdaficha}}</span></th> 
                                            <th>
                                                <a href="{{url('promocao/homologarfichareconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/'.$competencia.'/ficha/'.$fichaDoPm->id)}}" title="Acessar Ficha" class="btn btn-primary">
                                                    <span class="fa fa-file-o"></span> Ficha {{$fichaDoPm->st_ficha}} 

                                                </a> 
                                                <a href="{{url('promocao/visualizarpdffichadereconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/'.$competencia.'/ficha/'.$fichaDoPm->id)}}" title="Visualizar PDF" class="btn btn-primary" target="_blank">
                                                    <span class="fa fa-file-pdf-o"></span> Visualizar PDF
                                                </a>
                                                <!-- TODO - REFATORAR a blade para desabilitar os campos da ficha quando o qa estiver fechado ou conforme o período de escrituração/recurso -->
                                            </th>
                                        </tr>
                                       
                                    @endforeach
                                    
                                </tbody>
                                
                            </table>
                            @if(empty(Request::segment(9))) 
                            <p style="color:red; font-weight: bold;">Selecione uma das fichas disponíveis de homologação</p>
                            @endif
                            <input name="ce_ficha"  type="hidden" value="{{Request::segment(9)}}">
                        </div>
                    </fieldset>
                    @php
                        $contMedalha = 0;
                        $contInstrucao = 0;
                        $contPunicao = 0;
                        $contCurso = 0;
                        $cabecalhosArray = [];
                    @endphp
                    @if(!empty(Request::segment(9))) 
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Pontuações da ficha {{$ficha->st_ficha}}</legend>
                        <br>
                        @foreach($pontuacoes as $key => $pontuacao)

                            @php 
                                $gambiarraDoJuan = 'doc'.str_pad($pontuacao->nu_item , 2 , '0' , STR_PAD_LEFT).'_'.$pontuacao->nu_ordem ;
                            @endphp

                            @switch($pontuacao->nu_item)
                                @case(1) <!-- Tempo como Sargento -->
                                    @if($pontuacao->nu_ordem == 1)
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="col-xs-3">1 - Tempo de Serviço nas Graduações de Sargento</th>
                                                    <th class="col-xs-2">Data da promoção</th>
                                                    <th class="col-xs-1">Tempo em Meses</th>
                                                    <th class="col-xs-1">BG de Publicação</th>
                                                    <th class="col-xs-1">Aceitar</th>
                                                    <th class="col-xs-1">Justificativa</th>
                                                    <th class="col-xs-1">Homologado</th>
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th class="col-xs-1">Documentos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>{{$pontuacao->st_label}}</th>
                                                    <th class="form-inline">
                                                        <span id="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}" name="TEMPOSGT[st_criterio]">{{date('d/m/Y', strtotime($pontuacao->st_criterio))}}</span>
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_valor}}</span>
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                    </th>
                                                    <th>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label>
                                                        <br>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}>
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                    </th>
                                                    <th>
                                                        <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                    
                                                        @if($pontuacao->bo_homologadoqaatual)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>
                                                    
                                                    @if(isset($arquivos) && count($arquivos) > 0)
                                                        @foreach ($arquivos as $chave => $a)
                                                            @if ($a->st_descricao === 'doc01_1' || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                </td>
                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    
                                                </tr>
                                    @elseif($pontuacao->nu_ordem == 2)
                                                <tr>
                                                    <th>{{$pontuacao->st_label}}</th>
                                                    <th class="form-inline">
                                                        <span id="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}" name="TEMPOGRADUACAO[st_criterio]">{{date('d/m/Y', strtotime($pontuacao->st_criterio))}}</span>
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_valor}}</span>
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                    </th>
                                                    <th>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label>
                                                        <br>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}>
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                    </th>
                                                    <th class="form-inline">
                                                        <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                        @if($pontuacao->bo_homologadoqaatual)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @if(isset($arquivos) && count($arquivos) > 0)
                                                        @foreach ($arquivos as $chave => $a)
                                                            @if ($a->st_descricao === 'doc01_2' || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                </td>
                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </tr>
                                            
                                    @elseif($pontuacao->nu_ordem == 3)
                                                <tr>
                                                    <th>{{$pontuacao->st_label}}</th>
                                                    <th class="form-inline">
                                                        <span id="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}" name="TEMPOGRADUACAO[st_criterio]">{{$pontuacao->st_criterio}}</span>
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_valor}}</span>
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                    </th>
                                                    <th>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label>
                                                        <br>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}>
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                    </th>
                                                    <th class="form-inline">
                                                        <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                        @if($pontuacao->bo_homologadoqaatual)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @if(isset($arquivos) && count($arquivos) > 0)
                                                        @foreach ($arquivos as $chave => $a)
                                                            @if ($a->st_descricao === 'doc01_3' || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                </td>
                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </tr>
                                            
                                    @elseif($pontuacao->nu_ordem == 4)
                                                <tr>
                                                    <th>{{$pontuacao->st_label}}</th>
                                                    <th class="form-inline">
                                                        <span id="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}" name="TEMPOGRADUACAO[st_criterio]">{{$pontuacao->st_criterio}}</span>
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_valor}}</span>
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                    </th>
                                                    <th>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label>
                                                        <br>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}>
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                    </th>
                                                    <th class="form-inline">
                                                        <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                        @if($pontuacao->bo_homologadoqaatual)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @if(isset($arquivos) && count($arquivos) > 0)
                                                        @foreach ($arquivos as $chave => $a)
                                                            @if ($a->st_descricao === 'doc01_4' || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                </td>
                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif

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
                                                <th class="col-xs-1">Justificativa</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                                <th class="col-xs-1">Documentos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_label]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_label}}</span>
                                                </th>
                                                <th>
                                                    <span id="{{$pontuacao->st_nomeinterno}}[st_criterio]" name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_criterio}}</span>
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                </th>
                                                <th>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                                    <br>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                </th>
                                                <th class="form-inline">
                                                    <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                    @endif
                                                    @if($pontuacao->bo_homologadoqaatual)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>
                                                        @if(!empty($pontuacao->vl_pontos))
                                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                        @endif
                                                    </span>
                                                </th>

                                                @if(isset($arquivos) && count($arquivos) > 0)
                                                    @foreach ($arquivos as $chave => $a)
                                                        @if ($a->st_descricao === 'doc02' || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                            <td class="text-center">
                                                                <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                            </td>
                                                            @php
                                                                unset($arquivos[$chave]);
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif

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
                                                <th class="col-xs-1">Justificativa</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                                <th class="col-xs-1">Documentos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_criterio]" id="COMPORTAMENTO" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_label}}</span>
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                </th>
                                                <th>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                                    <br>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                </th>
                                                <th class="form-inline">
                                                    <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                    @endif
                                                    @if($pontuacao->bo_homologadoqaatual)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                </th>

                                                @if(isset($arquivos) && count($arquivos) > 0)
                                                    @foreach ($arquivos as $chave => $a)
                                                        @if ($a->st_descricao === 'doc03' || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                            <td class="text-center">
                                                                <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                            </td>
                                                            @php
                                                                unset($arquivos[$chave]);
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </tr>
                                        </tbody>
                                    </table>
                                    @break
                                @case(4) <!-- Medalhas -->
                                    @php
                                        $contMedalha++
                                    @endphp
                                    @if(!in_array('medalhas',$cabecalhosArray))
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="col-xs-2">4 - Medalha</th>
                                                    <th>BG de Publicação da Concessão</th>
                                                    <th class="col-xs-1">Aceitar</th>
                                                    <th class="col-xs-1">Justificativa</th>
                                                    <th class="col-xs-1">Homologado</th>
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th class="col-xs-1">Documentos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        @php 
                                            array_push($cabecalhosArray,'medalhas') ;
                                        @endphp
                                    @endif
                                    <tr id="medalha_{{$pontuacao->id}}">
                                        <th>
                                            <span name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_label}}</span>
                                        </th>
                                        <th>
                                            <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                        </th>
                                        <th>
                                            <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                            <br>
                                            <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                        </th>
                                        <th class="form-inline">
                                            <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                        </th>
                                        <th class="text-center">
                                            @if($pontuacao->bo_pontohomologado)
                                                @if($pontuacao->bo_pontoaceito == "1")
                                                    <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                @elseif($pontuacao->bo_pontoaceito == "0")
                                                    <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                @endif
                                            @else 
                                                <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                            @endif
                                            @if($pontuacao->bo_homologadoqaatual)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                        </th>
                                        <th>
                                            <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                        </th>

                                        @if(isset($arquivos) && count($arquivos) > 0)
                                            @foreach ($arquivos as $chave => $a)
                                                @if ($a->st_descricao === $gambiarraDoJuan || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                    <td class="text-center">
                                                        <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                    </td>
                                                    @php
                                                        unset($arquivos[$chave]);
                                                    @endphp
                                                    @break
                                                @endif
                                            @endforeach
                                        @endif

                                    </tr>
                                    @if($pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                        <!-- Fechando tabela de medalhas -->
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
                                                <th class="col-xs-1">Justificativa</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                                <th class="col-xs-1">Documentos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_criterio]" id="SANGUE" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_label === "SIM"?"Sim":"Não"}}</span>
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                </th>
                                                <th>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                                    <br>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                </th>
                                                <th class="form-inline">
                                                    <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                    @endif
                                                    @if($pontuacao->bo_homologadoqaatual)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                </th>

                                                @if(isset($arquivos) && count($arquivos) > 0)
                                                    @foreach ($arquivos as $chave => $a)
                                                        @if ($a->st_descricao === 'doc05' || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                            <td class="text-center">
                                                                <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                            </td>
                                                            @php
                                                                unset($arquivos[$chave]);
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </tr>
                                        </tbody>
                                    </table>
                                    @break
                                @case(6) <!-- Atividades de Instrutor ou Monitor -->
                                    @php
                                        $contInstrucao++
                                    @endphp
                                    @if(!in_array('atividadeInstrutorMonitor',$cabecalhosArray))
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="col-xs-2">6 - Atividade de Instrutor ou Monitor</th>
                                                    <th>CH</th>
                                                    <th>Data de início</th>
                                                    <th>Data de término</th>
                                                    <th>BG de Designação</th>
                                                    <th class="col-xs-1">Aceitar</th>
                                                    <th class="col-xs-1">Justificativa</th>
                                                    <th class="col-xs-1">Homologado</th>
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th class="col-xs-1">Documentos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        @php 
                                            array_push($cabecalhosArray,'atividadeInstrutorMonitor') ;
                                        @endphp
                                    @endif
                                        <tr id="atividade_{{$pontuacao->id}}">
                                            <th>
                                                <span id="INSTRUTOR" name="{{$pontuacao->st_nomeinterno}}[st_label]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_label}}</span>
                                            </th>
                                            <th>
                                                <span id="{{$pontuacao->st_nomeinterno}}[st_criterio]" name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_criterio}}</span>
                                            </th>
                                            <th>
                                                @if(!empty($pontuacao->st_campo))
                                                    <span id="{{$pontuacao->st_nomeinterno}}[st_campo]" name="{{$pontuacao->st_nomeinterno}}[st_campo1]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{date('d/m/Y', strtotime(explode(';', $pontuacao->st_campo)[0]))}}</span>
                                                @else
                                                    <span id="{{$pontuacao->st_nomeinterno}}[st_campo]" name="{{$pontuacao->st_nomeinterno}}[st_campo1]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}"></span>
                                                @endif
                                            </th>
                                            <th>
                                                @if(!empty($pontuacao->st_campo))
                                                    <span id="{{$pontuacao->st_nomeinterno}}[st_campo]" name="{{$pontuacao->st_nomeinterno}}[st_campo2]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{date('d/m/Y', strtotime(explode(';', $pontuacao->st_campo)[1]))}}</span>
                                                @else
                                                    <span id="{{$pontuacao->st_nomeinterno}}[st_campo]" name="{{$pontuacao->st_nomeinterno}}[st_campo2]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}"></span>
                                                @endif
                                            </th>
                                            <th>
                                                <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                            </th>
                                            <th>
                                                <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                    <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                                <br>
                                                <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                    <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                            </th>
                                            <th class="form-inline">
                                                <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                            </th>
                                            <th class="text-center">
                                                @if($pontuacao->bo_pontohomologado)
                                                    @if($pontuacao->bo_pontoaceito == "1")
                                                        <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                    @elseif($pontuacao->bo_pontoaceito == "0")
                                                        <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                    @endif
                                                @else 
                                                    <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                @endif
                                                @if($pontuacao->bo_homologadoqaatual)
                                                    @if($pontuacao->bo_pontoaceito == "1")
                                                        <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                    @elseif($pontuacao->bo_pontoaceito == "0")
                                                        <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                    @endif
                                                @else 
                                                    <span class="fa fa-hourglass-half" title="Aguardando Homologação no QA atual"></span>
                                                @endif
                                            </th>
                                            <th>
                                                <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>
                                                    @if(!empty($pontuacao->vl_pontos))
                                                        {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                    @endif
                                                </span>
                                            </th>

                                            @if(isset($arquivos) && count($arquivos) > 0)
                                                @foreach ($arquivos as $chave => $a)
                                                    @if ($a->st_descricao === $gambiarraDoJuan || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                        <td class="text-center">
                                                            <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                        </td>
                                                        @php
                                                            unset($arquivos[$chave]);
                                                        @endphp
                                                        @break
                                                    @endif
                                                @endforeach
                                            @endif

                                        </tr>
                                    @if($pontuacoes[$key+1]->nu_item != $pontuacao->nu_item) <!-- Fechando tabela -->
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
                                                <th class="col-xs-1">Justificativa</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                                <th class="col-xs-1">Documentos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_criterio]" id="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_criterio}}</span>
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                </th>
                                                <th>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                                    <br>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                </th>
                                                <th class="form-inline">
                                                    <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                    @endif
                                                    @if($pontuacao->bo_homologadoqaatual)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        <span class="fa fa-hourglass-half" title="Aguardando Homologação no QA atual"></span>
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                </th>

                                                @if(isset($arquivos) && count($arquivos) > 0)
                                                    @foreach ($arquivos as $chave => $a)
                                                        @if ($a->st_descricao === 'doc07' || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                            <td class="text-center">
                                                                <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                            </td>
                                                            @php
                                                                unset($arquivos[$chave]);
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif

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
                                                <th class="col-xs-1">Justificativa</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                                <th class="col-xs-1">Documentos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_criterio]" id="FORMACAO" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_label}}</span>
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                </th>
                                                <th>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                                    <br>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                </th>
                                                <th class="form-inline">
                                                    <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                    @endif
                                                    @if($pontuacao->bo_homologadoqaatual)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        <span class="fa fa-hourglass-half" title="Aguardando Homologação no QA atual"></span>
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                </th>

                                                @if(isset($arquivos) && count($arquivos) > 0)
                                                    @foreach ($arquivos as $chave => $a)
                                                        @if ($a->st_descricao === 'doc08' || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                            <td class="text-center">
                                                                <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                            </td>
                                                            @php
                                                                unset($arquivos[$chave]);
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </tr>
                                        </tbody>
                                    </table>
                                    @break
                                @case(9) <!-- Cursos com Aplicabilidade à Caserna -->
                                    @php
                                        $contCurso++
                                    @endphp
                                    @if($pontuacao->nu_ordem == 1) <!-- Abrindo tabela -->
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="col-xs-3">9 - Curso com Aplicabilidade à Caserna</th>
                                                    <th class="col-xs-2">Nome do curso</th>
                                                    <th>BG de Designação</th>
                                                    <th class="col-xs-1">Aceitar</th>
                                                    <th class="col-xs-1">Justificativa</th>
                                                    <th class="col-xs-1">Homologado</th>
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th class="col-xs-1">Documentos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        <span class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">CH igual ou superior a 30h</span>
                                                    </th>
                                                    <th>
                                                        <span id="{{$pontuacao->st_nomeinterno}}[st_criterio]" name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_criterio}}</span>
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                    </th>
                                                    <th>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                                        <br>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                    </th>
                                                    <th class="form-inline">
                                                        <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                        @if($pontuacao->bo_homologadoqaatual)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação no QA atual"></span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @if(isset($arquivos) && count($arquivos) > 0)
                                                        @foreach ($arquivos as $chave => $a)
                                                        @php 
                                                            $gambiarraDoJazon = '1'.$a->st_descricao ;
                                                        @endphp
                                                            @if (   $a->st_descricao === $gambiarraDoJuan 
                                                                    || $a->st_descricao === "doc09_{$contCurso}"
                                                                    || $a->st_descricao == $pontuacao->st_nomeinterno 
                                                                    || $gambiarraDoJazon == $pontuacao->st_nomeinterno )

                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                </td>
                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </tr>
                                    @elseif($pontuacao->nu_ordem == 2)
                                        <tr>
                                            <th>
                                                <span class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">CH igual ou superior a 60h</span>
                                            </th>
                                            <th>
                                                <span id="{{$pontuacao->st_nomeinterno}}[st_criterio]" name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_criterio}}</span>
                                            </th>
                                            <th>
                                                <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                            </th>
                                            <th>
                                                <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                    <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                                <br>
                                                <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                    <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                            </th>
                                            <th class="form-inline">
                                                <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                            </th>
                                            <th class="text-center">
                                                @if($pontuacao->bo_pontohomologado)
                                                    @if($pontuacao->bo_pontoaceito == "1")
                                                        <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                    @elseif($pontuacao->bo_pontoaceito == "0")
                                                        <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                    @endif
                                                @else 
                                                    <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                @endif
                                                @if($pontuacao->bo_homologadoqaatual)
                                                    @if($pontuacao->bo_pontoaceito == "1")
                                                        <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                    @elseif($pontuacao->bo_pontoaceito == "0")
                                                        <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                    @endif
                                                @else 
                                                    <span class="fa fa-hourglass-half" title="Aguardando Homologação no QA atual"></span>
                                                @endif
                                            </th>
                                            <th>
                                                <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                            </th>

                                            @if(isset($arquivos) && count($arquivos) > 0)
                                                @foreach ($arquivos as $chave => $a)
                                                @php 
                                                    $gambiarraDoJazon = '1'.$a->st_descricao ;
                                                @endphp
                                                @if (   $a->st_descricao === $gambiarraDoJuan 
                                                        || $a->st_descricao === "doc09_{$contCurso}"
                                                        || $a->st_descricao == $pontuacao->st_nomeinterno 
                                                        || $gambiarraDoJazon == $pontuacao->st_nomeinterno )

                                                        <td class="text-center">
                                                            <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                        </td>
                                                        @php
                                                            unset($arquivos[$chave]);
                                                        @endphp
                                                        @break
                                                    @endif
                                                @endforeach
                                            @endif

                                        </tr>
                                    @elseif($pontuacao->nu_ordem == 3) <!-- Fechando tabela -->
                                                <tr>
                                                    <th>
                                                        <span class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">CH igual ou superior a 100h</span>
                                                    </th>
                                                    <th>
                                                        <span id="{{$pontuacao->st_nomeinterno}}[st_criterio]" name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_criterio}}</span>
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                    </th>
                                                    <th>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                                        <br>
                                                        <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                            <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                    </th>
                                                    <th class="form-inline">
                                                        <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                        @endif
                                                        @if($pontuacao->bo_homologadoqaatual)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            <span class="fa fa-hourglass-half" title="Aguardando Homologação no QA atual"></span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @if(isset($arquivos) && count($arquivos) > 0)
                                                        @foreach ($arquivos as $chave => $a)
                                                            @php 
                                                                $gambiarraDoJazon = '1'.$a->st_descricao ;
                                                            @endphp
                                                            @if (   $a->st_descricao === $gambiarraDoJuan 
                                                                    || $a->st_descricao === "doc09_{$contCurso}"
                                                                    || $a->st_descricao == $pontuacao->st_nomeinterno 
                                                                    || $gambiarraDoJazon == $pontuacao->st_nomeinterno )

                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                </td>
                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                @endphp
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                    @break
                                @case(10) <!-- Contribuição Científica -->
                                    @if(!in_array('cientificos',$cabecalhosArray))
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="col-xs-3">10 - Contribuição Científica de Caráter Técnico Profissional<br>(Aprovada pela Diretoria de Ensino da PMRN)</th>
                                                <th>BG de Publicação</th>
                                                <th class="col-xs-1">Aceitar</th>
                                                <th class="col-xs-1">Justificativa</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                                <th class="col-xs-1">Documentos</th>
                                            </tr>
                                        </thead>
                                        @php 
                                        array_push($cabecalhosArray,'cientificos') ;
                                        @endphp
                                        @endif   
                                        <tbody>
                                        <tr>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_criterio]" id="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_label}}</span>
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                                </th>
                                                <th>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                                    <br>
                                                    <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                        <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                                </th>
                                                <th class="form-inline">
                                                    <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                                </th>
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                                    @endif
                                                    @if($pontuacao->bo_homologadoqaatual)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        <span class="fa fa-hourglass-half" title="Aguardando Homologação no QA atual"></span>
                                                    @endif
                                                </th>
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                </th>

                                                @if(isset($arquivos) && count($arquivos) > 0)
                                                    @foreach ($arquivos as $chave => $a)
                                                        @if (
                                                                $a->st_descricao === 'doc10'
                                                                || $a->st_descricao === 'doc_tcc'
                                                                || $a->st_descricao === 'doc_artigo'
                                                                || $a->st_descricao === 'doc_livro'
                                                                || $a->st_descricao == $pontuacao->st_nomeinterno
                                                            )
                                                            <td class="text-center">
                                                                <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                            </td>
                                                            @php
                                                                unset($arquivos[$chave]);
                                                            @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </tr>
                                        </tbody>
                            
                                            
                                    @break
                                @case(11) <!-- Punições -->
                                @php
                                    $contPunicao++
                                @endphp
                                @if(!in_array('punicao',$cabecalhosArray))
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="col-xs-2">11 - Punições</th>
                                                <th>BG de Designação</th>
                                                <th class="col-xs-1">Aceitar</th>
                                                <th class="col-xs-1">Justificativa</th>
                                                <th class="col-xs-1">Homologado</th>
                                                <th class="col-xs-1">Pontos</th>
                                                <th class="col-xs-1">Documentos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    @php 
                                        array_push($cabecalhosArray,'punicao') ;
                                    @endphp
                                @endif
                                    <tr id="punicao_{{$pontuacao->id}}">
                                        <th>
                                            <span name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_label}}</span>
                                        </th>
                                        <th>
                                            <span name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito == null?'intensAlteracao':''}}">{{$pontuacao->st_publicacao}}</span>
                                        </th>
                                        <th>
                                            <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="1" {{($pontuacao->bo_pontoaceito == "1" || old($pontuacao->st_nomeinterno) == "1") ? 'checked' : ''}} required> 
                                                <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]1"> Sim </label> 
                                            <br>
                                            <input type="radio" id="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0" name="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]" value="0" {{($pontuacao->bo_pontoaceito == "0" || old($pontuacao->st_nomeinterno) == "0") ? 'checked' : ''}}> 
                                                <label for="{{$pontuacao->st_nomeinterno}}[bo_pontoaceito]0"> Não </label>
                                        </th>
                                        <th class="form-inline">
                                            <input name="{{$pontuacao->st_nomeinterno}}[st_justificativa]" class="form-control" type="text" value="{{$pontuacao->st_justificativa or ''}}"  required>
                                        </th>
                                        <th class="text-center">
                                            @if($pontuacao->bo_pontohomologado)
                                                @if($pontuacao->bo_pontoaceito == "1")
                                                    <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                @elseif($pontuacao->bo_pontoaceito == "0")
                                                    <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                @endif
                                            @else 
                                                <span class="fa fa-hourglass-half" title="Aguardando Homologação"></span>
                                            @endif
                                            @if($pontuacao->bo_homologadoqaatual)
                                                @if($pontuacao->bo_pontoaceito == "1")
                                                    <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                @elseif($pontuacao->bo_pontoaceito == "0")
                                                    <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                @endif
                                            @else 
                                                <span class="fa fa-hourglass-half" title="Aguardando Homologação no QA atual"></span>
                                            @endif
                                        </th>
                                        <th>
                                            <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                        </th>

                                        @if(isset($arquivos) && count($arquivos) > 0)
                                            @foreach ($arquivos as $chave => $a)
                                                @if ($a->st_descricao === "doc11_{$contPunicao}"
                                                || $a->st_descricao == $pontuacao->st_nomeinterno
                                                )
                                                    <td class="text-center">
                                                        <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                    </td>
                                                    @php
                                                        unset($arquivos[$chave]);
                                                    @endphp
                                                    @break
                                                @endif
                                            @endforeach
                                        @endif

                                    </tr>
                                    @if(!isset($pontuacoes[$key+1])) <!-- Fechando tabela -->
                                            </tbody>
                                        </table>
                                    @endif
                                    @break
                                @default
                                    <h1>ERRO</h1>
                                    @break
                            @endswitch
                        @endforeach

                      
                        <div style="text-align: right;">
                          <!--  <span class="form-control total"><B>TOTAL GERAL DE PONTOS: {{collect($pontuacoes)->sum('vl_pontos')}}</B></span> -->
                            <span class="form-control total"><B>TOTAL GERAL DE PONTOS ENVIADOS: {{$ficha->vl_pontosdaficha}}</B></span>
                            <span class="form-control total"><B>TOTAL GERAL DE PONTOS VÁLIDOS: {{$ficha->vl_pontosvalidosdaficha}}</B></span>
                            
                           
                        </div>
                        <br>
                    </fieldset>
                   
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Observações internas da CPP</legend>
                        <div class="form-group">
                            <textarea class="form-control ckeditor" rows="3" id="st_obsinternacpp" name="st_obsinternacpp" placeholder="Digite as observações..." required>{{$ficha->st_obsinternacpp}}</textarea>
                        </div>
                    </fieldset>
                    <div class="row">
                    <div class="col-md-3">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Pendências da ficha</legend>
                                <br>
                                <div class="col-md-10 col-md-offset-1 bg-red">
                                    @if (isset($pendencias))
                                        @forelse ($pendencias as $pendencia)
                                            @if ($pendencia == 'faltou_inapto')
                                                Faltou / Inapto
                                                <br>
                                            @elseif ($pendencia == 'CFS_EHS')
                                                Sem CFS / EHS
                                                <br>
                                            @elseif ($pendencia == 'CAS')
                                                Sem CAS
                                                <br>
                                            @elseif ($pendencia == 'ART15')
                                                Art. 15 LCE 515/2014
                                                <br>
                                            @elseif ($pendencia == 'cert_forum')
                                                Sem certidão de Fórum
                                                <br>
                                            @elseif ($pendencia == 'condenado_judicialmente')
                                                Condenado Judicialmente
                                                <br>
                                            @elseif ($pendencia == 'comportamento_pendente')
                                                Comportamento Pendente
                                                <br>
                                            @elseif ($pendencia == 'envio_ficha')
                                                Envio da Ficha
                                                <br>
                                            @endif
                                        @empty

                                        @endforelse
                                    @endif
                                </div>
                                <div class="col-md-12 text-center" id="st_pendenciaficha">
                                    <br><br>
                                    @if(empty($ficha->dt_assinaturahomologacao))
                                        <button data-toggle="modal" data-target="#modalPendenciasFicha" type="button" class="btn btn-primary">
                                            <i class="fa fa-plus"></i> Cadastrar
                                        </button>
                                    @endif
                                    <br><br>
                                </div>
                        </fieldset>
                    </div>

                    <div class="col-md-3">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Certidão</legend>
                            <br>
                            <div class="col-md-12">

                                @php $achouCertidao = false @endphp

                                    <div class="col-md-12">
                                        @if(isset($arquivos) && count($arquivos) > 0)
                                            @foreach ($arquivos as $chave => $a)
                                                @if ($a->st_descricao === "certidao_nada_consta_justica")
                                                    <b class="text-black"> Certidão Anexada: </b>
                                                    <br>
                                                    <td class="text-center">
                                                        <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                    </td>
                                                    @php
                                                        $achouCertidao = true;
                                                        unset($arquivos[$chave]);
                                                    @endphp
                                                    @break
                                                @endif
                                            @endforeach
                                        @endif
                                        <br><br>
                                    </div>
                                @if (!$achouCertidao)
                                    <div class="col-md  text-red">
                                       <h4> Certidão não anexada</h4>
                                    </div>
                                @endif 
                            </div>
                           
                           
                        </fieldset>
                    </div>
                    <div class="col-md-3">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Inspeção</legend>
                            <br>
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <label for="dt_validadeinspecaosaude" class="control-label">Validade JPMS:</label>
                                </div>
                                <div class="col-md-8">
                                    <input name="dt_validadeinspecaosaude" class="form-control" type="date" class="form-control date" value="{{$policialDoQuadro->dt_validadeinspecaosaude}}" disabled />
                                </div>
                            </div>
                            <br><br><br>
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <label for="dt_validadetaf" class="control-label ">Validade TAF:</label>
                                </div>
                                <div class="col-md-8">
                                    <input name="dt_validadetaf" class="form-control" type="date" class="form-control date" value="{{$policialDoQuadro->dt_validadeinspecaotaf}}" disabled />
                                </div>
                                <br><br><br>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-3">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">interstício</legend>
                            <br>
                            <div class="col-md-8 col-md-offset-3">
                                <label for="bo_intersticio">Deduzido o tempo não computável, não atingiu o tempo máximo</label>
                                <input type="checkbox" name="bo_intersticio" id="bo_intersticio" value="1" {{$policialDoQuadro->bo_intersticio ? 'checked' : ''}} {{$ficha->dt_assinaturahomologacao ? 'disabled' : ''}}>
                                <br><br>
                            </div>
                        </fieldset>
                    </div>

                    </div>
                     @endif
                   
                    @if(empty(Request::segment(9)))     
                        <a href="{{url('promocao/homologarfichareconhecimento/'.$idQuadro.'/'.$idAtividade.'/competencia/CPP/graduacao/todos')}}" class="btn btn-warning">
                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar para listagem
                        </a>
                    @else 
                  
                        <a href="{{url('promocao/homologarfichareconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/CPP')}}" class="btn btn-warning">
                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar para fichas
                        </a>
                    @endif
           
                    @if(!empty(Request::segment(9))) 
                         @if(empty($ficha->dt_assinaturahomologacao))
                            <button type="button" title="Calcular" class="btn btn-primary" onclick="salvarHomologarFicha({{$idQuadro}}, {{$idAtividade}}, {{$idPolicial}})">
                                <i class="fa fa-calculator"></i> Calcular
                            </button>
                            <button type="button" class="btn btn-primary" title="Homologação da Ficha" data-toggle="modal" data-target="#modalConcluirHomologacaoCredenciais">
                                <i class="fa fa-gavel"></i> Homologar
                            </button>
                        @endif
                        <a href="{{url('promocao/visualizarpdffichadereconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/'.$competencia.'/ficha/'.$ficha->id)}}" target="_blank" class="btn btn-primary">
                            <span class="fa fa-print"></span>
                        </a>
                   @endif
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Moldal Retornar Ficha -->
<div class="modal fade" id="retornaFichaModal" tabindex="-1" role="dialog" aria-labelledby="retornaFichaModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="retornaFichaLabel">Retornar Ficha</h5>
            </div>
            <form action="{{ url('promocao/retornarfichareconhecimento/' . $idQuadro . '/' . $idAtividade . '/' . $idPolicial) }}" method="POST">
                <div class="modal-body">
                    {{csrf_field()}}
                    <div class="form-group">
                        <div class="control-label">Caso deseje realmente retornar a ficha para correções, digite sua senha.</div>
                        <label class="control-label">Senha:</label>
                        <div class="">
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Retornar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Modal para concluir a homologação do documento-->
<div class="modal fade" id="modalConcluirHomologacao" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirmar a homologação do documento</h4>
                </div>
                <div class="modal-body bg-danger">
                    <h4 class="modal-title">Atenção!</h4>
                    <div classe>
                        Ao confirmar esta ação, não será possível alterar a ficha novamente.
                        <br><br>
                        Deseja continuar?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" title="Não" class="btn btn-warning" data-dismiss="modal">Não</button>
                    <button type="button" title="Sim" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirHomologacaoCredenciais" data-dismiss="modal">
                        Sim
                    </button>
                </div>
            </div>
        </div>
    </div>
<!--Modal para confirmação da homologação do documento-->
<div class="modal fade" id="modalConcluirHomologacaoCredenciais" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmar Homologação</h4>
            </div>
            <div class="modal-body bg-danger">
                <h4 class="modal-title">Atenção!</h4>
                <div classe>
                    Ao confirmar esta ação, não será possível alterar a ficha novamente.
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="password" class="col-md-2 control-label" style="margin-top: 5px;">Senha</label>
                    <div class="col-md-10">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Digite sua senha..." required>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary">
                <button type="button" title="Cancelar" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" title="Concluir Ficha" class="btn btn-info" data-dismiss="modal" onclick="concluirFicha('{{$idQuadro}}', '{{$idAtividade}}', '{{$idPolicial}}','{{$ficha->id}}')">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!--Modal para cadastrar pendências da ficha-->
<div class="modal fade" id="modalPendenciasFicha" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cadastrar Pendências</h4>
            </div>
            <form action="{{url('promocao/dependencias/fichadereconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial)}}" method="post">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="envio_ficha" id="envio_ficha" value="ENVIO_FICHA">
                            <label class="form-check-label" for="envio_ficha">
                                Envio da ficha pendente
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="faltou_inapto" id="faltou_inapto" value="faltou_inapto">
                            <label class="form-check-label" for="faltou_inapto">
                                Faltou / Inapto JPMS
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="CFS_EHS" id="CFS_EHS" value="CFS_EHS">
                            <label class="form-check-label" for="CFS_EHS">
                                Sem CFS / EHS
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="CAS" id="CAS" value="CAS">
                            <label class="form-check-label" for="CAS">
                                Sem CAS
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ART15" id="ART15" value="ART15">
                            <label class="form-check-label" for="ART15">
                                Art. 15 LCE 515/2014
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="cert_forum" id="cert_forum" value="cert_forum">
                            <label class="form-check-label" for="cert_forum">
                                Sem Certidão de Fórum
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="condenado_judicialmente" id="condenado_judicialmente" value="condenado_judicialmente">
                            <label class="form-check-label" for="condenado_judicialmente">
                                Condenado Judicialmente
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="comportamento_pendente" id="comportamento_pendente" value="comportamento_pendente">
                            <label class="form-check-label" for="comportamento_pendente">
                                Comportamento Pendente
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="envio_ficha" id="envio_ficha" value="envio_ficha">
                            <label class="form-check-label" for="envio_ficha">
                                Envio da Ficha
                            </label>
                        </div>
                        <input name="ce_ficha"  type="hidden" value="{{Request::segment(9)}}">
                    </div>
                </div>
           
                <div class="modal-footer bg-primary">
                    <button type="button" title="Cancelar" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    <button type="submit" title="Concluir Ficha" class="btn btn-info" >Salvar</button>
                </div>
            </form>
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
    .intensAlteracao
    {
        border: solid 1px red;
    }
</style>
@stop
@section('js')
    <script>
        function salvarHomologarFicha(idQuadro, idAtividade, idPolicial){
            $("#form").attr("action", "{{url('promocao/salvarhomologarfichareconhecimento')}}/"+idQuadro+"/"+idAtividade+"/"+idPolicial);
            $("#form").submit();
        };
        // Função para concluir homologação da ficha
        function concluirFicha(idQuadro, idAtividade, idPolicial, idFicha){
            $("#form").attr("action", "{{url('promocao/homologarfichareconhecimento')}}/"+idQuadro+"/"+idAtividade+"/"+idPolicial+"/ficha/"+idFicha);
            var pass = $("#password").val();
            var text = '<input id="password" type="hidden" class="form-control" name="password" value="'+pass+'" placeholder="Digite sua senha..." required>'
            // alerta o valor do campo
            $(text).insertBefore("#st_pendenciaficha");
            $("#form").submit();
        };
    </script>
@stop