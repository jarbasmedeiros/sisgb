@extends('boletim::boletim.template_boletim')

@php 
    use app\utis\Funcoes;
@endphp
@section('title', 'Elaborar Nota')
@section('content_dinamic')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary container-fluid">
                <div class="panel-heading row">
                    <div class="col-md-10">Elaborar Nota</div>
                    <div class="col-md-2">{{(isset($nota)) ? 'SITUAÇÃO: ' . $nota->st_status : ''}}</div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" id="form_create_nota" action="{{url('/boletim/nota/store') }}">
                        {{csrf_field()}}
                        
                        <input type="hidden"  name="idNota" id="idNota" value="{{(isset($nota)) ? $nota->id : 0 }}">
                        <input type="hidden"  name="idPolicial" id="idPolicial" value="">
                        <input type="hidden"  name="ce_tipobkp" id="ce_tipobkp" value="{{$tipoNota->id}}">
                        
                    
            @if(isset($nota))
                    <input type="hidden"  name="bo_telaedicao" id="bo_telaedicao" value="1">                
                 @if(isset($policiaisDaNota) && (count($policiaisDaNota) > 0) )                    
                        <input type="hidden"  name="bo_tempolicial" id="bo_tempolicial" value="1">
                 @else
                        <input type="hidden"  name="bo_tempolicial" id="bo_tempolicial" value="0">    
                @endif
            @else
                        <input type="hidden"  name="bo_tempolicial" id="bo_tempolicial" value="0">    
                        <input type="hidden"  name="bo_telaedicao" id="bo_telaedicao" value="0">                
            @endif










                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">INFORMAÇÕES SOBRE O ASSUNTO DA NOTA</legend>
                            <div class="form-group">
                                <label for="ce_tipo" class="col-md-2 control-label">Tipo da nota</label>
                                <div class="col-md-6">
                                    <select class="form-control select2" id="ce_tipo" name="ce_tipo" onchange="exibirTipoNotaSelecionado(this)">
                                        @if(isset($tipos))
                                            @foreach($tipos as $t)
                                                <option value="{{$t->id}}" {{((isset($nota) && ($t->id == $tipoNota->id)) || ($tipoNota != '' && $tipoNota->id == $t->id)) ? 'selected' : ''}}>{{$t->st_tipo}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <span class="fa fa-question-circle primary control-label" data-toggle="tooltip" title="Para cada ASSUNTO existe no sistema um tipo de formulário (denominado Tipo de Nota) específico que ajudará o sistema atualizar automaticamente as fichas dos policiais com as informações da nota quando necessário."></span>
                            </div>
                            <div class="form-group">
                                <label for="st_assunto" class="col-md-2 control-label" >Assunto</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="st_assunto" id="st_assunto" value="{{(isset($nota)) ? $nota->st_assunto : '' }}" placeholder="Digite um Assunto"
                                    required="required">
                                    @if ($errors->has('st_assunto'))
                                        <div class="alert alert-danger" role="alert">
                                            <strong>{{ $errors->first('st_assunto') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <span class="fa fa-question-circle control-label" data-toggle="tooltip" title="O assunto é o tema sobre o qual a discussão ou o texto da nota está sendo tratado."></span>
                            </div>
                        </fieldset>
                        
                       
                        <div class="camposdanota"></div>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">MATÉRIA DA NOTA</legend>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea class="ckeditor" id="st_materia" name="st_materia">{{(isset($nota)) ? $nota->st_materia : '' }}</textarea>
                                    @if ($errors->has('st_materia'))
                                        <div class="alert alert-danger" role="alert">
                                            <strong>{{ $errors->first('st_materia') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        @if($tipoNota != '' && $tipoNota->st_tela != 'nota_template')
                           @if($tipoNota->id==17)
                                @include('boletim::notas/tipos/nota_movimentacao_praca')
                           @else 
                        
                                @include('boletim::notas/' . $tipoNota->st_tela)
                           @endif 
                        @endif
                        
                        <div class="form-group col-md-12">
                            
                            <a href='{{ url("boletim/notas")}}' class="col-md-1 btn btn-warning" style="margin: 5px">
                                <span class="fa fa-reply"></span> Voltar
                            </a>
                            
                            @if(!isset($nota) || ($nota->st_status == 'RASCUNHO'))
                                <button type="submit" id="salvarNota" class="col-md-1 btn btn-primary" style="margin: 5px" >
                                    <i class="fa fa-save"></i> Salvar
                                </button>
                            @endif
                            @if(isset($nota))
                                <a href='{{ url("boletim/nota/visualizar/".$nota->id)}}' class="col-md-2 btn btn-primary" target="_blank" style="margin: 5px">
                                    <span class="fa fa-file-pdf-o"></span> Visualizar
                                </a>
                               
                                @if($nota->st_status == 'ENVIADA')
                                    <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#aceitarModal">
                                        <span class="fa fa-check"></span> Aceitar
                                    </button>
                                    <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#recusarModal">
                                        <span class="fa fa-close"></span> Recusar
                                    </button>
                                @endif
                                @if($nota->st_status == 'RECEBIDA')
                                    <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#recusarModal">
                                        <span class="fa fa-close"></span> Recusar
                                    </button>
                                @endif
                                @if($nota->st_status == 'FINALIZADA' || $nota->st_status == 'ASSINADA' || $nota->st_status == 'RECUSADA')
                                    <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#corrigirModal">
                                        <span class="fa fa-edit"></span> Corrigir
                                    </button>
                                @endif
                                @if($nota->bo_policial == 1)
                                    @if($nota->st_status == 'RASCUNHO' && isset($policiaisDaNota) && count($policiaisDaNota) > 0 )
                                        <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#assinarModal">
                                            <span class="fa fa-edit"></span> Assinar
                                        </button>
                                    @endif
                                @else
                                    @if($nota->st_status == 'RASCUNHO')
                                        <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#assinarModal">
                                            <span class="fa fa-edit"></span> Assinar
                                        </button>
                                    @endif
                                @endif
                               <!--  @if($nota->st_status == 'ASSINADA' && $nota->bo_enviado != 1)
                                    <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#enviarModal">
                                        <span class="fa fa-send-o"></span> Enviar
                                    </button>
                                @endif -->
                            @endif
                        </div>
                    </form><!--fim form nota 1-->
                </div>
            </div>
        </div>
    </div>
    @if(isset($nota))
        <!-- Moldal para botão finalizar -->
        <div class="modal fade" id="finalizarModal" tabindex="-1" role="dialog" aria-labelledby="finalizarModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="finalizarModalLabel">Finalizar Nota</h5>
                    </div>
                    <div class="modal-body">
                        <div>
                            <strong> DESEJA REALMENTE FINALIZAR A NOTA? </strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <a href='{{url("boletim/nota/finalizar/".$nota->id)}}' class="btn btn-primary">Sim</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Moldal para botão corrigir -->
        <div class="modal fade" id="corrigirModal" tabindex="-1" role="dialog" aria-labelledby="corrigirModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="corrigirModalLabel">Retornar Nota para Elaboração</h5>
                    </div>
                    <div class="modal-body alert-danger">
                        <div class="alert-danger">
                            <strong> DESEJA REALMENTE RETORNAR A NOTA PARA ELABORAÇÃO? </strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <a href='{{url("boletim/nota/corrigir/".$nota->id)}}' class="btn btn-primary">Sim</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Moldal para botão assinar -->
        <div class="modal fade" id="assinarModal" tabindex="-1" role="dialog" aria-labelledby="assinarModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="assinarModalLabel">Assinar Nota</h5>
                    </div>
                    <div class="modal-body bg-danger">
                    <form name="assinar_form" role="form" action='{{ url("boletim/nota/assinar/".$nota->id)}}' method="POST">
                        <div class="form-group">
                            <strong> DESEJA REALMENTE ASSINAR A NOTA? </strong>
                                <br>
                                <label for="st_password" class="control-label">Senha</label>
                                <input type="password" class="control-form" name="st_password" required>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Sim</a>

                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Moldal para botão enviar -->
        <div class="modal fade" id="enviarModal" tabindex="-1" role="dialog" aria-labelledby="enviarModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="enviarModalLabel">Enviar Nota</h5>
                    </div>
                    <div class="modal-body">
                        <div>
                            <strong> DESEJA REALMENTE ENVIAR A NOTA PARA BOLETIM GERAL? </strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <a href='{{url("boletim/nota/enviar/".$nota->id)}}' class="btn btn-primary">Sim</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Moldal para botão recusar -->
        <div class="modal fade" id="recusarModal" tabindex="-1" role="dialog" aria-labelledby="recusarModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="recusarModalLabel">Recusar Nota</h5>
                    </div>
                    <div class="modal-body">
                        <form action='{{ url("boletim/nota/recusar/".$nota->id)}}' method="POST">
                            {{csrf_field()}}
                            <div class="alert-danger">
                                <strong> DESEJA REALMENTE RECUSAR A NOTA? </strong>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="st_obs">Observação:</label>
                                <textarea class="form-control" name="st_obs" id="st_obs" required></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Recusar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Moldal para botão aceitar -->
        <div class="modal fade" id="aceitarModal" tabindex="-1" role="dialog" aria-labelledby="aceitarModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="aceitarModalLabel">Aceitar Nota</h5>
                    </div>
                    <div class="modal-body">
                        <div>
                            <strong> DESEJA REALMENTE ACEITAR A NOTA? </strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <a href='{{url("boletim/nota/aceitar/".$nota->id)}}' class="btn btn-primary">Sim</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
@section('scripts')
    <script>

    function exibirTipoNotaSelecionado(combo){
        var tipoNotaSelecionada = $(combo).val();
        var telaEmEdicao = $('#bo_telaedicao').val();
        var temPolicial = $('#bo_tempolicial').val();
        if(telaEmEdicao==1){
            if(temPolicial==1){                 
                    alert('Náo é possível alterar o tipo de nota com policiais vinculados')
                    document.location.reload(true);
            }else{
               window.location.href = "{{ url('boletim/nota/edit/') }}" +"/"+ idNota+"/" + tipoNotaSelecionada;
            }
        }else{
            window.location.href = "{{ url('boletim/nota/create/') }}" + "/" + tipoNotaSelecionada;
        }
    }
        $(document).ready(function(){
         
            idNota = $('#idNota').val();
            tipoNota = $('#ce_tipo').val();
            idPolicial = 0;
            if(idNota == null || idNota == undefined || idNota == ""){
                idNota =0;
            }
            policial = null;
            @if(isset($nota))
                $("#form_create_nota").attr('action', "{{ url('boletim/nota/update/'.$nota->id) }}");
                /* Desabilitando os inputs caso seja o status seja RASCUNHO */
                var input = document.getElementsByTagName('input');
                /* Desabilitando o select e o textarea*/
                @if ($nota->st_status != 'RASCUNHO')
                    $("#ce_tipo").attr('disabled', true);                  

                    $("textarea").attr('disabled', true);
                    $("#st_obs").attr('disabled', false);
                @else
                    @if(isset($policiaisDaNota) && count($policiaisDaNota) > 0)
                    $("#ce_tipo").attr('disabled', true);                   
                    @else
                    $("#ce_tipo").attr('disabled', false);                   

                    @endif        
                    $("textarea").attr('disabled', false);
                @endif
                /* Percorre todos os inputs para desabilitalos */
                for( var i=0; i<=(input.length-1); i++ ){
                    @if ($nota->st_status != 'RASCUNHO')
                        input[i].disabled = true;
                    @else
                        input[i].disabled = false;
                    @endif
                }
                $("input[name=_token]").attr('disabled', false);
               
            @endif
        });
        /* Configuração do CKEditor */
        CKEDITOR.replace( 'st_materia', {
            toolbar: [
                { name: 'document', items : [ 'NewPage','Templates' ] },
                { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
                { name: 'editing', items : [ 'Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
                { name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
                { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
                { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
                '/',
                { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
                { name: 'colors', items : [ 'TextColor','BGColor' ] }                            
            ]
        });


      /*   $('#ce_tipo').change(function(){
            var tipoNota = $('#ce_tipo').val();
            //$("#form_create_nota").attr('action', 'foo');
            //$("#form_create_nota").attr('action', 'foo');
           
            @if(isset($nota))
                 @if(isset($policiaisDaNota) && (count($policiaisDaNota) > 0) )
                    alert('Náo é possível alterar o tipo de nota com policiais vinculados')
                    document.location.reload(true);
                 @else
                    if(tipoNota == 1){
                        window.location.href = "{{ url('boletim/nota/edit/' . $nota->id) }}" + "/" + tipoNota;
                    }
                @endif
            @else
                window.location.href = "{{ url('boletim/nota/create/') }}" + "/" + tipoNota;
                
                //alert(hidinputs);
            @endif
        }); */
        
        function buscaPolicialParaNota(){
            dadoPolicial = $('#st_policial').val();
            if(dadoPolicial != null && dadoPolicial != undefined && dadoPolicial != ""){
                $.ajax({
                    url : "{{url('boletim/buscapolicialparanota')}}" + "/" + dadoPolicial,
                    type : 'get',
                    beforeSend : function(){
                        $("#resultado").html("ENVIANDO...");
                    }
                }).done(function(msg){
                    $('#st_policial').val("");
                    if(msg == 0){
                        alert('Policial não encontrado');
                    }else{
                        idPolicial = msg.id;
                        $("#nome").html("Nome: "+msg.st_nome)
                        $("#matricula").html("Matrícula: "+msg.st_matricula)
                        $('#modalPolicial').modal('show');
                    }
                }).fail(function(jqXHR, textStatus, msg){
                    alert(msg);
                })
            }else{
                alert('informe a Matrícula ou cpf do policial');
                
            }
        }

        function addPolicialParaNota(){
            $.ajax({
                url : "{{url('boletim/adicionarpolicialparanota')}}"+"/"+idNota+"/"+idPolicial+"/"+tipoNota,
                method : 'get',
                beforeSend : function(){
                    $("#resultado").html("ENVIANDO...");
                }
            }).done(function(msg){
                if(msg == 0){
                    alert('Selecione um policial para Adicionar a nota.');
                }else if(msg == 1){
                    alert('A Nota do boletim não foi encontrada.');
                }else if(msg == 2){
                    alert('Só pode adcionar boletim a nota enquanto ela estiver com status de Racunho.');
                }else if(msg == 3){
                    alert('Policial não encontrado em nossa base de dados.');
                }else if(msg == 0){
                    alert('Selecione um policial para Adicionar a nota.');
                }else if(msg == 4){
                    alert('Este policial já está adicionado.');
                }else if(msg == 5){
                    alert('Ocorreu um erro desconhecido. Pode ser que  policial não tenha sido adicionado a nota.');
                }else{
                    window.location.href = "{{ url('boletim/nota/edit')}}/"+msg.id+"/"+msg.ce_tipo;
                }
            }).fail(function(jqXHR, textStatus, msg){
                alert(msg);
            })
        }
        //adiciona o href dinamico para o modal de comfirmação de remoção de policial da nota
        function populaModalConfRemoverPolicial(idPolicial){
            $("#urlRemoverPolicialNota").attr("href", "{{ url('boletim/removerpolicialparanota')}}/"+idNota+"/"+idPolicial);
        }
    </script>


@stop