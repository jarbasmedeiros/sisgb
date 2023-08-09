@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Dados Acadêmicos')
@section('tabcontent')
<div class="tab-pane active" id="dados_academicos">
    <h4 class="tab-title">Dados Acadêmicos - {{$policial->st_nome}}</h4>
    <hr class="separador">
            <div class="form-group col-md-offset-2 col-md-1">
                <label for="st_escolaridade" class="control-label">Escolaridade</label>
            </div>
            <div class="form-group{{ $errors->has('st_escolaridade') ? ' has-error' : '' }} col-md-4">
                <select id="st_escolaridade" disabled='true' name="st_escolaridade" class="form-control">
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
                    <a href='{{url("/")}}' class="col-md-1 btn btn-warning">
                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                    </a>                            
                </div>
            </div>    
</div>
<div class="content">
    <div class="row">
        <div class="col-md-13">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th style='text-align: center;' colspan="5">Cursos</th>
                    </tr>
                    <tr>
                        <th class="col-md-2">Nome</th>
                        <th class="col-md-2">Escolaridade</th>
                        <th class="col-md-1">Conclusão</th>
                        <th class="col-md-2">BG</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($cursos))
                        @forelse($cursos as $c)
                            <tr>
                                <th>{{$c->st_curso}}</th>
                                <th>{{$c->st_tipo}}</th>
                                <th>{{\Carbon\Carbon::parse($c->dt_conclusao)->format('d/m/Y')}}</th>
                                <th>{{$c->st_boletim}}</th>
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
    </div>
</div>
@endsection