@extends('boletim::boletim.template_boletim')

@section('title', 'Boletins em Elaboração')
@section('content_dinamic')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Formulário para consultar Boletins</div>
                <div class="panel-body">
                    <form class="form-contact" role="form" method="POST" action="{{url('/boletim/busca')}}">
                        {{csrf_field()}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Critérios de pesquisa</legend>
                            <div class="form-row">
                                <div class="form-group col-xs-3" style="margin-left:auto;">
                                    <label for="ce_tipo">Tipo de boletim</label>
                                    <select name="ce_tipo" id="ce_tipo" class="form-control select2" style="width: 100%;" required>
                                        @foreach($tiposBoletins as $tb)
                                            @if($tb->st_sigla == 'BR' || $tb->st_sigla == 'BER')
                                                @if ( auth()->user()->can('PUBLICACOES_RESERVADAS') || auth()->user()->can('PUBLICACOES_RESERVADAS_DA_OPM') )
                                                    <option value="{{$tb->id}}" {{($tb->id == $dadosForm['ce_tipo']) ? 'selected' : ''}}>{{$tb->st_tipo}}</option>
                                                @endif
                                            @else
                                                <option value="{{$tb->id}}" {{($tb->id == $dadosForm['ce_tipo']) ? 'selected' : ''}}>{{$tb->st_tipo}}</option>
                                            @endif
                                            
                                        @endforeach
                                    </select>
                                </div>
                               
                                <div name="unidadeBoletim" id="unidadeBoletim" class="form-group col-xs-2" style="margin-left:auto;" hidden>
                                    <label for="ce_unidade">Unidade</label>
                                    <select name="ce_unidade" id="ce_unidade" class="form-control select2" style="width: 100%;" required>
                                        @foreach($unidades as $u)
                                            @if(isset($dadosForm['ce_unidade']))  
                                                <option value="{{$u->id}}" {{($u->id == $dadosForm['ce_unidade']) ? 'selected' : ''}}>{{$u->st_sigla}}</option>
                                            @else
                                                <option value="{{$u->id}}">{{$u->st_sigla}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-xs-2" style="margin-left:auto;">
                                    <label for="st_filtro">Filtro</label>
                                    <select name="st_filtro" id="st_filtro" class="form-control select2" style="width: 100%;" required>
                                        <option value="mes_boletim">Mês</option>
                                        <option value="numero_boletim">Número</option>
                                        <option value="data_boletim">Data</option>
                                        <!-- <option value="assunto_boletim">Assunto</option> -->
                                    </select>
                                </div>
                                <div id="data" class="form-group col-xs-3" style="margin-left:auto;" hidden>
                                    <label for="inputData">Data</label>
                                    <input id="inputData" name="inputData" class="form-control" type="text" data-provide="datepicker" class="form-control date" value="{{isset($dadosForm['inputData']) ? $dadosForm['inputData'] : date('d/m/Y')}}" required/>
                                </div>
                                <div id="numero" class="form-group col-xs-2" style="margin-left:auto;" hidden>
                                    <label for="inputNumero">Número</label>
                                    <input type="number" name="inputNumero" class="form-control" id="inputNumero" value="{{isset($dadosForm['inputNumero']) ? $dadosForm['inputNumero'] : ''}}" required/>
                                </div>
                                <div id="assunto" class="form-group col-xs-2" style="margin-left:auto;" hidden>
                                    <label for="inputAssunto">Assunto</label>
                                    <input type="text" name="inputAssunto" class="form-control" id="inputAssunto" value="{{isset($dadosForm['inputAssunto']) ? $dadosForm['inputAssunto'] : ''}}" required/>
                                </div>
                                <div id="mes" class="form-group col-xs-2" style="margin-left:auto;">
                                    <label for="inputMes">Mês</label>
                                    <input id="inputMes" name="inputMes" type="text" data-provide="datepicker" class="form-control date"  value="{{isset($dadosForm['inputMes']) ? $dadosForm['inputMes'] : date('m')}}" required/>
                                </div>
                                <div id="ano" class="form-group col-xs-2" style="margin-left:auto;">
                                    <label for="inputAno">Ano</label>
                                    <input id="inputAno" name="inputAno" type="text" data-provide="datepicker" class="form-control date" value="{{isset($dadosForm['inputAno']) ? $dadosForm['inputAno'] : date('Y')}}" required/>   
                                </div>
                            </div>
                                <br>
                                <button type="submit" class="btn btn-primary" style="float:right; margin-bottom:10px;">Pesquisar</button>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Resultado da pesquisa</legend>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th>Tipo</th>
                                        <th>Boletim</th>
                                        <th>Data</th>
                                        <th class='col-1' >Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($boletins) && count($boletins)>0 && $boletins[0] != "vazio")
                                    @foreach($boletins as $b)
                                        @if($b->st_sigla == 'BR' || $b->st_sigla == 'BER')
                                            @can('PUBLICACOES_RESERVADAS')
                                                <tr>
                                                    <th>{{$b->st_sigla}}</th>
                                                    @if($b->ce_tipo == 7)
                                                            @if(!empty($b->pai))
                                                                <th>{{$b->st_sigla. ' Ao Boletim ' . str_pad($b->pai->nu_sequencial, 3 , '0' , STR_PAD_LEFT).'/'.$b->pai->nu_ano}}</th>
                                                            @else
                                                                <th></th>
                                                            @endif
                                                    @else
                                                        <th>{{str_pad($b->nu_sequencial, 3 , '0' , STR_PAD_LEFT).'/'.$b->nu_ano. ' de '. date('d/m/Y', strtotime($b->dt_boletim))}}</th>
                                                    @endif
        
                                                    <th>{{date('d/m/Y', strtotime($b->dt_boletim))}}</th>
                                                    <th >
                                                        <a href="{{url('boletim/visualizar/'.$b->id)}}" target="_blank" class='btn btn-primary fa fa fa-eye' title='Visualizar Pdf'></a>
                                                        @if($b->ce_tipo != 7)
                                                            @can('elabora_boletim')
                                                                <a href="{{url('boletim/'.$b->id.'/createaditamento')}}"  class='btn btn-primary fa fa fa-object-group' title='Cadastrar Aditamento'></a>
                                                            @endcan
                                                        @endif
                                                        <a href="{{url('boletim/'.$b->id.'/listanotas')}}" target="_blank"  class='btn btn-warning fa fa fa-eye' title='Visualizar Notas'></a>
                                                        @can('Administra')
                                                            @if($b->bo_integrado != 1)
                                                                <a onclick="modalcancelarPublicacao({{$b->id}})" data-toggle="tooltip" data-placement="top"  class='btn btn-danger fa fa-reply-all' title='Cancelar publicação'></a>
                                                            @endif
                                                        @endcan
                                                    </th>
                                                </tr>
                                            @endcan
                                            @can('PUBLICACOES_RESERVADAS_DA_OPM')
                                                @if ($b->ce_unidade == auth()->user()->ce_unidade)
                                                    <tr>
                                                        <th>{{$b->st_sigla}}</th>
                                                        @if($b->ce_tipo == 7)
                                                                @if(!empty($b->pai))
                                                                    <th>{{$b->st_sigla. ' Ao Boletim ' . str_pad($b->pai->nu_sequencial, 3 , '0' , STR_PAD_LEFT).'/'.$b->pai->nu_ano}}</th>
                                                                @else
                                                                    <th></th>
                                                                @endif
                                                        @else
                                                            <th>{{str_pad($b->nu_sequencial, 3 , '0' , STR_PAD_LEFT).'/'.$b->nu_ano. ' de '. date('d/m/Y', strtotime($b->dt_boletim))}}</th>
                                                        @endif
            
                                                        <th>{{date('d/m/Y', strtotime($b->dt_boletim))}}</th>
                                                        <th >
                                                            <a href="{{url('boletim/visualizar/'.$b->id)}}" target="_blank" class='btn btn-primary fa fa fa-eye' title='Visualizar Pdf'></a>
                                                            @if($b->ce_tipo != 7)
                                                                @can('elabora_boletim')
                                                                    <a href="{{url('boletim/'.$b->id.'/createaditamento')}}"  class='btn btn-primary fa fa fa-object-group' title='Cadastrar Aditamento'></a>
                                                                @endcan
                                                            @endif
                                                            <a href="{{url('boletim/'.$b->id.'/listanotas')}}" target="_blank"  class='btn btn-warning fa fa fa-eye' title='Visualizar Notas'></a>
                                                            @can('Administra')
                                                                @if($b->bo_integrado != 1)
                                                                    <a onclick="modalcancelarPublicacao({{$b->id}})" data-toggle="tooltip" data-placement="top"  class='btn btn-danger fa fa-reply-all' title='Cancelar publicação'></a>
                                                                @endif
                                                            @endcan
                                                        </th>
                                                    </tr>
                                                @endif
                                            @endcan
                                        @elseif($b->st_sigla == 'BG')
                                            <tr>
                                                <th>{{$b->st_sigla}}</th>
                                                @if($b->ce_tipo == 7)
                                                        @if(!empty($b->pai))
                                                            <th>{{$b->st_sigla. ' Ao Boletim ' . str_pad($b->pai->nu_sequencial, 3 , '0' , STR_PAD_LEFT).'/'.$b->pai->nu_ano}}</th>
                                                        @else
                                                            <th></th>
                                                        @endif
                                                @else
                                                    <th>{{str_pad($b->nu_sequencial, 3 , '0' , STR_PAD_LEFT).'/'.$b->nu_ano. ' de '. date('d/m/Y', strtotime($b->dt_boletim))}}</th>
                                                @endif

                                                <th>{{date('d/m/Y', strtotime($b->dt_boletim))}}</th>
                                                <th >
                                                    <a href="{{url('boletim/visualizar/'.$b->id)}}" target="_blank" class='btn btn-primary fa fa fa-eye' title='Visualizar Pdf'></a>
                                                    @if($b->ce_tipo != 7)
                                                        @can('elabora_bg')
                                                            <a href="{{url('boletim/'.$b->id.'/createaditamento')}}"  class='btn btn-primary fa fa fa-object-group' title='Cadastrar Aditamento'></a>
                                                        @endcan
                                                    @endif
                                                    <a href="{{url('boletim/'.$b->id.'/listanotas')}}" target="_blank"  class='btn btn-warning fa fa fa-eye' title='Visualizar Notas'></a>
                                                    @can('Administra')
                                                        @if($b->bo_integrado != 1)
                                                            <a onclick="modalcancelarPublicacao({{$b->id}})" data-toggle="tooltip" data-placement="top"  class='btn btn-danger fa fa-reply-all' title='Cancelar publicação'></a>
                                                        @endif
                                                    @endcan
                                                </th>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>{{$b->st_sigla}}</th>
                                                @if($b->ce_tipo == 7)
                                                        @if(!empty($b->pai))
                                                            <th>{{$b->st_sigla. ' Ao Boletim ' . str_pad($b->pai->nu_sequencial, 3 , '0' , STR_PAD_LEFT).'/'.$b->pai->nu_ano}}</th>
                                                        @else
                                                            <th></th>
                                                        @endif
                                                @else
                                                    <th>{{str_pad($b->nu_sequencial, 3 , '0' , STR_PAD_LEFT).'/'.$b->nu_ano. ' de '. date('d/m/Y', strtotime($b->dt_boletim))}}</th>
                                                @endif

                                                <th>{{date('d/m/Y', strtotime($b->dt_boletim))}}</th>
                                                <th >
                                                    <a href="{{url('boletim/visualizar/'.$b->id)}}" target="_blank" class='btn btn-primary fa fa fa-eye' title='Visualizar Pdf'></a>
                                                    @if($b->ce_tipo != 7 && $b->ce_unidade == auth()->user()->ce_unidade)
                                                        @can('elabora_boletim')
                                                            <a href="{{url('boletim/'.$b->id.'/createaditamento')}}"  class='btn btn-primary fa fa fa-object-group' title='Cadastrar Aditamento'></a>
                                                        @endcan
                                                    @endif
                                                    <a href="{{url('boletim/'.$b->id.'/listanotas')}}" target="_blank"  class='btn btn-warning fa fa fa-eye' title='Visualizar Notas'></a>
                                                    @can('Administra')
                                                        @if($b->bo_integrado != 1)
                                                            <a onclick="modalcancelarPublicacao({{$b->id}})" data-toggle="tooltip" data-placement="top"  class='btn btn-danger fa fa-reply-all' title='Cancelar publicação'></a>
                                                        @endif
                                                    @endcan
                                                </th>
                                            </tr>
                                        @endif
                                    @endforeach 
                                @else
                                    <tr>
                                        <th colspan='5'>Nenhum boletim encontrado</th>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            @if(isset($boletins) && count($boletins)>0 && $boletins[0] != "vazio")
                                {{$boletins->links()}}
                            @endif
                        </fieldset>
                    </form>

                    <!-- Modal para cancelar publicacao-->
                    <div class="modal fade-lg" id="cancelar_publicacao" tabindex="-1" role="dialog" aria-labelledby="cancelar_publicacao" aria-hidden="true">
                        <div class="modal-dialog  modal-lg" role="document">
                            <div class="modal-content">            
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Excluir Nota</h4>
                                </div>
                                <div class="modal-body bg-danger">
                                    <form class="form-horizontal" id="form_cancelar_publicacao" method="post" action=""> 
                                        <h4 class="modal-title">
                                            <strong>DESEJA REALMENTE CANCELAR A PUBLICAÇÃO?</strong>
                                            <div>
                                                <textarea style="border-radius: 5px;" name="st_motivocancelamento" class="form-control" placeholder="Informe aqui a justificativa para cancelar a publicação." id="st_obs" rows="3"></textarea>
                                            </div>
                                        <div class="modal-footer">
                                        
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                            <input type="hidden" id="idBoletim" name="idBoletim" value="">
                                            <input type="hidden" name="_token" value="{{Session::token()}}">
                                            <button type="submit" id="btnExcluir" class="btn btn-danger">Excluir</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        function modalcancelarPublicacao(id) {   
            $("#idBoletim").val(id);
            $idBoletim = $("#idBoletim").val();
            $('#cancelar_publicacao').modal();
            $('#form_cancelar_publicacao').attr('action', $idBoletim+'/cancelarpublicacao');
            //alert('sisgp/boletins/'+$idnota+'/cancelarpublicacao');
        };
    </script>
@stop

@section('css')
<style>
    .form-contact {
        width: 100%;
    }
</style>
@stop

