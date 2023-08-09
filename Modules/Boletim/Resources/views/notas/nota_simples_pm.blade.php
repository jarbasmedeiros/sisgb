

    <!--<form class="form-horizontal" role="form" method="POST" action="{{ url('/boletim/store') }}">-->
        {{csrf_field()}}
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Informações do Policial</legend>
            <div class="form-group">
                @if((!empty($nota)) || (isset($nota) && $nota->st_status ==  'RASCUNHO' ))
                    <label for="st_assunto" class="col-md-2 control-label">Policial</label>
                    <div class="col-md-6">
                        <input id="consultaPolicial" type="text" class="form-control" name="" value="" placeholder="Buscar policial por CPF ou Matrícula...">
                    </div>
                    <div class="col-4">
                        <!-- Botão para acionar modal -->
                        <a id="consultar" class="btn btn-primary" onclick="consultar()" data-toggle="modal" data-target="#modalExemplo">
                        Consultar
                        </a>
                    </div>
                @else
                    <h4>Ao salvar o sistema habilita o formulário para incluir de policias </h4>
                @endif
            
                    
                
            </div>
            <table class="table table-striped" >
            <thead>
                <tr class="bg-primary">
                    <th>Post/Grads</th>
                    <th>Praça</th>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            @if(isset($nota->id))
                <tbody class="addPolicialEncontrado_tbody">
                @if(isset($policiaisDaNota) && count($policiaisDaNota) > 0)
                    @foreach($policiaisDaNota as $key => $policiais)
                        
                        <tr>
                            <td>{{$policiais->st_postograduacaosigla}}</td>
                            <td>{{$policiais->st_numpraca}}</td>
                            <th>{{$policiais->st_matricula}}</th>
                            <th id="policial_{{$policiais->id}}">{{$policiais->st_nome}}</th>
                            <th>
                               
                                @if($nota->st_status == 'RASCUNHO')
                                    <a class="btn btn-danger btn-sm removerPolicial" id="{{$policiais->id}}" value="{{$policiais->id}}" data-toggle="modal" data-target="#removerPolicialModal" title="Remover Policial">
                                    <span class="fa fa-trash"></span></a>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                @endif
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
        <div class="camposdanota"></div>
 </fieldset>
      
<!--</form>-form nota com pm-->
<!-- Modal -->
<div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="exampleModalLabel">Adicionar Policial em Lote</h4>
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
                            </div>
                            <br/>
                            <div class="modal-footer">
                                <button type="button" id="adicionar" class="btn btn-primary addPolicial">Adicionar</button>
                                <button type="button" id="canceladd" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
</div>
<!---end modal  --->
<!---modal remover Policial --->
<div class="modal fade" id="removerPolicialModal" tabindex="-1" role="dialog" aria-labelledby="removerPolicialModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remover Policial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">
                <h5>DESEJA REALMENTE REMOVER ESTE POLICIAL DA NOTA?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="button" class="btn btn-primary" onclick="removerPolicial()">Remover</button>
            </div>
        </div>
    </div>
</div>
  <!---modal remover Policial --->

