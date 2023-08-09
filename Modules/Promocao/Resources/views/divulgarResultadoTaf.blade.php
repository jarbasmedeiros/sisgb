@extends('adminlte::page')
@php
    use app\utis\Funcoes;
@endphp
@section('title', 'SISGP - TAF')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div class="col-md-10">
                    <h4>{{$titulopainel}} {{date('d/m/Y', strtotime($quadro->dt_promocao))}}</h4>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12" id="alertSucesso"></div>
                    <div class="form-row">
                        <form method="POST" role="form" action="{{url('promocao/resultadotaf/'.$quadro->id.'/'.$atividade->id.'/competencia/'.$competencia)}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Dados da Portaria</label>
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
                        </form>
                    </div>
                </div>
                <br>
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
                <div class="table-responsive">
                    <table class="table striped" id="policiais">
                        <thead>
                            <tr class='bg-primary'>
                                    <th colspan="6">Policiais Inspecionados</th>
                                </tr>
                            <tr>
                                <th>Ordem</th>
                                <th>Post/Grad</th>
                                <th>N° Praça</th>
                                <th>Matrícula</th>
                                <th>Nome</th>
                                <th>Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($policiaisQuadro) && count($policiaisQuadro) > 0)
                                @php
                                    $ordem = 0;
                                @endphp
                                @foreach($policiaisQuadro as $policial)
                                    @php
                                        $ordem++;
                                    @endphp
                                    <tr>
                                        <th>{{$ordem}}</th>
                                        <th>{{$policial->st_postgrad}}</th>
                                        <th>{{$policial->st_numpraca}}</th>
                                        <th>{{$policial->st_matricula}}</th>
                                        <th>{{$policial->st_policial}}</th>
                                        <th>{{$policial->st_inspecaotafparecer}}{{' '.$policial->st_inspecaotafobs}}</th>
                                        <th></th>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>{{$policiaisQuadro->links()}}<th>
                                </tr>
                            @else
                                <tr>
                                    <th colspan="6">Nenhum policial inspecionado.</th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <a href="{{url('promocao/quadro/cronograma/'.$idQuadro.'/competencia/'.$competencia)}}" class="col-md-1 btn btn-warning" style="margin-right: 5px;">
            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
        </a>
                
        <form action="{{url('/promocao/divulgarTaf/'.$idQuadro.'/'.$atividade->id.'/gerarNota/visualizar')}}" method="POST">
        {{csrf_field()}}
            <button style="margin-right: 5px;" type="submit" class="btn btn-primary pull-left">Visualizar Portaria</button>
        </form>
        
        @if(!empty($atividade->st_portaria) && $atividade->ce_nota == null && !empty($comissao) && count($comissao) == $assinaturas)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gerarNotaModal">Gerar Nota para BG</button>
        @elseif($atividade->ce_nota != null)
            <a href='{{ url("boletim/nota/visualizar/" . $atividade->ce_nota)}}' class="btn btn-primary">
                <span class="fa fa-file-pdf-o"></span> Visualizar Nota
            </a>
        @endif
    </div>
</div>

    <!-- Moldal para botão finalizar -->
    <div class="modal fade" id="gerarNotaModal" tabindex="-1" role="dialog" aria-labelledby="gerarNotaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="gerarNotaModalLabel">Gerar Nota</h5>
                </div>
                <div class="modal-body bg-danger">
                    <div>
                        <strong> DESEJA REALMENTE GERAR A NOTA? </strong>
                        <p> Após gerar a nota, a convocação não poderá mais ser editada. </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#assinarModal">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Moldal para botão visualizar -->
    <div class="modal fade" id="visualizarNotaModal" tabindex="-1" role="dialog" aria-labelledby="visualizarNotaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="visualizarNotaModalLabel">Gerar Nota</h5>
                </div>
                <div class="modal-body bg-danger">
                    <div>
                        <strong> DESEJA REALMENTE VISUALIZAR A NOTA? </strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#visualizarModal">Sim</button>
                        <!-- <a href='{{url("boletim/nota/finalizar/")}}' class="btn btn-primary">Sim</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Moldal para botão assinar da comissão - confirmacao -->
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

    <!-- Moldal assinar da comissao -->
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

    <!-- Moldal Assinar Nota -->
    <div class="modal fade" id="assinarModal" tabindex="-1" role="dialog" aria-labelledby="assinarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-sm">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="assinarModalLabel">Assinar Nota</h5>
            </div>

            <div class="modal-body">
            <form action="{{url('/promocao/divulgarTaf/'.$idQuadro.'/'.$atividade->id.'/gerarNota/gerar')}}" method="POST">
                {{csrf_field()}}
                <p><strong> Digite sua senha para assinar eletronicamente </strong></p><br/>
                <div class="form-group">
                    <label for="pass" class="control-label">Senha:</label>
                    <div class="">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Assinar</button>
                </div>
            </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Moldal Assinar visualização -->
    <div class="modal fade" id="visualizarModal" tabindex="-1" role="dialog" aria-labelledby="visualizarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-sm">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="visualizarModalLabel">Assinar Nota</h5>
            </div>

            <div class="modal-body">
            <form action="{{url('/promocao/divulgarTaf/'.$idQuadro.'/'.$atividade->id.'/gerarNota/visualizar')}}" method="POST">
                {{csrf_field()}}
                <p><strong> Digite sua senha para assinar eletronicamente </strong></p><br/>
                <div class="form-group">
                    <label for="pass" class="control-label">Senha:</label>
                    <div class="">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Assinar</button>
                </div>
            </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Moldal para botão finalizar -->
    <div class="modal fade" id="gerarNotaModal" tabindex="-1" role="dialog" aria-labelledby="gerarNotaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="gerarNotaModalLabel">Gerar Nota</h5>
                </div>
                <div class="modal-body bg-danger">
                    <div>
                        <strong> DESEJA REALMENTE GERAR A NOTA? </strong>
                        <p> Após gerar a nota, a convocação não poderá mais ser editada. </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#assinarModal">Sim</button>
                        <!-- <a href='{{url("boletim/nota/finalizar/")}}' class="btn btn-primary">Sim</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal para adicionar policial na comissão-->
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

    <!-- Modal para buscar policial para adicionar na comissão -->
    <div class="modal fade" id="buscarPolicial" role="dialog">
        <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Busca de Policial</h4>
            </div>
            <div class="modal-body">
                <label style="padding: 2%;"><strong>Policial</strong></label>
                <input type="text" class="form-control" id="st_policial" placeholder="Matrícula ou CPF">      
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
            <button type="button" onclick="buscaPolicialParaNota()" class="btn btn-primary" data-dismiss="modal">Buscar</button>
            </div>
        </div>
        </div>
    </div>

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



@stop
@section('scripts')
    <script>
        function buscaPolicialParaNota(){
            dadoPolicial = $('#st_policial').val();
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
        }

        function cadastraPolicialassinaturaPortaria(idQuadro, idAtividade){
            
                $.ajax({                    
                    url : "quadrosacessos/"+idQuadro+"/atividade/"+idAtividade+"/cadastra/policial/"+idPolicial+"/assinatura/portaria",
                    method : 'post',
                    beforeSend : function(){
                        $("#atertSucesso").html("ENVIANDO...");
                    }
                }).done(function(msg){
                    if(msg == 1){
                        location.reload()
                        setTimeout(function(){ location.reload(); }, 1000);
                        $("#alertSucesso").addClass("alert alert-success");
                        $("#alertSucesso").html('Policial Adicionado com Sucesso!!');

                    }else{
                    alert(msg); 
                    }
                    
                }).fail(function(jqXHR, textStatus, msg){
                    alert(msg);
                })
           
        }
        //adiciona o href dinamico para o modal de comfirmação de remoção de policial do
        function populaModalConfRemoverPolicialQuadro(idPolicial, idQuadroAcesso, idAtividade){
            $("#urlRemoverPolicialQuadro").attr("href", "{{ url('promocao/removerpolicialdoquadro')}}/"+idPolicial+"/"+idQuadroAcesso+'/'+idAtividade);
        }

        function modalDesativa(idQuadro, idAtividade, idPolicial){
            var url = idQuadro+"/atividade/"+idAtividade+"/deleta/policial/"+idPolicial+"/assinatura/portaria";                      
            $("#modalDesativa").attr("action", "{{ url('promocao/quadrosacessos/')}}/"+url);
            $('#Modal').modal();        
        }
    </script>
@stop

<!-- quadrosacessos/{idQuadro}/atividade/{idAtividade}/deleta/policial/{idPolicial}/assinatura/portaria -->