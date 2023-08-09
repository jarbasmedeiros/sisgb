@extends('rh::funcionario.Form_edita_funcionario')
@section('title', 'SISGP - Dados Funcionais')
@section('tabcontent')
<div class="tab-pane active" id="dados_funcionais">
    <h4 class="tab-title">Dados Funcionais - {{ strtoupper($servidor->st_nome) }}</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('rh/servidor/edita/'.$servidor->id) }}">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Informações de Militar</legend>
            <div class="row">
                <div class="form-group{{$errors->has('st_matricula') ? 'has-error' : ''}} col-md-2">
                    <label for="st_matricula">Matrícula</label>
                    <input id="st_matricula" type="text" class="form-control" placeholder="Digite a Matricula" name="st_matricula" value="{{$servidor->st_matricula}}">
                    @if($errors->has('st_matricula'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_matricula')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('ce_graduacao') ? 'has-error' : ''}} col-md-3">
                    <label for="ce_graduacao" class="control-label">Posto/Graduação</label>
                    <select id="ce_graduacao" name="ce_graduacao" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($graduacoes as $g)
                            <option value="{{$g->id}}" {{($g->id == $servidor->ce_graduacao) ? 'selected': ''}}>{{$g->st_postograduacao}}</option>
                        @empty
                            <option>Não há orgãos cadastrados.</option>
                        @endforelse
                    </select>
                    @if($errors->has('ce_graduacao'))
                        <span class="help-block">
                            <strong>{{$errors->first('ce_graduacao')}}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group{{$errors->has('st_nomeguerra') ? 'has-error' : ''}} col-md-3">
                    <label for="st_nomeguerra" class="control-label">Nome de Guerra</label>
                    <input id="st_nomeguerra" type="text" class="form-control" name="st_nomeguerra" value="{{$servidor->st_nomeguerra}}">
                    @if($errors->has('st_nomeguerra'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_nomeguerra')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('st_quadrooperacional') ? 'has-error' : ''}} col-md-3">
                    <label for="st_quadrooperacional" class="control-label">Quadro Operacional - QO</label>
                    <input id="st_quadrooperacional" type="text" class="form-control" name="st_quadrooperacional" value="{{$servidor->st_quadrooperacional}}">
                    @if($errors->has('st_quadrooperacional'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_quadrooperacional')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('st_numeropraca') ? 'has-error' : ''}} col-md-2">
                    <label for="st_numeropraca" class="control-label">Número de Praça</label>
                    <input id="st_numeropraca" type="text" class="form-control" name="st_numeropraca" value="{{$servidor->st_numeropraca}}">
                    @if($errors->has('st_numeropraca'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_numeropraca')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('st_rgfuncional') ? 'has-error' : ''}} col-md-2">
                    <label for="st_rgfuncional" class="control-label">RG Funcional</label>
                    <input id="st_rgfuncional" type="text" class="form-control" name="st_rgfuncional" value="{{$servidor->st_rgfuncional}}">
                    @if($errors->has('st_rgfuncional'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_rgfuncional')}}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group{{$errors->has('dt_incorporacao') ? 'has-error' : ''}} col-md-3">
                    <label for="dt_incorporacao" class="control-label">Data de Incorporação</label>
                    <input id="dt_incorporacao" type="date" class="form-control" name="dt_incorporacao" value="{{$servidor->dt_incorporacao}}">
                    @if($errors->has('dt_incorporacao'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_incorporacao')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('st_antiguidade') ? 'has-error' : ''}} col-md-3">
                    <label for="st_antiguidade" class="control-label">Antiguidade</label>
                    <input id="st_antiguidade" type="text" class="form-control" name="st_antiguidade" value="{{$servidor->st_antiguidade}}">
                    @if($errors->has('st_antiguidade'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_antiguidade')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('st_nivelMilitar') ? 'has-error' : ''}} col-md-2">
                    <label for="st_nivelMilitar" class="control-label">Nivel</label>
                    <select id="st_nivelMilitar" name="st_nivelMilitar" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        <option {{$servidor->st_nivelMilitar == 'N/A' ? 'selected' : ''}} value="N/A">N/A</option>
                        <option {{$servidor->st_nivelMilitar == '1' ? 'selected' : ''}} value="1">1</option>
                        <option {{$servidor->st_nivelMilitar == '2' ? 'selected' : ''}} value="2">2</option>
                        <option {{$servidor->st_nivelMilitar == '3' ? 'selected' : ''}} value="3">3</option>
                        <option {{$servidor->st_nivelMilitar == '4' ? 'selected' : ''}} value="4">4</option>
                        <option {{$servidor->st_nivelMilitar == '5' ? 'selected' : ''}} value="5">5</option>
                        <option {{$servidor->st_nivelMilitar == '6' ? 'selected' : ''}} value="6">6</option>
                        <option {{$servidor->st_nivelMilitar == '7' ? 'selected' : ''}} value="7">7</option>
                        <option {{$servidor->st_nivelMilitar == '8' ? 'selected' : ''}} value="8">8</option>
                        <option {{$servidor->st_nivelMilitar == '9' ? 'selected' : ''}} value="9">9</option>
                        <option {{$servidor->st_nivelMilitar == '1' ? 'selected' : ''}} value="10">10</option>
                        <option {{$servidor->st_nivelMilitar == '1' ? 'selected' : ''}} value="11">11</option>
                        <option {{$servidor->st_nivelMilitar == '1' ? 'selected' : ''}} value="12">12</option>
                        <option {{$servidor->st_nivelMilitar == '1' ? 'selected' : ''}} value="13">13</option>
                        <option {{$servidor->st_nivelMilitar == '1' ? 'selected' : ''}} value="14">14</option>
                        <option {{$servidor->st_nivelMilitar == '1' ? 'selected' : ''}} value="15">15</option>
                    </select>
                    @if($errors->has('st_nivelMilitar'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_nivelMilitar')}}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group{{$errors->has('st_comportamento') ? 'has-error' : ''}} col-md-3">
                    <label for="st_comportamento" class="control-label">Comportamento</label>
                    <input id="st_comportamento" type="text" class="form-control" name="st_comportamento" value="{{$servidor->st_comportamento}}">
                    @if($errors->has('st_comportamento'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_comportamento')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('dt_bgcomportamento') ? 'has-error' : ''}} col-md-3">
                    <label for="dt_bgcomportamento" class="control-label">Data do BG do Comportamento</label>
                    <input id="dt_bgcomportamento" type="date" class="form-control" name="dt_bgcomportamento" value="{{$servidor->dt_bgcomportamento}}">
                    @if($errors->has('dt_bgcomportamento'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_bgcomportamento')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('st_bgcomportamento') ? 'has-error' : ''}} col-md-2">
                    <label for="st_bgcomportamento" class="control-label">BG do Comportamento</label>
                    <input id="st_bgcomportamento" type="text" class="form-control" name="st_bgcomportamento" value="{{$servidor->st_bgcomportamento}}">
                    @if($errors->has('st_bgcomportamento'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_bgcomportamento')}}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </fieldset>
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Informações do setor</legend>
            <div class="row">
                <div class="form-group{{ $errors->has('ce_setor') ? ' has-error' : '' }} col-md-8">
                    <label for="ce_setor" class="control-label">Setor</label>
                    <select id="ce_setor" name="ce_setor" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($setores as $s)
                            <option value="{{$s->id}}" {{( $s->id == $servidor->ce_setor) ? 'selected': '' }}>{{$s->st_sigla}}</option>
                        @empty
                            <option>Não há orgãos cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_setor'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_setor') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_devolucao') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_devolucao" class="control-label">Data de devolução</label>
                    <input id="dt_devolucao" type="date" class="form-control" name="dt_devolucao" value="{{ $servidor->dt_devolucao }}">
                    @if ($errors->has('dt_devolucao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_devolucao') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group{{ $errors->has('ce_funcao') ? ' has-error' : '' }} col-md-8">
                    <label for="ce_funcao" class="control-label">Função</label>
                    <select id="ce_funcao" name="ce_funcao" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($funcoes as $f)
                            <option value="{{$f->id}}" {{( $f->id == $servidor->ce_funcao) ? 'selected': '' }}>{{$f->st_funcao}}</option>
                        @empty
                            <option>Não há orgãos cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_funcao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_funcao') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('st_horariotrabalho') ? ' has-error' : '' }} col-md-2">
                    <label for="st_horariotrabalho" class="control-label">Horário de trabalho</label>
                    <select id="st_horariotrabalho" name="st_horariotrabalho" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        <option {{ $servidor->st_horariotrabalho == 'MANHÃ' ? 'selected':''}} value="MANHÃ">MANHÃ</option>
                        <option {{ $servidor->st_horariotrabalho == 'TARDE' ? 'selected':''}} value="TARDE">TARDE</option>
                        <option {{ $servidor->st_horariotrabalho == 'NOITE' ? 'selected':''}} value="NOITE">NOITE</option>
                        <option {{ $servidor->st_horariotrabalho == 'MANHÃ E TARDE' ? 'selected':''}} value="MANHÃ E TARDE">MANHÃ E TARDE</option>
                        <option {{ $servidor->st_horariotrabalho == 'OUTRO' ? 'selected':''}} value="OUTRO">OUTRO</option>
                    </select>
                    @if ($errors->has('st_horariotrabalho'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_horariotrabalho') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group{{ $errors->has('ce_status') ? ' has-error' : '' }} col-md-5">
                    <label for="ce_status" class="control-label">Situação</label>
                    <select id="ce_status" name="ce_status" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @if(isset( $status ) && count( $status )>0)
                            @foreach( $status as $key => $valor)
                                @if( $valor->id == $servidor->ce_status )
                                    <option value="{{ $valor->id}}" selected = "true">{{$valor->st_status}}</option>
                                @else
                                    <option value="{{ $valor->id}}">{{$valor->st_status}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('ce_status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_status') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }} col-md-4">
                    <label for="ce_unidade" class="control-label">OPM</label>
                    <select id="ce_unidade" name="ce_unidade" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($unidades as $u)
                            <option value="{{$u->id}}" {{( $u->id == $servidor->ce_unidade) ? 'selected': '' }}>{{$u->hierarquia}}</option>
                        @empty
                            <option>Não há uniades cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_setor'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_setor') }}</strong>
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
    </form>
</div>
@endsection