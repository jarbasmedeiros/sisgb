@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Dados Acadêmicos')
@section('tabcontent')
<div class="tab-pane active" id="dados_academicos">
    <h4 class="tab-title">Dados Acadêmicos - {{$policial->st_nome}}</h4>
    <fieldset class="scheduler-border  md-6">   
    <hr class="separador">
   
    <form role="form" method="POST" action="{{url('rh/policiais/edita/'.$policial->id.'/dados_academicos')}}">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">
            <div class="form-group col-md-offset-1 col-md-3">
                <label for="st_escolaridade">Informe seu maior nível de escolaridade:</label>
              
            </div>
            <div class="form-group{{ $errors->has('st_escolaridade') ? ' has-error' : '' }} col-md-4">
                <select id="st_escolaridade" name="st_escolaridade" class="form-control">
                    <option value="">Selecione</option>
                    <option value="ENSINO FUNDAMENTAL INCOMPLETO" {{ ($policial->st_escolaridade == "ENSINO FUNDAMENTAL INCOMPLETO") ? 'selected': '' }}>ENSINO FUNDAMENTAL INCOMPLETO</option>
                    <option value="ENSINO FUNDAMENTAL COMPLETO" {{ ($policial->st_escolaridade == "ENSINO FUNDAMENTAL COMPLETO") ? 'selected': '' }}>ENSINO FUNDAMENTAL COMPLETO</option>
                    <option value="ENSINO MÉDIO INCOMPLETO" {{ ($policial->st_escolaridade == "ENSINO MÉDIO INCOMPLETO") ? 'selected': '' }}>ENSINO MÉDIO INCOMPLETO</option>
                    <option value="ENSINO MÉDIO COMPLETO" {{ ($policial->st_escolaridade == "ENSINO MÉDIO COMPLETO") ? 'selected': '' }}>ENSINO MÉDIO COMPLETO</option>
                    <option value="TÉCNICO DE NÍVEL MÉDIO INCOMPLETO" {{ ($policial->st_escolaridade == "TÉCNICO DE NÍVEL MÉDIO INCOMPLETO") ? 'selected': '' }}>TÉCNICO DE NÍVEL MÉDIO INCOMPLETO</option>
                    <option value="TÉCNICO DE NÍVEL MÉDIO COMPLETO" {{ ($policial->st_escolaridade == "TÉCNICO DE NÍVEL MÉDIO COMPLETO") ? 'selected': '' }}>TÉCNICO DE NÍVEL MÉDIO COMPLETO</option>
                    <option value="TÉCNICO DE NÍVEL SUPERIOR INCOMPLETO" {{ ($policial->st_escolaridade == "TÉCNICO DE NÍVEL SUPERIOR INCOMPLETO") ? 'selected': '' }}>TÉCNICO DE NÍVEL SUPERIOR INCOMPLETO</option>
                    <option value="TÉCNICO DE NÍVEL SUPERIOR COMPLETO" {{ ($policial->st_escolaridade == "TÉCNICO DE NÍVEL SUPERIOR COMPLETO") ? 'selected': '' }}>TÉCNICO DE NÍVEL SUPERIOR COMPLETO</option>
                    <option value="ENSINO SUPERIOR INCOMPLETO" {{ ($policial->st_escolaridade == "ENSINO SUPERIOR INCOMPLETO") ? 'selected': '' }}>ENSINO SUPERIOR INCOMPLETO</option>
                    <option value="ENSINO SUPERIOR COMPLETO" {{ ($policial->st_escolaridade == "ENSINO SUPERIOR COMPLETO") ? 'selected': '' }}>ENSINO SUPERIOR COMPLETO</option>
                    <option value="TECNÓLOGO INCOMPLETO" {{ ($policial->st_escolaridade == "TECNÓLOGO INCOMPLETO") ? 'selected': '' }}>TECNÓLOGO INCOMPLETO</option>
                    <option value="TECNÓLOGO COMPLETO" {{ ($policial->st_escolaridade == "TECNÓLOGO COMPLETO") ? 'selected': '' }}>TECNÓLOGO COMPLETO</option>
                    <option value="PÓS - GRADUAÇÃO INCOMPLETA" {{ ($policial->st_escolaridade == "PÓS - GRADUAÇÃO INCOMPLETA") ? 'selected': '' }}>PÓS - GRADUAÇÃO INCOMPLETA</option>
                    <option value="PÓS - GRADUAÇÃO COMPLETA" {{ ($policial->st_escolaridade == "PÓS - GRADUAÇÃO COMPLETA") ? 'selected': '' }}>PÓS - GRADUAÇÃO COMPLETA</option>
                    <option value="MESTRADO INCOMPLETO" {{ ($policial->st_escolaridade == "MESTRADO INCOMPLETO") ? 'selected': '' }}>MESTRADO INCOMPLETO</option>
                    <option value="MESTRADO COMPLETO" {{ ($policial->st_escolaridade == "MESTRADO COMPLETO") ? 'selected': '' }}>MESTRADO COMPLETO</option>
                    <option value="DOUTORADO INCOMPLETO" {{ ($policial->st_escolaridade == "DOUTORADO INCOMPLETO") ? 'selected': '' }}>DOUTORADO INCOMPLETO</option>
                    <option value="DOUTORADO COMPLETO" {{ ($policial->st_escolaridade == "DOUTORADO COMPLETO") ? 'selected': '' }}>DOUTORADO COMPLETO</option>
                    <option value="PHD INCOMPLETO" {{ ($policial->st_escolaridade == "PHD INCOMPLETO") ? 'selected': '' }}>PHD INCOMPLETO</option>
                    <option value="PHD COMPLETO" {{ ($policial->st_escolaridade == "PHD COMPLETO") ? 'selected': '' }}>PHD COMPLETO</option>
                </select>
                @if ($errors->has('st_escolaridade'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_escolaridade') }}</strong>
                </span>
                @endif
            </div>
            <div class="row">
                <div class="form-group ">                          
                    <div class="col-md-2" style='text-align: center;'>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-fw fa-save"></i> Salvar
                        </button>                
                    </div>  
                                              
                </div>
            </div>    
    </form>
</div>
</fieldset>
<div class="content">
    <div class="row">
        <div class="col-md-13">
        <fieldset class="scheduler-border">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th style='text-align: center;' colspan="5">Lista de cursos acadêmicos</th>
                    </tr>
                    <tr>
                        <th class="col-md-2">Nome</th>
                        <th class="col-md-2">Escolaridade</th>
                        <th class="col-md-1">Conclusão</th>
                        <th class="col-md-2">BG</th>
                        @can('Edita')
                            <th class="col-md-2">Ações</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @if(isset($cursos))
                        @forelse($cursos as $c)
                            <tr>
                                <td>{{$c->st_curso}}</td>
                                <td>{{$c->st_tipo}}</td>
                                <td>{{\Carbon\Carbon::parse($c->dt_conclusao)->format('d/m/Y')}}</td>
                                <td>{{$c->st_boletim}}</td>
                                @can('Edita')
                                <td  class="col-md-2">
                                    <a  class="btn btn-warning fa fa-pencil" href="{{url('rh/policiais/'.$policial->id.'/edita/curso/'.$c->id)}}" title="Editar"></a> | 
                                    <a onclick="modalDesativa({{$c->id}}, {{$policial->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger">
                                    <i class="fa fa-trash"></i></a> 
                                </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">Nenhum Curso encontrado.</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
        </fieldset>
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
                <form class="form-inline" id="modalDesativa" method="get" > {{csrf_field()}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Excluir</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function modalDesativa(idCurso, idpolicial){
        
        var url = idpolicial+'/curso/'+idCurso+'/deleta';                      
        $("#modalDesativa").attr("action", "{{ url('rh/policiais/')}}/"+url);
            $('#Modal').modal();        
        };
</script>

@endsection