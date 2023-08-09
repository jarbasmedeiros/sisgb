@extends('adminlte::page')
@section('title', 'Recurso')
@section('content')
<div class="container-fluid">
<div class="row">
<div class="panel panel-primary"> 
    <div class="panel-heading">RECURSOS</div>
            <div class="panel-body">
            <div class="row">
                    <div class="col-md-12">
                                <form  class="form-horizontal" role="form" method="post" action='{{url("dal/recursos/paginado")}}' >
                                    <div class="form-group col-md-12">
                                    {{csrf_field()}}
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="ce_unidade[]" id="ce_unidade[]" data-placeholder="Selecione a unidade" style="width: 100%;" required>
                                            <option >Selecione a unidade </option>
                                                @foreach($unidade as $u)
                                                   <option value="{{$u->id}}">{!!$u->st_nomepais!!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>       
                                    <div class="col-md-5">
                                        <label for="ce_categoria" class="col-md-2 ">Categoria:</label>
                                        <div class="col-md-9">
                                        <select class="form-control select2" name="ce_categoria[]" multiple="multiple" >
                                        <option >Selecione a categoria </option>
												@if(isset($categoria))
													@foreach($categoria  as $c)
														<option value="{{$c->id}}">{{$c->st_categoria}}</option>
													@endforeach
												@endif
								      </select>
                                            </div>
                                    </div>   
                                    <button type="submit" class="btn btn-primary"><span ></span> Consultar</button>                                                                                        
                                </form>
                                </div> 
     
                <div class="col-md-12">
                    <div class="scheduler-border">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                <th colspan = "6">LISTA DE RECURSOS</th>    
                                     <th>
                                     <button type="button" class="btn btn-primary mr-05" data-toggle="modal" data-target="#criarecurso">
                                        NOVO RECURSO
                                    </button> 
                                    </th>         
                                </tr>
                                <tr>
                                    <th class="col-md-1">Tipo</th>
                                    <th class="col-md-3">Material</th>
                                    <th class="col-md-3">Marca</th>
                                    <th class="col-md-3">Modelo</th>
                                    <th class="col-md-3">Serial</th>
                                    <th class="col-md-3">Tombo</th>
                                    <th class="col-md-2">Ações</th>

                                </tr>
                                
                            </thead> 
                       
                            <tbody>
	                            @if(isset($recurso) && count($recurso) > 1 )
                                    @forelse($recurso as $s)
                                    <tr>
                                        <td>{{$s->st_tipo}}</td>
                                        <td>{{$s->st_material}}</td>
                                        <td>{{$s->st_marca}}</td>
                                        <td>{{$s->st_modelo}}</td>
                                        <td>{{$s->st_serial}}</td>
                                        <td>{{$s->st_tombo}}</td>
                                        <td>
                                            @if($s->ce_categoria == 1) 
                                                @else
                                                <a href="{{url('dal/recursos/edita/'.$s->id)}}" class="btn btn-warning fo fa fa-pencil" title='Editar'></a>
                                                <a onclick="modalDesativa({{$s->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger fa fa-trash"></a>
                                            @endif
                                      </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">Nenhum recurso encontrado.</td>
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
                            <h5 class="modal-title" id="exampleModalLabel">Excluir Recurso</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form-inline" id="modalDesativa" method="delete" > 
                        {{csrf_field()}}
                            <div class="modal-body bg-danger">
                                <h4 class="modal-title" id="exampleModalLabel">
                                    <b>DESEJA REALMENTE EXCLUIR O RECURSO?</b>
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
                    $("#modalDesativa").attr("action", "{{ url('dal/recursos/excluirecurso')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>

<!-- Moldal Excluir Sessão -->

            </div>
        </div>
    </div>
</div>




<!-- Moldal Criar   Recurso  -->
<div class="modal fade" id="criarecurso" tabindex="-1" role="dialog" aria-labelledby="criarecurso" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="criarecurso">Criar novo recurso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form"  method="post" action='{{url("dal/recursos/cadastrar")}}'> 
                {{csrf_field()}}
                <fieldset class="scheduler-border"  style="width: 100%;">    	
                    <legend class="scheduler-border">DADOS DO RECURSO</legend>



                    <!-- Unidade-->
                    <label for="ce_unidade" class="control-label">Unidade</label>
                    <div class="row">
                        <select class="form-control select2" name="ce_unidade"  data-placeholder="Selecione a unidade" style="width:100%;" required>
                            <option value="">Selecione a unidade </option>
                                @foreach($unidade as  $u)
                                    <option value="{{$u->id}}">{{$u->st_nomepais}}</option>
                                @endforeach 
                       </select>
                    </div>
                    
                     <!-- Categoria-->
                    <div class="form-group col-md-5">
                    <label for="ce_unidade" class="control-label">Categoria</label>
                    <select class="form-control select2" name="ce_categoria" type="number" style="width:100%;" >
                                        <option >Selecione a categoria </option>
												@if(isset($categoria))
													@foreach($categoria  as $c)
														<option value="{{ $c->id}}">{{$c->st_categoria}}</option>
													@endforeach
												@endif
								      </select>
                                </div>                          <!-- Aquisicao-->
                    <div class="form-group col-md-5">
                            <label for="ce_aquisicao" class="control-label">Aquisição</label>
                            <input id="ce_aquisicao" type="number" class="form-control" name="ce_aquisicao" > 
                    </div>
                     <!-- Situacao-->
                    <div class="form-group col-md-5">
                            <label for="ce_situacao" class="control-label">Situação</label>
                            <input id="ce_situacao" type="number" class="form-control" name="ce_situacao" > 
                    </div>
                    <!-- Tipo-->
                    <div class="form-group col-md-5">
                            <label for="st_tipo " class="control-label">Tipo</label>
                            <input id="st_tipo" type="text" class="form-control" name="st_tipo" > 
                   </div> 

                    <!-- Material-->
                    <div class="form-group col-md-5">
                            <label for="st_material" class="control-label">Material</label>
                            <input id="st_material" type="text" class="form-control" name="st_material" > 
                    </div>  
                     <!-- Marca-->
                    <div class="form-group col-md-5">
                            <label for="st_marca " class="control-label">Marca</label>
                            <input id="st_marca" type="text" class="form-control" name="st_marca" > 
                    </div>
                         <!-- Modelo-->
                    <div class="form-group col-md-5">
                            <label for="st_modelo " class="control-label">Modelo</label>
                            <input id="st_modelo" type="text" class="form-control" name="st_modelo" > 
                    </div> 
                         <!-- Serial-->
                    <div class="form-group col-md-5">
                            <label for="st_serial" class="control-label">Serial</label>
                            <input id="st_serial" type="text" class="form-control" name="st_serial" > 
                    </div>
                        <!-- Tombo-->
                    <div class="form-group col-md-5">
                            <label for="st_tombo" class="control-label">Tombo</label>
                            <input id="st_tombo" type="text" class="form-control" name="st_tombo" > 
                    </div>
                        <!-- Medida-->
                    <div class="form-group col-md-5">
                            <label for="st_medida" class="control-label">Medida</label>
                            <input id="st_medida" type="text" class="form-control" name="st_medida" > 
                    
                    </div> 
                        <!-- Quantidade-->
                    <div class="form-group col-md-5">
                            <label for="nu_quantidade" class="control-label">Quantidade</label>
                            <input id="nu_quantidade" type="number" class="form-control" name="nu_quantidade" > 
                    </div> 
                        <!-- Carga-->
                    <div class="form-group col-md-5">
                            <label for="nu_carga" class="control-label">Carga</label>
                            <input id="nu_carga" type="number" class="form-control" name="nu_carga" > 
                    </div> 
                        <!-- Preco-->
                    <div class="form-group col-md-5">
                            <label for="vl_preco " class="control-label">Preço</label>
                            <input id="vl_preco" type="number" class="form-control" name="vl_preco" > 
                    </div> 
                        <!-- codigo-->
                    <div class="form-group col-md-5">
                            <label for="st_codigo" class="control-label">Código</label>
                            <input id="st_codigo" type="text" class="form-control" name="st_codigo" > 
                    </div> 
                        <!-- Observação-->
                    <div class="form-group col-md-5">
                            <label for="st_obs" class="control-label">Observação</label>
                            <input id="st_obs" type="text" class="form-control" name="st_obs" > 
                    </div> 
                    </div>
                    
                    <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"  >Salvar</button>
                    </div>
                    </div>
                 </div> 
                </fieldset>
            </form>
           
            
       
@stop
@section('css')
    <style>
        th, td{text-align: center;}
        #a-voltar {margin-left: 10px;}
    </style>
@stop