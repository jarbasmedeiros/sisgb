@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Medalhas')
@section('tabcontent')
<!-- Autor: @aggeu. Issue 197, crude de medalhas de um policial. -->
<div class="tab-pane active" id="dados_medalhas">
    <h4 class="tab-title">Medalhas - {{ $policial->st_nome}}</h4>
    <hr class="separador">
        {{ csrf_field() }}
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan = "3">LISTA DE MEDALHAS</th>
                        <th>
                            <a class="btn btn-primary " href="{{url('rh/policiais/'.$policial->id.'/medalha/cadastra')}}">
                                <i></i> Nova Medalha
                            </a>
                        </th>
                    </tr>
                    <tr>   
                        <th class = "col-md-3">MEDALHA</th>
                        <th class = "col-md-3">PUBLICAÇÃO</th>
                        <th class = "col-md-3">DATA DA PUBLICAÇÃO</th>
                        <th class = "col-md-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($medalha))
                        @forelse($medalha as $m)
                        <tr>
                            <td>{{$m->st_nome}}</td>
                            <td>{{$m->st_publicacao}}</td>
                            <td>{{\Carbon\Carbon::parse($m->dt_publicacao)->format('d/m/Y')}}</td>
                            <td>
                                <a class="btn btn-warning " href="{{url('rh/policiais/'.$policial->id.'/medalha/'.$m->id.'/edita')}}" title="Editar"><i class="fa fa-pencil-square"></i></a> | 
                                <a onclick="modalDesativa({{$policial->id}}, {{$m->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger "><i class="fa fa-trash"></i></a> 
                                
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Nenhuma medalha encontrada.</td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
        
</div>

<!-- Modal Excluir-->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Medalha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR A MEDALHA?</b>
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

<!-- Função JS que chama a rota para excluir medalha -->
<script>
    function modalDesativa(idPolicial, idMedalha){
        var url = idPolicial+'/medalha/'+idMedalha+'/exclui';                      
        $("#modalDesativa").attr("action", "{{ url('rh/policiais/')}}/"+url);
        $('#Modal').modal();        
    };
</script>

<!-- /.tab-pane -->
@endsection