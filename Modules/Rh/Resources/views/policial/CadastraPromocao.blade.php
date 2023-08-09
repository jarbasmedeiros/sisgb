@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Promoção')
@section('tabcontent')
<!-- Autor: @aggeu. Issue 193, implementar aba de promoções. -->
<div class="tab-pane active" id="dados_promocao">
    <h4 class="tab-title">Promoções - {{ ($policial->st_nome) }}</h4>
    <hr class="separador">
    <form role="form" method="post" action="{{ url('rh/policiais/'.$policial->id.'/promocoes/cadastra') }}">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">    	
            <legend class="scheduler-border">Dados da Promoção</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('st_promocao') ? ' has-error' : '' }} col-md-2">
                    <label for="st_promocao">Promoção</label>
                    <select id="st_promocao" name="st_promocao" class="form-control" style="width: 100%;" required>
                        <option value="" >Selecione</option>
                        @forelse($graduacoes as $g)
                            <option value="{{$g->st_postograduacao}}">{{$g->st_postograduacao}}</option>
                        @empty
                            <option>Não há orgãos cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('st_promocao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_promocao') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_promocao') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_promocao">Data de Promoção</label>
                    <input id="dt_promocao" type="date" class="form-control" name="dt_promocao" required> 
                    @if ($errors->has('dt_promocao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_promocao') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_boletim') ? ' has-error' : '' }} col-md-2">
                    <label for="st_boletim">Publicação</label>
                    <input id="st_boletim" type="text" class="form-control" name="st_boletim" required> 
                    @if ($errors->has('st_boletim'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_boletim') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_boletim') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_boletim">Data de Publicação</label>
                    <input id="dt_boletim" type="date" class="form-control" name="dt_boletim" required> 
                    @if ($errors->has('dt_boletim'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_boletim') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_doe') ? ' has-error' : '' }} col-md-2">
                    <label for="st_doe">DOE</label>
                    <input id="st_doe" type="text" class="form-control" name="st_doe" > 
                    @if ($errors->has('st_doe'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_doe') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_doe') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_doe">Data do DOE</label>
                    <input id="dt_doe" type="date" class="form-control" name="dt_doe"> 
                    @if ($errors->has('dt_doe'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_doe') }}</strong>
                    </span>
                    @endif
                </div>  
            </div>
        </fieldset>
        <div class="form-group">
            <div class="col-md-offset-10">
                <a class="btn btn-warning" href="{{url('rh/policiais/edita/'.$policial->id.'/promocoes/listagem')}}">Voltar</a>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </div>
    </form>
</div>
<!-- /.tab-pane -->
@endsection