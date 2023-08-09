@extends('adminlte::page')
@section('title', 'Quantitativo de Vagas')
@section('content')
<div class="container-fluid">
    <div class="row">                   
        <div class="panel panel-primary">
            <div class="panel-heading">Dados da Portaria</div>
            <div class="panel-body">
            <fieldset class="scheduler-border">
            <div class="row">
                <div class="col-12" id="alertSucesso"></div>
                    <div class="form-row">
                        <form method="POST" role="form" action="{{url('/promocao/quadro/'.$atividade->ce_quadroacesso.'/atividade/'.$atividade->id.'/cadastra/portaria/quadroDeVagas')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1" hidden>Dados da Portaria</label>
                                @if($atividade->ce_nota == null && $alguemAssinou == false)
                                    <textarea type="textarea" class="ckeditor form-control" name="st_portaria" id="st_portaria" rows="10" required>{{$atividade->st_portaria}}</textarea>
                            </div>
                                    <button type="submit" class="btn btn-primary" title="Salvar dados da portaria">
                                        <i class="fa fa-fw fa-save"></i> Salvar
                                    </button>
                                @else
                                    {!! $atividade->st_portaria !!}
                            </div>
                                @endif
                        </form>
                    </div>
                </div>
            </div>   
            </fieldset>
                    {{csrf_field()}}
                    @if(isset($membrosDaComissao) && count($membrosDaComissao) > 0)
                    <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Membros da Comissão</legend>
                    <table class="table table-bordered"><!--Tabela dos membros da comissão-->
                            <thead>
                                <tr class="bg-primary">
                                        <th class="col-md-2">Posto / Graduação</th>
                                        <th class="col-md-5">Nome</th>
                                        <th class="col-md-2">Função</th>
                                        <th class="col-md-1">Assinatura</th>
                                        <th class="col-md-2">Ações</th>
                                    </tr>
                            </thead>
                           
                            @foreach($membrosDaComissao as $m)
                                <tr>
                                    <th>{{$m->st_postograd}}</th>
                                    <th>{{$m->st_nomeassinante}}</th>
                                    <th>{{$m->st_funcao}}</th>
                                    @if(!isset($m->st_assinatura))
                                        <th style="text-align:center;">
                                            <span class="fa fa-hourglass-end" title="Aguardando Assinatura"></span>
                                        </th>
                                        @if( $atividade->ce_nota == null)
                                            <th style="text-align: center">
                                            
                                                <a onclick="modalDeleta({{$atividade->ce_quadroacesso}}, {{$atividade->id}}, {{$m->ce_policial}})" data-toggle="modalDeletar" data-placement="top" title="Deletar Membro da Comissão" class="btn btn-danger btn-xs fa fa fa-trash"></a> 
                                             
                                                @if( $matricula == $m->st_matriculaassinante ) 
                                                    <button type="button" class="btn btn-success btn-xs fa fa-pencil-square-o" data-dismiss="modal" data-toggle="modal" data-target="#assinarModal" title="Assinar"></button>
                                                @endif
                                            </th>
                                        @endif
                                    @else
                                        <th style="text-align:center;">
                                            <span class="glyphicon glyphicon-ok text-green" title="Assinado"></span>
                                        </th>
                                       
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                        @if( $atividade->ce_nota == null)
                            <form action="{{url('promocao/quadro/calcularvagas/'.$atividade->ce_quadroacesso.'/'.$atividade->id.'/nota/visualizar')}}" method="POST">
                            {{csrf_field()}}                                                
                                <button type="button" class="btn btn-primary botoesFinais" title="Adicionar membro na comissão" data-toggle="modal" data-target="#cadastrarMembroModal">
                                    <span class="fa fa-user-plus"></span> Adicionar Membro
                                </button> 
                            </form> 
                        @endif
                    </fieldset>
                    @endif
                    @php $total = 0; @endphp
                    <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Quantitativo de Vagas</legend>
                        @foreach($vagas as $v)
                            @if(isset($quadro))
                                @if($quadro == $v->st_qpmp)
                                    @php
                                        $total = ($total + $v->nu_vagas);
                                    @endphp
                                    <tr>
                                        <th>{{$v->st_postograduacao}}</th>
                                        <th>{{$v->nu_vagasprevistas}}</th>
                                        <th>{{$v->nu_vagasexistente}}</th>
                                        <th>{{$v->nu_claro}}</th>
                                        <th>{{$v->nu_excedente}}</th>
                                        <th>{{$v->nu_agragados}}</th>
                                        <th>{{$v->nu_vagas}}</th>
                                    </tr>
                                @else
                                    <tr class="bg-info">
                                        <th colspan="6" class="foot">TOTAL</th>
                                        <th>{{$total}}</th>
                                    </tr>
                                    </table>
                                        @php
                                            $total = 0;
                                            $total = ($total + $v->nu_vagas);
                                        @endphp
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th colspan="2">{{$v->st_qpmp}} - {{$v->st_descricao}}</th>
                                            </tr>
                                            <tr class="bg-primary">
                                                <th class="col-md-2">Graduações</th>
                                                <th class="col-md-2">Previstos</th>
                                                <th class="col-md-1">Existentes</th>
                                                <th class="col-md-1">Claros</th>
                                                <th class="col-md-1">Excedentes</th>
                                                <th class="col-md-1">Agregados</th>
                                                <th class="col-md-1">Vagas</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <th>{{$v->st_postograduacao}}</th>
                                            <th>{{$v->nu_vagasprevistas}}</th>
                                            <th>{{$v->nu_vagasexistente}}</th>
                                            <th>{{$v->nu_claro}}</th>
                                            <th>{{$v->nu_excedente}}</th>
                                            <th>{{$v->nu_agragados}}</th>
                                            <th>{{$v->nu_vagas}}</th>
                                        </tr>
                                    @php
                                        $quadro = $v->st_qpmp
                                    @endphp
                                @endif
                            @else
                            <table class="table table-bordered"><!--Primeira volta do for-->
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="2">{{$v->st_qpmp}} - {{$v->st_descricao}}</th>
                                    </tr>
                                    <tr class="bg-primary">
                                            <th class="col-md-2">Graduações</th>
                                            <th class="col-md-2">Previstos</th>
                                            <th class="col-md-1">Existentes</th>
                                            <th class="col-md-1">Claros</th>
                                            <th class="col-md-1">Excedentes</th>
                                            <th class="col-md-1">Agregados</th>
                                            <th class="col-md-1">Vagas</th>
                                        </tr>
                                </thead>
                                <tr>
                                    <th>{{$v->st_postograduacao}}</th>
                                    <th>{{$v->nu_vagasprevistas}}</th>
                                    <th>{{$v->nu_vagasexistente}}</th>
                                    <th>{{$v->nu_claro}}</th>
                                    <th>{{$v->nu_excedente}}</th>
                                    <th>{{$v->nu_agragados}}</th>
                                    <th>{{$v->nu_vagas}}</th>
                                </tr>
                                @php
                                    $quadro = $v->st_qpmp;
                                    $total = $v->nu_vagas;
                                @endphp
                            @endif
                        @endforeach
                            <tr class="bg-info">
                                <th colspan="6" class="foot">TOTAL</th>
                                <th>{{$total}}</th>
                            </tr>
                        </table>
                    </fieldset>
                    
                       
                    <a href="{{url('promocao/quadro/cronograma/'.$atividade->ce_quadroacesso.'/competencia/'.$competencia)}}" class="col-md-1 btn btn-warning botoesFinais" id="voltar">
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </a>
                    @if( $atividade->ce_nota == null)
                        <form action="{{url('promocao/quadro/calcularvagas/'.$atividade->ce_quadroacesso.'/'.$atividade->id.'/nota/visualizar')}}" method="POST">
                        {{csrf_field()}}
                            <button type="submit" class="btn btn-primary botoesFinais" title="Visualizar Portaria">
                                <span class="fa fa-file-pdf-o"></span> Visualizar Portaria
                            </button>                                         
                            @if($todosAssinaram)
                                <button type="button" class="btn btn-primary botoesFinais" data-toggle="modal" data-target="#gerarNotaModal">
                                    <span class="glyphicon glyphicon-list-alt"></span> Gerar Nota para BG
                                </button>
                            @endif
                        </form>
                    @else
                        <a href='{{ url("boletim/nota/visualizar/" . $atividade->ce_nota)}}' class="btn btn-primary botoesFinais">
                            <span class="fa fa-file-pdf-o"></span> Visualizar Portaria
                        </a>
                        <a href='{{ url("boletim/nota/visualizar/" . $atividade->ce_nota)}}' class="btn btn-primary botoesFinais">
                            <span class="fa fa-file-pdf-o"></span> Visualizar Nota
                        </a>
                    @endif
                
               
            </div>
        </div>
    </div>
</div>
@stop

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
            <form action="{{url('promocao/quadro/calcularvagas/'.$atividade->ce_quadroacesso.'/'.$atividade->id.'/nota/gerarNota')}}" method="POST">
            {{csrf_field()}}
                <div>
                    <strong> DESEJA REALMENTE GERAR A NOTA PARA BG? </strong>
                    <p> Após gerar a nota, não será mais possível alterar o número de vagas para promoção. </p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Sim</button>
                </div>
            </div>
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
            <form action="{{url('promocao/quadro/'.$atividade->ce_quadroacesso.'/atividade/'.$atividade->id.'/comissao/assinatura/portaria')}}" method="post">
                {{csrf_field()}}
                <p><strong> Digite sua senha para assinar eletronicamente </strong></p><br/>
                <div class="form-group">
                    <label for="pass" class="control-label">Senha:</label>
                    <div class="">
                        <input type="password" class="form-control" name="st_password" id="st_password" required>
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

<!-- Moldal cadastrar membro na comissão -->
<div class="modal fade" id="cadastrarMembroModal" tabindex="-1" role="dialog" aria-labelledby="cadastrarMembroModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
            <h4 class="modal-title" id="cadastrarMembroModalLabel">Pesquisar policial para cadastro na Comissão</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="st_policial" class="col-sm-2 col-form-label" style="margin-top: 8px;">Pesquisar</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" style="margin: 0px;" id="st_policial" placeholder="Digite aqui a Matrícula ou CPF do policial">
                    </div>
                    <div class="col-sm-2">                      
                        <button type="button" onclick="buscaPolicialParaNota()" class="btn btn-primary glyphicon glyphicon-search" style="margin-bottom: 10px;" title= "Localizar Policial"></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-left">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"> 
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para adicionar policial na comissão -->
<div class="modal fade" id="modalPolicial" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmar Membro da Comissão</h4>
        </div>
        <form class="form-group" action="{{url('promocao/quadro/'.$atividade->ce_quadroacesso.'/atividade/'.$atividade->id.'/policial/comissao')}}" method="post">
        {{csrf_field()}}
        <div class="modal-body">
            <div id="nome"></div>
            <div id="matricula"></div>
            <div>
                <label for="st_funcao">Função</label>
                <input type="text" name="st_funcao" id="st_funcao" placeholder="Digite aqui a função" required>
            </div>
            <div>
                <label for="st_funcao" hidden>idPolicial</label>
                <input type="text" name="idPolicial" id="idPolicial" hidden>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
          <!--  <button type="button" onclick="addPolicialNaComissão()" class="btn btn-primary" data-dismiss="modal">Adicionar na comissão</button> -->
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<!-- Modal Excluir curso -->
<div class="modal fade-lg" id="modalDeletar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Membro da Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR O MEMBRO DA COMISSÃO?</b></br>
                </h4>
               
                <form class="form-inline" id="modalDeleta" method="post" > {{csrf_field()}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Excluir</button>
            </div>
            </form>
        </div>
    </div>
</div>


@section('css')
    <style>
        th{text-align:center;}
        .foot{text-align: right;}
        a, button{margin-right: 05px;}
        .botoesFinais{margin: 10px 00px 05px 05px; }
    </style>
@stop

@section('js')
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

    function addPolicialNaComissão(idQuadro){
        $.ajax({
            url : "{{url('promocao/quadrodeacesso/addpolicialnalistadoqudro/')}}"+"/"+idQuadro+"/"+idPolicial,
            method : 'get',
            beforeSend : function(){
                $("#alertSucesso").html("ENVIANDO...");
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

    function modalDeleta(idQuadro, idAtividade, idPolicial){
        var url = idQuadro+'/atividade/'+idAtividade+'/deleta/policial/'+idPolicial+'/comissao';                      
        $("#modalDeleta").attr("action", "{{ url('promocao/quadro')}}/"+url);
        $('#modalDeletar').modal();        
    };

</script>

@endsection