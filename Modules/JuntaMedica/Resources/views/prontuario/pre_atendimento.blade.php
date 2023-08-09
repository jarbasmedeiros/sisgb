@extends('adminlte::page')
<?php
use App\utis\Funcoes;
?>
@section('title', 'Novo Atendimento')

@section('content')
<div class="row">


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">FORMULÁRIO PARA REGISTRO DE ATENDIMENTOS PELA JUNTA MÉDICA</div>

            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('juntamedica/atendimento/criar/'.$prontuario->id) }}">
                {{ csrf_field() }}
                    @if(isset($_GET['bo_retorno']) && isset($_GET['idAtendimento']))
                    <input hidden name="bo_retorno" value="{{$_GET['bo_retorno']}}"/>
                    <input hidden name="ce_pai" value="{{$_GET['idAtendimento']}}"/>
                    @endif
                    <div id="ce_sessao" class="form-group{{ $errors->has('ce_sessao') ? ' has-error' : '' }}">
                        <label for="ce_sessao" class="col-md-4 control-label">Tipo da Sessão</label>
                        <div class="col-md-6">
                            <select id="ce_sessao" type="text" name="ce_sessao" class="form-control" required>
                                @foreach ($sessoesabertas as $tiposessao)
                                    @if(!$tiposessao->bo_conferida)
                                        @if ($tiposessao->ce_tipo == 1)
                                            <option value="{{$tiposessao->id}}" selected="selected">{{"Sessão ".$tiposessao->nu_sequencial." (".$tiposessao->st_tipo.")"}}</option>
                                        @else
                                            <option value="{{$tiposessao->id}}">{{"Sessão ".$tiposessao->nu_sequencial." (".$tiposessao->st_tipo.")"}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>                           
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('st_sei') ? ' has-error' : '' }}">
                        <label for="st_sei" class="col-md-4 control-label">Número do sei</label>
                        <div class="col-md-6">
                            <input id="st_sei" type="text"  class="form-control" name="st_sei"  > 
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_obs') ? ' has-error' : '' }}">
                        <label for="st_obs" class="col-md-4 control-label">Observações</label>
                        <div class="col-md-6">
                        <textarea rows="4" cols="63" id="st_obs" name="st_obs" class="form-control" placeholder="Observações..."></textarea>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-md-2  col-md-offset-4">
                            <a class="btn btn-warning" title="Voltar" href="{{url('juntamedica/prontuario/show/'.$prontuario->id)}}">
                            <i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
                        </div>                       
                        <button type="submit" class="col-md-2 btn btn-primary">
                            <i class="fa fa-fw fa-save"> </i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="{{asset('js/juntamedica.js') }}"></script>
<script src="{{asset('js/functions.js') }}"></script>
     
@stop

@section('js')
    <script>
        function SomenteNumero(e) {
            var tecla = (window.event) ? event.keyCode : e.which;
            if ((tecla > 47 && tecla < 58)) return true;
            else {
                if (tecla == 8 || tecla == 0) return true;
                else return false;
            }
        }
    </script>
@endsection