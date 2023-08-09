@extends('rh::policial.Form_edita_policial')
@section('title', 'Cursos')
@section('tabcontent')
<div class="tab-pane active" id="cursos">
    <h4 class="tab-title">Cursos - {{ strtoupper($policial->st_nome) }}</h4>
    <hr class="separador">
   
    
</div>

        <div class="modal-content">
    
            <div class="modal-body">

                <form class="form"  method="post" action="{{ url('/rh/policiais/'.$policial->id.'/curso/'.$curso->id.'/edita') }}"> 
                {{csrf_field()}}
                <fieldset class="scheduler-border">    	
                    <legend class="scheduler-border">Dados do Curso</legend>
            
                    
                    <div class="form-group{{ $errors->has('st_categoria') ? ' has-error' : '' }} col-md-2">
                        <label for="st_categoria" class="control-label">Categoria</label>
                        <select id="st_categoria" name="st_categoria" class="form-control" required>
                            <option value="ACADEMICO" {{($curso->st_categoria == 'ACADEMICO') ? 'selected': ''}} >ACADÊMICO</option>                        
                            <option value="APERFEICOAMENTO" {{($curso->st_categoria == 'APERFEICOAMENTO') ? 'selected': ''}}>APERFEICOAMENTO</option>
                            <option value="CASERNA" {{($curso->st_categoria == 'CASERNA') ? 'selected': ''}} >CASERNA</option>
                            <option value="FORMACAO" {{($curso->st_categoria == 'FORMACAO') ? 'selected': ''}}>FORMAÇÃO</option>
                            <option value="OUTRO" {{($curso->st_categoria == 'OUTRO') ? 'selected': ''}}>OUTRO</option>
                        </select>
                        @if ($errors->has('st_categoria'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_categoria') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="tipo"  style="display: none;">
                        <div class="form-group{{ $errors->has('st_tipo') ? ' has-error' : '' }} col-md-2" >
                            <label for="st_tipo" class="control-label">Tipo</label>
                            <select id="st_tipo" name="st_tipo" class="form-control">
                                <option value=""  selected>Selecione</option>
                                
                            </select>
                            @if ($errors->has('st_tipo'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_tipo') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="cursoSelect"  style="display: none;">
                        <div class="form-group{{ $errors->has('st_curso') ? ' has-error' : '' }} col-md-2">
                            <label for="st_curso" class="control-label">Curso</label>
                            <select id="cursoSelect"  class="form-control">
                                <option value="{{$curso->st_curso}}"  selected>{{$curso->st_curso}}</option>
                            </select>
                            @if ($errors->has('st_curso'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_curso') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="cursoInput" >
                        <div class="form-group{{ $errors->has('st_curso') ? ' has-error' : '' }} col-md-4">
                            <label for="st_curso">Curso</label>
                            <input id="cursoInput" type="text" class="form-control" placeholder="Digite o nome do curso" value="{{$curso->st_curso}}"> 
                            @if ($errors->has('st_curso'))
                            <span class="help-block">
                                <strong>{{ $errors->first('st_curso') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('st_instituicao') ? ' has-error' : '' }} col-md-4">
                        <label for="st_instituicao ">INSTITUIÇÃO</label>
                        <input id="st_instituicao " type="text" class="form-control" placeholder="Instituição do curso" name="st_instituicao" value="{{$curso->st_instituicao}}" required> 
                        @if ($errors->has('st_instituicao '))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_instituicao ') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('st_cargahoraria') ? ' has-error' : '' }} col-md-2">
                        <label for="st_cargahoraria ">CARGA HORÁRIA</label>
                        <input id="st_cargahoraria " type="Number" class="form-control" placeholder="Ex: 40" value="{{$curso->st_cargahoraria}}" name="st_cargahoraria"> 
                        @if ($errors->has('st_cargahoraria'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_cargahoraria') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('dt_conclusao') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_conclusao" class="control-label">Data de Conclusão</label>
                        <input id="dt_conclusao" type="date" class="form-control" name="dt_conclusao" value="{{$curso->dt_conclusao}}"> 
                        @if ($errors->has('dt_conclusao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_conclusao') }}</strong>
                        </span>
                        @endif
                    </div>
    
            
                    <div class="form-group{{ $errors->has('st_mediafinal') ? ' has-error' : '' }} col-md-2">
                        <label for="st_mediafinal" class="control-label">Média Final</label>
                        <input id="st_mediafinal" type="text" class="form-control" placeholder="Ex: 90" name="st_mediafinal" value="{{$curso->st_mediafinal}}"> 
                        @if ($errors->has('st_mediafinal'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_mediafinal') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group{{ $errors->has('st_boletim') ? ' has-error' : '' }} col-md-2">
                        <label for="st_boletim" class="control-label">Publicação</label>
                        <input id="st_boletim" type="text" class="form-control" placeholder="Boletim de publicação" name="st_boletim" required  value="{{$curso->st_boletim}}"> 
                        @if ($errors->has('st_boletim'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_boletim') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group{{ $errors->has('dt_publicacao') ? ' has-error' : '' }} col-md-3">
                        <label for="dt_publicacao" class="control-label">Data de publicação</label>
                        <input id="dt_publicacao" type="date" class="form-control" name="dt_publicacao" required value="{{$curso->dt_publicacao}}"> 
                        @if ($errors->has('dt_publicacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('dt_publicacao') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                      
                </fieldset>

            </div>
            <div class="modal-footer">
          

                <a type="button" class="btn btn-secondary" href="{{url('rh/policiais/edita/'.$policial->id.'/cursos')}}">Cancelar</a></button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            </form>
        </div>
    </div>
</div>



























<!-- Modal Excluir curso -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR O CURSO?</b>
                </h4>
                <form class="form-inline" id="modalDesativa" method="post" > {{csrf_field()}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Excluir</button>
            </div>
            </form>
        </div>
    </div>
</div>
@section('js')
   
    <script src="{{ asset('js/cursos.js') }}"></script>
@stop
<script>




        function modalDesativa(id){
           
           $("#modalDesativa").attr("action", "{{ url('curso/deleta')}}/"+id);
                $('#Modal').modal();        
            };
</script>

<!-- /.tab-pane -->
@endsection