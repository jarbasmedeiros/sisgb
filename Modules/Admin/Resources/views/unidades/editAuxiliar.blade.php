@extends('adminlte::page')

@section('title', 'Atualizar Cadastro de Unidades')


@section('content')


                <div class="panel panel-primary">
                    <div class="panel-heading"><strong>ATUALIZAÇÃO DE INFORMAÇÕES DA UNIDADE</strong></div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{url('/admin/unidades/edit/'.$unidade->id)}}">
                            {{ csrf_field() }}
 

                                <fieldset  class="scheduler-border">
                                    <legend class="scheduler-border">Informações Adicionais</legend><BR>
                                        <div class="form-group{{ $errors->has('st_comandante') ? ' has-error' : '' }}">
                                            <label for="st_comandante" class="col-md-2 control-label">Comandante da Unidade:</label>
                                            
                                            <div class="col-md-7">
                                                    <input id="st_comandante" type="text" class="form-control" placeholder="Comandante da Unidade" name="st_comandante" value=""> 
                                                    @if ($errors->has('st_comandante'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('st_comandante') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                        </div>


                                        <div class="form-group{{ $errors->has('st_subComandante') ? ' has-error' : '' }}">
                                            <label for="st_subComandante" class="col-md-2 control-label">SubComandante da Unidade:</label>
                                            <div class="col-md-7">
                                                    <input id="st_subComandante" type="text" class="form-control" placeholder="SubComandante da Unidade" name="st_subComandante" value=""> 
                                                    @if ($errors->has('st_subComandante'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('st_subComandante') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('st_subComandante') ? ' has-error' : '' }}">
                                            <label for="st_contato" class="col-md-2 control-label">Contato da Unidade:</label>
                                            <div class="col-md-7">
                                                    <input id="st_contato" type="text" class="form-control" placeholder="(84) 0000-0000" name="st_contato" value=""> 
                                                    @if ($errors->has('st_subComandante'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('st_contato') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('st_subComandante') ? ' has-error' : '' }}">
                                            <label for="st_contato" class="col-md-2 control-label">Latitude/Longitude:</label>
                                            <div class="col-md-7">
                                                    <input id="st_contato" type="text" class="form-control" placeholder="(84) 0000-0000" name="st_contato" value=""> 
                                                    @if ($errors->has('st_subComandante'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('st_contato') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                        </div>


                                        <div class="form-group{{ $errors->has('st_subComandante') ? ' has-error' : '' }}">
                                            <label for="st_contato" class="col-md-2 control-label">Site da Unidade:</label>
                                            <div class="col-md-7">
                                                    <input id="st_contato" type="text" class="form-control" placeholder="" name="st_contato" value=""> 
                                                    @if ($errors->has('st_subComandante'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('st_contato') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                        </div> 
                                </fieldset>
                                                   
    
                            <div class="form-group ">
                                <div class="col-md-1  col-md-offset-2" style="margin-right:10px;">                               
                                    <a  href="{{url('admin/unidades')}}" class="btn btn-warning"  title="Voltar">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>
                                </div>
                                <button type="submit" class="col-md-1 btn btn-primary">
                                    <i class="glyphicon glyphicon-floppy-disk"></i> Salvar
                                </button>
                            </div>       
                        </form>                        
                    </div>
            
    
@stop