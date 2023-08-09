@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Movimentações')
@section('tabcontent')
<div class="tab-pane active" id="publicacoes">
    <h4 class="tab-title">Movimentações - {{ $policial->st_nome}}</h4>
    <hr class="separador">
    {{ csrf_field() }}
        <div class="row">
        <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="5">Movimentações</th>
                            <th>
                                @can('Edita_rh')
                                    <a class="btn btn-primary" data-toggle="modal" data-target="#ModalAdicionarMovimentacao" title="Cadastrar Movimentação"> Cadastrar Movimentação</a>
                                @endcan
                            </th>
                            <!--
                            <th>
                                
                                <div class="col-md-1">
                                    <form id="novaMovimentacao" class="form-horizontal" role="form" method="GET" action='{{url("rh/policiais/".$policial->id."/movimentacao/create")}}'>
                                        @can('Edita')
                                            <button type="submit" class="btn btn-primary btn-xs" title="Adicionar Nova Movimentação">Nova Movimentação</button>                                                                                        
                                        @endcan
                                    </form>
                                </div>
                            </th>
                            -->
                        </tr>
                        <tr>
                            <th class="col-md-2">DE</th>
                            <th class="col-md-2">PARA</th>
                            <th class="col-md-2">A CONTAR DE</th>
                            <th class="col-md-2">PUBLICAÇÃO</th>
                            <th class="col-md-2">DATA DA PUBLICAÇÃO</th>
                            @can('Edita')
                            <th class="col-md-2">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($movimentacoes))
                            @forelse($movimentacoes as $m)
                                <tr>
                                    <td>{{$m->st_unidadeorigem}}</td>
                                    <td>{{$m->st_unidadeDestindo}}</td>
                                    <td>{{\Carbon\Carbon::parse($m->dt_movimentacao)->format('d/m/Y')}}</td>
                                    <td>{{$m->st_publicacao}}</td>
                                    <td>{{\Carbon\Carbon::parse($m->dt_publicacao)->format('d/m/Y')}}</td>
                                    <td>
                                        @if(empty($m->ce_nota))
                                            @can('Edita')
                                            <a id="{{ $m->id }}" onclick="captura(this)" class="btn btn-warning fa fa fa-pencil-square" data-idmov="{{ $m->id }}" data-origem="{{ $m->ce_unidadeorigem }}" data-destino="{{ $m->ce_unidadedestino }}" data-movimentacao="{{ $m->dt_movimentacao }}" data-stpublicacao="{{ $m->st_publicacao }}" data-publicacao="{{ $m->dt_publicacao }}" data-toggle="modal" data-target="#ModalEditarMovimentacao" title="Editar Movimentação"></a> | 
                                            @endcan
                                            @can('Deleta')
                                            <a onclick="modalDesativa({{$m->id}}, {{$policial->id}})" data-toggle="modal" data-placement="top" title="Deletar Movimentação" class="btn btn-danger fa fa fa-trash"></a>
                                            @endcan
                                        @else 
                                        <a class="btn btn-success fa fa fa-file-pdf-o" href='{{url("boletim/nota/visualizar/".$m->ce_nota)}}'  target="_blank" title="Publicação"></a>
                                        @endif
                                    </td>
                                </tr>                               
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center;">Nenhuma Movimentação Encontrada.</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div> 
</div>

<!-- Modal Adicionar Movimentação -->
<div class="modal fade" id="ModalAdicionarMovimentacao"  role="dialog" aria-labelledby="salvarpromocao" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">            
                <div class="modal-header">
                    <h4 class="modal-title">Adicionar Movimentação
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>
                </div>
                <div class="modal-body bg-primary">
                    <form role="form" id="form_movimentacao" method="POST" action="/sisgp/rh/policiais/{{ $policial->id }}/movimentacao/cadastra"> 
                        {{ csrf_field() }}
                        <h4>De</h4>
                        <select class="form-control select2" style="width: 100%" name="ce_unidadeorigem" required>
                        <option value=""></option>
                        @foreach($unidades as $dados)    
                        <option value="{{ $dados->id }}">{{ $dados->st_nomepais }}</option>
                        @endforeach
                        </select>

                        <h4>Para</h4>
                        <select class="form-control select2" style="width: 100%" name="ce_unidadedestino" required>
                        <option value=""></option>
                        @foreach($unidades as $dados)    
                        <option value="{{ $dados->id }}">{{ $dados->st_nomepais }}</option>
                        @endforeach
                        </select>

                        <h4>A contar de</h4>
                        <input class='form-control' type="date" name="dt_movimentacao" required>

                        <h4>Boletim</h4>
                        <input class="form-control" type="text" name="st_publicacao" required>

                        <h4>Data da Publicação</h4>
                        <input class='form-control' type="date" name="dt_publicacao" required>
                        
                        <div class="modal-footer" style="text-align:center;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success salvar">Salvar</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>

<!-- Modal Editar Movimentação -->
<div class="modal fade" id="ModalEditarMovimentacao"  role="dialog" aria-labelledby="salvarpromocao" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">            
                <div class="modal-header">
                    <h4 class="modal-title">Editar Movimentação
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>
                </div>
                <div class="modal-body bg-primary">
                    <form role="form" name="formEditaMovimentacao" id="formEditaMovimentacao" method="POST" action=""> 
                        {{ csrf_field() }}
                        <h4>De</h4>
                        <select id="novo_unidadeorigem" class="form-control select2" style="width: 100%" name="ce_unidadeorigem" required>
                        <option value=""></option>
                        @foreach($unidades as $dados)    
                        <option value="{{ $dados->id }}">{{ $dados->st_nomepais }}</option>
                        @endforeach
                        </select>

                        <h4>Para</h4>
                        <select id="novo_unidadedestino" class="form-control select2" style="width: 100%" name="ce_unidadedestino" required>
                        <option value=""></option>
                        @foreach($unidades as $dados)    
                        <option value="{{ $dados->id }}">{{ $dados->st_nomepais }}</option>
                        @endforeach
                        </select>

                        <h4>A contar de</h4>
                        <input id="novo_movimentacao" class='form-control' type="date" name="dt_movimentacao" required>

                        <h4>Boletim</h4>
                        <input id="novo_stpublicacao" class="form-control" type="text" name="st_publicacao" required>

                        <h4>Data da Publicação</h4>
                        <input id="novo_publicacao" class='form-control' type="date" name="dt_publicacao" required>
                        
                        <div class="modal-footer" style="text-align:center;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success salvar">Salvar</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>

<!-- Modal Excluir movimentacao -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Movimentação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR A MOVIMENTAÇÃO?</b>
                </h4>
                <form class="form-inline" id="modalDesativa" method="get" > {{csrf_field()}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Excluir</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    var id_movimentacao;
    var ce_unidadeorigem;
    var ce_unidadedestino;
    var dt_movimentacao;
    var st_publicacao;
    var dt_publicacao;    

    function captura(componente){
        id_policial = "{{ $policial->id }}";
        id_movimentacao = componente.getAttribute("data-idmov");
        ce_unidadeorigem = componente.getAttribute("data-origem");
        ce_unidadedestino = componente.getAttribute("data-destino");
        dt_movimentacao = componente.getAttribute("data-movimentacao");
        st_publicacao = componente.getAttribute("data-stpublicacao");
        dt_publicacao = componente.getAttribute("data-publicacao");
        
        $('#novo_unidadeorigem').val(ce_unidadeorigem);
        $('#novo_unidadeorigem').select2().trigger('change');
        $('#novo_unidadedestino').val(ce_unidadedestino);
        $('#novo_unidadedestino').select2().trigger('change');
        $('#novo_movimentacao').val(dt_movimentacao);
        $('#novo_stpublicacao').val(st_publicacao);
        $('#novo_publicacao').val(dt_publicacao);

        document.formEditaMovimentacao.action = "/sisgp/rh/policiais/"+id_policial+"/movimentacao/"+id_movimentacao+"/edita";
    }

    function modalDesativa(idMovimentacao, idpolicial){
        var url = idpolicial+'/movimentacao/'+idMovimentacao+'/deleta';                      
        $("#modalDesativa").attr("action", "{{ url('rh/policiais/')}}/"+url);
        $('#Modal').modal();        
    };
</script>




@endsection