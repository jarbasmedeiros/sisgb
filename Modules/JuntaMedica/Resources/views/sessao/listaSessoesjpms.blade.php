@extends('adminlte::page')
@section('title', 'Sessões')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="panel panel-primary"> 
    <div class="panel-heading">CONTROLE DE SESSÕES</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="scheduler-border">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                <th colspan = "5">LISTA DE SESSÕES DA JPMS</th>    
                                <th colspan = "1" >                
                                    <button type="button" class="btn btn-primary mr-05" data-toggle="modal" data-target="#criaSessao">
                                        NOVA SESSÃO
                                    </button>                            
                                </th>          
                                </tr>
                                <tr>
                                    <th class="col-md-1">Tipo</th>
                                    <th class="col-md-2">Data</th>
                                    <th class="col-md-3">Número</th>
                                    <th class="col-md-3">Status</th>
                                    <th class="col-md-1">Vitual</th>
                                    <th class="col-md-2">Ações</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($sessoes) && count($sessoes) > 0)
                                    @forelse($sessoes as $s)
                                    <tr>
                                        <td>{{$s->st_tipo}}</td>
                                        <td> {{date( "d/m/Y", strtotime($s->dt_sessao))}}</td>
                                        <td>{{$s->nu_sequencial}}/{{$s->nu_ano}}</td>
                                        <td>{{$s->st_status}}</td>
                                        @if ($s->bo_sessaovirtual == 1)
                                            <td>Sim</td>
                                        @else
                                            <td>Não</td>
                                        @endif
                                        <td class="text-left">
                                            <a href="{{url('/juntamedica/sessoes/'.$s->id.'/sessaoaberta')}}" class="btn btn-primary fa fa fa-eye col-md-offset-2" title='Abrir'></a>
                                            |
                                            <a href='{{url("/juntamedica/sessoes/edita/".$s->id)}}' class="btn btn-warning fo fa fa-pencil" title="Editar"></a>
                                            @if($s->st_status == 'ABERTO')
                                            |
                                            <a onclick="modalDesativa({{$s->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger fa fa-trash"></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">Nenhuma sessão encontrada.</td>
                                    </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                   </div>

<!-- Moldal Excluir Sessão -->

                            <div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Excluir Sessão</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form-inline" id="modalDesativa" method="GET" > {{csrf_field()}}
                            <div class="modal-body bg-danger">
                                <h4 class="modal-title" id="exampleModalLabel">
                                    <b>DESEJA REALMENTE EXCLUIR A SESSÃO?</b>
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
                    $("#modalDesativa").attr("action", "{{ url('juntamedica/sessoes/exclui/sessao')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>

<!-- Moldal Excluir Sessão -->

            </div>
        </div>
    </div>
</div>
@if(isset($sessoes) && count($sessoes)>0  && (!is_array($sessoes)))
    {{$sessoes->links()}}
@endif


<!-- Moldal Criar Sessão -->
<div class="modal fade" id="criaSessao" tabindex="-1" role="dialog" aria-labelledby="criaSessao" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="criaSessao">Criar uma nova Sessão para JPMS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form"  method="post" action='{{url("juntamedica/sessoes/novasessao")}}'> 
                {{csrf_field()}}
                <fieldset class="scheduler-border">    	
                    <legend class="scheduler-border">DADOS DA SESSÃO</legend>
                    <div class="row">
                        <div class="form-group{{ $errors->has('ce_tipo') ? ' has-error' : '' }} col-md-12">
                            <label for="ce_tipo" class="control-label">TIPO DA SESSÃO</label>
                            <select id="ce_tipo" name="ce_tipo" class="form-control" >
                            @foreach($tipos as  $tp)
                            <option value="{{$tp->id}}">{{$tp->st_tipo}}</option>
                            @endforeach                    
                            </select>
                            @if ($errors->has('ce_tipo'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_tipo') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('bo_sessaovirtual') ? ' has-error' : '' }} col-md-12">
                            <div class="form-check">
                                <input type="checkbox" name="bo_sessaovirtual" value="1">
                                <strong> SESSÃO VIRTUAL </strong>
                            </div>
                            @if ($errors->has('bo_sessaovirtual'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bo_sessaovirtual') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('dt_sessao') ? ' has-error' : '' }} col-md-12">
                            <label for="dt_sessao" class="control-label">DATA DA SESSÃO</label>
                            <input id="dt_sessao" type="date" class="form-control" name="dt_sessao" > 
                            @if ($errors->has('dt_sessao'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dt_sessao') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"  >Salvar</button>
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

