@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP -  Inatividade')
@section('tabcontent')

    <div class="tab-pane active" id="cursos">
        <h4 class="tab-title">Inatividade - {{ $policial->st_nome}}</h4>
        <hr class="separador">
    </div>
    <form role="form" method="POST" action="{{ url('/rh/policiais/'.$policial->id.'/aba/inatividade') }}">
        {{ csrf_field() }}

        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Dados da Inatividade</legend>
            <div class="row">
            <div class="form-group{{ $errors->has('bo_ativo') ? ' has-error' : '' }} col-md-2">
                    <label for="bo_ativo" class="control-label">(In)Ativo</label>
                    <select id="bo_ativo" name="bo_ativo" class="form-control" style="width:50%;" required>
                        
                        <option value="1" {{ ($policial->bo_ativo == "1") ? 'selected': '' }}>Ativo</option>                        
                        <option value="0" {{ ($policial->bo_ativo == "0") ? 'selected': '' }}>Inativo</option>
                    </select>
                    @if ($errors->has('bo_ativo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bo_ativo') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="row">  
                <div class="form-group{{ $errors->has('st_motivoinatividade') ? ' has-error' : '' }} col-md-3" id="comboMotivoInatividade">
                    <label for="st_motivoinatividade" class="control-label">Motivo da Inatividade</label>
                    <select id="st_motivoinatividade" name="st_motivoinatividade" class="form-control" style="width: 100%;">
                        <option value="" selected>Selecione</option>
                        <optgroup label="Reserva">                        
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_AGREG_PRETA' ? 'selected' : ''}} value="PED_AGREG_PRETA">Agregação preta (mais de 2 anos fora)</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_30_ANOS' ? 'selected' : ''}} value="PED_30_ANOS">A pedido (mais de 30 anos)</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_MAG_SAUDE' ? 'selected' : ''}} value="PED_MAG_SAUDE">Cargo de magistério ou Saúde</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_CARG_ELETIVO' ? 'selected' : ''}} value="PED_CARG_ELETIVO">Eleito a cargo eletivo</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_IDADE_LIMITE' ? 'selected' : ''}} value="PED_IDADE_LIMITE">Idade limite</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_LICENCA_PARTICULAR' ? 'selected' : ''}} value="PED_LICENCA_PARTICULAR">Tempo em licença de interesse particular (mais de 2 anos)</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_TEMPO_CEL' ? 'selected' : ''}} value="PED_TEMPO_CEL">Tempo de serviço como Coronel</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_TEMPO_TC' ? 'selected' : ''}} value="PED_TEMPO_TC">Tempo de serviço como Ten Coronel</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_TEMPO_MAJOR' ? 'selected' : ''}} value="PED_TEMPO_MAJOR">Tempo de serviço como Major</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_TEMPO_SUB' ? 'selected' : ''}} value="PED_TEMPO_SUB">Tempo de serviço como Suboficial</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'PED_RESERVA_NAO_REMUNERADA' ? 'selected' : ''}} value="PED_RESERVA_NAO_REMUNERADA">Não Remunerada</option>
                        </optgroup>
                        <optgroup label="Exclusão">                                                   
                            <option {{strtoupper($policial->st_motivoinatividade) == 'EXC_MORTE' ? 'selected' : ''}} value="EXC_MORTE">Exclusão por falecimento</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'EXC_DESERCAO' ? 'selected' : ''}} value="EXC_DESERCAO">Exclusão por crime de deserção</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'EXC_ABEMDISCIPLINA' ? 'selected' : ''}} value="EXC_ABEMDISCIPLINA">Exclusão à bem da disciplina</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'EXC_POR_DEMISSAO_OFICIAL' ? 'selected' : ''}} value="EXC_POR_DEMISSAO_OFICIAL">Exclusão por Demissão (Oficial)</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'EXC_DETERMINACAO_JUDICIAL' ? 'selected' : ''}} value="EXC_DETERMINACAO_JUDICIAL">Exclusão por Determinação Judicial</option>
                        </optgroup>
                        <optgroup label="Licenciamento">                                                                              
                            <option {{strtoupper($policial->st_motivoinatividade) == 'LIC_PEDIDO' ? 'selected' : ''}} value="LIC_PEDIDO">Licenciamento a pedido (vontade do PM)</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'LIC_EX_OFICIO' ? 'selected' : ''}} value="LIC_EX_OFICIO">Licenciamento por Ex-Ofício</option>
                        </optgroup>
                        <optgroup label="Reforma">                                                   
                            <option {{strtoupper($policial->st_motivoinatividade) == 'REF_IDADE' ? 'selected' : ''}} value="REF_IDADE">Reforma por idade</option>
                            <option {{strtoupper($policial->st_motivoinatividade) == 'REF_INVALIDEZ' ? 'selected' : ''}} value="REF_INVALIDEZ" >Reforma por invalidez</option>
                        </optgroup>
                        <optgroup label="Transferência">                                                   
                            <option {{strtoupper($policial->st_motivoinatividade) == 'TRANS_CBOM' ? 'selected' : ''}} value="TRANS_CBOM">Transferido para o CBOM</option>
                            
                        </optgroup>
             

                    <!--<option {{strtoupper($policial->st_comportamento) == 'INSUFICIENTE' ? 'selected' : ''}} value="Insuficiente">Insuficiente</option>
                        <option {{strtoupper($policial->st_comportamento) == 'MAU' ? 'selected' : ''}} value="Mau">Mau</option>
                        <option {{strtoupper($policial->st_comportamento) == 'BOM' ? 'selected' : ''}} value="Bom">Bom</option>
                        <option {{strtoupper($policial->st_comportamento) == 'ÓTIMO' ? 'selected' : ''}} value="Ótimo">Ótimo</option>
                        <option {{strtoupper($policial->st_comportamento) == 'EXCEPCIONAL' ? 'selected' : ''}} value="Excepcional">Excepcional</option>-->
                    </select>
                    @if ($errors->has('st_motivoinatividade'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_motivoinatividade') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('dt_inatividade') ? ' has-error' : '' }} col-md-2" id="dataInatividade">
                    <label for="dt_inatividade" class="control-label">Data da inatividade</label>
                    <input id="dt_inatividade" type="date" class="form-control" name="dt_inatividade" value="{{$policial->dt_inatividade}}">
                    @if($errors->has('dt_inatividade'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_inatividade')}}</strong>
                        </span>
                    @endif
                </div> 
                <div class="form-group{{ $errors->has('st_publicacaoinatividade') ? ' has-error' : '' }} col-md-3" id="publicacaoInatividade">
                    <label for="st_publicacaoinatividade" class="control-label">Publicação (BG/DOE) da inatividade</label>
                    <input id="st_publicacaoinatividade" type="text" class="form-control" name="st_publicacaoinatividade" value="{{$policial->st_publicacaoinatividade}}">
                    @if($errors->has('st_publicacaoinatividade'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_publicacaoinatividade')}}</strong>
                        </span>
                    @endif
                </div> 
            </div>
        </fieldset>

                 <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Dados da Reforma</legend>
                    <div class="row">
                        <!-- Campo ATIVO/INATIVO -->
                        <div class="form-group{{ $errors->has('st_motivoreforma') ? ' has-error' : '' }} col-md-2">
                            <label for="st_motivoreforma">Motivo da Reforma</label>
                                <select id="st_motivoreforma" name="st_motivoreforma" class="form-control" style="width:100%;" >
                                    <option value="">Selecione</option>                        
                                    <option {{strtoupper($policial->st_motivoreforma) == 'REF_IDADE' ? 'selected' : ''}} value="REF_IDADE">Reforma por idade</option>
                                    <option {{strtoupper($policial->st_motivoreforma) == 'REF_INVALIDEZ' ? 'selected' : ''}} value="REF_INVALIDEZ">Reforma por invalidez</option>
                                </select>
                                @if ($errors->has('st_motivoreforma'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_motivoreforma') }}</strong>
                                </span>
                                @endif
                        </div>


                     <div class="form-group{{ $errors->has('dt_motivoreforma') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_motivoreforma" class="control-label">Data da Reforma</label>
                    <input id="dt_motivoreforma" type="date" class="form-control" name="dt_motivoreforma" value="{{$policial->dt_motivoreforma}}" > 
                    @if ($errors->has('dt_motivoreforma'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_motivoreforma') }}</strong>
                    </span>
                    @endif
                </div>


                <div class="form-group{{ $errors->has('st_publicacaoreforma') ? ' has-error' : '' }} col-md-3" id="datapublicareforma">
                    <label for="st_publicacaoreforma" class="control-label">Publicação da Reforma</label>
                    <input id="st_publicacaoreforma" type="text" class="form-control" name="st_publicacaoreforma" value="{{$policial->st_publicacaoreforma}}" >
                    @if($errors->has('st_publicacaoreforma'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_publicacaoreforma')}}</strong>
                        </span>
                    @endif
                </div> 
                </fieldset>

                    <fieldset class="scheduler-border">
                    <legend class="scheduler-border"> Dados da Isenção de Imposto de Renda</legend>
                    <div class="row">
                        <!-- Campo ATIVO/INATIVO -->
                        <div class="form-group{{ $errors->has('bo_beneficioir') ? ' has-error' : '' }} col-md-2 " >
                            <label for="bo_beneficioir">Beneficiário</label>
                                <select id="bo_beneficioir" name="bo_beneficioir" class="form-control" style="width:60%;" >
                                    <option {{$policial->bo_beneficioir == '0' ? 'selected' : ''}} value="0">Não</option>                      
                                    <option {{$policial->bo_beneficioir == '1' ? 'selected' : ''}} value="1">Sim</option>                      
                                </select>
                                @if ($errors->has('bo_beneficioir'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bo_beneficioir') }}</strong>
                                </span>
                                @endif
                        </div>


                     <div class="form-group{{ $errors->has('dt_beneficioir') ? ' has-error' : '' }} col-md-2">
                    <label for="dt_beneficioir" class="control-label">Data de Benefício IR</label>
                    <input id="dt_beneficioir" type="date" class="form-control" name="dt_beneficioir" value="{{$policial->dt_beneficioir}}"  > 
                    @if ($errors->has('dt_beneficioir'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dt_beneficioir') }}</strong>
                    </span>
                    @endif
                </div>


                <div class="form-group{{ $errors->has('st_publicacaobeneficioir') ? ' has-error' : '' }} col-md-3" id="dataInatividade22">
                    <label for="st_publicacaobeneficioir" class="control-label">Publicação Benefício IR</label>
                    <input id="st_publicacaobeneficioir" type="text" class="form-control" name="st_publicacaobeneficioir" value="{{$policial->st_publicacaobeneficioir}}" >
                    @if($errors->has('st_publicacaobeneficioir'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_publicacaobeneficioir')}}</strong>
                        </span>
                    @endif
                </fieldset>
           
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Dados do Falecimento</legend>
                    <div class="row">
                        
                <div class="form-group{{ $errors->has('bo_vivo') ? ' has-error' : '' }} col-md-1">
                    <label for="bo_vivo" class="control-label">Vivo</label>
                    <select id="bo_vivo" name="bo_vivo" class="form-control" >
                        <option value=""  selected>Selecione</option>
                        <option value="1" {{ ($policial->bo_vivo == "1") ? 'selected': '' }}>Sim</option>                        
                        <option value="0" {{ ($policial->bo_vivo == "0") ? 'selected': '' }}>Não</option>
                    </select>
                    @if ($errors->has('bo_vivo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bo_vivo') }}</strong>
                    </span>
                    @endif
                </div>
          

            <div class="row">
                <div class="form-group{{ $errors->has('dt_obito') ? ' has-error' : '' }} col-md-2" id="div_dt_obito">
                    <label for="dt_obito" class="control-label">Data do óbito</label>
                    <input id="dt_obito" type="date" class="form-control" name="dt_obito" value="{{$policial->dt_obito}}" >
                    @if($errors->has('dt_obito'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_obito')}}</strong>
                        </span>
                    @endif
                </div> 
                <div class="form-group{{ $errors->has('st_motivoobito') ? ' has-error' : '' }} col-md-3" id="div_st_motivoobito">
                    <label for="st_motivoobito" class="control-label">Motivo do óbito (Conforme certidão de óbito)</label>
                    <input id="st_motivoobito" type="text" class="form-control" name="st_motivoobito" value="{{$policial->st_motivoobito}}" >
                    @if($errors->has('st_motivoobito'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_motivoobito')}}</strong>
                        </span>
                    @endif
                </div> 
                <div class="form-group{{ $errors->has('bo_obitorelacionadoprofissao') ? ' has-error' : '' }} col-md-2" id="div_bo_obitorelacionadoprofissao">
                    <label for="bo_obitorelacionadoprofissao" class="control-label">Óbito relacionado à profissão</label>
                    <select id="bo_obitorelacionadoprofissao" name="bo_obitorelacionadoprofissao" class="form-control" >
                        <option value=""  selected>Selecione</option>
                        <option value="1" {{ ($policial->bo_obitorelacionadoprofissao == "1") ? 'selected': '' }}>Sim</option>                        
                        <option value="0" {{ ($policial->bo_obitorelacionadoprofissao == "0") ? 'selected': '' }}>Não</option>
                    </select>
                    @if ($errors->has('bo_obitorelacionadoprofissao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bo_obitorelacionadoprofissao') }}</strong>
                    </span>
                    @endif
                </div>

            <div class="form-group{{ $errors->has('dt_publicacaoobito') ? ' has-error' : '' }} col-md-2" id="div_dt_pub">
                    <label for="dt_publicacaoobito" class="control-label">Data de Publicação</label>
                    <input id="dt_publicacaoobito" type="date" class="form-control" name="dt_publicacaoobito" value="{{$policial->dt_publicacaoobito}}" >
                    @if($errors->has('dt_publicacaoobito'))
                        <span class="help-block">
                            <strong>{{$errors->first('dt_publicacaoobito')}}</strong>
                        </span>
                    @endif
                </div> 
                
                <div class="form-group{{ $errors->has('st_publicacaoobito') ? ' has-error' : '' }} col-md-4" id="div_st_pub" >
                    <label for="st_publicacaoobito" class="control-label">Publicação</label>
                    <input id="st_publicacaoobito" type="text" class="form-control" name="st_publicacaoobito" value="{{$policial->st_publicacaoobito}}" >
                    @if($errors->has('st_publicacaoobito'))
                        <span class="help-block">
                            <strong>{{$errors->first('st_publicacaoobito')}}</strong>
                        </span>
                    @endif
                </div> 
                </div> 
                </fieldset>
                <div class="row">
            <div class="form-group">                
                               
                <div class="col-md-1" style='text-align: center;'>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-fw fa-save"></i> Salvar
                    </button>                
                </div>                            
            </div>
        </div>
            
    </form>
</div>
    
@endsection

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



$(document).ready(function () {  
        //altera a exibição dos campos abaixo de acordo com a mudança do bo_vivo
        $('#bo_vivo').on('change', function() {
            if(this.value == 1){
                $('#div_dt_obito').hide();
                $('#dt_obito').val('');
                $('#dt_obito').removeAttr('required');
                $('#div_st_motivoobito').hide();
                $('#st_motivoobito').val('');
                $('#st_motivoobito').removeAttr('required');
                $('#div_bo_obitorelacionadoprofissao').hide();
                $('#bo_obitorelacionadoprofissao').val('');
                $('#bo_obitorelacionadoprofissao').removeAttr('required');

                $('#div_dt_pub').hide();
                $('#dt_publicacaoobito').val('');
                $('#dt_publicacaoobito').removeAttr('required');

                
                $('#div_st_pub').hide();
                $('#st_publicacaoobito').val('');
                $('#st_publicacaoobito').removeAttr('required');

            }else{
                $('#div_dt_obito').show();
                $('#dt_obito').attr('required', true);
                $('#div_st_motivoobito').show();
                $('#st_motivoobito').attr('required', true);
                $('#div_bo_obitorelacionadoprofissao').show();
                $('#bo_obitorelacionadoprofissao').attr('required', true);

                 $('#div_dt_pub').show();
                $('#dt_publicacaoobito').attr('required', true);

                 $('#div_st_pub').show();
                $('#st_publicacaoobito').attr('required', true);
            }
        });
        //exibe os campos abaixo de acordo com o valor do bo_vivo
        if($('#bo_vivo').val() == 1) {
            $('#div_dt_obito').hide();
            $('#dt_obito').val('');
            $('#dt_obito').removeAttr('required');
            $('#div_st_motivoobito').hide();
            $('#st_motivoobito').val('');
            $('#st_motivoobito').removeAttr('required');
            $('#div_bo_obitorelacionadoprofissao').hide();
            $('#bo_obitorelacionadoprofissao').val('');
            $('#bo_obitorelacionadoprofissao').removeAttr('required');
            $('#div_dt_pub').hide();
                $('#dt_publicacaoobito').val('');
                $('#dt_publicacaoobito').removeAttr('required');

                
                $('#div_st_pub').hide();
                $('#st_publicacaoobito').val('');
                $('#st_publicacaoobito').removeAttr('required');
        }else{
            $('#div_dt_obito').show();
            $('#dt_obito').attr('required', true);
            $('#div_st_motivoobito').show();
            $('#st_motivoobito').attr('required', true);
            $('#div_bo_obitorelacionadoprofissao').show();
            $('#bo_obitorelacionadoprofissao').attr('required', true);

             $('#div_dt_pub').show();
                $('#dt_publicacaoobito').attr('required', true);

                 $('#div_st_pub').show();
                $('#st_publicacaoobito').attr('required', true);
        }

    });
</script>
@endsection
