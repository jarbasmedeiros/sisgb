@extends('adminlte::page')

@section('title', 'Habilitações - Dados da Habilitação')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                Formulário de Habilitação - Dados da Habilitação
                </div>
                <input hidden name="idPessoa" type="text" value="{{ $dados->solicitante->id }}">
                <input hidden name="idPolicial" type="text" value="{{ $idPolicial }}">
                <div class="panel-body">
                    <form method="post" action="{{ URL::route('create_habilitacao', [$idPolicial, $dados->solicitante->id]) }}">
                    {{ csrf_field() }}
                    <fieldset class="scheduler-border">    	
                        <legend class="scheduler-border">Policial Selecionado</legend>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="st_nomepolicial">Nome</label>
                                <input disabled type="text" class="form-control"  value="{{ $dados->policial->st_nome }}">
                            </div>
                            
                            <div class="form-group col-md-2">
                                <label for="st_cpfpolicial">CPF</label>
                                <input disabled data-mask="000.000.000-00" type="text" class="form-control" value="{{ $dados->policial->st_cpf }}">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="bo_vivo">Vivo?</label>
                                <input disabled type="text" class="form-control" value="@if($dados->policial->bo_vivo == 1) SIM @else NÃO @endif">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="st_matriculapolicial">Matrícula</label>
                                <input disabled id="st_matricula" type="text" class="form-control" value="{{ $dados->policial->st_matricula }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="st_graduacao">Graduação</label>
                                <input disabled type="text" class="form-control" value="{{ $dados->policial->st_postograduacao }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="st_nivelpolicial">Nível da Graduação</label>
                                <input disabled type="text" class="form-control" value="{{ $dados->policial->st_nivel }}">
                            </div>
                        </div>        
                    </fieldset>

                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                Dados da Habilitação
                            </legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="st_tipo">Tipo</label>
                                        <select required class="form-control" name="st_tipo" id="st_tipo">
                                            <option value="">--Selecione--</option>
                                            <option value="POS_MORTE">Pós-Morte</option>
                                            <option value="JUDICIAL">Judicial</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="st_vinculo">Vínculo</label>
                                        <select required class="form-control" name="st_vinculo" id="st_tipovinculo">
                                            <option value="">--Selecione--</option>
                                            <option value="Pai/Mãe">Pai/Mãe</option>
                                            <option value="Filhos">Filhos</option>
                                            <option value="Conjuge">Conjuge</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                Dados do Solicitante
                            </legend>
                            <div class="row">       
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="st_nomesolicitante">
                                            Nome
                                        </label>
                                        <input class="form-control" id="st_nomesolicitante" name="st_nomesolicitante" required type="text" value="{{ $dados->solicitante->st_nome }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="st_cpfsolicitante">
                                            CPF
                                        </label>
                                        <input data-mask="000.000.000-00" class="form-control" id="st_cpf" name="st_cpfsolicitante" required type="text" value="{{ $dados->solicitante->st_cpf }}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="scheduler-border">    	
                            <legend class="scheduler-border">
                                Endereço do Solicitante
                            </legend>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="st_cep" >CEP</label>
                                    <input required id="st_cep" type="text" class="form-control" placeholder="Ex: 00000-000" name="st_cep" value="{{ $dados->solicitante->st_cep }}"> 
                                </div>
                                
                                <div class="form-group col-md-5">
                                    <label for="st_logradouro">Logradouro</label>
                                    <input required id="st_logradouro" type="text" class="form-control" placeholder="Digite sua rua, avenida ou travessa" name="st_logradouro" value="{{ $dados->solicitante->st_logradouro }}"> 
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="st_numeroresidencia" >Número</label>
                                    <input required id="st_numeroresidencia" type="text" class="form-control" placeholder="Ex: 12" name="st_numeroresidencia" value="{{ $dados->solicitante->st_numeroresidencia   }}"> 
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="st_bairro" >Bairro</label>
                                    <input required id="st_bairro" type="text" class="form-control" placeholder="Digite seu bairro" name="st_bairro" value=" {{ $dados->solicitante->st_bairro   }} "> 
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="st_cidade" >Cidade</label>
                                    <input required id="st_cidade" type="text" class="form-control" placeholder="Digite sua cidade" name="st_cidade" value=" {{ $dados->solicitante->st_cidade   }} "> 
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="st_ufendereco" class="control-label">UF</label>
                                    <select required id="st_ufendereco" name="st_ufendereco" class="form-control">
                                        <option value="">--Selecionar--</option>
                                        <option value="AC">AC</option>
                                        <option value="AL">AL</option>
                                        <option value="AP">AP</option>
                                        <option value="AM">AM</option>
                                        <option value="BA">BA</option>
                                        <option value="CE">CE</option>
                                        <option value="DF">DF</option>
                                        <option value="ES">ES</option>
                                        <option value="GO">GO</option>
                                        <option value="MA">MA</option>
                                        <option value="MT">MT</option>
                                        <option value="MS">MS</option>
                                        <option value="MG">MG</option>
                                        <option value="PA">PA</option>
                                        <option value="PB">PB</option>
                                        <option value="PR">PR</option>
                                        <option value="PE">PE</option>
                                        <option value="PI">PI</option>
                                        <option value="RJ">RJ</option>
                                        <option value="RN">RN</option>
                                        <option value="RS">RS</option>
                                        <option value="RO">RO</option>
                                        <option value="RR">RR</option>
                                        <option value="SC">SC</option>
                                        <option value="SP">SP</option>
                                        <option value="SE">SE</option>
                                        <option value="TO">TO</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="st_complemento" >Complemento</label>
                                    <input id="st_complemento" type="text" class="form-control" placeholder="Digite o complemento" name="st_complemento" value=" {{ $dados->solicitante->st_complemento }} "> 
                                </div> 
                            </div>
                        </fieldset>

                        <fieldset class="scheduler-border">    	
                            <legend class="scheduler-border">
                                Contato do Solicitante
                            </legend>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="st_telefonefixo" >Telefone Residencial</label>
                                    <input required id="st_telefonefixo" type="text" class="form-control" placeholder="Digite seu telefone" name="st_telefonefixo" value=" {{ $dados->solicitante->st_telefone   }} "> 
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="st_telefonecelular" >Telefone Celular</label>
                                    <input required id="st_telefonecelular" type="text" class="form-control" placeholder="Digite seu celular" name="st_telefonecelular" value=" {{ $dados->solicitante->st_telefonecelular   }} "> 
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="st_email" >Email</label>
                                    <input required id="st_email" type="text" class="form-control" placeholder="Digite seu email" name="st_email" value=" {{ $dados->solicitante->st_email   }} "> 
                                </div>                                
                            </div>
                        </fieldset>
                        
                        <fieldset class="scheduler-border">    	
                            <legend class="scheduler-border">Dados Bancários do Solicitante</legend>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="st_codigobanco">Código do Banco</label>
                                    <input required id="st_codigobanco" type="text" class="form-control" placeholder="Ex: 001" name="st_codigobanco" value=" {{ $dados->solicitante->st_codigobanco   }} "> 
                                </div>

                                <div class="form-group col-md-5">
                                    <label for="st_banco">Nome do Banco</label>
                                    <input required id="st_banco" type="text" class="form-control" placeholder="Ex: Caixa, Banco do Brasil..." name="st_banco" value=" {{ $dados->solicitante->st_banco   }} "> 
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="st_agencia">Agência</label>
                                    <input required id="st_agencia" type="text" class="form-control" placeholder="Ex: 000" name="st_agencia" value=" {{ $dados->solicitante->st_agencia   }} "> 
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="st_conta" class="control-label">Conta Corrente</label>
                                    <input required id="st_conta" type="text" class="form-control" placeholder="Ex: 000000" name="st_conta" value=" {{ $dados->solicitante->st_conta   }} "> 
                                </div>
                            </div>
                        </fieldset>
                    <a href=" {{ URL::previous() }} " class="btn btn-warning">
                        <span class="icon fa fa-arrow-left fa-lg"></span>
                        Voltar
                    </a>
                    <a href=" {{ URL::route('dps_tela_habilitacoes') }} " class="btn btn-danger">
                        <span class="icon fa fa-remove fa-lg"></span>
                        Cancelar
                    </a>
                    <button class="btn btn-primary">
                        <span class="icon fa fa-check-square-o fa-lg"></span>
                        Cadastrar
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection