@extends('adminlte::page')
@section('title', 'Ficha de Reconhecimento')
@section('content')
@php 
use Illuminate\Support\Arr;
@endphp

<input type="hidden" name="recursoAberto" id="recursoAberto" value="{{$quadro->bo_recursoliberado}}">

<div class="container-fluid">
    <div class="row"> 
        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div>
                    <label>Consultar Ficha(s) de Reconhecimento dos sargentos da PM / RN</label>
                </div>
            </div> 
           
            <div class="panel-body">
           
                <form id="form" class="form-contact" role="form" method="POST" 
                     enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input name="ce_ficha"  type="hidden" value="{{Request::segment(9)}}">
                  
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Dados do policial</legend>
                        <br />
                        <div class="form-row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-2">Graduação</th>
                                        <th class="col-xs-2">QPMP</th>
                                        <th class="col-xs-2">Matrícula</th>
                                        <th class="col-xs-2">Nº Praça </th>
                                        <th class="col-xs-2">Data de Nascimento </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th><span class="form-control" disabled>{{$policialDoQuadro->st_postgrad}}</span></th>
                                    <th><span class="form-control" disabled>{{$policialDoQuadro->st_qpmp}}</span></th>
                                    <th><span class="form-control" disabled>{{$policialDoQuadro->st_matricula}}</span></th>
                                    <th><span class="form-control" disabled>{{$policialDoQuadro->st_numpraca}}</span></th>
                                    <th><span class="form-control" disabled>{{date('d/m/Y', strtotime($policialDoQuadro->dt_nascimento))}}</span></th>
                                </tr>
                                </tbody>
                               
                            </table>
                            <!-- <div class="col-xs-8">
                            </div> -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-4">Nome</th>
                                        <th class="col-xs-6">OPM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th><span class="form-control" disabled>{{$policialDoQuadro->st_policial}}</span></th>
                                        <th><span class="form-control" disabled>{{$policialDoQuadro->st_unidade}}</span></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Dados da(s) Ficha(s)</legend>
                        <br />
                        <div class="form-row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-xs-2">Ficha</th>
                                        <th class="col-xs-2">Pontuação enviada</th>
                                        <th class="col-xs-2">Pontuação válida</th>
                                        <th class="col-xs-2">Ação </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($policialDoQuadro->fichas as $key => $fichaDoPm)
                                        <tr>
                                           
                                             <th><span class="form-control" disabled>{{$fichaDoPm->st_ficha}}</span></th>
                                            <th><span class="form-control" disabled>{{$fichaDoPm->vl_pontosdaficha}}</span></th>
                                            <th><span class="form-control" disabled>{{$fichaDoPm->vl_pontosvalidosdaficha}}</span></th> 
                                            <th>
                                                <a href="{{url('promocao/fichaselecionada/visualizarhomologadas/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/'.$competencia.'/ficha/'.$fichaDoPm->id)}}" title="Acessar Ficha" class="btn btn-primary">
                                                    <span class="fa fa-file-o"></span> Ficha {{$fichaDoPm->st_ficha}} 

                                                </a> 
                                                <a href="{{url('promocao/escriturarfichadereconhecimento/'.$idQuadro.'/'.$idAtividade.'/'.$idPolicial.'/competencia/'.$competencia.'/pdf/ficha/'.$fichaDoPm->id)}}" title="Visualizar PDF" class="btn btn-primary" target="_blank">
                                                    <span class="fa fa-file-pdf-o"></span> Visualizar PDF
                                                </a>
                                                <!-- TODO - REFATORAR a blade para desabilitar os campos da ficha quando o qa estiver fechado ou conforme o período de escrituração/recurso -->
                                            </th>
                                        </tr>
                                       
                                    @endforeach
                                   
                                </tbody>
                            
                            </table>
                            <p style="color:red; font-weight: bold;">Selecione uma das fichas de escrituração disponíveis </p>
                            @if(empty(Request::segment(9))) 
                                <input name="ce_ficha"  type="hidden" value="{{Request::segment(9)}}">
                            @endif

                           
                            @if(Request::segment(3) == 'visualizarenviadas' ) 
                                <a href="{{url('promocao/fichasgtenviada/'.$idQuadro.'/'.$idAtividade.'/competencia/'.$competencia)}}" title="Voltar para ficha" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar para enviadas
                                </a> 
                            @endif 
                            @if( Request::segment(3) == 'visualizarhomologadas'  ) 
                           
                                <a href="{{url('promocao/homologadosfichareconhecimento/'.$idQuadro.'/'.$idAtividade.'/competencia/'.$competencia)}}" title="Voltar" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar para homologadas
                                </a> 
                            @endif

                        </div>
                    </fieldset>
                  


                 

                  
                </form>
            </div>
        </div>
    </div>
</div>

@stop
@section('css')
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }
    div {
        overflow-x:auto;
    }
    fieldset 
	{
		border: 1px solid #ddd !important;
		margin: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
    }
  
</style>
@stop

