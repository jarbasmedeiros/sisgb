@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Medalhas')
@section('tabcontent')
<!-- Autor: @aggeu. Issue 197, crude de medalhas de um policial. -->

        <div class="tab-pane active" id="dados_medalhas">
            <h4 class="tab-title">Medalhas - {{ $policial->st_nome}}</h4>
            <hr class="separador">
            <form role="form" method="post" action="{{ url('rh/policiais/'.$policial->id.'/medalha/'.$idMedalha.'/edita') }}">
                {{ csrf_field() }}
                @if(isset($medalha))
                    @foreach($medalha as $m)
                        @if($m->id == $idMedalha)
                            <fieldset class="scheduler-border">    	
                                <legend class="scheduler-border">Dados da Medalha</legend>
                                <div class="row">
                                    <div class="form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }} col-md-2">
                                        <label for="st_tipo">Tipo</label>
                                        <select id="st_tipo" name="st_tipo" class="form-control" style="width: 100%;">
                                            <option value="" selected>Selecione</option>
                                            <option {{$m->st_tipo == 'Sem medalha' ? 'selected' : ''}} value="Sem medalha">Sem medalha</option>
                                            <option {{$m->st_tipo == '10 Anos' ? 'selected' : ''}} value="10 Anos">10 Anos</option>
                                            <option {{$m->st_tipo == '20 Anos' ? 'selected' : ''}} value="20 Anos">20 Anos</option>
                                            <option {{$m->st_tipo == '30 Anos' ? 'selected' : ''}} value="30 Anos">30 Anos</option>
                                            <option {{$m->st_tipo == 'Condecoração meritória' ? 'selected' : ''}} value="Condecoração meritória">Condecoração meritória</option>
                                        </select> 
                                        @if ($errors->has('st_tipo'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_tipo') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }} col-md-5">
                                        <label for="st_nome">Nome</label>
                                        <input id="st_nome" type="text" class="form-control" name="st_nome" value="{{$m->st_nome}}"> 
                                        @if ($errors->has('st_nome'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_nome') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('dt_medalha') ? ' has-error' : '' }} col-md-2">
                                        <label for="dt_medalha">Data da Medalha</label>
                                        <input id="dt_medalha" type="date" class="form-control" name="dt_medalha" value="{{$m->dt_medalha}}"> 
                                        @if ($errors->has('dt_medalha'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('dt_medalha') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('st_publicacao') ? ' has-error' : '' }} col-md-3">
                                        <label for="st_publicacao">Publicação</label>
                                        <input id="st_publicacao" type="text" class="form-control" name="st_publicacao"value="{{$m->st_publicacao}}" > 
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
                                        <input id="st_publicacao" type="date" class="form-control" name="dt_publicacao" value="{{$m->dt_publicacao}}"> 
                                        @if ($errors->has('dt_publicacao'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('dt_publicacao') }}</strong>
                                        </span>
                                        @endif
                                    </div>            
                                </div>
                            </fieldset>
                        @endif
                    @endforeach
                @endif
                
                <div class="form-group">
                    <div class="col-md-offset-10">
                        <a class="btn btn-warning" href="{{url('rh/policiais/edita/'.$policial->id.'/dados_medalhas')}}">Voltar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
                <!-- Definindo o metodo de envio -->
                {{ method_field('PUT') }}
            </form>
        </div>

<!-- /.tab-pane -->
@endsection