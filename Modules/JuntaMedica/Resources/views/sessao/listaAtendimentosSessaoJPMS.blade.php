@extends('adminlte::page')
@section('title', 'Sessoes')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            @php 
                setlocale(LC_TIME, 'portuguese');
                date_default_timezone_set('America/Sao_Paulo');
            @endphp
            <div class="panel-heading"><div class="col-md-6">ATA DE INSPEÇÃO DE SAÚDE DA SESSÃO {{$sessao->nu_sequencial}}/{{$sessao->nu_ano}} DE {{strtoupper(strftime('%d DE %B DE %Y', strtotime(($sessao->dt_sessao))))}}</div><div class="text-right">Status: {{$sessao->st_status}}</div></div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="scheduler-border">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="11">Lista de Atendimentos</th>                     
                                </tr>
                                <tr>
                                    <th class="col-md-1">Nome</th>
                                    <th class="col-md-1">Post/Grad</th>
                                    <th class="col-md-1">Matrícula</th>
                                    <th class="col-md-1">Unidade</th>
                                    <th class="col-md-1">CID</th>
                                    
                                    <th class="col-md-1">Parecer</th>
                                    <th class="col-md-1">Restrição</th>
                                    <th class="col-md-1">Causa/Efeito</th>
                                    <th class="col-md-1">OBS</th>
                                    <th class="col-md-1">Sei</th>
                                    <th class="col-md-3">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($sessao->atendimentosMedicos) && count($sessao->atendimentosMedicos) > 0)
                                    @forelse($sessao->atendimentosMedicos as $a)
                                        @php 
                                            $restricoes = ""; 
                                        @endphp
                                    <tr>
                                        <td>{{$a->st_nome}}</td>
                                        <td>{{$a->st_postograduacao}} {{$a->st_orgao}}</td>
                                        <td>{{$a->st_matricula}}</td>
                                        <td>{{$a->st_unidade}}</td>
                                        <td>{{$a->st_cid}}</td>
                                        <td>{{$a->st_parecer}}</td>
                                        @php 
                                            $contador = 0;
                                            $total = count($a->restricoes);
                                        @endphp
                                        @if($a->restricoes > 0)
                                            <td>
                                                @foreach ($a->restricoes as $restricao)
                                                    @php ++$contador @endphp
                                                    @if ($contador < $total)
                                                        {{$restricao->st_restricao}},
                                                    @else
                                                        {{$restricao->st_restricao}}.
                                                    @endif
                                                @endforeach                                       
                                            </td>
                                        @else
                                            <td>Sem restrição.</td>
                                        @endif
                                        <td>{{$a->st_causaefeito}}</td>
                                        <td>{{$a->st_obs}}</td>

                                        @if($sessao->st_numsei)
                                        <td>{{$sessao->st_numsei}}</td>
                                            @else
                                                <td></td>
                                            @endif
                                        
                                        <td>
                                            <a class="btn btn-primary" title="Visualizar atendimento" href="{{url('/juntamedica/atendimento/'.$a->id.'/visualizar')}}"><i class="fa fa-eye"></i></a>
                                            @if(!$sessao->bo_conferida)
                                            
                                            <a class="btn btn-warning" title="Corrigir atendimento" href="{{url('/juntamedica/atendimento/corrigir/'.$sessao->id.'/'.$a->id)}}"><i class="fa fa-pencil"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">Nenhum atendimento médico encontrado.</td>
                                    </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if($sessao->bo_conferida == 1)
            <div class="mb-20px">
                <button data-toggle="modal" data-target="#assinarSessao" title="Assinar Ata" class="btn btn-primary">
                    <i class="fa fa-pencil-square-o"></i> Assinar Ata
                </button>
                <a  href="{{url('juntamedica/sessoes/'.$sessao->id.'/atendimentos/PM/excel')}}" title="Exportar PM para excel" class="btn btn-primary">
                    <i class="fa fa-file-excel-o"></i> Exportar PM
                </a>
                <a  href="{{url('juntamedica/sessoes/'.$sessao->id.'/atendimentos/CBOM/excel')}}"  title="Exportar BM para excel" class="btn btn-primary">
                    <i class="fa fa-file-excel-o"></i> Exportar CBOM
                </a>
                <a href="{{url('/juntamedica/sessoes/'.$sessao->id.'/pdf')}}"  target="_blank" class="btn btn-primary" title='Imprimir Pdf'>
                    <i class="fa fa-print"></i> Imprimir 
                </a>
                
                @if(($sessao->st_status == 'FECHADO') && empty($sessao->ce_nota))
                    <a href=""  target="_blank" class="btn btn-primary" title='Gerar Nota'>
                        <i class="fa  fa-send-o"></i> Gerar Nota_Sem Nota 
                    </a>
                @else
                    <a href="{{url('boletim/nota/visualizar/'.$sessao->ce_nota)}}"  target="_blank" rel="noopener" class="btn btn-primary" title='Visualizar Nota'>
                        <i class="fa fa-eye"></i> Visualizar Nota
                    </a>
                @endif
        
        <hr>
        @endif          
            </div>
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="scheduler-border">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="12">Assinaturas</th>                            
                                    </tr>
                                    <tr>
                                        <th class="col-md-1">Ordem</th>
                                        <th class="col-md-5">Nome</th>
                                        <th class="col-md-2">Posto/Grad</th>
                                        <th class="col-md-3">Função</th>
                                        <th class="col-md-1">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($assinaturasSessao) && count($assinaturasSessao) > 0)
                                        @php $contador = 0 @endphp
                                        @forelse($assinaturasSessao as $a)
                                        @php $contador++ @endphp
                                        <tr>
                                            <td>{{$contador}}</td>
                                            <td>{{$a->st_nomeassinante}}</td>
                                            <td>{{$a->st_postograd}}</td>
                                            <td>{{$a->st_funcao}}</td>
                                            <td>
                                                <button onclick="excluiAssinaturaSessao({{$sessao->id}}, {{$a->id}})" id="btn-excluir" data-toggle="modal" data-target="#excluirAssinatura" title="Excluir" class="btn btn-danger fa fa-trash"></button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5">Ata não assinada.</td>
                                        </tr>
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <br/><br/>
                    </div>
                </div>
            </div>
           
       
       
        @if (($sessao->st_status == 'ABERTO') && count($sessao->atendimentosMedicos) > 0)
            <a onclick="modalDesativa({{$sessao->id}})" data-toggle="modal" data-placement="top" title="Finalizar" class="btn btn-danger mb-20px">
                <i class=" fa fa-times-circle"></i> Finalizar SESSÃO
            </a>
        @endif
        
                
        <div>
            <a href="{{url('juntamedica/sessoes')}}" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar">
                <i class="glyphicon glyphicon-arrow-left"></i> Voltar 
            </a>
        </div>
    </div>
</div>

<!-- Modal finaliza Sessao -->

                            <div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Finalizar Sessão</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form-inline" id="modalDesativa" method="GET" > {{csrf_field()}}
                            <div class="modal-body bg-danger">
                                <h4 class="modal-title" id="exampleModalLabel">
                                    <b>DESEJA REALMENTE FINALIZAR ESTA SESSÃO?</b>
                                </h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Sim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function modalDesativa(id){
                    $("#modalDesativa").attr("action", "{{ url('juntamedica/sessoes/finaliza/sessao')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>
<!--Fim  Modal finaliza Sessao -->

<!-- Modal para assinatura da Ata -->
<div class="modal fade" id="assinarSessao" tabindex="-1" role="dialog" aria-labelledby="salvarpromocao" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h4 class="modal-title">Assinar Ata de Inspeção de Saúde</h4>
            </div>
            <div class="modal-body bg-primary">
                <form role="form" id="form_quadro" method="post" action="{{url('/juntamedica/sessoes/'.$sessao->id.'/assina')}}"> 
                    {{csrf_field()}}  
                    <div class="col-sm-2" style="margin-top: 3%;">Senha</div>
                    <div class="col-sm-10">
                        <input class="form-control" id="password" type="password" name="password" required>
                    </div>
                    <br/><br/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success salvar">Assinar</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>

<!-- Modal para excluir uma assinatura da Sessão -->
<div class="modal fade" id="excluirAssinatura" tabindex="-1" role="dialog" aria-labelledby="excluirAssinatura" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h4 class="modal-title">Excluir Assinatura da Ata</h4>
            </div>
            <div class="modal-body bg-danger">
                <form role="form" id="form_excluir" method="post" action=""> 
                    {{csrf_field()}}  
                    <div class="col-sm-12" style="margin-top: 3%;">DESEJA REALMENTE EXCLUIR A ASSINATURA?</div>
                    <br/><br/><br/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>

@stop

<script>
    function excluiAssinaturaSessao(idSessao, idAssinaturaSessao){
        let url = '/juntamedica/sessoes/'+idSessao+'/assinatura/'+idAssinaturaSessao+'/exclui';
        $("#form_excluir").removeAttr("action");
        $("#form_excluir").attr("action", "{{url('')}}" + url);
    };
</script>

@section('css')
    <style>
        *{font-size: 14px;}
        th, td{text-align: center;}
        #btn-assinar{
            margin-left: 10px;
            margin-bottom: 20px;
        }
        .mb-20px{margin-bottom: 20px;}
    </style>
@stop
