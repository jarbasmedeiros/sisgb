@extends('boletim::boletim.template_boletim')

@section('title', 'Elabora Boletim')
@php
$contador = null;
$contadorParte1 = 1;
$contadorParte2 = 1;
$contadorParte3 = 1;
$contadorParte4 = 1;
@endphp

@section('content_dinamic')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
            @if($boletim->ce_tipo == 7)
                <div class="panel-heading col-md-10">Elaboração do {{$boletim->st_sigla}} ao {{$boletim->pai->st_sigla}} {{$boletim->pai->nu_sequencial}}/{{$boletim->pai->nu_ano}}</div>
            @else
                <div class="panel-heading col-md-10">Elaboração do Boletim {{$boletim->nu_sequencial.'/'.$boletim->nu_ano}}</div>

            @endif
                <div class="panel-heading col-md-2">SITUAÇÃO: {{$boletim->st_status}}</div>

                <div class="panel-body">
        
                    @if($boletim->st_status == 'ABERTO')
                        <a href='{{url("boletim/atribuirnotas/".$boletim->id)}}' class="btn btn-primary pull-right" style="margin-top:10px;">Selecionar Notas</a>
                        <a href='{{url("boletim/capa/edit/".$boletim->id."/".$boletim->ce_tipo)}}' class="btn btn-primary pull-right" style="margin-top:10px; margin-right: 1%;">Capa</a>
                    @endif

                    <div class="container col-md-12">
                        @if(isset($notas) && count($notas)>0)
                         
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">1ª Parte</legend>
                                @if(count($notas['parte1'])>0)
                                    @foreach($notas['parte1'] as $parte1)
                                    @if($contadorParte1 != $parte1->st_topico)
                                        <div class="control-group"><strong style='text-decoration: underline; margin-bottom: 20px'>{{$parte1->st_topico}}<br/></strong></div>
                                        @endif
              
                                    @php
                                        $contadorParte1 = $parte1->st_topico;
                                    @endphp  
                                        <div class="control-group">{!!$parte1->st_materia!!}</div>
                                        @if($boletim->st_status == 'ABERTO')
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select id="st_parte" onchange="mudaParteboletimNota(this.value, {{$parte1->id}}, {{$boletim->id}})" required name="st_parte" class="form-control select2">
                                                    <option value="{{$parte1->ce_topico}}">Mudar nota para outro tópico de boletim</option>
                                                        @foreach($topicos as $t)
                                                        <option value="{{$t->id}}">{{$t->st_topico}}</option>
                                                        @endforeach
                                                    </select>
                                                    <a href='{{url("boletim/removernota/".$parte1->id."/".$boletim->id)}}' class="btn btn-danger" style='margin-bottom: 30px'>Remover Nota</a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="control-group">SEM ALTERAÇÃO</div>
                                @endif
                            </fieldset>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">2ª Parte</legend>
                                @if(count($notas['parte2'])>0)
                                    @foreach($notas['parte2'] as $parte2)
                                    @if($contadorParte2 != $parte2->st_topico)
                                        <div class="control-group"><strong style='text-decoration: underline; margin-bottom: 20px'>{{$parte2->st_topico}}<br/></strong></div>
                                        @endif
              
                                    @php
                                        $contadorParte2 = $parte2->st_topico;
                                    @endphp  
                                        <div class="control-group">{!!$parte2->st_materia!!}</div>
                                        <p></p>
                                        @if($boletim->st_status == 'ABERTO')
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select id="st_parte" onchange="mudaParteboletimNota(this.value, {{$parte2->id}}, {{$boletim->id}})" required name="st_parte" class="form-control select2">
                                                        <option value="{{$parte2->ce_topico}}">Mudar nota para outro tópico de boletim</option>
                                                        @foreach($topicos as $t)
                                                        <option value="{{$t->id}}">{{$t->st_topico}}</option>
                                                        @endforeach
                                                    </select>
                                                    <a href='{{url("boletim/removernota/".$parte2->id."/".$boletim->id)}}' class="btn btn-danger" style='margin-bottom: 30px'>Remover Nota</a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="control-group">SEM ALTERAÇÃO</div>
                                @endif
                            </fieldset>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">3ª Parte</legend>
                                @if(count($notas['parte3'])>0)
                                    @foreach($notas['parte3'] as $parte3)
                                    @if($contadorParte3 != $parte3->st_topico)
                                        <div class="control-group"><strong style='text-decoration: underline; margin-bottom: 20px'>{{$parte3->st_topico}}<br/></strong></div>
                                        @endif
              
                                    @php
                                        $contadorParte3 = $parte3->st_topico;
                                    @endphp  
                                        <div class="control-group">{!!$parte3->st_materia!!}</div>
                                        @if($boletim->st_status == 'ABERTO')
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select id="st_parte" onchange='mudaParteboletimNota(this.value, {{$parte3->id}}, {{$boletim->id}})' required name="st_parte" class="form-control select2">
                                                        <option value="{{$parte3->ce_topico}}">Mudar nota para outro tópico de boletim</option>
                                                        @foreach($topicos as $t)
                                                        <option value="{{$t->id}}">{{$t->st_topico}}</option>
                                                        @endforeach
                                                    </select>
                                                    <a href='{{url("boletim/removernota/".$parte3->id."/".$boletim->id)}}' class="btn btn-danger" style='margin-bottom: 30px'>Remover Nota</a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="control-group">SEM ALTERAÇÃO</div>
                                @endif
                            </fieldset>

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">4ª Parte</legend>
                                @if(count($notas['parte4'])>0)
                                    @foreach($notas['parte4'] as $parte4)
                                    @if($contadorParte4 != $parte4->st_topico)
                                        <div class="control-group"><strong style='text-decoration: underline; margin-bottom: 20px'>{{$parte4->st_topico}}<br/></strong></div>
                                        @endif
              
                                    @php
                                        $contadorParte3 = $parte4->st_topico;
                                    @endphp 
                                        <div class="control-group">{!!$parte4->st_materia!!}</div>
                                        @if($boletim->st_status == 'ABERTO')
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select id="st_parte" onchange="mudaParteboletimNota(this.value, {{$parte4->id}}, {{$boletim->id}})" required name="st_parte" class="form-control select2">
                                                    <option value="{{$parte4->ce_topico}}">Mudar nota para outro tópico de boletim</option>
                                                        @foreach($topicos as $t)
                                                        <option value="{{$t->id}}">{{$t->st_topico}}</option>
                                                        @endforeach
                                                    </select>
                                                    <a href='{{url("boletim/removernota/".$parte4->id."/".$boletim->id)}}' class="btn btn-danger" style='margin-bottom: 30px'>Remover Nota</a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="control-group">SEM ALTERAÇÃO</div>
                                @endif
                            </fieldset>

                        @endif
                    </div>
                    <div class="form-group col-md-12" style="margin-bottom: 0px;">
                        <a href='{{ URL::previous()}}' class="col-md-1 btn btn-warning mr-05"  title="Voltar">
                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                        </a>
                        @if(count($notas['parte1']) > 0 || count($notas['parte2']) >0 || count($notas['parte3']) > 0 || count($notas['parte4']) > 0)
                            @if($boletim->st_status == 'ABERTO')
                                <button type="button" class="col-md-1 btn btn-primary mr-05" id="finalizarBtn" data-toggle="modal" data-target="#finalizarModal">
                                    Finalizar
                                </button>
                            @endif
                            <a href='{{ url("boletim/visualizar/" . $boletim->id)}}' target="_blank" class="col-md-1 btn btn-primary mr-05">
                                <span class="fa fa-file-pdf-o"></span> PDF
                            </a>
                        @endif
                        @if($boletim->st_status == 'FINALIZADO' || $boletim->st_status == 'ASSINADO')
                            <button type="button" class="col-md-1 btn btn-primary mr-05" data-toggle="modal" data-target="#corrigirModal">
                                Corrigir
                            </button>
                        @endif
                        @if($boletim->st_status == 'FINALIZADO')
                            @if($boletim->ce_tipo ==1)
                                @can('assina_bg')
                                    <button type="button" class="col-md-1 btn btn-primary mr-05" data-toggle="modal" data-target="#assinarModal">
                                        Assinar
                                    </button>
                                @endcan
                            @else 
                                @can('assina_boletim')
                                    <button type="button" class="col-md-1 btn btn-primary mr-05" data-toggle="modal" data-target="#assinarModal">
                                        Assinar
                                    </button>
                                @endcan
                            @endif
                        @endif
                        @if($boletim->st_status == 'ASSINADO')
                            @if($boletim->ce_tipo ==1)
                                @can('publica_bg')
                                <button type="button" class="col-md-1 btn btn-primary mr-05" data-toggle="modal" data-target="#confirmarPublicacaoModal">
                                    Publicar
                                </button>
                                @endcan
                            @else
                                @can('publica_boletim')
                                <button type="button" class="col-md-1 btn btn-primary mr-05" data-toggle="modal" data-target="#confirmarPublicacaoModal">
                                    Publicar
                                </button>
                                @endcan
                            @endif                            
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal finalizar boletim-->
    <div class="modal fade" id="finalizarModal" tabindex="-1" role="dialog" aria-labelledby="finalizarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="finalizarModalLabel">Finalizar Boletim</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body  alert-danger">
           <form id="form_finaliza_boletim" method="get">
           <strong>DESEJA FINALIZAR ESTE BOLETIM?</strong>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <a href='{{ url("boletim/finalizar/".$boletim->id)}}' type="submit" class="btn btn-primary">Finalizar</a>
        </div>
            </form>
        </div>
    </div>
    </div>
    <!-- Moldal Assinar boletim -->
    <div class="modal fade" id="assinarModal" tabindex="-1" role="dialog" aria-labelledby="assinarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="assinarModalLabel">Assinar Boletim</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
           <form action='{{ url("boletim/assinar/".$boletim->id)}}' method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <label for="pass" class="col-md-2 control-label">Senha</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="password" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Assinar</button>
        </div>
            </form>
        </div>
    </div>
    </div>
    
    <!-- Moldal devolver boletim para elaboração-->
    <div class="modal fade" id="corrigirModal" tabindex="-1" role="dialog" aria-labelledby="corrigirModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="corrigirModalLabel">Retornar Boletim para Elaboração</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body alert-danger">
           
           <div class="alert-danger">
              DESEJA REALMENTE RETORNAR O BOLETIM PARA ELABORAÇÃO?
           </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <a href='{{ url("boletim/retornarparaelaboracao/".$boletim->id)}}' class="btn btn-primary">Sim</a>
        </div>
        </div>
    </div>
    </div>

    <!-- Moldal confirmar publicação do boletim -->
    <div class="modal fade" id="confirmarPublicacaoModal" tabindex="-1" role="dialog" aria-labelledby="confirmarPublicacaorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="confirmarPublicacaoModalLabel">Confirmar Publicação do Boletim</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
           
            <div class="alert-danger">
               APÓS A PUBLICAÇÃO DO BOLETIM, NÃO SERÁ MAIS POSSÍVEL ALTERÁ-LO.
               TEM CERTEZA QUE DESEJA CONTINUAR?
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#publicarModal">Publicar</button>
        </div>
         
        </div>
    </div>
    </div>

    <!-- Moldal Publicar Boletim -->
    <div class="modal fade" id="publicarModal" tabindex="-1" role="dialog" aria-labelledby="publicarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"id="publicarModalLabel">Publicar Boletim</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="pass" class="col-md-2 control-label">Senha</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="publicarBoletim({{$boletim->id}})" class="btn btn-primary">Publicar</button>
            </div>
            </div>
        </div>
    </div>
    <div class="overlay" style="left: 0;right: 0;top: 0;bottom: 0;font-size: 30px;position: fixed;background: rgba(0,0,0,0.6);width: 100%;height: 100% !important;z-index: 1050; display:none;" >
        <i class="fa fa-refresh fa-spin fa-lg" id="spinner" style="top: 50%;left: 52%;position: absolute; color:white;"></i>
    </div>

@stop

<style>
    .mr-05{
        margin-right: 05px;
    }
</style>
