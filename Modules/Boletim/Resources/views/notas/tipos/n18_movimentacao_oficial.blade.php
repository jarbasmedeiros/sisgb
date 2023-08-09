@extends('boletim::notas.tipos.arquitetura_tipos_nota_template')


@section('fragmento_head_tbl_policias_notas')
    <th>Ord.</th>
    <th>Post/Grad</th>
    <th>Matrícula</th>
    <th>Nome</th>
    <th>OPM Origem</th>
    <th>Função Atual</th>
    <th>OPM Destino</th>
    <th>Nova Função</th>
    <th>A contar</th>
    <th>Ações</th>
@endsection


@section('fragmento_body_tbl_policias_notas')    
    @if(isset($policiaisDaNota) )
  
        @forelse($policiaisDaNota  as $key => $policial)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{$policial->st_postograduacaosigla}}</td>
                <th>{{$policial->st_matricula}}</th>
                <th id="policial_{{$policial->id}}">{{$policial->st_nome}}</th>
                <td>{{$policial->st_siglaopmorigem}}</td>
                <td>{{$policial->st_funcaoatual}}</td>
                <td>{{$policial->st_siglaopmdestino}}</td>
                <td>{{$policial->st_novafuncao}}</td>
                <td>{{$policial->dt_acontar}}</td>
                <th>                               
                    @if($nota->st_status == 'RASCUNHO')
                        <a class="btn btn-danger btn-sm removerPolicial" id="{{$policial->ce_policial}}" value="{{$policial->ce_policial}}" data-toggle="modal" onclick="showModalRemoverPmQualquerNota({{$policial->ce_policial}})" title="Remover Policial">
                        <span class="fa fa-trash"></span></a>
                    @endif
                </th>
            </tr>
        @empty
            <tr>  
                <td>Nenhum policial adicionado</td>
            </tr>
        @endforelse
    @endif
@endsection


@section('fragmento_modais_da_nota')   
    
 <!-- Modal consultar pm-->
<div class="modal fade" id="modalConsultaPm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Adicionar Policial à nota de movimentação</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tblConfirmaPolicial">
                    <thead>
                        <tr class="bg-primary">
                            <th>Post/Grad</th>
                            <th>Matrícula</th>
                            <th>Nome</th>
                        </tr>
                    </thead>
                    <tbody name="policialencontrado_tbody" id="policialencontrado_tbody"> </tbody>
                </table>
            </div>

            <!-- campos complementar para a nota de movimentação -->
            <input type="hidden"  id="ce_tiponota" value="17" /> 
            {{csrf_field()}}
            <div class="panel-body">
                <div class="row">
                    <div class="form-group">
                        <label for="ce_tipo" class="col-md-3 control-label">Unidade de destino</label>
                        <div class="col-md-3">                                
                                
                            <select id="ce_unidadedestino"  required name="ce_unidadedestino" class="form-control select2" style="width: 100%">
                                <option value="">Selecione</option>
                                @foreach($unidades as $opm)
                                    <option value="{{ $opm->id}}">{{$opm->st_sigla}}</option>                                        
                                @endforeach
                            </select>
                            @if ($errors->has('ce_unidadedestino'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_unidadedestino') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group" >
                        <label for="ce_tipo" class="col-md-3 control-label">Nova Função</label>
                        <div class="col-md-3">                                
                                
                            <select id="ce_novafuncao"  required name="ce_novafuncao" class="form-control select2" style="width: 100%">
                                <option value="">Selecione</option>
                                @foreach($funcoes as $f)
                                    <option value="{{ $f->id}}">{{$f->st_nome}}</option>                                        
                                @endforeach
                            </select>
                            @if ($errors->has('ce_novafuncao'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ce_novafuncao') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                &nbsp;
                <div class="row">
                    <div class="form-group">
                        <label for="dt_acontar" class="col-md-3 control-label">Data a contar</label>
                        <div class="col-md-3">                                   
                            <input type="date" class="form-control" id="dt_acontar" name="dt_acontar" 
                                required="" class="form-control" 
                                name="dt_acontar" /> 
                            @if ($errors->has('dt_acontar'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dt_acontar') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                </div>
                         
                          <!-- end campos complementar para a nota de movimentação -->
            <br/>
            <div class="modal-footer">
                <button type="button" id="btnAddPmANota" name="btnAddPmANota" onclick="addPmQualquerNota()" class="btn btn-primary">Adicionar</button>
                <button type="button" id="canceladd" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!---end modal add selecionar pm --->
@endsection


@section('fragmento_scripts_das_notas')
<script>

function consultarPmQualquerNota(){
   // valida se informado a matrícula ou cpf do policial
    if($('#txtCpfMatriculaPolicial').val()==''){
        alert('Informar o CPF ou Matrícula do Policial');
    }else{
        //exibe o modal de consulta de policial para a nota 17
        $('#modalConsultaPm').modal({
            show: 'true'
        }); 

        //recuperando o tipo de nota selecionada    
        var idNota = $("#ce_tipo option:selected").val();

        //montando a url            
        baseUrl = getBaseUrl()+"/";

        //recuperando a matrícula/cpf do policial
        var user = $('#txtCpfMatriculaPolicial').val();

        //iniciando a requisição para a api rest para consultar o policial
        $.ajax({
                //Enviando via ajax
                url : baseUrl+"boletim/consultarpolicial/"+user,
                method: 'get',
   
            }).done(function(data){
                //console.log(data.length);
                //
                if(data != 1){
                    //popula a tabela com os dados do policial localizado.
                    $('.addPolicial').attr('id', data.id);
                    $('#idPolicial').val(data.id);
                    $('#policialencontrado_tbody').remove();

                    $('#tblConfirmaPolicial').append( "<tbody name='idPolicial' id='policialencontrado_tbody'></tbody>");
                    $('#policialencontrado_tbody').append(
                    "<tr id="+data.id+">"+
                        "<td>"+data.st_postograduacaosigla+"</td>"+
                        "<td>"+data.st_matricula+"</td>"+
                        "<td>"+data.st_nome+"</td>"+
                        "</tr>");

                        $('#rascunho').append('<input type="hidden" id="rascunho_st_materia" name="rascunho_st_materia" value="">'+'<input type="hidden" id="rascunho_st_assunto" name="rascunho_st_assunto" value="">'+'<input type="hidden" name="ce_nota" value='+idNota+'>');    
                        $('#rascunho_st_assunto').val($('#st_assunto').val());
                        $('#rascunho_st_materia').val($('#st_materia').val());
                        //$('#consultaPolicial').val('');
                }else{
                    alert('Erro! Policial Não encontrado.');
                    $("[data-dismiss=modal]").trigger({ type: "click" });
                }
            }).fail(function () {
                alert('falha para consultar o policial');
            });
            
    }
} 

function addPmQualquerNota() {
    var baseUrl = getBaseUrl()+"/";

    var ce_unidadedestino =  $('#ce_unidadedestino').val();
    var ce_novafuncao =  $('#ce_novafuncao').val();
    var dt_acontar =  $('#dt_acontar').val();
    //validando os campos obrigatórios
    if(ce_unidadedestino==''){
        alert('Selecionar unidade de destino');
    }else{
        if(ce_novafuncao==''){
            alert('Selecionar uma função');
        }else{
            
            if(dt_acontar==''){
                alert('Informar a data de referência da movimentação');
            }else{
            //agrupando os dados para enviar
                dados = {
                    ce_nota: $('#idNota').val(),
                    ce_tipo: $('#ce_tipo').val(),
                    _token: $("input[name=_token]").val(),
                    ce_policial: $('#policialencontrado_tbody tr:first-child').attr("id"),
                    ce_opmdestino: ce_unidadedestino,
                    dt_acontar: dt_acontar,
                    ce_novafuncao: ce_novafuncao
                };
            
                //fazendo a requisição a api rest
                $.ajax({
                    //preparando os dados
                    url : baseUrl+"boletim/tiponota/addpolicialparacadatiponota",//web rota service não api
                    method: 'post',
                    dataType: "json",
                    data: dados,            
                    //Verificando se encontrou 0 policial
                    success: function (data) {
                    //  alert('requisição ok');
                        if(data.retorno =='sucesso'){
                        // alert('Policial adicionado a nota com sucesso!');
                        alert(data.msg);
                            $("[data-dismiss=modal]").trigger({ type: "click" });
                            document.location.reload(true);
                        }else{
                        // fecha o modal
                            $("[data-dismiss=modal]").trigger({ type: "click" });
                            alert(data.msg);
                        }                           
                    },
                    error: function (request, status, error) {
                    //  alert( 'erro requisição');
                        alert('Falha para adicionar o o policial: '+request.responseText);
                    }
                }); 
            
            }
        }
    }
}
    
function showModalRemoverPmQualquerNota(idPolicial){
        //salva valor do id do policial selecionado
        $('#ce_policialselecionadoexclusao').val(idPolicial);
        //show modal
         $('#modalRemoverPmQualquerNota').modal({
            show: 'true'
        });  

}

function removerPmQualquerNota(){

    var idPolicial =  $('#ce_policialselecionadoexclusao').val();
    if( idPolicial==''){
        alert('Selecionar um policial');
    }else{        
        var token = $("input[name=_token]").val();
        var baseUrl = getBaseUrl()+"/boletim/tiponota/delpolicialparacadatiponota";
        var idNota = $('#idNota').val();
        var idTipoNota = $('#ce_tipo').val();

        //realizando requisição ajax
        $.ajax({
           
          
            url : baseUrl,
            dataType: "json",
            data: {// change data to this object
                _token: token,
                ce_nota:  idNota,
                ce_tipo:  idTipoNota,
                ce_policial: idPolicial
            },            
            method: 'post',
            success: function (data) {
               // alert('sucesso ok');
              //  alert(data);
                if(data.retorno=='sucesso'){                    
                    window.location.href = getBaseUrl()+"/boletim/nota/edit/"+idNota+"/"+idTipoNota;
                    //$(location).href("boletim/nota/edit/"+nota.ce_nota+"/"+nota.ce_tipo);
                    alert(data.msg);
                    $("[data-dismiss=modal]").trigger({ type: "click" });
                    document.location.reload(true);
                }else{  
                    alert(data.msg);
                    $('#modalRemoverPmQualquerNota').modal('hide');                       
                }                               
            },
            error: function (request, status, error) {
                alert('Falha para excluir o policial: '+error+'->'+status+'->'+request.responseText);
            }
        });
    }
}
</script>
@endsection