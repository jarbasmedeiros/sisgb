@extends('adminlte::page')

@section('title', 'Lista de Gratificações')
@section('content_header')
@can('Gratificacao')
    <a href="{{url("rh/gratificacao/create")}}"><h1 class="btn btn-primary">Nova Gratificação</h1></a>
    @endcan
    <a href="{{url("rh/gratificacoes/pdf")}}"><h1 class="btn btn-primary"><i class="fa fa-fw fa-print"></i> Imprimir Lista de Gratificação</h1></a>
@stop

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="7">Lista de Gratificações</th>
                        </tr>
                        <tr>
                            <th class="col-md-3">Nome</th>
                            <th class="col-md-2">Valor</th>
                            <th class="col-md-1">Quantidade de Vagas</th>
                            <th class="col-md-1">Funcionários</th>
                            <th class="col-md-1">Disponível</th>
                            <th class="col-md-1">Total Gasto</th>
                            @can('Gratificacao')
                            <th class="col-md-2">Ações</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($listGrat))
                            @foreach($listGrat as $grat)
                                <tr>
                                    <th>{{$grat->st_gratificacao}}</th>
                                    <th>R$ {{substr(str_replace(".",",", $grat->vl_gratificacao), 0, -2)}}</th>
                                    <th>{{$grat->nu_vagas}}</th>
                                    @foreach($grat->listGrat as $key=>$valor)
                                        @if ($valor->st_gratificacao == $grat->st_gratificacao)
                                            <th>{{$valor->qtde}}</th>
                                            <th>{{($grat->nu_vagas) - ($valor->qtde)}}</th>
                                            <th>R$ {{($valor->qtde) * ($grat->vl_gratificacao)}}</th>
                                        @endif
                                    @endforeach 
                                    @can('Gratificacao')
                                    <th><a class="btn btn-primary" href="{{url('rh/gratificacao/edita/'.$grat->id)}}">Editar</a> | 
                                        <a onclick="modalDesativa({{$grat->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger">
                                        <i class="fa fa-trash"></i></a> 
                                    </th>
                                    @endcan
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Modal Desativa gratificação -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Gratificação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
    
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE EXCLUIR A GRATIFICAÇÃO?</b>
                    </h4>
                    <form class="form-inline" id="modalDesativa" method="post" > {{csrf_field()}}
    
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
               
               $("#modalDesativa").attr("action", "{{ url('rh/gratificacao/destroy')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>

@stop