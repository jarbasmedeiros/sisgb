@extends('boletim::boletim.template_boletim')

@section('title', 'Cria Boletim')

@section('content_dinamic')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Criar Tópico</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url('/boletim/topico/create')}}">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label for="st_parte" class="col-md-4 control-label">Parte do boletim</label>
                            <div class="col-md-3">
                               
                                <select id="st_parte"  required name="st_parte" class="form-control">
                                    <option value="">Selecione</option>
                                   
                                            <option value="1">1ª Parte</option>
                                            <option value="2">2ª Parte</option>
                                            <option value="3">3ª Parte</option>
                                            <option value="4">4ª Parte</option>
                                     
                                </select>
                                @if ($errors->has('st_parte'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_parte') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="st_topico" class="col-md-4 control-label">Tópico</label>

                            <div class="col-md-3">
                                <input id="st_topico" type="input" required class="form-control" name="st_topico" value=""> 
                                @if ($errors->has('st_topico'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_topico') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                       
                        <div class="form-group ">
                            <div class="col-md-2  col-md-offset-4">
                                <a href='{{ url("boletim/topicos/lista")}}' class=" btn btn-danger"  title="Voltar">
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
@stop