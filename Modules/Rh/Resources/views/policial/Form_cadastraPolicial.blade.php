@extends('adminlte::page')
@section('title', 'SISGP - Novo Policial')
@section('content')

<div class="tab-pane active" id="novo_policial">
    <h4 class="tab-title">Inserir Novo Policial</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('rh/policiais/cadastro/novo') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Informações de Militar</legend>
            <div class="row">
                <!-- Campo nome -->
                <div class="form-group{{ $errors->has('st_nome') ? ' has-error' : '' }} col-md-2">
                    <label for="st_nome">Nome</label>
                    <input id="st_nome" type="text" class="form-control" required="true"  placeholder="Digite o nome do policial" name="st_nome">
                    @if ($errors->has('st_nome'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_nome') }}</strong>
                        </span>
                    @endif
                </div>
                 <!-- Campo cpf -->
                <div class="form-group{{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                    <label for="st_cpf">CPF</label>
                    <input id="st_cpf" type="text" class="form-control" placeholder="Digite o CPF do policial" required="true" name="st_cpf" >
                    @if ($errors->has('st_cpf'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_cpf') }}</strong>
                        </span>
                    @endif
                </div>
                <!-- Campo cpf -->
                <div class="form-group{{ $errors->has('st_matricula') ? ' has-error' : '' }} col-md-2">
                    <label for="st_matricula">Matrícula</label>
                    <input id="st_matricula" type="text" class="form-control" placeholder="Digite a Matricula" name="st_matricula" >
                    @if ($errors->has('st_matricula'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_matricula') }}</strong>
                        </span>
                    @endif
                </div>
                <!-- Campo Gradução -->
                <div class="form-group{{ $errors->has('ce_graduacao') ? ' has-error' : '' }} col-md-2">
                    <label for="ce_graduacao" class="control-label">Posto/Graduação</label>
                    <select id="ce_graduacao" name="ce_graduacao" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($graduacoes as $g)
                            <option value="{{$g->id}}" >{{$g->st_postograduacao}}</option>
                        @empty
                            <option>Não há orgãos cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_graduacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_graduacao') }}</strong>
                        </span>
                    @endif
                </div>

                <!-- Campo Nome de Guerra -->
                <div class="form-group{{ $errors->has('st_nomeguerra') ? ' has-error' : '' }} col-md-2">
                    <label for="st_nomeguerra" class="control-label">Nome de Guerra</label>
                    <input id="st_nomeguerra" type="text" class="form-control" name="st_nomeguerra">
                    @if ($errors->has('st_nomeguerra'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_nomeguerra') }}</strong>
                        </span>
                    @endif
                </div>

            </div>
            <div class="row">
                <!-- Campo Unidade -->
                <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }} col-md-4">
                    <label for="ce_unidade" class="control-label">Unidade</label>
                    <select id="ce_unidade" name="ce_unidade" class="form-control select2" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($unidades as $u)
                            <option value="{{$u->id}}" >{{$u->st_nomepais}}</option>
                        @empty
                            <option>Não há unidades cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_unidade'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_unidade') }}</strong>
                        </span>
                    @endif
                </div>

                <!-- Campo Data da Incorporação -->
                <div class="form-group{{ $errors->has('dt_incorporacao') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_incorporacao" class="control-label">Data de Incorporação</label>
                    <input id="dt_incorporacao" type="date" class="form-control" required="true" name="dt_incorporacao" >
                    @if($errors->has('dt_incorporacao'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_incorporacao')}}</strong>
                        </span>
                    @endif
                </div>  
                          
     
                <!-- Campo Status -->
                <div class="form-group{{ $errors->has('ce_status') ? ' has-error' : '' }} col-md-2">
                        <label for="ce_status" class="control-label">Status</label>
                        <select id="ce_status" name="ce_status" class="form-control" style="width: 100%;">
                            <option value="" selected>Selecione</option>
                            @forelse($status as $s)
                                <option value="{{$s->id}}">{{$s->st_nome}}</option>
                            @empty
                                <option>Não há status cadastrados.</option>
                            @endforelse
                        </select>
                        @if ($errors->has('ce_status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_status') }}</strong>
                            </span>
                        @endif
                </div>
                 <!-- Campo Quadro -->
                 <div class="form-group{{ $errors->has('ce_qpmp') ? ' has-error' : '' }} col-md-2">
                    <label for="ce_qpmp" class="control-label">Quadro</label>
                    <select id="ce_qpmp" name="ce_qpmp" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($quadro as $q)
                            <option value="{{$q->id}}" >{{$q->st_qpmp}}</option>
                        @empty
                            <option>Não há quadros cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_qpmp'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_qpmp') }}</strong>
                        </span>
                    @endif
                </div> 
             
            </div>
        </fieldset>        
        <div class="form-group">
            <div class="col-md-4">
                <a class="btn btn-warning" href="{{url('/')}}" style='margin-right: 10px;'>
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-fw fa-save"></i> Salvar
                </button>
            </div>
        </div>
        <!-- Definindo o metodo de envio -->
    </form>
</div>
@endsection



