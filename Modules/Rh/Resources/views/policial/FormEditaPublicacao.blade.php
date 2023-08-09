@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Publicações')
@section('tabcontent')
<div class="tab-pane active" id="publicacoes">
    <h4 class="tab-title">Publicações - {{ $policial->st_nome}}</h4>
    <hr class="separador">
       

        <form class="form"  method="post" action='{{url("rh/policiais/".$policial->id."/publicacao/".$publicacao->id."/edita")}}'> 
        {{csrf_field()}}
            <fieldset class="scheduler-border">    	
                <legend class="scheduler-border">Dados da Publicação</legend>
                <div class="row">
                    <div class="form-group{{ $errors->has('st_assunto') ? ' has-error' : '' }} col-md-4">
                        <label for="st_assunto">ASSUNTO</label>
                        <input id="st_assunto" type="text" class="form-control" placeholder="Assunto da Publicação" name="st_assunto" value="{{$publicacao->st_assunto}}"> 
                        @if ($errors->has('st_assunto'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_assunto') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('st_boletim') ? ' has-error' : '' }} col-md-3">
                        <label for="st_boletim">PUBLICAÇÃO</label>
                        <input id="st_boletim" type="text" class="form-control" placeholder="Boletim de Publicação" name="st_boletim" value="{{$publicacao->st_boletim}}"> 
                        @if ($errors->has('st_boletim'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_boletim') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('dt_publicacao') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_publicacao" class="control-label">DATA DE PUBLICAÇÃO</label>
                        <input id="dt_publicacao" type="date" class="form-control" name="dt_publicacao" value="{{$publicacao->dt_publicacao}}"> 
                        @if ($errors->has('dt_publicacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_publicacao') }}</strong>
                        </span>
                        @endif
                    </div>
                    

                    <div class="form-group{{ $errors->has('st_comportamento') ? ' has-error' : '' }} col-md-2">
                        <label for="st_comportamento" class="control-label">COMPORTAMENTO</label>
                        <select id="st_comportamento" name="st_comportamento" class="form-control">                        
                            <option value="EXCEPCIONAL" {{($publicacao->st_comportamento == 'EXCEPCIONAL') ? 'selected': ''}}>EXCEPCIONAL</option>                        
                            <option value="ÓTIMO" {{($publicacao->st_comportamento == 'ÓTIMO') ? 'selected': ''}}>ÓTIMO</option>
                            <option value="BOM" {{($publicacao->st_comportamento == 'BOM') ? 'selected': ''}}>BOM</option>
                            <option value="INSUFICIENTE" {{($publicacao->st_comportamento == 'INSUFICIENTE') ? 'selected': ''}}>INSUFICIENTE</option>
                            <option value="MAU" {{($publicacao->st_comportamento == 'MAU') ? 'selected': ''}}>MAU</option>
                        </select>
                        @if ($errors->has('st_comportamento'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_comportamento') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group{{ $errors->has('st_materia') ? ' has-error' : '' }} col-md-12">
                        <label for="st_materia" class="control-label">MATÉRIA</label>
                        <textarea id="st_materia" type="text" class="ckeditor form-control" name="st_materia" rows="5">{{$publicacao->st_materia}}</textarea>
                        @if ($errors->has('st_materia'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_materia') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

            </fieldset>    

            <div class="modal-footer">
            <button type="button" class="btn btn-warning">
                <a href="{{url('rh/policiais/'.$policial->id.'/publicacoes/listagem')}}"><font color=white>
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Voltar
                </font></a>                
            </button>
            @can('Edita_rh')
                <button type="submit" class="btn btn-primary">Salvar</button>
            @endcan
            </div>
            <!-- Definindo o metodo de envio -->
            {{ method_field('PUT') }}
        </form>
</div>

@endsection