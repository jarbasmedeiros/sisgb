@extends('adminlte::page')

@section('title', 'Cadastro de Solicitante')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Formulário de Habilitação - 
                    @isset($solicitante)
                        Selecionar Solicitante
                    @else
                        Pesquisar/Cadastrar Solicitante
                    @endisset
                </div>
                <div class="panel-body">

                    <form action="{{ URL::route('get_pessoa_cpf') }}" method="GET">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                Pesquisa de Solicitante por CPF
                            </legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="st_cpf">CPF do Solicitante</label>
                                    <div class="input-group">
                                        <input hidden type="text" name="idPolicial" value="{{ $idPolicial }}">
                                        <input required id="st_cpf" class="form-control" name="st_cpf" type="text">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>

                    @if(Session::has('erroMsg'))
                        <form action="{{ URL::route('create_pessoa', ['idPolicial' => $idPolicial]) }}" method="POST">
                            {{ csrf_field() }}

                            <fieldset class="scheduler-border">   	
                                <legend class="scheduler-border">Identificação</legend>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="st_nome">Nome</label>
                                        <input id="st_nome" type="text" class="form-control" placeholder="Digite o nome" name="st_nome" required> 
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="st_cpf">CPF</label>
                                        <input id="st_cpf" type="text" data-mask="000.000.000-00" class="form-control" placeholder="Digite o CPF" name="st_cpf" required> 
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="dt_nascimento" class="control-label">
                                            Data de Nascimento
                                        </label>
                                        <input id="dt_nascimento" type="date" class="form-control" name="dt_nascimento" required> 
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label for="st_sexo" class="control-label">Sexo</label>
                                        <div class="radio">
                                            <label class="radio-option">
                                                <input type="radio" name="st_sexo" id="st_sexo" value="MASCULINO" checked required>
                                                Masculino
                                            </label>
                                            <label class="radio-option">
                                                <input type="radio" name="st_sexo" id="st_sexo" value="FEMININO"  required>
                                                Feminino
                                            </label>
                                        </div>
                                    </div>  

                                    <div class="form-group col-md-4">
                                        <label for="st_mae" class="control-label">Filiação (Mãe)</label>
                                        <input required id="st_mae" type="text"  class="form-control" placeholder="Digite o nome da mãe" name="st_mae"> 
                                    </div>     
                                    
                                    <div class="form-group col-md-3">
                                        <label for="st_rgcivil">RG</label>
                                        <input id="st_rgcivil" data-mask="000.000.000" type="text" class="form-control" placeholder="Digite o RG" name="st_rgcivil" required> 
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="st_orgaorgcivil">Orgão emissor do RG</label>
                                        <input id="st_orgaorgcivil" type="text" class="form-control" placeholder="Digite o orgão emissor do RG" name="st_orgaorgcivil" required> 
                                    </div>
                                </div>     
                            </fieldset>
                    
                            <fieldset class="scheduler-border">    	
                                <legend class="scheduler-border">Endereço</legend>

                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="st_cep" >CEP</label>
                                        <input required id="st_cep" type="text" class="form-control" data-mask="00000-000" placeholder="Digite seu CEP" name="st_cep" value> 
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="st_logradouro">Logradouro</label>
                                        <input required id="st_logradouro" type="text" class="form-control" placeholder="Digite sua rua, avenida ou travessa" name="st_logradouro"> 
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="st_numeroresidencia" >Número</label>
                                        <input required id="st_numeroresidencia" type="text" class="form-control" placeholder="Ex: 12" name="st_numeroresidencia"> 
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="st_bairro" >Bairro</label>
                                        <input required id="st_bairro"   type="text" class="form-control" placeholder="Digite seu bairro" name="st_bairro"> 
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="st_cidade" >Cidade</label>
                                        <input required id="st_cidade" type="text" class="form-control" placeholder="Digite sua cidade" name="st_cidade"> 
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="st_ufendereco" class="control-label">UF</label>
                                        <select required id="st_ufendereco" name="st_ufendereco" class="form-control">
                                            <option value="">Selecione</option>
                                            <option  value="AC">AC</option>
                                            <option  value="AL">AL</option>
                                            <option  value="AP">AP</option>
                                            <option  value="AM">AM</option>
                                            <option  value="BA">BA</option>
                                            <option  value="CE">CE</option>
                                            <option  value="DF">DF</option>
                                            <option  value="ES">ES</option>
                                            <option  value="GO">GO</option>
                                            <option  value="MA">MA</option>
                                            <option  value="MT">MT</option>
                                            <option  value="MS">MS</option>
                                            <option  value="MG">MG</option>
                                            <option  value="PA">PA</option>
                                            <option  value="PB">PB</option>
                                            <option  value="PR">PR</option>
                                            <option  value="PE">PE</option>
                                            <option  value="PI">PI</option>
                                            <option  value="RJ">RJ</option>
                                            <option  value="RN">RN</option>
                                            <option  value="RS">RS</option>
                                            <option  value="RO">RO</option>
                                            <option  value="RR">RR</option>
                                            <option  value="SC">SC</option>
                                            <option  value="SP">SP</option>
                                            <option  value="SE">SE</option>
                                            <option  value="TO">TO</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="st_complemento" >Complemento</label>
                                        <input required id="st_complemento"   type="text" class="form-control" placeholder="Digite o complemento" name="st_complemento"> 
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="scheduler-border">    	
                                <legend class="scheduler-border">Contato</legend>

                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="st_telefonefixo" >Telefone Residencial</label>
                                        <input id="st_telefonefixo"   type="text" class="form-control" placeholder="Digite seu telefone" name="st_telefonefixo" value=""> 
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="st_telefonecelular" >Telefone Celular</label>
                                        <input required id="st_telefonecelular" data-mask="(00) 90000-0000" type="text" class="form-control" placeholder="Digite seu celular" name="st_telefonecelular"> 
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="scheduler-border">    	
                                <legend class="scheduler-border">Dados Bancários</legend>

                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="st_codigobanco">Código do Banco</label>
                                        <input required id="st_codigobanco"   type="text" class="form-control" placeholder="Ex: 001" name="st_codigobanco"> 
                                    </div>

                                    <div class="form-group col-md-5">
                                        <label for="st_banco">Nome do Banco</label>
                                        <input required id="st_banco" type="text" class="form-control" placeholder="Ex: Caixa, Banco do Brasil..." name="st_banco"> 
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="st_agencia">Agência</label>
                                        <input required id="st_agencia" type="text" class="form-control" placeholder="Ex: 000" name="st_agencia" value> 
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="st_conta" class="control-label">Conta Corrente</label>
                                        <input required id="st_conta" type="text" class="form-control" placeholder="Ex: 000000" name="st_conta"> 
                                    </div>
                                </div>
                            </fieldset>

                            <a href=" {{ URL::previous() }} " class="btn btn-warning">
                                <span class="glyphicon glyphicon-arrow-left"></span>
                                Voltar
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <span class="icon fa fa-save fa-lg"></span>
                                Cadastrar
                            </button>
                        </form>
                    @elseif(isset($solicitante))
                        <table class="table">
                            <thead class="bg-primary">
                                <div class="row">
                                    <th class="col-md-5">
                                        Nome
                                    </th>
                                    <th class="col-md-2">
                                        CPF
                                    </th>
                                    <th class="col-md-2">
                                        Data de Nascimento
                                    </th>
                                    <th>
                                        Sexo
                                    </th>
                                    <th class="col-md-1">
                                        Ações
                                    </th>
                                </div>
                                
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ $solicitante->st_nome }}
                                    </td>
                                    <td>
                                        {{ $solicitante->st_cpf }}
                                    </td>
                                    <td>
                                        {{ 
                                            date('d/m/Y', strtotime($solicitante->dt_nascimento))
                                        }}
                                    </td>
                                    <td>
                                        {{ $solicitante->st_sexo }}
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="
                                        {{
                                            URL::route('dps_tela_dados_solicitacao', [
                                                'idPessoa' => $solicitante->id,
                                                'idPolicial' => $idPolicial
                                            ])
                                        }}
                                        ">
                                            <span class="icon fa fa-check fa-lg"></span>
                                            Selecionar
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <a href=" {{ URL::previous() }} " class="btn btn-warning">
                                            <span class="glyphicon glyphicon-arrow-left"></span>
                                            Voltar
                                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection