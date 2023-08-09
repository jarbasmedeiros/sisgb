@extends('adminlte::page')

@section('title', 'Mover Boletim')

@section('css')
<style>
    .mt-20{ margin-top: 25px; }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Mover Boletim</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('pesquisarUnidadesMoverBoletim') }}">
                    {{csrf_field()}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Pesquisar Unidades</legend>
                            <div class="form-group">
                                <div class="col-md-3 col-md-offset-3">
                                    <label for="st_origem" class="col-md-offset-5">Origem</label>
                                    <input id="st_origem" type="text" required class="form-control" name="st_origem" value=""> 
                                    @if ($errors->has('st_origem'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_origem') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="st_destino" class="col-md-offset-5">Destino</label>
                                    <input id="st_destino" type="text" required class="form-control" name="st_destino" value=""> 
                                    @if ($errors->has('st_destino'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_destino') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-1 mt-20">
                                    <button type="submit" class="btn btn-primary" title="Pesquisar">
                                        <i class="fa  fa-search"> </i>
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('MoverBoletim') }}">
                    {{csrf_field()}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Origem</legend>
                            <div class="form-group">
                                <div class="col-md-1">
                                    <label for="id_origem" class="col-md-offset-5">Id</label>
                                    <input id="id_origem" type="text" required readonly class="form-control" name="id_origem" value="{{ $unidadeOrigem->id or '' }}"> 
                                    @if ($errors->has('id_origem'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id_origem') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label for="st_sigla_origem" class="col-md-offset-5">Sigla</label>
                                    <input id="st_sigla_origem" type="text" required readonly class="form-control" name="st_sigla_origem" value="{{ $unidadeOrigem->st_sigla or '' }}"> 
                                    @if ($errors->has('st_sigla_origem'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_sigla_origem') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <label for="st_nomepais_origem" class="col-md-offset-5">Unidades Pais</label>
                                    <input id="st_nomepais_origem" type="text" required readonly class="form-control" name="st_nomepais_origem" value="{{ $unidadeOrigem->st_nomepais or '' }}"> 
                                    @if ($errors->has('st_nomepais_origem'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_nomepais_origem') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Destino</legend>
                            <div class="form-group">
                                <div class="col-md-1">
                                    <label for="id_destino" class="col-md-offset-5">Id</label>
                                    <input id="id_destino" type="text" required readonly class="form-control" name="id_destino" value="{{ $unidadeDestino->id or '' }}"> 
                                    @if ($errors->has('id_destino'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id_destino') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label for="st_sigla_destino" class="col-md-offset-5">Sigla</label>
                                    <input id="st_sigla_destino" type="text" required readonly class="form-control" name="st_sigla_destino" value="{{ $unidadeDestino->st_sigla or '' }}"> 
                                    @if ($errors->has('st_sigla_destino'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_sigla_destino') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <label for="st_nomepais_destino" class="col-md-offset-5">Unidades Pais</label>
                                    <input id="st_nomepais_destino" type="text" required readonly class="form-control" name="st_nomepais_destino" value="{{ $unidadeDestino->st_nomepais or '' }}"> 
                                    @if ($errors->has('st_nomepais_destino'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_nomepais_destino') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                    
                        <div class="form-group ">
                            <button type="submit" class="col-md-2 btn btn-primary col-md-offset-4">
                                <i class="fa fa-exchange"></i> Movimentar
                            </button>
                            <div class="col-md-2  ">
                                <a href='{{ url("/")}}' class=" btn btn-danger"  title="Cancelar">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop