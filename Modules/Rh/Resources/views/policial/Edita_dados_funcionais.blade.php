@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Dados Funcionais')
@section('tabcontent')
<!-- 
Autor: @aggeu.  
Issue 184, Editar dados funcionais. Refatorado na Issue 211.
View que mostra os dados funcionais recuperados para edição 
-->
<div class="tab-pane active" id="dados_funcionais">
    <h4 class="tab-title">Dados Funcionais - {{ $policial->st_nome}}</h4>
    <hr class="separador">
    <form role="form" method="POST" action="{{ url('rh/policiais/edita/'.$policial->id.'/dados_funcionais') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Informações de Militar</legend>
            <div class="row">

                <!-- Campo Matricula -->
                <div class="form-group{{ $errors->has('st_matricula') ? ' has-error' : '' }} col-md-2">
                    <label for="st_matricula">Matrícula</label>
                    <input id="st_matricula" type="text" class="form-control" placeholder="Digite a Matricula" name="st_matricula" value="{{$policial->st_matricula}}">
                    @if ($errors->has('st_matricula'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_matricula') }}</strong>
                        </span>
                    @endif
                </div>

                 <!-- Campo Nome de Guerra -->
                <div class="form-group{{ $errors->has('st_nomeguerra') ? ' has-error' : '' }} col-md-2">
                    <label for="st_nomeguerra" class="control-label">Nome de Guerra</label>
                    <input id="st_nomeguerra" type="text" class="form-control" name="st_nomeguerra" value="{{$policial->st_nomeguerra}}">
                    @if ($errors->has('st_nomeguerra'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_nomeguerra') }}</strong>
                        </span>
                    @endif
                </div>

                <!-- Campo Gradução -->
                <div class="form-group{{ $errors->has('ce_graduacao') ? ' has-error' : '' }} col-md-2">
                    <label for="ce_graduacao" class="control-label">Posto/Graduação</label>
                    <select id="ce_graduacao" name="ce_graduacao" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($graduacoes as $g)
                            <option value="{{$g->id}}" {{($g->id == $policial->ce_graduacao) ? 'selected': ''}}>{{$g->st_postograduacao}}</option>
                        @empty
                            <option>Não há orgãos cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_graduacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_graduacao') }}</strong>
                        </span>
                    @endif
                </div>
              
                 <!-- Campo Nível -->
                 <div class="form-group{{ $errors->has('st_nivel') ? ' has-error' : '' }} col-md-2">
                    <label for="st_nivel" class="control-label">Nivel</label>
                    <select id="st_nivel" name="st_nivel" class="form-control" style="width: 100%;">
                        <option value="" >Selecione</option>
                       
                        <option {{$policial->st_nivel == '1' ? 'selected' : ''}} value="1">I (0 - 3 anos)</option>
                        <option {{$policial->st_nivel == '2' ? 'selected' : ''}} value="2">II (3 - 6 anos)</option>
                        <option {{$policial->st_nivel == '3' ? 'selected' : ''}} value="3">III (6 - 9 anos)</option>
                        <option {{$policial->st_nivel == '4' ? 'selected' : ''}} value="4">IV (9 - 12 anos)</option>
                        <option {{$policial->st_nivel == '5' ? 'selected' : ''}} value="5">V (12 - 15 anos)</option>
                        <option {{$policial->st_nivel == '6' ? 'selected' : ''}} value="6"> VI (15 - 18 anos)</option>
                        <option {{$policial->st_nivel == '7' ? 'selected' : ''}} value="7">VII(18 - 21 anos)</option>
                        <option {{$policial->st_nivel == '8' ? 'selected' : ''}} value="8">VIII(21 - 24 anos)</option>
                        <option {{$policial->st_nivel == '9' ? 'selected' : ''}} value="9">IX (24 - 27 anos)</option>
                        <option {{$policial->st_nivel == '10' ? 'selected' : ''}} value="10">X ( > 27 anos)</option>
                    </select>
                    @if ($errors->has('st_nivel'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_nivel') }}</strong>
                        </span>
                    @endif
                </div>
                <!-- Campo Numero de Praça -->
                <div class="form-group{{ $errors->has('st_numpraca') ? ' has-error' : '' }} col-md-2">
                @if($policial->ce_graduacao < 7)
                    <label for="st_numpraca" class="control-label">Número de Praça</label>
                    <input id="st_numpraca" type="text" class="form-control" name="st_numpraca" value="{{$policial->st_numpraca}}">
                @endif
                    @if ($errors->has('st_numpraca'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_numpraca') }}</strong>
                        </span>
                    @endif
                </div>
                @if(isset($imagem))
                    <div class="col-md-2">
                        <img id="img" class="img" src="data:image/png;data:image/jpeg;base64,{!! $imagem !!}"  width='100' height='120' style="border:1px solid #999;">
                    </div>
                @else
                    <div class="col-md-2">
                        <img id="img" class="img" src="{{ URL::asset('/imgs/default_profile.jpg') }}"  width='100' height='120' style="border:1px solid #999;">
                    </div>
                @endif
            </div>
            <div class="row">


               
                <!-- Campo Quadro -->
                <div class="form-group{{ $errors->has('ce_qpmp') ? ' has-error' : '' }} col-md-2">
                    <label for="ce_qpmp" class="control-label">Quadro</label>
                    <select id="ce_qpmp" name="ce_qpmp" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        @forelse($quadro as $q)
                            <option value="{{$q->id}}" {{( $q->id == $policial->ce_qpmp) ? 'selected': '' }}>({{$q->st_tipo}}) - {{$q->st_qpmp}}</option>
                        @empty
                            <option>Não há quadros cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_qpmp'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_qpmp') }}</strong>
                        </span>
                    @endif
                </div> 

                 <!-- Campo Unidade -->
                 <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }} col-md-4">
                    <label for="ce_unidade" class="control-label">Unidade</label>
                    @can('MOVIMENTAR_PM')
                        <select id="ce_unidade" name="ce_unidade" class="form-control select2" style="width: 100%;" >
                    @endcan
                    @cannot('MOVIMENTAR_PM')
                        <select id="ce_unidade" name="ce_unidade" class="form-control select2" style="width: 100%;" disabled>
                    @endcannot                    
                        <option value="">Selecione</option>
                        @forelse($unidades as $u)
                            <option value="{{$u->id}}" {{( $u->id == $policial->ce_unidade) ? 'selected': '' }}>{{$u->st_nomepais}}</option>
                        @empty
                            <option>Não há unidades cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_unidade'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_unidade') }}</strong>
                        </span>
                    @endif
                </div>

                 <!-- Campo Função -->
                 <div class="form-group{{ $errors->has('ce_funcao') ? ' has-error' : '' }} col-md-3">
                    <label for="ce_funcao" class="control-label">Função</label>
                    <select id="ce_funcao" name="ce_funcao" class="form-control" style="width: 100%;">
                        <option value="" >Selecione</option>
                        @forelse($funcao as $f)
                            <option value="{{$f->id}}" {{( $f->id == $policial->ce_funcao) ? 'selected': '' }}>{{$f->st_nome}}</option>
                        @empty
                            <option>Não há unidades cadastrados.</option>
                        @endforelse
                    </select>
                    @if ($errors->has('ce_funcao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ce_funcao') }}</strong>
                        </span>
                    @endif
                </div>
              
                <div class="fileUpload btn btn-link col-md-2">
                    <span>
                        <i class="fa fa-camera"></i> Alterar Imagem
                        <input id='imagem' type="file" class="upload" name='imagem' accept="image/png, image/jpeg" title='Tipos de imagens aceitos: PNG, JPEG ou JPG.'>
                        <label for='imagem' class="hidden">Imagem</label>
                    </span>
                </div>                  
            </div>
           
            <div class="row">
                <!-- Campo Comportamento -->
                <div class="form-group{{ $errors->has('st_comportamento') ? ' has-error' : '' }} col-md-3">
                    <label for="st_comportamento" class="control-label">Comportamento</label>
                    <select id="st_comportamento" name="st_comportamento" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        <option {{strtoupper($policial->st_comportamento) == 'INSUFICIENTE' ? 'selected' : ''}} value="Insuficiente">Insuficiente</option>
                        <option {{strtoupper($policial->st_comportamento) == 'MAU' ? 'selected' : ''}} value="Mau">Mau</option>
                        <option {{strtoupper($policial->st_comportamento) == 'BOM' ? 'selected' : ''}} value="Bom">Bom</option>
                        <option {{strtoupper($policial->st_comportamento) == 'ÓTIMO' ? 'selected' : ''}} value="Ótimo">Ótimo</option>
                        <option {{strtoupper($policial->st_comportamento) == 'EXCEPCIONAL' ? 'selected' : ''}} value="Excepcional">Excepcional</option>
                    </select>
                    @if ($errors->has('st_comportamento'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_comportamento') }}</strong>
                        </span>
                    @endif
                </div>
                <!-- Campo A contar de -->
                <div class="form-group{{ $errors->has('dt_comportamento') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_comportamento" class="control-label">A contar de</label>
                    <input id="dt_comportamento" type="date" class="form-control" name="dt_comportamento" value="{{$policial->dt_comportamento}}">
                    @if($errors->has('dt_comportamento'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_comportamento')}}</strong>
                        </span>
                    @endif
                </div>   
                <!-- Campo Bg Comportamento -->
                <div class="form-group{{ $errors->has('st_bgcomportamento') ? ' has-error' : '' }} col-md-3">
                    <label for="st_bgcomportamento" class="control-label">BG do Comportamento</label>
                    <input id="st_bgcomportamento" type="text" class="form-control" name="st_bgcomportamento" value="{{$policial->st_bgcomportamento}}">
                    @if($errors->has('st_bgcomportamento'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_bgcomportamento')}}</strong>
                        </span>
                    @endif
                </div>
                <!-- Campo Data do BG de comportamento -->
                <div class="form-group{{ $errors->has('dt_bgcomportamento') ? ' has-error' : '' }} col-md-3">
                    <label for="dt_bgcomportamento" class="control-label">Data do BG do Comportamento</label>
                    <input id="dt_bgcomportamento" type="date" class="form-control" name="dt_bgcomportamento" value="{{$policial->dt_bgcomportamento}}">
                    @if($errors->has('dt_bgcomportamento'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_bgcomportamento')}}</strong>
                        </span>
                    @endif
                </div>                         
            </div>
           
        </fieldset> 
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Tempo de serviço</legend>
            <div class="row"> 
                 <!-- Campo Data da Incorporação -->
                 <div class="form-group{{ $errors->has('dt_incorporacao') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_incorporacao" class="control-label">Data de Incorporação</label>
                    <input id="dt_incorporacao" type="date" class="form-control" name="dt_incorporacao" value="{{$policial->dt_incorporacao}}">
                    @if($errors->has('dt_incorporacao'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_incorporacao')}}</strong>
                        </span>
                    @endif
                </div> 
                <div class="form-group col-md-2">
                    <label  class="control-label">Tempo de Serviço</label>
                    <input type="text" class="form-control" style="width:100%; left:100%;" value="{{$policial->dt_tempo}}" disabled>
                </div>
                <div class="form-group{{ $errors->has('bo_ativo') ? ' has-error' : '' }} col-md-2">
                    <label for="bo_ativo" class="control-label">(In)Ativo</label>

                    @if($policial->bo_ativo == '1')
                    <input id="bo_vivo" type="text" class="form-control" name="bo_vivo" value="Ativo" disabled> 
                    @else
                    <input id="bo_vivo" type="text" class="form-control" name="bo_vivo" value="Inativo" disabled>
                    @endif
                    @if ($errors->has('bo_ativo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bo_ativo') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
                
                
              
            
               
                
            </div>
        </fieldset>

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Situação do Efetivo</legend>
            <div class="row"> 
                <!-- Campo Status -->
                <div class="form-group{{ $errors->has('ce_status') ? ' has-error' : '' }} col-md-4">
                        <label for="ce_status" class="control-label">Status</label>
                        <select id="ce_status" name="ce_status" class="form-control" style="width: 100%;">
                            <option value="" selected>Selecione</option>
                            @forelse($status as $s)
                                <option value="{{$s->id}}" {{( $s->id == $policial->ce_status) ? 'selected': '' }}>{{$s->st_nome}}</option>
                            @empty
                                <option>Não há status cadastrados.</option>
                            @endforelse
                        </select>
                        @if ($errors->has('ce_status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_status') }}</strong>
                            </span>
                        @endif
                </div>

                   <!-- Campo Atuação -->
                   <div class="form-group{{ $errors->has('st_atuacao') ? ' has-error' : '' }} col-md-3">
                    <label for="st_atuacao" class="control-label">Atuação</label>
                    <select id="st_atuacao" name="st_atuacao" class="form-control" style="width: 100%;">
                        <option value="" >Selecione</option>
                       
                        <option {{$policial->st_atuacao == 'OPERACIONAL' ? 'selected' : ''}} value="OPERACIONAL">OPERACIONAL</option>
                        <option {{$policial->st_atuacao == 'ADMINISTRATIVO' ? 'selected' : ''}} value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                       
                    </select>
                    @if ($errors->has('st_atuacao'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_atuacao') }}</strong>
                        </span>
                    @endif
                </div>
                @can('Admin')
                <div class="form-group{{ $errors->has('st_mapaforca') ? ' has-error' : '' }} col-md-4">
                    <label for="ce_status" class="control-label">Mapa força</label>
                    <select id="st_mapaforca" name="st_mapaforca" class="form-control" style="width: 100%;">
                        <option value="0" selected>Selecione</option>
                        <option value="JPMS">JPMS</option>
                        <option value="LICENCA_ESPECIAL">Licença</option>
                        <option value="FERIAS">Férias</option>
                        <option value="A_DISPOSICAO">A disposição</option>
                        <option value="FORCA_NACIONAL">Força Nacional</option>
                        <option value="CURSO">Curso</option>
                        <option value="OUTROS">Outros</option>
                        <option value="JPMS_PARCIAL">Pronto com restrições</option>
                        <option value="PRONTO">Pronto Emprego</option>
                        <!-- "antigo campo" <option value="nu_emcurso">Em curso</option> -->
                    </select>
                    @if ($errors->has('st_mapaforca'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_status') }}</strong>
                            </span>
                    @endif
                </div>
                @endcan
                    
            </div>
        </fieldset>
        <div class="form-group">
            <div class="col-md-4">
               
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-fw fa-save"></i> Salvar
                </button>
            </div>
        </div>
        <!-- Definindo o metodo de envio -->
        {{ method_field('PUT') }}
    </form>
</div>
@endsection

@section('css')
<style>
    .fileUpload {
    position: relative;
    overflow: hidden;
    margin: 24px 0px 10px 70px;
}

.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style>
@stop 

@section('js')

<script>
$(document).ready(function () {  
    //função para fazer a preview da foto do policial
   //$(function(){
    $('#imagem').change(function(){
            const file = $(this)[0].files[0]
            const fileReader = new FileReader()
            fileReader.onloadend = function(){
                $('#img').attr('src', fileReader.result)
            }
            fileReader.readAsDataURL(file)
    }) 
    $('#bo_ativo').on('change', function() {
        if(this.value ==1){
            $('#comboMotivoInatividade').hide();
            $('#dataInatividade').hide();
            $('#publicacaoInatividade').hide();
        }else{
            $('#comboMotivoInatividade').show();
            $('#dataInatividade').show();
            $('#publicacaoInatividade').show();
            }
        });

        if($('#bo_ativo').val()==1 ) {
            $('#comboMotivoInatividade').hide();
            $('#dataInatividade').hide();
            $('#publicacaoInatividade').hide();
        }else{
            $('#comboMotivoInatividade').show();
            $('#dataInatividade').show();
            $('#publicacaoInatividade').show();
        }
});
</script>
@endsection