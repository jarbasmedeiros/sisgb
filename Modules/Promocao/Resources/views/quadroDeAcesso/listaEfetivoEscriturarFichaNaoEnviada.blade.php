@extends('promocao::abas')
@section('title', 'Escriturar Ficha')
@php
    use app\utis\Funcoes;
@endphp

@section('css')
<style>
    th, td { text-align: center; }
    #btn-importar-efetivo {
        float: right;
        margin-top: 30px;
    }
    #label-policial {
        margin-top: 7px;
    }
</style>
@endsection

@php 
    $contador = 0;
    if(isset($contador_inicial)){
        $contador += $contador_inicial;
    }
@endphp

@section('tabcontent')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div class="col-md-10">
                    {{-- Verifica se existe policiais no quadro. Se sim, exibe a quantidade deles, senão, exibe 0 --}}
                    <h4> {{(isset($policiaisQuadro) && (count($policiaisQuadro) > 0)) ? $policiaisQuadro->total() : '0'}} Ficha(s) <b> não enviada(s) </b></h4>
                </div>
                <div class="col-md-2">{{(isset($nota)) ? 'SITUAÇÃO: '.$nota->st_status : ''}}</div>
            </div> 
            <div class="panel-body">
                <div class="row">
                    <div class="col-12" id="alertSucesso"></div>
                    <div class="form-row form-inline col-md-5 col-md-offset-3">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Localizar Policial no QA</legend>
                            <form method="post" action="{{url('promocao/fichasgtnaoenviada/buscasgt/'.$quadro->id.'/'.$atividade->id.'/0/competencia/'.$competencia)}}">
                                {{csrf_field()}}
                                <div class="form-group col-xs-12 col-md-12 col-sm-12 text-center" style="margin-left:auto; margin:10px;">
                                    {{-- <label style="padding: 2%;">
                                        <strong>Localizar Policial</strong>
                                    </label> --}}
                                    <select class="form-control" name="criterio" required>
                                        <option value="st_matricula" selected>Matrícula</option>
                                        <option value="st_cpf">CPF</option>
                                        <option value="st_policial">Nome</option>
                                    </select>
                                    <input type="text" class="form-control" id="st_filtro" name="st_filtro" placeholder="Matrícula ou CPF" required>
                                    @if(isset($nota))
                                        <input type="hidden" class="form-control" id="idNota" value="{{$nota->id}}">
                                    @endif
                                    <button type="submit" class="btn btn-primary glyphicon glyphicon-search" title="Localizar Policial" style="margin-bottom:2px;"></button>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                    {{-- @if (isset($policiaisQuadro) && empty($policiaisQuadro))
                        <div class="col-md-4">
                            <a href="{{route('importaPoliciaisDaUnidadeParaQA', ['idQuadro' => $quadro->id, 'idAtividade' => $atividade->id, 'competencia' => $competencia])}}" class="btn btn-success" id="btn-importar-efetivo" title="Importa efetivo da unidade para o QA">
                                <i class="fa fa-users"></i> Importar Efetivo
                            </a>
                        </div>
                    @endif --}}
                    @can('EDITA_QA')
                        @if (false)
                            <div class="col-md-4">
                                <button id="btn-importar-efetivo" type="button" class="btn btn-success" data-toggle="modal" data-target="#modalConsultaPm" >
                                    <i class="fa fa-user"></i> Importar Policial
                                </button>
                            </div>
                        @endif
                    @endcan
                </div>
                <div>
                    <table class="table table-responsive table-bordered table-striped" id="policiais">
                        <thead>
                            <tr class="bg-primary">
                                <th>Ordem</th>
                                <th>Post/Grad</th>
                                <th>Praça</th>
                                <th>Matrícula</th>
                                <th>Nome</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($policiaisQuadro) && count($policiaisQuadro) > 0)  
                                @foreach($policiaisQuadro as $policial)
                                    @if(empty($policial->bo_fichaenviada))
                                        @php
                                            $contador++;
                                            //dd($policial)
                                        @endphp
                                        <tr>
                                            <td>{{$contador}}</td>
                                            <td>{{$policial->st_postgrad}}</td>
                                            <td>{{$policial->st_numpraca}}</td>
                                            <td>{{$policial->st_matricula}}</td>
                                            <td class="text-left">{{$policial->st_policial}}</td>
                                            <td>
                                                @if ($quadro->st_status === "ABERTO" && $quadro->bo_escriturarliberado)
                                                    @if($policial->bo_importoudados == 1)
                                                        <a href="{{url('promocao/escriturarfichadereconhecimento/'.$quadro->id.'/'.$atividade->id.'/'.$policial->ce_policial.'/competencia/'.$competencia)}}" class='btn btn-sm btn-primary ' title="Escriturar ficha">
                                                            Escriturar
                                                        </a>
                                                    @else 
                                                        <a href="{{route('importaDadosPolicialEscriturarFicha', ['idQuadro' => $quadro->id, 'idAtividade' => $atividade->id, 'competencia' => $competencia, 'idPolicial' => $policial->ce_policial])}}" class='btn btn-sm btn-success ' title="Importar dados do policial para a ficha">
                                                            Importar Dados
                                                        </a>
                                                    @endif 
                                                   
                                                    <a onclick="buscaHistoricoNotas({{$quadro->id}}, {{$policial->ce_policial}})" title="Histórico" class="btn btn-sm btn-primary">
                                                        <span class="fa fa-history"></span>
                                                    </a>
                                                    @can('HOMOLOGAR_FICHA_RECONHECIMENTO')
                                                        <button onclick="editarPolicial( 
                                                                    '{{$policial->st_policial}}', 
                                                                    '{{$policial->st_matricula}}', 
                                                                    '{{$policial->ce_graduacao}}', 
                                                                    '{{$policial->ce_qpmp}}', 
                                                                    '{{$policial->st_numpraca}}', 
                                                                    '{{$policial->dt_nascimento}}', 
                                                                    '{{$policial->ce_unidade}}', 
                                                                    '{{$policial->ce_policial}}', 
                                                                    '{{$quadro->id}}', 
                                                                )" 
                                                            class="btn btn-sm btn-warning" title="Editar dados do policial">
                                                            <span class="fa fa-pencil"></span>
                                                        </button>
                                                    @endcan
                                                    {{-- <a class="btn btn-sm btn-danger " onclick="populaModalConfRemoverPolicialQuadro('{{$policial->ce_policial}}', '{{$policial->ce_quadroacesso}}', '{{$atividade->id}}', '{{$competencia}}')" data-toggle="modal" data-target="#modalRemoverPolicialDoQuadro" title="Remover Policial do QA">
                                                        <i class="fa fa-trash"></i>
                                                    </a> --}}
                                                @endif
                                            </td>
                                        </tr>
                                        @else
                                            <tr>
                                                <td colspan="8">Nenhum policial encontrado</td>
                                            </tr>
                                    @endif    
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">Nenhum policial encontrado</td>
                                </tr>    
                            @endif
                        </tbody>
                    </table>
                    @if(isset($policiaisQuadro) && (count($policiaisQuadro) > 0) )
                        {{$policiaisQuadro->links()}}
                    @endif
                </div>
            </div>
        </div>
        <div class="form-row">
            {{-- essa rota volta para a tela do organograma do QA --}}
            {{-- <a href="{{url('promocao/quadro/cronograma/'.$quadro->id.'/competencia/'.$competencia)}}" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a> --}}
            {{-- essa rota leva para a tela dos QAs --}}
            <a href="{{url('promocao/listadequadrodeacesso/competencia/'.$competencia)}}" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>
            @can('EDITA_QA')
                @if ($quadro->st_status === "ABERTO")
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAdicionaPmEmLote" >
                        <i class="fa fa-user"></i> Importar Policial em LOTE
                    </button>
                @endif
            @endcan
            @if (false)
                @if(empty($atividade->dt_atividade))
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#finalizarModal">Finalizar Escrituração</button>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Moldal Finalizar Período de Escrituração -->
<div class="modal fade" id="finalizarModal" role="dialog" aria-labelledby="finalizarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-sm">
        <div class="modal-header bg-danger">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title" id="finalizarModalLabel">Finalizar período de escrituração</h5>
        </div>

        <div class="modal-body">
        <form action="{{url('promocao/finalizarescrituracao/' . $quadro->id . '/' . $atividade->id.'/competencia/'.$competencia)}}" method="POST">
            {{csrf_field()}}
            <p>Após finalizar o período de escrituação não será possivel editar as Fichas de Reconhecimento dos Sargentos.</p>
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

<!-- Modal consultar pm  -->
<div class="modal fade" id="modalConsultaPm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Consultar Policial para o QA</h4>
            </div>
            <div class="modal-body">
                <div class='form-inline form-group col-md-12'>
                    <label id="label-policial" for="txtCpfMatriculaPolicial" class="col-md-1 col-md-offset-4 control-label">Policial</label>
                    <input id="txtCpfMatriculaPolicial" type="text"  class="form-control" name="txtCpfMatriculaPolicial" placeholder="Digite CPF ou Matrícula..." required>
                    <button type="button" id="btnAddPmANota" name="btnAddPmANota" onclick="consultaPolicial()" class="btn btn-primary" title="Consultar Policial">
                        <i class="fa fa-search"></i>
                    </button>
                    <span id="loader"></span>
                </div>
                <br>
                <br>
                <table class="table table-bordered" id="tblConfirmaPolicial">
                    <thead>
                        <tr class="bg-primary">
                            <th class="col-md-1">Post/Grad</th>
                            <th class="col-md-2">Matrícula</th>
                            <th class="col-md-9">Nome</th>
                        </tr>
                    </thead>
                    <tbody name="policialencontrado_tbody" id="policialencontrado_tbody"> </tbody>
                </table>
                <input type="hidden" name="idPolicial" id="idPolicial">
                <input type="hidden" name="unidadePolicial" id="unidadePolicial">
            </div>
            <div class="modal-footer">
                <button type="button" id="canceladd" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btnAddPmANota" name="btnAddPmANota" onclick="inseriPolicialnoQA( '{{$quadro->id}}', '{{auth()->user()->ce_unidade}}' )" class="btn btn-success" data-dismiss="modal" title="Inserir Policial no QA">Inserir no QA</button>
            </div>
        </div>
    </div>
</div>
<!---end Modal consultar pm  --->

<!-- Modal inserir pm no QA -->
<div class="modal fade" id="modalInseriPmQA" role="dialog" aria-labelledby="modalInseriPmQA" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Adicionar Policial à nota de movimentação</h4>
            </div>
            <div class="modal-body" id="modal-body-table">
                <table class="table table-bordered" id="tblConfirmaPolicial">
                    <thead>
                        <tr class="bg-primary">
                            <th>Post/Grad</th>
                            <th>Matrícula</th>
                            <th>Nome</th>
                        </tr>
                    </thead>
                    <tbody name="policialencontrado_tbody" id="policialencontrado_tbody"> </tbody>
                </table>
            </div>
            <br/>
            <div class="modal-footer">
                <button type="button" id="btnAddPmANota" name="btnAddPmANota" onclick="" class="btn btn-primary">Adicionar</button>
                <button type="button" id="canceladd" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!---end Modal inserir pm no QA --->

<!-- Modal para remover policial do quadro de acesso-->
<div class="modal fade" id="modalRemoverPolicialDoQuadro" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Remover Policial do QA</h4>
        </div>
        <div class="modal-body bg-red">
            <div id="nome">Confirmar Remoção?</div>
            <div id="nome"></div>
            <div id="matricula"></div>
        </div>
        <div class="modal-footer bg-danger">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
          <a id="urlRemoverPolicialQuadro"  class="btn btn-primary" >Sim</a>
        </div>
      </div>
    </div>
  </div>
  <!-- end Modal para remover policial do quadro de acesso-->


  <!-- Modal de histórico do QA-->
<div class="modal fade" id="modalHistorico" tabindex="-1" role="dialog" aria-labelledby="modalHistorico" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Histórico de alterações da Ficha</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dataTable" role="grid">
                        <thead>
                            <tr class="bg-primary">
                                <th>Data</th>
                                <th>Usuário</th>
                                <th>CPF</th>
                                <th>Status</th>
                                <th>Ação</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody id="historico_nota_tbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secundary center-block" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div id="spinner" class="spinner" style="left: 0;right: 0;top: 0;bottom: 0;font-size: 30px;position: fixed;background: rgba(0,0,0,0.6);width: 100%;height: 100% !important;z-index: 1050; display:none;" >
    <div style="top: 46%; left: 45%; position: absolute; color:white;">CARREGANDO...</div>
</div>



    <!-- modal adicionar PM em LOTE -->
    <div class="modal fade" id="modalAdicionaPmEmLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Importar policiais para o QA em lote</h4>
                </div>
                <div class="modal-body">
                    <!--
                    <div class="form-group">
                        <label for="st_efetivo">Digite as matrículas dos policiais sem usar pontos ou hífens e todas devem ser separadas por vírgula.</label>
                        <textarea class='form-control' placeholder='Exemplo: 123456, 234567, 568794' id="st_efetivo" name="st_efetivo" cols="30" rows="5" required></textarea>
                        <label for="cp_personalizado">Campo personalizado para todos os policiais:</label>
                        <input type="text" id="cp_personalizado" class="form-control" maxlength="300">
                    </div>
                    <br/>
                    
                        <button type="button" id="btnAddPmANota2" name="btnAddPmANota2" onclick="addPmEmLoteQualquerNota()"  class="btn btn-primary">Adicionar</button>
                        <button type="button" id="canceladd" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                        <hr>
                    <!-->
                    <div class="modal-footer">
                        <div style='text-align:left;background-color:lightgray;padding:10px;border-radius:5px;'>
                            <form action="{{ route('addPolicialAoQaEmLoteExcell') }}" role="form" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                
                                Obs: O nome da planilha deve ser relacao_efetivo_do_qa.xls e a primeira coluna deve conter as matrículas na hora de fazer o upload.</p>
                                <span>
                                <br>
                               
                                    <input id='arquivo' type="file" class="form-control-file" name='arquivo' required>
                                    @if(isset($quadro))
                                    <input type="hidden" name='idQuadro' id='idQuadro'  value="{{$quadro->id}}">
                                    @endif
                                    
                                </span>
                                <br>
                                <div style='text-align: center'>
                                <button type='submit' class='btn btn-primary'>Enviar Planilha</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--Modal para editar policial-->
<div class="modal fade" id="modalEditarPolicial" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editarPolicial" action="" method="post">
                {{ csrf_field() }}
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Atualizar dados do Policial do QA de {{strftime('%B/%Y', strtotime($quadro->dt_promocao))}}</h4>
                </div>
                <div class="row">
                    <div class="modal-body">
                        <div class="form-group col-md-12">
                            <label for="st_policial">Nome</label>
                            <input type="text" class="form-control" id="input_st_policial" name="st_policial" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="st_matricula">Matrícula</label>
                            <input type="text" class="form-control" id="input_st_matricula" name="st_matricula" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="ce_graduacao">Graduação</label>
                            <select id="select_ce_graduacao" name="ce_graduacao" class="form-control" required>
                                <option value="" selected>Selecione</option>
                                @forelse($graduacoes as $g)
                                    @if ( ($g->id > 1) && ($g->id < 7) )
                                        <option value="{{$g->id}}"> {{$g->st_postograduacao}} </option>
                                    @endif
                                @empty
                                    <option>Não há graduação cadastrada.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="ce_qpmp">QPMP</label>
                            <select id="select_ce_qpmp" name="ce_qpmp" class="form-control" required>
                                <option value="" selected>Selecione</option>
                                @forelse($qpmps as $q)
                                @if ( $q->st_tipo == "Praça" )
                                    <option value="{{$q->id}}"> {{$q->st_qpmp}} </option>
                                @endif
                                @empty
                                    <option>Não há QPMP cadastrado.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="st_numpraca">Nº Praça</label>
                            <input type="text" class="form-control" id="input_st_numpraca" name="st_numpraca" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="dt_nascimento">Data de Nascimento</label>
                            <input type="date" class="form-control" id="input_dt_nascimento" name="dt_nascimento" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="ce_unidade">Unidade</label>
                            <select id="select_ce_unidade" name="ce_unidade" class="form-control select2" style="width: 100%;" required>
                                <option value="" selected>Selecione</option>
                                @forelse($unidades as $u)
                                    <option value="{{$u->id}}"> {{$u->st_nomepais}} </option>
                                @empty
                                    <option>Não há unidade cadastrada.</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="button" title="Cancelar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" title="Salva Edição do Policial" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('js')
    <script>

       

        function consultaPolicial() {

            let getUrl = window.location;
            let baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + '/'; 

            let CpfOuMatricula = document.getElementById('txtCpfMatriculaPolicial').value
            
            if( CpfOuMatricula == '' ) {
                alert('Informar o CPF ou Matrícula do Policial');
            } else {
                $('#policialencontrado_tbody').remove();
                //iniciando a requisição para a api rest para consultar o policial
                $.ajax({
                    //Enviando via ajax
                    url : baseUrl + "promocao/consultarpolicial/" + CpfOuMatricula,
                    method: 'get',
                    beforeSend: function () {
                        //adiciona o loader
                        $("#loader").html("<span id='div-loader'> <img src='{{ asset('imgs/carregando.gif') }}' width=30><span><b> Carregando... </b></span> </span>");
                    },
                }).done(function(data){
                    $('#div-loader').remove();
                    console.log(data)
                    if(!data.retorno){
                        //popula a tabela com os dados do policial localizado.
                        $('#idPolicial').val(data.id);
                        $('#unidadePolicial').val(data.ce_unidade);
                        $('#policialencontrado_tbody').remove();
                        $('#tblConfirmaPolicial').append( "<tbody name='idPolicial' id='policialencontrado_tbody'></tbody>");
                        $('#policialencontrado_tbody').append(
                            "<tr id="+data.id+">"+
                                "<td>"+data.st_postograduacaosigla+"</td>"+
                                "<td>"+data.st_matricula+"</td>"+
                                "<td>"+data.st_nome+"</td>"+
                            "</tr>"
                        );
                    }else{
                        alert(data.msg);
                    }
                }).fail(function () {
                    $('#div-loader').remove();
                    alert('falha ao consultar policial!');
                });
            }
        }

        function inseriPolicialnoQA( idQuadro, unidadePmLogado ) {

            let getUrl = window.location;
            let baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + '/'; 

            let idPolicial = $('#idPolicial').val() 
            let unidadePolicial = $('#unidadePolicial').val() 

            if (unidadePolicial == unidadePmLogado) {
                $.ajax({
                    //Enviando via ajax
                    url : baseUrl + "promocao/inserirpolicial/qa/" + idQuadro + "/" + idPolicial,
                    method: 'get',
                    beforeSend: function () {
                        //adiciona o loader
                        $("#loader").html("<span id='div-loader'> <img src='{{ asset('imgs/carregando.gif') }}' width=30><span><b> Carregando... </b></span> </span>");
                    },
                }).done(function(data){
                    $('#div-loader').remove();
                    if(data.retorno == 'sucesso'){
                        alert(data.msg);
                        document.location.reload(true);
                    }else{
                        alert(data.msg);
                    }
                }).fail(function () {
                    $('#div-loader').remove();
                    alert('falha na requisição!');
                });

                $('#txtCpfMatriculaPolicial').val('')
                $('#policialencontrado_tbody').remove();
                $('#tblConfirmaPolicial').append( "<tbody name='idPolicial' id='policialencontrado_tbody'></tbody>");
            } else {
                alert('Não é possível inserir policial de outra unidade no QA!')
            }
            
            
        }

        //adiciona o href dinamico para o modal de comfirmação de remoção de policial do
        function populaModalConfRemoverPolicialQuadro(idPolicial, idQuadroAcesso, idAtividade, competencia){
            $("#urlRemoverPolicialQuadro").attr("href", "{{ url('promocao/removerpolicialdoqa')}}/"+idPolicial+"/"+idQuadroAcesso+'/'+idAtividade+'/competencia/'+competencia);
        }

        function buscaHistoricoNotas(idQuadro, idPolicial){
            
            //Limpa o modal da consulta anterior
            $('#historico_nota_tbody').html("");

            var getUrl = window.location;
            var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            baseUrl += "/";
           
            $.ajax({
                url : baseUrl + "promocao/historico/quadrosacessos/" + idQuadro + "/" + idPolicial,
                type : 'get'
            }).done(function(historicos){
                
                if (historicos.retorno) {
                    alert(historicos.msg)

                } else if (historicos.lenght == 0) {
                    alert('Nenhum histórico encontrado!')

                } else {
                    $('#modalHistorico').modal('show');
                        for (var i = 0; i < historicos.length; i++){

                            if (historicos[i].st_obs == null){
                                var observacoes = "";
                            }else{
                                var observacoes = historicos[i].st_obs;
                            }
                                      
                            $('#historico_nota_tbody').append(
                                "<tr>"+ //Formata a data para dd/mm/yyyy hh:mm:ss
                                "<td>"+moment(historicos[i].dt_cadastro).format('DD/MM/YYYY HH:mm:ss')+"</td>"+
                                "<td>"+historicos[i].st_policialacao+"</td>"+
                                "<td>"+historicos[i].st_cpfpolicialacao+"</td>"+
                                "<td>"+historicos[i].st_status+"</td>"+
                                "<td>"+historicos[i].st_acao+"</td>"+
                                "<td>"+observacoes+"</td>"+
                                "</tr>");
                            
                        }
                }
                    
            }).fail(function(jgXHR, textStatus, historicos){
                alert('Falha na requisição do histórico!')
            })
            
        }

        function editarPolicial(nome, matricula, ce_graduacao, ce_qpmp, numPraca, nascimento, ce_unidade, idPolicial, idQa) {
            
            $('#input_st_policial').val(nome)
            $('#input_st_matricula').val(matricula)
            $('#select_ce_graduacao').val(ce_graduacao)
            $('#select_ce_qpmp').val(ce_qpmp)
            $('#input_st_numpraca').val(numPraca)
            $('#input_dt_nascimento').val(nascimento)
            $('#select_ce_unidade').val(ce_unidade).select2()

            $('#editarPolicial').attr('action', "{{url('promocao/editarpolicial')}}/" + idPolicial + '/qa/' + idQa + '/nao_enviada')

            $('#modalEditarPolicial').modal('show');
        }

    </script>
@endsection