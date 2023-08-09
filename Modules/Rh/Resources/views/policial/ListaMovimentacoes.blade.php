@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Movimentações')
@section('tabcontent')
<div class="tab-pane active" id="publicacoes">
    <h4 class="tab-title">Movimentações - {{ $policial->st_nome}}</h4>
    <hr class="separador">
    {{ csrf_field() }}
        <div class="row">
        <div class="content">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="5">Movimentações</th>
                            <th>
                                <div class="col-md-1">
                                    <form id="novaMovimentacao" class="form-horizontal" role="form" method="GET" action='{{url("rh/policiais/".$policial->id."/movimentacao/create")}}'>
                                        @can('Edita')
                                            <button type="submit" class="btn btn-primary btn-xs" title="Adicionar Nova Movimentação">Nova Movimentação</button>                                                                                        
                                        @endcan
                                    </form>
                                </div>                                
                            </th>
                        </tr>
                        <tr>
                            <th class="col-md-2">DE</th>
                            <th class="col-md-2">PARA</th>
                            <th class="col-md-2">A CONTAR DE</th>
                            <th class="col-md-2">POBLICAÇÃO</th>
                            <th class="col-md-2">DATA DA PUBLICAÇÃO</th>
                            @can('Edita')
                                <th class="col-md-2">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($movimentacoes))
                            @forelse($movimentacoes as $m)
                                <tr>
                                    <th>{{$m->st_unidadeorigem}}</th>
                                    <th>{{$m->st_unidadeDestindo}}</th>
                                    <th>{{\Carbon\Carbon::parse($m->dt_movimentacao)->format('d/m/Y')}}</th>
                                    <th>{{$m->st_publicacao}}</th>
                                    <th>{{\Carbon\Carbon::parse($m->dt_publicacao)->format('d/m/Y')}}</th>
                                    <th>
                                        @can('Edita')
                                            <a class="btn btn-warning btn-xs fa fa fa-pencil-square" href='{{url("rh/policiais/".$policial->id."/movimentacao/".$m->id)}}' title="Editar Movimentação"></a> | 
                                        @endcan
                                        @can('Deleta')
                                            <a onclick="modalDesativa({{$m->id}}, {{$policial->id}})" data-toggle="modal" data-placement="top" title="Deletar Movimentação" class="btn btn-danger btn-xs fa fa fa-trash"></a> 
                                        @endcan  
                                    </th>
                                </tr>
                               
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center;">Nenhuma Movimentação Encontrada.</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div> 
        <a href='{{url("/")}}' class="btn btn-warning">
            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
        </a>  
</div>




<!-- Modal Excluir curso -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Movimentação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR A MOVIMENTAÇÃO?</b>
                </h4>
                <form class="form-inline" id="modalDesativa" method="get" > {{csrf_field()}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Excluir</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function modalDesativa(idMovimentacao, idpolicial){
        var url = idpolicial+'/movimentacao/'+idMovimentacao+'/deleta';                      
        $("#modalDesativa").attr("action", "{{ url('rh/policiais/')}}/"+url);
        $('#Modal').modal();        
    };
</script>




@endsection