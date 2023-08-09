@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Medalhas')
@section('tabcontent')
<!-- Autor: @aggeu. Issue 197, crude de medalhas de um policial. -->
<div class="tab-pane active" id="dados_medalhas">
    <h4 class="tab-title">Medalhas - {{ strtoupper($policial->st_nome) }}</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('rh/policiais/'.$policial->id.'/medalha/cadastra') }}">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Dados da Medalha</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }} col-md-2">
                    <label for="st_tipo">Tipo</label>
                    <select id="st_tipo" name="st_tipo" class="form-control" style="width: 100%;" required>
                        <option value="">Selecione</option>
                        
                           

                            <optgroup label="Medalhas Policial Militar">
                            <option value="30 Anos">Ouro (30 anos)</option>
                            <option value="20 Anos">Prata (20 anos)</option>
                            <option value="10 Anos">Bronze  (10 anos)</option>
                           
                            </optgroup>
                           
                            <optgroup label="Medalhas Meritória">
                            <option value="Tiradentes">Tiradentes</option>
                            <option value="Mérito Policial Militar"> Mérito Policial Militar</option>
                            <option value="Mérito Luiz Gonzaga">Mérito Luiz Gonzaga</option>
                            <option value="Mérito Profissional Coronel Bento Manoel de Medeiros">Mérito Profissional Coronel Bento Manoel de Medeiros</option>
                            <option value="Mérito Acadêmico Coronel Milton Freire de Andrade">Mérito Acadêmico Coronel Milton Freire de Andrade</option>
                            <option value="Mérito da Saúde  Coronel PM Médico Pedro Germano Costa">Mérito da Saúde  Coronel PM Médico Pedro Germano Costa</option>
                            <option value="Mérito de Polícia Judiciária Militar Estadual">Mérito de Polícia Judiciária Militar Estadual</option>
                            <option value="Reconhecimento da Capelania Militar Cristo Rei">Reconhecimento da Capelania Militar Cristo Rei</option>
                            <option value="Mérito Desportivo Militar Cabo PM Walter Silva">Mérito Desportivo Militar Cabo PM Walter Silva</option>
                            <option value="Comemorativa(HCCPG)">Comemorativa do Hospital(HCCPG)</option>
                           <option value="Mérito Musical Tonheca Dantas">Mérito Musical Tonheca Dantas </option>
                           <option value="Policial Militar do Mérito Operacional">Policial Militar do Mérito Operacional </option>
                            <option value="Mérito da Saúde Cel Pedro Germano">Mérito da Saúde Cel Pedro Germano</option>
                            
                            </optgroup>

                        </optgroup>
                    </select>  
                    @if ($errors->has('st_tipo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tipo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }} col-md-5">
                    <label for="st_nome">Nome</label>
                    <input id="st_nome" type="text" class="form-control" name="st_nome" required> 
                    @if ($errors->has('st_nome'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_nome') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_medalha') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_medalha">Data da Medalha</label>
                    <input id="dt_medalha" type="date" class="form-control" name="dt_medalha" required> 
                    @if ($errors->has('dt_medalha'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_medalha') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_publicacao') ? ' has-error' : '' }} col-md-3">
                    <label for="st_publicacao">Publicação</label>
                    <input id="st_publicacao" type="text" class="form-control" name="st_publicacao" required> 
                    @if ($errors->has('st_publicacao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_publicacao') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group{{ $errors->has('dt_publicacao') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_publicacao">Data da Publicação</label>
                    <input id="st_publicacao" type="date" class="form-control" name="dt_publicacao" required> 
                    @if ($errors->has('dt_publicacao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_publicacao') }}</strong>
                    </span>
                    @endif
                </div>            
            </div>
        </fieldset>
        <div class="form-group">
            <div class="col-md-offset-10">
                <a class="btn btn-warning" href="{{url('rh/policiais/edita/'.$policial->id.'/dados_medalhas')}}">Voltar</a>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </div>
    </form>
</div>
<!-- /.tab-pane -->
@endsection