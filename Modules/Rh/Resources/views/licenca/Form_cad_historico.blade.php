@extends('adminlte::page')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">Cadastro de Histórico</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('rh/historicolicenca/store/licenca/' . $idPolicial . '/' . $idLicenca) }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('nu_dias') ? ' has-error' : '' }}">
                                <label for="nu_dias" class="col-md-2 control-label">Dias:</label>
                                <div class="col-md-2">
                                    <input type="number" id="dias" name="nu_dias" class="form-control" required="true" onchange="datafim()">
                                    @if ($errors->has('nu_dias'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nu_dias') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('dt_inicio') ? ' has-error' : '' }}">
                                <label for="dt_inicio" class="col-md-2 control-label">Data Inicial:</label>
                                <div class="col-md-4">
                                    <input type="date" id="inicio" name="dt_inicio" class="form-control" required="true" onchange="datafim()">
                                    @if ($errors->has('dt_inicio'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('dt_inicio') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('dt_fim') ? ' has-error' : '' }}">
                                <label for="dt_fim" class="col-md-2 control-label">Data Final:</label>
                                <div class="col-md-4">
                                    <input type="date" id="fim" name="dt_fim" class="form-control" required="true" readonly>
                                    @if ($errors->has('dt_fim'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('dt_fim') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('st_descricao') ? ' has-error' : '' }}">
                                <label for="st_descricao" class="col-md-2 control-label">Descrição:</label>
                                <div class="col-md-8">
                                    <textarea id="descricao" name="st_descricao" rows="6" class="form-control"></textarea>
                                    @if ($errors->has('st_descricao'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('st_descricao') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-2">
                                    <a href="{{url('rh/historicolicenca/lista/' . $idPolicial . '/' . $idLicenca)}}" class=" btn btn-danger" title="Voltar">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>
                                </div>
                                <button type="submit" class="col-md-2 btn btn-primary">
                                    <i class="fa fa-btn fa-save"></i> Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        function datafim(){
            var dias = $('#dias').val();
            var dt_ini = $('#inicio').val();
            if(dias && dt_ini){
                $('#fim').val(calcData(dias, dt_ini));
            }
        }
    </script>
@endsection