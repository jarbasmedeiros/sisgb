@extends('adminlte::page')
@section('title', 'Restrições')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                CONTROLE DE RESTRIÇÕES MÉDICAS
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="scheduler-border">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan = "3">Lista de restrições médicas disponíveis</th>    
                                    <th colspan = "1" >                
                                        <button type="button" class="btn btn-primary mr-05" data-toggle="modal" data-target="#criarRestricao">
                                            NOVA RESTRIÇÃO
                                        </button>             
                                    </th>          
                                </tr>
                                <tr>
                                    <th class="col-md-2">Ord.</th>
                                    <th class="col-md-4">Restrição</th>
                                    <th class="col-md-4">Status</th>
                                    <th class="col-md-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($restricoes) && count($restricoes) > 0)
                                    <?php $cont = 0; ?>
                                    @forelse($restricoes as $restricao)
                                    <tr>
                                        <td>{{++$cont}}</td>
                                        <td class="text-left">{{$restricao->st_restricao}}</td>
                                        <td>{{$restricao->bo_ativo? 'Ativo': 'Inativo'}}</td>
                                        <td>
                                            <a href="{{url('/juntamedica/restricao/editar/'.$restricao->id)}}" class="btn btn-warning fa fa-pencil" title="Editar"></a>
                                            <!--|
                                            <a href="{.{url('/juntamedica/restricao/deletar/'.$restricao->id)}}" class="btn btn-danger fa fa-trash" title='Deletar'></a>-->
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">Nenhuma restrição encontrada.</td>
                                    </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($restricoes) && count($restricoes)>0  && (!is_array($restricoes)))
    {{$restricoes->links()}}
@endif

<!-- Moldal Criar Sessão -->
<div class="modal fade" id="criarRestricao" tabindex="-1" role="dialog" aria-labelledby="criarRestricao" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="criarRestricao">Criar uma nova restrição para JPMS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form"  method="post" action='{{url("juntamedica/restricao/criar")}}'> 
            {{csrf_field()}}
                <fieldset class="scheduler-border">    	
                    <legend class="scheduler-border">DADOS DA RESTRIÇÃO</legend>
                    <div class="row">
                        <div class="form-group{{ $errors->has('st_restricao') ? ' has-error' : '' }} col-md-12">
                            <label for="st_restricao" class="control-label">RESTRIÇÃO</label>
                            <input id="st_restricao" type="text" class="form-control" name="st_restricao" > 
                            @if ($errors->has('st_restricao'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_restricao') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@stop
@section('css')
    <style>
        th, td{text-align: center;}
        #a-voltar {margin-left: 10px;}
    </style>
@stop