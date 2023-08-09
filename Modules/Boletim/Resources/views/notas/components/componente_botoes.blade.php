<!-- botões componente-->
<div class="form-group col-md-12">                            

@if(Request::segment(3)=='edit')
    <a href='{{ url("boletim/notas")}}' class="col-md-1 btn btn-warning" style="margin: 5px">
        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
    </a>  
@else 
    <a href='{{ url()->previous()}}' class="col-md-1 btn btn-warning" style="margin: 5px">
        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
    </a>  
@endif
   
        
    @if(!isset($nota))
        <button type="submit" id="salvarNota" class="col-md-1 btn btn-primary" style="margin: 5px" >
            <i class="fa fa-save"></i> Salvar
        </button>
    @endif
  
    @if(isset($nota))
        @if ($nota->st_status != 'RASCUNHO')
            <a href='{{ url("boletim/nota/visualizar/".$nota->id)}}' class="col-md-1 btn btn-primary" target="_blank" style="margin: 5px">
                <span class="fa fa-file-pdf-o"></span> Visualizar
            </a>    
        @endif
      
        @if(empty($nota->ce_unidadetramitada))
            <!-- notas elaboradas por processos --> 
            @if(isset($tipoNota) && $tipoNota->bo_processo == 1)

                @if(!in_array($nota->st_status,array('ENVIADA','RECEBIDA','ATRIBUIDA','PUBLICADA')))
                    <button type="button" class="col-md-2 btn btn-danger" style="margin: 5px" data-toggle="modal" data-target="#excluirNotaProcessoModal">
                        <span class="fa fa-trash"></span> Excluir
                    </button>
                @endif
                @if( $nota->st_status == 'FINALIZADA' && auth()->user()->can('assina_nota_boletim') )
                    <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#assinarModal">
                        <span class="fa fa-edit"></span> Assinar
                    </button>
                @endif
                @if($nota->st_status == 'FINALIZADA' || $nota->st_status == 'ASSINADA' )
                    <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#tramitarModal">
                        <span class="fa fa-send-o"></span> Tramitar
                    </button>
                @endif
            @else
                <!-- notas elaboradas fora de processo -->
                @if(!in_array($nota->st_status,array('ATRIBUIDA','PUBLICADA')))
                
                    @if($nota->st_status == 'RASCUNHO')
                        <button type="submit" id="salvarNota" class="col-md-1 btn btn-primary" style="margin: 5px" >
                        <i class="fa fa-save"></i> Salvar
                    </button>
                        @if(isset($tipoNota) && $tipoNota->bo_policial == 1 )
                                @if( isset($policiaisDaNota) && count($policiaisDaNota) > 0 )
                                    <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#finalizarModal">
                                        <span class="fa fa-check"></span> Finalizar
                                    </button>
                                @endif
                        @else 
                            <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#finalizarModal">
                                <span class="fa fa-check"></span> Finalizar
                            </button>  
                        @endif
                    @endif
                   
                    @if($nota->st_status == 'FINALIZADA' || $nota->st_status == 'ASSINADA' || $nota->st_status == 'RECUSADA')
                        <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#corrigirModal">
                            <span class="fa fa-edit"></span> Corrigir
                        </button>
                    @endif
                    @if(isset($tipoNota) && $tipoNota->bo_policial == 1 )
                        @if($nota->st_status == 'FINALIZADA' && isset($policiaisDaNota) && (count($policiaisDaNota) > 0) && auth()->user()->can('assina_nota_boletim') )
                            <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#assinarModal">
                                <span class="fa fa-edit"></span> Assinar
                            </button>
                        @endif
                    @else
                        @if($nota->st_status == 'FINALIZADA' && auth()->user()->can('assina_nota_boletim'))
                            <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#assinarModal">
                                <span class="fa fa-edit"></span> Assinar
                            </button>
                        @endif
                    @endif
                    
                    @if($nota->st_status == 'FINALIZADA' || $nota->st_status == 'ASSINADA' )
                        <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#tramitarModal">
                            <span class="fa fa-send-o"></span> Tramitar
                        </button>
                    @endif
                    
                    
                @endif 
            @endif 
        @else 
            @if($nota->ce_unidadetramitada == auth()->user()->ce_unidade)
                @if($nota->st_status == 'FINALIZADA' && auth()->user()->can('assina_nota_boletim'))
                   
                        <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#assinarModal">
                            <span class="fa fa-edit"></span> Assinar
                        </button>
                   
                @endif
                @if($nota->st_status == 'FINALIZADA' || $nota->st_status == 'ASSINADA' )
                        <button type="button" class="col-md-2 btn btn-primary" style="margin: 5px" data-toggle="modal" data-target="#tramitarModal">
                            <span class="fa fa-send-o"></span> Tramitar
                        </button>
                @endif
            @else 
                 <div class="bg-red text-center col-md-7" style="margin-top: 60px; padding: 5px; "> ATENÇÃO: enquanto esta nota estiver tramitada (em outra unidade) você não terá permissão para alterá-la. </div>
            @endif
        @endif
  
        
    @else
        <!-- ops,erro_sem_nota_componente_botoes -->
    @endif
</div>

<!-- end botões componente -->
