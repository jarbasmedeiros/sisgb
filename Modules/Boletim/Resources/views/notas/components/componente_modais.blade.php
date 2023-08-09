@if(isset($nota))
   
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

    <!-- Moldal para botão finalizar -->
   <div class="modal fade" id="finalizarModal" tabindex="-1" role="dialog" aria-labelledby="finalizarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="finalizarModalLabel">Finalizar edição da Nota</h5>
                </div>
                <div class="modal-body alert-warning">
                    <div class="alert-warning">
                        <strong> DESEJA REALMENTE FINALIZAR A EDIÇÃO DA NOTA ? </strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <a href='{{ url("boletim/nota/finalizar/".$nota->id)}}' class="btn btn-primary">Sim</a>
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

     <!---modal remover Policial --->
     <div class="modal fade" id="modalRemoverPmQualquerNota" tabindex="-1" role="dialog" aria-labelledby="removerPolicialModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remover Policial da Nota</h5>
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

        <!-- Moldal para botão excluir nota -->
        <div class="modal fade" id="excluirNotaProcessoModal" tabindex="-1" role="dialog" aria-labelledby="excluirNotaProcessoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="excluirNotaProcessoModal">Excluir Nota</h5>
                </div>
                <div class="modal-body alert-danger">
                    <div class="alert-danger">
                        <strong> DESEJA REALMENTE EXCLUIR A NOTA ? </strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <a href='{{url("boletim/notaprocesso/excluir/".$nota->id)}}' class="btn btn-primary">Sim</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Moldal para chefia autorizar nota -->
    <div class="modal fade" id="autorizarModal" tabindex="-1" role="dialog" aria-labelledby="autorizarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="autorizarModalLabel">Autorizar Nota</h5>
                </div>
                <div class="modal-body">
                    <div>
                        <strong> DESEJA REALMENTE AUTORIZAR A NOTA? </strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <a href='{{url("boletim/nota/devolver/".$nota->id."/1")}}' class="btn btn-primary">Sim</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Moldal para chefia autorizar nota -->
    <div class="modal fade" id="desautorizarModal" tabindex="-1" role="dialog" aria-labelledby="desautorizarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="desautorizarModalLabel">Autorizar Nota</h5>
                </div>
                <div class="modal-body">
                    <div>
                        <strong> DESEJA REALMENTE DESAUTORIZAR A NOTA? </strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <a href='{{url("boletim/nota/devolver/".$nota->id."/0")}}' class="btn btn-primary">Sim</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Moldal para chefia tramitar nota -->
    <div class="modal fade" id="tramitarModal"  role="dialog" aria-labelledby="tramitarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="tramitarModalLabel">Tramitar Nota</h5>
                </div>
                <form method="POST" action='{{ url("boletim/nota/tramitar")}}' id="tramitar_form" name="tramitar_form"  >
                    {{csrf_field()}}   
                <div class="modal-body">
                        @if(isset($nota))
                            <input type="hidden" name="id" value="{{$nota->id}}"/>
                        @endif
                       
                         <!-- Campo Unidade -->
                        <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }} col-md-6">
                            <label for="ce_unidade" class="control-label">Selecione a unidade de destino</label>
                            <select id="ce_unidade" name="ce_unidade"  class="form-control select2" style="width: 100%;" required>
                                <option value="" >--Selecione--</option>
                                @if(isset($unidades))
                                    @foreach($unidades as $u)
                                        <option value="{{$u->id}}">{{$u->st_nomepais}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('ce_unidade'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('ce_unidade') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"form="tramitar_form" >Tramitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endif