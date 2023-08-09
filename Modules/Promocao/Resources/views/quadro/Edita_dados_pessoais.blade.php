@extends('rh::funcionario.Form_edita_funcionario')
@section('title', 'SISGP - Dados Pessoais')
@section('tabcontent')
<div class="tab-pane active" id="dados_pessoais">
    <h4 class="tab-title">Dados Pessoais - {{ strtoupper($servidor->st_nome) }}</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('/rh/servidor/edita/'.$servidor->id) }}">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Identificação</legend>
    
            <div class="row">
                <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }} col-md-5">
                    <label for="st_nome">Nome</label>
                    <input id="st_nome" type="text" class="form-control" placeholder="Digite o nome" name="st_nome" value="{{ $servidor->st_nome }}" required> 
                    @if ($errors->has('st_nome'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_nome') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_nascimento" class="control-label">Data de Nascimento</label>
                    <input id="dt_nascimento" type="date" class="form-control" name="dt_nascimento" value="{{ $servidor->dt_nascimento }}" required> 
                    @if ($errors->has('dt_nascimento'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_nascimento') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_sexo') ? ' has-error' : '' }} col-md-2">
                    <label for="st_sexo" class="control-label">Sexo</label>
                    <div class="radio">
                        <label class="radio-option">
                            <input type="radio" name="st_sexo" id="st_sexo" value="M" {{ ($servidor->st_sexo == 'M') ? 'checked':''}} required>
                            Masculino
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="st_sexo" id="st_sexo" value="F"{{ ($servidor->st_sexo == 'F') ? 'checked':''}}>
                            Feminino
                        </label>
                    </div>
                    @if ($errors->has('st_sexo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_sexo') }}</strong>
                    </span>
                    @endif
                </div>
                @if($servidor->st_caminhofoto)
                    <div class="col-md-2">
                        <img class="" src="{{url( 'rh/imagem/'.$servidor->st_caminhofoto )}}" width='100' height='120'>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="form-group{{ $errors->has('st_nacionalidade') ? ' has-error' : '' }} col-md-2">
                    <label for="st_nacionalidade" class="control-label">Nacionalidade</label>
                    <input id="st_nacionalidade" type="text" class="form-control" placeholder="Ex: Brasileira" name="st_nacionalidade" value="{{ $servidor->st_nacionalidade }}"> 
                    @if ($errors->has('st_nacionalidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_nacionalidade') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_naturalidade') ? ' has-error' : '' }} col-md-3">
                    <label for="st_naturalidade" class="control-label">Naturalidade</label>
                    <input id="st_naturalidade" type="text" class="form-control" placeholder="Ex: Natal" name="st_naturalidade" value="{{ $servidor->st_naturalidade }}"> 
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
                        <option {{ $servidor->st_ufnaturalidade == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $servidor->st_ufnaturalidade == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $servidor->st_ufnaturalidade == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $servidor->st_ufnaturalidade == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $servidor->st_ufnaturalidade == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $servidor->st_ufnaturalidade == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $servidor->st_ufnaturalidade == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $servidor->st_ufnaturalidade == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $servidor->st_ufnaturalidade == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $servidor->st_ufnaturalidade == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $servidor->st_ufnaturalidade == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $servidor->st_ufnaturalidade == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $servidor->st_ufnaturalidade == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $servidor->st_ufnaturalidade == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $servidor->st_ufnaturalidade == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $servidor->st_ufnaturalidade == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $servidor->st_ufnaturalidade == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $servidor->st_ufnaturalidade == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $servidor->st_ufnaturalidade == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $servidor->st_ufnaturalidade == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $servidor->st_ufnaturalidade == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $servidor->st_ufnaturalidade == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $servidor->st_ufnaturalidade == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $servidor->st_ufnaturalidade == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $servidor->st_ufnaturalidade == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $servidor->st_ufnaturalidade == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $servidor->st_ufnaturalidade == 'TO' ? 'selected':''}} value="TO">TO</option>
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
                        <option value="A+" {{ ($servidor->st_tiposanguineo == "A+") ? 'selected': '' }}>A+</option>
                        <option value="A-" {{ ($servidor->st_tiposanguineo == "A-") ? 'selected': '' }}>A-</option>
                        <option value="B+" {{ ($servidor->st_tiposanguineo == "B+") ? 'selected': '' }}>B+</option>
                        <option value="B-" {{ ($servidor->st_tiposanguineo == "B-") ? 'selected': '' }}>B-</option>
                        <option value="AB+" {{ ($servidor->st_tiposanguineo == "AB+") ? 'selected': '' }}>AB+</option>
                        <option value="AB-" {{ ($servidor->st_tiposanguineo == "AB-") ? 'selected': '' }}>AB-</option>
                        <option value="O+" {{ ($servidor->st_tiposanguineo == "O+") ? 'selected': '' }}>O+</option>
                        <option value="O-" {{ ($servidor->st_tiposanguineo == "O-") ? 'selected': '' }}>O-</option>
                    </select>
                    @if ($errors->has('st_tiposanguineo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tiposanguineo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_estadocivil') ? ' has-error' : '' }} col-md-2">
                    <label for="st_estadocivil" class="control-label">Estado Civil</label>
                    <select id="st_estadocivil" name="st_estadocivil" class="form-control" onchange="checkConjuge()" required>
                        <option value=""  selected>Selecione</option>
                        <option value="Solteiro" {{ $servidor->st_estadocivil == 'Solteiro' ? 'selected':''}}>Solteiro(a)</option>
                        <option value="Casado" {{ $servidor->st_estadocivil == 'Casado' ? 'selected':''}}>Casado(a)</option>
                        <option value="Viúvo" {{ $servidor->st_estadocivil == 'Viúvo' ? 'selected':''}}>Viúvo(a)</option>
                        <option value="Divorciado" {{ $servidor->st_estadocivil == 'Divorciado' ? 'selected':''}}>Divorciado(a)</option>
                        <option value="União Estável" {{ $servidor->st_estadocivil == 'União Estável' ? 'selected':''}}>União Estável</option>
                        <option value="Outro" {{ $servidor->st_estadocivil == 'Outro' ? 'selected':''}}>Outro</option>
                    </select>
                    @if ($errors->has('st_estadocivil'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_estadocivil') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group{{ $errors->has('st_pai') ? ' has-error' : '' }} col-md-5">
                    <label for="st_pai" class="control-label">Filiação (Pai)</label>
                    <input id="st_pai" type="text" class="form-control" placeholder="Digite o nome do pai" name="st_pai" value="{{ $servidor->st_pai }}"> 
                    @if ($errors->has('st_pai'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_pai') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_mae') ? ' has-error' : '' }} col-md-5">
                    <label for="st_mae" class="control-label">Filiação (Mãe)</label>
                    <input id="st_mae" type="text" class="form-control" placeholder="Digite  o nome da mãe" name="st_mae" value="{{ $servidor->st_mae }}"> 
                    @if ($errors->has('st_mae'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_mae') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                @if($servidor->st_estadocivil == 'Casado' || $servidor->st_estadocivil == 'União Estável')
                    <div class="form-group{{ $errors->has('st_conjuge') ? ' has-error' : '' }} col-md-5" id="divConjuge">
                @else
                    <div class="form-group{{ $errors->has('st_conjuge') ? ' has-error' : '' }} col-md-5" style="display: none" id="divConjuge">
                @endif
                    <label for="st_conjuge" class="control-label">Cônjuge</label>
                    <input id="st_conjuge" type="text" class="form-control" placeholder="Digite  o nome do cônjuge" name="st_conjuge" value="{{ $servidor->st_conjuge }}"> 
                    @if ($errors->has('st_conjuge'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_conjuge') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_altura') ? ' has-error' : '' }} col-md-1">
                <label for="st_altura" class="control-label">Altura</label>
                <input id="st_altura" type="text" class="form-control" name="st_altura" value="{{ $servidor->st_altura }}"> 
                @if ($errors->has('st_altura'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_altura') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('st_cor') ? ' has-error' : '' }} col-md-2">
                <label for="st_cor" class="control-label">Cor</label>
                <input id="st_cor" type="text" class="form-control" name="st_cor" value="{{ $servidor->st_cor }}"> 
                @if ($errors->has('st_cor'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_cor') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('st_olhos') ? ' has-error' : '' }} col-md-2">
                <label for="st_olhos" class="control-label">Olhos</label>
                <input id="st_olhos" type="text" class="form-control" name="st_olhos" value="{{ $servidor->st_olhos }}"> 
                @if ($errors->has('st_olhos'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_olhos') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('st_cabelos') ? ' has-error' : '' }} col-md-2">
                <label for="st_cabelos" class="control-label">Cabelos</label>
                <input id="st_cabelos" type="text" class="form-control" name="st_cabelos" value="{{ $servidor->st_cabelos }}"> 
                @if ($errors->has('st_cabelos'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_cabelos') }}</strong>
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
                    <input id="st_cep" type="text" class="form-control" placeholder="Ex: 00000-000" name="st_cep" value="{{ $servidor->st_cep }}"> 
                    @if ($errors->has('st_cep'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cep') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_logradouro') ? ' has-error' : '' }} col-md-5">
                    <label for="st_logradouro">Logradouro</label>
                    <input id="st_logradouro" type="text" class="form-control" placeholder="Digite sua rua, avenida ou travessa" name="st_logradouro" value="{{ $servidor->st_logradouro }}"> 
                    @if ($errors->has('st_logradouro'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_logradouro') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_numeroresidencia') ? ' has-error' : '' }} col-md-2">
                    <label for="st_numeroresidencia" >Número</label>
                    <input id="st_numeroresidencia" type="text" class="form-control" placeholder="Ex: 12" name="st_numeroresidencia" value="{{ $servidor->st_numeroresidencia }}"> 
                    @if ($errors->has('st_numeroresidencia'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_numeroresidencia') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_bairro') ? ' has-error' : '' }} col-md-3">
                    <label for="st_bairro" >Bairro</label>
                    <input id="st_bairro" type="text" class="form-control" placeholder="Digite seu bairro" name="st_bairro" value="{{ $servidor->st_bairro }}"> 
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
                    <input id="st_cidade" type="text" class="form-control" placeholder="Digite sua cidade" name="st_cidade" value="{{ $servidor->st_cidade }}"> 
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
                        <option {{ $servidor->st_uf == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $servidor->st_uf == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $servidor->st_uf == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $servidor->st_uf == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $servidor->st_uf == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $servidor->st_uf == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $servidor->st_uf == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $servidor->st_uf == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $servidor->st_uf == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $servidor->st_uf == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $servidor->st_uf == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $servidor->st_uf == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $servidor->st_uf == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $servidor->st_uf == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $servidor->st_uf == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $servidor->st_uf == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $servidor->st_uf == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $servidor->st_uf == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $servidor->st_uf == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $servidor->st_uf == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $servidor->st_uf == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $servidor->st_uf == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $servidor->st_uf == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $servidor->st_uf == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $servidor->st_uf == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $servidor->st_uf == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $servidor->st_uf == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_uf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_uf') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_complemento') ? ' has-error' : '' }} col-md-6">
                    <label for="st_complemento" >Complemento</label>
                    <input id="st_complemento" type="text" class="form-control" placeholder="Digite o complemento" name="st_complemento" value="{{ $servidor->st_complemento }}"> 
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
                    <input id="st_telefoneresidencial" type="text" class="form-control" placeholder="Digite seu telefone" name="st_telefoneresidencial" value="{{ $servidor->st_telefoneresidencial }}"> 
                    @if ($errors->has('st_telefoneresidencial'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_telefoneresidencial') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_telefonecelular') ? ' has-error' : '' }} col-md-2">
                    <label for="st_telefonecelular" >Telefone Celular</label>
                    <input id="st_telefonecelular" type="text" class="form-control" placeholder="Digite seu celular" name="st_telefonecelular" value="{{ $servidor->st_telefonecelular }}"> 
                    @if ($errors->has('st_telefonecelular'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_telefonecelular') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_email') ? ' has-error' : '' }} col-md-5">
                    <label for="st_email" >Email</label>
                    <input id="st_email" type="text" class="form-control" placeholder="Digite seu email" name="st_email" value="{{ $servidor->st_email }}"> 
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
                    <input id="st_codigobanco" type="text" class="form-control" placeholder="Ex: 000" name="st_codigobanco" value="{{ $servidor->st_codigobanco }}"> 
                    @if ($errors->has('st_codigobanco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_codigobanco') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_nomebanco') ? ' has-error' : '' }} col-md-5">
                    <label for="st_nomebanco">Nome do Banco</label>
                    <input id="st_nomebanco" type="text" class="form-control" placeholder="Ex: Caixa, Banco do Brasil..." name="st_nomebanco" value="{{ $servidor->st_nomebanco }}"> 
                    @if ($errors->has('st_nomebanco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_nomebanco') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_agencia') ? ' has-error' : '' }} col-md-2">
                    <label for="st_agencia">Agência</label>
                    <input id="st_agencia" type="text" class="form-control" placeholder="Ex: 000" name="st_agencia" value="{{ $servidor->st_agencia }}"> 
                    @if ($errors->has('st_agencia'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_agencia') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_conta') ? ' has-error' : '' }} col-md-2">
                    <label for="st_conta" class="control-label">Conta Corrente</label>
                    <input id="st_conta" type="text" class="form-control" placeholder="Ex: 000000" name="st_conta" value="{{ $servidor->st_conta }}"> 
                    @if ($errors->has('st_conta'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_conta') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <div class="form-group ">
            <div class="col-md-offset-5">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-fw fa-save"></i> Salvar
                </button>
            </div>
        </div>
    </form>
</div>
<!-- /.tab-pane -->
@endsection