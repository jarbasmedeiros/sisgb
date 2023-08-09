@extends('adminlte::page')
@section('title', 'Lista de quadro de Acesso')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
<div class="container-fluid">
    <div class="row">
    <div class="row">
        <button class="btn btn-primary" id="btnNovoquadro" name="btnNovoquadro" data-toggle="modal" data-target="#salvarpromocao">No quadro</button>
    </div>
        <div class="panel panel-primary">
            <div class="panel-heading">Lista de quadro de Aceo</div>
            
            <div class="panel-body">
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">

                                <th>Ano</th>
                                <th>Data da Promoção</th>
                                <th>Data de Referência</th>
                                <th class='col-md-1'>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($Quadros) && count($Quadros)>0)
                                @foreach($Quadros as $quadro)
                                    <tr>
                                        <th>{{date('Y', strtotime($quadro->dt_promocao))}}</th>

                                        <th>{{date('d/m/Y', strtotime($quadro->dt_promocao))}}</th>
                                        @if(!empty($quadro->dt_referencia))
                                        <th>{{date('d/m/Y', strtotime($quadro->dt_referencia))}}</th>
                                        @else
                                        <th>{{$quadro->dt_referencia}}</th>

                                        @endif
                                        <th>
                                            <a href="#"  class='btn btn-primary fa fa fa-eye' title='Abrir'></a> |
                                            
                                            
                                            <button onclick="funcaoModalEditarquadro({{$quadro->id}}, {{$quadro->dt_promocao}}, {{$quadro->dt_referencia}} )"  
                                                    data-toggle="modal" data-target="#salvarpromocao" title='Editar Promoção' 
                                                    class="btn btn-warning  fa fa fa-pencil-square"></button>
                                        </th>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para salvar a promoção-->
<div class="modal fade" id="salvarpromocao" tabindex="-1" role="dialog" aria-labelledby="salvapromocao" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal Criar/Editar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-primary">
                <form role="form" id="form_quadro" method="POST" action="{{url('promocao/quadro/adicionar')}}">
                    {{csrf_field()}}
                    <h4>Data da Promoção</h4>
                    <input id="dt_promocao" date="{{$quadro->dt_promocao}}" value="{{$quadro->dt_promocao}}" type="date" required='true' class="form-control fa fa fa-calendar" name="dt_promocao"> 
                    <br/><br/>
                    <h4>Data de Referência</h4>
                    <input id="dt_referencia" date="{{$quadro->dt_referencia}}" type="date" required='true' value="{{$quadro->dt_referencia}}" class="form-control fa fa fa-calendar" name="dt_referencia">
                    <br/><br/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit"  class="btn btn-success salvar">Salvar</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>
<script>
function funcaoModalEditarquadro(id, promocao, referencia){
    $("#form_quadro").removeAttr("action");
    $("#form_quadro").attr("action", "{{url('promocao/quadrodeacesso/update')}}/"+id);
    $("dt_promocao").val(promocao);
    $("dt_referencia").val(referencia);
};
</script>
@stop
@section('css')
    <style>
        btnNovoquadro{ float:right; margin-bottom:1%; margin-right:1%; }
    </style>
@stop