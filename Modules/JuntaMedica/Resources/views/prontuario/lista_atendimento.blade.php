@extends('adminlte::page')
@section('title', 'Atendimentos abertos')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">LISTA COM {{count($atendimentos)}} ATENDIMENTO(S) PENDENTE(S)</div>
            <div class="panel-body">
                        
            @if(isset($atendimentos))
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-1">Nº</th>
                        <th class="col-md-1">Post/Grad</th>
                        <th class="col-md-3">Nome</th>
                        <th class="col-md-1">Matrícula</th>
                        <th class="col-md-2">Unidade</th>
                        <th class="col-md-1">Orgão</th>
                        <th class="col-md-2">Sessão</th>
                        @can('JPMS')
                        <th class="col-md-1">AÇÕES</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @if(isset($atendimentos))
                        @if(empty($atendimentos))        
                            <tr>
                                <th colspan="7">Nenhum resultado encontrado</th>
                            </tr>
                        @else
                            @php $cont = 0; 
                            @endphp
                            @foreach($atendimentos as $p)
                            <tr>
                                <td>{{++$cont}}</td>
                                <td>{{$p->st_postograduacao}}</td>
                                <td class="text-left">{{$p->st_nome}}</td>  
                                <td>{{$p->st_matricula}}</td>
                                <td>{{$p->st_unidade}}</td>
                                <td>{{$p->st_orgao}}</td>
                                <td>{{$p->st_tipo}}</td>
                                @can('JPMS')
                                <td>
                                    <a class="btn btn-primary"  title="Concluir atendimento" href="{{url('/juntamedica/atendimento/editar/'.$p->id)}}"> 
                                    <i class="fa fa-user-md"></i></a>
                                    <!--
                                    <a onclick="modalExcluirAtendimento({{$p->id}})" class="btn btn-danger"
                                        data-toggle="tooltip" data-placement="top" title="Excluir atendimento">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                    
                                    

                                <td class="text-left"><a class="btn btn-primary"  title="Concluir atendimento" href="{{url('/juntamedica/atendimento/editar/'.$p->id)}}"> 
                                <i class="fa fa-user-md"></i></a>
                                -->
                                @empty($p->st_parecer)
                                
                                <a onclick="modalExcluirAtendimento({{$p->id}})" class="btn btn-danger"
                                    data-toggle="tooltip" data-placement="top" title="Excluir atendimento">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>

                                @endempty
                                </td>
                                @endcan
                            </tr>
                            @endforeach        
                        @endif
                    @endif
                </tbody>
            </table>
            </div>
            @endif          
                    <!--fim do bloco que só exibe quando o existir um pm selecionado-->
            <!---->
        </div>
        <div class="modal fade" id="modalExluirAtendimento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>

                    </div>
                    <div class="modal-body">
                        Deseja realmente excluir o atendimento?
                    </div>
                    <div class="modal-footer">
                        <form class="form-horizontal" id="form_excluir_atendimento" role="form" method="post">
                            {{ csrf_field() }}
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
    <script>
        function modalExcluirAtendimento(idAtendimento) {
            $("#form_excluir_atendimento").attr("action", "{{ url('juntamedica/atendimento/excluir') }}/" + idAtendimento);
            //alert({{ url('juntamedica/atendimento/excluir/') }});
            $('#modalExluirAtendimento').modal();
        };
    </script>
@endsection
@section('css')
    <style>
        th, td, input{text-align: center;}
        .foot{text-align: right;}
    </style>
@stop
