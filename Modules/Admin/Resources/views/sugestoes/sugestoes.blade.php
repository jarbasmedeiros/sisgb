@extends('adminlte::page')

@section('title', 'Sugestões')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">

<style>
    th, td {
        text-align: center;
    }
    .m-10 {
        margin: 10px 10px 0px 10px;
    }
    .float-right {
        float: right;
    }
    .border{
        border: solid 1px rgba(19, 110, 247, 0.945);
    }
</style>
@endsection
    
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">Lista de sugestões</div>
            <div class="row">
                <div class="col-md-10 ">
                    <p class="m-10"> 
                        Registre sua sugestão ou vote em alguma já cadastrada. 
                        Iremos selecionar aquelas sugestões mais votadas (com maior quantidade de likes) para implementarmos nas próximas releases.
                    </p>
                </div>
                <div class="col-md-2">
                    <button type="button" data-toggle="modal" data-target="#addSugestaoModal" class="btn btn-primary m-10 float-right"> <i class="fa fa-plus"></i> 
                        Nova Sugestão
                    </button>
                </div>
            </div>
            <hr>
            <div class="panel-body">
                <table class="table table-bordered" id=sugestoesTable>
                    <thead>
                        <tr class="bg-primary">
                            <th class="col-md-1">Ordem</th>
                            <th class="col-md-7">Sugestão</th>
                            <th class="col-md-1">Data</th>
                            <th class="col-md-1">Status</th>
                            <th class="col-md-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($sugestoes))
                            @forelse ($sugestoes as $key => $s)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td class="text-left">{{ $s->st_sugestao }}</td>
                                    <td>{{ date('d/m/Y', strtotime($s->dt_cadastro)) }}</td>
                                    <td>{{ $s->st_status }}</td>
                                    <td>
                                        @if ($s->st_status == 'Sugerido')
                                            <a href="{{ route('votarSugestao', ['idSugestao' => $s->id, 'voto' => 'l']) }}" class="btn btn-success fa fa-thumbs-o-up" title="Gostei"> <b>{{ $s->nu_like }}</b></a>
                                            <a href="{{ route('votarSugestao', ['idSugestao' => $s->id, 'voto' => 'd']) }}" class="btn btn-danger fa fa-thumbs-o-down" title="Não Gostei"> <b>{{ $s->nu_dislike or '0' }}</b></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Nenhuma sugestão encontrada.</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal para inserir uma nova sugestão --}}
<div class="modal fade" id="addSugestaoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Cadastrar sugestão</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form class="form-horizontal" action="{{ route('cadastraSugestao') }}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group{{ $errors->has('st_sugetao') ? ' has-error' : '' }}">
                    <label for="st_sugestao" class="col-md-2 control-label">Sugestão:</label>
                    <div class="col-md-10">
                        <input id="st_sugestao" type="text" class="form-control" required="true" placeholder="Informe a Sugestão" name="st_sugestao"> 
                        @if ($errors->has('st_sugestao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_sugestao') }}</strong>
                        </span>
                        @endif
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
        </div>
    </div>
</div>  

@endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

<script>
    $(document).ready(function() {
        $('#sugestoesTable').DataTable( {
            "ordering":  false,
            "order": [[ 1, "desc" ]],
            "lengthMenu": [[50, 100, 250, 500, -1], ['50', '100', '250', '500', "Todos"]],
            "language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ ate _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ Resultados por pagina",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Proximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Ultimo"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                },
            },
        } );
    });

</script>

@endsection