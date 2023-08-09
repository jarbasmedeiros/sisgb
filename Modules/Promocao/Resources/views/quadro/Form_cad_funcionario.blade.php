@extends('adminlte::page')

@section('title', 'Cadastro de Servidor')

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
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Cadastro de Servidor</div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{ url('/rh/servidor') }}">
                        {{ csrf_field() }}
                        <fieldset class="scheduler-border">    	
					        <legend class="scheduler-border">Identificação</legend>
					
                            <div class="row">
                                <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_cpf" >CPF</label>
                                    <input id="st_cpf" type="text" class="form-control" placeholder="Ex: 000.000.000-00" name="st_cpf" value="{{ old('st_cpf') }}" required> 
                                    @if ($errors->has('st_cpf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_cpf') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }} col-md-6">
                                    <label for="st_nome" >Nome</label>
                                    <input id="st_nome" type="text" class="form-control" placeholder="Digite o nome" name="st_nome" value="{{ old('st_nome') }}" required> 
                                    @if ($errors->has('st_nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_nome') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }} col-md-3">
                                    <label for="dt_nascimento" class="control-label">Data de Nascimento</label>
                                    <input id="dt_nascimento" type="date" class="form-control" name="dt_nascimento" value="{{ old('dt_nascimento') }}"> 
                                    @if ($errors->has('dt_nascimento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dt_nascimento') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group{{ $errors->has('st_nacionalidade') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_nacionalidade" class="control-label">Nacionalidade</label>
                                    <input id="st_nacionalidade" type="text" class="form-control" placeholder="Ex: Brasileira" name="st_nacionalidade" value="{{ old('st_nacionalidade') }}"> 
                                    @if ($errors->has('st_nacionalidade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_nacionalidade') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('st_naturalidade') ? ' has-error' : '' }} col-md-3">
                                    <label for="st_naturalidade" class="control-label">Naturalidade</label>
                                    <input id="st_naturalidade" type="text" class="form-control" placeholder="Ex: Natal" name="st_naturalidade" value="{{ old('st_naturalidade') }}"> 
                                    @if ($errors->has('st_naturalidade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_naturalidade') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('st_ufnaturalidade') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_ufnaturalidade" class="control-label">UF</label>
                                    <select id="st_ufnaturalidade" name="st_ufnaturalidade" class="form-control">
                                        <option value="">Selecione</option>
                                        <option {{ old('st_ufnaturalidade') == 'AC' ? 'selected':''}} value="AC">AC</option>
                                        <option {{ old('st_ufnaturalidade') == 'AL' ? 'selected':''}} value="AL">AL</option>
                                        <option {{ old('st_ufnaturalidade') == 'AP' ? 'selected':''}} value="AP">AP</option>
                                        <option {{ old('st_ufnaturalidade') == 'AM' ? 'selected':''}} value="AM">AM</option>
                                        <option {{ old('st_ufnaturalidade') == 'BA' ? 'selected':''}} value="BA">BA</option>
                                        <option {{ old('st_ufnaturalidade') == 'CE' ? 'selected':''}} value="CE">CE</option>
                                        <option {{ old('st_ufnaturalidade') == 'DF' ? 'selected':''}} value="DF">DF</option>
                                        <option {{ old('st_ufnaturalidade') == 'ES' ? 'selected':''}} value="ES">ES</option>
                                        <option {{ old('st_ufnaturalidade') == 'GO' ? 'selected':''}} value="GO">GO</option>
                                        <option {{ old('st_ufnaturalidade') == 'MA' ? 'selected':''}} value="MA">MA</option>
                                        <option {{ old('st_ufnaturalidade') == 'MT' ? 'selected':''}} value="MT">MT</option>
                                        <option {{ old('st_ufnaturalidade') == 'MS' ? 'selected':''}} value="MS">MS</option>
                                        <option {{ old('st_ufnaturalidade') == 'MG' ? 'selected':''}} value="MG">MG</option>
                                        <option {{ old('st_ufnaturalidade') == 'PA' ? 'selected':''}} value="PA">PA</option>
                                        <option {{ old('st_ufnaturalidade') == 'PB' ? 'selected':''}} value="PB">PB</option>
                                        <option {{ old('st_ufnaturalidade') == 'PR' ? 'selected':''}} value="PR">PR</option>
                                        <option {{ old('st_ufnaturalidade') == 'PE' ? 'selected':''}} value="PE">PE</option>
                                        <option {{ old('st_ufnaturalidade') == 'PI' ? 'selected':''}} value="PI">PI</option>
                                        <option {{ old('st_ufnaturalidade') == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                                        <option {{ old('st_ufnaturalidade') == 'RN' ? 'selected':''}} value="RN">RN</option>
                                        <option {{ old('st_ufnaturalidade') == 'RS' ? 'selected':''}} value="RS">RS</option>
                                        <option {{ old('st_ufnaturalidade') == 'RO' ? 'selected':''}} value="RO">RO</option>
                                        <option {{ old('st_ufnaturalidade') == 'RR' ? 'selected':''}} value="RR">RR</option>
                                        <option {{ old('st_ufnaturalidade') == 'SC' ? 'selected':''}} value="SC">SC</option>
                                        <option {{ old('st_ufnaturalidade') == 'SP' ? 'selected':''}} value="SP">SP</option>
                                        <option {{ old('st_ufnaturalidade') == 'SE' ? 'selected':''}} value="SE">SE</option>
                                        <option {{ old('st_ufnaturalidade') == 'TO' ? 'selected':''}} value="TO">TO</option>
                                    </select>
                                    @if ($errors->has('st_ufnaturalidade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_ufnaturalidade') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('st_tiposanguineo') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_tiposanguineo" class="control-label">Tipo Sanguíneo</label>
                                    <select id="st_tiposanguineo" name="st_tiposanguineo" class="form-control">
                                        <option value=""  selected>Selecione</option>
                                        <option value="A+" {{ ( old('st_tiposanguineo') == "A+") ? 'selected': '' }}>A+</option>
                                        <option value="A-" {{ ( old('st_tiposanguineo') == "A-") ? 'selected': '' }}>A-</option>
                                        <option value="B+" {{ ( old('st_tiposanguineo') == "B+") ? 'selected': '' }}>B+</option>
                                        <option value="B-" {{ ( old('st_tiposanguineo') == "B-") ? 'selected': '' }}>B-</option>
                                        <option value="AB+" {{ ( old('st_tiposanguineo') == "AB+") ? 'selected': '' }}>AB+</option>
                                        <option value="AB-" {{ ( old('st_tiposanguineo') == "AB-") ? 'selected': '' }}>AB-</option>
                                        <option value="O+" {{ ( old('st_tiposanguineo') == "O+") ? 'selected': '' }}>O+</option>
                                        <option value="O-" {{ ( old('st_tiposanguineo') == "O-") ? 'selected': '' }}>O-</option>
                                    </select>
                                    @if ($errors->has('st_tiposanguineo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_tiposanguineo') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('st_sexo') ? ' has-error' : '' }} col-md-3">
                                    <label for="st_sexo" class="control-label">Sexo</label>
                                    <div class="radio">
                                        <label class="radio-option">
                                            <input type="radio" name="st_sexo" id="st_sexo" value="M" {{ (old('st_sexo') == 'M') ? 'checked':''}}>
                                            Masculino
                                        </label>
                                        <label class="radio-option">
                                            <input type="radio" name="st_sexo" id="st_sexo" value="F" {{ (old('st_sexo') == 'F') ? 'checked':''}}>
                                            Feminino
                                        </label>
                                    </div>
                                    @if ($errors->has('st_sexo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_sexo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group{{ $errors->has('st_estadocivil') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_estadocivil" class="control-label">Estado Civil</label>
                                    <select id="st_estadocivil" name="st_estadocivil" class="form-control" onchange="checkConjuge()" required>
                                        <option value=""  selected>Selecione</option>
                                        <option value="Solteiro">Solteiro(a)</option>
                                        <option value="Casado">Casado(a)</option>
                                        <option value="Viúvo">Viúvo(a)</option>
                                        <option value="Divorciado">Divorciado(a)</option>
                                        <option value="União Estável">União Estável</option>
                                        <option value="Outro">Outro</option>
                                    </select>
                                    @if ($errors->has('st_estadocivil'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_estadocivil') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('st_pai') ? ' has-error' : '' }} col-md-5">
                                    <label for="st_pai" class="control-label">Filiação (Pai)</label>
                                    <input id="st_pai" type="text" class="form-control" placeholder="Digite o nome do pai" name="st_pai" value="{{ old('st_pai') }}"> 
                                    @if ($errors->has('st_pai'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_pai') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('st_mae') ? ' has-error' : '' }} col-md-5">
                                    <label for="st_mae" class="control-label">Filiação (Mãe)</label>
                                    <input id="st_mae" type="text" class="form-control" placeholder="Digite  o nome da mãe" name="st_mae" value="{{ old('st_mae') }}"> 
                                    @if ($errors->has('st_mae'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_mae') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('st_conjuge') ? ' has-error' : '' }} col-md-5" style="display: none" id="divConjuge">
                                    <label for="st_conjuge" class="control-label">Cônjuge</label>
                                    <input id="st_conjuge" type="text" class="form-control" placeholder="Digite  o nome do cônjuge" name="st_conjuge"> 
                                    @if ($errors->has('st_conjuge'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_conjuge') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        
                        <fieldset class="scheduler-border">    	
					        <legend class="scheduler-border">Endereço</legend>
                            <div class="row">
                                <div class="form-group{{ $errors->has('st_cep') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_cep" >CEP</label>
                                    <input id="st_cep" type="text" class="form-control" placeholder="Ex: 00000-000" name="st_cep" value="{{ old('st_cep') }}"> 
                                    @if ($errors->has('st_cep'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_cep') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_logradouro') ? ' has-error' : '' }} col-md-5">
                                    <label for="st_logradouro">Logradouro</label>
                                    <input id="st_logradouro" type="text" class="form-control" placeholder="Digite sua rua, avenida ou travessa" name="st_logradouro" value="{{ old('st_logradouro') }}"> 
                                    @if ($errors->has('st_logradouro'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_logradouro') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_numeroresidencia') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_numeroresidencia" >Número</label>
                                    <input id="st_numeroresidencia" type="text" class="form-control" placeholder="Ex: 12" name="st_numeroresidencia" value="{{ old('st_numeroresidencia') }}"> 
                                    @if ($errors->has('st_numeroresidencia'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_numeroresidencia') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_bairro') ? ' has-error' : '' }} col-md-3">
                                    <label for="st_bairro" >Bairro</label>
                                    <input id="st_bairro" type="text" class="form-control" placeholder="Digite seu bairro" name="st_bairro" value="{{ old('st_bairro') }}"> 
                                    @if ($errors->has('st_bairro'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_bairro') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group{{ $errors->has('st_cidade') ? ' has-error' : '' }} col-md-3">
                                    <label for="st_cidade" >Cidade</label>
                                    <input id="st_cidade" type="text" class="form-control" placeholder="Digite sua cidade" name="st_cidade" value="{{ old('st_cidade') }}"> 
                                    @if ($errors->has('st_cidade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_cidade') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_uf') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_uf" class="control-label">UF</label>
                                    <select id="st_uf" name="st_uf" class="form-control">
                                        <option value="">Selecione</option>
                                        <option {{ old('st_uf') == 'AC' ? 'selected':''}} value="AC">AC</option>
                                        <option {{ old('st_uf') == 'AL' ? 'selected':''}} value="AL">AL</option>
                                        <option {{ old('st_uf') == 'AP' ? 'selected':''}} value="AP">AP</option>
                                        <option {{ old('st_uf') == 'AM' ? 'selected':''}} value="AM">AM</option>
                                        <option {{ old('st_uf') == 'BA' ? 'selected':''}} value="BA">BA</option>
                                        <option {{ old('st_uf') == 'CE' ? 'selected':''}} value="CE">CE</option>
                                        <option {{ old('st_uf') == 'DF' ? 'selected':''}} value="DF">DF</option>
                                        <option {{ old('st_uf') == 'ES' ? 'selected':''}} value="ES">ES</option>
                                        <option {{ old('st_uf') == 'GO' ? 'selected':''}} value="GO">GO</option>
                                        <option {{ old('st_uf') == 'MA' ? 'selected':''}} value="MA">MA</option>
                                        <option {{ old('st_uf') == 'MT' ? 'selected':''}} value="MT">MT</option>
                                        <option {{ old('st_uf') == 'MS' ? 'selected':''}} value="MS">MS</option>
                                        <option {{ old('st_uf') == 'MG' ? 'selected':''}} value="MG">MG</option>
                                        <option {{ old('st_uf') == 'PA' ? 'selected':''}} value="PA">PA</option>
                                        <option {{ old('st_uf') == 'PB' ? 'selected':''}} value="PB">PB</option>
                                        <option {{ old('st_uf') == 'PR' ? 'selected':''}} value="PR">PR</option>
                                        <option {{ old('st_uf') == 'PE' ? 'selected':''}} value="PE">PE</option>
                                        <option {{ old('st_uf') == 'PI' ? 'selected':''}} value="PI">PI</option>
                                        <option {{ old('st_uf') == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                                        <option {{ old('st_uf') == 'RN' ? 'selected':''}} value="RN">RN</option>
                                        <option {{ old('st_uf') == 'RS' ? 'selected':''}} value="RS">RS</option>
                                        <option {{ old('st_uf') == 'RO' ? 'selected':''}} value="RO">RO</option>
                                        <option {{ old('st_uf') == 'RR' ? 'selected':''}} value="RR">RR</option>
                                        <option {{ old('st_uf') == 'SC' ? 'selected':''}} value="SC">SC</option>
                                        <option {{ old('st_uf') == 'SP' ? 'selected':''}} value="SP">SP</option>
                                        <option {{ old('st_uf') == 'SE' ? 'selected':''}} value="SE">SE</option>
                                        <option {{ old('st_uf') == 'TO' ? 'selected':''}} value="TO">TO</option>
                                    </select>
                                    @if ($errors->has('st_uf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_uf') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_complemento') ? ' has-error' : '' }} col-md-6">
                                    <label for="st_complemento" >Complemento</label>
                                    <input id="st_complemento" type="text" class="form-control" placeholder="Digite o complemento" name="st_complemento" value="{{ old('st_complemento') }}"> 
                                    @if ($errors->has('st_complemento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_complemento') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="scheduler-border">    	
					        <legend class="scheduler-border">Contato</legend>
                            <div class="row">
                                <div class="form-group{{ $errors->has('st_telefoneresidencial') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_telefoneresidencial" >Telefone Residencial</label>
                                    <input id="st_telefoneresidencial" type="text" class="form-control" placeholder="Ex: (00) 0000-0000" name="st_telefoneresidencial" value="{{ old('st_telefoneresidencial') }}"> 
                                    @if ($errors->has('st_telefoneresidencial'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_telefoneresidencial') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_telefonecelular') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_telefonecelular" >Telefone Celular</label>
                                    <input id="st_telefonecelular" type="text" class="form-control" placeholder="Ex: (00) 00000-0000" name="st_telefonecelular" value="{{ old('st_telefonecelular') }}"> 
                                    @if ($errors->has('st_telefonecelular'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_telefonecelular') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_email') ? ' has-error' : '' }} col-md-5">
                                    <label for="st_email" >Email</label>
                                    <input id="st_email" type="email" class="form-control" placeholder="Digite seu email" name="st_email" value="{{ old('st_email') }}"> 
                                    @if ($errors->has('st_email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="scheduler-border">    	
					        <legend class="scheduler-border">Dados Bancários</legend>

                            <div class="row">
                                <div class="form-group{{ $errors->has('st_codigobanco') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_codigobanco">Código</label>
                                    <input id="st_codigobanco" type="text" class="form-control" placeholder="Ex: 000" name="st_codigobanco" value="{{ old('st_codigobanco') }}"> 
                                    @if ($errors->has('st_codigobanco'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_codigobanco') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_nomebanco') ? ' has-error' : '' }} col-md-5">
                                    <label for="st_nomebanco">Nome do Banco</label>
                                    <input id="st_nomebanco" type="text" class="form-control" placeholder="Ex: Caixa, Banco do Brasil..." name="st_nomebanco" value="{{ old('st_nomebanco') }}"> 
                                    @if ($errors->has('st_nomebanco'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_nomebanco') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_agencia') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_agencia">Agência</label>
                                    <input id="st_agencia" type="text" class="form-control" placeholder="Ex: 000" name="st_agencia" value="{{ old('st_agencia') }}"> 
                                    @if ($errors->has('st_agencia'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_agencia') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('st_conta') ? ' has-error' : '' }} col-md-2">
                                    <label for="st_conta" class="control-label">Conta Corrente</label>
                                    <input id="st_conta" type="text" class="form-control" placeholder="Ex: 000000" name="st_conta" value="{{ old('st_conta') }}"> 
                                    @if ($errors->has('st_conta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_conta') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group ">
                            <div class="col-md-2  col-md-offset-4">
                                <a href="javascript:history.back()" class=" btn btn-danger"  title="Voltar">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>
                            </div>
                            <button type="submit" class="col-md-2 btn btn-primary">
                                <i class="fa fa-fw fa-file"></i> Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection