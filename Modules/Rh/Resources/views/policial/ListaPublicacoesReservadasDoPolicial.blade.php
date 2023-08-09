@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Publicações Reservadas')
@section('tabcontent')



<div class="tab-pane active" id="publicacoes_reservadas">
    <h4 class="tab-title">Publicações Reservadas - {{ $policial->st_nome }}</h4>
    <hr class="separador">
    {{ csrf_field() }}
        <div class="row">
        <div class="content">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="4">Publicações Reservadas</th>
                            <!-- <th>
                                <div class="col-md-1">
                                    <form id="novaPublicacao" class="form-horizontal" role="form" method="GET" action='{{url("rh/policiais/".$policial->id."/publicacoes/create")}}'>
                                        @can('Edita')
                                            <button type="submit" class="btn btn-primary btn-xs" title="Adicionar Nova Publicação">Nova Publicação</button>                                                                                        
                                        @endcan
                                    </form>
                                </div>                                
                            </th> -->
                        </tr>
                        <tr>
                            <th class="col-md-9">ASSUNTO</th>
                            <th class="col-md-1">PUBLICAÇÃO</th>
                            <th class="col-md-1">DATA DA PUBLICAÇÃO</th>
                            <th class="col-md-1">AÇÕES</th>
                           <!--  <th class="col-md-2">COMPORTAMENTO</th>
                            @can('Edita')
                                <th class="col-md-2">AÇÕES</th>
                            @endcan -->
                        </tr>
                    </thead>
                    <tbody>
                    
                        @if(isset($publicacoes))
                            {{-- @php $i=0; @endphp (ESCOLHER PUBLICAÇÃO QUE SERÁ MOSTRADA)--}}
                            @forelse($publicacoes as $p)                                                            
                                @if($p->bo_reservado == 1)
                                    {{-- @if($i != 2 )  (ESCOLHER PUBLICAÇÃO QUE SERÁ MOSTRADA)--}}
                                        <tr>
                                            <td>{{$p->st_assunto}}</td>
                                            <td>{{$p->st_boletim}}</td>
                                            <td>{{\Carbon\Carbon::parse($p->dt_publicacao)->format('d/m/Y')}}</td>
                                            <td>
                                                @if(!empty($p->ce_nota))
                                                    <a class="btn btn-success fa fa fa-file-pdf-o" href='{{url("boletim/nota/visualizar/".$p->ce_nota)}}'  target="_blank" title="Publicação"></a>  
                                                @endif
                                            </td>
                                        <!--  <th>{{$p->st_comportamento}}</th>
                                            <th>
                                                @can('Edita')
                                                    <a class="btn btn-warning btn-xs fa fa fa-pencil-square" href='{{url("rh/policiais/".$policial->id."/publicacao/".$p->id)}}' title="Editar Publicação"></a> | 
                                                @endcan
                                                @can('Deleta')
                                                    <a onclick="modalDesativa({{$p->id}}, {{$policial->id}})" data-toggle="modal" data-placement="top" title="Deletar Publicação" class="btn btn-danger btn-xs fa fa fa-trash"></a> 
                                                @endcan  
                                            </th> -->
                                        </tr>
                                    {{--@endif (ESCOLHER PUBLICAÇÃO QUE SERÁ MOSTRADA) --}}
                                    {{-- @php $i++; @endphp (ESCOLHER PUBLICAÇÃO QUE SERÁ MOSTRADA) --}}
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
        
        <!-- Botão de voltar NOVO -->
        <form action="{{url("rh/policiais/buscar")}}" method="post">
            {{csrf_field()}}            
            <input type="hidden" name="busca" id="busca" class="form-control" placeholder="Buscar policial" value={{$policial->st_matricula}}>                    
            <button type="submit" id="search-btn" class="btn btn-warning">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </button>                                  
        </form>
        
        <!-- BOTAO DE VOLTAR ANTIGO
        <a href='{{url("/")}}' class="btn btn-warning">
            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
        </a> -->  
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