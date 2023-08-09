@extends('adminlte::page')

@section('title', 'Detalhes da Unidade')


@section('content')        
    <div class="panel panel-primary">           
        <div class="panel-heading"><strong>INFORMAÇÕES SOBRE A UNIDADE</strong></div>
        <div class="panel-body">
            <fieldset class="scheduler-border">   
                <legend class="scheduler-border">Informações Gerais</legend>
                                        
                    <div class="row">
                        <div class="form-group{{ $errors->has('st_nomepais') ? ' has-error' : '' }} col-md-8">
                            <label for="st_nomepais">Hierarquia do Organograma</label>
                            <input id="st_nomepais" type="text" class="form-control" disabled='true' placeholder="Não informado" name="st_nomepais" value="{{$unidade->st_nomepais}}" required> 
                            @if ($errors->has('st_nomepais'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_nomepais') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('st_sigla') ? ' has-error' : '' }} col-md-4">
                            <label for="st_sigla">Sigla</label>
                            <input id="st_sigla" type="text" class="form-control"  disabled='true' placeholder="Não informado" name="st_sigla" value="{{$unidade->st_sigla}}" required> 
                            @if ($errors->has('st_sigla'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_sigla') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group{{ $errors->has('st_descricao') ? ' has-error' : '' }} col-md-7">
                            <label for="st_descricao">Descrição</label>
                            <input id="st_descricao" type="text" class="form-control"  disabled='true' placeholder="Não informado" name="st_descricao" value="{{$unidade->st_descricao}}" required> 
                            @if ($errors->has('st_descricao'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_descricao') }}</strong>
                            </span>
                            @endif
                        </div>

                        @php 
                        $estado = env('MANUTENCAO_SISTEMA');
                        @endphp

                        @if($estado=='MANUTENCAO')
                            <div class="form-group{{ $errors->has('bo_organogramanovo') ? ' has-error' : '' }}">
                                <label for="bo_organogramanovo" class="col-md-2 control-label">Novo Organograma:</label>
                                <div class="col-md-7">
                                    <select class='form-control'  disabled='true' name='bo_organogramanovo' id='bo_organogramanovo'>
                                    <option value=""> -- Selecionar -- </option>
                                        <option {{$unidade->bo_organogramanovo == '1' ? 'selected' : ''}} value="1">Sim</option>
                                        <option {{$unidade->bo_organogramanovo == '0' ? 'selected' : ''}} value="0">Não</option>
                                    </select>
                                    @if ($errors->has('bo_organogramanovo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bo_organogramanovo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('bo_corrigido') ? ' has-error' : '' }}">
                                <label for="bo_corrigido" class="col-md-2 control-label">Corrigido:</label>
                                <div class="col-md-7">
                                    <select class='form-control' disabled='true'  name='bo_corrigido' id='bo_corrigido'>
                                    <option value=""> -- Selecionar -- </option>
                                        <option {{$unidade->bo_corrigido == '1' ? 'selected' : ''}} value="1">Sim</option>
                                        <option {{$unidade->bo_corrigido == '0' ? 'selected' : ''}} value="0">Não</option>
                                    </select>
                                    @if ($errors->has('bo_corrigido'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bo_corrigido') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }} col-md-5">
                            <label for="st_tipo">Tipo de Unidade</label>
                            
                            <select class='form-control' name='st_tipo' disabled='true' id='st_tipo' >
                                @if($unidade->st_tipo == null)
                                    @php
                                        $unidade->st_tipo = 'Não informado'
                                    @endphp
                                @endif
                                
                                <option value="{{$unidade->id}}" {{($unidade->id) == ($unidade->st_tipo) ? 'selected' : ''}}>{{$unidade->st_tipo}}</option>
                                <option {{$unidade->st_tipo == 'COMANDO GERAL' ? 'selected' : ''}} value="COMANDO GERAL">Comando Geral</option>                                        
                                <option {{$unidade->st_tipo == 'GRANDE COMANDO' ? 'selected' : ''}} value="GRANDE COMANDO">Grande Comando</option>                                        
                                <option {{$unidade->st_tipo == 'COMANDO REGIONAL' ? 'selected' : ''}} value="COMANDO REGIONAL">Comando Regional</option>                                        
                                <option {{$unidade->st_tipo == 'BATALHAO' ? 'selected' : ''}} value="BATALHAO">Batalhão</option>                                        
                                <option {{$unidade->st_tipo == 'CIA INDEPENDENTE' ? 'selected' : ''}} value="CIA INDEPENDENTE">Cia Independente</option>                                        
                                <option {{$unidade->st_tipo == 'CIA' ? 'selected' : ''}} value="CIA">Cia</option>                                        
                                <option {{$unidade->st_tipo == 'PELOTAO' ? 'selected' : ''}} value="PELOTAO">Pelotão</option>                                        
                                <option {{$unidade->st_tipo == 'DESTACAMENTO' ? 'selected' : ''}} value="DESTACAMENTO">Destacamento</option>                                        
                                <option {{$unidade->st_tipo == 'DISTRITO' ? 'selected' : ''}} value="DISTRITO">Distrito</option>                                        
                                <option {{$unidade->st_tipo == 'GRUPO' ? 'selected' : ''}} value="GRUPO">Grupo</option>                                        
                                <option {{$unidade->st_tipo == 'ORGAO EXTERNO' ? 'selected' : ''}} value="ORGAO EXTERNO">Orgao Externo</option>                                        
                                <option {{$unidade->st_tipo == 'SETOR' ? 'selected' : ''}} value="SETOR">Setor</option>                                        
                            </select>
                            @if ($errors->has('st_tipo'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_tipo') }}</strong>
                            </span>
                            @endif
                        
                        </div> 

                        
                    </div>
                    <div class="row">
                        


                        <div class="form-group{{ $errors->has('bo_ativo') ? ' has-error' : '' }} col-md-4">
                            <label for="bo_ativo" class="control-label">Ativo</label>
                            
                                    <select class='form-control' disabled='true' name='bo_ativo' id='bo_ativo' required>
                                    <option value=""> --  Selecionar  -- </option>
                                        <option {{$unidade->bo_ativo == '1' ? 'selected' : ''}} value="1">Sim</option>
                                        <option {{$unidade->bo_ativo == '0' ? 'selected' : ''}} value="0">Não</option>
                                    </select>
                                    @if ($errors->has('bo_ativo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bo_ativo') }}</strong>
                                    </span>
                                    @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('bo_organograma') ? ' has-error' : '' }} col-md-4">
                            <label for="bo_organograma" class="control-label">Organograma</label>
                            
                            <select class='form-control' disabled='true'  name='bo_organograma' id='bo_organograma' required>
                            <option value=""> -- Selecionar -- </option>
                                <option {{$unidade->bo_organograma == '1' ? 'selected' : ''}} value="1">Sim</option>
                                <option {{$unidade->bo_organograma == '0' ? 'selected' : ''}} value="0">Não</option>
                            </select>
                            @if ($errors->has('bo_organograma'))
                            <span class="help-block">
                                <strong>{{ $errors->first('bo_organograma') }}</strong>
                            </span>
                            @endif
                            
                        </div>

                        <div class="form-group hidden{{ $errors->has('st_arvore') ? ' has-error' : '' }}">
                            <label for="st_arvore" class="col-md-2 control-label">Árvore:</label>

                            <div class="col-md-10">
                                <input class='form-control' disabled='true' type='text' name='st_arvore' id='st_arvore' disabled value="{{$unidade->st_tipo}}">                                    
                                @if ($errors->has('st_arvore'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_arvore') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>                                    
            </fieldset>  

            <fieldset  class="scheduler-border">
                <legend class="scheduler-border">Informações Adicionais</legend>       
                <div class="row">
                    <div class="form-group{{ $errors->has('st_comandante') ? ' has-error' : '' }} col-md-6">
                        <label for="st_comandante">Comandante da Unidade:</label>
                        <input id="st_comandante" type="text" class="form-control" disabled='true' placeholder="Não informado" name="st_comandante" value="{{$unidade->st_comandante}}"  > 
                        @if ($errors->has('st_comandante'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_comandante') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('st_sigla') ? ' has-error' : '' }} col-md-6">
                        <label for="st_subcomandante">SubComandante da Unidade</label>
                        <input id="st_subcomandante" type="text" class="form-control" disabled='true'  placeholder="Não informado" name="st_subcomandante" value="{{$unidade->st_subcomandante}}" > 
                        @if ($errors->has('st_subcomandante'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_subcomandante') }}</strong>
                        </span>
                        @endif
                    </div>                   
                </div>
                <div class="row">
                    

                    <div class="form-group{{ $errors->has('st_logradouro') ? ' has-error' : '' }} col-md-4">
                        <label for="st_logradouro">Logradouro</label>
                        <input id="st_logradouro" type="text" class="form-control"  disabled='true' placeholder="Não informado" name="st_logradouro" value="{{$unidade->st_logradouro}}"  > 
                        @if ($errors->has('st_logradouro'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_logradouro') }}</strong>
                        </span>
                        @endif
                    </div>

                        <div class="form-group{{ $errors->has('st_numero') ? ' has-error' : '' }} col-md-2">
                        <label for="st_numero">Número</label>
                        <input id="st_numero" type="text" class="form-control" disabled='true' placeholder="Não informado" name="st_numero" value="{{$unidade->st_numero}}"  > 
                        @if ($errors->has('st_numero'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_numero') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('st_bairro') ? ' has-error' : '' }} col-md-6">
                        <label for="st_bairro">Bairro</label>
                        <input id="st_bairro" type="text" class="form-control" disabled='true' placeholder="Não informado" name="st_bairro" value="{{$unidade->st_bairro}}"  > 
                        @if ($errors->has('st_bairro'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_bairro') }}</strong>
                        </span>
                        @endif
                    </div>

                        
                </div>

                <div class="row">

                    <div class="form-group{{ $errors->has('st_complemento') ? ' has-error' : '' }} col-md-5">
                        <label for="st_complemento">Complemento</label>
                        <input id="st_complemento" type="text" class="form-control" disabled='true'  placeholder="Não informado" name="st_complemento" value="{{$unidade->st_complemento}}"  > 
                        @if ($errors->has('st_complemento'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_complemento') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('st_cidade') ? ' has-error' : '' }} col-md-4">
                        <label for="st_cidade">Cidade</label>
                        <input id="st_cidade" type="text" class="form-control" disabled='true' placeholder="Não informado" name="st_cidade" value="{{$unidade->st_cidade}}" > 
                        @if ($errors->has('st_cidade'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_cidade') }}</strong>
                        </span>
                        @endif
                    </div>
                    

                        <div class="form-group{{ $errors->has('st_cep') ? ' has-error' : '' }} col-md-2">
                        <label for="st_cep">Cep</label>
                        <input id="st_cep" type="text" class="form-control" disabled='true'  placeholder="Não informado" data-mask="00000-000" name="st_cep" value="{{$unidade->st_cep}}"  > 
                        @if ($errors->has('st_cep'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_cep') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="row">

                    <div class="form-group{{ $errors->has('st_latitude') ? ' has-error' : '' }} col-md-6">
                        <label for="st_latitude">Latitude</label>
                        <input id="st_latitude" type="text" class="form-control" disabled='true' placeholder="Não informado" name="st_latitude" value="{{$unidade->st_latitude}}" > 
                        @if ($errors->has('st_latitude'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_latitude') }}</strong>
                        </span>
                        @endif
                    </div>
    
                    <div class="form-group{{ $errors->has('st_longitude') ? ' has-error' : '' }} col-md-6">
                        <label for="st_longitude" class="control-label">Longitude</label>
                        <input id="st_longitude" type="text" class="form-control" disabled='true' placeholder="Não informado" name="st_longitude" value="{{$unidade->st_longitude}}" >
                        @if ($errors->has('st_longitude'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_longitude') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group{{ $errors->has('st_site') ? ' has-error' : '' }} col-md-4">
                        <label for="st_site" class="control-label">Site da Unidade</label>
                        <input id="st_site" type="text" class="form-control" disabled='true' placeholder="https://pm.rn.gov.br" name="st_site" value="{{$unidade->st_site}}" >
                        
                        @if ($errors->has('st_site'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_site') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('st_email') ? ' has-error' : '' }} col-md-4">
                        <label for="st_email" class="control-label">Email da Unidade</label>
                        <input id="st_email" type="email" id="email" class="form-control" disabled='true' maxlength="50" placeholder="algo@exemplo.com" name="st_email" value="{{$unidade->st_email}}" >
                        
                        @if ($errors->has('st_email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_email') }}</strong>
                        </span>
                        @endif
                        
                    </div>

                    <div class="form-group{{ $errors->has('st_contato') ? ' has-error' : '' }} col-md-4">
                        <label for="st_contato">Contato da Unidade:</label>
                        <input id="st_contato" type="text" class="form-control" disabled='true' data-mask="0000-0000" placeholder="0000-0000" name="st_contato" value="{{$unidade->st_contato}}" > 
                        @if ($errors->has('st_contato'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_contato') }}</strong>
                        </span>
                        @endif
                    </div>

                    


            </fieldset>


            <div class="form-group ">
                <div class=" ">                               
                    <a  href="{{url('admin/unidades')}}" class="btn btn-warning"  title="Voltar">
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </a>
                </div>
            </div>                            
        </div>
    </div>
        
 
            
    

@stop