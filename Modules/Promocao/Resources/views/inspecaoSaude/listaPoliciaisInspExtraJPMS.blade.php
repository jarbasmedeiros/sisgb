@extends('adminlte::page')
@section('title', 'Convocação Extra')
@section('content')
@if(isset($nota))
@else
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary container-fluid">
                <div class="panel-heading row">
                    <div class="col-md-10">{{$titulopainel}}{{date('d/m/Y', strtotime($quadro->dt_promocao))}}</div>
                    <div class="col-md-2">{{(isset($nota)) ? 'SITUAÇÃO: ' . $nota->st_status : ''}}</div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" id="form_create_nota" action="{{url('promocao/convocacaoextra/portaria/salvar/'  . $idQuadroAcesso . '/' . $idAtividade . '/competencia/' . $competencia)}}">
                        {{csrf_field()}}
                        <div class="camposdanota"></div>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">MATÉRIA DA NOTA</legend>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea class="ckeditor" id="st_portaria" name="st_portaria">
                                    @if(isset($dadosDaPortaria))
                                    {{$dadosDaPortaria->st_portaria}}
                                    @endif
                                    </textarea>
                                </div>
                            </div>
                        </fieldset>
                        
                        
                        <div class="form-group col-md-12">
                            @if(!isset($dadosDaPortaria->ce_nota) || (empty($dadosDaPortaria->ce_nota)))
                                <button type="submit" id="salvarNota" class="col-md-1 btn btn-primary" style="margin: 5px" >
                                <i class="fa fa-save"></i> Salvar Portaria
                                </button>
                            @endif
                        </div>
                    </form>



@endif

                </div>
                <div class="panel-body">
                <div class="row">
                    <div class="col-12" id="alertSucesso"></div>
                    @if(!isset($dadosDaPortaria->ce_nota) || (empty($dadosDaPortaria->ce_nota)))
                    <div class="form-row form-inline">
                        <div class="form-group col-xs-3 col-md-3 col-sm-3" style="margin-left:auto; padding-top:10px;">
                            <label style="padding: 2%;"><strong>Policial</strong></label>
                            <input type="text" class="form-control" id="st_policial" placeholder="Matrícula ou CPF">
                            @if(isset($dadosDaPortaria->ce_nota))
                            <input type="hidden" class="form-control" id="idNota" value="{{$dadosDaPortaria->ce_nota}}">
                            @endif
                            <button type="button" onclick="buscaPolicialParaNota()" class="btn btn-primary glyphicon glyphicon-search" title= "Localizar Policial"></button>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table striped" id="policiais">
                    <thead>
                    @if(isset($dadosDaPortaria->policiais) && count($dadosDaPortaria->policiais)>0)
                        <tr>
                            <th>Ordem</th>
                            <th>Post/Grad</th>
                            <th>Praça</th>
                            <th>Matrícula</th>
                            <th>Nome</th>
                            <th>Unidade</th>
                            @if(isset($dadosDaPortaria->ce_nota) && empty($dadosDaPortaria->ce_nota))
                            <th>Ação</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                            @php $ordem = 0;@endphp
                            @foreach($dadosDaPortaria->policiais as $policial)
                                @php $ordem++ @endphp
                                <tr>
                                    <th>{{$ordem}}</th>
                                    <th>{{$policial->st_postgrad}}</th>
                                    <th>{{$policial->st_numpraca}}</th>
                                    <th>{{$policial->st_matricula}}</th>
                                    <th>{{$policial->st_policial}}</th>
                                    <th>{{$policial->st_unidade}}</th>
                                    <th>
                                    @if(isset($dadosDaPortaria->ce_nota) && empty($dadosDaPortaria->ce_nota))
                                        <button type="button" onclick="populaModalConfRemoverPolicialQuadro({{$policial->ce_policial}}, {{$policial->ce_quadroacesso}}, {{$atividade->id}})" data-toggle="modal" data-target="#modalRemoverPolicialDoQuadro" title='Remover Policial' class="btn btn-danger fo fa fa-remove"></button>
                                    @endif
                                    </th>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th>Nenhum policial no Quadro<th>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                    <tr colspan="6">
                            <th>
                            @if(isset($dadosDaPortaria->policiais) && count($dadosDaPortaria->policiais) == '1')
                                {{count($dadosDaPortaria->policiais)}} Policial
                            @elseif(isset($dadosDaPortaria->policiais) && count($dadosDaPortaria->policiais) > '1')
                                {{count($dadosDaPortaria->policiais)}} Policiais
                            @else
                            @endif
                            </th>
                        </tr>
                    </tfoot>
                    </table>
                    
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <a href="{{url('promocao/quadro/cronograma/'.$idQuadroAcesso. '/competencia/'.$competencia)}}" class="col-md-1 btn btn-warning" style="margin:5px">
                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                </a>
                @if(isset($dadosDaPortaria->policiais) && count($dadosDaPortaria->policiais)>0)
               
                    @if(isset($dadosDaPortaria->ce_nota) && empty($dadosDaPortaria->ce_nota) )
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gerarNotaModal">Gerar Nota para BG</button>
                    @elseif(isset($dadosDaPortaria->ce_nota) && !empty($dadosDaPortaria->ce_nota) )
                        <a href="{{url('boletim/nota/visualizar/'.$dadosDaPortaria->ce_nota)}}" class="btn btn-primary" style="margin:5px">
                            <span class="fa fa-file-pdf-o"></span> Visualizar Nota
                        </a>
                    @endif
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
            <form action="{{url('/promocao/gerarnotarconvocacaoextra/'.$idQuadroAcesso.'/'.$atividade->id.'/gerarNota/competencia/'.$competencia)}}" method="POST">
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

@stop
@section('scripts')
    <script>

        function buscaPolicialParaNota(){
            alert('ok');
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

        function addPolicialParaQuadroDeAcesso(idQuadroAcesso){
            $.ajax({
                url : "{{url('promocao/quadrodeacesso/addpolicialnalistadoqudro/')}}"+"/"+idQuadroAcesso+"/"+idPolicial,
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
            $("#urlRemoverPolicialQuadro").attr("href", "{{ url('promocao/removerpolicialdaconvocaoextra')}}/"+idPolicial+"/"+idQuadroAcesso+"/"+idAtividade);
        }
    </script>
@stop