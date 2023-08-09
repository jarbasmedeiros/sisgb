@extends('boletim::boletim.template_boletim')

@section('title', 'Boletins em Elaboração')

@section('content_dinamic')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Lista de tópicos</div>
                <div class="panel-body">
                    
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"> Critério de pesquisa de tópicos </legend>
                        <a href='{{url("boletim/topico/create")}}' class="btn btn-primary" style="float:right; margin-bottom:10px;">  Novo Tópico</a>
                        <form role="form" method="POST" action="{{ url('boletim/topicos/pesquisa')}}">
                            <div class="row">
                            {{csrf_field()}}
                               
                                <div class="form-group col-md-3">
                                    <label for="st_topico">Nome do tópico</label>                      
                                    <input id="st_topico" type="text" class="form-control" placeholder="Informar o nome do tópico" name="st_topico"  required > 
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="btnPesquisarTopico"></label>
                                    <button type="submit" name="btnPesquisarTopico"class="btn btn-primary" id="btnPesquisarTopico"><i class="fa fa fa-search"></i> Pesquisar</button>   
                                </div>
                            </div>
                        </form>             
                    </fieldset>
                    <fieldset class="scheduler-border">
                    @if(isset($topicos) && count($topicos)>0)
                        <legend class="scheduler-border">Resultado da listagem de tópicos {{$topicos->total()}} registro(s)</legend>
                    @else 
                        <legend class="scheduler-border">Resultado da listagem de tópicos 0 registro</legend>
                    @endif
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Tópicos</th>
                                    <th>Partes</th>
                                    <th class='col-1' >Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            @if(isset($topicos) && count($topicos)>0)
                                @foreach($topicos as $t)
                                    <tr>
                                        <td>{{$t->st_topico}}</td>
                                        <td>{{$t->st_parte}}</td>
                                    
                                        <td >
                                        <a href="{{url('boletim/topico/edit/'.$t->id)}}"  class='btn btn-primary fa fa fa-eye' title='Abrir'></a>
                                            | <button onclick="modalExcluiTopico({{$t->id}})" data-toggle="tooltip" data-placement="top" title='Excluir Topico' class="btn btn-danger fo fa fa-trash"></button> 
                                        </td>
                                    </tr>
                                @endforeach 
                            @else
                                    <tr>
                                        <td colspan='5'>Nenhum tópico encontrado.</td>
                                    </tr>

                            @endif

                            </tbody>
                        </table>
                        @if(isset($topicos) && count($topicos)>0)
                            <div class="pagination pagination-centered">
                            <tr>
                                <td>
                                @if(isset($dadosForm))
                                    {{$topicos->appends($dadosForm)->links()}}
                                @else
                                    {{$topicos->links()}}
                                @endif
                                   
                                    
                                </td>
                            </tr>
                            </div>
                        @endif
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

                    
 
   
<div class="modal fade-lg" id="exclui_topico" tabindex="-1" role="dialog" aria-labelledby="exclui_topico" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Excluir Topico</h4>
            </div>
            <div class="modal-body bg-danger">
            <form class="form-horizontal" id="form_exclui_topico" method="get"> 
                <h4 class="modal-title">
                        <strong>DESEJA REALMENTE EXCLUIR O TÓPICO?</strong>
                </h4>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                    <a id="deleta_topico"  class="btn btn-danger exclui_topico">Excluir</a>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@stop
