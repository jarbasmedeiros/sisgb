@extends('adminlte::page')
@section('title', 'Plano de Férias')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="row">

            @can('PLANO_FERIAS')
            <a href="{{url('/rh/planoferias/criar')}}" button class="btn btn-primary" id="btnNovoQuadro" name="btnNovoQuadro" onclick="()" data-toggle="modal" data-target="">Novo plano de férias</a>
            @endcan
            </div>
        <div class="panel panel-primary">
            <div class="panel-heading">Plano de Férias </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th class='col-md-1'>Ano referido</th>
                                <th class='col-md-1'>Status</th>                                
                                <th class='col-md-1'>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($listas) && count($listas) > 0)
                                @foreach($listas as $r)
                                    <tr>
                                        <th>{{$r->st_ano}}</th>
                                        <th>{{$r->st_status}}</th>
                                        <th> 
                                            @can('PLANO_FERIAS')
                                                <a href="{{url('/rh/planoferias/'.$r->st_ano.'/turma/1')}}" class='btn btn-primary fa fa fa-pencil-square' title='Abrir Plano de Férias'></a>
                                                |
                                                @if(!isset($r->ce_nota) && ($r->st_status =='FECHADO'))
                                                    <button onclick="gerarNotaBoletimJPMS({{$r->id}},{{$r->st_ano}})" data-toggle="tooltip" data-placement="top" title='Gerar nota de boletim' class="btn btn-warning fo fa fa-send-o"></button> 
                                                @endif
                                                @if(isset($r->ce_nota))
                                                <a href="{{url('/boletim/nota/visualizar/'.$r->ce_nota)}}" target="_blank" class='btn btn-primary fa fa fa-eye' title='Visualizar nota'></a> |
                                                @endif
                                                @if($r->st_status == 'PUBLICADO')
                                                    <a href="{{url('/rh/planoferias/'.$r->st_ano).'/exportarergon'}}" class='btn bg-green glyphicon glyphicon-usd' title='Exportar dados para o Ergon'></a>
                                                @endif
                                            @else
                                                @if($r->st_status == 'PUBLICADO')
                                                    <a href="{{url('/rh/planoferias/'.$r->st_ano.'/turma/1')}}" class='btn btn-primary fa fa fa-pencil-square' title='Abrir Plano de Férias'></a>
                                                @endif
                                            @endcan
                                        </th>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">
                                        Nenhum resultado encontrado.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        </div>
    </div>
</div>
</div>

<!---modal gerar nota boletim --->
     <div class="modal fade" id="modalGeraNotaResultadoJunta" tabindex="-1" role="dialog" aria-labelledby="modalGeraNotaResultadoJunta" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGeraNotaResultadoJunta">Confirmar geração de nota para boletim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body alert-danger">
                    <h5>DESEJA REALMENTE GERAR NOTA DE BOLETIM?</h5>
                </div>
                <form id="form_gerar_nota_boletim_jpms" role="form" method="POST">
                {{ csrf_field() }}
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                    <button type="submit" class="btn btn-primary" >Gerar Nota</button>
                </div>
            </div>
        </div>
    </div>
 <!--- end modal gerar nota boletim  --->

@stop
  <!-- Script gerar nota boletim jpms-->
  <script>
        function gerarNotaBoletimJPMS(idPlanoFerias, ano){ 
            //alert(idPlanoFerias+'/'+ano);
            $('#modalGeraNotaResultadoJunta').modal({
                show: 'true'
            }); 
            $("#form_gerar_nota_boletim_jpms").attr("action", "{{ url('rh/planoferias/')}}/" + ano + "/gerarnotabg/" + idPlanoFerias);
        }
 </script>
  <!-- end script gerar nota boletim jpms-->


@section('css')
    <style>
        #btnNovoQuadro{
            float:right;
            margin-bottom:1%;
            margin-right:1%;
        }
    </style>
@stop