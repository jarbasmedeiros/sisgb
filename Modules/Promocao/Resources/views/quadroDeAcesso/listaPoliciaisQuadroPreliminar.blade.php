@extends('adminlte::page')
@php 
    use app\utis\Funcoes;
@endphp
@section('title', 'Polciais do QA')
@section('content')
<form method="POST" id="convocarParaTaf" role="form" action="{{url('promocao/cadastrarportariadivulgarqapreliminar/'.$idQuadro.'/'.$atividade->id)}}">
    <div class="panel panel-primary">
        <div class="panel-heading">Quadro de Acesso</div>
        <div class="panel-body">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Dados da Portaria para publicação do QA preliminar</legend>
                <div class="row">
                    <div class="form-group">
                    {{csrf_field()}}
                        @if($atividade->ce_nota == null && $assinaturas > 0 && !empty($comissao))
                            <fieldset style="width: 100%; height:100%;" type="textarea" class="ckeditor form-control" name="st_portaria" id="st_portaria" rows="10" required>{!! $atividade->st_portaria !!}</fieldset>
                        @elseif($atividade->ce_nota == null && $assinaturas == 0 && !empty($comissao))
                            <textarea type="textarea" class="ckeditor form-control" name="st_portaria" id="st_portaria" rows="10" required>{{$atividade->st_portaria}}</textarea>
                        @elseif($atividade->ce_nota == null && empty($comissao))
                            <textarea type="textarea" class="ckeditor form-control" name="st_portaria" id="st_portaria" rows="10" required>{{$atividade->st_portaria}}</textarea>
                            <!-- {!! $atividade->st_portaria !!} -->
                        @elseif($atividade->ce_nota != null)
                            <fieldset style="width: 100%; height:100%;" type="textarea" class="ckeditor form-control" name="st_portaria" id="st_portaria" rows="10" required>{!! $atividade->st_portaria !!}</fieldset>
                        @endif
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

    <div class="form-group">    
        @if($atividade->ce_nota == null && $assinaturas == 0 && !empty($comissao))                             
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-fw fa-save"></i> Salvar
            </button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#buscarPolicial">
                <i class="fa fa-fw fa-save"></i> Cadastrar membro da comissão
            </button>                                        
        @elseif($atividade->ce_nota == null && $assinaturas > 0 && !empty($comissao))
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#buscarPolicial">
                <i class="fa fa-fw fa-save"></i> Cadastrar membro da comissão
            </button>                                       
        @elseif($atividade->ce_nota == null && empty($comissao))
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-fw fa-save"></i> Salvar
            </button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#buscarPolicial">
                <i class="fa fa-fw fa-save"></i> Cadastrar membro da comissão
            </button>
        @endif    
    </div>
</form>


<!-- Tabela comissão -->
@if($atividade->ce_nota == null)
    @if(!empty($comissao))
    <div class="table-responsive">
        <table class="table striped" id="policiais">
            <thead>
                <tr class='bg-primary'>
                    <th colspan="6">Comissão</th>
                </tr>
                <tr>
                    <th>Nome</th>
                    <th>Post/Grad</th>
                    <th>Matrícula</th>
                    <th>Função</th>
                    <th>Ações</th>
                    <th>Assinatura</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($comissao))
                    @forelse($comissao as $c)
                        <tr>
                            <th>{{$c->st_nomeassinante}}</th>
                            <th>{{$c->st_postograd}}</th>
                            <th>{{$c->st_matriculaassinante}}</th>                                            
                            <th>{{$c->st_funcao}}</th>
                            <th>
                                @if(!isset($c->st_assinatura) && $c->st_matriculaassinante == $matriculaLogada)
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-placement="top" data-target="#assinarComissaoConfirmacaoModal" title="Assinar"><i class="glyphicon glyphicon-pencil"></i></button> | 
                                @endif
                                <a onclick="modalDesativa({{$idQuadro}}, {{$atividade->id}}, {{$c->ce_policial}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> 
                            </th>
                            @if($c->st_assinatura!=null)
                                <th><i class="glyphicon glyphicon-ok text-green"></i></th>
                            @endif
                        </tr>
                    @empty
                    <tr>
                        <th colspan="6" style="text-align: center;">Nenhum policial cadastrado.</th>
                    </tr>
                    @endforelse                                    
                @endif
            </tbody>
        </table>
    </div>
    @endif
@elseif($atividade->ce_nota != null)
        @if(!empty($comissao))
        <div class="table-responsive">
            <table class="table striped" id="policiais">
                <thead>
                    <tr class='bg-primary'>
                        <th colspan="6">Comissão</th>
                    </tr>
                    <tr>
                        <th>Nome</th>
                        <th>Post/Grad</th>
                        <th>Matrícula</th>
                        <th>Função</th>
                        <th>Assinatura</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($comissao))
                        @forelse($comissao as $c)
                            <tr>
                                <th>{{$c->st_nomeassinante}}</th>
                                <th>{{$c->st_postograd}}</th>
                                <th>{{$c->st_matriculaassinante}}</th>                                            
                                <th>{{$c->st_funcao}}</th>
                                @if($c->st_assinatura!=null)
                                    <th><i class="glyphicon glyphicon-ok text-green"></i></th>
                                @endif
                            </tr>
                        @empty
                        <tr>
                            <th colspan="6" style="text-align: center;">Nenhum policial cadastrado.</th>
                        </tr>
                        @endforelse                                    
                    @endif
                </tbody>
            </table>
        </div>
        @endif
@endif



    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary container-fluid">
                <div class="panel-heading row">
                    <div class="col-md-10">Policiais para o Quadro de Acesso da Promoção de {{date('d/m/Y', strtotime($quadro->dt_promocao))}}</div>
                    <div class="col-md-2">{{(isset($nota)) ? 'SITUAÇÃO: ' . $nota->st_status : ''}}</div>
                </div>
                <div class="panel-body">
                <div class="row">
                    <div class="col-12" id="alertSucesso"></div>
                    @if(isset($atividade) && empty($atividade->dt_atividade))
                    <div class="form-row form-inline">
                        <div class="form-group col-xs-3 col-md-3 col-sm-3" style="margin-left:auto; padding-top:10px;">
                            <label style="padding: 2%;"><strong>Policial</strong></label>
                            <input type="text" class="form-control" id="st_policial2" placeholder="Matrícula ou CPF">
                            @if(isset($nota))
                            <input type="hidden" class="form-control" id="idNota" value="{{$nota->id}}">
                            @endif
                            <button type="button" onclick="buscaPolicialParaNota()" class="btn btn-primary glyphicon glyphicon-search" title= "Localizar Polcial"></button>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table striped" id="policiais">
                    <thead>
                        <tr>
                            <th>Ordem</th>
                            <th>Post/Grad</th>
                            <th>Praça</th>
                            <th>Matrícula</th>
                            <th>Nome</th>
                            <th>Unidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($policiaisQuadro) && count($policiaisQuadro)>0)
                            @php $ordem = 0;@endphp
                            @foreach($policiaisQuadro as $policial)
                                @php $ordem++ @endphp
                                <tr>
                                    <th>{{$ordem}}</th>
                                    <th>{{$policial->st_postgrad}}</th>
                                    <th>{{$policial->st_numpraca}}</th>
                                    <th>{{$policial->st_matricula}}</th>
                                    <th>{{$policial->st_policial}}</th>
                                    <th>{{$policial->st_unidade}}</th>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th>Nenum policial no Quadro<th>
                            </tr>
                        @endif
                    </tbody>
                 
                    </table>
                    @if(isset($policiaisQuadro) && count($policiaisQuadro)>0)
                        {{$policiaisQuadro->links()}}
                    @endif
                    </div>
                </div>
            </div>
            <div class="form-row">
                <a href="{{url('promocao/quadro/cronograma/'.$idQuadro.'/competencia/'.$competencia)}}" class="col-md-1 btn btn-warning" style="margin-right: 5px;">
                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                </a>
                <form action="{{url('/promocao/gerarnotadivulgarqapreliminar/'.$idQuadro.'/'.$atividade->id.'/gerarNota/visualizar')}}" method="POST">
                {{csrf_field()}}
                    <button style="margin-right: 5px;" type="submit" class="btn btn-primary pull-left">Visualizar Portaria</button>
                </form>
                
                @if(!empty($atividade->st_portaria) && $atividade->ce_nota == null && !empty($comissao) && count($comissao) == $assinaturas)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalConfirmarConclusaoDeListagem">Gerar Nota para BG</button>
                @elseif($atividade->ce_nota != null)
                    <a href='{{ url("boletim/nota/visualizar/" . $atividade->ce_nota)}}' class="btn btn-primary">
                        <span class="fa fa-file-pdf-o"></span> Visualizar Nota
                    </a>
                @endif
            </div>
        </div>
    </div>

<!-- @aggeu. Issue 222. -->
<!-- Modal para adicionar na comissão - buscar policial-->
<div class="modal fade" id="buscarPolicial" role="dialog">
        <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Busca de Policial</h4>
            </div>
            <div class="modal-body">
                <label style="padding: 2%;"><strong>Matrícula ou CPF</strong></label>
                <input type="text" class="form-control" id="st_policial" placeholder="Somente números" onkeypress="return somenteNumeros(event)">      
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
            <button type="button" onclick="buscaPolicialParaNota()" class="btn btn-primary" data-dismiss="modal">Buscar</button>
            </div>
        </div>
        </div>
    </div>

<!-- @aggeu. Issue 222. -->
<!-- Modal para adicionar na comissão - adicionar policial-->
<div class="modal fade" id="modalPolicial" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">                
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cadastro de Policial</h4>
            </div>
            <form method="POST" action="{{url('promocao/comissao/'.$idQuadro.'/'.$atividade->id.'/cadastro')}}">
            {{csrf_field()}}
                <div class="modal-body">
                    <div id="nome"></div>
                    <div id="matricula"></div>                       
                    <div class="form-group">
                        <label for="st_funcaoAssinate">Função</label>
                        <input id="st_funcaoAssinate" type="text" class="form-control" name="st_funcaoAssinate"> 
                    </div>
                    <div class="form-group">
                        <input id="idPolicial" type="hidden" class="form-control" name="idPolicial">
                    </div>             
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- @aggeu. Issue 222. -->
<!-- Modal Excluir policial da comissão-->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Excluir o policial da comissão</h5>
            </div>
            <div class="modal-body alert-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR?</b>
                </h4>
                <form class="form-inline" id="modalDesativa" method="delete" > {{csrf_field()}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Excluir</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- @aggeu. Issue 222. -->
<!-- Moldal para assinar comissão - confirmar -->
<div class="modal fade" id="assinarComissaoConfirmacaoModal" tabindex="-1" role="dialog" aria-labelledby="assinarComissaoConfirmacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="assinarComissaoConfirmacaoModalLabel">Assinar</h5>
            </div>
            <div class="modal-body bg-danger">
                <div>
                    <strong> DESEJA REALMENTE ASSINAR? </strong>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary pull-right" data-dismiss="modal" data-toggle="modal" data-placement="top" data-target="#assinarCommissaoModal">Sim</button>
                    <!-- <a href='{{url("boletim/nota/finalizar/")}}' class="btn btn-primary">Sim</a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- @aggeu. Issue 222. -->
<!-- Moldal para assinar comissão - assinar -->
<div class="modal fade" id="assinarCommissaoModal" tabindex="-1" role="dialog" aria-labelledby="assinarCommissaoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-sm">
            <form action="{{url('promocao/comissao/'.$idQuadro.'/'.$atividade->id.'/assinatura')}}" method="POST">
            {{csrf_field()}}
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="assinarCommissaoModalLabel">Assinar Comissão</h5>
                </div>

                <div class="modal-body">            
                    <p><strong> Digite sua senha para assinar eletronicamente </strong></p><br/>
                    <div class="form-group">
                        <label for="pass" class="control-label">Senha:</label>
                        <div class="">
                            <input type="password" class="form-control" name="st_password" required>
                        </div>                            
                    </div>
                </div>
                
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Assinar</button>
                    </div>
                </div>
                {{ method_field('PUT') }}
            </form>
        </div>
    </div>
</div>
  

   <!-- Modal para confirmar conclusão da lista de efetivo-->
   <div class="modal fade" id="modalConfirmarConclusaoDeListagem" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <form class="form-horizontal" action="{{url('promocao/concluirelacaoefetivo/'.$atividade->id)}}" method="get"> 
                <h4 class="modal-title">Confirmação</h4>
                </div>
                <div class="modal-body  bg-danger">
                    <div class=" bg bg-danger">Ao gerar a nota para BG, o QA não poderar mais ser alterado. Deseja Continuar?</div> 
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal" data-target="#assinar" style="margin:5px">
                        Gerar Nota para BG
                    </button>
                </div>
            </form>
      </div>
    </div>
  </div>
    
  <!--Modal para Concluir Realização de TAF com senha-->
  <div class="modal fade" id="assinar" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Assinar gerar nota</h4>
                </div>
                <div class="modal-body bg-danger">
                    <h4 class="modal-title">Atenção!</h4>
                    <div classe>
                        É necessario assinar eletronicamente a para gerar a nota para boletim.
                    </div>
                </div>
                <div class="modal-body">
                    <form role="form" id="concluirTaf" action="{{url('/promocao/gerarnotadivulgarqapreliminar/'.$idQuadro.'/'.$atividade->id.'/gerarNota/assinar')}}" method="POST">
                        {{csrf_field()}}
                        <h4>Informe a Senha:</h4>
                        <input id="password" type="password" class="form-control" name="password" value="" placeholder="Digite sua senha..." required>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="concluirTaf"  data-toggle="modal"class="btn btn-primary">Assinar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('scripts')
    <script>
        function buscaPolicialParaNota(){
            if(dadoPolicial = $('#st_policial').val()){               
                if(dadoPolicial != null && dadoPolicial != undefined && dadoPolicial != ""){
                    $.ajax({
                        url : "{{url('rh/buscapolicialparanota')}}" + "/" + encodeURI(dadoPolicial),
                        type : 'get',
                        beforeSend : function(){
                            $("#resultado").html("ENVIANDO...");
                        }
                    }).done(function(msg){
                        $('#st_policial').val("");
                        if(msg.st_nome){
                            idPolicial = msg.id;
                            $("#idPolicial").val(msg.id)
                            $("#nome").html("Nome: "+msg.st_nome)
                            $("#matricula").html("Matrícula: "+msg.st_matricula)
                            $('#modalPolicial').modal('show');
                        }else{
                            alert(msg);
                        }
                    }).fail(function(jqXHR, textStatus, msg){
                        alert(msg);
                    })
                }else{
                    alert('informe a Matrícula ou cpf do policial');
                }
            }else if(dadoPolicial = $('#st_policial2').val()){
                if(dadoPolicial != null && dadoPolicial != undefined && dadoPolicial != ""){
                    $.ajax({
                        url : "{{url('rh/buscapolicialparanota')}}" + "/" + encodeURI(dadoPolicial),
                        type : 'get',
                        beforeSend : function(){
                            $("#resultado").html("ENVIANDO...");
                        }
                    }).done(function(msg){
                        $('#st_policial2').val("");
                        if(msg.st_nome){
                            idPolicial = msg.id;
                            $("#idPolicial").val(msg.id)
                            $("#nome").html("Nome: "+msg.st_nome)
                            $("#matricula").html("Matrícula: "+msg.st_matricula)
                            $('#modalPolicial').modal('show');
                        }else{
                            alert(msg);
                        }
                    }).fail(function(jqXHR, textStatus, msg){
                        alert(msg);
                    })
                }else{
                    alert('informe a Matrícula ou cpf do policial');
                }
            }
            
        }

        function modalDesativa(idQuadro, idAtividade, idPolicial){
            var url = idQuadro+"/atividade/"+idAtividade+"/deleta/policial/"+idPolicial+"/assinatura/portaria";                      
            $("#modalDesativa").attr("action", "{{ url('promocao/quadrosacessos/')}}/"+url);
            $('#Modal').modal();        
        }

        /* fonte: https://www.linhadecomando.com/javascript/javascript-permitir-somente-numeros */
        function somenteNumeros(e) {
            var charCode = e.charCode ? e.charCode : e.keyCode;
            // charCode 8 = backspace   
            // charCode 9 = tab
            if (charCode != 8 && charCode != 9) {
                // charCode 48 equivale a 0   
                // charCode 57 equivale a 9
                if (charCode < 48 || charCode > 57) {
                    return false;
                }
            }
        }

    </script>
@stop