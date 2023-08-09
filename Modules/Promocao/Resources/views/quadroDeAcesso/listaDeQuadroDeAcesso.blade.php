@extends('adminlte::page')
@section('title', 'Lista de quadro de Acesso')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

@section('content')
@php
    setlocale(LC_TIME, 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
@endphp
<div class="container-fluid">
    <div class="row">
        @can('Lista_Todos_QA')
            <div class="row">
                @can('GERENCIAR_QA')
                    <button class="btn btn-primary" id="btnNovoQuadro" name="btnNovoQuadro" onclick="funcaoModalNovoquadro()" data-toggle="modal" data-target="#atualizarPromocao">
                        <i class="fa fa-plus"></i> Abrir o Quadro de Acesso
                    </button>
                @endcan
            </div>
        @endcan
        <div class="panel panel-primary">
            <div class="panel-heading">Lista de Quadros de Acessos</div>
            <div class="panel-body">
                <div>
                    <table class="table table-bordered table-responsive table-striped">
                        <thead>
                            <tr class="bg-primary">
                                <th class='col-md-1'>Ano</th>
                                <th class='col-md-2'>Promoção de</th>
                                <th class='col-md-2'>Data da Promoção</th>
                                <th class='col-md-2'>Data de Referência</th>
                                <th class='col-md-1'>Status</th>
                                <th class='col-md-3'>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($quadros) && count($quadros) > 0)
                                @foreach($quadros as $quadro)
                                    {{-- @cannot('Lista_Todos_QA') 
                                        @if ($quadro->st_status != 'ABERTO')
                                           @continue        
                                        @endif
                                    @endcannot --}}
                                    <tr>
                                        <td>{{date('Y', strtotime($quadro->dt_promocao))}}</td>
                                        <td>{{strftime('%B/%Y', strtotime($quadro->dt_promocao))}}</td>
                                        <td>{{date('d/m/Y', strtotime($quadro->dt_promocao))}}</td>
                                        @if(!empty($quadro->dt_referencia))
                                            <td>{{date('d/m/Y', strtotime($quadro->dt_referencia))}}</td>
                                        @else
                                            <td>{{$quadro->dt_referencia}}</td>
                                        @endif
                                        <td>{{$quadro->st_status}}</td>
                                        <td class="text-left">
                                            {{-- essa rota leva para a tela de cronograma do QA --}}
                                            {{-- <a href="{{url('/promocao/quadro/cronograma/'.$quadro->id.'/competencia/'.$competencia)}}" class='btn btn-primary btn-sm fa fa fa-eye' title='Abrir'></a>  --}}
                                            {{-- essa rota leva para a tela de Escriturar Ficha de Reconhecimento --}}
                                            <a href="{{url('/promocao/fichasgtnaoenviada/'.$quadro->id.'/4/competencia/'.$competencia)}}" class='btn btn-primary btn-sm fa fa fa-eye' title='Abrir Quadro de Acesso'></a> 
                                            @if ($quadro->st_status === 'ABERTO')
                                                @can('EDITA_QA')
                                                    {{-- essa rota leva para a tela de Homologar Ficha de Reconhecimento --}}
                                                    | <a href="{{url('/promocao/homologarfichareconhecimento/'.$quadro->id.'/10/competencia/'.$competencia.'/graduacao/todos')}}" class='btn btn-success btn-sm fa fa fa-gavel' title='Homologar Fichas de Reconhecimento'></a> 
                                                    
                                                    @can('GERENCIAR_QA')
                                                        | <button onclick="funcaoModalEditarquadro({{json_encode($quadro)}}, {{$quadro->dt_promocao}}, {{$quadro->dt_referencia}})" data-toggle="modal" data-target="#atualizarPromocao" title="Editar Quadro de Acesso" class="btn btn-warning btn-sm fa fa fa-pencil-square"></button> 
                                                        
                                                        | 
                                                        @if ($quadro->bo_escriturarliberado)
                                                            <a href="{{url('promocao/alterarescriturar/qa/'.$quadro->id.'/10/competencia/'.$competencia.'/bloquear')}}" class="btn btn-danger btn-sm fa fa-lock" title="Bloquear Escriturar"></a>
                                                        @else
                                                            <a href="{{url('promocao/alterarescriturar/qa/'.$quadro->id.'/10/competencia/'.$competencia.'/liberar')}}" class="btn btn-success btn-sm fa fa-unlock-alt" title="Liberar Escriturar"></a>
                                                        @endif
                                                        |
                                                        @if ($quadro->bo_recursoliberado)
                                                            <a href="{{url('promocao/alterarrecurso/qa/'.$quadro->id.'/10/competencia/'.$competencia.'/bloquear')}}" class="btn btn-danger btn-sm fa fa-balance-scale" title="Bloquear Recurso"></a>
                                                        @else
                                                            <a href="{{url('promocao/alterarrecurso/qa/'.$quadro->id.'/10/competencia/'.$competencia.'/liberar')}}" class="btn btn-success btn-sm fa fa-balance-scale" title="Liberar Recurso"></a>
                                                        @endif
                                                        |    <a href="{{url('promocao/dashoboard/qa/'.$quadro->id.'/10')}}" class="btn btn-primary btn-sm fa fa-dashboard" title="Dashboard"></a>
                                                    @endcan
                                                    @can('IMPORTAR_EFETIVO_INSPECAO_JPMS_TAF_QA')
                                                        @if ($quadro->bo_escriturarliberado || $quadro->bo_recursoliberado)
                                                            |<button type="button" class="btn btn-primary" onclick="modalImportaEfetivo({{$quadro->id}})" title="Importar efetivo inspecionado pela JPMS ou TAF">
                                                                <i class="fa fa-users"></i>
                                                            </button>
                                                        @endif
                                                    @endcan
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">
                                        Nenhum Quadro de Acesso encontrado.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    @if(isset($quadros) && count($quadros) > 0)
                        {{ $quadros->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="novaPromocao" tabindex="-1" role="dialog" aria-labelledby="salvarpromocao" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h4 class="modal-title">Novo Quadro de Acesso</h4>
            </div>
            <div class="modal-body bg-primary">
                <form role="form" id="form_quadro" method="POST" action="{{url('promocao/quadro/adicionar')}}"> 
                    {{csrf_field()}}  
                    <h4>Data da Promoção</h4>
                    <input id="dt_promocao" type="date" required class="form-control" name="dt_promocao" value=""> 
                    <br/><br/>
                    <h4>Data de Referência</h4>
                    <input id="dt_referencia" type="date" required class="form-control" name="dt_referencia" value="">
                    <br/><br/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success salvar">Salvar</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div> -->

<div class="modal fade" id="atualizarPromocao" tabindex="-1" role="dialog" aria-labelledby="salvarpromocao" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h4 class="modal-title">Cadastro de Quadro de Acesso</h4>
            </div>
            <div class="modal-body bg-primary">
                <form role="form" id="form_quadro" method="POST" action="{{url('promocao/quadro/adicionar')}}"> 
                    {{csrf_field()}}  
                    <h4>Data da Promoção</h4>
                    <input id="dt_promocao" type="date" required class="form-control" name="dt_promocao" > 
                    <br/><br/>
                    <h4>Data de Referência</h4>
                    <input id="dt_referencia" type="date" required class="form-control" name="dt_referencia" >
                    <br/><br/>
                    <h4>Quadro de Acesso anterior</h4>
                    <select  class="form-control select2-container" name="ce_qaanterior" id="ce_qaanterior" required style="z-index: 289;">
                        <option value="">Selecione</option>
                        @foreach($quadros as $key => $qa)
                            @if($key < 5)
                                <option value="{{$qa->id}}"> {{date('d/m/Y', strtotime($qa->dt_promocao))}}</option>
                            @endif
                        @endforeach
                    </select>
                    <br/><br/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success salvar">Salvar</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>

<!-- modal adicionar PM em LOTE -->
<div class="modal fade" id="modalImportaEfetivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Importar Efetivo</h4>
            </div>
            <div class="modal-body">
                <div class="modal-footer">
                    <div style='text-align:left;background-color:lightgray;padding:10px;border-radius:5px;'>
                        <form action="{{ route('importarPoliciaisInspecionadosJpmsTafExcel') }}" role="form" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                            <label for="tipoInspecao">Tipo</label>
                            <select name="tipoInspecao" id="tipoInspecao" required>
                                <option value="">Selecione</option>
                                <option value="jpms">JPMS</option>
                                <option value="taf">TAF</option>
                            </select>
                            <br><br>
                            <b>Obs:</b> O nome da planilha deve ser efetivo_inspecionado_do_qa.xls e a primeira coluna deve conter as matrículas na hora de fazer o upload.
                            <br><br>
                            <span>
                                <input id='arquivo' type="file" class="form-control-file" name='arquivo' required>
                                @if(isset($quadro))
                                    <input id="idQuadro" type="hidden" name='idQuadro' id='idQuadro'  >
                                @endif
                            </span>
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

<script>

    function funcaoModalEditarquadro(quadro){
        $("#form_quadro").removeAttr("action");
        $("#form_quadro").attr("action", "{{url('promocao/quadrodeacesso/update')}}/"+quadro.id);
        document.getElementById('dt_promocao').value = null;
        document.getElementById('dt_promocao').value =quadro.dt_promocao;
        document.getElementById('dt_referencia').value = null;
        document.getElementById('dt_referencia').value =quadro.dt_referencia;
        document.getElementById('ce_qaanterior').value =null;
        document.getElementById('ce_qaanterior').value =quadro.ce_qaanterior;
    };

    function funcaoModalNovoquadro(){
        $("#form_quadro").removeAttr("action");
        $("#form_quadro").attr("action", "{{url('promocao/quadro/adicionar')}}");
        document.getElementById('dt_promocao').value = null;
        document.getElementById('dt_referencia').value = null;
        document.getElementById('ce_qaanterior').value = null;
    };

    function modalImportaEfetivo(idQuadro) {
        $('#idQuadro').val(idQuadro)
        $('#modalImportaEfetivo').modal()
    }

</script>

@stop
@section('css')
    <style>
        #btnNovoQuadro{
            float:right;
            margin-bottom:1%;
            margin-right:1%;
        }

        th, td { text-align: center; }
    </style>
@stop