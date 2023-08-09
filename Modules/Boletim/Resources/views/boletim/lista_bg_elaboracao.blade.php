@extends('boletim::boletim.template_boletim')

@section('title', 'BG em Elaboração')

@section('content_dinamic')    
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">{{count($boletins)}} - Boletins Gerais (BG) em elaboração/assinar/publicar</div>
                <div class="panel-body">     

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
                                        </th>
                                    </tr>
                            @endforeach 
                            @else
                                <tr>
                                    <th colspan='5'>Não há boletim</th>
                                </tr>

                            @endif                            
                        </tbody>
                    </table>
                  
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

  
@stop
