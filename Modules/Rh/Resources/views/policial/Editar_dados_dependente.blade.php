@extends('rh::policial.Form_edita_policial')
@section('title', 'SGPO -  Dependente')
@section('tabcontent')
<div class="tab-pane active" id="cursos">
    <h4 class="tab-title">Editar Dados Dependente - {{ strtoupper($dependentes->st_nome)  }}</h4>
    <hr class="separador">
</div>


        <div class="modal-content">
  
            <div class="modal-body">

                <form class="form"  method="get" action="{{url('rh/policiais/edita/' . $policial->id . '/dependentes/'.$dependentes->id)}}">
                {{csrf_field()}}
                <fieldset class="scheduler-border">    	
                    <legend class="scheduler-border">Dados do Dependente</legend>
         
                    <div class="cursoInput" >
                        <div class="form-group   {{ $errors->has('st_nome') ? ' has-error' : '' }} col-md-4">
                            <label >Nome</label>
                            <input  type="text" name="st_nome"  class="form-control" value="{{$dependentes->st_nome}}">
                            @if ($errors->has('st_nome'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_nome') }}</strong>
                                </span>
                             @endif
                        </div>
                        <div class="form-group  {{ $errors->has('st_sexo') ? ' has-error' : '' }} col-md-2">
                            <label>Sexo</label>
                            <select name="st_sexo" id="st_sexo" class="form-control">
                                <option value="">Selecione</option>
                                <option {{$dependentes->st_sexo == 'Feminino' ? 'selected' : ''}} value="Feminino">Feminino</option>
                                <option {{$dependentes->st_sexo == 'Masculino' ? 'selected' : ''}} value="Masculino">Masculino</option>
                            </select>
                            @if ($errors->has('st_sexo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_sexo') }}</strong>
                                </span>
                             @endif
                        </div>
                        <div class="form-group {{ $errors->has('dt_nascimento') ? ' has-error' : '' }} col-md-2">
                            <label>Data de Nascimento</label>
                            <input id="dt_nascimento" type="date" class="form-control" name="dt_nascimento" value="{{$dependentes->dt_nascimento}}">
                            @if ($errors->has('dt_nascimento'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_nascimento') }}</strong>
                                </span>
                             @endif
                        </div>
                        <div class="form-group {{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                            <label>CPF</label>
                            <input id="st_cpf" type="text" class="form-control" name="st_cpf" value="{{$dependentes->st_cpf}}">
                            @if ($errors->has('st_cpf'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_cpf') }}</strong>
                                </span>
                             @endif
                        </div>    

                        <div class="form-group {{ $errors->has('st_parentesco') ? ' has-error' : '' }}  col-md-2">
                            <label>Parentesco</label>
                            <select name="st_parentesco" id="st_parentesco" class="form-control" >
                                <option value="" selected>Selecione</option>
                                <option {{$dependentes->st_parentesco == 'Neto' ? 'selected' : ''}} value="Neto">Neto</option>
                                <option {{$dependentes->st_parentesco == 'Cônjuge' ? 'selected' : ''}} value="Cônjuge" >Cônjuge</option>
                                <option {{$dependentes->st_parentesco == 'Filho(a)' ? 'selected' : ''}} value="Filho(a)">Filho(a)</option>
                                <option {{$dependentes->st_parentesco == 'Irmão(ã)' ? 'selected' : ''}} value="Irmão(ã)">Irmão(ã)</option>
                                <option {{$dependentes->st_parentesco == 'Enteado(a)' ? 'selected' : ''}} value="Enteado(a)">Enteado(a)</option>
                                <option {{$dependentes->st_parentesco == 'Pais' ? 'selected' : ''}} value="Pais">Pais</option>
                            </select>
                            @if ($errors->has('st_parentesco'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_parentesco') }}</strong>
                                </span>
                             @endif
                        </div>

                        <div class="form-group col-md-4">
                        <label>Tipo de Dependência</label>
                        <input id="st_tipodependencia"  type="text" class="form-control" name="st_tipodependencia" value="{{$dependentes->st_tipodependencia}}"> 
                        </div>
                        <div class="form-group col-md-2">
                        <label>N° SEI</label>
                        <input id="st_processosei"  type="text" class="form-control" name="st_processosei" value="{{$dependentes->st_processosei}}"> 
                        </div>
                        
                       
                        <div class="form-group {{ $errors->has('dt_inicio') ? ' has-error' : '' }} col-md-2">
                            <label>Data de Ínicio</label>
                            <input id="dt_inicio" type="date"  class="form-control" name="dt_inicio"  value="{{$dependentes->dt_inicio}}" >
                            @if ($errors->has('dt_inicio'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_inicio') }}</strong>
                                </span>
                             @endif
                        </div>
                        
                        <div class="form-group {{ $errors->has('dt_termino') ? ' has-error' : '' }} col-md-2">
                            <label>Data de Término</label>
                            <input id="dt_termino" type="date" class="form-control" name="dt_termino"  value="{{$dependentes->dt_termino}}">
                            @if ($errors->has('dt_termino'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_termino') }}</strong>
                                </span>
                             @endif
                        </div>
                        
                        <div class="form-group {{ $errors->has('bo_ergon') ? ' has-error' : '' }} col-md-1">
                            <label>Registrado no Ergon</label>
                            @if($dependentes->bo_ergon  == 1)
                            <input type ="checkbox" id ="bo_ergon" name="bo_ergon" checked>
                            @else
                            <input type ="checkbox" id ="bo_ergon" name="bo_ergon">
                            @endif
                            @if ($errors->has('bo_ergon'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bo_ergon') }}</strong>
                                </span>
                             @endif
                        </div>

                        <div class="form-group {{ $errors->has('st_obs') ? ' has-error' : '' }} col-md-12">
                        <label>Observação</label>
                        <input id="st_obs"  type="text" class="form-control" name="st_obs"  value="{{$dependentes->st_obs}}"> 
                        @if ($errors->has('st_obs'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_obs') }}</strong>
                                </span>
                             @endif
                        </div>

                    </div>

                   
  
                </fieldset>

            </div>
            <div class="modal-footer">
            <div class="form-group">                
                <a class="btn btn-warning" href="{{url('rh/policiais/edita/'.$policial->id.'/dependentes')}}" style='margin-right: 10px;'>
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
                            <button type="submit" class="btn btn-primary salvar">Salvar</button>
            </form>
        </div>
    </div>
</div>




























@endsection