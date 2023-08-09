@extends('adminlte::page')

@section('title', 'Cadastro de Unidades')


@section('content')

<div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">Cadastro de Unidade</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{url('/admin/unidades')}}">
                            {{ csrf_field() }}


                            <div class="form-group{{ $errors->has('st_pai') ? ' has-error' : '' }}">
                                <label for="st_pai" class="col-md-2 control-label">Unidade Pai:</label>
    
                                <div class="col-md-10">
                                    <select class='form-control select2' name='st_pai' id='st_pai' required>
                                        <option value="">Selecione a Unidade Pai</option>
                                        @foreach($unidades as $unidade)
                                            <option value="{{$unidade->ce_pai}}">{{$unidade->st_nomepais}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('st_pai'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_pai') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                           
                            <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }}">
                                <label for="st_nome" class="col-md-2 control-label">Nome da Unidade:</label>
                                <div class="col-md-6">
                                    <input id="st_nome" type="text" class="form-control" required="true" placeholder="Nome da Unidade" name="st_nome" value="{{ old('name') }}"> 
                                    @if ($errors->has('st_nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_nome') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                                                                  
                                <label for="st_sigla" class="col-md-1 control-label">Sigla:</label>
                                <div class="col-md-3">
                                    <input id="st_sigla" type="text" class="form-control" required="true" placeholder="Sigla" name="st_sigla" value="{{ old('name') }}"> 
                                    @if ($errors->has('st_sigla'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_sigla') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>                                                   

                            <div class="form-group{{ $errors->has('st_ativo') ? ' has-error' : '' }}">
                                <label for="st_ativo" class="col-md-2 control-label">Ativo:</label>
    
                                <div class="col-md-2">
                                    <select class='form-control' name='st_ativo' id='st_ativo' required>
                                    <!--<option value="">Ativo:</option>-->                                        
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>                                        
                                    </select>
                                    @if ($errors->has('st_ativo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_ativo') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <label for="st_tipo" class="col-md-2 control-label">Tipo de Unidade:</label>    
                                <div class="col-md-6">
                                    <select class='form-control' name='st_tipo' id='st_tipo' required>
                                        <option value="">--  Selecionar  --</option>                                        
                                        <option value="Comando Geral">Comando Geral</option>
                                        <option value="Grande Comando">Grande Comando</option>
                                        <option value="Comando Regional">Comando Regional</option>
                                        <option value="Batalhao">Batalhão</option>
                                        <option value="Cia Independente">Cia Independente</option>
                                        <option value="Cia">Cia</option>
                                        <option value="Pelotao">Pelotão</option>
                                        <option value="Destacamento">Destacamento</option>
                                        <option value="Orgao Externo">Orgão Externo</option>
                                    </select>
                                    @if ($errors->has('st_tipo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_tipo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group hidden{{ $errors->has('st_arvore') ? ' has-error' : '' }}">
                                <label for="st_arvore" class="col-md-2 control-label">Árvore:</label>
    
                                <div class="col-md-10 hidden">
                                    <input class='form-control' type='text' name='st_arvore' id='st_arvore'>                                    
                                    @if ($errors->has('st_arvore'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_arvore') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                           
    
                            <div class="form-group ">
                                <div class="col-md-2  col-md-offset-4">
                                    <a href="javascript:history.back()" class="btn btn-warning"  title="Voltar">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>
                                </div>
                                <button type="submit" class="col-md-2 btn btn-primary">
                                    <i class="glyphicon glyphicon-floppy-disk"></i> Salvar
                                </button>
                            </div>
    
    
                        </form>
                       
                        
                    </div>
                </div>
            </div>
        </div>
    
@stop