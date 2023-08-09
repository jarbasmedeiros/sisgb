@extends('boletim::boletim.template_boletim')

@section('title', 'Boletins em Elaboração')

@section('content_dinamic')    
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Lista de Boletins em elaboração</div>
                <div class="panel-body">     

                <!-- caso não tenha ou só tenha 1 vinculo oculta o combo -->
                    @if(isset($vinculos) && !empty($vinculos))                        
                        <div class="form-group{{ $errors->has('ce_unidadevinculadaselecionada') ? ' has-error' : '' }} col-md-6">
                        <!--Select com a listagem das unidades-->
                        <label for="ce_unidadevinculadaselecionada" class="control-label">Unidades vinculadas</label>                        
                            <select id="ce_unidadevinculadaselecionada" name="ce_unidadevinculadaselecionada" class="form-control"  onchange="exibirBoletinsUnidadeSelecionada(this)">                    
                                @foreach($vinculos as $vinculo)
                                        @if(isset($idUnidade) && $idUnidade==$vinculo['id'] )
                                            <option value="{{$vinculo['id']}}" selected>{{$vinculo['st_nomepais']}}</option>
                                        @else
                                            <option value="{{$vinculo['id']}}" >{{$vinculo['st_nomepais']}}</option>
                                        @endif
                                @endforeach                       
                            </select>                          
                        </div>                                        
                    @endif
                
                
                    <a href='{{url("boletim/create")}}' class="btn btn-primary" style="float:right; margin-bottom:10px;"> <i class="fa fa-plus"></i> Novo Boletim</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th>Tipo</th>
                                <th>Boletim</th>
                              
                                <th>Status</th>
                                <th class='col-1' >Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @if(isset($boletins) && count($boletins)>0)
                            @foreach($boletins as $b)
                                @if($b->ce_unidade == $idUnidade)
                                    <tr>
                                        <th style='font-weight:normal!important;'>{{$b->st_sigla}}</th>
                                        @if($b->ce_tipo == 7)
                                            @if(!empty($b->pai))
                                                <th>{{$b->st_sigla. ' Ao Boletim ' . str_pad($b->pai->nu_sequencial, 3 , '0' , STR_PAD_LEFT).'/'.$b->pai->nu_ano}}</th>
                                            @else
                                            <th>{{$b->st_sigla. ' Ao Boletim (Não encontrado o boletim pai) '}}</th>
                                            @endif
                                        @else
                                        <th style='font-weight:normal!important;'>{{str_pad($b->nu_sequencial, 3 , '0' , STR_PAD_LEFT).'/'.$b->nu_ano. ' de '. date('d/m/Y', strtotime($b->dt_boletim))}}</th>
                                        @endif
                                        <th style='font-weight:normal!important;'>{{$b->st_status}}</th>
                                        <th style='font-weight:normal!important;'>
                                        <a href="{{url('boletim/edit/'.$b->id)}}"  class='btn btn-primary fa fa fa-eye' title='Abrir'></a>
                                        @if($b->ce_tipo != 7)
                                        <a href="{{url('boletim/'.$b->id.'/createaditamento')}}"  class='btn btn-primary fa fa fa-object-group' title='Cadastrar Aditamento'></a>
                                    @endif
                                        @if(($b->bo_notaatribuida == 0) && ($b->st_status != "PUBLICADO"))
                                            | <button onclick="modalExcluiBoletim({{$b->id}})" data-toggle="tooltip" data-placement="top" title='Excluir Boletim' class="btn btn-danger fo fa fa-trash"></button> 
                                        @endif
                                        </th>
                                    </tr>
                                @endif
                            @endforeach 
                            @else
                                <tr>
                                    <th colspan='5'>Não há boletim em elaboração</th>
                                </tr>

                            @endif                            
                        </tbody>
                    </table>
                    <a href='{{url('boletim/lista_boletim_pendente')}}' class="btn btn-warning" style="float:left; margin-bottom:10px;"><i class="glyphicon glyphicon-arrow-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>

                    
 
   
<div class="modal fade-lg" id="exclui_boletim" tabindex="-1" role="dialog" aria-labelledby="exclui_boletim" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Excluir Boletim</h4>
            </div>
            <div class="modal-body bg-danger">
            <form class="form-horizontal" id="form_exclui_boletim" method="get"> 
                <h4 class="modal-title">
                        <strong>DESEJA REALMENTE EXCLUIR O BOLETIM?</strong>
                </h4>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                    <a id="" type="submit" class="btn btn-danger excluirboletim">Excluir</a>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

    <!-- Script consultar os boletins da unidade vinculada que foi selecionada-->
    <script>
        function exibirBoletinsUnidadeSelecionada(combo){ 
            //recupera o valor do option selecionado     
            var idUnidade = $(combo).val();
            //recarrega a página com a unidade selecionada
            window.location.href="{{url('boletim/lista_boletim_pendente')}}"+'/'+idUnidade;
        }
    </script>
@stop
