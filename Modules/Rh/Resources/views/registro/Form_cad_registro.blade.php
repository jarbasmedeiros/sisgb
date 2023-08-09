@extends('adminlte::page')

@section('title', 'Cadastro de Caderneta de Regsitro')
<?php
use App\utis\Funcoes;
$select = 2;
?>

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Cadastro de Publicação</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/rh/registro/'.$funcionario->id.'/'.$tiporegistro) }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Funcionário</label>
                            <div class="col-md-6">
                                <input type="text" disabled class="form-control" required="true" value="{{$funcionario->st_nome}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if(isset( $itens) && count( $itens)>0)
                            @foreach($itens as $item)
                                @if($item->st_nomeitem == 'Texto Curto')
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-4 control-label">{{$item->st_nome}}</label>
                                        <div class="col-md-6">
                                            @if($item->st_nome == 'Tipo' && $item->ce_tiporegistro == 2)
                                                <select name="{{$item->id}}" require="true" class="form-control" required="true">
                                                    <option value="">Selecione</option>
                                                    <option value="LICENÇA ESPECIAL">LICENÇA ESPECIAL</option>
                                                    <option value="LICENÇA PARA TRATAR DE INTERESSE PARTICULAR">LICENÇA PARA TRATAR DE INTERESSE PARTICULAR</option>
                                                    <option value="LICENÇA PARA TRATAMENTO DE SAÚDE DE PESSOA DA FAMÍLIA">LICENÇA PARA TRATAMENTO DE SAÚDE DE PESSOA DA FAMÍLIA</option>
                                                    <option value="LICENÇA PARA TRATAMENTO DA PRÓPRIA SAÚDE">LICENÇA PARA TRATAMENTO DA PRÓPRIA SAÚDE</option>
                                                    <option value="LICENÇA NÚPCIAS">LICENÇA NÚPCIAS</option>
                                                    <option value="LICENÇA LUTO">LICENÇA LUTO</option>
                                                    <option value="LICENÇA INSTALAÇÃO">LICENÇA INSTALAÇÃO</option>
                                                    <option value="LICENÇA TRÂNSITO">LICENÇA TRÂNSITO</option>
                                                    <option value="LICENÇA MATERNIDADE">LICENÇA MATERNIDADE</option>
                                                    <option value="LICENÇA PATERNIDADE">LICENÇA PATERNIDADE</option>
                                                    <option value="OUTROS">OUTROS</option>
                                                </select>
                                            @elseif($item->st_nome == 'Setor')
                                                <select id="{{$item->id}}" name="{{$item->id}}" class="form-control" required>
                                                    <option value="" selected>Selecione</option>
                                                    @forelse($listSetor as $s)
                                                        <option value="{{$s->id}}" {{ ($s->id == $funcionario->ce_setor) ? 'selected': '' }}>{{$s->st_sigla}}</option>
                                                    @empty
                                                        <option>Não há setores cadastrados.</option>
                                                    @endforelse
                                                </select>
                                            @elseif($item->st_nome == 'Dias' && $item->ce_tiporegistro != 1)
                                                <input type="text" name="{{$item->id}}" id="rgts{{$item->id}}" required="true" class="form-control" onchange="datafim()">
                                            @elseif($item->st_nome == 'Dias' && $item->ce_tiporegistro == 1)
                                                <input type="text" name="{{$item->id}}" id="rgts{{$item->id}}" required="true" class="form-control" value="30" onchange="datafim()" readonly>    
                                            @else
                                                <input type="text" name="{{$item->id}}" id="rgts{{$item->id}}" required="true" class="form-control" value="">
                                            @endif
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @elseif($item->st_nomeitem == 'Data')
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-4 control-label">{{$item->st_nome}}</label>
                                        <div class="col-md-6">
                                            @if($item->st_nome == 'Início')
                                                <input type="date" name="{{$item->id}}" id="rgts{{$item->id}}" class="form-control" onchange="datafim()">
                                            @elseif($item->st_nome == 'Fim' && $item->ce_tiporegistro == 1)
                                                <input type="date" name="{{$item->id}}" id="rgts{{$item->id}}" class="form-control" readonly>
                                            @else
                                                <input type="date" name="{{$item->id}}" id="rgts{{$item->id}}" class="form-control">
                                            @endif
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @elseif($item->st_nomeitem == 'Texto longo')
                                    <div class="form-group{{ $errors->has('st_descricao') ? ' has-error' : '' }}">
                                        <label for="st_descricao" class="col-md-4 control-label">{{$item->st_nome}}</label>
                                        <div class="col-md-6 ">
                                            <textarea name="{{$item->id}}" cols="120" rows="4" class="form-control" placeholder="{{$item->st_nome}}" value="{{ old('st_descricao') }}"></textarea>
                                            @if ($errors->has('st_descricao'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('st_descricao') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if($tiporegistro != 4)
                                <div class="col-md-6 col-md-offset-4 form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }}">
                                    <label for="st_tipo" class="control-label"> Altera Status?</label>
                                    <div>
                                        <select id="st_alterastatus" onclick="alterarstatusservidor()" name="st_alterastatus" require="true" class="form-control-required" required="required">
                                            <option value="">Selecione</option>
                                            <option value="Não">Não</option>
                                            <option value="Sim">Sim</option>
                                        </select>

                                        @if ($errors->has('st_alterastatus'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('st_alterastatus') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div id='status' style="display: none;" class="col-md-6 form-inline{{ $errors->has('st_status') ? ' has-error' : '' }}">
                                    <label for="st_status" class="control-label"> Status Funcioário</label>

                                    <div>
                                        <select id="st_status" name="st_status" desabled class="form-control-required" disabled>
                                            <option value="">Selecione</option>
                                            @if(isset($status) && count($status)>0)
                                            @foreach($status as $s)
                                            <option value="{{$s->id}}">{{$s->st_status}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('st_status'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('st_status') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if($funcionario->bo_ativo == 1 && $tiporegistro == 3)
                            <div class="col-md-12  form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }}">
                                <div class="col-md-6  form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }}">
                                    <label for="st_tipo" class="control-label"> Desativa funcionários</label>
                                    <div>
                                        <select id="st_desativafuncionario" onclick="desativafuncionario()" name="st_desativafuncionario" require="true" class="form-control-required" required="required">
                                            <option value="">Selecione</option>
                                            <option value="Não">Não</option>
                                            <option value="Sim">Sim</option>
                                        </select>
                                        @if ($errors->has('st_desativafuncionario'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('st_desativafuncionario') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div id='motivo' style="display: none;" class="col-md-6 form-inline{{ $errors->has('st_status') ? ' has-error' : '' }}">
                                    <label for="st_motivo" class="control-label"> Tipo da inatividade</label>
                                    <div>
                                        <select id="st_motivo" name="st_motivo" class="form-control-required" disabled>
                                            <option value="">Selecione</option>
                                            <option value="ABANDONO DE CARGO">Abandono de Cargo</option>
                                            <option value="APOSENTADO">Aposentado</option>
                                            <option value="DEVOLVIDO">Devolvido</option>
                                            <option value="DEMITIDO">Demitido</option>
                                            <option value="EXONERADO">Exonerado</option>
                                            <option value="FALECIDO">Falecido</option>
                                            <option value="RELOTADO">Relotado</option>
                                            <option value="OUTROS">Outros</option>
                                        </select>
                                        @if ($errors->has('st_motivo'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('st_motivo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($funcionario->bo_ativo != 1 && $tiporegistro == 3)
                            <div class="col-md-12 form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }}">
                                <div class="col-md-4  form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }}">
                                    <label for="st_tipo" class="control-label"> Ativa funcionários</label>
                                    <div>
                                        <select id="st_ativafuncionario" onclick="ativafuncionario()" name="st_ativafuncionario" require="true" class="form-control-required" required="required">
                                            <option value="">Selecione</option>
                                            <option value="Não">Não</option>
                                            <option value="Sim">Sim</option>
                                        </select>
                                        @if ($errors->has('st_ativafuncionario'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('st_ativafuncionario') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div id="ativa" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-4 form-inline{{ $errors->has('st_status') ? ' has-error' : '' }}">
                                            <label for="dt_posse" class="control-label">Data de Posse</label>
                                            <div>
                                                <input type="date" name="dt_posse" id="dt_posse" class="form-control" disabled>
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-inline{{ $errors->has('st_status') ? ' has-error' : '' }}">
                                            <label for="dt_exercicio" class="control-label">Data de Exercício</label>
                                            <div>
                                                <input type="date" name="dt_exercicio" id="dt_exercicio" class="form-control" disabled>
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-inline{{ $errors->has('st_status') ? ' has-error' : '' }}">
                                            <label for="ce_cargo" class="control-label">Cargo</label>
                                            <div>
                                                <select id="ce_cargo" name="ce_cargo" class="form-control" disabled>
                                                    <option value="" selected>Selecione</option>
                                                    @forelse($listCargo as $c)
                                                        <option value="{{$c->id}}" {{ ($c->id == $funcionario->ce_cargo) ? 'selected': '' }}>{{$c->st_cargo}}</option>
                                                    @empty
                                                        <option>Não há orgãos cadastrados.</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-inline{{ $errors->has('st_status') ? ' has-error' : '' }}">
                                            <label for="ce_orgao" class="control-label">Orgão</label>
                                            <div>
                                                <select id="ce_orgao" name="ce_orgao" class="form-control" disabled>
                                                    <option value="" selected>Selecione</option>
                                                    @forelse($listOrgao as $o)
                                                        <option value="{{$o->id}}" {{ ($o->id == $funcionario->ce_orgao) ? 'selected': '' }}>{{$o->st_sigla}}</option>
                                                    @empty
                                                        <option>Não há orgãos cadastrados.</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group col-md-12">
                            <div class="col-md-2">
                                <a href="javascript:history.back()" class=" btn btn-danger" title="Voltar">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>
                            </div>
                            <button type="submit" class="col-md-2 btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @stop
    @section('scripts')
        <script>
            function datafim(){ // Função para alterar data final automaticamente no cadastro de férias e licenças
                if($('#rgts1').length){ // verificação para saber se está na página de férias ou licenças
                    var dias = $('#rgts1').val();
                    var dt_ini = $('#rgts2').val();
                    if(dias && dt_ini){
                        $('#rgts3').val(calcData(dias, dt_ini));
                    }
                } else {
                    var dias = $('#rgts6').val();
                    var dt_ini = $('#rgts7').val();
                    if(dias && dt_ini){
                        $('#rgts8').val(calcData(dias, dt_ini));
                    }
                }
            }
        </script>
    @endsection