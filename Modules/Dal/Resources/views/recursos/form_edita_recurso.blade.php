@extends('adminlte::page')
@section('title', 'Recursos')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="scheduler-border">
                    <form class="form" method="post" action='{{url("dal/recursos/edita/".$recurso->id)}}'> 
                {{csrf_field()}}        
                <fieldset class="scheduler-border">    	
                <legend class="scheduler-border">DADOS DO RECURSO</legend>
                <div class="row">             
                   
                  <!-- Unidade-->
                      <div class="form-group col-md-5">
                            <label for="ce_unidade" class="control-label">Unidade</label>
                            <select class="form-control select2" name="ce_unidade"  type="number" >
                                        <option value="">Selecione a unidade </option>
												@if(isset($unidade))
													@foreach($unidade  as $c)
                                                    <option value="{{$c->id}}">{!!$c->st_nomepais!!}</option>
													@endforeach
												@endif
								      </select>
                            
                            </div>                   
                     <!-- Categoria-->
                    <div class="form-group col-md-5">
                    <label for="ce_unidade" class="control-label">Categoria</label>
                    <select class="form-control select2" name="ce_categoria"  type="number">
                                        <option value="">Selecione a categoria </option>
												@if(isset($categoria))
													@foreach($categoria  as $c)
														<option value="{{$c->id}}">{{$c->st_categoria}}</option>
													@endforeach
												@endif
								      </select>
                    </div>  
                        <!-- Aquisicao-->
                    <div class="form-group col-md-5">
                            <label for="ce_aquisicao" class="control-label">Aquisição</label>
                            <input id="ce_aquisicao" type="number" class="form-control" name="ce_aquisicao" value="{{$recurso->ce_aquisicao}}"> 
                    </div>
                     <!-- Situacao-->
                    <div class="form-group col-md-5">
                            <label for="ce_situacao" class="control-label">Situação</label>
                            <input id="ce_situacao" type="number" class="form-control" name="ce_situacao"  value="{{$recurso->ce_situacao}}" > 
                    </div>
                        <!-- Tipo-->
                    <div class="form-group col-md-5">
                            <label for="st_tipo " class="control-label">Tipo</label>
                            <input id="st_tipo" type="text" class="form-control" name="st_tipo" value="{{$recurso->st_tipo}}"> 
                    </div> 

                    <!-- Material-->
                    <div class="form-group col-md-5">
                            <label for="st_material" class="control-label">Material</label>
                            <input id="st_material" type="text" class="form-control" name="st_material" value="{{$recurso->st_material}}"> 
                    </div>  
                     <!-- Marca-->
                    <div class="form-group col-md-5">
                            <label for="st_marca " class="control-label">Marca</label>
                            <input id="st_marca" type="text" class="form-control" name="st_marca" value="{{$recurso->st_marca}}"> 
                        </div>
                         <!-- Modelo-->
                     <div class="form-group col-md-5">
                            <label for="st_modelo " class="control-label">Modelo</label>
                            <input id="st_modelo" type="text" class="form-control" name="st_modelo" value="{{$recurso->st_modelo}}"> 
                        </div> 
                         <!-- Serial-->
                     <div class="form-group col-md-5">
                            <label for="st_serial" class="control-label">Serial</label>
                            <input id="st_serial" type="text" class="form-control" name="st_serial" value="{{$recurso->st_serial}}"> 
                        </div>
                        <!-- Tombo-->
                    <div class="form-group col-md-5">
                            <label for="st_tombo" class="control-label">Tombo</label>
                            <input id="st_tombo" type="text" class="form-control" name="st_tombo" value="{{$recurso->st_tombo}}"> 
                        </div>
                        <!-- Medida-->
                    <div class="form-group col-md-5">
                            <label for="st_medida" class="control-label">Medida</label>
                            <input id="st_medida" type="text" class="form-control" name="st_medida" value="{{$recurso->st_medida}}"> 
                        </div> 
                        <!-- Quantidade-->
                     <div class="form-group col-md-5">
                            <label for="nu_quantidade" class="control-label">Quantidade</label>
                            <input id="nu_quantidade" type="number" class="form-control" name="nu_quantidade" value="{{$recurso->nu_quantidade}}"> 
                        </div> 
                        <!-- Carga-->
                     <div class="form-group col-md-5">
                            <label for="nu_carga" class="control-label">Carga</label>
                            <input id="nu_carga" type="number" class="form-control" name="nu_carga" value="{{$recurso->nu_carga}}"> 
                        </div> 
                        <!-- Preco-->
                     <div class="form-group  col-md-5">
                            <label for="vl_preco " class="control-label">Preço</label>
                            <input id="vl_preco" type="number" class="form-control" name="vl_preco" value="{{$recurso->vl_preco}}"> 
                        </div> 
                        <!-- codigo-->
                     <div class="form-group  col-md-5">
                            <label for="st_codigo" class="control-label">Código</label>
                            <input id="st_codigo" type="text" class="form-control" name="st_codigo" value="{{$recurso->st_codigo}}" > 
                        </div> 
                        <!-- Observação-->
                     <div class="form-group col-md-5">
                            <label for="st_obs" class="control-label">Observação</label>
                            <input id="st_obs" type="text" class="form-control" name="st_obs" value="{{$recurso->st_obs}}"  > 
                        </div> 
                    </div>
                
                
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#salvar">Salvar</button>
        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <a href="javascript:history.back()" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar"><i class="glyphicon glyphicon-arrow-left"></i> Voltar
            </a>
        </div>
</div>


@stop
