@extends('adminlte::page')

@section('title', 'Edição de Itens')

@section('content')
<div class="row">
        <div class="col-md-12">
            
                @if(session('sucessoMsg'))
                <div class="container">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Sucesso!</strong> {{ session('sucessoMsg')}}
                    </div>
                </div>
                @endif
                @if(session('erroMsg'))
                <div class="container">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Atenção!</strong> {{ session('erroMsg')}}
                    </div>
                </div>
                @endif
        </div>
    </div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Editar Item</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action='{{ url("rh/item/edita/$item->id") }}'>
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('ce_tiporegistro') ? ' has-error' : '' }}">
                        <label for="ce_tiporegistro" class="col-md-2 control-label">Tipo de Registro</label>

                        <div class="col-md-3">
                            <select name="ce_tiporegistro" required="true" class="form-control">
                                <option value="{{$item->ce_tiporegistro}}">{{$item->ce_tiporegistro}}</option>
                                @if(isset($tiposregistro)&& count($tiposregistro)>0)
                                @foreach($tiposregistro as $t)
                                @if($item->ce_tiporegistro == $t->id)
                                <option selected="true" value="{{$t->id}}">{{$t->st_tipo}}</option>
                                @else
                                <option value="{{$t->id}}">{{$t->st_tipo}}</option>
                                @endif
                                @endforeach
                                @endif

                            </select>

                            @if ($errors->has('ce_tiporegistro'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_tiporegistro') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                        
                    <div class="form-group{{ $errors->has('ce_tipoitem') ? ' has-error' : '' }}">
                        <label for="ce_tipoitem" class="col-md-2 control-label">Tipo de Item</label>

                        <div class="col-md-3">
                            <select id="ce_tipoitem" name="ce_tipoitem" onclick="selectTipoItem()" required="true" class="form-control">
                                <option value="{{$item->ce_tipoitem}}">{{$item->ce_tipoitem}}</option>
                                @if(isset($tipositens)&& count($tipositens)>0)
                                @foreach($tipositens as $ti)
                                @if($item->ce_tipoitem == $ti->id)
                                <option selected="true" value="{{$ti->id}}">{{$ti->st_item}}</option>
                                @else
                                <option value="{{$ti->id}}">{{$ti->st_item}}</option>
                                @endif
                                @endforeach
                                @endif
                                </select>

                            @if ($errors->has('st_item'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_item') }}</strong>
                            </span>
                                @endif
                            </div>
                    </div>   

                    <div id="divDetalhe" class="form-group{{ $errors->has('bo_detalhe') ? ' has-error' : '' }}" style="display: none">
                        <label for="bo_detalhe" class="col-md-2 control-label">Detalhe</label>

                        <div class="col-md-3">
                            <select id="bo_detalhe" name="bo_detalhe" class="form-control" disabled="true">
                                <option value="{{$item->bo_detalhe}}">Selecione</option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select> 
                        </div>
                    </div>

                    <div id="divMestre" class="form-group{{ $errors->has('bo_mestre') ? ' has-error' : '' }}" style="display: none">
                        <label for="bo_mestre" class="col-md-2 control-label">Mestre</label>
                        <div class="col-md-3">
                            <select id="bo_mestre" name="bo_mestre" onclick="selectMestre()" disabled="true" class="form-control">
                                <option value="{{$item->bo_mestre}}">Selecione</option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select> 
                        </div>
                    </div>

                    <div id="divTabelaOrigem" class="form-group{{ $errors->has('st_tabelaorigem') ? ' has-error' : '' }}" style="display: none">
                        <label for="st_tabelaorigem" class="col-md-2 control-label" >Tabela Origem</label>

                        <div class="col-md-3">
                            <select id="st_tabelaorigem" disabled="true" onclick="selectTipoItem()" name="st_tabelaorigem" class="form-control">
                                <option value="{{$item->st_tabelaorigem}}">Selecione a Tabela</option>
                                @if(isset($tables)&& count($tables)>0)
                                @foreach($tables as $key=> $ta)                                                           
                                <option value="{{$ta->TABLE_NAME}}">{{$ta->TABLE_NAME}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div id="divColunaWhere" class="form-group{{ $errors->has('st_colunawhere') ? ' has-error' : '' }}" style="display: none">
                        <label for="st_colunawhere" class="col-md-2 control-label">Coluna Where</label>

                        <div class="col-md-6">
                            <input id="st_colunawhere" type="text" disabled="true" class="form-control" placeholder="Coluna Where" name="st_colunawhere" 
                            value="{{$item->st_colunawhere}}"> 
                                @if($errors->has('st_colunawhere'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_colunawhere') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>

                    <div id="divColunaTabela" class="form-group{{ $errors->has('st_colunatabela') ? ' has-error' : '' }}" style="display: none">
                        <label for="st_colunatabela" class="col-md-2 control-label">Coluna Tabela</label>

                        <div class="col-md-6">
                            <input id="st_colunatabela" type="text" disabled="true" class="form-control" placeholder="Coluna Tabela" name="st_colunatabela" 
                            value="{{$item->st_colunatabela}}"> 
                                @if($errors->has('st_colunatabela'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_colunatabela') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>

                    <div id="divIdDetalhe" class="form-group{{ $errors->has('st_iddetalhe') ? ' has-error' : '' }}" style="display: none">
                        <label for="ce_tipoitem" class="col-md-2 control-label">ID Detalhe</label>

                        <div class="col-md-3">
                            <select id="st_iddetalhe" onclick="selectTipoItem()" disabled="true" name="st_iddetalhe" class="form-control">
                                <option value="{{$item->st_iddetalhe}}">Selecione a Coluna</option>
                                @if(isset($itensdetalhe)&& count($itensdetalhe)>0)
                                @foreach($itensdetalhe as $de)                               
                                <option value="{{$de->id}}">{{$de->st_nome}}</option>
                                @endforeach
                                @endif
                            </select>

                            @if ($errors->has('st_iddetalhe'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_iddetalhe') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }}">
                        <label for="st_nome" class="col-md-2 control-label">Nome</label>

                        <div class="col-md-6">
                            <input id="nome" type="text" class="form-control" required="true" placeholder="Nome" name="st_nome" value="{{$item->st_nome}}"> 
                                @if ($errors->has('st_nome'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_nome') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('nu_sequencia_form') ? ' has-error' : '' }}">
                        <label for="nu_sequencia_form" class="col-md-2 control-label">Número de Sequência do Form</label>

                        <div class="col-md-6">
                            <input id="nu_sequencia_form" type="text" class="form-control" placeholder="Número de Sequência do Form" name="nu_sequencia_form" value="{{$item->nu_sequencia_form}}"> 
                                @if ($errors->has('nu_sequencia_form'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nu_sequencia_form') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('nu_sequencia_impressao') ? ' has-error' : '' }}">
                        <label for="nu_sequencia_impressao" class="col-md-2 control-label">Número de Sequência da Impressão</label>

                        <div class="col-md-6">
                            <input id="nu_sequencia_impressao" type="text" class="form-control" placeholder="Número de Sequência da Impressão" name="nu_sequencia_impressao" value="{{$item->nu_sequencia_impressao}}"> 
                                @if ($errors->has('nu_sequencia_impressao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nu_sequencia_impressao') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('bo_obrigatorio') ? ' has-error' : '' }}">
                        <label for="bo_obrigatorio" class="col-md-2 control-label">Obrigatório</label>

                        <div class="col-md-3">
                            <select name="bo_obrigatorio" class="form-control">
                                <option value="{{$item->bo_obrigatorio}}">{{$item->bo_obrigatorio}}</option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select> 
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_valorfixo') ? ' has-error' : '' }}">
                        <label for="st_valorfixo" class="col-md-2 control-label">Valor Fixo</label>

                        <div class="col-md-6">
                            <input id="st_valorfixo" type="text" class="form-control" placeholder="Valor Fixo" name="st_valorfixo" value="{{$item->st_valorfixo}}"> 
                                @if ($errors->has('st_valorfixo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_valorfixo') }}</strong>
                                </span>
                                @endif
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-md-2  col-md-offset-4">
                            <a href='{{ url("rh/itens")}}' class=" btn btn-danger"  title="Voltar">
                                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                            </a>
                        </div>
                        <button type="submit" class="col-md-2 btn btn-primary">
                            <i class="fa fa-check"> </i> Salvar
                        </button>
                    </div>


                </form>
                
                
            </div>
        </div>
</div>
@stop