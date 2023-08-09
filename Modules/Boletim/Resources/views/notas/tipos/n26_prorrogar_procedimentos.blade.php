@extends('boletim::notas.tipos.arquitetura_tipos_nota_template')
@section('conteudo_especifico_das_notas')


{{csrf_field()}}
<!-- .dados do procedimentos  -->
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">DADOS DO PROCEDIMENTO</legend>
        <br>
        <div class="form-inline">
            <div class="form-group{{ $errors->has('st_pesquisarprocedimento') ? ' has-error' : '' }} col-md-12" >
                <div class="col-md-2 col-md-offset-2 text-right">
                    <label for="st_pesquisarprocedimento" class="col-form-label" style="margin-top: 7px">Pesquisar Procedimento</label>
                </div>
                <input type="text" name="st_pesquisarprocedimento" id="st_pesquisarprocedimento" class="form-control" style="width: 25%" placeholder="Digite o Nº do procedimento">
                @if ($errors->has('st_pesquisarprocedimento'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_pesquisarprocedimento') }}</strong>
                    </span>
                @endif
                <button type="button" onclick="pesquisarProcedimento()" class="btn btn-primary" title="Pesquisar Procedimento">
                    <i class="fa fa-search"></i>
                </button>
                <span class="loader"></span>
            </div>
        </div>
        <br><br><br>
        <div class="form-group{{ $errors->has('st_tipoprocedimento') ? ' has-error' : '' }} col-md-4" style="margin-right: 0.2px">
            <label for="st_tipoprocedimento" class="control-label">Tipo de Procedimento</label>
                <select id="st_tipoprocedimento" name="st_tipoprocedimento" class="form-control select2" required="required" >
                    <option value="" >--Selecione--</option>
                    <option value="CD" {{((isset($nota) && ($nota->st_tipoprocedimento == 'CD')) 
                        ) ? 'selected' : ''}}>CD (Conselho de Disciplina) </option>
                    <option value="CJ" {{((isset($nota) && ($nota->st_tipoprocedimento == 'CJ')) 
                        ) ? 'selected' : ''}}>CJ (Conselho de Justificação)</option>
                    <option value="IPM" {{((isset($nota) && ($nota->st_tipoprocedimento == 'IPM')) 
                        ) ? 'selected' : ''}}>IPM (Inquérito Policial Militar)</option>
                    <option value="PAD" {{((isset($nota) && ($nota->st_tipoprocedimento == 'PAD')) 
                        ) ? 'selected' : ''}}>PAD (Processo Administrativo Disciplinar)</option>
                    <option value="PADS" {{((isset($nota) && ($nota->st_tipoprocedimento == 'PADS')) 
                        ) ? 'selected' : ''}}>PADS (Processo Administrativo Disciplinar Sumário)</option>
                    <option value="SINDICANCIA" {{((isset($nota) && ($nota->st_tipoprocedimento == 'SINDICANCIA')) 
                        ) ? 'selected' : ''}}>SINDICÂNCIA</option>
                </select> 
                @if ($errors->has('st_tipoprocedimento'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_tipoprocedimento') }}</strong>
                    </span>
                @endif
        </div>
        <div class="form-group{{ $errors->has('st_numsei') ? ' has-error' : '' }} col-md-2" style="margin-right: 0.2px">
            <label for="st_numsei" class="control-label" >N° do SEI</label>
            <input type="text" class="form-control" placeholder="Nº do SEI"  id="st_numsei" name="st_numsei" 
            value="{{(isset($nota)) ? $nota->st_numsei : '' }}" required="required" >
            @if ($errors->has('st_numsei'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_numsei') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_numprocedimento') ? ' has-error' : '' }} col-md-2" style="margin-right: 0.2px">
            <label  for="st_numprocedimento" class="control-label">N° da Portaria</label>
            <input type="text" class="form-control" placeholder="Nº da portaria" id="st_numprocedimento" 
            name="st_numprocedimento"
            value="{{(isset($nota)) ? $nota->st_numprocedimento : '' }}" required="required" >
            @if ($errors->has('st_numprocedimento'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_numprocedimento') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_documentooriginal') ? ' has-error' : '' }} col-md-2" style="margin-right: 0.2px">
            <label for="st_documentooriginal" class="control-label">Documento Original</label>
            <input type="text" class="form-control" placeholder="Documento original" 
            id="st_documentooriginal"  name="st_documentooriginal"
            value="{{(isset($nota)) ? $nota->st_documentooriginal : '' }}" required="required">
            @if ($errors->has('st_documentooriginal'))
                <span class="help-block">
                    <strong>{{ $errors->first('st_documentooriginal') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('st_origem') ? ' has-error' : '' }} col-md-2">
            <label for="st_origem" class="control-label">Origem do Procedimento</label>
                <select id="st_origem" name="st_origem" class="form-control select2" >
                    <option value="" >-- Selecione --</option>
                    <option value="PM" {{((isset($nota) && ($nota->st_origem == 'PM')) 
                        ) ? 'selected' : ''}}>PM(De Ofício)</option>
                    <option value="MP" {{((isset($nota) && ($nota->st_origem == 'MP')) 
                        ) ? 'selected' : ''}}>MP (Requisição)</option>
                    <option value="ORGAOS_EXTERNOS" {{((isset($nota) && ($nota->st_origem == 'ORGAOS_EXTERNOS')) 
                        ) ? 'selected' : ''}}>ORGÃOS EXTERNOS (Noticia Fato)</option>
                </select> 
                @if ($errors->has('st_origem'))
                    <span class="help-block">
                        <strong>{{ $errors->first('st_origem') }}</strong>
                    </span>
                @endif
        </div>
    </fieldset>

    
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">JUSTIFICATIVA DA PRORROGAÇÃO</legend>
        <div class="form-group{{ $errors->has('st_justificativa_adiamento') ? ' has-error' : '' }} col-md-12">
            @if(isset($nota))
                @if($nota->st_status ==  'RASCUNHO')
                    <textarea class="ckeditor"  id="st_justificativa_adiamento" name="st_justificativa_adiamento" >{{(isset($nota)) ? $nota->st_justificativa_adiamento : '' }}</textarea>
                @else
                    <textarea class="ckeditor" disabled id="st_justificativa_adiamento" name="st_justificativa_adiamento" >{{(isset($nota)) ? $nota->st_justificativa_adiamento : '' }}</textarea>
                @endif
            @endif
        </div>
    </fieldset>
    <!-- .end dados  do procedimentos  -->
@endsection

   <!-- Java script para as notas -->
@section('fragmento_scripts_das_notas')
<script>

function pesquisarProcedimento() {
    //alert(getBaseUrl())
    let baseUrl = getBaseUrl();
    let numProcedimento = $('#st_pesquisarprocedimento').val()

    if (numProcedimento == '') {
        alert('Informe o número do Procedimento!')
    } else {
        //iniciando a requisição ajax para buscar o procedimento
        $ajax({
            //Enviando via ajax
            url: baseUrl + 'promocao/consultarprocedimento/' + numProcedimento
            method: 'get'
            beforeSend: function () {
                //adiciona o loader
                $("#loader").html("<span id='div-loader'> <img src='{{ asset('imgs/carregando.gif') }}' width=30><span><b> Carregando... </b></span> </span>");
            },
        }).done(function(data){
            console.log(data)
           /*  if(!data.retorno){
                $('#div-loader').remove();
                //popula a tabela com os dados do policial localizado.
                $('#idPolicial').val(data.id);
                $('#policialencontrado_tbody').remove();
                $('#tblConfirmaPolicial').append( "<tbody name='idPolicial' id='policialencontrado_tbody'></tbody>");
                $('#policialencontrado_tbody').append(
                    "<tr id="+data.id+">"+
                        "<td>"+data.st_postograduacaosigla+"</td>"+
                        "<td>"+data.st_matricula+"</td>"+
                        "<td>"+data.st_nome+"</td>"+
                    "</tr>"
                );
            }else{
                alert(data.msg);
            } */
        }).fail(function () {
            alert('falha ao consultar policial!');
        });
    } 


}


</script>
@endsection