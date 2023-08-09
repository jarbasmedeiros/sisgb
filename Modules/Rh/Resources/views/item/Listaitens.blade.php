@extends('adminlte::page')

@section('title', 'Itens')
@can('Admin')
@section('content_header')
    <a href="{{url('rh/item/create')}}"><h1 class="btn btn-primary">Novo Item</h1></a>
@stop
@endcan

@section('content')
    <div class="content">
            <div class="row">
                <div class="col-md-12">

                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <th colspan="5" class="col-md-12">
                                    
                                    <form id="listaItensByTipoDeRegistro" class="form-horizontal" role="form" method="POST" action="{{ url('/rh/listaitens') }}">
                                    {{csrf_field()}}
                                        <div class="form-group{{ $errors->has('ce_tiporegistro') ? ' has-error' : '' }}">

                                            <label for="st_tiporegistro" class="col-md-2 control-label">Selecione o Tipo de Registro</label>

                                            <div class="col-md-3">
                                                <select name="st_tiporegistro" required="true" class="form-control">
                                                    <option value="">Tipo do Registro</option>
                                                    @if(isset($tiporegistro)&& count($tiporegistro)>0)
                                                    @foreach($tiporegistro as $t)
                                                    <option value="{{$t->id}}">{{$t->st_tipo}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                
                                                @if ($errors->has('st_tiporegistro'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('st_tiporegistro') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <button type="submit" class="btn btn-primary">Filtrar</button>
                                        </div>
                                    </form>
                                </th>
                            </tr>

                            <tr class="bg-primary">
                                <th colspan="6">LISTA DE ITENS</th>
                            </tr>
                            <tr>
                                <th class="col-md-3">NOME</th>
                                <th class="col-md-2">TIPO DE ITEM</th>
                                <th class="col-md-2">TIPO DE REGISTRO</th>
                                <th class="col-md-3">SEQUÊNCIA IMPRESSÃO</th>
                                @can('Admin')
                                <th class="col-md-2">AÇÕES</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($itens))
                            @foreach($itens as $i)
                        <tr>
                            <th>{{$i->st_nome}}</th>
                            <th>{{$i->ce_tipoitem}}</th>
                            <th>{{$i->ce_tiporegistro}}</th>
                            <th>{{$i->nu_sequencia_impressao}}</th>
                            @can('Admin')
                            <th><a class="btn btn-primary" href="{{url('rh/item/edita/'.$i->id)}}">Editar</a> | 
                                <a onclick="modalDesativa({{$i->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger">
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

    <!--Modal Desativa usuário -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
    
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE EXCLUIR O ITEM?</b>
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
               
               $("#modalDesativa").attr("action", "{{ url('rh/item/deleta')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>
@stop