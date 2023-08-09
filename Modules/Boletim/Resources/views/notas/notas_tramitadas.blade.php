@extends('boletim::boletim.template_boletim')

@section('title', 'Notas tramitadas')

@section('content_dinamic')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Lista de Notas tramitadas</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th class='col-md-1'>Data</th>
                                <th class='col-md-3'>Assunto</th>
                                <th class='col-md-1'>Status</th>
                                <th class='col-md-3'>Origem</th>
                                <th class='col-md-1'>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($notas) && count($notas)>0)
                                @foreach($notas as $nota)
                              
                                    <tr>
                                        <td>{{date('d/m/Y', strtotime($nota->dt_cadastro))}}</td>
                                        <td>{{$nota->st_assunto}}</td>
                                        <td>{{$nota->st_status}}</td>
                                        <td>{{$nota->st_unidade}}</td>
                                        <td>
                                            <a href="{{url('boletim/nota/editdevolvernotatramitada/'. $nota->id . '/' . $nota->ce_tipo)}}" data-toggle="tooltip" class='btn btn-primary fa fa-eye' title='Abrir'></a>
                                            <button onclick="buscaHistoricoNotas({{$nota->id}})" class='btn btn-success fa fa-list' data-toggle="modal" data-target="#modalHistorico" title='Histórico'></button>
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
@section('scripts')
    <script>
        $('.accordion-toggle').click(function(){
            $(this).text(function(i,old){
                return old=='Ver mais...' ?  'Ver menos...' : 'Ver mais...';
            });
        });
    </script>
@endsection


