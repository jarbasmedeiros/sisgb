@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Publicações')
@section('tabcontent')
<div class="tab-pane active" id="publicacoes">
    <h4 class="tab-title">Publicações - {{ $policial->st_nome}}</h4>
    <hr class="separador">
    {{ csrf_field() }}
        <div class="row">
        <div class="content">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="3">Publicações</th>
                            <th>
                                <div class="col-md-1">
                                    <form id="novaPublicacao" class="form-horizontal" role="form" method="GET" action='{{url("rh/policiais/".$policial->id."/publicacoes/create")}}'>
                                        @can('Edita')
                                            <button type="submit" class="btn btn-primary " title="Adicionar Nova Publicação">Nova Publicação</button>                                                                                        
                                        @endcan
                                    </form>
                                </div>                                
                            </th> 
                        </tr>
                        <tr>
                            <th class="col-md-2">ASSUNTO</th>
                            <th class="col-md-2">PUBLICAÇÃO</th>
                            <th class="col-md-2">DATA DA PUBLICAÇÃO</th>
                           <!--  <th class="col-md-2">COMPORTAMENTO</th>-->
                            @can('Edita')
                                <th class="col-md-2">AÇÕES</th>
                            @endcan 
                        </tr>
                    </thead>
                    <tbody>          
                        @if(isset($publicacoes))
                            @forelse($publicacoes as $p)                                
                                @if($p->bo_reservado == null)
                                    <tr>
                                        <td>{{$p->st_assunto}}</td>
                                        <td>{{$p->st_boletim}}</td>
                                        <td>{{\Carbon\Carbon::parse($p->dt_publicacao)->format('d/m/Y')}}</td>
                                    <!--  <th>{{$p->st_comportamento}}</th> -->
                                        <th>
                                            
                                            @if(!empty($p->ce_nota))
                                                <a class="btn btn-success fa fa fa-file-pdf-o" href='{{url("boletim/nota/visualizar/".$p->ce_nota)}}'  target="_blank" title="Publicação"></a>  
                                            @else
                                                @can('Edita')
                                                    <a class="btn btn-warning  fa fa fa-pencil-square" href='{{url("rh/policiais/".$policial->id."/publicacao/".$p->id)}}' title="Editar Publicação"></a> | 
                                                @endcan
                                                @can('Edita')
                                                    <a onclick="modalDesativa({{$p->id}}, {{$policial->id}})" data-toggle="modal" data-placement="top" title="Deletar Publicação" class="btn btn-danger  fa fa fa-trash"></a> 
                                                @endcan 
                                            @endif 
                                        
                                        </th>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center;">Nenhuma Publicação Encontrada.</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div> 
          
</div>




<!-- Modal Excluir curso -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Publicação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR A PUBLICAÇÃO?</b>
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
    function modalDesativa(idPublicacao, idpolicial){
        var url = idpolicial+'/publicacao/'+idPublicacao+'/deleta';                      
        $("#modalDesativa").attr("action", "{{ url('rh/policiais/')}}/"+url);
        $('#Modal').modal();        
    };
</script>




@endsection