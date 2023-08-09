@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Documentos')
@section('tabcontent')
<div class="tab-pane active" id="documentos">
    <h4 class="tab-title">Documentos - {{ $policial->st_nome}}</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('rh/policiais/edita/'.$policial->id.'/documentos') }}">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">CPF</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">Número</label>
                    <input id="st_cpf" type="text" class="form-control" name="st_cpf" placeholder="Ex: 000.000.000-00" value="{{ $policial->st_cpf }}"> 
                    @if ($errors->has('st_cpf'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cpf') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Documento de Origem</legend>
        @can('EMITIR_RG')
        
            <div class="row">
                <div class="form-group{{ $errors->has('st_registrocivil') ? ' has-error' : '' }} col-md-12">
                    <label for="st_registrocivil">Certidão de Nascimento/Casamento/Divórcio</label>
                    <input id="st_registrocivil" type="text" class="form-control" placeholder="Digite o número" name="st_registrocivil" value="{{ $policial->st_registrocivil }}"> 
                    @if ($errors->has('st_registrocivil'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_registrocivil') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_rgmilitar') ? ' has-error' : '' }} col-md-2">
                    <label for="st_rgmilitar">RG Militar</label>
                    <input id="st_rgmilitar" type="text" class="form-control" placeholder="Digite o número" name="st_rgmilitar" value="{{ $policial->st_rgmilitar }}"> 
                    @if ($errors->has('st_rgmilitar'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_rgmilitar') }}</strong>
                    </span>
                    @endif
                </div>
               <!--  <div class="form-group{{ $errors->has('dt_emissaorgmilitar') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_emissaorgmilitar" class="control-label">Data de emissão</label>
                    <input id="dt_emissaorgmilitar" type="date" class="form-control" name="dt_emissaorgmilitar" value="{{ $policial->dt_emissaorgmilitar }}"> 
                    @if ($errors->has('dt_emissaorgmilitar'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_emissaorgmilitar') }}</strong>
                    </span>
                    @endif
                </div> -->
            </div>
        @else
        <div class="row">
                <div class="form-group{{ $errors->has('st_registrocivil') ? ' has-error' : '' }} col-md-12">
                    <label for="st_registrocivil">Certidão de Nascimento/Casamento </label>
                    <input id="st_registrocivil" type="text" class="form-control" placeholder="Digite o número" name="st_registrocivil" value="{{ $policial->st_registrocivil }}"readonly> 
                    @if ($errors->has('st_registrocivil'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_registrocivil') }}</strong>
                    </span>
                    @endif
                </div>
           
                <div class="form-group{{ $errors->has('st_rgmilitar') ? ' has-error' : '' }} col-md-2">
                    <label for="st_rgmilitar">RG Militar</label>
                    <input id="st_rgmilitar" type="text" class="form-control" placeholder="Digite o número" name="st_rgmilitar" value="{{ $policial->st_rgmilitar }}"readonly> 
                    @if ($errors->has('st_rgmilitar'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_rgmilitar') }}</strong>
                    </span>
                    @endif
                </div>
                <!-- <div class="form-group{{ $errors->has('dt_emissaorgmilitar') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_emissaorgmilitar" class="control-label">Data de emissão</label>
                    <input id="dt_emissaorgmilitar" type="date" class="form-control" name="dt_emissaorgmilitar" value="{{ $policial->dt_emissaorgmilitar }}"> 
                    @if ($errors->has('dt_emissaorgmilitar'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_emissaorgmilitar') }}</strong>
                    </span>
                    @endif
                </div> -->
            </div>
        @endcan
        </fieldset>
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Identidade</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_rgcivil') ? ' has-error' : '' }} col-md-2">
                    <label for="st_rgcivil">RG Civil</label>
                    <input id="st_rgcivil" type="text" class="form-control" placeholder="Digite o número" name="st_rgcivil" value="{{ $policial->st_rgcivil }}"> 
                    @if ($errors->has('st_rgcivil'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_rgcivil') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_orgaorgcivil') ? ' has-error' : '' }} col-md-2">
                    <label for="st_orgaorgcivil">Órgão expedidor</label>
                    <input id="st_orgaorgcivil" type="text" class="form-control" placeholder="Digite o orgão" name="st_orgaorgcivil" value="{{ $policial->st_orgaorgcivil }}"> 
                    @if ($errors->has('st_orgaorgcivil'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_orgaorgcivil') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_emissaorgcivil') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_emissaorgcivil" class="control-label">Data de emissão</label>
                    <input id="dt_emissaorgcivil" type="date" class="form-control" name="dt_emissaorgcivil" value="{{ $policial->dt_emissaorgcivil }}"> 
                    @if ($errors->has('dt_emissaorgcivil'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_emissaorgcivil') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            
 
        </fieldset>
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Título Eleitoral</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_titulo') ? ' has-error' : '' }} col-md-2">
                    <label for="st_titulo">Título</label>
                    <input id="st_titulo" type="text" class="form-control" placeholder="Digite o número" name="st_titulo" value="{{ $policial->st_titulo }}"> 
                    @if ($errors->has('st_titulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_titulo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_zonatitulo') ? ' has-error' : '' }} col-md-1">
                    <label for="st_zonatitulo">Zona</label>
                    <input id="st_zonatitulo" type="text" class="form-control" placeholder="Digite a zona" name="st_zonatitulo" value="{{ $policial->st_zonatitulo }}"> 
                    @if ($errors->has('st_zonatitulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_zonatitulo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_secaotitulo') ? ' has-error' : '' }} col-md-1">
                    <label for="st_secaotitulo">Seção</label>
                    <input id="st_secaotitulo" type="text" class="form-control" placeholder="Digite a seção" name="st_secaotitulo" value="{{ $policial->st_secaotitulo }}"> 
                    @if ($errors->has('st_secaotitulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_secaotitulo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_municipiotitulo') ? ' has-error' : '' }} col-md-3">
                    <label for="st_municipiotitulo">Município</label>
                    <input id="st_municipiotitulo" type="text" class="form-control" placeholder="Digite o município" name="st_municipiotitulo" value="{{ $policial->st_municipiotitulo }}"> 
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
                        <option {{ $policial->st_uftitulo == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $policial->st_uftitulo == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $policial->st_uftitulo == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $policial->st_uftitulo == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $policial->st_uftitulo == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $policial->st_uftitulo == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $policial->st_uftitulo == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $policial->st_uftitulo == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $policial->st_uftitulo == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $policial->st_uftitulo == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $policial->st_uftitulo == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $policial->st_uftitulo == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $policial->st_uftitulo == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $policial->st_uftitulo == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $policial->st_uftitulo == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $policial->st_uftitulo == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $policial->st_uftitulo == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $policial->st_uftitulo == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $policial->st_uftitulo == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $policial->st_uftitulo == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $policial->st_uftitulo == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $policial->st_uftitulo == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $policial->st_uftitulo == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $policial->st_uftitulo == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $policial->st_uftitulo == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $policial->st_uftitulo == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $policial->st_uftitulo == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_uftitulo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_uftitulo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_emissaotitulo') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_emissaotitulo" class="control-label">Data de emissão</label>
                    <input id="dt_emissaotitulo" type="date" class="form-control" name="dt_emissaotitulo" value="{{ $policial->dt_emissaotitulo }}"> 
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
                    <input id="st_cnh" type="text" class="form-control" placeholder="Digite o número" name="st_cnh" value="{{ $policial->st_cnh }}"> 
                    @if ($errors->has('st_cnh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_cnh') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_categoriacnh') ? ' has-error' : '' }} col-md-2">
                    <label for="st_categoriacnh">Categoria</label>
                    <input id="st_categoriacnh" type="text" class="form-control" placeholder="Digite a categoria" name="st_categoriacnh" value="{{ $policial->st_categoriacnh }}"> 
                    @if ($errors->has('st_categoriacnh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_categoriacnh') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_vencimentocnh') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_vencimentocnh" class="control-label">Data de Validade</label>
                    <input id="dt_vencimentocnh" type="date" class="form-control" name="dt_vencimentocnh" value="{{ $policial->dt_vencimentocnh }}"> 
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
                        <option {{ $policial->st_ufcnh == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $policial->st_ufcnh == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $policial->st_ufcnh == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $policial->st_ufcnh == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $policial->st_ufcnh == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $policial->st_ufcnh == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $policial->st_ufcnh == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $policial->st_ufcnh == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $policial->st_ufcnh == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $policial->st_ufcnh == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $policial->st_ufcnh == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $policial->st_ufcnh == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $policial->st_ufcnh == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $policial->st_ufcnh == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $policial->st_ufcnh == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $policial->st_ufcnh == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $policial->st_ufcnh == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $policial->st_ufcnh == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $policial->st_ufcnh == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $policial->st_ufcnh == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $policial->st_ufcnh == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $policial->st_ufcnh == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $policial->st_ufcnh == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $policial->st_ufcnh == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $policial->st_ufcnh == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $policial->st_ufcnh == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $policial->st_ufcnh == 'TO' ? 'selected':''}} value="TO">TO</option>
                    </select>
                    @if ($errors->has('st_ufcnh'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_ufcnh') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_emissaocnh') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_emissaocnh" class="control-label">Data de Emissão</label>
                    <input id="dt_emissaocnh" type="date" class="form-control" name="dt_emissaocnh" value="{{ $policial->dt_emissaocnh }}"> 
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
                    <input id="st_carteiratrabalho" type="text" class="form-control" placeholder="Digite o número" name="st_carteiratrabalho" value="{{ $policial->st_carteiratrabalho }}"> 
                    @if ($errors->has('st_carteiratrabalho'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_carteiratrabalho') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_seriecarteiratrabalho') ? ' has-error' : '' }} col-md-2">
                    <label for="st_seriecarteiratrabalho">Série</label>
                    <input id="st_seriecarteiratrabalho" type="text" class="form-control" placeholder="Digite a série" name="st_seriecarteiratrabalho" value="{{ $policial->st_seriecarteiratrabalho }}"> 
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
                        <option {{ $policial->st_ufcarteiratrabalho == 'AC' ? 'selected':''}} value="AC">AC</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'AL' ? 'selected':''}} value="AL">AL</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'AP' ? 'selected':''}} value="AP">AP</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'AM' ? 'selected':''}} value="AM">AM</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'BA' ? 'selected':''}} value="BA">BA</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'CE' ? 'selected':''}} value="CE">CE</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'DF' ? 'selected':''}} value="DF">DF</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'ES' ? 'selected':''}} value="ES">ES</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'GO' ? 'selected':''}} value="GO">GO</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'MA' ? 'selected':''}} value="MA">MA</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'MT' ? 'selected':''}} value="MT">MT</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'MS' ? 'selected':''}} value="MS">MS</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'MG' ? 'selected':''}} value="MG">MG</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'PA' ? 'selected':''}} value="PA">PA</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'PB' ? 'selected':''}} value="PB">PB</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'PR' ? 'selected':''}} value="PR">PR</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'PE' ? 'selected':''}} value="PE">PE</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'PI' ? 'selected':''}} value="PI">PI</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'RJ' ? 'selected':''}} value="RJ">RJ</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'RN' ? 'selected':''}} value="RN">RN</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'RS' ? 'selected':''}} value="RS">RS</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'RO' ? 'selected':''}} value="RO">RO</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'RR' ? 'selected':''}} value="RR">RR</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'SC' ? 'selected':''}} value="SC">SC</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'SP' ? 'selected':''}} value="SP">SP</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'SE' ? 'selected':''}} value="SE">SE</option>
                        <option {{ $policial->st_ufcarteiratrabalho == 'TO' ? 'selected':''}} value="TO">TO</option>
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
                <div class="form-group{{ $errors->has('st_pispasep') ? ' has-error' : '' }} col-md-2">
                    <label for="st_pispasep">Número</label>
                    <input id="st_pispasep" type="text" class="form-control" placeholder="Digite o número" name="st_pispasep" value="{{ $policial->st_pispasep }}"> 
                    @if ($errors->has('st_pispasep'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_pispasep') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Certificado Militar</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_certificadomilitar') ? ' has-error' : '' }} col-md-3">
                    <label for="st_certificadomilitar">Registro de Alistamento (RA)</label>
                    <input id="st_certificadomilitar" type="text" class="form-control" placeholder="Digite o RA" name="st_certificadomilitar" value="{{$policial->st_certificadomilitar}}">
                    @if($errors->has('st_certificadomilitar'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_certificadomilitar')}}</strong>
                        </span>
                    @endif
                </div>
          
                <div class="form-group{{ $errors->has('st_reservista') ? ' has-error' : '' }} col-md-8">
                    <label for="st_reservista">Observações</label>
                    <input id="st_reservista" type="text" class="form-control" placeholder="Observações do Alistamento" name="st_reservista" value="{{$policial->st_reservista}}">
                    @if($errors->has('st_reservista'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_reservista')}}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <div class="form-group">
            <div class="col-md-offset-5">
                
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-fw fa-save"></i> Salvar
                </button>
            </div>
        </div>
        <!-- Definindo o metodo de envio -->
        {{ method_field('PUT') }}
    </form>
</div>
@endsection