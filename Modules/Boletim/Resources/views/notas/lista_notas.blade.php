@extends('boletim::boletim.template_boletim')

@section('title', 'Notas')

@section('content_dinamic')
    <div class="container-fluid">
        <div class="row align-item-start">
            <div class="panel panel-primary">
                <div class="panel-heading">Lista de Notas para Boletim</div>
                <div class="panel-body">

                <div class="row">
                    <a href='{{url("boletim/nota/create/1")}}' class="btn btn-primary" style="float:right; margin-bottom:10px; margin-right:15px;"> <i class="fa fa-plus"></i> Nova Nota</a>
                </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Data</th>
                                    <th>Origem</th>
                                    <th>Situação</th>
                                    <th class='col-md-3'>Assunto</th>
                                   
                                    <th class='col-md-2'>Tipo de Nota</th>
                                    <th class='col-md-1'>Status</th>
                                    <th>N° da Nota</th>
                                    <th class='col-md-2'>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($notas) && count($notas)>0)
                                    
                                    @foreach($notas as $nota)
                                        <tr>
                                      
                                            <td>{{date('d/m/Y', strtotime($nota->dt_cadastro))}}</td>
                                            <td>{{$nota->st_unidade}}</td>
                                            <td>{{(empty($nota->ce_unidadetramitada)? 'Local': 'Tramitada')}}</td>
                                            <td style="text-align:justify;">{{$nota->st_assunto}}</td>
                                           
                                            <td style="text-align:justify;">{{$nota->st_tipo}}</td>
                                            <td>{{$nota->st_status}}</td>
                                            <td>{{$nota->nu_sequencial}}/{{$nota->nu_ano}}</td>
                                            <td>
                                                <a href="{{url('boletim/nota/edit/'.$nota->id.'/'.$nota->ce_tipo)}}"  class='btn btn-primary fa fa fa-eye' title='Abrir'></a> |
                                                <button onclick="buscaHistoricoNotas({{$nota->id}})" class='btn btn-success fa fa-list' data-toggle="modal" data-target="#modalHistorico" title='Histórico'></button>
                                             
                                                @if($nota->st_status == 'RASCUNHO')
                                                | <button onclick="modalExcluiNota({{$nota->id}})" data-toggle="tooltip" data-placement="top" title='Excluir Nota' class="btn btn-danger fo fa fa-trash"></button>
                                                @endif
                                             
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                @else
                                    <tr>
                                        <th colspan="6">Nenhuma nota encontrada</th>
                                    </tr>

                                @endif
                            </tbody>
                        </table>
                                    
                    </div>
                    @if(isset($notas) && count($notas)>0)
                                    <div class="pagination pagination-centered">
                                      <tr>
                                        <th>
                                            {{$notas->links()}}
                                        </th>
                                      </tr>
                                    </div>
                    @endif
                </div>
                
            </div>
            
        </div>
      
    </div>
    
    <!-- Modal para excluir a nota-->
    <div class="modal fade-lg" id="exclui_nota" tabindex="-1" role="dialog" aria-labelledby="exclui_nota" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Excluir Nota</h4>
                </div>
                <div class="modal-body bg-danger">
                    <form class="form-horizontal" id="form_exclui_nota" method="post" action="{{url('boletim/nota/exclui')}}"> 
                        <h4 class="modal-title">
                            <strong>DESEJA REALMENTE EXCLUIR A NOTA?</strong>
                            <div>
                                <textarea style="border-radius: 5px;" name="st_obs" class="form-control" placeholder="Informe aqui a justificativa para excluir a nota." id="st_obs" rows="3"></textarea>
                            </div>
                        <div class="modal-footer">
                        
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                            <input type="hidden" id="idNota" name="idNota" value="">
                            <input type="hidden" name="_token" value="{{Session::token()}}">
                            <button type="submit" id="btnExcluir" class="btn btn-danger">Excluir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de histórico da nota-->
    
    <div class="modal fade" id="modalHistorico" tabindex="-1" role="dialog" aria-labelledby="modalHistorico" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick="off()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Histórico de alterações de Nota</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dataTable" role="grid">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Data</th>
                                    <th>Usuário</th>
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
                    <button type="button" class="btn btn-secundary center-block" data-dismiss="modal" onclick="off()">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="spinner" class="spinner" style="left: 0;right: 0;top: 0;bottom: 0;font-size: 30px;position: fixed;background: rgba(0,0,0,0.6);width: 100%;height: 100% !important;z-index: 1050; display:none;" >
        <div style="top: 46%; left: 45%; position: absolute; color:white;">CARREGANDO...</div>
    </div>


@stop