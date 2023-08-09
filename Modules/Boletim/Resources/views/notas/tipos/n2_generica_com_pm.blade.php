@extends('boletim::notas.tipos.arquitetura_tipos_nota_template')

@section('fragmento_head_tbl_policias_notas')    
    <th>Post/Grad</th>
    <th>Praça</th>
    <th>Matrícula</th>
    <th>Nome</th>
    <th hidden>Campo Personalizado</th>
    <th>Ações</th>
@endsection

@section('fragmento_body_tbl_policias_notas')    
    @if(isset($policiaisDaNota) )
        @forelse($policiaisDaNota  as $policiais)
            <tr>  
                <td>{{$policiais->st_postograduacaosigla}}</td>
                <td>{{$policiais->st_numpraca}}</td>
                <td>{{$policiais->st_matricula}}</td>
                <td id="policial_{{$policiais->id}}">{{$policiais->st_nome}}</td>
                <td hidden>{{$policiais->st_campopersonalizado}}</td>
                <td>                               
                    @if($nota->st_status == 'RASCUNHO')
                        <a class="btn btn-danger btn-sm removerPolicial" id="{{$policiais->id}}" value="{{$policiais->id}}" data-toggle="modal"  onclick="showModalRemoverPmQualquerNota({{$policiais->id}})" title="Remover Policial">
                            <span class="fa fa-trash"></span>
                        </a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>  
                <td>Nenhum policial adicionado</td>
            </tr>
        @endforelse
    @endif
@endsection

@section('fragmento_modais')    
    <!-- modal consultar pm -->
    <div class="modal fade" id="modalConsultaPm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Adicionar Policial à nota</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="tblConfirmaPolicial">
                        <thead>
                            <tr class="bg-primary">
                                <th>Post/Grad</th>
                                <th>Praça</th>
                                <th>Matrícula</th>
                                <th>Nome</th>
                            </tr>
                        </thead>
                        <tbody name="idPolicial" id="policialencontrado_tbody"> </tbody>
                    </table>
                    <label for="st_campopersonalizado" class="control-label" hidden>Resumo simplificado da Nota para Extrato de Assentamento</label>
                    
                    <textarea   id="st_campopersonalizado" name="st_campopersonalizado"  rows="5" cols="130" placeholder="Digite aqui" hidden></textarea>
                </div>
                <br/>
                <div class="modal-footer">
                    <button type="button" id="btnAddPmANota" name="btnAddPmANota" onclick="addPmQualquerNota()" class="btn btn-primary">Adicionar</button>
                    <button type="button" id="canceladd" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>    
    <!--- end modal consultar pm --->

    <!---modal remover Policial --->
    <div class="modal fade" id="modalRemoverPmQualquerNota" tabindex="-1" role="dialog" aria-labelledby="removerPolicialModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remover policial da Nota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body alert-danger">
                    <h5>DESEJA REALMENTE REMOVER ESTE POLICIAL DA NOTA?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                    <button type="button" class="btn btn-primary" onclick="removerPmQualquerNota()">Remover</button>
                </div>
            </div>
        </div>
    </div>
    <!--- end modal remover Policial --->

    <!---modal remover Policial Em Lote--->
    <div class="modal fade" id="modalRemoverEmLotePmQualquerNota" tabindex="-1" role="dialog" aria-labelledby="removerPolicialModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remover todos os policial da Nota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body alert-danger">
                    <h5>DESEJA REALMENTE REMOVER TODOS OS POLICIAIS DA NOTA?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                    <button type="button" class="btn btn-primary" onclick="removerPmEmLoteQualquerNota()">Remover</button>
                </div>
            </div>
        </div>
    </div>
    <!--- end modal remover Policial Em Lote--->

    <!-- modal adicionar PM em LOTE -->
    <div class="modal fade" id="modalAdicionaPmEmLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Adicionar policiais em Lote</h4>
                </div>
                <div class="modal-body">
                    <!--
                    <div class="form-group">
                        <label for="st_efetivo">Digite as matrículas dos policiais sem usar pontos ou hífens e todas devem ser separadas por vírgula.</label>
                        <textarea class='form-control' placeholder='Exemplo: 123456, 234567, 568794' id="st_efetivo" name="st_efetivo" cols="30" rows="5" required></textarea>
                        <label for="cp_personalizado">Campo personalizado para todos os policiais:</label>
                        <input type="text" id="cp_personalizado" class="form-control" maxlength="300">
                    </div>
                    <br/>
                    
                        <button type="button" id="btnAddPmANota2" name="btnAddPmANota2" onclick="addPmEmLoteQualquerNota()"  class="btn btn-primary">Adicionar</button>
                        <button type="button" id="canceladd" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                        <hr>
                    <!-->
                    <div class="modal-footer">
                        <div style='text-align:left;background-color:lightgray;padding:10px;border-radius:5px;'>
                            <form action="{{ route('addPolicialExcell') }}" role="form" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                <p><strong>Faça o upload da planilha padrão (Excel): anexando-a e clicando em "Enviar Planilha".</strong>
                                <br>
                                Obs: O nome da planilha não pode ser alterado do original na hora de fazer o upload.</p>
                                <span>
                                <br>
                                <label for='arquivo'><a target="_blank" href='{{ url("planilhas/padrao/planilha_generica_com_pm.xlsx")}}'><i class="fa fa-save"></i> (Download da planilha padrão)</a></label>
                                    <input id='arquivo' type="file" class="form-control-file" name='arquivo' required>
                                    @if(isset($nota->id))
                                    <input type="hidden" name='idNota' value="{{$nota->id}}">
                                    @endif
                                    @if(isset($tipoNota->id))
                                    <input type="hidden" name='tipoNota' value="{{$tipoNota->id}}">
                                    @endif
                                </span>
                                <br>
                                <div style='text-align: center'>
                                <button type='submit' class='btn btn-primary'>Enviar Planilha</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('fragmento_scripts_das_notas')
    <script> 
            function consultarPmQualquerNota() {
               
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
                                    "<td>"+data.st_numpraca+"</td>"+
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

            //por cabo Araújo 10/11/2021
            function digitarPoliciaisEmLote(){
                //esta função abre o modal de adicionar policiais em lote
                $('#modalAdicionaPmEmLote').modal({
                    show: 'true'
                }); 
            }

            //por cabo Araújo 10/11/2021
            //esta função dá o retorno se os policiais foram adicionados com sucesso
            function addPmEmLoteQualquerNota(){
              //alert('chamou add qualquer nota');
                var baseUrl = getBaseUrl()+"/";
                dados = {
                    idNota: $('#idNota').val(),
                    st_efetivo: $('#st_efetivo').val(),
                    st_campopersonalizado: $('#cp_personalizado').val(),
                    _token: $("input[name=_token]").val()
                };
                $.ajax({
                    //Enviando via ajax p controller
                    url : baseUrl+"boletim/tiponota/addpoliciaisemloteparacadatiponota",
                    data: dados,
                    method: 'POST',
                    dataType: "json",
                    //Verificando se encontrou 0 policial
                }).done(function(data){
                    //console.log(data);
                   if(data.retorno =='sucesso'){
                        alert('Policiais adicionados a nota com sucesso!');
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                        document.location.reload(true);
                    }else{
                        alert(data.msg);
                        //alert(data.msg);
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                    }
                }).fail(function (data) {
                    //console.log(data);
                    alert('falha para consultar o policial'+data);
                });                    
            }
    
            function addPmQualquerNota(){
                //  alert('chamou add qualquer nota');
                var baseUrl = getBaseUrl()+"/";
                
                dados = {
                    ce_nota: $('#idNota').val(),
                    ce_tipo: $('#ce_tipo').val(),
                    ce_policial: $('#idPolicial').val(),
                    st_campopersonalizado: $('#st_campopersonalizado').val(),
                    _token: $("input[name=_token]").val()
                }; 
                
                //valida se o campo personalizado está preenchido
                /* if (dados.st_campopersonalizado  == "") {
                    return alert('O campo Texto Personalizado é obrigatório!');
                } */

                //valida se a string enviada ao campo personalizado é menor que 300 caracteres
                if (dados.st_campopersonalizado.length  > 300) {
                    return alert(
                        'O campo Texto Personalizado aceita no máximo 300 caracteres. Foram inseridos '
                        + dados.st_campopersonalizado.length + ' caracteres.'
                    );
                }  

                $.ajax({
                    //Enviando via ajax p controller
                    url : baseUrl+"boletim/tiponota/addpolicialparacadatiponota",
                    data: dados,
                    method: 'POST',
                    dataType: "json",
                    //Verificando se encontrou 0 policial
                }).done(function(data){
                    //console.log(data.length);
                    if(data.retorno =='sucesso'){
                        console.log(data);
                        alert('Policial adicionado a nota com sucesso!');
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                        document.location.reload(true);
                    }else{
                        alert(data.msg);
                        //alert(data.msg);
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                    }
                });
            }

          
        
            function showModalRemoverPmQualquerNota(idPolicial){
               // alert('show'+idPolicial);
                //salva valor do id do policial selecionado
                $('#ce_policialselecionadoexclusao').val(idPolicial);
                //show modal
                $('#modalRemoverPmQualquerNota').modal({
                    show: 'true'
                });  
            }

            function showModalRemoverEmLotePmQualquerNota(idPolicial){
               // alert('show'+idPolicial);
                //show modal
                $('#modalRemoverEmLotePmQualquerNota').modal({
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
                    $.ajax({
                        headers: {
                            '_token': token
                            },
                        //Enviando via ajax
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
                            alert(data.msg);
                            if(data.retorno=='sucesso'){                    
                                window.location.href = getBaseUrl()+"/boletim/nota/edit/"+idNota+"/"+idTipoNota;
                                //$(location).href("boletim/nota/edit/"+nota.ce_nota+"/"+nota.ce_tipo);
                            }else{                        
                                $('#modalRemoverPmQualquerNota').modal('hide');                       
                            }                               
                        },
                        error: function (request, status, error) {
                            //alert(request.responseText);
                            alert('Falha para excluir o policial: '+request.responseText);
                        }
                    });
                }            
            }

            function removerPmEmLoteQualquerNota(){

                var token = $("input[name=_token]").val();
                var baseUrl = getBaseUrl()+"/boletim/tiponota/delpolicialparacadatiponota";
                var idNota = $('#idNota').val();
                var idTipoNota = $('#ce_tipo').val();
                $.ajax({
                    headers: {
                        '_token': token
                        },
                    //Enviando via ajax
                    url : baseUrl,
                    dataType: "json",
                    data: {// change data to this object
                        _token: token,
                        ce_nota:  idNota,
                        ce_tipo:  idTipoNota,
                        bo_exclusaolotepoliciais: "1"
                    },            
                    method: 'post',
                    success: function (data) {
                        alert(data.msg);
                        if(data.retorno=='sucesso'){                    
                            window.location.href = getBaseUrl()+"/boletim/nota/edit/"+idNota+"/"+idTipoNota;
                            //$(location).href("boletim/nota/edit/"+nota.ce_nota+"/"+nota.ce_tipo);
                        }else{                        
                            $('#modalRemoverEmLotePmQualquerNota').modal('hide');                       
                        }                               
                    },
                    error: function (request, status, error) {
                        //alert(request.responseText);
                        alert('Falha para excluir o lote de policiais: '+request.responseText);
                    }
                });
            }




    </script>
@endsection

@section('css')
<style>

    .mb-10 {
        margin-bottom: 10px;
    }

    th, td {
        text-align: center;
    }

</style>
@endsection