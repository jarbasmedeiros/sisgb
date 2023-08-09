            <div class="row">
            <div class="form-row form-inline">
                <div class="form-group col-xs-3 col-md-3 col-sm-3" style="margin-left:auto; padding-top:10px;">
                    <label style="padding: 2%;"><strong>Policial</strong></label>
                    <input type="text" class="form-control" id="st_policial" placeholder="Matrícula ou CPF">
                    @if(isset($nota))
                    <input type="hidden" class="form-control" id="idNota" value="{{$nota->id}}">
                    @endif
                    <button type="button" onclick="buscaPolicialParaNota()" class="btn btn-primary glyphicon glyphicon-search" title= "Localizar Policial"></button>
                </div>
            </div>
               
            </div>
            <div class="table-responsive">
                <table class="table striped" id="policiais">
                <thead>
                    <tr>
                        <th>Ordem</th>
                        <th>Post/Grad</th>
                        <th>Praça</th>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($policiaisDaNota) && !empty($policiaisDaNota))
                        @php $ordem = 0;@endphp
                        @foreach($policiaisDaNota as $policial)
                            @php $ordem++ @endphp
                            <tr>
                                <th>{{$ordem}}</th>
                                <th>{{$policial->st_postograduacaosigla}}</th>
                                <th>{{$policial->st_numpraca}}</th>
                                <th>{{$policial->st_matricula}}</th>
                                <th>{{$policial->st_nome}}</th>
                                <th>
                              
                                @if($nota->st_status == 'RASCUNHO')
                                  <button type="button" onclick="populaModalConfRemoverPolicial({{$policial->id}})" data-toggle="modal" data-target="#modalRemoverPolicial" 
                                  title='Remover Policial' class="btn btn-danger fo fa fa-remove"></button>
                                @endif
                                </th>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

  <!-- Modal para adicionar policial a nota de boletim -->
  <div class="modal fade" id="modalPolicial" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmação de Policial</h4>
        </div>
        <div class="modal-body">
            <div id="nome"></div>
            <div id="matricula"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
          <button type="button" onclick="addPolicialParaNota()" class="btn btn-primary" data-dismiss="modal">Adicionar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para remover policial da nota de boletim-->
  <div class="modal fade" id="modalRemoverPolicial" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmação de Remover Policial</h4>
        </div>
        <div class="modal-body">
            <div id="nome">Deseja Realmente Remover o Policial?</div>
            <div id="nome"></div>
            <div id="matricula"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
          <a id="urlRemoverPolicialNota"  class="btn btn-primary" >Remover</a>
        </div>
      </div>
    </div>
  </div>

