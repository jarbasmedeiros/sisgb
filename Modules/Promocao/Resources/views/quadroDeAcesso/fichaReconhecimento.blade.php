@extends('adminlte::page')
@section('title', 'Ficha de Reconhecimento')
@section('content')
@php 
use Illuminate\Support\Arr;
@endphp

<input type="hidden" name="recursoAberto" id="recursoAberto" value="{{$quadro->bo_recursoliberado}}">

<div class="container-fluid">
    <div class="row"> 
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div>
                    <label>Ficha de Reconhecimento dos sargentos da PM / RN</label>
                </div>
            </div> 
           
            <div class="panel-body">
           
                <form id="form" class="form-contact" role="form" method="POST" 
                action="{{url('promocao/escriturarfichadereconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/'.$competencia.'/ficha/'.Request::segment(9))}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input name="ce_ficha"  type="hidden" value="{{Request::segment(9)}}">
                  
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
                                    <th><span class="form-control" disabled>{{$policialDoQuadro->st_postgrad}}</span></th>
                                    <th><span class="form-control" disabled>{{$policialDoQuadro->st_qpmp}}</span></th>
                                    <th><span class="form-control" disabled>{{$policialDoQuadro->st_matricula}}</span></th>
                                    <th><span class="form-control" disabled>{{$policialDoQuadro->st_numpraca}}</span></th>
                                    <th><span class="form-control" disabled>{{date('d/m/Y', strtotime($policialDoQuadro->dt_nascimento))}}</span></th>
                                </tr>
                                </tbody>
                               
                            </table>
                            <!-- <div class="col-xs-8">
                            </div> -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-4">Nome</th>
                                        <th class="col-xs-6">OPM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><span class="form-control" disabled>{{$policialDoQuadro->st_policial}}</span></th>
                                        <th><span class="form-control" disabled>{{$policialDoQuadro->st_unidade}}</span></th>
                                    </tr>
                                </tbody>
                            </table>
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
                                                <a href="{{url('promocao/escriturarfichadereconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/'.$competencia.'/ficha/'.$fichaDoPm->id)}}" title="Acessar Ficha" class="btn btn-primary">
                                                    <span class="fa fa-file-o"></span> Ficha {{$fichaDoPm->st_ficha}} 

                                                </a> 
                                                <a href="{{url('promocao/escriturarfichadereconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/'.$competencia.'/pdf/ficha/'.$fichaDoPm->id)}}" title="Visualizar PDF" class="btn btn-primary" target="_blank">
                                                    <span class="fa fa-file-pdf-o"></span> Visualizar PDF
                                                </a>
                                                <!-- TODO - REFATORAR a blade para desabilitar os campos da ficha quando o qa estiver fechado ou conforme o período de escrituração/recurso -->
                                            </th>
                                        </tr>
                                       
                                    @endforeach
                                   
                                </tbody>
                            
                            </table>
                            @if(empty(Request::segment(9))) 
                            <p style="color:red; font-weight: bold;">Selecione uma das fichas de escrituração disponíveis </p>
                            @endif
                            <input name="ce_ficha"  type="hidden" value="{{Request::segment(9)}}">
                        
                        </div>
                    </fieldset>
                  
                    @php
                        $contMedalha = 0;
                        $contInstrucao = 0;
                        $contPunicao = 0;
                        $contCurso = 0;
                        $contArquivo = 0;
                        $totalPontos = 0;
                        $cabecalhosArray = [];
                    @endphp
                   @if(!empty(Request::segment(9))) 
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Pontuações da ficha {{$ficha->st_ficha}}</legend>
                      

                 
                        @foreach($ficha->pontuacoes as $key => $pontuacao)
                     

                                @php 
                                $totalPontos += $pontuacao->vl_pontos;
                                $gambiarraDoJuan = 'doc'.str_pad($pontuacao->nu_item , 2 , '0' , STR_PAD_LEFT).'_'.$pontuacao->nu_ordem ;
                                @endphp

                                @switch($pontuacao->nu_item)
                                    @case(1) <!-- Tempo como Sargento -->
                                        @if($pontuacao->nu_ordem == 1)
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th class="col-xs-3">1 - Tempo de Serviço nas Graduações de Sargento</th>
                                                        <th class="col-xs-3">Tempo em Meses</th>
                                                        <th class="col-xs-2">BG de Publicação</th>
                                                        <th class="col-xs-1">Homologado</th>
                                                        @if($policialDoQuadro->bo_fichahomologada)
                                                            <th class="col-xs-1 justificativa">Justificativa</th>
                                                        @endif
                                                        <th class="col-xs-1">Pontos</th>
                                                        <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>{{$pontuacao->st_label}}</th>
                                                        <th class="form-inline">
                                                            @if($pontuacao->st_criterio)
                                                                Dt. Promoção: <input class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" name="TEMPOSGT[st_criterio]" type="date" value="{{date('Y-m-d', strtotime($pontuacao->st_criterio))}}">
                                                            @else
                                                                Dt. Promoção: <input class="form-control camposObrigatorios" name="TEMPOSGT[st_criterio]" type="date">
                                                            @endif
                                                        </th>
                                                        <th>
                                                            <input name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                        </th>
                                                        <th class="text-center">
                                                            @if($pontuacao->bo_pontohomologado)
                                                                @if($pontuacao->bo_pontoaceito == "1")
                                                                    <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                                @elseif($pontuacao->bo_pontoaceito == "0")
                                                                    <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                                @endif
                                                            @else 
                                                                NÃO
                                                            @endif
                                                        </th>
                                                        @if($policialDoQuadro->bo_fichahomologada)
                                                            <th class="justificativa">
                                                                {{$pontuacao->st_justificativa or ''}}
                                                            </th>
                                                        @endif
                                                        <th>
                                                            <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                        </th>

                                                        @php $achouArquivo = false; @endphp

                                                        @if(isset($arquivos) && count($arquivos) > 0)

                                                            @foreach ($arquivos as $chave => $a)
                                                                @if ($a->st_descricao === 'doc01_1' || $a->st_descricao == $pontuacao->st_nomeinterno)

                                                                    <td class="text-center">
                                                                        <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                        <input id="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}[id]" value="{{$a->id}}" hidden>
                                                                        <input id="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}[st_descricao]" value="doc01_1" hidden>
                                                                        <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                            <i class="fa fa-trash"></i> 
                                                                        </button>
                                                                    </td>

                                                                    @php
                                                                        unset($arquivos[$chave]);
                                                                        $achouArquivo = true;
                                                                    @endphp

                                                                    @break
                                                                @endif
                                                            @endforeach

                                                        @endif

                                                        @if (!$achouArquivo)
                                                            <th id="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}">
                                                                <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}', 'doc01_1')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}[st_path]" accept="application/pdf">
                                                            </th>  
                                                        @endif                                                        
                                                        
                                                    </tr>
                                        @elseif($pontuacao->nu_ordem == 2)
                                                    <tr>
                                                        <th>{{$pontuacao->st_label}}</th>
                                                        <th class="form-inline">
                                                        @if($pontuacao->st_criterio)
                                                            Dt. Promoção: <input class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" name="TEMPOGRADUACAO[st_criterio]" type="date" value="{{date('Y-m-d', strtotime($pontuacao->st_criterio))}}">
                                                        @else
                                                            Dt. Promoção: <input class="form-control camposObrigatorios" name="TEMPOGRADUACAO[st_criterio]" type="date">
                                                        @endif
                                                        </th>
                                                        <th>
                                                            <input name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                        </th>
                                                        <th class="text-center">
                                                            @if($pontuacao->bo_pontohomologado)
                                                                @if($pontuacao->bo_pontoaceito == "1")
                                                                    <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                                @elseif($pontuacao->bo_pontoaceito == "0")
                                                                    <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                                @endif
                                                            @else 
                                                                NÃO
                                                            @endif
                                                        </th>
                                                        @if($policialDoQuadro->bo_fichahomologada)
                                                            <th class="justificativa">
                                                                {{$pontuacao->st_justificativa or ''}}
                                                            </th>
                                                        @endif
                                                        <th>
                                                            <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                        </th>

                                                        @php $achouArquivo = false; @endphp

                                                        @if(isset($arquivos) && count($arquivos) > 0)

                                                            @foreach ($arquivos as $chave => $a)
                                                                @if ($a->st_descricao === 'doc01_2' || $a->st_descricao == $pontuacao->st_nomeinterno)

                                                                    <td class="text-center">
                                                                        <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                        <input id="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}[id]" value="{{$a->id}}" hidden>
                                                                        <input id="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}[st_descricao]" value="doc01_2" hidden>
                                                                        <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                            <i class="fa fa-trash"></i> 
                                                                        </button>
                                                                    </td>

                                                                    @php
                                                                        unset($arquivos[$chave]);
                                                                        $achouArquivo = true;
                                                                    @endphp

                                                                    @break
                                                                @endif
                                                            @endforeach

                                                        @endif

                                                        @if (!$achouArquivo)
                                                            <th id="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}">
                                                                <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}', 'doc01_2')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}NuOrdem{{$pontuacao->nu_ordem}}[st_path]" accept="application/pdf">
                                                            </th>  
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
                                                    <th class="col-xs-1">Homologado</th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="col-xs-1 justificativa">Justificativa</th>
                                                    @endif
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th class="form-inline">
                                                        Curso:
                                                        <select name="{{$pontuacao->st_nomeinterno}}[st_label]" class="form-control select2-container camposObrigatorios  {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
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
                                                        <input name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="number" value="{{$pontuacao->st_criterio}}" step="0.0001" min="0" max="10">
                                                    </th>
                                                    <th>
                                                        <input name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            NÃO
                                                        @endif
                                                    </th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="justificativa">
                                                            {{$pontuacao->st_justificativa or ''}}
                                                        </th>
                                                    @endif
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @php $achouArquivo = false; @endphp

                                                    @if(isset($arquivos) && count($arquivos) > 0)

                                                        @foreach ($arquivos as $chave => $a)
                                                            @if ($a->st_descricao === 'doc02' || $a->st_descricao == $pontuacao->st_nomeinterno)

                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}[id]" value="{{$a->id}}" hidden>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}[st_descricao]" value="doc02" hidden>
                                                                    <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> 
                                                                    </button>
                                                                </td>

                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                    $achouArquivo = true;
                                                                @endphp

                                                                @break
                                                            @endif
                                                        @endforeach

                                                    @endif

                                                    @if (!$achouArquivo)
                                                        <th id="ARQUIVO{{$pontuacao->nu_item}}">
                                                            <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}', 'doc02')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}[st_path]" accept="application/pdf">
                                                        </th>  
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
                                                    <th class="col-xs-1">Homologado</th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="col-xs-1 justificativa">Justificativa</th>
                                                    @endif
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        <select name="COMPORTAMENTO[st_criterio]" class="form-control select2-container camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option value="SEMCOMPORTAMENTO"selected="selected" value="">Selecione...</option>
                                                            <option value="COMPORTAMENTOMAU" {{($pontuacao->st_criterio == "COMPORTAMENTOMAU") ? 'selected' : ''}}>Insuficiente ou Mau</option>
                                                            <option value="COMPORTAMENTOBOM" {{($pontuacao->st_criterio == "COMPORTAMENTOBOM") ? 'selected' : ''}}>Bom</option>
                                                            <option value="COMPORTAMENTOOTIMO" {{($pontuacao->st_criterio == "COMPORTAMENTOOTIMO") ? 'selected' : ''}}>Ótimo</option>
                                                            <option value="COMPORTAMENTOEXCEPCIONAL" {{($pontuacao->st_criterio == "COMPORTAMENTOEXCEPCIONAL") ? 'selected' : ''}}>Excepcional</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input name="COMPORTAMENTO[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            NÃO
                                                        @endif
                                                    </th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="justificativa">
                                                        {{$pontuacao->st_justificativa or ''}}
                                                        </th>
                                                    @endif
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @php $achouArquivo = false; @endphp
                                                
                                                    @if(isset($arquivos) && count($arquivos) > 0)

                                                        @foreach ($arquivos as $chave => $a)
                                                            @if ($a->st_descricao === 'doc03' || $a->st_descricao == $pontuacao->st_nomeinterno)
                                                    
                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}[id]" value="{{$a->id}}" hidden>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}[st_descricao]" value="doc03" hidden>
                                                                    <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> 
                                                                    </button>
                                                                </td>

                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                    $achouArquivo = true;
                                                                @endphp

                                                                @break
                                                            @endif
                                                        @endforeach

                                                    @endif

                                                    @if (!$achouArquivo)
                                                        <th id="ARQUIVO{{$pontuacao->nu_item}}">
                                                            <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}', 'doc03')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}[st_path]" accept="application/pdf">
                                                        </th>  
                                                    @endif 

                                                </tr>
                                            </tbody>
                                        </table>
                                        @break
                                    @case(4) <!-- Medalhas -->
                                            @php
                                                $contMedalha++;
                                            @endphp
                                            @if(!in_array('medalhas',$cabecalhosArray))
                                                <table class="table table-bordered">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th class="col-xs-4">4 - Medalha</th>
                                                        <th class="col-xs-2">BG de Publicação da Concessão</th>
                                                        <th class="col-xs-1">Ação</th>
                                                        <th class="col-xs-1">Homologado</th>
                                                        @if($policialDoQuadro->bo_fichahomologada)
                                                            <th class="col-xs-1 justificativa">Justificativa</th>
                                                        @endif
                                                        <th class="col-xs-1">Pontos</th>
                                                        <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php 
                                                    array_push($cabecalhosArray,'medalhas') ;
                                                @endphp
                                            @endif
                                            <tr id="medalha_{{$pontuacao->id}}">
                                                @if($contMedalha > 1)
                                                    <th>
                                                        <select onchange="atualizaInputNomeInterno('medalha{{$contMedalha}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contMedalha}}', 'ARQUIVO{{$pontuacao->nu_item}}_{{$contMedalha}}')" id= "medalha{{$contMedalha}}" name="MEDALHA{{$contMedalha}}[st_criterio]" class="form-control select2-container camposObrigatorios selectAdcional {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option value="">Selecione...</option>
                                                            <option value="SEMMEDALHA" {{($pontuacao->st_nomeinterno == "SEMMEDALHA") ? 'selected' : ''}}>Sem Medalhas</option>
                                                            <optgroup label="Medalhas Policial Militar">
                                                                <option value="MEDALHA30" {{($pontuacao->st_nomeinterno == "MEDALHA30") ? 'selected' : ''}}>Ouro (30 anos)</option>
                                                                <option value="MEDALHA20" {{($pontuacao->st_nomeinterno == "MEDALHA20") ? 'selected' : ''}}>Prata (20 anos)</option>
                                                                <option value="MEDALHA10" {{($pontuacao->st_nomeinterno == "MEDALHA10") ? 'selected' : ''}}>Bronze  (10 anos)</option>
                                                            </optgroup>
                                                            
                                                            <optgroup label="Medalhas Meritória">
                                                                <option value="MEDALHATIRADENTES" {{($pontuacao->st_nomeinterno == "MEDALHATIRADENTES") ? 'selected' : ''}}>Tiradentes</option>
                                                                <option value="MEDALHAPM" {{($pontuacao->st_nomeinterno == "MEDALHAPM") ? 'selected' : ''}}> Mérito Policial Militar</option>
                                                                <option value="MEDALHAGONZAGA" {{($pontuacao->st_nomeinterno == "MEDALHAGONZAGA") ? 'selected' : ''}}>Mérito Luiz Gonzaga</option>
                                                                <option value="MEDALHABENTO" {{($pontuacao->st_nomeinterno == "MEDALHABENTO") ? 'selected' : ''}}>Mérito Profissional Coronel Bento Manoel de Medeiros</option>
                                                                <option value="MEDALHAMILTONFREIRE" {{($pontuacao->st_nomeinterno == "MEDALHAMILTONFREIRE") ? 'selected' : ''}}>Mérito Acadêmico Coronel Milton Freire de Andrade</option>
                                                                <option value="MEDALHASAUDE" {{($pontuacao->st_nomeinterno == "MEDALHASAUDE") ? 'selected' : ''}}>Mérito da Saúde  Coronel PM Médico Pedro Germano Costa</option>
                                                                <option value="MEDALHAJUDICIARIA" {{($pontuacao->st_nomeinterno == "MEDALHAJUDICIARIA") ? 'selected' : ''}}>Mérito de Polícia Judiciária Militar Estadual</option>
                                                                <option value="MEDALHACAPELANIA" {{($pontuacao->st_nomeinterno == "MEDALHACAPELANIA") ? 'selected' : ''}}>Reconhecimento da Capelania Militar Cristo Rei</option>
                                                                <option value="MEDALHADESPORTIVA" {{($pontuacao->st_nomeinterno == "MEDALHADESPORTIVA") ? 'selected' : ''}}>Mérito Desportivo Militar Cabo PM Walter Silva</option>
                                                                <option value="MEDALHAHOSPITAL" {{($pontuacao->st_nomeinterno == "MEDALHAHOSPITAL") ? 'selected' : ''}}>Comemorativa do Hospital(HCCPG)</option>
                                                                <option value="MEDALHAMUSICAL" {{($pontuacao->st_nomeinterno == "MEDALHAMUSICAL") ? 'selected' : ''}}>Mérito Musical Tonheca Dantas </option>
                                                                <option value="MEDALHAOPERACIONAL" {{($pontuacao->st_nomeinterno == "MEDALHAOPERACIONAL") ? 'selected' : ''}}>Policial Militar do Mérito Operacional </option>
                                                                <option value="MEDALHACBOM" {{($pontuacao->st_nomeinterno == "MEDALHACBOM") ? "selected" : ''}}>Medalha Major José Osias da Silva (CBOM)</option>
                                                                <option value="MEDALHAAMBIENTAL" {{($pontuacao->st_nomeinterno == "MEDALHAAMBIENTAL") ? "selected" : ''}}>Mérito Ambiental Cap Gontijo</option>
                                                            </optgroup>
                                                        </select>
                                                    </th>
                                                @else
                                                    <th>
                                                        <select onchange="atualizaInputNomeInterno('medalha{{$contMedalha}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contMedalha}}', 'ARQUIVO{{$pontuacao->nu_item}}_{{$contMedalha}}')" id= "medalha{{$contMedalha}}" name="MEDALHA{{$contMedalha}}[st_criterio]" class="form-control select2-container camposObrigatorios selectAdcional {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option value="">Selecione...</option>
                                                            <option value="SEMMEDALHA" {{($pontuacao->st_nomeinterno == "SEMMEDALHA") ? 'selected' : ''}}>Sem Medalhas</option>
                                                            <optgroup label="Medalhas Policial Militar">
                                                                <option value="MEDALHA30" {{($pontuacao->st_nomeinterno == "MEDALHA30") ? 'selected' : ''}}>Ouro (30 anos)</option>
                                                                <option value="MEDALHA20" {{($pontuacao->st_nomeinterno == "MEDALHA20") ? 'selected' : ''}}>Prata (20 anos)</option>
                                                                <option value="MEDALHA10" {{($pontuacao->st_nomeinterno == "MEDALHA10") ? 'selected' : ''}}>Bronze  (10 anos)</option>
                                                            </optgroup>
                                                            
                                                            <optgroup label="Medalhas Meritória">
                                                                <option value="MEDALHATIRADENTES" {{($pontuacao->st_nomeinterno == "MEDALHATIRADENTES") ? 'selected' : ''}}>Tiradentes</option>
                                                                <option value="MEDALHAPM" {{($pontuacao->st_nomeinterno == "MEDALHAPM") ? 'selected' : ''}}> Mérito Policial Militar</option>
                                                                <option value="MEDALHAGONZAGA" {{($pontuacao->st_nomeinterno == "MEDALHAGONZAGA") ? 'selected' : ''}}>Mérito Luiz Gonzaga</option>
                                                                <option value="MEDALHABENTO" {{($pontuacao->st_nomeinterno == "MEDALHABENTO") ? 'selected' : ''}}>Mérito Profissional Coronel Bento Manoel de Medeiros</option>
                                                                <option value="MEDALHAMILTONFREIRE" {{($pontuacao->st_nomeinterno == "MEDALHAMILTONFREIRE") ? 'selected' : ''}}>Mérito Acadêmico Coronel Milton Freire de Andrade</option>
                                                                <option value="MEDALHASAUDE" {{($pontuacao->st_nomeinterno == "MEDALHASAUDE") ? 'selected' : ''}}>Mérito da Saúde  Coronel PM Médico Pedro Germano Costa</option>
                                                                <option value="MEDALHAJUDICIARIA" {{($pontuacao->st_nomeinterno == "MEDALHAJUDICIARIA") ? 'selected' : ''}}>Mérito de Polícia Judiciária Militar Estadual</option>
                                                                <option value="MEDALHACAPELANIA" {{($pontuacao->st_nomeinterno == "MEDALHACAPELANIA") ? 'selected' : ''}}>Reconhecimento da Capelania Militar Cristo Rei</option>
                                                                <option value="MEDALHADESPORTIVA" {{($pontuacao->st_nomeinterno == "MEDALHADESPORTIVA") ? 'selected' : ''}}>Mérito Desportivo Militar Cabo PM Walter Silva</option>
                                                                <option value="MEDALHAHOSPITAL" {{($pontuacao->st_nomeinterno == "MEDALHAHOSPITAL") ? 'selected' : ''}}>Comemorativa do Hospital(HCCPG)</option>
                                                                <option value="MEDALHAMUSICAL" {{($pontuacao->st_nomeinterno == "MEDALHAMUSICAL") ? 'selected' : ''}}>Mérito Musical Tonheca Dantas </option>
                                                                <option value="MEDALHAOPERACIONAL" {{($pontuacao->st_nomeinterno == "MEDALHAOPERACIONAL") ? 'selected' : ''}}>Policial Militar do Mérito Operacional </option>
                                                                <option value="MEDALHACBOM" {{($pontuacao->st_nomeinterno == "MEDALHACBOM") ? "selected" : ''}}>Medalha Major José Osias da Silva (CBOM)</option>
                                                                <option value="MEDALHAAMBIENTAL" {{($pontuacao->st_nomeinterno == "MEDALHAAMBIENTAL") ? "selected" : ''}}>Mérito Ambiental Cap Gontijo</option>
                                                            </optgroup>
                                                        </select>
                                                    </th>
                                                @endif
                                                    <th>
                                                        <input name="MEDALHA{{$contMedalha}}[st_publicacao]" class=" bgMedalha form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}"/>
                                                    </th>
                                                    @if($pontuacao->nu_ordem != 1)
                                                        <th class="col-md-1">
                                                            <button class="btn btn-danger" title="Remover Medalha" name="removeMedalha_{{$pontuacao->id}}" id="removeMedalha_{{$pontuacao->id}}" onclick="removeMedalha({{$pontuacao->id}})">Remover</button>
                                                        </th>
                                                    @else
                                                        <th class="col-md-1">
                                                        </th>
                                                    @endif
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            NÃO
                                                        @endif
                                                    </th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="justificativa">
                                                        {{$pontuacao->st_justificativa or ''}}
                                                        </th>
                                                    @endif
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @php 
                                                        $achouArquivo = false;
                                                    @endphp
                                                
                                                    @if(isset($arquivos) && count($arquivos) > 0)
                                                    
                                                        @foreach ($arquivos as $chave => $a)
                                                    
                                                            @if ( $a->st_descricao === $gambiarraDoJuan || $a->st_descricao == $pontuacao->st_nomeinterno )

                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}_{{$contMedalha}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contMedalha}}[id]" value="{{$a->id}}" hidden>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}_{{$contMedalha}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contMedalha}}[st_descricao]" value="{{$pontuacao->st_nomeinterno or ''}}" hidden>
                                                                    <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> 
                                                                    </button>
                                                                </td>

                                                                @php
                                                                // unset($arquivos[$chave]);
                                                                    $achouArquivo = true;
                                                                @endphp
                                                                @break;

                                                            @endif
                                                        @endforeach

                                                    @endif

                                                    @if (!$achouArquivo)
                                                        <th id="ARQUIVO{{$pontuacao->nu_item}}_{{$contMedalha}}">
                                                            <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}_{{$contMedalha}}', '{{$pontuacao->st_nomeinterno or ''}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contMedalha}}')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contMedalha}}[st_path]" accept="application/pdf">
                                                            <input value="{{$pontuacao->st_nomeinterno or ''}}" type="text" id="input_nome_interno_{{$pontuacao->nu_item}}_{{$contMedalha}}" hidden>
                                                        </th>  
                                                    @endif 

                                                </tr>
                                            @if($ficha->pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                                <!-- Fechando tabela de medalhas -->
                                                    <tr id="linhaFinalMedalha">
                                                        <th>
                                                            <button class="btn btn-success" name="adicionaMedalha" id="adicionaMedalha" title="Adicionar Medalha" onclick="adicionaLinha('Medalha')" type="button">
                                                                <i class="fa fa-plus"></i> Adicionar Medalha
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
                                                    <th class="col-xs-1">Homologado</th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="col-xs-1 justificativa">Justificativa</th>
                                                    @endif
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th class="form-inline">
                                                        <select id="sangue" name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control select2-container {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option value="" selected>Selecione...</option>
                                                            <option value="SIM" {{($pontuacao->st_criterio == "SIM") ? 'selected' : ''}}>Sim</option>
                                                            <option value="NAO" {{($pontuacao->st_criterio == "NAO") ? 'selected' : ''}}>Não</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input id="bgSangue" name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            NÃO
                                                        @endif
                                                    </th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="justificativa">
                                                        {{$pontuacao->st_justificativa or ''}}
                                                        </th>
                                                    @endif
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @php $achouArquivo = false; @endphp

                                                    @if(isset($arquivos) && count($arquivos) > 0)

                                                        @foreach ($arquivos as $chave => $a)
                                                            @if ($a->st_descricao === 'doc05' || $a->st_descricao == $pontuacao->st_nomeinterno)

                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}[id]" value="{{$a->id}}" hidden>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}[st_descricao]" value="doc05" hidden>
                                                                    <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> 
                                                                    </button>
                                                                </td>

                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                    $achouArquivo = true;
                                                                @endphp

                                                                @break
                                                            @endif
                                                        @endforeach

                                                    @endif

                                                    @if (!$achouArquivo)
                                                        <th id="ARQUIVO{{$pontuacao->nu_item}}">
                                                            <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}', 'doc05')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}[st_path]" accept="application/pdf">
                                                        </th>  
                                                    @endif 

                                                </tr>
                                            </tbody>
                                        </table>
                                        @break
                                    @case(6) <!-- Atividades de Instrutor ou Monitor -->
                                            @php
                                                $contInstrucao++;
                                            @endphp
                                            @if(!in_array('atividadeInstrutorMonitor',$cabecalhosArray))
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th class="col-xs-2">6 - Atividade de Instrutor ou Monitor</th>
                                                        <th class="col-xs-1">Carga Horária</th>
                                                        <th>Data de início</th>
                                                        <th>Data de término</th>
                                                        <th>BG de Designação</th>
                                                        <th>Ação</th>
                                                        <th class="col-xs-1">Homologado</th>
                                                        @if($policialDoQuadro->bo_fichahomologada)
                                                            <th class="col-xs-1 justificativa">Justificativa</th>
                                                        @endif
                                                        <th class="col-xs-1">Pontos</th>
                                                        <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php 
                                                    array_push($cabecalhosArray,'atividadeInstrutorMonitor') ;
                                                @endphp
                                            @endif
                                            <tr id="atividade_{{$pontuacao->id}}">
                                                @if($contInstrucao > 1)
                                                    <th>
                                                        <select onchange="atualizaInputNomeInterno('atividade{{$contInstrucao}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contInstrucao}}', 'ARQUIVO{{$pontuacao->nu_item}}_{{$contInstrucao}}')" id="atividade{{$contInstrucao}}" name="INSTRUCAO{{$contInstrucao}}[st_label]" class="form-control select2-container camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option value="" selected>Selecione...</option>
                                                            <option value="INSTRUTOR" {{($pontuacao->st_label == "INSTRUTOR") ? 'selected' : ''}}>Instrutor</option>
                                                            <option value="MONITOR" {{($pontuacao->st_label == "MONITOR") ? 'selected' : ''}}>Monitor</option>
                                                        </select>
                                                    </th>
                                                @else
                                                    <th>
                                                        <select onchange="atualizaInputNomeInterno('atividade{{$contInstrucao}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contInstrucao}}', 'ARQUIVO{{$pontuacao->nu_item}}_{{$contInstrucao}}')" id="atividade{{$contInstrucao}}" name="INSTRUCAO{{$contInstrucao}}[st_label]" class="form-control select2-container camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option value="" selected>Selecione...</option>
                                                            <option value="SEMATIVIDADE" {{($pontuacao->st_label == "Sem atividade") ? 'selected' : ''}}>Sem atividade</option>'
                                                            <option value="INSTRUTOR" {{($pontuacao->st_label == "INSTRUTOR") ? 'selected' : ''}}>Instrutor</option>
                                                            <option value="MONITOR" {{($pontuacao->st_label == "MONITOR") ? 'selected' : ''}}>Monitor</option>
                                                        </select>
                                                    </th>
                                                @endif
                                                <th>
                                                    <input name="INSTRUCAO{{$contInstrucao}}[st_criterio]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="number" min="0" value="{{$pontuacao->st_criterio}}">
                                                </th>
                                                <th>
                                                    @if(!empty($pontuacao->st_campo))
                                                        <input name="INSTRUCAO{{$contInstrucao}}[st_campo1]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="date" value="{{explode(';', $pontuacao->st_campo)[0]}}">
                                                    @else
                                                        <input name="INSTRUCAO{{$contInstrucao}}[st_campo1]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="date" value="">
                                                    @endif
                                                </th>
                                                <th>
                                                    @if(!empty($pontuacao->st_campo))
                                                        <input name="INSTRUCAO{{$contInstrucao}}[st_campo2]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="date" value="{{explode(';', $pontuacao->st_campo)[1]}}">
                                                    @else
                                                        <input name="INSTRUCAO{{$contInstrucao}}[st_campo2]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="date" value="">
                                                    @endif
                                                </th>
                                                <th>
                                                    <input name="INSTRUCAO{{$contInstrucao}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} atividade" type="text" value="{{$pontuacao->st_publicacao}}">
                                                </th>
                                                @if($pontuacao->nu_ordem != 1)
                                                    <th class="col-md-1">
                                                        <button class="btn btn-danger" title="Remover Atividade" name="removeAtividade_{{$pontuacao->id}}" id="removeAtividade_{{$pontuacao->id}}" onclick="removeAtividade({{$pontuacao->id}})">Remover</button>
                                                    </th>
                                                @else
                                                    <th class="col-md-1">
                                                    </th>
                                                @endif
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        NÃO
                                                    @endif
                                                </th>
                                                @if($policialDoQuadro->bo_fichahomologada)
                                                    <th class="justificativa">
                                                    {{$pontuacao->st_justificativa or ''}}
                                                    </th>
                                                @endif
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                </th>

                                                @php 
                                                    $achouArquivo = false;
                                                @endphp
                                                
                                                @if(isset($arquivos) && count($arquivos) > 0)

                                                    @foreach ($arquivos as $chave => $a)
                                                    
                                                        @if ( $a->st_descricao === $gambiarraDoJuan || $a->st_descricao == $pontuacao->st_nomeinterno )
                                                        
                                                            <td class="text-center">
                                                                <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                <input id="ARQUIVO{{$pontuacao->nu_item}}_{{$contInstrucao}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contInstrucao}}[id]" value="{{$a->id}}" hidden>
                                                                <input id="ARQUIVO{{$pontuacao->nu_item}}_{{$contInstrucao}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contInstrucao}}[st_descricao]" value="{{$pontuacao->st_nomeinterno or ''}}" hidden>
                                                                <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i> 
                                                                </button>
                                                            </td>

                                                            @php
                                                            // unset($arquivos[$chave]);
                                                                $achouArquivo = true;
                                                            @endphp

                                                            @break
                                                        @endif
                                                    @endforeach

                                                @endif
                                                            
                                                @if (!$achouArquivo)
                                                    <th id="ARQUIVO{{$pontuacao->nu_item}}_{{$contInstrucao}}">
                                                        <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}_{{$contInstrucao}}', '{{$pontuacao->st_label or ''}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contInstrucao}}')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contInstrucao}}[st_path]" accept="application/pdf">
                                                        <input value="{{$pontuacao->st_nomeinterno or ''}}" type="text" id="input_nome_interno_{{$pontuacao->nu_item}}_{{$contInstrucao}}" hidden>
                                                    </th>  
                                                @endif 

                                            </tr>
                                            

                                            @if($ficha->pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                                        <tr id="linhaFinalAtividade">
                                                            <th>
                                                                <button class="btn btn-success" name="adicionaAtividade" id="adicionaAtividade" title="Adicionar Atividade" onclick="adicionaLinha('Atividade')" type="button">
                                                                    <i class="fa fa-plus"></i> Adicionar Atividade
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
                                                    <th class="col-xs-3">7 - Teste de Condicionamento Físico</th>
                                                    <th>BG de Publicação</th>
                                                    <th class="col-xs-1">Homologado</th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="col-xs-1 justificativa">Justificativa</th>
                                                    @endif
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th class="form-inline">
                                                        Resultado: 
                                                        <select id="taf" name="{{$pontuacao->st_nomeinterno}}[st_criterio]" class="form-control select2-container {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option selected="selected" value="">Selecione...</option>
                                                            <option value="FALTOU" {{($pontuacao->st_criterio == "FALTOU") ? 'selected' : ''}}>Faltou</option>
                                                            <option value="APTO" {{($pontuacao->st_criterio == "APTO") ? 'selected' : ''}}>Apto</option>
                                                            <option value="INAPTO" {{($pontuacao->st_criterio == "INAPTO") ? 'selected' : ''}}>Inapto</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input id="bgTaf" name="{{$pontuacao->st_nomeinterno}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            NÃO
                                                        @endif
                                                    </th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="justificativa">
                                                        {{$pontuacao->st_justificativa or ''}}
                                                        </th>
                                                    @endif
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @php $achouArquivo = false; @endphp

                                                    @if(isset($arquivos) && count($arquivos) > 0)

                                                        @foreach ($arquivos as $chave => $a)
                                                            @if ($a->st_descricao === 'doc07' || $a->st_descricao == $pontuacao->st_nomeinterno)

                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}[id]" value="{{$a->id}}" hidden>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}[st_descricao]" value="doc07" hidden>
                                                                    <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> 
                                                                    </button>
                                                                </td>

                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                    $achouArquivo = true;
                                                                @endphp

                                                                @break
                                                            @endif
                                                        @endforeach

                                                    @endif

                                                    @if (!$achouArquivo)
                                                        <th id="ARQUIVO{{$pontuacao->nu_item}}">
                                                            <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}', 'doc07')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}[st_path]" accept="application/pdf">
                                                        </th>  
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
                                                    <th class="col-xs-1">Homologado</th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="col-xs-1 justificativa">Justificativa</th>
                                                    @endif
                                                    <th class="col-xs-1">Pontos</th>
                                                    <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        <select id="formacao" name="FORMACAO[st_criterio]" class="form-control select2-container {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option selected="selected" value="">Selecione...</option>
                                                            <option value="SEMFORMACAO" {{($pontuacao->st_criterio == "SEMFORMACAO") ? 'selected' : ''}}>Sem formação</option>
                                                            <option value="FORMACAOGRADUADO" {{($pontuacao->st_criterio == "FORMACAOGRADUADO") ? 'selected' : ''}}>Graduação</option>
                                                            <option value="FORMACAOESPECIALISTA" {{($pontuacao->st_criterio == "FORMACAOESPECIALISTA") ? 'selected' : ''}}>Especialização</option>
                                                            <option value="FORMACAOMESTRE" {{($pontuacao->st_criterio == "FORMACAOMESTRE") ? 'selected' : ''}}>Mestrado</option>
                                                            <option value="FORMACAODOUTOR" {{($pontuacao->st_criterio == "FORMACAODOUTOR") ? 'selected' : ''}}>Doutorado</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input id="bgFormacao" name="FORMACAO[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            NÃO
                                                        @endif
                                                    </th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="justificativa">
                                                        {{$pontuacao->st_justificativa or ''}}
                                                        </th>
                                                    @endif
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @php $achouArquivo = false; @endphp

                                                    @if(isset($arquivos) && count($arquivos) > 0)

                                                        @foreach ($arquivos as $chave => $a)
                                                            @if ($a->st_descricao === 'doc08' || $a->st_descricao == $pontuacao->st_nomeinterno)

                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}[id]" value="{{$a->id}}" hidden>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}[st_descricao]" value="doc08" hidden>
                                                                    <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> 
                                                                    </button>
                                                                </td>

                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                    $achouArquivo = true;
                                                                @endphp

                                                                @break
                                                            @endif
                                                        @endforeach

                                                    @endif

                                                    @if (!$achouArquivo)
                                                        <th id="ARQUIVO{{$pontuacao->nu_item}}">
                                                            <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}', 'doc08')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}[st_path]" accept="application/pdf">
                                                        </th>  
                                                    @endif 

                                                </tr>
                                            </tbody>
                                        </table>
                                        @break
                                    @case(9) <!-- Cursos com Aplicabilidade à Caserna -->
                                            @php
                                                $contCurso++;
                                            @endphp
                                            @if(!in_array('cursos',$cabecalhosArray))
                                                <table class="table table-bordered">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th class="col-xs-3">9 - Curso com Aplicabilidade à Caserna</th>
                                                        <th class="col-xs-2">Nome do curso</th>
                                                        <th>BG de Designação</th>
                                                        <th class="col-md-1">Ação</th>
                                                        <th class="col-xs-1">Homologado</th>
                                                        @if($policialDoQuadro->bo_fichahomologada)
                                                            <th class="col-xs-1 justificativa">Justificativa</th>
                                                        @endif
                                                        <th class="col-xs-1">Pontos</th>
                                                        <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php 
                                                    array_push($cabecalhosArray,'cursos') ;
                                                @endphp
                                            @endif    
                                            <tr id="curso_{{$pontuacao->id}}">
                                                @if($contCurso > 1)
                                                    <th>
                                                        <select onchange="atualizaInputNomeInterno('curso{{$contCurso}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contCurso}}', 'ARQUIVO{{$pontuacao->nu_item}}_{{$contCurso}}')" id="curso{{$contCurso}}" name="CURSO{{$contCurso}}[st_label]" class="form-control select2-container selectAdcional {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option selected="selected" value="">Selecione...</option>
                                                            <option value="CURSO30" {{($pontuacao->st_label == "CURSO30") ? 'selected' : ''}}>CH igual ou superior a 30h</option>
                                                            <option value="CURSO60" {{($pontuacao->st_label == "CURSO60") ? 'selected' : ''}}>CH igual ou superior a 60h</option>
                                                            <option value="CURSO100" {{($pontuacao->st_label == "CURSO100") ? 'selected' : ''}}>CH igual ou superior a 100h</option>
                                                        </select>
                                                    </th>
                                                @else
                                                    <th>
                                                        <select onchange="atualizaInputNomeInterno('curso{{$contCurso}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contCurso}}', 'ARQUIVO{{$pontuacao->nu_item}}_{{$contCurso}}')" id="curso{{$contCurso}}" name="CURSO{{$contCurso}}[st_label]" class="form-control select2-container selectAdcional {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option selected="selected" value="">Selecione...</option>
                                                            <option value="Sem curso" {{($pontuacao->st_label == "Sem curso") ? 'selected' : ''}}>Sem curso</option>
                                                            <option value="CURSO30" {{($pontuacao->st_label == "CURSO30") ? 'selected' : ''}}>CH igual ou superior a 30h</option>
                                                            <option value="CURSO60" {{($pontuacao->st_label == "CURSO60") ? 'selected' : ''}}>CH igual ou superior a 60h</option>
                                                            <option value="CURSO100" {{($pontuacao->st_label == "CURSO100") ? 'selected' : ''}}>CH igual ou superior a 100h</option>
                                                        </select>
                                                    </th>
                                                @endif
                                                <th>
                                                    <input name="CURSO{{$contCurso}}[st_criterio]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} curso" type="text" value="{{$pontuacao->st_criterio}}">
                                                </th>
                                                <th>
                                                    <input name="CURSO{{$contCurso}}[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}} curso" type="text" value="{{$pontuacao->st_publicacao}}">
                                                </th>
                                                @if($pontuacao->nu_ordem != 1)
                                                    <th class="col-md-1">
                                                        <button class="btn btn-danger" title="Remover Curso" name="removeCurso_{{$pontuacao->id}}" id="removeCurso_{{$pontuacao->id}}" onclick="removeCurso({{$pontuacao->id}})">Remover</button>
                                                    </th>
                                                @else
                                                    <th class="col-md-1">
                                                    </th>
                                                @endif
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        NÃO
                                                    @endif
                                                </th>
                                                @if($policialDoQuadro->bo_fichahomologada)
                                                    <th class="justificativa">
                                                    {{$pontuacao->st_justificativa or ''}}
                                                    </th>
                                                @endif
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                </th>

                                                @php 
                                                    $achouArquivo = false; 
                                                
                                                @endphp

                                                    @if(isset($arquivos) && count($arquivos) > 0)
                                                    
                                                        @foreach ($arquivos as $chave => $a)
                                                            @php 
                                                                $gambiarraDoJazon = '1'.$a->st_descricao ;
                                                               // echo $a->st_descricao;
                                                            @endphp
                                                            @if (   $a->st_descricao === $gambiarraDoJuan 
                                                                    || $a->st_descricao == $pontuacao->st_nomeinterno 
                                                                    || $gambiarraDoJazon == $pontuacao->st_nomeinterno  )

                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}_{{$contCurso}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contCurso}}[id]" value="{{$a->id}}" hidden>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}_{{$contCurso}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contCurso}}[st_descricao]" value="{{$pontuacao->st_label or ''}}" hidden>
                                                                    <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> 
                                                                    </button>
                                                                </td>

                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                    $achouArquivo = true;
                                                                @endphp

                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @else

                                                    @endif

                                                    @if (!$achouArquivo)
                                                        <th id="ARQUIVO{{$pontuacao->nu_item}}_{{$contCurso}}">
                                                            <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}_{{$contCurso}}', '{{$pontuacao->st_label or ''}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contCurso}}')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contCurso}}[st_path]" accept="application/pdf">
                                                            <input value="{{$pontuacao->st_label or ''}}" type="text" id="input_nome_interno_{{$pontuacao->nu_item}}_{{$contCurso}}" hidden>
                                                        </th>  
                                                    @endif 

                                            </tr>
                                            @if($ficha->pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                                        <tr id="linhaFinalCurso">
                                                            <th>
                                                                <button class="btn btn-success" name="adicionaCurso" id="adicionaCurso" title="Adicionar Curso" onclick="adicionaLinha('Curso')" type="button">
                                                                    <i class="fa fa-plus"></i> Adicionar Curso
                                                                </button>
                                                            </th><th></th><th></th>
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
                                                        <th class="col-xs-3">10 - Contribuição Científica de Caráter Técnico Profissional (Aprovada pela Diretoria de Ensino da PMRN)</th>
                                                        <th>BG de Publicação</th>
                                                        <th class="col-xs-1">Homologado</th>
                                                        @if($policialDoQuadro->bo_fichahomologada)
                                                            <th class="col-xs-1 justificativa">Justificativa</th>
                                                        @endif
                                                        <th class="col-xs-1">Pontos</th>
                                                        <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            @php 
                                                array_push($cabecalhosArray,'cientificos') ;
                                            @endphp
                                        @endif   

                                
                                                @if ( isset($pontuacao->st_nomeinterno) && 
                                                    (in_array($pontuacao->st_nomeinterno, ['SEMCIENTIFICO','CIENTIFICOGRADUACAO','CIENTIFICOESPECIALIZACAO','CIENTIFICOMESTRADO','CIENTIFICODOUTOR']))
                                                )
                                                    <!-- TODO - Verificar algoritmo para impedir duplicar registro -->
                                                    <tr>
                                                        <th>
                                                            <select id="cientifico" name="CIENTIFICO1[st_criterio]" class="form-control select2-container {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                                <option selected="selected" value="">Selecione...</option>
                                                                <option value="SEMCIENTIFICO" {{($pontuacao->st_criterio == "SEMCIENTIFICO") ? 'selected' : ''}}>Sem TCC</option>
                                                                <option value="CIENTIFICOGRADUACAO" {{($pontuacao->st_criterio == "CIENTIFICOGRADUACAO") ? 'selected' : ''}}>TCC em Graduação</option>
                                                                <option value="CIENTIFICOESPECIALIZACAO" {{($pontuacao->st_criterio == "CIENTIFICOESPECIALIZACAO") ? 'selected' : ''}}>TCC em Especialização</option>
                                                                <option value="CIENTIFICOMESTRADO" {{($pontuacao->st_criterio == "CIENTIFICOMESTRADO") ? 'selected' : ''}}>TCC em Mestrado</option>
                                                                <option value="CIENTIFICODOUTOR" {{($pontuacao->st_criterio == "CIENTIFICODOUTOR") ? 'selected' : ''}}>TCC em Doutorado</option>
                                                            </select>
                                                        </th>
                                                        <th>
                                                            <input id="bgCientifico" name="CIENTIFICO1[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                        </th>
                                                        <th class="text-center">
                                                            @if($pontuacao->bo_pontohomologado)
                                                                @if($pontuacao->bo_pontoaceito == "1")
                                                                    <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                                @elseif($pontuacao->bo_pontoaceito == "0")
                                                                    <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                                @endif
                                                            @else 
                                                                NÃO
                                                            @endif
                                                        </th>
                                                        @if($policialDoQuadro->bo_fichahomologada)
                                                            <th class="justificativa">
                                                            {{$pontuacao->st_justificativa or ''}}
                                                            </th>
                                                        @endif
                                                        <th>
                                                            <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                        </th>

                                                        @php $achouArquivo = false; @endphp

                                                        @if(isset($arquivos) && count($arquivos) > 0)

                                                            @foreach ($arquivos as $chave => $a)
                                                                @if ($a->st_descricao === 'doc_tcc' || $a->st_descricao == $pontuacao->st_nomeinterno)

                                                                    <td class="text-center">
                                                                        <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                        <input id="ARQUIVO{{$pontuacao->nu_item}}_1[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_1[id]" value="{{$a->id}}" hidden>
                                                                        <input id="ARQUIVO{{$pontuacao->nu_item}}_1[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_1[st_descricao]" value="doc_tcc" hidden>
                                                                        <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                            <i class="fa fa-trash"></i> 
                                                                        </button>
                                                                    </td>

                                                                    @php
                                                                        unset($arquivos[$chave]);
                                                                        $achouArquivo = true;
                                                                    @endphp

                                                                    @break
                                                                @endif
                                                            @endforeach

                                                        @endif

                                                        @if (!$achouArquivo)
                                                            <th id="ARQUIVO{{$pontuacao->nu_item}}_1">
                                                                <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}_1', 'doc_tcc')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}_1[st_path]" accept="application/pdf">
                                                            </th>  
                                                        @endif 

                                                    </tr>
                                                @elseif ( isset($pontuacao->st_nomeinterno) 
                                                
                                                && 
                                                    (in_array($pontuacao->st_nomeinterno, ['SEMCIENTIFICOARTIGO','CIENTIFICOARTIGO']))
                                                )
                                                    <tr>
                                                        <th>
                                                            <select id="cientifico" name="CIENTIFICO2[st_criterio]" class="form-control select2-container {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                                <option selected="selected" value="">Selecione...</option>
                                                                <option value="SEMCIENTIFICOARTIGO" {{($pontuacao->st_criterio == "SEMCIENTIFICOARTIGO") ? 'selected' : ''}}>Sem Artigo Publicado</option>
                                                                <option value="CIENTIFICOARTIGO" {{($pontuacao->st_criterio == "CIENTIFICOARTIGO") ? 'selected' : ''}}>Artigo Publicado em Periódicos</option>
                                                            </select> 
                                                        </th>
                                                        <th>
                                                            <input id="bgCientifico" name="CIENTIFICO2[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                        </th>
                                                        <th class="text-center">
                                                            @if($pontuacao->bo_pontohomologado)
                                                                @if($pontuacao->bo_pontoaceito == "1")
                                                                    <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                                @elseif($pontuacao->bo_pontoaceito == "0")
                                                                    <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                                @endif
                                                            @else 
                                                                NÃO
                                                            @endif
                                                        </th>
                                                        @if($policialDoQuadro->bo_fichahomologada)
                                                            <th class="justificativa">
                                                            {{$pontuacao->st_justificativa or ''}}
                                                            </th>
                                                        @endif
                                                        <th>
                                                            <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                        </th>

                                                        @php $achouArquivo = false; @endphp

                                                        @if(isset($arquivos) && count($arquivos) > 0)

                                                            @foreach ($arquivos as $chave => $a)
                                                                @if ($a->st_descricao === 'doc_artigo' || $a->st_descricao == $pontuacao->st_nomeinterno)

                                                                    <td class="text-center">
                                                                        <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                        <input id="ARQUIVO{{$pontuacao->nu_item}}_2[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_2[id]" value="{{$a->id}}" hidden>
                                                                        <input id="ARQUIVO{{$pontuacao->nu_item}}_2[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_2[st_descricao]" value="doc_artigo" hidden>
                                                                        <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                            <i class="fa fa-trash"></i> 
                                                                        </button>
                                                                    </td>

                                                                    @php
                                                                        unset($arquivos[$chave]);
                                                                        $achouArquivo = true;
                                                                    @endphp

                                                                    @break
                                                                @endif
                                                            @endforeach

                                                        @endif

                                                        @if (!$achouArquivo)
                                                            <th id="ARQUIVO{{$pontuacao->nu_item}}_2">
                                                                <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}_2', 'doc_artigo')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}_2[st_path]" accept="application/pdf">
                                                            </th>  
                                                        @endif 

                                                    </tr>
                                                @elseif ( isset($pontuacao->st_nomeinterno) 
                                                && 
                                                    (in_array($pontuacao->st_nomeinterno, ['SEMCIENTIFICOLIVRO','CIENTIFICOLIVRO']))
                                                )
                                                <tr>
                                                    <th>
                                                        <select id="cientifico" name="CIENTIFICO3[st_criterio]" class="form-control select2-container {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option selected="selected" value="">Selecione...</option>
                                                            <option value="SEMCIENTIFICOLIVRO" {{($pontuacao->st_criterio == "SEMCIENTIFICOLIVRO") ? 'selected' : ''}}>Sem Livro Publicado</option>
                                                            <option value="CIENTIFICOLIVRO" {{($pontuacao->st_criterio == "CIENTIFICOLIVRO") ? 'selected' : ''}}>Livro Publicado</option>
                                                        </select> 
                                                    </th>
                                                    <th>
                                                        <input id="bgCientifico" name="CIENTIFICO3[st_publicacao]" class="form-control {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                    </th>
                                                    <th class="text-center">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            @if($pontuacao->bo_pontoaceito == "1")
                                                                <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                            @elseif($pontuacao->bo_pontoaceito == "0")
                                                                <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                            @endif
                                                        @else 
                                                            NÃO
                                                        @endif
                                                    </th>
                                                    @if($policialDoQuadro->bo_fichahomologada)
                                                        <th class="justificativa">
                                                        {{$pontuacao->st_justificativa or ''}}
                                                        </th>
                                                    @endif
                                                    <th>
                                                        <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                    </th>

                                                    @php $achouArquivo = false; @endphp

                                                    @if(isset($arquivos) && count($arquivos) > 0)

                                                        @foreach ($arquivos as $chave => $a)
                                                            @if ($a->st_descricao === 'doc_livro' || $a->st_descricao == $pontuacao->st_nomeinterno)

                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}_3[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_3[id]" value="{{$a->id}}" hidden>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}_3[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_3[st_descricao]" value="doc_livro" hidden>
                                                                    <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> 
                                                                    </button>
                                                                </td>

                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                    $achouArquivo = true;
                                                                @endphp

                                                                @break
                                                            @endif
                                                        @endforeach

                                                    @endif

                                                    @if (!$achouArquivo)
                                                        <th id="ARQUIVO{{$pontuacao->nu_item}}_3">
                                                            <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}_3', 'doc_livro')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}_3[st_path]" accept="application/pdf">
                                                        </th>  
                                                    @endif 

                                                </tr>

                                                @else
                                                <!-- Não faz nada-->
                                                    
        
                                                @endif

                                            @if($ficha->pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                                    </tbody>
                                                </table>
                                            @endif
                                        @break
                                    @case(11) <!-- Punições -->
                                            @php
                                                $contPunicao++;
                                            @endphp
                                            @if(!in_array('punicao',$cabecalhosArray))
                                                <table class="table table-bordered">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th class="col-xs-3">11 - Punições</th>
                                                        <th>BG de Designação</th>
                                                        <th class="col-xs-1">Ação</th>
                                                        <th class="col-xs-1">Homologado</th>
                                                        @if($policialDoQuadro->bo_fichahomologada)
                                                            <th class="col-xs-1 justificativa">Justificativa</th>
                                                        @endif
                                                        <th class="col-xs-1">Pontos</th>
                                                        <th class="col-xs-2">Documentos <br> (Deve ser PDF com no máximo 512 KB)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php 
                                                    array_push($cabecalhosArray,'punicao') ;
                                                @endphp
                                            @endif
                                            <tr id="punicao_{{$pontuacao->id}}">
                                                @if($contPunicao > 1)
                                                    <th>
                                                        <select onchange="atualizaInputNomeInterno('punicao{{$contPunicao}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contPunicao}}', 'ARQUIVO{{$pontuacao->nu_item}}_{{$contPunicao}}')" id="punicao{{$contPunicao}}" name="PUNICAO{{$contPunicao}}[st_criterio]" class="form-control select2-container camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option selected="selected" value="">Selecione...</option>
                                                            <option value="REPREENSAO" {{($pontuacao->st_criterio == "REPREENSAO") ? 'selected' : ''}}>Repreensão</option>
                                                            <option value="DETENCAO" {{($pontuacao->st_criterio == "DETENCAO") ? 'selected' : ''}}>Detenção</option>
                                                            <option value="PRISAO" {{($pontuacao->st_criterio == "PRISAO") ? 'selected' : ''}}>Prisão</option>
                                                        </select>
                                                    </th>
                                                @else
                                                    <th>
                                                        <select onchange="atualizaInputNomeInterno('punicao{{$contPunicao}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contPunicao}}', 'ARQUIVO{{$pontuacao->nu_item}}_{{$contPunicao}}')" id="punicao{{$contPunicao}}" name="PUNICAO{{$contPunicao}}[st_criterio]" class="form-control select2-container camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}">
                                                            <option selected="selected" value="">Selecione...</option>
                                                            <option value="SEMPUNICAO" {{($pontuacao->st_criterio == "SEMPUNICAO") ? 'selected' : ''}}>Sem punição</option>
                                                            <option value="REPREENSAO" {{($pontuacao->st_criterio == "REPREENSAO") ? 'selected' : ''}}>Repreensão</option>
                                                            <option value="DETENCAO" {{($pontuacao->st_criterio == "DETENCAO") ? 'selected' : ''}}>Detenção</option>
                                                            <option value="PRISAO" {{($pontuacao->st_criterio == "PRISAO") ? 'selected' : ''}}>Prisão</option>
                                                        </select>
                                                    </th>
                                                @endif
                                                    <th>
                                                        <input id="bgPunicao" name="PUNICAO{{$contPunicao}}[st_publicacao]" class="form-control camposObrigatorios {{$pontuacao->bo_pontoaceito === '0'?'intensAlteracao':''}}" type="text" value="{{$pontuacao->st_publicacao}}">
                                                    </th>
                                                    @if($pontuacao->nu_ordem != 1)
                                                        <th class="col-md-1">
                                                            <button class="btn btn-danger" title="Remover Punição" name="removePunicao_{{$pontuacao->id}}" id="removePunicao_{{$pontuacao->id}}" onclick="removePunicao({{$pontuacao->id}})">Remover</button>
                                                        </th>
                                                    @else
                                                        <th>
                                                        </th>
                                                    @endif
                                                <th class="text-center">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        @if($pontuacao->bo_pontoaceito == "1")
                                                            <span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>
                                                        @elseif($pontuacao->bo_pontoaceito == "0")
                                                            <span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>
                                                        @endif
                                                    @else 
                                                        NÃO
                                                    @endif
                                                </th>
                                                @if($policialDoQuadro->bo_fichahomologada)
                                                    <th class="justificativa">
                                                    {{$pontuacao->st_justificativa or ''}}
                                                    </th>
                                                @endif
                                                <th>
                                                    <span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>
                                                </th>

                                                @php $achouArquivo = false; @endphp

                                                    @if(isset($arquivos) && count($arquivos) > 0)

                                                        @foreach ($arquivos as $chave => $a)
                                                            
                                                            @if ( $a->st_descricao === $gambiarraDoJuan || $a->st_descricao == $pontuacao->st_nomeinterno )

                                                                <td class="text-center">
                                                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}_{{$contPunicao}}[id]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contPunicao}}[id]" value="{{$a->id}}" hidden>
                                                                    <input id="ARQUIVO{{$pontuacao->nu_item}}_{{$contPunicao}}[st_descricao]" type="text" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contPunicao}}[st_descricao]" value="{{$pontuacao->st_nomeinterno or ''}}" hidden>
                                                                    <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> 
                                                                    </button>
                                                                </td>

                                                                @php
                                                                    unset($arquivos[$chave]);
                                                                    $achouArquivo = true;
                                                                @endphp

                                                                @break
                                                            @endif
                                                        @endforeach

                                                    @endif

                                                    @if (!$achouArquivo)
                                                        <th id="ARQUIVO{{$pontuacao->nu_item}}_{{$contPunicao}}">
                                                            <input onchange="inserirDescricao('ARQUIVO{{$pontuacao->nu_item}}_{{$contPunicao}}', '{{$pontuacao->st_label or ''}}', 'input_nome_interno_{{$pontuacao->nu_item}}_{{$contPunicao}}')" type="file" class="form-control-file" name="ARQUIVO{{$pontuacao->nu_item}}_{{$contPunicao}}[st_path]" accept="application/pdf">
                                                        <input value="{{$pontuacao->st_nomeinterno or ''}}" type="text" id="input_nome_interno_{{$pontuacao->nu_item}}_{{$contPunicao}}" hidden>
                                                        </th>  
                                                    @endif 
<!-- TODO - desabilitar botões da ficha preliminar, e/ou todas quando o qa estiver fechado -->
<!-- TODO - verificar se o anexo dos pdf estão vinculados corretamente a ficha selecionada -->
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
                                <i class="fa fa-plus"></i> Adicionar Punição
                                </button>
                                </th><th></th><th>
                            </th>
                        </tr>
                              
                            </tbody>
                        </table>

                        <div style="text-align: right;">
                            <span class="form-control total text-white"><B>TOTAL GERAL DE PONTOS: {{$totalPontos}}</B></span>
                            <h6 class="text-danger"> * Pontos não homologados </h6> 
                        </div>
                        
                    </fieldset>


                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Certidão</legend>
                        <br><br>
                        
                        @php $achouArquivo = false; @endphp
                        
                        @if(isset($arquivos) && count($arquivos) > 0)

                            @foreach ($arquivos as $chave => $a)
                                @if ($a->st_descricao === "certidao_nada_consta_justica")

                                    
                                    <a href="{{url('promocao/escrituradaFicha/arquivo/'.$a->id.'/policial/'.$a->ce_policial)}}"> {{$a->st_descricao .'.pdf'}} </a>
                                    <input id="ARQUIVO_certidao_nada_consta_justica[id]" type="text" name="ARQUIVO_certidao_nada_consta_justica[id]" value="{{$a->id}}" hidden>
                                    <input id="ARQUIVO_certidao_nada_consta_justica[st_descricao]" type="text" name="ARQUIVO_certidao_nada_consta_justica[st_descricao]" value="certidao_nada_consta_justica" hidden>
                                    <button onclick="idDocumentoParaRemocao('{{$a->id}}', '{{$idAtividade}}', '{{$a->ce_policial}}', '{{$competencia}}')" title="Remover Arquivo" type="button" data-toggle="modal" data-target="#modalConcluirRemocaoDocumento" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> 
                                    </button>

                                    @php
                                        unset($arquivos[$chave]);
                                        $achouArquivo = true;
                                    @endphp

                                    @break
                                @endif
                            @endforeach

                        @endif

                        @if (!$achouArquivo)
                            <span id="ARQUIVO_certidao_nada_consta_justica">
                                <input onchange="inserirDescricao('ARQUIVO_certidao_nada_consta_justica', 'certidao_nada_consta_justica')" type="file" class="form-control-file" name="ARQUIVO_certidao_nada_consta_justica[st_path]" accept="application/pdf">
                            </span>
                        @endif  
                        <br><br>
                    </fieldset>

                   @endif
                    @if(empty(Request::segment(9))) 
                        <a href="{{url('promocao/fichasgtnaoenviada/'.$idQuadro.'/'.$idAtividade.'/competencia/'.$competencia)}}" title="Voltar" class="btn btn-warning">
                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar para listagem
                        </a> 
                    @else 
                        <a href="{{url('promocao/escriturarfichadereconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$policialDoQuadro->ce_policial.'/competencia/'.$competencia)}}" title="Voltar" class="btn btn-warning">
                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar para fichas
                        </a>
                    @endif

                    
                    @if(!empty(Request::segment(9))) 
                        @if($ficha->st_ficha == 'DEFINITIVA')


                            @if ($quadro->bo_escriturarliberado)
                            <!--  BOTÕES DESABILITADOS PROCURAR ADMINISTRADOR 
                                TODO - reimplementar as regras dos botões durante o período de escrituração; CODIGO ESTÁ NA ÁREA DE TRABALHO-->
                                @if (isset($ficha->dt_assinatura))
                                    @can('ASSINAR_FICHA_RECONHECIMENTO')
                                        @if (!isset($ficha->dt_envio))
                                            <button id="btnEnviarFicha" type="button" title="Enviar" class="btn btn-primary" data-toggle="modal" data-target="#modalConfirmarEnvio" >
                                                <span class="fa fa-send"></span> Enviar à CPP
                                            </button>
                                        @endif
                                    @endcan

                                @else
                                    <button type="submit" title="Salvar" class="btn btn-primary">
                                        <i class="fa fa-fw fa-save"></i> Salvar
                                    </button>
                                    @can('ASSINAR_FICHA_RECONHECIMENTO')
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assinarModal">
                                            <i class="fa fa-pencil"></i> Assinar Ficha
                                        </button>
                                    @endcan

                                @endif
                            @endif

                            @if ($quadro->bo_recursoliberado)
            
                                <!-- TODO - refatorar a ficha para as novas alterações quando em recurso -->
                                @if ($policialDoQuadro->bo_recorreu)
                                    @if(!$policialDoQuadro->bo_recursoenviado)
                                        @if(!$ficha->dt_assinatura)
                                            <button type="submit" title="Salvar" class="btn btn-primary">
                                                <i class="fa fa-fw fa-save"></i> Salvar correções
                                            </button>
                                        @endif
                                        @can('ASSINAR_FICHA_RECONHECIMENTO')
                                            @if(!$ficha->dt_assinatura)
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assinarModal">
                                                    <i class="fa fa-pencil"></i> Assinar correções
                                                </button>
                                            @else
                                                @if(!$policialDoQuadro->bo_recursoenviado)
                                                    <button id="btnEnviarFicha" type="button" title="Enviar" class="btn btn-primary" data-toggle="modal" data-target="#modalConfirmarEnvio" >
                                                        <span class="fa fa-send"></span> Enviar correções à CPP
                                                    </button>
                                                @endif
                                            @endif
                                        @endcan
                                    @endif
                                @endif
                            @endif
                        @endif

                        <!-- TODO - desabilitar botões de exclusão caso o militar não tenha recorrido caso esteja em período de escriturar ou recurso -->

                  
                        <a href="{{url('promocao/escriturarfichadereconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/'.$competencia.'/pdf/ficha/'.$ficha->id)}}" title="Visualizar PDF" class="btn btn-primary" target="_blank">
                            <span class="fa fa-file-pdf-o"></span> Visualizar PDF
                        </a>
                    @endif        
                </form>
            </div>
        </div>
    </div>
</div>

<!--Modal para concluir a remoção do documento-->
<div class="modal fade" id="modalConcluirRemocaoDocumento" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirmar a remoção do documento</h4>
                </div>
                <div class="modal-body bg-danger">
                    <h4 class="modal-title">Atenção!</h4>
                    <div classe>
                        Ao confirmar esta ação, não será possível recuperar o arquivo novamente.
                        <br><br>
                        Deseja continuar?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" title="Não" class="btn btn-warning" data-dismiss="modal">Não</button>
                    <button type="button" title="Sim" class="btn btn-primary" data-toggle="modal" data-target="#modalConcluirRemocaoCredenciais" data-dismiss="modal">
                        Sim
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal para confirmação da remoção do documento-->
    <div class="modal fade" id="modalConcluirRemocaoCredenciais" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Assinar remoção do documento</h4>
                </div>
                <div class="modal-body bg-danger">
                    <h4 class="modal-title">Atenção!</h4>
                    <div classe>
                        É necessario assinar eletronicamente a remoção do documento.
                    </div>
                </div>
                <div class="modal-body">
                    <form role="form" id="removerDoc" method="POST">
                        {{csrf_field()}}
                        <h4>Informe a Senha:</h4>
                        <input id="password" type="password" class="form-control" name="password" value="" placeholder="Digite sua senha...">
                        <br>
                        <div class="modal-footer">
                            <button type="button" title="Cancelar" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                            <button type="submit" title="Remover Arquivo" class="btn btn-primary">Remover</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Modal para confirmação de envio da ficha de reconhecimento-->
    <div class="modal fade" id="modalConfirmarEnvio" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirmar Envio?</h4>
                </div>
                <div class="modal-body">
                    <form action="{{url("promocao/enviarFichaEscriturada/$idQuadro/$idAtividade/$idPolicial/$competencia")}}" method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="password" class="col-md-2 control-label" style="margin-top: 5px;">Senha</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" name="password">
                                <input name="ce_ficha"  type="hidden" value="{{Request::segment(9)}}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-primary">
                        <button type="button" title="Cancelar" class="btn btn-warning" data-dismiss="modal">Não</button>
                        <button type="submit" title="Confirmar envio" class="btn btn-info">Sim</button>
                    </div>
                    </form>
                    {{-- <div class="modal-footer">
                        <button type="button" title="Cancelar" class="btn btn-warning" data-dismiss="modal">Não</button>
                        <button type="button" onclick="enviarFicha('{{$idQuadro}}', '{{$idAtividade}}', '{{$idPolicial}}', '{{$competencia}}')" title="Confirmar envio" class="btn btn-primary">Sim</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!--Modal para excluir uma certidão-->
    <div class="modal fade" id="modalExcluirCertidao" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirma exclusão da certidão?</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-footer">
                        <button type="button" title="Cancelar" class="btn btn-warning" data-dismiss="modal">Não</button>
                        <button type="button" onclick="retornarFichaEdicao('{{$idQuadro}}', '{{$idAtividade}}', '{{$idPolicial}}', '{{$competencia}}')" title="Confirmar retorno da Ficha para edição" class="btn btn-primary">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modal para confirmação de correção da ficha de reconhecimento-->
    <div class="modal fade" id="modalCorrigirFicha" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Retornar a Ficha para edição?</h4>
                </div>
                <div class="modal-body">
                    <div class="modal-footer">
                        <button type="button" title="Cancelar" class="btn btn-warning" data-dismiss="modal">Não</button>
                        <button type="button" onclick="retornarFichaEdicao('{{$idQuadro}}', '{{$idAtividade}}', '{{$idPolicial}}', '{{$competencia}}')" title="Confirmar retorno da Ficha para edição" class="btn btn-primary">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Moldal assinar ficha de reconhecimento -->
    <div class="modal fade" id="assinarModal" tabindex="-1" role="dialog" aria-labelledby="assinarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="assinarModalLabel">Assinar Ficha</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="{{route('assinaFichaReconhecimento', ['idQuadro' => $idQuadro, 'idPolicial' => $idPolicial])}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="password" class="col-md-2 control-label" style="margin-top: 5px;">Senha</label>
                        <div class="col-md-10">
                            <input type="password" class="form-control" name="password">
                        </div>
                        <input name="ce_ficha"  type="hidden" value="{{Request::segment(9)}}">
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">Assinar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
        
@stop
@section('css')
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }
    div {
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
    .intensAlteracao
    {
        border: solid 1px red;
    }
    .total
    {
        background-color:#808080;
    }
</style>
@stop
@section('js')
    <script>
        function excluirCertidao(idPolicial,idQuadro){

        }
    // Função para o form do modal de remover documento
        function idDocumentoParaRemocao($idArquivo, $idAtividade, $idPolicial, $competencia){
            $("#removerDoc").attr("action", "{{url('promocao/escrituradaFicha/atividade')}}/"+$idAtividade+"/arquivo/"+$idArquivo+"/policial/"+$idPolicial+"/competencia/"+$competencia);
        }

        /* //Função para enviar a ficha
        function enviarFicha(idQuadro, idAtividade, idPolicial, competencia){
            $("#form").attr("action", "{{url('promocao/enviarFichaEscriturada')}}/"+idQuadro+"/"+idAtividade+"/"+idPolicial+"/"+competencia);
            $("#form").submit();
        }; */

        //Função para retornar a ficha para edição
        function retornarFichaEdicao(idQuadro, idAtividade, idPolicial, competencia){
            $("#form").attr("action", "{{url('promocao/retornarFichaEscrituradaParaEdicao')}}/"+idQuadro+"/"+idAtividade+"/"+idPolicial+"/"+competencia);
            $("#form").submit();
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
                        $(".bgMedalha").removeAttr("required");
                        $('#adicionaMedalha').prop('disabled', true);
                    }else{
                        $(".bgMedalha").attr("required", false);
                        $('#adicionaMedalha').prop('disabled', false);
                    }
                    break;
                case "sangue":
                    if (valor === "NAO"){
                        $("#bgSangue").removeAttr("required");
                    }else{
                        $("#bgSangue").attr("required", false);
                    }
                    break;
                case "atividade1":
                    if (valor === "Sem atividade"){
                        $(".atividade").removeAttr("required");
                        $('#adicionaAtividade').prop('disabled', true);
                    }else{
                        $(".atividade").attr("required", false);
                        $('#adicionaAtividade').prop('disabled', false);
                    }
                    break;
                case "formacao":
                    if (valor === "SEMFORMACAO"){
                        $("#bgFormacao").removeAttr("required");
                    }else{
                        $("#bgFormacao").attr("required", false);
                    } 
                    break;
                case "curso1":
                    if (valor === "Sem curso"){
                        $(".curso").removeAttr("required");
                        $('#adicionaCurso').prop('disabled', true);
                    }else{
                        $(".curso").attr("required", false);
                        $('#adicionaCurso').prop('disabled', false);
                    } 
                    break;
                case "cientifico":
                    if (valor === "SEMCIENTIFICO"){
                        $("#bgCientifico").removeAttr("required");
                    }else{
                        $("#bgCientifico").attr("required", false);
                    }
                    break;
                case "punicao":
                    if (valor === "SEMPUNICAO"){
                        $("#bgPunicao").removeAttr("required");
                        $('#adicionaPunicao').prop('disabled', true);
                    }else{
                        $("#bgPunicao").attr("required", false);
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
        var idFinal = "{{collect($ficha->pontuacoes)->last()->id}}";
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
        
        @if(!empty(Request::segment(9))) 
        //Função para adicionar novos elementos nos itens
        function adicionaLinha(local, pontuacaoNuItem = null, nomeInterno = null){
            switch(local){
                case 'Medalha':
                    inputContMedalha = $('#input_contMedalha'+contadorMedalha).val()
                    if (inputContMedalha) {
                        contadorMedalha = $('#input_contMedalha').val()
                        contadorMedalha++
                    } else {
                        contadorMedalha++
                    }
                    idInputContMedalha = 'input_contMedalha_'+contadorMedalha
                    var text = '<tr id="medalha_'+idFinal+'">'+
                                    '<th>'+
                                        '<select onchange="atualizaInputNomeInterno(\'medalha'+contadorMedalha+'\', \'input_nome_interno_4_'+contadorMedalha+'\', \'ARQUIVO4_'+contadorMedalha+'\')" id="medalha'+contadorMedalha+'" name="MEDALHA'+contadorMedalha+'[st_criterio]" class="form-control select2-container selectAdcional">'+
                                            '<option value="">Selecione...</option>' +
                                            '<option value="SEMMEDALHA" {{($pontuacao->st_nomeinterno == "SEMMEDALHA") ? "selected" : ''}}>Sem Medalhas</option>' +
                                            '<optgroup label="Medalhas Policial Militar">' +
                                                '<option value="MEDALHA30" {{($pontuacao->st_nomeinterno == "MEDALHA30") ? "selected" : ''}}>Ouro (30 anos)</option>' +
                                                '<option value="MEDALHA20" {{($pontuacao->st_nomeinterno == "MEDALHA20") ? "selected" : ''}}>Prata (20 anos)</option>' +
                                                '<option value="MEDALHA10" {{($pontuacao->st_nomeinterno == "MEDALHA10") ? "selected" : ''}}>Bronze  (10 anos)</option>' +
                                            '</optgroup>' +
                                                
                                            '<optgroup label="Medalhas Meritória">'+
                                                '<option value="MEDALHATIRADENTES" {{($pontuacao->st_nomeinterno == "MEDALHATIRADENTES") ? "selected" : ''}}>Tiradentes</option>'+
                                                '<option value="MEDALHAPM" {{($pontuacao->st_nomeinterno == "MEDALHAPM") ? "selected" : ''}}> Mérito Policial Militar</option>'+
                                                '<option value="MEDALHAGONZAGA" {{($pontuacao->st_nomeinterno == "MEDALHAGONZAGA") ? "selected" : ''}}>Mérito Luiz Gonzaga</option>'+
                                                '<option value="MEDALHABENTO" {{($pontuacao->st_nomeinterno == "MEDALHABENTO") ? "selected" : ''}}>Mérito Profissional Coronel Bento Manoel de Medeiros</option>'+
                                                '<option value="MEDALHAMILTONFREIRE" {{($pontuacao->st_nomeinterno == "MEDALHAMILTONFREIRE") ? "selected" : ''}}>Mérito Acadêmico Coronel Milton Freire de Andrade</option>'+
                                                '<option value="MEDALHASAUDE" {{($pontuacao->st_nomeinterno == "MEDALHASAUDE") ? "selected" : ''}}>Mérito da Saúde  Coronel PM Médico Pedro Germano Costa</option>'+
                                                '<option value="MEDALHAJUDICIARIA" {{($pontuacao->st_nomeinterno == "MEDALHAJUDICIARIA") ? "selected" : ''}}>Mérito de Polícia Judiciária Militar Estadual</option>'+
                                                '<option value="MEDALHACAPELANIA" {{($pontuacao->st_nomeinterno == "MEDALHACAPELANIA") ? "selected" : ''}}>Reconhecimento da Capelania Militar Cristo Rei</option>'+
                                                '<option value="MEDALHADESPORTIVA" {{($pontuacao->st_nomeinterno == "MEDALHADESPORTIVA") ? "selected" : ''}}>Mérito Desportivo Militar Cabo PM Walter Silva</option>'+
                                                '<option value="MEDALHAHOSPITAL" {{($pontuacao->st_nomeinterno == "MEDALHAHOSPITAL") ? "selected" : ''}}>Comemorativa do Hospital(HCCPG)</option>'+
                                                '<option value="MEDALHAMUSICAL" {{($pontuacao->st_nomeinterno == "MEDALHAMUSICAL") ? "selected" : ''}}>Mérito Musical Tonheca Dantas </option>'+
                                                '<option value="MEDALHAOPERACIONAL" {{($pontuacao->st_nomeinterno == "MEDALHAOPERACIONAL") ? "selected" : ''}}>Policial Militar do Mérito Operacional </option>'+
                                                '<option value="MEDALHACBOM" {{($pontuacao->st_nomeinterno == "MEDALHACBOM") ? "selected" : ''}}>Medalha Major José Osias da Silva (CBOM)</option>'+
                                                '<option value="MEDALHAAMBIENTAL" {{($pontuacao->st_nomeinterno == "MEDALHAAMBIENTAL") ? "selected" : ''}}>Mérito Ambiental Cap Gontijo</option>'+
                                            '</optgroup>'+
                                        '</select>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input id="bgMedalhaAdicional" name="MEDALHA'+contadorMedalha+'[st_publicacao]" class="form-control" type="text">'+
                                    '</th>'+
                                    '<th class="col-md-1">'+
                                        '<button class="btn btn-danger" title="Remover Medalha" name="removeMedalha_'+idFinal+'" id="removeMedalha_'+idFinal+'" onclick="removeMedalha('+idFinal+')">Remover</button>'+
                                    '</th>'+
                                    '<th class="text-center">'+
                                        '@if($pontuacao->bo_pontohomologado)'+
                                            '@if($pontuacao->bo_pontoaceito == "1")'+
                                                '<span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>'+
                                            '@elseif($pontuacao->bo_pontoaceito == "0")'+
                                                '<span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>'+
                                            '@endif'+
                                        '@else'+ 
                                            'NÃO'+
                                        '@endif'+
                                    '</th>'+
                                    '<th>'+
                                        '<span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled></span>'+
                                    '</th>'+
                                    '<th id=ARQUIVO4_'+contadorMedalha+'>'+
                                        '<input onchange="inserirDescricao(\'ARQUIVO4_'+contadorMedalha+'\', \'medalha\', \'input_nome_interno_4_'+contadorMedalha+'\')" type="file" class="form-control-file" name="ARQUIVO4_'+contadorMedalha+'[st_path]" accept="application/pdf">'+
                                        '<input value=\"\" type=\"text\" id=\"input_nome_interno_4_'+contadorMedalha+'\" hidden>'+
                                        '<input value='+contadorMedalha+' type="text" id='+idInputContMedalha+' hidden>'+
                                    '</th>'+
                                '</tr>';
                    $(text).insertBefore("#linhaFinalMedalha");
                    idFinal++;
                    break;
                case 'Atividade':
                    inputContInstrucao = $('#input_contInstrucao'+contadorInstrucao).val()
                    if (inputContInstrucao) {
                        contadorInstrucao = $('#input_contInstrucao').val()
                        contadorInstrucao++
                    } else {
                        contadorInstrucao++
                    }
                    idInputContInstrucao = 'input_contInstrucao_'+contadorInstrucao
                    var text = '<tr id="atividade_'+idFinal+'">'+
                                    '<th>'+
                                        '<select onchange="atualizaInputNomeInterno(\'atividade'+contadorInstrucao+'\', \'input_nome_interno_6_'+contadorInstrucao+'\', \'ARQUIVO6_'+contadorInstrucao+'\')" id="atividade'+contadorInstrucao+'" name="INSTRUCAO'+contadorInstrucao+'[st_label]" class="form-control select2-container atividade">'+
                                            '<option selected>Selecione...</option>'+
                                            '<option value="INSTRUTOR">Instrutor</option>'+
                                            '<option value="MONITOR">Monitor</option>'+
                                        '</select>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input id="criterioAtividadeAdicional" name="INSTRUCAO'+contadorInstrucao+'[st_criterio]" class="form-control atividade" type="number" value="">'+
                                    '</th>'+
                                    '<th>'+
                                        '<input name="INSTRUCAO'+contadorInstrucao+'[st_campo1]" class="form-control atividade" type="date" value="">'+
                                    '</th>'+
                                    '<th>'+
                                        '<input name="INSTRUCAO'+contadorInstrucao+'[st_campo2]" class="form-control atividade" type="date" value="">'+
                                    '</th>'+
                                    '<th>'+
                                        '<input id="bgAtividadeAdicional" name="INSTRUCAO'+contadorInstrucao+'[st_publicacao]" class="form-control atividade" type="text">'+
                                    '</th>'+
                                    '<th class="col-md-1">'+
                                        '<button class="btn btn-danger" title="Remover Atividade" name="removeAtividade_'+idFinal+'" id="removeAtividade_'+idFinal+'" onclick="removeAtividade('+idFinal+')">Remover</button>'+
                                    '</th>'+
                                    '<th class="text-center">'+
                                        '@if($pontuacao->bo_pontohomologado)'+
                                            '@if($pontuacao->bo_pontoaceito == "1")'+
                                                '<span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>'+
                                            '@elseif($pontuacao->bo_pontoaceito == "0")'+
                                                '<span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>'+
                                            '@endif'+
                                        '@else'+ 
                                            'NÃO'+
                                        '@endif'+
                                    '</th>'+
                                    '<th>'+
                                        '<span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>'+
                                    '</th>'+
                                    '<th id=ARQUIVO6_'+contadorInstrucao+'>'+
                                        '<input onchange="inserirDescricao(\'ARQUIVO6_'+contadorInstrucao+'\', \'instrucao\', \'input_nome_interno_6_'+contadorInstrucao+'\')" type="file" class="form-control-file" name="ARQUIVO6_'+contadorInstrucao+'[st_path]" accept="application/pdf">'+
                                        '<input value=\"\" type=\"text\" id=\"input_nome_interno_6_'+contadorInstrucao+'\" hidden>'+
                                        '<input value='+contadorInstrucao+' type="text" id='+idInputContInstrucao+' hidden>'+
                                    '</th>'+
                                '</tr>';
                    
                    $(text).insertBefore("#linhaFinalAtividade");
                    idFinal++;
                    break;
                case 'Punicao':
                    inputContPunicao = $('#input_contPunicao'+contadorPunicao).val()
                    if (inputContPunicao) {
                        contadorPunicao = $('#input_contPunicao').val()
                        contadorPunicao++
                    } else {
                        contadorPunicao++
                    }
                    idInputContPunicao = 'input_contPunicao_'+contadorPunicao
                    var text = '<tr id="punicao_'+idFinal+'">'+
                                    '<th>'+
                                        '<select onchange="atualizaInputNomeInterno(\'punicao'+contadorPunicao+'\', \'input_nome_interno_11_'+contadorPunicao+'\', \'ARQUIVO11_'+contadorPunicao+'\')" id="punicao'+contadorPunicao+'" name="PUNICAO'+contadorPunicao+'[st_criterio]" class="form-control select2-container">'+
                                            '<option selected="selected" value="">Selecione...</option>'+
                                            '<option value="REPREENSAO">Repreensão</option>'+
                                            '<option value="DETENCAO">Detenção</option>'+
                                            '<option value="PRISAO">Prisão</option>'+
                                        '</select>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input id="bgPunicaoAdicional" name="PUNICAO'+contadorPunicao+'[st_publicacao]" class="form-control" type="text">'+
                                    '</th>'+
                                    '<th class="col-md-1">'+
                                        '<button class="btn btn-danger" title="Remover Punição" name="removePunicao_'+idFinal+'" id="removePunicao_'+idFinal+'" onclick="removePunicao('+idFinal+')">Remover</button>'+
                                    '</th>'+
                                    '<th class="text-center">'+
                                        '@if($pontuacao->bo_pontohomologado)'+
                                            '@if($pontuacao->bo_pontoaceito == "1")'+
                                                '<span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>'+
                                            '@elseif($pontuacao->bo_pontoaceito == "0")'+
                                                '<span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>'+
                                            '@endif'+
                                        '@else'+ 
                                            'NÃO'+
                                        '@endif'+
                                    '</th>'+
                                    '<th>'+
                                        '<span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>'+
                                    '</th>'+
                                    '<th id=ARQUIVO11_'+contadorPunicao+'>'+
                                        '<input onchange="inserirDescricao(\'ARQUIVO11_'+contadorPunicao+'\', \'punicao\', \'input_nome_interno_11_'+contadorPunicao+'\')" type="file" class="form-control-file" name="ARQUIVO11_'+contadorPunicao+'[st_path]" accept="application/pdf">'+
                                        '<input value=\"\" type=\"text\" id=\"input_nome_interno_11_'+contadorPunicao+'\" hidden>'+
                                        '<input value='+contadorPunicao+' type="text" id='+idInputContPunicao+' hidden>'+
                                    '</th>'+
                                '</tr>';
                    $(text).insertBefore("#linhaFinalPunicao");
                    idFinal++;
                    break;
                case 'Curso':
                    inputContCurso = $('#input_contCurso'+contadorCurso).val()
                    if (inputContCurso) {
                        contadorCurso = $('#input_contCurso').val()
                        contadorCurso++
                    } else {
                        contadorCurso++
                    }
                    idInputContCurso = 'input_contCurso_'+contadorCurso
                    var text = '<tr id="curso_'+idFinal+'">'+
                                    '<th>'+
                                        '<select onchange="atualizaInputNomeInterno(\'curso'+contadorCurso+'\', \'input_nome_interno_9_'+contadorCurso+'\', \'ARQUIVO9_'+contadorCurso+'\')" id="curso'+contadorCurso+'" name="CURSO'+contadorCurso+'[st_label]" id="CURSO" class="form-control select2-container selectAdcional">'+
                                            '<option selected="selected" value="">Selecione...</option>'+
                                            '<option value="CURSO30">CH igual ou superior a 30h</option>'+
                                            '<option value="CURSO60">CH igual ou superior a 60h</option>'+
                                            '<option value="CURSO100">CH igual ou superior a 100h</option>'+
                                        '</select>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input name="CURSO'+contadorCurso+'[st_criterio]" class="form-control curso" type="text">'+
                                    '</th>'+
                                    '<th>'+
                                        '<input name="CURSO'+contadorCurso+'[st_publicacao]" class="form-control curso" type="text">'+
                                    '</th>'+
                                    '<th class="col-md-1">'+
                                        '<button class="btn btn-danger" title="Remover Curso" name="removeCurso_'+idFinal+'" id="removeCurso_'+idFinal+'" onclick="removeCurso('+idFinal+')">Remover</button>'+
                                    '</th>'+
                                    '<th class="text-center">'+
                                        '@if($pontuacao->bo_pontohomologado)'+
                                            '@if($pontuacao->bo_pontoaceito == "1")'+
                                                '<span class="fa fa-check-square-o text-green" title="Pontuação Aceita"></span>'+
                                            '@elseif($pontuacao->bo_pontoaceito == "0")'+
                                                '<span class="fa fa-remove text-red" title="Pontuação Não Aceita"></span>'+
                                            '@endif'+
                                        '@else'+ 
                                            'NÃO'+
                                        '@endif'+
                                    '</th>'+
                                    '<th>'+
                                        '<span name="{{$pontuacao->st_nomeinterno}}[st_valor]" class="form-control" disabled>{{$pontuacao->vl_pontos}}</span>'+
                                    '</th>'+
                                    '<th id=ARQUIVO9_'+contadorCurso+'>'+
                                        '<input onchange="inserirDescricao(\'ARQUIVO9_'+contadorCurso+'\', \'instrucao\', \'input_nome_interno_9_'+contadorCurso+'\')" type="file" class="form-control-file" name="ARQUIVO9_'+contadorCurso+'[st_path]" accept="application/pdf">'+
                                        '<input value=\"\" type=\"text\" id=\"input_nome_interno_9_'+contadorCurso+'\" hidden>'+
                                        '<input value='+contadorCurso+' type="text" id='+idInputContCurso+' hidden>'+
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
                                            '<input id="ARQUIVO'+contadorArquivo+'[st_path]" type="file" class="form-control-file" name="ARQUIVO'+contadorArquivo+'[st_path]" accept="application/pdf">'+
                                        '</span>'+
                                    '</th>'+
                                    '<th>'+
                                        '<input type="text" class="form-control" name="ARQUIVO'+contadorArquivo+'[st_descricao]" placeholder="Digite a descrição">'+
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
@endif
        //função que inseri a descrição do arquivo quando selecionado
        function inserirDescricao(nomeArquivo, descricao, inputNomeInterno = null) {
           
            //verifica se foi enviado um nome interno
            if (inputNomeInterno != null) {
                //atribui o valor do input para a descrição
                descricao = $('#'+inputNomeInterno).val() 
            }
           
            //verifica se o elemento com o id repassado não existe
            if ( ! $('#input' + nomeArquivo).length ) {
                //caso o input não exista, será inserido
                $('#' + nomeArquivo).append(
                    '<input type="text" class="form-control-file" value="' + descricao + '" id="' + 'input' + nomeArquivo + '" name="' + nomeArquivo + '[st_descricao]" accept="application/pdf" hidden>'
                )  
            } else {
                //remove o input nome arquivo
                $('#input' + nomeArquivo).remove()

                //adiciona um novo input ao elemento nome arquivo
                $('#' + nomeArquivo).append(
                    '<input type="text" class="form-control-file" value="' + descricao + '" id="' + 'input' + nomeArquivo + '" name="' + nomeArquivo + '[st_descricao]" accept="application/pdf" hidden>'
                ) 
            }             
        }

        function atualizaInputNomeInterno(selectId, inputNomeInterno, nomeArquivo) {

            //pega o valor selecionado no select
            valorSelecionado = $('#' + selectId + ' option:selected').val()

            //remove o input nome interno
            $('#' + inputNomeInterno).remove()
            
            //inseri um novo input nome interno
            $('#' + nomeArquivo).append(
                '<input value=\"'+valorSelecionado+'\" type=\"text\" id=\"'+inputNomeInterno+'\" hidden>'
            ) 
        }

        //Exibe as justificativas no caso do período de recurso está aberto
        window.onload = function () {

            recurso = $('#recursoAberto').val()

            if (!recurso) {
                $("th").remove(".justificativa")
            } 
        }
        

    </script>
@stop