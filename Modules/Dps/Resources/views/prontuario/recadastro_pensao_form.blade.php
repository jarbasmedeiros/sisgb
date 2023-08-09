@extends('dps::prontuario.abas_prontuario_pensionista')

@section('title', 'SISGP - Dados do Pensionista')

@section('tabcontent')

<div class="tab-pane active" id="dados_pessoais">
    <h4 class="tab-title">Prova de Vida - {{ $dadosAba->pessoa->st_nome }}</h4>
    <hr class="separador">
    <form role="form" method="POST" action=" {{ URL::route('salvar_prontuario_pensionista', [
            'pensionistaId' => $dadosAba->pessoa->id,
            'aba' => 'recadastro',
            'acao' => 'criar'
        ]) }} ">
        {{ csrf_field() }}

        <div class="modal bg-danger" id="assinarModal" tabindex="-1" role="dialog" aria-labelledby="assinarModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="assinarModalLabel">Assinar Prova de Vida</h5>
                    </div>
                    <div class="modal-body bg-danger">
                        <div class="form-group">
                            <strong> DESEJA CONCLUIR A PROVA DE VIDA? </strong>
                        </div>
                        
                        <div class="form-group">
                            <label for="st_assinatura"> Digite a sua senha </label>
                            <input required type="password" id="st_assinatura" name="st_assinatura" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                        <button type="submit" class="btn btn-success">Sim</button>
                    </div>
                </div>
            </div>
        </div>


        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Identificação</legend>
    
            <div class="row">
                <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }} col-md-4">
                    <label for="st_nome">Nome</label>
                    <input disabled id="st_nome" type="text" class="form-control" placeholder="Digite o nome" name="st_nome" value="{{ $dadosAba->pessoa->st_nome }}" required> 
                    @if ($errors->has('st_nome'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_nome') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_nascimento" class="control-label">Data de Nascimento</label>
                    <input disabled id="dt_nascimento" type="date" class="form-control" name="dt_nascimento" value="{{ $dadosAba->pessoa->dt_nascimento }}" required> 
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
                            <input disabled type="radio" name="st_sexo" id="st_sexo" value="MASCULINO" {{ ($dadosAba->pessoa->st_sexo == 'MASCULINO') ? 'checked':'' }} required>
                            Masculino
                        </label>
                        <label class="radio-option">
                            <input disabled type="radio" name="st_sexo" id="st_sexo" value="FEMININO" {{ ($dadosAba->pessoa->st_sexo == 'FEMININO') ? 'checked':'' }} required>
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
                    <select disabled id="st_tiposanguineo" name="st_tiposanguineo" class="form-control">
                        <option value=""  selected>Selecione</option>
                        <option value="A" {{ ($dadosAba->pessoa->st_tiposanguineo == "A") ? 'selected': '' }}>A</option>                        
                        <option value="B" {{ ($dadosAba->pessoa->st_tiposanguineo == "B") ? 'selected': '' }}>B</option>
                        <option value="AB" {{ ($dadosAba->pessoa->st_tiposanguineo == "AB") ? 'selected': '' }}>AB</option>
                        <option value="O" {{ ($dadosAba->pessoa->st_tiposanguineo == "O") ? 'selected': '' }}>O</option>
                    </select>
                    @if ($errors->has('st_tiposanguineo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tiposanguineo') }}</strong>
                    </span>
                    @endif
                </div>
               

                <div class="form-group{{ $errors->has('st_fatorrh') ? ' has-error' : '' }} col-md-1">
                    <label for="st_fatorrh" class="control-label">Fator RH</label>
                    <select disabled id="st_fatorrh" name="st_fatorrh" class="form-control">
                        <option value=""  selected>Selecione</option>
                        <option value="+" {{ ($dadosAba->pessoa->st_fatorrh == "+") ? 'selected': '' }}>+</option>
                        <option value="-" {{ ($dadosAba->pessoa->st_fatorrh == "-") ? 'selected': '' }}>-</option>  
                    </select>
                    @if ($errors->has('st_fatorrh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_fatorrh') }}</strong>
                    </span>
                    @endif
                </div>
              
            
                <div class="form-group{{ $errors->has('bo_vivo') ? ' has-error' : '' }} col-md-2">
                    <label for="bo_vivo" class="control-label">Vivo</label>
                    <select disabled id="bo_vivo" name="bo_vivo" class="form-control" required>
                        <option value=""  selected>Selecione</option>
                        <option value="1" {{ ($dadosAba->pessoa->bo_vivo == "1") ? 'selected': '' }}>Sim</option>                        
                        <option value="0" {{ ($dadosAba->pessoa->bo_vivo == "0") ? 'selected': '' }}>Não</option>
                    </select>
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
                    <input disabled id="st_naturalidade" type="text" class="form-control" placeholder="Ex: Natal" name="st_naturalidade" value="{{ $dadosAba->pessoa->st_naturalidade }}"> 
                    @if ($errors->has('st_naturalidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_naturalidade') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_ufnaturalidade') ? ' has-error' : '' }} col-md-2">
                    <label for="st_ufnaturalidade" class="control-label">UF</label>
                    <select disabled id="st_ufnaturalidade" name="st_ufnaturalidade" class="form-control">
                        <option value="">Selecione</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $dadosAba->pessoa->st_ufnaturalidade == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_ufnaturalidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_ufnaturalidade') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_mae') ? ' has-error' : '' }} col-md-4">
                    <label for="st_mae" class="control-label">Filiação (Mãe)</label>
                    <input disabled id="st_mae" type="text" class="form-control" placeholder="Digite  o nome da mãe" name="st_mae" value="{{ $dadosAba->pessoa->st_mae }}"> 
                    @if ($errors->has('st_mae'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_mae') }}</strong>
                    </span>
                    @endif
                </div>                
                <div class="form-group{{ $errors->has('st_pai') ? ' has-error' : '' }} col-md-4">
                    <label for="st_pai" class="control-label">Filiação (Pai)</label>
                    <input disabled id="st_pai" type="text" class="form-control" placeholder="Digite o nome do pai" name="st_pai" value="{{ $dadosAba->pessoa->st_pai }}"> 
                    @if ($errors->has('st_pai'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_pai') }}</strong>
                    </span>
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-2">
                    <label for="st_cpf">CPF</label>
                    <input disabled class="form-control" type="text" name="st_cpf" id="st_cpf" value="{{ $dadosAba->pessoa->st_cpf }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="st_rgcivil">Registro Geral</label>
                    <input disabled class="form-control" type="text" name="st_rgcivil" id="st_rgcivil" value="{{ $dadosAba->pessoa->st_rgcivil }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="st_orgaorgcivil">Orgão Emissor</label>
                    <input disabled class="form-control" type="text" name="st_orgaorgcivil" id="st_orgaorgcivil" value="{{ $dadosAba->pessoa->st_orgaorgcivil }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="dt_emissaorgcivil">Data de Emissão</label>
                    <input disabled class="form-control" type="text" name="dt_emissaorgcivil" id="dt_emissaorgcivil" value="{{ $dadosAba->pessoa->dt_emissaorgcivil }}">
                </div>
            </div>
            
            <div class="row">
                <div class="form-group{{ $errors->has('st_estadocivil') ? ' has-error' : '' }} col-md-2">
                    <label for="st_estadocivil" class="control-label">Estado Civil</label>
                    <select disabled id="st_estadocivil" name="st_estadocivil" class="form-control" required>
                        <option value=""  selected>Selecione</option>
                        <option value="Solteiro" {{ $dadosAba->pessoa->st_estadocivil == 'Solteiro' ? 'selected':''}}>Solteiro(a)</option>
                        <option value="Casado" {{ $dadosAba->pessoa->st_estadocivil == 'Casado' ? 'selected':''}}>Casado(a)</option>
                        <option value="Viúvo" {{ $dadosAba->pessoa->st_estadocivil == 'Viúvo' ? 'selected':''}}>Viúvo(a)</option>
                        <option value="Divorciado" {{ $dadosAba->pessoa->st_estadocivil == 'Divorciado' ? 'selected':''}}>Divorciado(a)</option>
                        <option value="União Estável" {{ $dadosAba->pessoa->st_estadocivil == 'União Estável' ? 'selected':''}}>União Estável</option>
                        <option value="Outro" {{ $dadosAba->pessoa->st_estadocivil == 'Outro' ? 'selected':''}}>Outro</option>
                    </select>
                    @if ($errors->has('st_estadocivil'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_estadocivil') }}</strong>
                    </span>
                    @endif
                </div>               
                    <div class="form-group{{ $errors->has('st_conjuge') ? ' has-error' : '' }} col-md-5" id="divConjuge">
                        <label for="st_conjuge" class="control-label">Cônjuge</label>
                        <input disabled id="st_conjuge" type="text" class="form-control" placeholder="Digite  o nome do cônjuge" name="st_conjuge" value="{{ $dadosAba->pessoa->st_conjuge }}"> 
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
                    <input disabled id="st_cep" type="text" class="form-control" placeholder="Ex: 00000-000" name="st_cep" value="{{ $dadosAba->pessoa->st_cep }}"> 
                    @if ($errors->has('st_cep'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cep') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_logradouro') ? ' has-error' : '' }} col-md-5">
                    <label for="st_logradouro">Logradouro</label>
                    <input disabled id="st_logradouro" type="text" class="form-control" placeholder="Digite sua rua, avenida ou travessa" name="st_logradouro" value="{{ $dadosAba->pessoa->st_logradouro }}"> 
                    @if ($errors->has('st_logradouro'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_logradouro') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_numeroresidencia') ? ' has-error' : '' }} col-md-2">
                    <label for="st_numeroresidencia" >Número</label>
                    <input disabled id="st_numeroresidencia" type="text" class="form-control" placeholder="Ex: 12" name="st_numeroresidencia" value="{{ $dadosAba->pessoa->st_numeroresidencia }}"> 
                    @if ($errors->has('st_numeroresidencia'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_numeroresidencia') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_bairro') ? ' has-error' : '' }} col-md-3">
                    <label for="st_bairro" >Bairro</label>
                    <input disabled id="st_bairro" type="text" class="form-control" placeholder="Digite seu bairro" name="st_bairro" value="{{ $dadosAba->pessoa->st_bairro }}"> 
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
                    <input disabled id="st_cidade" type="text" class="form-control" placeholder="Digite sua cidade" name="st_cidade" value="{{ $dadosAba->pessoa->st_cidade }}"> 
                    @if ($errors->has('st_cidade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cidade') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_ufendereco') ? ' has-error' : '' }} col-md-2">
                    <label for="st_ufendereco" class="control-label">UF</label>
                    <select disabled id="st_ufendereco" name="st_ufendereco" class="form-control">
                        <option value="">Selecione</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $dadosAba->pessoa->st_ufendereco == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_ufendereco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_ufendereco') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_complemento') ? ' has-error' : '' }} col-md-6">
                    <label for="st_complemento" >Complemento</label>
                    <input disabled id="st_complemento" type="text" class="form-control" placeholder="Digite o complemento" name="st_complemento" value="{{ $dadosAba->pessoa->st_complemento }}"> 
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
                    <input disabled id="st_telefone" type="text" class="form-control" placeholder="Digite seu telefone" name="st_telefone" value="{{ $dadosAba->pessoa->st_telefone }}"> 
                    @if ($errors->has('st_telefoneresidencial'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_telefone') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_telefonecelular') ? ' has-error' : '' }} col-md-2">
                    <label for="st_telefonecelular" >Telefone Celular</label>
                    <input disabled id="st_telefonecelular" type="text" class="form-control" placeholder="Digite seu celular" name="st_telefonecelular" value="{{ $dadosAba->pessoa->st_telefonecelular }}"> 
                    @if ($errors->has('st_telefonecelular'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_telefonecelular') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_email') ? ' has-error' : '' }} col-md-5">
                    <label for="st_email" >Email</label>
                    <input disabled id="st_email" type="text" class="form-control" placeholder="Digite seu email" name="st_email" value="{{ $dadosAba->pessoa->st_email }}"> 
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
                    <input disabled id="st_codigobanco" type="text" class="form-control" placeholder="Ex: 001" name="st_codigobanco" value="{{ $dadosAba->pessoa->st_codigobanco }}"> 
                    @if ($errors->has('st_codigobanco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_codigobanco') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_banco') ? ' has-error' : '' }} col-md-5">
                    <label for="st_banco">Nome do Banco</label>
                    <input disabled id="st_banco" type="text" class="form-control" placeholder="Ex: Caixa, Banco do Brasil..." name="st_banco" value="{{ $dadosAba->pessoa->st_banco }}"> 
                    @if ($errors->has('st_banco'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_banco') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_agencia') ? ' has-error' : '' }} col-md-2">
                    <label for="st_agencia">Agência</label>
                    <input disabled id="st_agencia" type="text" class="form-control" placeholder="Ex: 000" name="st_agencia" value="{{ $dadosAba->pessoa->st_agencia }}"> 
                    @if ($errors->has('st_agencia'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_agencia') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('st_conta') ? ' has-error' : '' }} col-md-2">
                    <label for="st_conta" class="control-label">Conta Corrente</label>
                    <input disabled id="st_conta" type="text" class="form-control" placeholder="Ex: 000000" name="st_conta" value="{{ $dadosAba->pessoa->st_conta }}"> 
                    @if ($errors->has('st_conta'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_conta') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">
                Dados da Pensão
            </legend>
            <div class="row">
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="st_tipo">Tipo</label>
                        <select disabled required class="form-control" name="st_tipo" id="st_tipo">
                            <option value="">--Selecione--</option>
                            <option {{ $dadosAba->st_tipo == 'POS_MORTE' ? 'selected' : '' }} value="POS_MORTE">Pós-Morte</option>
                            <option {{ $dadosAba->st_tipo == 'JUDICIAL' ? 'selected' : '' }} value="JUDICIAL">Judicial</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="st_vinculo">Vínculo</label>
                        <select disabled required class="form-control" name="st_vinculo" id="st_vinculo">
                            <option value="">--Selecione--</option>
                            <option {{ $dadosAba->st_vinculo == 'Pai/Mãe' ? 'selected' : '' }} value="Pai/Mãe">PAI/MÃE</option>
                            <option {{ $dadosAba->st_vinculo == 'Filhos' ? 'selected' : '' }} value="Filhos">FILHOS</option>
                            <option {{ $dadosAba->st_vinculo == 'Conjuge' ? 'selected' : '' }} value="Conjuge">CONJUGE</option>
                            <option {{ $dadosAba->st_vinculo == 'ESPOSA' ? 'selected' : '' }} value="ESPOSA">ESPOSA</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="st_situacao">Situação</label>
                        <input disabled type="text" name="st_situacao" class="form-control" value="{{ $dadosAba->st_situacao  }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="dt_inicio">Início</label>
                        <input disabled class="form-control" name="dt_inicio" type="date" name="dt_termino" value="{{$dadosAba->dt_inicio}}"">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="st_tiporesponsavellegal">Declarante</label>
                    <select required name="st_tiporesponsavellegal" id="st_tiporesponsavellegal" class="form-control" onchange="exibirCampos()">
                        <option value="">Escolha uma opção</option>
                        <option value="PENSIONISTA">Pensionista</option>
                        <option value="TUTOR">Tutor</option>
                        <option value="PROCURADOR">Procurador</option>
                        <option value="CURADOR">Curador</option>
                    </select>
                </div>

                <div id="nomeDeclarante" class="form-group col-md-4" style="display: none;">
                    <label for="st_nomeresponsavellegal">Nome do Declarante</label>
                    <input type="text" id="st_nomeresponsavellegal" name="st_nomeresponsavellegal" class="form-control">
                </div>
                
                <div id="cpfDeclarante" class="form-group col-md-3" style="display: none;">
                    <label for="st_cpfresponsavellegal">CPF do Declarante</label>
                    <input type="text" id="st_cpfresponsavellegal" name="st_cpfresponsavellegal" class="form-control">
                </div>

            </div>

            {{-- <div class="row">
                <div class="form-group col-md-3">
                    <label for="st_pcd">Cadeirante?</label>
                    <select required class='form-control' name="st_pcd" id="st_pcd" onchange="exibirChecks()">
                        <option value="">Escolha uma opção</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
            </div>

            <div id="checkboxes" style="display: none;">
                <div class="form-check col-md-2">
                    <input class="form-check-input" id="bo_temporario" name="bo_temporario" value="1" type="checkbox">
                    <label class="form-check-label" for="bo_temporario">Temporário?</label>
                </div>
            </div> --}}
                
        </fieldset>

        <div class="row">
            <div class="form-group">                
                               
                <div class="col-md-1" style='text-align: center;'>
                    <a href="#" data-toggle="modal" data-target="#assinarModal" class="btn btn-primary">
                        <i class="fa fa-save fa-lg"></i> Registrar
                    </a>                
                </div>                            
            </div>
        </div>
            
    </form>
</div>

<script>
    function aux(element1, element2, value, display) {
        document.getElementById(element1).style.display = display;
        document.getElementById(element2).value = value;
    }

    function exibirChecks() {
        let drop = document.getElementById("st_pcd").value;
        if (drop == 'S') {
            document.getElementById('checkboxes').style.display = 'block';
        } else {
            document.getElementById('checkboxes').style.display = 'none';
            document.getElementById('bo_temporario').checked = false;
        }
    }

    function exibirCampos() {
        let campo = document.getElementById("st_tiporesponsavellegal").value;
        if (campo != 'PENSIONISTA' && campo != '') {
            aux('nomeDeclarante', 'st_nomeresponsavellegal', '', 'block');
            aux('cpfDeclarante', 'st_cpfresponsavellegal', '', 'block');
        } else {
            aux('nomeDeclarante', 'st_nomeresponsavellegal', '', 'none');
            aux('cpfDeclarante', 'st_cpfresponsavellegal', '', 'none');
        }
    }
</script>

@endsection