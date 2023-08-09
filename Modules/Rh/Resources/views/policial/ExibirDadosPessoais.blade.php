@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Consultar Policial')
@section('tabcontent')
<div class="tab-pane active" id="dados_pessoais">
    <h4 class="tab-title">Dados Pessoais - {{ $policial->st_nome}}</h4>
    <hr class="separador">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Identificação</legend>
    
            <div class="row">
                <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }} col-md-4">
                    <label for="st_nome">Nome</label>
                    <input id="st_nome" type="text" class="form-control" disabled='true' placeholder="Digite o nome" name="st_nome" value="{{ $policial->st_nome }}" required> 
                    @if ($errors->has('st_nome'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_nome') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_nascimento" class="control-label">Data de Nascimento</label>
                    <input id="dt_nascimento" type="date" disabled='true' class="form-control" name="dt_nascimento" value="{{ $policial->dt_nascimento }}" required> 
                    @if ($errors->has('dt_nascimento'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_nascimento') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_sexo') ? ' has-error' : '' }} col-md-1">
                    <label for="st_sexo" class="control-label">Sexo</label>
                    <div class="radio">
                        <label class="radio-option">
                            <input type="radio" name="st_sexo" id="st_sexo" disabled='true' value="MASCULINO" {{ ($policial->st_sexo == 'MASCULINO') ? 'checked':'' }} required>
                            Masculino
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="st_sexo" id="st_sexo" disabled='true' value="FEMININO" {{ ($policial->st_sexo == 'FEMININO') ? 'checked':'' }} required>
                            Feminino
                        </label>
                    </div>
                    @if ($errors->has('st_sexo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_sexo') }}</strong>
                    </span>
                    @endif
                </div>  

                <div class="form-group{{ $errors->has('st_tiposanguineo') ? ' has-error' : '' }} col-md-2">
                    <label for="st_tiposanguineo" class="control-label">Tipo Sanguíneo</label>
                    <select id="st_tiposanguineo" disabled='true' name="st_tiposanguineo" class="form-control">
                        <option value=""  selected>Selecione</option>
                        <option value="A" {{ ($policial->st_tiposanguineo == "A") ? 'selected': '' }}>A</option>                        
                        <option value="B" {{ ($policial->st_tiposanguineo == "B") ? 'selected': '' }}>B</option>
                        <option value="AB" {{ ($policial->st_tiposanguineo == "AB") ? 'selected': '' }}>AB</option>
                        <option value="O" {{ ($policial->st_tiposanguineo == "O") ? 'selected': '' }}>O</option>
                    </select>
                    @if ($errors->has('st_tiposanguineo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tiposanguineo') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_fatorrh') ? ' has-error' : '' }} col-md-1">
                    <label for="st_fatorrh" class="control-label">Fator RH</label>
                    <select id="st_fatorrh" disabled='true' name="st_fatorrh" class="form-control">
                        <option value=""  selected>Selecione</option>
                        <option value="+" {{ ($policial->st_fatorrh == "+") ? 'selected': '' }}>+</option>
                        <option value="-" {{ ($policial->st_fatorrh == "-") ? 'selected': '' }}>-</option>  
                    </select>
                    @if ($errors->has('st_fatorrh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_fatorrh') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('bo_vivo') ? ' has-error' : '' }} col-md-2">
                    <label for="bo_vivo" class="control-label">Vivo</label>
                    @if($policial->bo_ativo == '1')
                    <input id="bo_vivo" type="text" class="form-control" name="bo_vivo" value="SIM" disabled> 
                    @else
                    <input id="bo_vivo" type="text" class="form-control" name="bo_vivo" value="NÃO" disabled>
                    @endif
                    @if ($errors->has('bo_vivo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bo_vivo') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

         
            <div class="row">
                <div class="form-group{{ $errors->has('st_naturalidade') ? ' has-error' : '' }} col-md-2">
                    <label for="st_naturalidade" class="control-label">Naturalidade</label>
                    <input id="st_naturalidade" disabled='true' type="text" class="form-control" placeholder="Ex: Natal" name="st_naturalidade" value="{{ $policial->st_naturalidade }}"> 
                    @if ($errors->has('st_naturalidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_naturalidade') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_ufnaturalidade') ? ' has-error' : '' }} col-md-2">
                    <label for="st_ufnaturalidade" class="control-label">UF</label>
                    <select id="st_ufnaturalidade" name="st_ufnaturalidade" disabled='true' class="form-control">
                        <option value="">Selecione</option>
                        <option {{ $policial->st_ufnaturalidade == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $policial->st_ufnaturalidade == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $policial->st_ufnaturalidade == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $policial->st_ufnaturalidade == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $policial->st_ufnaturalidade == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $policial->st_ufnaturalidade == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $policial->st_ufnaturalidade == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $policial->st_ufnaturalidade == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $policial->st_ufnaturalidade == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $policial->st_ufnaturalidade == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $policial->st_ufnaturalidade == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $policial->st_ufnaturalidade == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $policial->st_ufnaturalidade == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $policial->st_ufnaturalidade == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $policial->st_ufnaturalidade == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $policial->st_ufnaturalidade == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $policial->st_ufnaturalidade == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $policial->st_ufnaturalidade == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $policial->st_ufnaturalidade == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $policial->st_ufnaturalidade == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $policial->st_ufnaturalidade == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $policial->st_ufnaturalidade == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $policial->st_ufnaturalidade == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $policial->st_ufnaturalidade == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $policial->st_ufnaturalidade == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $policial->st_ufnaturalidade == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $policial->st_ufnaturalidade == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_ufnaturalidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_ufnaturalidade') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_mae') ? ' has-error' : '' }} col-md-4">
                    <label for="st_mae" class="control-label">Filiação (Mãe)</label>
                    <input id="st_mae" type="text" disabled='true' class="form-control" placeholder="Digite  o nome da mãe" name="st_mae" value="{{ $policial->st_mae }}"> 
                    @if ($errors->has('st_mae'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_mae') }}</strong>
                    </span>
                    @endif
                </div>                
                <div class="form-group{{ $errors->has('st_pai') ? ' has-error' : '' }} col-md-4">
                    <label for="st_pai" class="control-label">Filiação (Pai)</label>
                    <input id="st_pai" type="text" disabled='true' class="form-control" placeholder="Digite o nome do pai" name="st_pai" value="{{ $policial->st_pai }}"> 
                    @if ($errors->has('st_pai'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_pai') }}</strong>
                    </span>
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="form-group{{ $errors->has('st_altura') ? ' has-error' : '' }} col-md-1">
                    <label for="st_altura" class="control-label">Altura</label>
                    <input id="st_altura" type="text" disabled='true' class="form-control" name="st_altura" value="{{ $policial->st_altura }}" readonly> 
                    @if ($errors->has('st_altura'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_altura') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_cor') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cutis" class="control-label">Cutis</label>
                    <input id="st_cutis" type="text" disabled='true' class="form-control" name="st_cutis" value="{{ $policial->st_cutis }}"readonly> 
                    @if ($errors->has('st_cor'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cutis') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_olhos') ? ' has-error' : '' }} col-md-2">
                    <label for="st_olhos" class="control-label">Olhos</label>
                    <input id="st_olhos" type="text"  disabled='true'class="form-control" name="st_olhos" value="{{ $policial->st_olhos }}"readonly> 
                    @if ($errors->has('st_olhos'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_olhos') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_cabelo') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cabelo" class="control-label">Cabelos</label>
                    <input id="st_cabelo" type="text" disabled='true' class="form-control" name="st_cabelo" value="{{ $policial->st_cabelo }}"readonly> 
                    @if ($errors->has('st_cabelo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cabelo') }}</strong>
                    </span>
                    @endif
                </div>                        
            </div>
            
            <div class="row">
                <div class="form-group{{ $errors->has('st_estadocivil') ? ' has-error' : '' }} col-md-2">
                    <label for="st_estadocivil" disabled='true' class="control-label">Estado Civil</label>
                    <select id="st_estadocivil" name="st_estadocivil" class="form-control" required disabled>
                        <option value=""  selected>Selecione</option>
                        <option value="Solteiro" {{ $policial->st_estadocivil == 'Solteiro' ? 'selected':''}}>Solteiro(a)</option>
                        <option value="Casado" {{ $policial->st_estadocivil == 'Casado' ? 'selected':''}}>Casado(a)</option>
                        <option value="Viúvo" {{ $policial->st_estadocivil == 'Viúvo' ? 'selected':''}}>Viúvo(a)</option>
                        <option value="Divorciado" {{ $policial->st_estadocivil == 'Divorciado' ? 'selected':''}}>Divorciado(a)</option>
                        <option value="União Estável" {{ $policial->st_estadocivil == 'União Estável' ? 'selected':''}}>União Estável</option>
                        <option value="Outro" {{ $policial->st_estadocivil == 'Outro' ? 'selected':''}}>Outro</option>
                    </select>
                    @if ($errors->has('st_estadocivil'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_estadocivil') }}</strong>
                    </span>
                    @endif
                </div>               
                    <div class="form-group{{ $errors->has('st_conjuge') ? ' has-error' : '' }} col-md-5" id="divConjuge">
                        <label for="st_conjuge"  class="control-label">Cônjuge</label>
                        <input id="st_conjuge" type="text" disabled='true' class="form-control" placeholder="Digite  o nome do cônjuge" name="st_conjuge" value="{{ $policial->st_conjuge }}"> 
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
                    <input id="st_cep" disabled='true' type="text" class="form-control" placeholder="Ex: 00000-000" name="st_cep" value="{{ $policial->st_cep }}"> 
                    @if ($errors->has('st_cep'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cep') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_endereco') ? ' has-error' : '' }} col-md-5">
                    <label for="st_endereco">Logradouro</label>
                    <input id="st_endereco" disabled='true' type="text" class="form-control" placeholder="Digite sua rua, avenida ou travessa" name="st_endereco" value="{{ $policial->st_endereco }}"> 
                    @if ($errors->has('st_endereco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_endereco') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_numeroresidencia') ? ' has-error' : '' }} col-md-2">
                    <label for="st_numeroresidencia" >Número</label>
                    <input id="st_numeroresidencia" disabled='true' type="text" class="form-control" placeholder="Ex: 12" name="st_numeroresidencia" value="{{ $policial->st_numeroresidencia }}"> 
                    @if ($errors->has('st_numeroresidencia'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_numeroresidencia') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_bairro') ? ' has-error' : '' }} col-md-3">
                    <label for="st_bairro" >Bairro</label>
                    <input id="st_bairro" disabled='true' type="text" class="form-control" placeholder="Digite seu bairro" name="st_bairro" value="{{ $policial->st_bairro }}"> 
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
                    <input id="st_cidade" disabled='true' type="text" class="form-control" placeholder="Digite sua cidade" name="st_cidade" value="{{ $policial->st_cidade }}"> 
                    @if ($errors->has('st_cidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cidade') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_ufendereco') ? ' has-error' : '' }} col-md-2">
                    <label for="st_ufendereco" class="control-label">UF</label>
                    <select id="st_ufendereco" disabled='true' name="st_ufendereco" class="form-control">
                        <option value="">Selecione</option>
                        <option {{ $policial->st_ufendereco == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $policial->st_ufendereco == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $policial->st_ufendereco == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $policial->st_ufendereco == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $policial->st_ufendereco == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $policial->st_ufendereco == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $policial->st_ufendereco == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $policial->st_ufendereco == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $policial->st_ufendereco == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $policial->st_ufendereco == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $policial->st_ufendereco == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $policial->st_ufendereco == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $policial->st_ufendereco == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $policial->st_ufendereco == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $policial->st_ufendereco == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $policial->st_ufendereco == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $policial->st_ufendereco == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $policial->st_ufendereco == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $policial->st_ufendereco == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $policial->st_ufendereco == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $policial->st_ufendereco == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $policial->st_ufendereco == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $policial->st_ufendereco == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $policial->st_ufendereco == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $policial->st_ufendereco == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $policial->st_ufendereco == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $policial->st_ufendereco == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_ufendereco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_ufendereco') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_complemento') ? ' has-error' : '' }} col-md-6">
                    <label for="st_complemento" >Complemento</label>
                    <input id="st_complemento" disabled='true' type="text" class="form-control" placeholder="Digite o complemento" name="st_complemento" value="{{ $policial->st_complemento }}"> 
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
                <div class="form-group{{ $errors->has('st_telefonefixo') ? ' has-error' : '' }} col-md-2">
                    <label for="st_telefonefixo" >Telefone Residencial</label>
                    <input id="st_telefonefixo" disabled='true' type="text" class="form-control" placeholder="Digite seu telefone" name="st_telefonefixo" value="{{ $policial->st_telefonefixo }}"> 
                    @if ($errors->has('st_telefoneresidencial'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_telefonefixo') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_telefonecelular') ? ' has-error' : '' }} col-md-2">
                    <label for="st_telefonecelular" >Telefone Celular</label>
                    <input id="st_telefonecelular" disabled='true' type="text" class="form-control" placeholder="Digite seu celular" name="st_telefonecelular" value="{{ $policial->st_telefonecelular }}"> 
                    @if ($errors->has('st_telefonecelular'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_telefonecelular') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_email') ? ' has-error' : '' }} col-md-5">
                    <label for="st_email" >Email</label>
                    <input id="st_email" disabled='true' type="text" class="form-control" placeholder="Digite seu email" name="st_email" value="{{ $policial->st_email }}"> 
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
                    <label for="st_codigobanco">Código do Banco</label>
                    <input id="st_codigobanco" disabled='true' type="text" class="form-control" placeholder="Ex: 001" name="st_codigobanco" value="{{ $policial->st_codigobanco }}"> 
                    @if ($errors->has('st_codigobanco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_codigobanco') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_banco') ? ' has-error' : '' }} col-md-5">
                    <label for="st_banco">Nome do Banco</label>
                    <input id="st_banco" disabled='true' type="text" class="form-control" placeholder="Ex: Caixa, Banco do Brasil..." name="st_banco" value="{{ $policial->st_banco }}"> 
                    @if ($errors->has('st_banco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_banco') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_agencia') ? ' has-error' : '' }} col-md-2">
                    <label for="st_agencia">Agência</label>
                    <input id="st_agencia" disabled='true' type="text" class="form-control" placeholder="Ex: 000" name="st_agencia" value="{{ $policial->st_agencia }}"> 
                    @if ($errors->has('st_agencia'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_agencia') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_conta') ? ' has-error' : '' }} col-md-2">
                    <label for="st_conta" class="control-label">Conta Corrente</label>
                    <input id="st_conta" disabled='true' type="text" class="form-control" placeholder="Ex: 000000" name="st_conta" value="{{ $policial->st_conta }}"> 
                    @if ($errors->has('st_conta'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_conta') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>

        <div class="row">
            <div class="form-group ">                
                <a href='{{url("/")}}' class="col-md-1 btn btn-warning">
                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                </a>                
                                         
            </div>
        </div>
            
</div>
<!-- /.tab-pane -->
@endsection