@extends('adminlte::page')
@section('title', 'Distribuir efetivo')
@section('content')
<div class="container">
    <form role="form" method="POST" action="{{ url('rh/planoferias/'.$ano.'/trocarturma') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
            <input id="ano" type="hidden" class="form-control" readonly required="true"  placeholder="Informe o ano" name="ano" value="{{ $ano }}">
            <div class="row">
                        <!-- Campo Turmas -->
                        <div class="form-group col-md-4{{ $errors->has('ano') ? ' has-error' : '' }} ">
                        <label for="turma">Selecione a turma:</label>
                        <select class="form-control" name="ce_turmaferias">
                           @foreach ($turmas as $turma)
                               <option value="{{ $turma->id }}"> Turma {{ $turma->st_turma }}</option>
                           @endforeach
                        </select>
                        </div>
        </div>
                  <input type="hidden" class="col-md-12" id="ce_policial"  name="ce_policial" value="{{ $ce_policial}}" >

    
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-4">
                                <a class="btn btn-warning" href="{{url('/rh/planoferias')}}" style='margin-right: 10px;'>
                                    <i class="fa fa-arrow-left"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-fw fa-save"></i> Salvar
                                </button>
                            </div>
                        </div>
                    </div>
    </form>
</div>
@stop