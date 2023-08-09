@extends('rh::funcionario.Form_edita_funcionario')
@section('title', 'SISGP - Documentos')
@section('tabcontent')
<div class="tab-pane active" id="documentos">
    <h4 class="tab-title">Documentos - {{ strtoupper($servidor->st_nome) }}</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('rh/servidor/edita/'.$servidor->id) }}">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">CPF</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Número</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_cpf" placeholder="Ex: 000.000.000-00" value="{{ $servidor->st_cpf }}" required> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Identidade</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_rg') ? ' has-error' : '' }} col-md-2">
                    <label for="st_rg">Registro Geral</label>
                    <input id="st_rg" type="text" class="form-control" placeholder="Digite o número" name="st_rg" value="{{ $servidor->st_rg }}"> 
                    @if ($errors->has('st_rg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_rg') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_orgaorg') ? ' has-error' : '' }} col-md-2">
                    <label for="st_orgaorg">Órgão expedidor</label>
                    <input id="st_orgaorg" type="text" class="form-control" placeholder="Digite o orgão" name="st_orgaorg" value="{{ $servidor->st_orgaorg }}"> 
                    @if ($errors->has('st_orgaorg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_orgaorg') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_emissaorg') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_emissaorg" class="control-label">Data de emissão</label>
                    <input id="dt_emissaorg" type="date" class="form-control" name="dt_emissaorg" value="{{ $servidor->dt_emissaorg }}"> 
                    @if ($errors->has('dt_emissaorg'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_emissaorg') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Título Eleitoral</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('nu_titulo') ? ' has-error' : '' }} col-md-2">
                    <label for="nu_titulo">Título</label>
                    <input id="nu_titulo" type="text" class="form-control" placeholder="Digite o número" name="nu_titulo" value="{{ $servidor->nu_titulo }}"> 
                    @if ($errors->has('nu_titulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nu_titulo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('nu_zonatitulo') ? ' has-error' : '' }} col-md-1">
                    <label for="nu_zonatitulo">Zona</label>
                    <input id="nu_zonatitulo" type="text" class="form-control" placeholder="Digite a zona" name="nu_zonatitulo" value="{{ $servidor->nu_zonatitulo }}"> 
                    @if ($errors->has('nu_zonatitulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nu_zonatitulo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('nu_secaotitulo') ? ' has-error' : '' }} col-md-1">
                    <label for="nu_secaotitulo">Seção</label>
                    <input id="nu_secaotitulo" type="text" class="form-control" placeholder="Digite a seção" name="nu_secaotitulo" value="{{ $servidor->nu_secaotitulo }}"> 
                    @if ($errors->has('nu_secaotitulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nu_secaotitulo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_municipiotitulo') ? ' has-error' : '' }} col-md-3">
                    <label for="st_municipiotitulo">Município</label>
                    <input id="st_municipiotitulo" type="text" class="form-control" placeholder="Digite o município" name="st_municipiotitulo" value="{{ $servidor->st_municipiotitulo }}"> 
                    @if ($errors->has('st_municipiotitulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_municipiotitulo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_uftitulo') ? ' has-error' : '' }} col-md-2">
                    <label for="st_uftitulo" class="control-label">UF</label>
                    <select id="st_uftitulo" name="st_uftitulo" class="form-control">
                        <option value="">Selecione</option>
                        <option {{ $servidor->st_uftitulo == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $servidor->st_uftitulo == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $servidor->st_uftitulo == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $servidor->st_uftitulo == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $servidor->st_uftitulo == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $servidor->st_uftitulo == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $servidor->st_uftitulo == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $servidor->st_uftitulo == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $servidor->st_uftitulo == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $servidor->st_uftitulo == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $servidor->st_uftitulo == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $servidor->st_uftitulo == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $servidor->st_uftitulo == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $servidor->st_uftitulo == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $servidor->st_uftitulo == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $servidor->st_uftitulo == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $servidor->st_uftitulo == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $servidor->st_uftitulo == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $servidor->st_uftitulo == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $servidor->st_uftitulo == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $servidor->st_uftitulo == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $servidor->st_uftitulo == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $servidor->st_uftitulo == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $servidor->st_uftitulo == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $servidor->st_uftitulo == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $servidor->st_uftitulo == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $servidor->st_uftitulo == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_uftitulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_uftitulo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_emissaotitulo') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_emissaotitulo" class="control-label">Data de emissão</label>
                    <input id="dt_emissaotitulo" type="date" class="form-control" name="dt_emissaotitulo" value="{{ $servidor->dt_emissaotitulo }}"> 
                    @if ($errors->has('dt_emissaotitulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_emissaotitulo') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Carteira de Habilitação</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_cnh') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cnh">CNH</label>
                    <input id="st_cnh" type="text" class="form-control" placeholder="Digite o número" name="st_cnh" value="{{ $servidor->st_cnh }}"> 
                    @if ($errors->has('st_cnh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cnh') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_categoriacnh') ? ' has-error' : '' }} col-md-2">
                    <label for="st_categoriacnh">Categoria</label>
                    <input id="st_categoriacnh" type="text" class="form-control" placeholder="Digite a categoria" name="st_categoriacnh" value="{{ $servidor->st_categoriacnh }}"> 
                    @if ($errors->has('st_categoriacnh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_categoriacnh') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_vencimentocnh') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_vencimentocnh" class="control-label">Vencimento</label>
                    <input id="dt_vencimentocnh" type="date" class="form-control" name="dt_vencimentocnh" value="{{ $servidor->dt_vencimentocnh }}"> 
                    @if ($errors->has('dt_vencimentocnh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_vencimentocnh') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_ufcnh') ? ' has-error' : '' }} col-md-2">
                    <label for="st_ufcnh" class="control-label">UF</label>
                    <select id="st_ufcnh" name="st_ufcnh" class="form-control">
                        <option value="">Selecione</option>
                        <option {{ $servidor->st_ufcnh == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $servidor->st_ufcnh == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $servidor->st_ufcnh == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $servidor->st_ufcnh == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $servidor->st_ufcnh == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $servidor->st_ufcnh == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $servidor->st_ufcnh == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $servidor->st_ufcnh == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $servidor->st_ufcnh == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $servidor->st_ufcnh == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $servidor->st_ufcnh == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $servidor->st_ufcnh == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $servidor->st_ufcnh == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $servidor->st_ufcnh == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $servidor->st_ufcnh == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $servidor->st_ufcnh == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $servidor->st_ufcnh == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $servidor->st_ufcnh == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $servidor->st_ufcnh == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $servidor->st_ufcnh == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $servidor->st_ufcnh == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $servidor->st_ufcnh == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $servidor->st_ufcnh == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $servidor->st_ufcnh == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $servidor->st_ufcnh == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $servidor->st_ufcnh == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $servidor->st_ufcnh == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_ufcnh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_ufcnh') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_emissaocnh') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_emissaocnh" class="control-label">Data de Emissão</label>
                    <input id="dt_emissaocnh" type="date" class="form-control" name="dt_emissaocnh" value="{{ $servidor->dt_emissaocnh }}"> 
                    @if ($errors->has('dt_emissaocnh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_emissaocnh') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Carteira de Trabalho</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_carteiratrabalho') ? ' has-error' : '' }} col-md-2">
                    <label for="st_carteiratrabalho">Número</label>
                    <input id="st_carteiratrabalho" type="text" class="form-control" placeholder="Digite o número" name="st_carteiratrabalho" value="{{ $servidor->st_carteiratrabalho }}"> 
                    @if ($errors->has('st_carteiratrabalho'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_carteiratrabalho') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_seriecarteiratrabalho') ? ' has-error' : '' }} col-md-2">
                    <label for="st_seriecarteiratrabalho">Série</label>
                    <input id="st_seriecarteiratrabalho" type="text" class="form-control" placeholder="Digite a série" name="st_seriecarteiratrabalho" value="{{ $servidor->st_seriecarteiratrabalho }}"> 
                    @if ($errors->has('st_seriecarteiratrabalho'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_seriecarteiratrabalho') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_ufcarteiratrabalho') ? ' has-error' : '' }} col-md-2">
                    <label for="st_ufcarteiratrabalho" class="control-label">UF</label>
                    <select id="st_ufcarteiratrabalho" name="st_ufcarteiratrabalho" class="form-control">
                        <option value="">Selecione</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $servidor->st_ufcarteiratrabalho == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_ufcarteiratrabalho'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_ufcarteiratrabalho') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">NIS (PIS/PASEP)</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('nu_pis_pasep') ? ' has-error' : '' }} col-md-2">
                    <label for="nu_pis_pasep">Número</label>
                    <input id="nu_pis_pasep" type="text" class="form-control" placeholder="Digite o número" name="nu_pis_pasep" value="{{ $servidor->nu_pis_pasep }}"> 
                    @if ($errors->has('nu_pis_pasep'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nu_pis_pasep') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Certificado Militar</legend>
            <div class="row">
                <div class="form-group{{$errors->has('st_certificadomilitar') ? 'has-error' : ''}} col-md-2">
                    <label for="st_certificadomilitar">Número de Reservista</label>
                    <input id="st_certificadomilitar" type="text" class="form-control" placeholder="Digite o número" name="st_certificadomilitar" value="{{$servidor->st_certificadomilitar}}">
                    @if($errors->has('st_certificadomilitar'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_certificadomilitar')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('dt_reservista') ? 'has-error' : ''}} col-md-3">
                    <label for="dt_reservista" class="control-label">Data de Reservista</label>
                    <input id="dt_reservista" type="date" class="form-control" name="dt_reservista" value="{{$servidor->dt_reservista}}">
                    @if($errors->has('dt_reservista'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_reservista')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('dt_eliminReser') ? 'has-error' : ''}} col-md-3">
                    <label for="dt_eliminReser" class="control-label">Data de Elimin Reser</label>
                    <input id="dt_eliminReser" type="date" class="form-control" name="dt_eliminReser" value="{{$servidor->dt_eliminReser}}">
                    @if($errors->has('dt_eliminReser'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_eliminReser')}}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </fieldset>

        <div class="form-group">
            <div class="col-md-offset-5">
                <button type="submit" class=" btn btn-primary">
                    <i class="fa fa-fw fa-save"></i> Salvar
                </button>
            </div>
        </div>
    </form>
</div>
@endsection