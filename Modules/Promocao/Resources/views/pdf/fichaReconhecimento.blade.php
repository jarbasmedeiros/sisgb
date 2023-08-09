<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport">
  
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- PDF -->
    <link rel="stylesheet" href="{{ asset('assets/css/quadroAcesso.css') }}">

    <style type="text/css">
        #watermarkBoletim {
            position: fixed;
            top: 35%;
            width: 100%;
            text-align: center;
            opacity: .2;
            transform: rotate(-50deg);
            transform-origin: 50% 50%;
            z-index: 1000;
            font-size: 95px;    
            font-family: "Times New Roman", Times, serif;
        }
    </style>

    <title>FICHA DE RECONHECIMENTO - {{$policialDoQuadro->st_matricula}}</title>
</head>
<body>

    <div class="container-fluid">

        @if ( 
            isset($quadro) 
            && isset($ficha) 
            && $quadro->st_status == 'ABERTO'
            && empty($ficha->dt_assinaturahomologacao)
            )
            @if($quadro->bo_recursoliberado == 1
                && $fichaPolicial->bo_recorreu == 1 )
                <div id="watermarkBoletim">
                        FICHA EM RECURSO
                </div>
            @elseif ($quadro->bo_escriturarliberado == 1)
                    <div id="watermarkBoletim">
                        NÃO HOMOLOGADA
                    </div>
            @endif
        @endif



           
        <div class="row">
            <div class="panel panel-primary container-fluid">
                <div class="panel-heading row" style="text-align:center;">
                    <span><b>ESTADO DO RIO GRANDE DO NORTE</b></span><br/>
                    <span><b>SECRETARIA DE ESTADO DA SEGURANÇA PÚBLICA E DA DEFESA SOCIAL</b></span><br/>
                    <span><b>POLÍCIA MILITAR</b></span>
                </div>
                <br/>
                <div style="border:1px solid black; text-align: center;">
                    <b>QUADRO DE ACESSO REFERENTE AS PROMOÇÕES PREVISTAS PARA: {{date('d/m/Y', strtotime($quadro->dt_promocao))}}</b>
                </div>
                <br/>
       

                    <div class="tituloTabela" style="border:1px solid black; border-left:1px solid black;">
                        <b>FICHA DE RECONHECIMENTO {{$ficha->st_ficha}} DOS SARGENTOS DA PMRN</b>
                    </div>

                <div class="panel-body">
                    <div class="scheduler-border"  style="border-right:1px solid black; border-left:1px solid black;">
                        <div class="form-row" style="width: 100%;">
                       
                        <div class="form-group col-xs-6" >
                                <strong><label>Nome:</label></strong>
                                <span class="form-control">{{$policialDoQuadro->st_policial}}</span>
                            </div>
                            <div class="form-group col-xs-2" style="border-top:1px solid black;">
                                <strong><label>OPM:</label></strong>
                                <span class="form-control">{{$policialDoQuadro->st_unidade}}</span>
                            </div>
                            <div style="">
                                <div class="form-group col-xs-2" style="border-top:1px solid black; border-right:1px solid black; float: left; width: 33%;">
                                    <strong><label>Graduação:</label></strong>
                                    <span class="form-control">{{$policialDoQuadro->st_postgrad}}</span>
                                </div>
                                <div class="form-group col-xs-2" style="border-top:1px solid black; border-right:1px solid black; float: left; width: 33%;">
                                    <strong><label>QPMP:</label></strong>
                                    <span class="form-control">{{$policialDoQuadro->st_qpmp}}</span>
                                </div>
                                <div class="form-group col-xs-2" style="border-top:1px solid black; float: left; width: 33.8%;">
                                    <strong><label>Nº Praça:</label></strong>
                                    <span class="form-control">{{$policialDoQuadro->st_numpraca}}</span>
                                </div>
                                <div style='clear: left;'></div>
                            </div>
                            <div>
                                <div class="form-group col-xs-2" style="border-top:1px solid black; border-right:1px solid black; float: left; width: 50%;">
                                    <strong><label>Matrícula:</label></strong>
                                    <span class="form-control">{{$policialDoQuadro->st_matricula}}</span>
                                </div>
                                <div class="form-group col-xs-2" style="border-top:1px solid black; float: left; width: 50%;">
                                    <strong><label>Data de Nascimento:</label></strong>
                                    <span class="form-control">{{date('d/m/Y', strtotime($policialDoQuadro->dt_nascimento))}}</span>
                                </div>
                                <div style="clear: left;" ></div>
                            </div>
                        </div>
                    </div>
                    <div class="scheduler-border" style="">
                        <div class="tituloTabela" style="border-right:1px solid black; border-left:1px solid black;">
                            <b>Pontuações</b>
                             

                            @php
                                $cabecalhosArray = [];
                            @endphp

                        </div>
                        @foreach($pontuacoes as $key => $pontuacao)
                            @switch($pontuacao->nu_item)
                                @case(1) <!-- Tempo como Sargento -->
                                    @if($pontuacao->nu_ordem == 1)
                                        <table style="border-collapse: collapse; width: 100%;">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="primeiraColuna col-xs-3">1 - Tempo de Serviço nas Graduações de Sargento</th>
                                                    <th class="segundaQuartaColuna col-xs-4">Tempo em Meses</th>
                                                    <th>BG de Publicação</th>
                                                    <th class="segundaQuartaColuna">Pontos</th>
                                                    <th class="segundaQuartaColuna">Aceito</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        @if(empty($pontuacao->st_label))<br>@else{{$pontuacao->st_label}}@endif
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                                    </th>
                                                    <th>
                                                        @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                                        @endif
                                                    </th>
                                                </tr>
                                    @elseif($pontuacao->nu_ordem == 2)
                                                <tr>
                                                    <th>
                                                        @if(empty($pontuacao->st_label))<br>@else{{$pontuacao->st_label}}@endif
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                                    </th>
                                                    <th>
                                                        @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                                        @endif
                                                    </th>
                                                </tr>
                                    @elseif($pontuacao->nu_ordem == 3)
                                                <tr>
                                                    <th>
                                                        @if(empty($pontuacao->st_label))<br>@else{{$pontuacao->st_label}}@endif
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                                    </th>
                                                    <th>
                                                        @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                                        @endif
                                                    </th>
                                                </tr>
                                    @elseif($pontuacao->nu_ordem == 4)
                                                <tr>
                                                    <th>
                                                        @if(empty($pontuacao->st_label))<br>@else{{$pontuacao->st_label}}@endif
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                                    </th>
                                                    <th>
                                                        @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                    </th>
                                                    <th class="segundaQuartaColuna">
                                                        @if($pontuacao->bo_pontohomologado)
                                                            {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                                        @endif
                                                    </th>
                                                </tr>


                                            </tbody>
                                        </table>
                                    @endif
                                    @break
                                @case(2) <!-- Nota de Curso de Formacao -->
                                    <table style="border-collapse: collapse; width: 100%;">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="primeiraColuna col-xs-4">2 - Nota Obtida no Último Curso de Formação ou Aperfeiçoamento</th>
                                                <th class="segundaQuartaColuna">Nota</th>
                                                <th>BG de Publicação Ata de Conclusão</th>
                                                <th class="segundaQuartaColuna">Pontos</th>
                                                <th class="segundaQuartaColuna">ACEITO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                    Curso do 
                                                    @if(empty($pontuacao->st_label))<br>@else{{$pontuacao->st_label}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                                </th>
                                                <th>
                                                    @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                                    @endif
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @break
                                @case(3) <!-- Comportamento -->
                                    <table style="border-collapse: collapse; width: 100%;">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="primeiraColuna col-xs-2">3 - Comportamento</th>
                                                <th class="segundaQuartaColuna">-</th>
                                                <th>BG de Publicação</th>
                                                <th class="segundaQuartaColuna">Pontos</th>
                                                <th class="segundaQuartaColuna">ACEITO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    @if(empty($pontuacao->st_label))<br>@else{{$pontuacao->st_label}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                                </th>
                                                <th>
                                                    @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                                    @endif
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @break
                                @case(4) <!-- Medalhas -->
                                    @if(!in_array('medalhas',$cabecalhosArray))
                                        <table class="table table-bordered" style="border-collapse: collapse; width: 100%;">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="primeiraColuna col-xs-2">4 - Medalha</th>
                                                    <th class="segundaQuartaColuna">-</th>
                                                    <th>BG de Publicação da Concessão</th>
                                                    <th class="segundaQuartaColuna">Pontos</th>
                                                    <th class="segundaQuartaColuna">ACEITO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        @php 
                                            array_push($cabecalhosArray,'medalhas') ;
                                        @endphp
                                    @endif
                                    <tr>
                                        <th>
                                            @if(empty($pontuacao->st_label))<br>@else{{$pontuacao->st_label}}@endif
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                        </th>
                                        <th>
                                            @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            @if($pontuacao->bo_pontohomologado)
                                                {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                            @endif
                                        </th>
                                    </tr>
                                    @if($pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                        <!-- Fechando tabela de medalhas -->
                                            </tbody>
                                        </table>
                                    @endif
                                    @break
                                @case(5) <!-- Doacao de sangue -->
                                    <!-- Criando tabela de doacao de sangue -->
                                    <table style="border-collapse: collapse; width: 100%;">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="primeiraColuna col-xs-2">5 - Doação de Sangue</th>
                                                <th class="segundaQuartaColuna">-</th>
                                                <th>BG de Publicação</th>
                                                <th class="segundaQuartaColuna">Pontos</th>
                                                <th class="segundaQuartaColuna">ACEITO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                     @if(empty($pontuacao->st_criterio))<br>@else
                                                        {{$pontuacao->st_criterio === "SIM" ? "SIM" : "NÃO"}}
                                                     @endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                                </th>
                                                <th>
                                                    @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                                    @endif
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @break
                                @case(6) <!-- Atividades de Instrutor ou Monitor -->
                                    @if(!in_array('atividadeInstrutorMonitor',$cabecalhosArray))
                                        <table style="border-collapse: collapse; width: 100%;">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="primeiraColuna col-xs-3">6 - Atividade de Instrutor ou Monitor</th>
                                                    <th class="segundaQuartaColuna">Tempo em Meses</th>
                                                    <th class="segundaQuartaColuna">CH</th>
                                                    <th>BG de Designação</th>
                                                    <th class="segundaQuartaColuna">Pontos</th>
                                                    <th class="segundaQuartaColuna">ACEITO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        @php 
                                            array_push($cabecalhosArray,'atividadeInstrutorMonitor') ;
                                        @endphp
                                    @endif
                                    <tr id="atividade_{{$pontuacao->id}}">
                                        <th>
                                            @if(empty($pontuacao->st_label))<br>@else
                                                {{$pontuacao->st_label === "SEMATIVIDADE" ? "" : $pontuacao->st_label}}
                                            @endif
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            @if(empty($pontuacao->st_criterio))<br>@else{{$pontuacao->st_criterio}}@endif
                                        </th>
                                        <th>
                                            @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            @if($pontuacao->bo_pontohomologado)
                                                {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                            @endif
                                        </th>
                                    </tr>
                                    @if($pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                    <!-- Fechando tabela de Atividades -->
                                        </tbody>
                                    </table>
                                    @endif
                                    @break
                                @case(7) <!-- TAF -->
                                    <table class="table table-bordered" style="border-collapse: collapse; width: 100%;">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="primeiraColuna col-xs-2">7 - Teste de Condicionamento Físico</th>
                                                <th class="segundaQuartaColuna">-</th>
                                                <th>BG de Publicação</th>
                                                <th class="segundaQuartaColuna">Pontos</th>
                                                <th class="segundaQuartaColuna">ACEITO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                     @if(empty($pontuacao->st_criterio))<br>@else{{$pontuacao->st_criterio}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                                </th>
                                                <th>
                                                    @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                                    @endif
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @break
                                @case(8) <!-- Curso Superior -->
                                    <table class="table table-bordered" style="border-collapse: collapse; width: 100%;">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="primeiraColuna col-xs-3">8 - Aprimoramento</th>
                                                <th class="segundaQuartaColuna">-</th>
                                                <th>BG de Designação</th>
                                                <th class="segundaQuartaColuna">Pontos</th>
                                                <th class="segundaQuartaColuna">ACEITO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th class="form-inline">
                                                    @if(empty($pontuacao->st_label))<br>@else{{$pontuacao->st_label}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                                </th>
                                                <th>
                                                    @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                                    @endif
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @break
                                @case(9) <!-- Cursos com Aplicabilidade à Caserna -->
                                    @if(!in_array('cursos',$cabecalhosArray))
                                        <table class="table table-bordered" style="border-collapse: collapse; width: 100%;">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="primeiraColuna col-xs-6">9 - Curso com Aplicabilidade à Caserna</th>
                                                    <th class="segundaQuartaColuna">-</th>
                                                    <th>BG de Designação</th>
                                                    <th class="segundaQuartaColuna">Pontos</th>
                                                    <th class="segundaQuartaColuna">ACEITO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        @php 
                                            array_push($cabecalhosArray,'cursos') ;
                                        @endphp
                                    @endif    
                                    <tr id="curso_{{$pontuacao->id}}">
                                        <th>
                                            @if(empty($pontuacao->st_label))<br>@else
                                                @switch($pontuacao->st_label)
                                                    @case("CURSO30")
                                                        CH igual ou superior a 30h
                                                        @break
                                                    @case("CURSO60")
                                                        CH igual ou superior a 60h
                                                        @break
                                                    @case("CURSO100")
                                                        CH igual ou superior a 100h
                                                        @break
                                                    @default
                                                        {{$pontuacao->st_label}}
                                                        @break
                                                @endswitch
                                            @endif
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                        </th>
                                        <th>
                                            @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            @if($pontuacao->bo_pontohomologado)
                                                {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                            @endif
                                        </th>
                                    </tr>
                                    @if($pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                    <!-- Fechando tabela de Curso -->
                                        </tbody>
                                    </table>
                                    @endif
                                    @break
                                @case(10) <!-- Contribuição Científica -->
                                    @if(!in_array('cientificos',$cabecalhosArray))

                                        <table style="border-collapse: collapse; width: 100%;">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="primeiraColuna col-xs-3">10 - Contribuição Científica de Caráter Técnico Profissional<br>(Aprovada pela Diretoria de Ensino da PMRN)</th>
                                                    <th class="segundaQuartaColuna">-</th>
                                                    <th>BG de Publicação</th>
                                                    <th class="segundaQuartaColuna">Pontos</th>
                                                    <th class="segundaQuartaColuna">ACEITO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php 
                                                array_push($cabecalhosArray,'cientificos') ;
                                            @endphp
                                    @endif  
                                    
                                 
                                    
                                        <tr>
                                                <th>
                                                    @if(empty($pontuacao->st_label))<br>@else{{$pontuacao->st_label}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                                </th>
                                                <th>
                                                    @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    {{$pontuacao->vl_pontos}}
                                                </th>
                                                <th class="segundaQuartaColuna">
                                                    @if($pontuacao->bo_pontohomologado)
                                                        {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                                    @endif
                                                </th>
                                            </tr>
                                    

                                    @if($pontuacoes[$key+1]->nu_item != $pontuacao->nu_item)
                                    <!-- Fechando tabela de cientifico -->
                                        </tbody>
                                    </table>
                                    @endif
                                    @break
                                @case(11) <!-- Punições -->
                                    @if(!in_array('punicao',$cabecalhosArray)) <!-- Abrindo tabela -->
                                        <table class="table table-bordered" style="border-collapse: collapse; width: 100%;">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="primeiraColuna col-xs-3">11 - Punições</th>
                                                    <th class="segundaQuartaColuna">-</th>
                                                    <th>BG de Designação</th>
                                                    <th class="segundaQuartaColuna">Pontos</th>
                                                    <th class="segundaQuartaColuna">ACEITO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        @php 
                                            array_push($cabecalhosArray,'punicao') ;
                                        @endphp
                                    @endif
                                    <tr id="punicao_{{$pontuacao->id}}">
                                        <th>
                                            @if(empty($pontuacao->st_label))<br>@else
                                                {{$pontuacao->st_label === "SEMPUNICAO" ? "" : $pontuacao->st_label}}
                                            @endif
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            @if(empty($pontuacao->st_valor))<br>@else{{$pontuacao->st_valor}}@endif
                                        </th>
                                        <th>
                                            @if(empty($pontuacao->st_publicacao))<br>@else{{$pontuacao->st_publicacao}}@endif
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            {{round($pontuacao->vl_pontos, 1) == 0?'0.0':round($pontuacao->vl_pontos, 1)}}
                                        </th>
                                        <th class="segundaQuartaColuna">
                                            @if($pontuacao->bo_pontohomologado)
                                                {{$pontuacao->bo_pontoaceito == 1 ?'SIM': 'NÃO'}}
                                            @endif
                                        </th>
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
                    @php 
                    
                        $totalPontos = number_format($ficha->vl_pontosdaficha, 2);
                    
                        $totalPontosValidos = number_format($ficha->vl_pontosvalidosdaficha, 2);
                    @endphp 
                    </div>
                    <div class="tituloTabela" style="border:1px solid black; text-align: center;">
                        TOTAL GERAL DE PONTOS ENVIADOS: {{$totalPontos}}<br/>
                        <B>TOTAL GERAL DE PONTOS VALIDOS: {{$totalPontosValidos}}</B>
                    </div>


                </div>

                
            </div>
        </div>
    </div>
    <div class="rodape">
        <span>Ficha de Reconhecimento dos Sargentos da PMRN / CPP / SISGP. </span> <br><br>
        <span>Impresso por {{Auth::user()->name}} em {{date('d/m/Y - H:m:s')}} </span>

    </body>

</html>
