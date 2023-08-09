@extends('adminlte::page')
@php 
    use app\utis\Funcoes;
@endphp
@section('title', 'Polciais do QA')
@section('content')
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
                            <input type="text" class="form-control" id="st_policial" placeholder="Matrícula ou CPF">
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
                            <th>Ação</th>
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
                                    <th>
                                    @if(isset($atividade) && empty($atividade->dt_atividade))
                                        <button type="button" onclick="populaModalConfRemoverPolicialQuadro({{$policial->ce_policial}}, {{$policial->ce_quadroacesso}}, {{$atividade->id}})" data-toggle="modal" data-target="#modalRemoverPolicialDoQuadro" title='Remover Policial' class="btn btn-danger fo fa fa-remove"></button>
                                    @endif
                                    </th>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th>Nenum policial no Quadro<th>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr colspan="6">
                            <th>
                                {{(count($policiaisQuadro)>0) ? $policiaisQuadro->total() : '0'}} Policiais
                            </th>
                        </tr>
                    </tfoot>
                    </table>
                    @if(isset($policiaisQuadro) && count($policiaisQuadro)>0)
                        {{$policiaisQuadro->links()}}
                    @endif
                    </div>
                </div>
            </div>
            <div class="form-row">
                <a href="{{url('promocao/quadro/cronograma/'.$idQuadro.'/competencia/'.$competencia)}}" class="col-md-1 btn btn-warning" style="margin:5px">
                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                </a>
                @if(isset($atividade) && empty($atividade->dt_atividade) && count($policiaisQuadro)>0)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalConfirmarConclusaoDeListagem" style="margin:5px">
                        Concluir Relação de Efetivo
                    </button>
                @endif
            </div>
        </div>
    </div>

    
  <!-- Modal para adicionar policial ao Quadro de Acesso -->
  <div class="modal fade" id="modalPolicial" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmação de Policial</h4>
        </div>
        <div class="modal-body">
            <div id="nome"></div>
            <div id="matricula"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
          <button type="button" onclick="addPolicialParaQuadroDeAcesso({{$quadro->id}})" class="btn btn-primary" data-dismiss="modal">Adicionar ao Quadro</button>
        </div>
      </div>
    </div>
  </div>


   <!-- Modal para remover policial do quadro de acesso-->
   <div class="modal fade" id="modalRemoverPolicialDoQuadro" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmação de Remover Policial</h4>
        </div>
        <div class="modal-body">
            <div id="nome">Deseja Realmente Remover o Policial?</div>
            <div id="nome"></div>
            <div id="matricula"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
          <a id="urlRemoverPolicialQuadro"  class="btn btn-primary" >Remover</a>
        </div>
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
                    <div class=" bg bg-danger">Após concluir a Relação do efetivo não será possível adicionar ou remover policial.
                Deseja Continuar?</div>
                    
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                <button type="subpmit" class="btn btn-primary" >Concluir Relação de Efetivo</button>
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

        function addPolicialParaQuadroDeAcesso(idQuadro){
            $.ajax({
                url : "{{url('promocao/quadrodeacesso/addpolicialnalistadoqudro/')}}"+"/"+idQuadro+"/"+idPolicial,
                method : 'get',
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
    </script>
@stop