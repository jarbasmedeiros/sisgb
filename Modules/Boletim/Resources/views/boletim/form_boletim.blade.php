@extends('boletim::boletim.template_boletim')

@section('title', 'Cria Boletim')

@section('content_dinamic')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Criar Boletim</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url('/boletim/create')}}">
                    {{csrf_field()}}
                    @if(isset($idBoletim))
                    <input id="ce_pai" type="hidden" required class="form-control" name="ce_pai" value="{{$idBoletim}}"> 
                    <input id="ce_tipo" type="hidden" required class="form-control" name="ce_tipo" value="7"> 
                    @else

                        <div class="form-group">
                            <label for="ce_tipo" class="col-md-4 control-label">Tipo de Boletim</label>
                            <div class="col-md-3">
                               
                                <select id="ce_tipo"  required name="ce_tipo" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($tipos as $tipo)
                                       @if($tipo->id != 7)
                                            @if($tipo->st_sigla == 'BG')
                                                @can('elabora_bg')
                                                <option value="{{ $tipo->id}}">{{$tipo->st_tipo}}</option>
                                                @endcan
                                            @else  
                                                <option value="{{ $tipo->id}}">{{$tipo->st_tipo}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('st_tipo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ce_tipo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    @endif
                        <div class="form-group">
                        @if(isset($idBoletim))
                            <label for="dt_boletim" class="col-md-4 control-label">Data do Aditamento</label>
                        @else
                            <label title="O Boletim só pode ser criado com a data do dia." for="dt_boletim" class="col-md-4 control-label">Data do Boletim</label>
                        @endif

                            <div class="col-md-3">
                                <input title="O Boletim só pode ser criado com a data do dia." disabled id="dt_boletim" type="date" required class="form-control" name="dt_boletim" value="{{ $data}}"> 
                                @if ($errors->has('dt_boletim'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_boletim') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-md-1  col-md-offset-4" >
                                <a href='{{ url("boletim/lista_boletim_pendente")}}' class=" btn btn-danger"  title="Voltar">
                                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                </a>
                            </div>
                            <div class="col-md-2"  >
                                <button type="submit" class="btn btn-primary col-md-12" >
                                    <i class="fa fa-save"> </i> Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop