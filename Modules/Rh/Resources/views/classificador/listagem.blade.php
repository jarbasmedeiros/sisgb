@extends('adminlte::page')

@section('title', 'Classificador')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
<style>

    th, td {
        text-align: center;
    }
    
</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <fieldset class="scheduler-border">
        <div class="panel panel-primary">
            @if (isset($efetivo))
                <legend class="scheduler-border">{{count($efetivo)}} policiais ordenados pela antiguidade</legend>
            @else
                <legend class="scheduler-border">Policiais importados</legend>
            @endif
              
                <div class="form-group col-md-4">
                    <label for="ce_graduacao" class="control-label">Selecione o Post/Grad  desejado para listar</label>
                    <select id="ce_graduacao" name="ce_graduacao"  class="form-control select" style="width: 100%;" required>
                        <option value="" >--Selecione--</option>
                        <optgroup label="Oficiais">
                            @php
                                if (isset($_GET['grad'])) {
                                    $idGraduacao = $_GET['grad'];
                                } else {
                                    $idGraduacao = 15;
                                }
                            @endphp
                            <option {{$idGraduacao == 15 ? 'selected' : ''}} value="15">Coronel</option>
                            <option {{$idGraduacao == 14 ? 'selected' : ''}} value="14">Tenente Coronel</option>
                            <option {{$idGraduacao == 13 ? 'selected' : ''}} value="13">Major</option>
                            <option {{$idGraduacao == 12 ? 'selected' : ''}} value="12">Capitão</option>
                            <option {{$idGraduacao == 11 ? 'selected' : ''}} value="11">1ºTenente</option>
                            <option {{$idGraduacao == 10 ? 'selected' : ''}} value="10">2ºTenente</option>
                            <option {{$idGraduacao == 9 ? 'selected' : ''}} value="9">Aspirante</option>
                        </option>                       
                        <optgroup label="Praças">                       
                            <option {{$idGraduacao == 8 ? 'selected' : ''}} value="8">Aluno Oficial</option>
                            <option {{$idGraduacao == 7 ? 'selected' : ''}} value="7">Sub Tenente</option>
                            <option {{$idGraduacao == 6 ? 'selected' : ''}} value="6">1ºSargento</option>
                            <option {{$idGraduacao == 5 ? 'selected' : ''}} value="5">2ºSargento</option>
                            <option {{$idGraduacao == 4 ? 'selected' : ''}} value="4">3ºSargento</option>
                            <option {{$idGraduacao == 3 ? 'selected' : ''}} value="3">Cabo</option>
                            <option {{$idGraduacao == 2 ? 'selected' : ''}} value="2">Soldado</option>
                            <option {{$idGraduacao == 1 ? 'selected' : ''}} value="1">Aluno Soldado</option>
                        </optgroup>
                    </select>
                </div>
                @can('ATUALIZAR_ANTIGUIDADE')
                <div class="form-group col-md-8">
                    <div style="text-align:right;">
                        <br>
                        <button type="button" class='btn btn-md btn-success' data-toggle="modal" data-target="#modalMudarAntiguidade">Modificar Antiguidade</button>
                    </div>
                </div>
                @endcan
                <div class="col-md-12">
                    <table id="tabela" class="table table-bordered table-striped">
                        <thead>
                            <tr class="bg-primary">
                               
                                <th class="col-md-1">Quadro</th>
                                <th class="col-md-1">Post/Grad</th>
                                <th class="col-md-4">Nome</th>
                                <th class="col-md-1">Matrícula</th>
                                <th class="col-md-1">Antiguidade Post/Grad</th>
                                <th class="col-md-1">Antiguidade Geral</th>
                                <th class="col-md-1">Situação</th>
                                @can('ATUALIZAR_ANTIGUIDADE')
                                    <th class="col-md-2">Ações</th> 
                                @endcan
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($efetivo))
                                @forelse ($efetivo as $key => $e)
                                    <tr>
                                        <td>{{ $e->st_qpmp }}</td>
                                        <td>{{ $e->st_postograduacaosigla }}</td>
                                        <td class="text-left">{{ $e->st_nome }}</td>
                                        <td>{{ $e->st_matricula }}</td>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $e->nu_antiguidade }}</td>
                                        <td class="text-left">{{ $e->st_situacao }}</td>
                                        @can('ATUALIZAR_ANTIGUIDADE')      
                                            <td>
                                            <a href="{{url('/rh/classificador/ordenar/s/'.$e->id.'?grad='.$idGraduacao)}}" 
                                                class='btn btn-primary fa fa fa-plus-square' title='Subir'></a> 
                                            <a href="{{url('/rh/classificador/ordenar/d/'.$e->id.'?grad='.$idGraduacao)}}" 
                                                class='btn btn-primary fa fa fa-minus-square' title='Descer'></a> 
                                            </td>     
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"><strong> Nenhum Policial relacionado. </strong></td>
                                    </tr>
                                @endforelse  
                            @endif
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
        </div>
    </fieldset>
    </div>
</div>

@can('Admin')
<!-- modal adicionar PM em LOTE -->
<div class="modal fade" id="modalMudarAntiguidade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Adicionar Nova Antiguidade</h4>
            </div>
            <div class="modal-body">
                <div class="modal-footer">
                    <div style='text-align:left;background-color:lightgray;padding:10px;border-radius:5px;'>
                        <form action="{{ route('addNovaClassificacao') }}" role="form" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                            <p><strong>Faça o upload da planilha padrão (Excel): anexando-a e clicando em "Enviar Planilha".</strong>
                            <br>
                            Obs: O nome da planilha não pode ser alterado do original na hora de fazer o upload.</p>
                            <span>
                            <br>
                            <label for='arquivo'><a target="_blank" href='{{ url("planilhas/padrao/planilha_classificador_antiguidade.xlsx")}}'><i class="fa fa-save"></i> (Download da planilha padrão)</a></label>
                                <input id='arquivo' type="file" class="form-control-file" name='arquivo' required>
                            </span>
                            <input type="hidden" name="ce_graduacao" value="@php echo $idGraduacao @endphp">
                            <br>
                            <div style='text-align: center'>
                            <button type='submit' class='btn btn-primary'>Enviar Planilha</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan



@stop


@section('css')

 
@stop

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
    
    $('#tabela').DataTable( {
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
            "sSearch": "Procurar",
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
            "buttons": {
                "pageLength": {
                    _: "Exibe %d Linhas",
                    '-1': "Exibe Todos os Policiais"
                }
            }
        },
    } );

    $('#ce_graduacao').change(function(){
        //recupera a graduação selecionada
            var idGrad = $(this).val();
            //recupera o path
            var pathname = window.location.pathname; 
            //monta a url 
            var url = pathname+"?grad="+idGrad;
            //redireciona
            window.location.href = url;
    }) ;
   
    
} );

    
    </script>

 


@stop
 