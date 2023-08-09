@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Dependente')
@section('tabcontent')
<div class="tab-pane active" id="cursos">
    <h4 class="tab-title">Cadastro de Dependente</h4>
    <hr class="separador">
</div>
<div class="modal-content">
  
            <div class="modal-body">

                <form class="form"  method="post" action="{{url('rh/policiais/edita/' . $policial->id . '/cadastra/dependentes')}}">
                {{csrf_field()}}
                <fieldset class="scheduler-border">    	
                    <legend class="scheduler-border">Dados do Dependente</legend>
           
                    <div class="cursoInput" >
                        <div class="form-group {{ $errors->has('st_nome') ? ' has-error' : '' }} col-md-4">
                            <label >Nome</label>
                            <input  type="text" name="st_nome"  class="form-control" required > 
                            @if ($errors->has('st_nome'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_nome') }}</strong>
                                </span>
                             @endif
                        </div>
                       
                        <div class="form-group {{ $errors->has('st_sexo') ? ' has-error' : '' }} col-md-2">
                            <label>Sexo</label>
                            <select name="st_sexo" id="st_sexo" class="form-control"  required >
                            <option value="">Selecione</option>
                            <option >Feminino</option>
                            <option >Masculino</option>
                            </select>
                            @if ($errors->has('st_sexo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_sexo') }}</strong>
                                </span>
                             @endif
                        </div>
                        <div class="form-group {{ $errors->has('dt_nascimento') ? ' has-error' : '' }} col-md-2">
                            <label>Data de Nascimento</label>
                            <input id="dt_nascimento" type="date"  class="form-control" name="dt_nascimento"  required >
                            @if ($errors->has('dt_nascimento'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_nascimento') }}</strong>
                                </span>
                             @endif
                        </div>
                        <div class="form-group {{ $errors->has('st_cpf') ? ' has-error' : '' }} col-md-2">
                            <label>CPF</label>
                            <input id="st_cpf" type="text"  class="form-control" name="st_cpf" required >
                            @if ($errors->has('st_cpf'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_cpf') }}</strong>
                                </span>
                             @endif
                        </div>    

                        <div class="form-group {{ $errors->has('st_parentesco') ? ' has-error' : '' }} col-md-2">
                            <label>Parentesco</label>
                            <select name="st_parentesco" id="st_parentesco" class="form-control" required >
                            <option value="" >Selecione</option>
                            <option >Cônjuge</option>
                            <option >Filho(a)</option>
                            <option >Irmão(ã)</option>
                            <option >Enteado(a)</option>
                            <option >Pais</option>
                            </select>
                            @if ($errors->has('st_parentesco'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_parentesco') }}</strong>
                                </span>
                            @endif
                        </div>
                       
                        @can('EXIBE_INFO_RESTRITA_DEPENDENTE')
                            <div class="form-group {{ $errors->has('st_tipodependencia') ? ' has-error' : '' }} col-md-4">
                                <label>Tipo de Dependência</label>
                                <input id="st_tipodependencia" type="text" class="form-control" name="st_tipodependencia"  placeholder="informe o tipo de dependencia, ex: (sentença judicial)"  >
                                @if ($errors->has('st_tipodependencia'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_tipodependencia') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group {{ $errors->has('st_processosei') ? ' has-error' : '' }} col-md-2">
                            <label>N° SEI</label>
                            <input id="st_processosei"  type="text" class="form-control" name="st_processosei" > 
                            @if ($errors->has('st_processosei'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('st_processosei') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                        
                            <div class="form-group {{ $errors->has('dt_inicio') ? ' has-error' : '' }} col-md-2">
                                <label>Data de Ínicio</label>
                                <input id="dt_inicio" type="date"  class="form-control" name="dt_inicio" >
                                @if ($errors->has('dt_inicio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dt_inicio') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group {{ $errors->has('dt_termino') ? ' has-error' : '' }} col-md-2">
                                <label>Data de Término</label>
                                <input id="dt_termino" type="date" class="form-control" name="dt_termino" >
                                @if ($errors->has('dt_termino'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dt_termino') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group {{ $errors->has('bo_ergon') ? ' has-error' : '' }} col-md-1">
                                <label>Registrado no Ergon</label>
                                <input type ="checkbox" id ="bo_ergon" name="bo_ergon" >
                                @if ($errors->has('bo_ergon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bo_ergon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        @endcan

                        <div class="form-group {{ $errors->has('st_obs') ? ' has-error' : '' }} col-md-12">
                        <label>Observação</label>
                        <input id="st_obs"  type="text" class="form-control" name="st_obs" > 
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