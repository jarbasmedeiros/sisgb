@extends('adminlte::page')

@php 
    use app\utis\Funcoes;
    
@endphp

@section('title', 'Elaborar Nota')

@section('css')
    <link href="{{ asset('assets/css/layout.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary container-fluid">
                <div class="panel-heading row">
                    <div class="col-md-10">Elaborar Nota</div>
                    <div class="col-md-2">{{(isset($nota)) ? 'Situação: ' . $nota->st_status : ''}}</div>                
                </div>               
                @php 
                //get url para saber se está em edição ou criação
                $urlFull = $_SERVER['REQUEST_URI'];
                $url = explode('/',$urlFull);
                $urlEdit = $url[4];

                @endphp
                <input type="hidden"  name="idPolicial" id="idPolicial" value="">
                <input type="hidden"  name="ce_tipobkp" id="ce_tipobkp" value="{{$tipoNota->id}}">
                <input type="hidden"  name="bo_telaedicao" id="bo_telaedicao" value="{{$urlEdit}}">
                <input type="hidden"  name="ce_policialselecionadoexclusao" id="ce_policialselecionadoexclusao" >
                <input type="hidden"  name="idNota" id="idNota" value="{{(isset($nota)) ? $nota->id : 0 }}">         
       
                <div class="panel-body">  
                    @if($urlEdit=='edit')
                    <form class="form-horizontal" role="form" method="POST" id="form_update_nota" action="{{url('/boletim/nota/update/'.$nota->id) }}">  
                    @else 
                    
                    <form class="form-horizontal" role="form" method="POST" id="form_create_nota" action="{{url('/boletim/nota/store') }}">  
                    @endif
                    <!--   <input type="text"  name="ce_nota" id="ce_nota" value="{{(isset($nota)) ? $nota->id : 0 }}"> -->

                        {{csrf_field()}}                  
                        <!-- fragmento_infomacoes_nota-->   
                        
                        @if(isset($nota))           
                            @component('boletim::notas.components.componente_info_nota',['tipos'=>$tipos,'nota'=>$nota,'tipoNota'=>$tipoNota])
                        @else 
                            @component('boletim::notas.components.componente_info_nota',['tipos'=>$tipos,'tipoNota'=>$tipoNota])
                        @endif                        
                        @endcomponent     
                        <!-- end fragmento_infomacoes_nota-->

                        <!-- fragmento_materia-->
                        @if(isset($nota))   
                            @component('boletim::notas.components.componente_materia',['nota'=>$nota,'tipoNota'=>$tipoNota]) @endcomponent 
                            @component('boletim::notas.components.componente_rodape',['nota'=>$nota,'tipoNota'=>$tipoNota]) @endcomponent

                            {{-- atribuição feita para usar no CKEDITOR.replace na hora de adicionar uma imagem --}}
                            @php $notaId = $nota->id @endphp 

                        @else
                            @component('boletim::notas.components.componente_materia') @endcomponent 
                            @component('boletim::notas.components.componente_rodape') @endcomponent 
                            {{-- atribuição feita para usar no CKEDITOR.replace na hora de adicionar uma imagem --}}
                            @php $notaId = -1 @endphp 
                        @endif
                        <!-- end fragmento_materia-->
                            @php
                            //dd($tipoNota);
                            @endphp
                    

                     <!-- região específica de cada nota-->
                     @yield('conteudo_especifico_das_notas')
                        <!-- end região específica de cada nota-->





                        @if(isset($tipoNota) && $tipoNota->bo_policial==1)
                            <fieldset class="scheduler-border">
                            <legend class="scheduler-border">INFORMAÇÕES DO POLICIAL</legend>
                                <div class="form-group">
                                    @if( isset($nota)  && $nota->ce_tipo ==  $tipoNota->id)
                                        @if(  $nota->st_status ==  'RASCUNHO')
                                        <div class='form-group'><!--inicio de form group -->
                                            <div class='col-md-4 col-md-offset-3' style="padding-right:0px;">
                                                <label for="txtCpfMatriculaPolicial" class="col-md-2 control-label">Policial</label>
                                                <input style="width:83%"  id="txtCpfMatriculaPolicial" type="text"  class="form-control col-md-2" name="txtCpfMatriculaPolicial" placeholder="Digite o CPF ou Matrícula do Policial à Pesquisar">
                                            </div>
                                            <div class="col-md-5" style="padding-left:0px;">
                                                <!-- Botão para acionar modal -->
                                                <a id="btnConsultarPm" name="btnConsultarPm" class="btn btn-primary search" title="Pesquisar Policial" onclick="consultarPmQualquerNota()" >
                                                    <i class="fa fa-search"></i> 
                                                </a>
                                                @if($nota->ce_tipo == 2)
                                                    <!--Botão para adicionar policial em lote -->
                                                    <a id="btnEmLote" name="btnEmLote" class="btn btn-primary search" onclick="digitarPoliciaisEmLote()" >
                                                        Adicionar Em Lote 
                                                    </a>
                                                    @if (isset($policiaisDaNota) && count($policiaisDaNota) > 1)
                                                        <a id="btnExcluirEmLote" name="btnExcluirEmLote" class="btn btn-danger search" onclick="showModalRemoverEmLotePmQualquerNota()" >
                                                            Excluir Em Lote 
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div><!--fim de form group -->
                                        
                                        @endif
                                        </div>
                                        <!-- listagem dinamica dos policiais da nota-->    
                                                                    <br/>
                                        <table class="table table-striped table-bordered" >
                                            <thead>
                                                <tr class="bg-primary">
                                                <!-- cabeçalho dinamico da listagem dos policiais da nota-->    
                                                    @yield('fragmento_head_tbl_policias_notas')                                          
                                                <!-- end cabeçalho dinamico da listagem dos policiais da nota-->    
                                                </tr>
                                            </thead>
                                            @if(isset($nota->id))
                                                <tbody class="addPolicialEncontrado_tbody">                                           
                                                    <!-- cabeçalho dinamico da listagem dos policiais da nota-->    
                                                        @yield('fragmento_body_tbl_policias_notas')                                          
                                                    <!-- end cabeçalho dinamico da listagem dos policiais da nota-->                                               
                                                </tbody>
                                            @endif
                                        </table>
                                            
                                        @if(isset($policiaisDaNota) && count($policiaisDaNota) > 0 )
                                            <div class="pagination pagination-centered">
                                                <tr>
                                                    <th>
                                                    {{$policiaisDaNota->links()}}
                                                    </th>
                                                </tr>
                                            </div>
                                        @endif
                                        <!-- end listagem dinamica dos policiais da nota-->    
                                    @else
                                        <h4>&nbsp;&nbsp;&nbsp; Ao salvar a nota o sistema habilitará o formulário para incluir os policiais </h4>
                                    @endif                            
                                </div>
                            </fieldset>
                        @endif
                        <!-- fragmento_policias_notas-->
                        @yield('fragmento_policias_notas')
                        <!-- end fragmento_policias_notas-->

                        <!-- fragmento_materia -->
                            
                        @if(isset($nota))  
                            @if(isset($policiaisDaNota))    
                                @component('boletim::notas.components.componente_botoes',['nota'=>$nota,'tipoNota'=>$tipoNota,'policiaisDaNota'=>$policiaisDaNota]) @endcomponent                        
                            @else
                                @component('boletim::notas.components.componente_botoes',['nota'=>$nota,'tipoNota'=>$tipoNota]) @endcomponent                        
                            @endif
                        @else
                            @component('boletim::notas.components.componente_botoes') @endcomponent                        
                        @endif
                        <!-- end fragmento_materia-->
                    </form>
                </div>
            </div>
        </div>
    </div>
        
    <!-- fragmento_modais-->
    @yield('fragmento_modais')
    <!-- end fragmento_modais-->
        @if(isset($nota))  
     
            @component('boletim::notas.components.componente_modais',['nota'=>$nota,'unidades'=>$unidades]) @endcomponent                        
        @endif
        @yield('fragmento_modais_da_nota')  

        @yield('content_dinamic')      
    @stop

    @section('js')
        <!-- Java script para as notas -->
        <script src="{{ asset('js/notas.js') }}"></script>   
            
        <script >                    
            function exibirTipoNotaSelecionado(combo){      
                var tipoNotaSelecionada = $(combo).val();
                var telaEmEdicao = $('#bo_telaedicao').val();
                var temPolicial = $('#bo_tempolicial').val();
                var idNota = $('#idNota').val();
                
                if(telaEmEdicao == 'edit'){
                //   if(temPolicial==1){                 
                //         alert('Náo é possível alterar o tipo de nota com policiais vinculados')
                //          document.location.reload(true);
                //   }else{
                    window.location.href = "{{ url('boletim/nota/edit/') }}" +"/"+ idNota+"/" + tipoNotaSelecionada;
                //   }
                }else{
                    window.location.href = "{{ url('boletim/nota/create/') }}" + "/" + tipoNotaSelecionada;
                }
            }
            
            function consultarPmTemplate() {
                if($('#txtCpfMatriculaPolicial').val()==''){
                    alert('Informar o CPF ou Matrícula do Policial');
                    }else{
                    // alert('consultar pm1');
                    
                    $('#modalConsultaPm').modal({
                        show: 'true'
                    }); 
                    
                    var idNota = $("#ce_tipo option:selected").val();
                    
                    baseUrl = getBaseUrl()+"/";
                    //alert(baseUrl);
                    var user = $('#txtCpfMatriculaPolicial').val();
                    //alert(user); return false;
                    $.ajax({
                        //Enviando via ajax
                        url : baseUrl+"boletim/consultarpolicial/"+user,
                        method: 'get',
                        //Verificando se cadastrou
                    }).done(function(data){
                        //console.log(data.length);
                        if(data != 1){
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
                    });
                }
            } 
             
            CKEDITOR.replace('st_materia', {
                filebrowserUploadUrl: "{{route('uploadImagemNota', ['_token' => csrf_token(), 'nota_id' => $notaId,])}}",
                filebrowserUploadMethod: 'form'
            });

            CKEDITOR.replace('st_rodape', {
                filebrowserUploadUrl: "{{route('uploadImagemNota', ['_token' => csrf_token(), 'nota_id' => $notaId,])}}",
                filebrowserUploadMethod: 'form'
            });

            

            
            

        </script>   

        <!-- fragmento_scripts-->
        @yield('fragmento_scripts_das_notas')
        <!-- end fragmento_scripts-->
        <!-- fragmento_scripts-->
        @yield('fragmento_scripts_dos_componentes')
        <!-- end fragmento_scripts-->
    @stop


 








