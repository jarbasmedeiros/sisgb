@extends('boletim::boletim.template_boletim')

@section('title', 'Procedimentos')
@section('content_dinamic')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Formulário para Consultar Procedimentos</div>
                <div class="panel-body">
                    <form class="form-contact" role="form" method="POST" action="{{url('/djd/buscarprocedimentos')}}">
                        {{csrf_field()}}
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Critérios de pesquisa</legend>
                            <div class="form-row">
                                <div class="form-group col-xs-3" style="margin-left:auto;">
                                    <label for="st_criterio">Critério</label>
                                    <select name="st_criterio" id="st_criterio" class="form-control select" style="width: 100%;" required> 
                                        <option value="st_numsei">N° SEI</option>
                                        <option value="st_numprocedimento">N° Procedimento</option>
                                        <option value="st_fato">Fato</option>
                                        <option value="st_encarregado">Encarregado (Matrícula/Nome)</option>
                                        <option value="st_envolvido">Indiciado (Matrícula/CPF)</option>
                                    </select>
                                </div>

                                <div id="ano" class="form-group col-xs-2" style="margin-left:auto;">
                                    <label for="st_filtro">Filtro</label>
                                    <input id="st_filtro" name="st_filtro" type="text"  class="form-control" value="" required/> 
                                      
                                </div>
                                <div class="form-group col-xs-2" style="margin:25px 0px;">
                                    <button type="submit" class="btn btn-primary" ><span class="fa fa-fw fa-search"></span>  Pesquisar</button>
                                </div>
                            </div>
                                <br>
                                
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Resultado da pesquisa</legend>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th>Cadastro</th>
                                        <th>Status</th>
                                        <th>Tipo</th>
                                        <th>Início</th>
                                        <th>Prazo</th>
                                        <th>N° SEI</th>
                                        <th>Origem</th>
                                        <th>Encarregado</th>
                                        <th>Unidade</th>
                                        <th>Solução</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($procedimentos) && count($procedimentos)>0)
                                    @foreach($procedimentos as $p)
                                        <tr class="text-center">
                                            <td>{{date('d/m/Y', strtotime($p->dt_cadastro))}}</td>
                                            <td>{{$p->st_status}}</td>
                                            <td>{{$p->st_tipo}}</td>
                                            <td>{{date('d/m/Y', strtotime($p->dt_prazoinicial))}}</td>
                                            <td>{{date('d/m/Y', strtotime($p->dt_encerramento))}}</td>
                                            <td>{{$p->st_numsei}}</td>
                                            <td>{{$p->st_origem}}</td>
                                            <td>
                                                {{$p->st_postgradencarregado}} -
                                                {{$p->st_nomeencarregado}}                                                                                              
                                            </td>
                                            <td>{{$p->unidade->st_sigla}}</td>
                                            <td>{{$p->st_solucao}}</td>
                                            <td class="text-left">
                                                <a href="{{url('djd/procedimentos/'.$p->id.'/extrato')}}" target="_blank" class="btn btn-primary" title="Visualizar"><span class="fa fa fa-eye"></span></a>
                                                {{-- <a class="btn btn-success" title="Histórico"><span class="fa fa-list"></span></a> --}}
                                                
                                                
                                                @if($p->dt_registro == null)
                                                    <a class="btn btn-warning" onclick="modalConfirmar({{$p->id}})" title="Registrar"><span class="fa fa-check"></span></a>                                               
                                                @endif
                                            </td>                                            
                                        </tr>
                                    @endforeach 
                                @else
                                    <tr>
                                        <th colspan='11' class="text-center" style="font-weight: normal;">{{$msgResultado}}</th>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                        </fieldset>
                    </form>
                </div>
            </div>        
        </div>
    </div>

        {{-- Modal para confirmar registro --}}
    <div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmar registro
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>                    
                    </h5>

                </div>
                <div class="modal-body bg-danger">
    
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE CONFIRMAR O REGISTRO?</b>
                    </h4>
                    <form class="form-inline" id="modalConfirmar" method="post" > {{csrf_field()}}
    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function modalConfirmar(id){
            $("#modalConfirmar").attr("action","{{url('djd/procedimentos/registrar')}}/"+id);
            $('#Modal').modal();
        };
    </script>




@stop



