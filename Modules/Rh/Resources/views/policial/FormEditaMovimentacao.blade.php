@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Publicações')
@section('tabcontent')
<div class="tab-pane active" id="publicacoes">
    <h4 class="tab-title">Movimentação - {{ $policial->st_nome}}</h4>
    <hr class="separador">
       

        <form class="form"  method="post" action='{{url("rh/policiais/".$policial->id."/movimentacao/".$movimentacao->id."/edita")}}'> 
        {{csrf_field()}}
            <fieldset class="scheduler-border">    	
                <legend class="scheduler-border">Dados da Movimentação</legend>
                <div class="row">
                <div class="form-group{{ $errors->has('ce_unidadeorigem') ? ' has-error' : '' }}" class="col-md-12">
                    <div class="col-md-12">
                    <label for="st_boletim">UNIDADE DE ORIGEM</label>
                        <select class="form-control select2" name="ce_unidadeorigem"  data-placeholder="Selecione a unidade de origem" style="width: 100%;" required>
                                <option value="">Selecione a Unidade de Origem</option>
                            @foreach($unidades as $u)
                            @if($movimentacao->ce_unidadeorigem == $u->id)
                                <option value="{{$u->id}}" selected>{{$u->hierarquia}}</option>
                                @else
                                <option value="{{$u->id}}">{{$u->hierarquia}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div> 
                <div class="form-group{{ $errors->has('ce_unidadedestino') ? ' has-error' : '' }}" class="col-md-12">
                    <div class="col-md-12">
                    <label for="st_boletim">UNIDADE DESTINO</label>
                        <select class="form-control select2" name="ce_unidadedestino"  data-placeholder="Selecione a unidade" style="width: 100%;" required>
                                <option value="">Selecione a Unidade Destino</option>
                            @foreach($unidades as $u)
                                @if($movimentacao->ce_unidadedestino == $u->id)
                                <option value="{{$u->id}}" selected>{{$u->hierarquia}}</option>
                                @else
                                <option value="{{$u->id}}" >{{$u->hierarquia}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div> 

                    <div class="form-group{{ $errors->has('dt_movimentacao') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_movimentacao" class="control-label">DATA DA MOVIMENTAÇÃO</label>
                        <input id="dt_movimentacao" type="date" class="form-control" name="dt_movimentacao" value="{{$movimentacao->dt_movimentacao}}"> 
                        @if ($errors->has('dt_movimentacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_movimentacao') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('st_publicacao') ? ' has-error' : '' }} col-md-3">
                        <label for="st_publicacao">BOLETIM DE PUBLICAÇÃO</label>
                        <input id="st_publicacao" type="text" class="form-control" placeholder="Boletim de Publicação" name="st_publicacao" value="{{$movimentacao->st_publicacao}}"> 
                        @if ($errors->has('st_publicacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_publicacao') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('dt_publicacao') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_publicacao" class="control-label">DATA DE PUBLICAÇÃO</label>
                        <input id="dt_publicacao" type="date" class="form-control" name="dt_publicacao" value="{{$movimentacao->dt_publicacao}}"> 
                        @if ($errors->has('dt_publicacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_publicacao') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                </div>

                

            </fieldset>    

            <div class="modal-footer">
            <button type="button" class="btn btn-warning">
                <a href="{{url('rh/policiais/'.$policial->id.'/movimentacoes')}}"><font color=white>
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Voltar
                </font></a>                
            </button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

        </form>
</div>

@endsection