@extends('adminlte::page')

@section('title', 'Edita Perfil')

@section('content')
<div class="container">
        <div class="row">
        
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">Altera Perfil</div>
                    <div class="panel-body">
                        <div class="text-center">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/role/edita/'.$role->id) }}">
                            {{ csrf_field() }}
                            
    
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nome</label>
    
                                <div class="col-md-6">
                                    <input id="st_nome" type="text" class="form-control" required="true" placeholder="Nome do Perfil" name="st_nome" value="{{ $role->st_nome }}"> 
                                    @if ($errors->has('st_nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_nome') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('st_label') ? ' has-error' : '' }}">
                                <label for="st_label" class="col-md-4 control-label">Descrição</label>
    
                                <div class="col-md-6">
                                    <input id="st_label" type="text" class="form-control" required="true" placeholder="st_label" name="st_label" value="{{$role->st_label  }}"> 
                                    @if ($errors->has('st_label'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_label') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-md-2  col-md-offset-4">
                                    <a href="javascript:history.back()" class=" btn btn-warning"  title="Voltar">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>
                                </div>
                                <button type="submit" class="col-md-2 btn btn-primary">
                                    <i class="fa fa-save"></i> Salvar
                                </button>
                            </div>
                        </div>
                    </div>  

                       <div style="border: solid #0a6 1px; margin-top: 30px;  margin-bottom: 30px;" class="col-md-12 form-inline">
                                <div class="" id="">
                                    
                                
                                                <h4 class="" id="exampleModalLabel">
                                                    <b>SELECIONE AS PERMISSÕES DESEJADAS:</b>
                                                </h4>
                                                <div class="col-md-12  col-md-offset-0">
                                                    <label for="name" class="col-md-4 control-label" style="margin-top:20px;">Permissões</label>
                                                        <form class="form-inline" id="modaladdPermissao" method="post" > {{csrf_field()}}
                                                
                                                    
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Nome da Permissão</th>
                                                                        <th scope="col">Descrição da Permissão</th>
                                                                        <th scope="col">Ação</th>
                                                                        </tr>
                                                                    </thead>
                                                                @php $aux = 1; $concat = null;@endphp

                                                                <tbody>
                                                                  @foreach($todasPermissoes as $k => $p)
                                                                  @php $total = count($role->permissions);@endphp 
                                                                        @if(!isset($p->existe))
                                                                            <tr>
                                                                            <th scope="row" name="idpermission" id="idpermission" value="{{$p->id}}"></th>
                                                                            <td>{{$p->st_nome}}</td>
                                                                            <td>{{$p->st_label}}</td>
                                                                            <td><input type="checkbox" class="form-check-input" name="checkboxpermissions" id="{{$p->id}}"></td>
                                                                            </tr>
                                                                           
                                                                        @else
                                                                            @php 
                                                                            if($k == ($total -1)){
                                                                                
                                                                                $concat = $concat;    
                                                                            }
                                                                            $concat = $concat.$p->id.','; @endphp
                                                                            <tr>
                                                                                <th scope="row" name="idpermission" id="idpermission" value="{{$p->id}}"></th>
                                                                                <td>{{$p->st_nome}}</td>
                                                                                <td>{{$p->st_label}}</td>
                                                                                <td><input type="checkbox" checked class="form-check-input" name="checkboxpermissions" id="{{$p->id}}"></td>
                                                                            </tr>

                                                                        @endif
                                                                        @php $aux++; @endphp
                                                                  @endforeach
                                                                  @php $permissoes = rtrim($concat, ",");@endphp
                                                                </tbody>
                                                                
                                                        
                                                        </table>
                                                    

                                                </div>
                                                <input type="hidden" name="idPerfil" id="idPerfil" value="{{$role->id}}">
                                                <input type="hidden" name="todasPermissoes" id="todasPermissoes" value="{{$permissoes}}">
                                                <input type="hidden" name="novasPermissoes" id="novasPermissoes" value="">
                                                <div class="col-md-6  col-md-offset-5">
                                                    <a style="margin-bottom:20px; display:none;" type="button" onclick="AdicionarPermissao()" id="atualizar" data-toggle="tooltip" data-placement="top" title="Salve aqui as alterações efetuadas" class="btn btn-primary">Atualizar</a>
                                                </div>
                                            
                                            </form>
                                </div>
                            </div>
                       
                        
                        </div>
                </div>
            </div>
            
             
    
@stop