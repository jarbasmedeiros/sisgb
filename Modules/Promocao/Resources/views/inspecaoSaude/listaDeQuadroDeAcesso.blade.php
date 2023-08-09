@extends('adminlte::page')
@section('title', 'Lista Efetivo')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="row">
            <button class="btn btn-primary" id="btnNovoQuadro" name="btnNovoQuadro" onclick="funcaoModalNovoquadro()" data-toggle="modal" data-target="#atualizarPromocao">Novo Quadro de Acesso</button>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">Lista de quadro de Acesso</div>
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
                            @if(isset($quadros) && count($quadros) > 0)
                                @foreach($quadros as $quadro)
                                    <tr>
                                        <th>{{date('Y', strtotime($quadro->dt_promocao))}}</th>
                                        <th>{{date('d/m/Y', strtotime($quadro->dt_promocao))}}</th>
                                        @if(!empty($quadro->dt_referencia))
                                            <th>{{date('d/m/Y', strtotime($quadro->dt_referencia))}}</th>
                                        @else
                                            <th>{{$quadro->dt_referencia}}</th>
                                        @endif
                                        <th>
                                            <a href="{{url('/promocao/quadro/cronograma/'.$quadro->id.'/competencia/'.$competencia)}}" class='btn btn-primary fa fa fa-eye' title='Abrir'></a> |
                                            
                                            <button onclick="funcaoModalEditarquadro({{$quadro}}, {{$quadro->dt_promocao}}, {{$quadro->dt_referencia}})" data-toggle="modal" data-target="#atualizarPromocao" title="Editar Promoção" class="btn btn-warning fa fa fa-pencil-square"></button>
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


<script>
    function funcaoModalEditarquadro(cadro){
        $("#form_quadro").removeAttr("action");
        $("#form_quadro").attr("action", "{{url('promocao/quadrodeacesso/update')}}/"+cadro.id);
        document.getElementById('dt_promocao').value = null;
        document.getElementById('dt_promocao').value =cadro.dt_promocao;
        document.getElementById('dt_referencia').value = null;
        document.getElementById('dt_referencia').value =cadro.dt_referencia;
    };
    function funcaoModalNovoquadro(){
        $("#form_quadro").removeAttr("action");
        $("#form_quadro").attr("action", "{{url('promocao/quadro/adicionar')}}");
        document.getElementById('dt_promocao').value = null;
        document.getElementById('dt_referencia').value = null;
    };
</script>

<div class="modal fade" id="atualizarPromocao" tabindex="-1" role="dialog" aria-labelledby="salvarpromocao" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h4 class="modal-title">Atualizar Quadro de Acesso</h4>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success salvar">Salvar</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>
@stop
@section('css')
    <style>
        #btnNovoQuadro{
            float:right;
            margin-bottom:1%;
            margin-right:1%;
        }
    </style>
@stop