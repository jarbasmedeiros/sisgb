@extends('promocao::abas')
@section('title', 'Escriturar Ficha')
@php
    use app\utis\Funcoes;
@endphp

@section('css')
<style>
    th, td { text-align: center; }
</style>
@endsection

@section('tabcontent')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div class="col-md-10">
                    <h4>Fichas de reconhecimento <b> enviadas </b></h4>
                </div>
                <div class="col-md-2">{{(isset($nota)) ? 'SITUAÇÃO: '.$nota->st_status : ''}}</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12" id="alertSucesso"></div>
                    <div class="form-row form-inline col-md-5 col-md-offset-3">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Localizar Policial no QA</legend>
                            <form method="post" action="{{url('promocao/fichasgtenviada/buscasgt/'.$quadro->id.'/'.$atividade->id.'/1/competencia/'.$competencia)}}">
                                {{csrf_field()}}
                                <div class="form-group col-xs-12 col-md-12 col-sm-12" style="margin-left:auto; margin:10px;">
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
                                <th>Status</th>
                                <th>Recurso</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($policiaisQuadro) && count($policiaisQuadro) > 0)
                                @php
                                    $ordem = 0;
                                @endphp
                                @foreach($policiaisQuadro as $policial)
                                    @if(!empty($policial->bo_fichaenviada))
                                        @php
                                            $ordem++
                                        @endphp
                                        <tr>
                                            <td>{{$ordem}}</td>
                                            <td>{{$policial->st_postgrad}}</td>
                                            <td>{{$policial->st_numpraca}}</td>
                                            <td>{{$policial->st_matricula}}</td>
                                            <td>{{$policial->st_policial}}</td>
                                            <td>
                                                @if ($policial->bo_fichahomologada)
                                                    Homologada
                                                @else
                                                    Não Homologada
                                                @endif
                                            </td>
                                            <td>
                                                @if ($policial->bo_recorreu)
                                                    Recorreu
                                                @else
                                                    Não Recorreu
                                                @endif
                                            </td>
                                            <td class="text-left">
                               
                                                <a href="{{url('promocao/fichas/visualizarenviadas/'.$quadro->id.'/'.$atividade->id.'/'.$policial->ce_policial.'/competencia/'.$competencia)}}" title="Visualizar Fichas de Reconhecimento" class="btn btn-sm btn-primary">
                                                    <span class="fa fa fa-eye"></span>
                                                </a>
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
                                                @if ($quadro->st_status === "ABERTO")
                                                    @can('ESCRITURAR_FICHA_RECONHECIMENTO_RECURSO')
                                                        @if ( $policial->bo_recorreu && $quadro->bo_recursoliberado &&  !$policial->bo_recursoenviado)
                                                            <a href="{{url('promocao/escriturarfichadereconhecimento/'.$quadro->id.'/'.$atividade->id.'/'.$policial->ce_policial.'/competencia/'.$competencia)}}" class='btn btn-sm btn-warning ' title="Retificar ficha">
                                                                Retificar ficha
                                                            </a>
                                                        @endif
                                                    @endcan
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
            {{-- <a href="{{url('promocao/quadro/cronograma/'.$quadro->id.'/competencia/'.$competencia)}}" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a> --}}
            <a href="{{url('promocao/listadequadrodeacesso/competencia/'.$competencia)}}" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>
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

            $('#editarPolicial').attr('action', "{{url('promocao/editarpolicial')}}/" + idPolicial + '/qa/' + idQa + '/enviada')

            $('#modalEditarPolicial').modal('show');
        }

</script>
@endsection