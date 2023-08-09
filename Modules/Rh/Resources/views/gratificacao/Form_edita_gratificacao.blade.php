@extends('adminlte::page')

@section('title', 'Edita Gratificações')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Altera Gratificação</div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="myForm" role="form" method="POST" action="{{ url('/rh/gratificacao/edita/'.$gratificacao->id) }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('st_gratificacao') ? ' has-error' : '' }}">
                                <label for="st_gratificacao" class="col-md-4 control-label">Nome</label>
    
                                <div class="col-md-6">
                                    <input id="st_gratificacao" type="text" class="form-control" required="true" placeholder="Nome da Gratificação" name="st_gratificacao" value="{{ $gratificacao->st_gratificacao }}"> 
                                    @if ($errors->has('st_gratificacao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_gratificacao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('vl_gratificacao') ? ' has-error' : '' }}">
                                <label for="vl_gratificacao" class="col-md-4 control-label">Valor</label>
    
                                <div class="col-md-6">
                                    <input id="vl_gratificacao" type="text" class="form-control" required="true" placeholder="Valor" name="vl_gratificacao" value="{{ substr(str_replace(".",",", $gratificacao->vl_gratificacao), 0, -2) }}"> 
                                    @if ($errors->has('vl_gratificacao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vl_gratificacao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('nu_vagas') ? ' has-error' : '' }}">
                                <label for="nu_vagas" class="col-md-4 control-label">Quantidade de Vagas</label>
    
                                <div class="col-md-6">
                                    <input id="nu_vagas" type="number" required="true" class="form-control" placeholder="Quantidade de Vagas" name="nu_vagas" value="{{ $gratificacao->nu_vagas }}"> 
                                    @if ($errors->has('nu_vagas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nu_vagas') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group ">
                                <div class="col-md-2  col-md-offset-4">
                                    <a href="javascript:history.back()" class=" btn btn-danger"  title="Voltar">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>
                                </div>
                                <button type="submit" class="col-md-2 btn btn-primary">
                                    <i class="fa fa-check"> </i> Salvar
                                </button>
                            </div>
    
    
                        </form>
                       
                        
                    </div>
                </div>
            </div>
        </div>
        @section('scripts')
        <script>
            $(document).ready(function(){
                $("#vl_gratificacao").inputmask('currency', {
                            'alias': 'numeric',
                            'decimalProtect': true,
                            'groupSeparator': '.',
                            'autoGroup': true,
                            'digits': 2,
                            'radixPoint': ",",
                            'digitsOptional': false,
                            'allowMinus': false,
                            'prefix': 'R$ ',
                            'placeholder': '0',
                            'removeMaskOnSubmit': true
                });
            });
        </script>
        @endsection
@stop