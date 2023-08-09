@extends('dps::prontuario.abas_prontuario_pensionista')

@section('title', 'SISGP - Dados do Pensionista')

@section('tabcontent')

<div class="tab-pane active" id="dados_pessoais">
    <h4 class="tab-title">Dados Pessoais - {{ $dadosAba->st_nome }}</h4>
    <hr class="separador">
    <form role="form" method="POST" action=" {{ URL::route('salvar_prontuario_pensionista', [
        'pensionistaId' => $idPensionista,
        'aba' => 'dados_pessoais',
        'acao' => 'salvar'
    ]) }} ">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Identificação</legend>
    
            <div class="row">
                <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }} col-md-4">
                    <label for="st_nome">Nome</label>
                    <input id="st_nome" type="text" class="form-control" placeholder="Digite o nome" name="st_nome" value="{{ $dadosAba->st_nome }}" required> 
                    @if ($errors->has('st_nome'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_nome') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_nascimento" class="control-label">Data de Nascimento</label>
                    <input id="dt_nascimento" type="date" class="form-control" name="dt_nascimento" value="{{ $dadosAba->dt_nascimento }}" required> 
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
                            <input type="radio" name="st_sexo" id="st_sexo" value="MASCULINO" {{ ($dadosAba->st_sexo == 'MASCULINO') ? 'checked':'' }} required>
                            Masculino
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="st_sexo" id="st_sexo" value="FEMININO" {{ ($dadosAba->st_sexo == 'FEMININO') ? 'checked':'' }} required>
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
                    <select id="st_tiposanguineo" name="st_tiposanguineo" class="form-control">
                        <option value=""  selected>Selecione</option>
                        <option value="A" {{ ($dadosAba->st_tiposanguineo == "A") ? 'selected': '' }}>A</option>                        
                        <option value="B" {{ ($dadosAba->st_tiposanguineo == "B") ? 'selected': '' }}>B</option>
                        <option value="AB" {{ ($dadosAba->st_tiposanguineo == "AB") ? 'selected': '' }}>AB</option>
                        <option value="O" {{ ($dadosAba->st_tiposanguineo == "O") ? 'selected': '' }}>O</option>
                    </select>
                    @if ($errors->has('st_tiposanguineo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tiposanguineo') }}</strong>
                    </span>
                    @endif
                </div>
               

                <div class="form-group{{ $errors->has('st_fatorrh') ? ' has-error' : '' }} col-md-1">
                    <label for="st_fatorrh" class="control-label">Fator RH</label>
                    <select id="st_fatorrh" name="st_fatorrh" class="form-control">
                        <option value=""  selected>Selecione</option>
                        <option value="+" {{ ($dadosAba->st_fatorrh == "+") ? 'selected': '' }}>+</option>
                        <option value="-" {{ ($dadosAba->st_fatorrh == "-") ? 'selected': '' }}>-</option>  
                    </select>
                    @if ($errors->has('st_fatorrh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_fatorrh') }}</strong>
                    </span>
                    @endif
                </div>
              
            
                <div class="form-group{{ $errors->has('bo_vivo') ? ' has-error' : '' }} col-md-2">
                    <label for="bo_vivo" class="control-label">Vivo</label>
                    <select id="bo_vivo" name="bo_vivo" class="form-control" required>
                        <option value=""  selected>Selecione</option>
                        <option value="1" {{ ($dadosAba->bo_vivo == "1") ? 'selected': '' }}>Sim</option>                        
                        <option value="0" {{ ($dadosAba->bo_vivo == "0") ? 'selected': '' }}>Não</option>
                    </select>
                    @if ($errors->has('bo_vivo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bo_vivo') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="row">

                <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf" class="control-label">CPF</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_cpf" value="{{ $dadosAba->st_cpf }}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>


                <div class="form-group{{ $errors->has('st_naturalidade') ? ' has-error' : '' }} col-md-2">
                    <label for="st_naturalidade" class="control-label">Naturalidade</label>
                    <input id="st_naturalidade" type="text" class="form-control" placeholder="Ex: Natal" name="st_naturalidade" value="{{ $dadosAba->st_naturalidade }}"> 
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
                        <option {{ $dadosAba->st_ufnaturalidade == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $dadosAba->st_ufnaturalidade == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_ufnaturalidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_ufnaturalidade') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_mae') ? ' has-error' : '' }} col-md-4">
                    <label for="st_mae" class="control-label">Filiação (Mãe)</label>
                    <input id="st_mae" type="text" class="form-control" placeholder="Digite  o nome da mãe" name="st_mae" value="{{ $dadosAba->st_mae }}"> 
                    @if ($errors->has('st_mae'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_mae') }}</strong>
                    </span>
                    @endif
                </div>                
                <div class="form-group{{ $errors->has('st_pai') ? ' has-error' : '' }} col-md-4">
                    <label for="st_pai" class="control-label">Filiação (Pai)</label>
                    <input id="st_pai" type="text" class="form-control" placeholder="Digite o nome do pai" name="st_pai" value="{{ $dadosAba->st_pai }}"> 
                    @if ($errors->has('st_pai'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_pai') }}</strong>
                    </span>
                    @endif
                </div>

            </div>
            
            <div class="row">
                <div class="form-group{{ $errors->has('st_estadocivil') ? ' has-error' : '' }} col-md-2">
                    <label for="st_estadocivil" class="control-label">Estado Civil</label>
                    <select id="st_estadocivil" name="st_estadocivil" class="form-control" required>
                        <option value=""  selected>Selecione</option>
                        <option value="Solteiro" {{ $dadosAba->st_estadocivil == 'Solteiro' ? 'selected':''}}>Solteiro(a)</option>
                        <option value="Casado" {{ $dadosAba->st_estadocivil == 'Casado' ? 'selected':''}}>Casado(a)</option>
                        <option value="Viúvo" {{ $dadosAba->st_estadocivil == 'Viúvo' ? 'selected':''}}>Viúvo(a)</option>
                        <option value="Divorciado" {{ $dadosAba->st_estadocivil == 'Divorciado' ? 'selected':''}}>Divorciado(a)</option>
                        <option value="União Estável" {{ $dadosAba->st_estadocivil == 'União Estável' ? 'selected':''}}>União Estável</option>
                        <option value="Outro" {{ $dadosAba->st_estadocivil == 'Outro' ? 'selected':''}}>Outro</option>
                    </select>
                    @if ($errors->has('st_estadocivil'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_estadocivil') }}</strong>
                    </span>
                    @endif
                </div>               
                    <div class="form-group{{ $errors->has('st_conjuge') ? ' has-error' : '' }} col-md-5" id="divConjuge">
                        <label for="st_conjuge" class="control-label">Cônjuge</label>
                        <input id="st_conjuge" type="text" class="form-control" placeholder="Digite  o nome do cônjuge" name="st_conjuge" value="{{ $dadosAba->st_conjuge }}"> 
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
                    <input id="st_cep" type="text" class="form-control" placeholder="Ex: 00000-000" name="st_cep" value="{{ $dadosAba->st_cep }}"> 
                    @if ($errors->has('st_cep'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cep') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_logradouro') ? ' has-error' : '' }} col-md-5">
                    <label for="st_logradouro">Logradouro</label>
                    <input id="st_logradouro" type="text" class="form-control" placeholder="Digite sua rua, avenida ou travessa" name="st_logradouro" value="{{ $dadosAba->st_logradouro }}"> 
                    @if ($errors->has('st_logradouro'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_logradouro') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_numeroresidencia') ? ' has-error' : '' }} col-md-2">
                    <label for="st_numeroresidencia" >Número</label>
                    <input id="st_numeroresidencia" type="text" class="form-control" placeholder="Ex: 12" name="st_numeroresidencia" value="{{ $dadosAba->st_numeroresidencia }}"> 
                    @if ($errors->has('st_numeroresidencia'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_numeroresidencia') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_bairro') ? ' has-error' : '' }} col-md-3">
                    <label for="st_bairro" >Bairro</label>
                    <input id="st_bairro" type="text" class="form-control" placeholder="Digite seu bairro" name="st_bairro" value="{{ $dadosAba->st_bairro }}"> 
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
                    <input id="st_cidade" type="text" class="form-control" placeholder="Digite sua cidade" name="st_cidade" value="{{ $dadosAba->st_cidade }}"> 
                    @if ($errors->has('st_cidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cidade') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_ufendereco') ? ' has-error' : '' }} col-md-2">
                    <label for="st_ufendereco" class="control-label">UF</label>
                    <select id="st_ufendereco" name="st_ufendereco" class="form-control">
                        <option value="">Selecione</option>
                        <option {{ $dadosAba->st_ufendereco == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $dadosAba->st_ufendereco == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $dadosAba->st_ufendereco == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $dadosAba->st_ufendereco == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $dadosAba->st_ufendereco == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $dadosAba->st_ufendereco == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $dadosAba->st_ufendereco == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $dadosAba->st_ufendereco == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $dadosAba->st_ufendereco == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $dadosAba->st_ufendereco == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $dadosAba->st_ufendereco == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $dadosAba->st_ufendereco == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $dadosAba->st_ufendereco == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $dadosAba->st_ufendereco == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $dadosAba->st_ufendereco == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $dadosAba->st_ufendereco == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $dadosAba->st_ufendereco == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $dadosAba->st_ufendereco == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $dadosAba->st_ufendereco == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $dadosAba->st_ufendereco == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $dadosAba->st_ufendereco == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $dadosAba->st_ufendereco == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $dadosAba->st_ufendereco == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $dadosAba->st_ufendereco == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $dadosAba->st_ufendereco == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $dadosAba->st_ufendereco == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $dadosAba->st_ufendereco == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_ufendereco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_ufendereco') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_complemento') ? ' has-error' : '' }} col-md-6">
                    <label for="st_complemento" >Complemento</label>
                    <input id="st_complemento" type="text" class="form-control" placeholder="Digite o complemento" name="st_complemento" value="{{ $dadosAba->st_complemento }}"> 
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
                <div class="form-group{{ $errors->has('st_telefone') ? ' has-error' : '' }} col-md-2">
                    <label for="st_telefone" >Telefone Residencial</label>
                    <input id="st_telefone" type="text" class="form-control" placeholder="Digite seu telefone" name="st_telefone" value="{{ $dadosAba->st_telefone }}"> 
                    @if ($errors->has('st_telefoneresidencial'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_telefone') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_telefonecelular') ? ' has-error' : '' }} col-md-2">
                    <label for="st_telefonecelular" >Telefone Celular</label>
                    <input id="st_telefonecelular" type="text" class="form-control" placeholder="Digite seu celular" name="st_telefonecelular" value="{{ $dadosAba->st_telefonecelular }}"> 
                    @if ($errors->has('st_telefonecelular'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_telefonecelular') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_email') ? ' has-error' : '' }} col-md-5">
                    <label for="st_email" >Email</label>
                    <input id="st_email" type="text" class="form-control" placeholder="Digite seu email" name="st_email" value="{{ $dadosAba->st_email }}"> 
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
                    <input id="st_codigobanco" type="text" class="form-control" placeholder="Ex: 001" name="st_codigobanco" value="{{ $dadosAba->st_codigobanco }}"> 
                    @if ($errors->has('st_codigobanco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_codigobanco') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_banco') ? ' has-error' : '' }} col-md-5">
                    <label for="st_banco">Nome do Banco</label>
                    <input id="st_banco" type="text" class="form-control" placeholder="Ex: Caixa, Banco do Brasil..." name="st_banco" value="{{ $dadosAba->st_banco }}"> 
                    @if ($errors->has('st_banco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_banco') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_agencia') ? ' has-error' : '' }} col-md-2">
                    <label for="st_agencia">Agência</label>
                    <input id="st_agencia" type="text" class="form-control" placeholder="Ex: 000" name="st_agencia" value="{{ $dadosAba->st_agencia }}"> 
                    @if ($errors->has('st_agencia'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_agencia') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_conta') ? ' has-error' : '' }} col-md-2">
                    <label for="st_conta" class="control-label">Conta Corrente</label>
                    <input id="st_conta" type="text" class="form-control" placeholder="Ex: 000000" name="st_conta" value="{{ $dadosAba->st_conta }}"> 
                    @if ($errors->has('st_conta'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_conta') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <div class="row">
            <div class="form-group">                
                               
                <div class="col-md-1" style='text-align: center;'>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-fw fa-save"></i> Salvar
                    </button>                
                </div>                            
            </div>
        </div>
            
    </form>
</div>
<!-- /.tab-pane -->
@endsection

@section('js')
<script>
    $(document).ready(function () {  
        //altera a exibição dos campos abaixo de acordo com a mudança do bo_vivo
        $('#bo_vivo').on('change', function() {
            if(this.value == 1){
                $('#div_dt_obito').hide();
                $('#dt_obito').val('');
                $('#dt_obito').removeAttr('required');
                $('#div_st_motivoobito').hide();
                $('#st_motivoobito').val('');
                $('#st_motivoobito').removeAttr('required');
                $('#div_bo_obitorelacionadoprofissao').hide();
                $('#bo_obitorelacionadoprofissao').val('');
                $('#bo_obitorelacionadoprofissao').removeAttr('required');
            }else{
                $('#div_dt_obito').show();
                $('#dt_obito').attr('required', true);
                $('#div_st_motivoobito').show();
                $('#st_motivoobito').attr('required', true);
                $('#div_bo_obitorelacionadoprofissao').show();
                $('#bo_obitorelacionadoprofissao').attr('required', true);
            }
        });
        //exibe os campos abaixo de acordo com o valor do bo_vivo
        if($('#bo_vivo').val() == 1) {
            $('#div_dt_obito').hide();
            $('#dt_obito').val('');
            $('#dt_obito').removeAttr('required');
            $('#div_st_motivoobito').hide();
            $('#st_motivoobito').val('');
            $('#st_motivoobito').removeAttr('required');
            $('#div_bo_obitorelacionadoprofissao').hide();
            $('#bo_obitorelacionadoprofissao').val('');
            $('#bo_obitorelacionadoprofissao').removeAttr('required');
        }else{
            $('#div_dt_obito').show();
            $('#dt_obito').attr('required', true);
            $('#div_st_motivoobito').show();
            $('#st_motivoobito').attr('required', true);
            $('#div_bo_obitorelacionadoprofissao').show();
            $('#bo_obitorelacionadoprofissao').attr('required', true);
        }

    });
</script>
@endsection