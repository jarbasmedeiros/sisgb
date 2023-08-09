@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Publicações')
@section('tabcontent')

    <div class="tab-pane active" id="cursos">
        <h4 class="tab-title">Comportamento - {{ $policial->st_nome}}</h4>
        <hr class="separador">
    </div>
  
    <div class="container-fluid">
        <div class="row">
        <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="5">Comportamento</th>
                            <th>
                                @can('Edita')
                                    <a class="btn btn-primary" href='{{url("rh/policiais/" . $policial->id ."/cadastra/comportamento")}}' title="Cadastrar Comportamento"> Cadastrar Comportamento</a>
                                @endcan
                            </th>
                        </tr>
                        <tr>
                            <th class="col-md-2">Comportamento</th>
                            <th class="col-md-2">Data do boletim</th>
                            <th class="col-md-2">Boletim</th>
                            <th class="col-md-2">Motivo</th>
                            <th class="col-md-2">Observação</th>
                            <th class="col-md-2">Ações</th>
                        </tr>
                    </thead>
                 
                    <tr>
                    @if(isset($comportamento))
                        @forelse($comportamento as $m)
                        <tr>
                            <td>{{$m->st_comportamento}}</td>
                            <td>{{\Carbon\Carbon::parse($m->dt_boletim)->format('d/m/Y')}}</td>
                            <td>{{$m->st_boletim}}</td>
                            <td>{{$m->st_motivo}}</td>
                            <td>{{$m->st_obs}}</td>
                            <td>
                                @can('Edita')
                                    <a class="btn btn-warning fa fa-pencil" href="{{url('rh/policiais/edita/'. $policial->id.'/comportamento/'.$m->id)}}" title="Editar"></a>
                                    |
                                    <a onclick="modalDesativa({{$m->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger fa fa-trash"></a>        
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">Nenhum comportamento encontrado.</td>
                        </tr>
                        @endforelse
                    @endif
                  
            <!-- Moldal Excluir Comportamento -->

           <div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Excluir Comportamento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form-inline" id="modalDesativa" method="post">
                         {{csrf_field()}}
                            <div class="modal-body bg-danger">
                                <h4 class="modal-title" id="exampleModalLabel">
                                <b>Motivo da Exclusão:</b>
                               <input id="st_motivo"  type="text"  required class="form-control" name="st_motivo" style="width:80%; "> 
                                </h4>
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
                function modalDesativa(id){
                    $("#modalDesativa").attr("action", "{{ url('rh/policiais/exclui/' . $policial->id . '/comportamento')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>


  </div>
    
@endsection
