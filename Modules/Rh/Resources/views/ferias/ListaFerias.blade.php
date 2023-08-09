@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP -  Férias')
@section('tabcontent')
    <div class="tab-pane active" id="cursos">
        <h4 class="tab-title">Férias - {{ $policial->st_nome}}</h4>
        <hr class="separador">
    </div>
    <div class="container-fluid">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan="7">Férias</th>
                        <th>
                            <button data-toggle="modal" data-target="#criaFerias" title="Novas Férias" class="btn btn-primary">Novas Férias</button>
                        </th>
                    </tr>
                    <tr>
                        <th>Ano referência</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th>Dias</th>
                        <th>Situação</th>
                        <th>Restam</th>
                        <th>Observações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($ferias))
                        @foreach($ferias as $fe)
                            <tr>
                                <td>{{$fe->st_anoreferencia}}</td>
                                <td>{{date('d/m/Y', strtotime($fe->dt_inicio))}}</td>
                                <td>{{date('d/m/Y', strtotime($fe->dt_termino))}}</td>
                                <td>{{$fe->nu_dias}}</td>
                                <td>Foram usufruídos {{$fe->nu_dias_gozadas}} dias</td>
                                @php
                                    $restam = $fe->nu_dias - $fe->nu_dias_gozadas;
                                @endphp
                                <td>{{$restam}} dias</td>
                                <td>{{$fe->st_obs}}</td>
                                
                                <td>
                                    @if(count($fe->historicos) <= 1)
                                        <button data-toggle="modal" onclick="abreEdit({{$policial->id}}, {{$fe->id}}, {{json_encode($fe->dt_inicio)}}, {{json_encode($fe->dt_termino)}}, {{$fe->nu_dias}}, {{$fe->st_anoreferencia}}, {{json_encode($fe->st_publicacao)}}, {{json_encode($fe->st_obs)}})" title="Editar"  class="btn btn-warning fa fa-pencil"></button>
                                    @endif
                                    <a href="{{url('rh/historicoferias/lista/' . $policial->id . '/' . $fe->id)}}" title="Histórico férias"><i class="btn btn-success fa fa-list"></i></a>
                                    <!-- <button data-toggle="modal" data-target="#historico_{{$fe->id}}" title="Histórico Férias" class="btn btn-success fa fa-list"></button> -->
                                    
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="7">Não há férias cadastradas</th>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Historico -->
    @foreach($ferias as $fe)
        <div class="modal fade" id="historico_{{$fe->id}}" tabindex="-1" role="dialog" aria-labelledby="historicoferias" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">            
                    <div class="modal-header">
                        <h4 class="modal-title">Histórico das Férias</h4>
                    </div>
                    <div class="modal-body">
                    <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Início</th>
                                    <th>Fim</th>
                                    <th>Dias</th>
                                    <th>Ano referência</th>
                                    <th>Descrição</th>
                                    <th>Tipo</th>
                                    <th>Início Gozo</th>
                                    <th>Fim Gozo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @if(!empty($fe->historicos))
                                        @foreach($fe->historicos as $hist)
                                            <tr>
                                                <th>{{ (!empty($hist->dt_inicio)) ? (date('d/m/Y', strtotime($hist->dt_inicio))) : ""}}</th>
                                                <th>{{ (!empty($hist->dt_fim)) ? (date('d/m/Y', strtotime($hist->dt_fim))) : ""}}</th>
                                                <th>{{$hist->nu_dias}}</th>
                                                <th>{{$hist->nu_ano}}</th>
                                                <th>{{$hist->st_descricao}}</th>
                                                <th>{{$hist->st_tipo}}</th>
                                                <th>{{ (!empty($hist->dt_inicio_gozo)) ? (date('d/m/Y', strtotime($hist->dt_inicio_gozo))) : ""}}</th>
                                                <th>{{ (!empty($hist->dt_final_gozo)) ? (date('d/m/Y', strtotime($hist->dt_final_gozo))) : ""}}</th>
                                                <th>{{$hist->st_status}}</th>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <th colspan="9">Não há histórico de férias cadastrado</th>
                                        </tr>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div> 
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Cria Férias -->
    <div class="modal fade" id="criaFerias" tabindex="-1" role="dialog" aria-labelledby="salvarpromocao" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">            
                <div class="modal-header">
                    <h4 class="modal-title">Criar férias</h4>
                </div>
                <div class="modal-body bg-primary">
                    <form role="form" id="form_ferias" method="POST" action="{{url('rh/policiais/cria/' . $policial->id . '/ferias')}}"> 
                        {{csrf_field()}}  
                        <h4>Data da Início</h4>
                        <input id="dt_inicio" type="date" required class="form-control" name="dt_inicio" > 
                        <h4>Data de Término</h4>
                        <input id="dt_termino" type="date" required class="form-control" name="dt_termino" readonly>
                        <h4>Dias</h4>
                        <input id="nu_dias" type="integer" required class="form-control" name="nu_dias" value="30" readonly>
                        <h4>Ano referência</h4>
                        <input id="st_anoreferencia" type="text" required class="form-control" name="st_anoreferencia" >
                        <h4>Publicação</h4>
                        <input id="st_publicacao" type="text" class="form-control" name="st_publicacao" >
                        <h4>Observações</h4>
                        <input id="st_obs" type="text" class="form-control" name="st_obs" >
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success salvar">Salvar</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>

    <!-- Modal Edita Férias -->
    <div class="modal fade" id="editFerias" tabindex="-1" role="dialog" aria-labelledby="editFerias" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">            
                <div class="modal-header">
                    <h4 class="modal-title">Editar férias</h4>
                </div>
                <div class="modal-body bg-primary">
                    <form role="form" id="form_edit_ferias" method="POST" action="{{url('rh/policiais/cria/' . $policial->id . '/ferias')}}"> 
                        {{csrf_field()}}  
                        <h4>Data da Início</h4>
                        <input id="dt_inicio" type="date" required class="form-control" name="dt_inicio" > 
                        <h4>Data de Término</h4>
                        <input id="dt_termino" type="date" required class="form-control" name="dt_termino" readonly>
                        <h4>Dias</h4>
                        <input id="nu_dias" type="integer" required class="form-control" name="nu_dias" readonly>
                        <h4>Ano referência</h4>
                        <input id="st_anoreferencia" type="text" required class="form-control" name="st_anoreferencia" >
                        <h4>Publicação</h4>
                        <input id="st_publicacao" type="text" class="form-control" name="st_publicacao" >
                        <h4>Observações</h4>
                        <input id="st_obs" type="text" class="form-control" name="st_obs" >
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success salvar">Salvar</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#criaFerias #dt_inicio').change(function(){
            var dt_ini = $('#criaFerias #dt_inicio').val();
            var dias = $('#criaFerias #nu_dias').val();
            $('#criaFerias #dt_termino').val(calcData(dias, dt_ini));
        });
        $('#editFerias #dt_inicio').change(function(){
            var dt_ini = $('#editFerias #dt_inicio').val();
            var dias = $('#editFerias #nu_dias').val();
            $('#editFerias #dt_termino').val(calcData(dias, dt_ini));
        });
        function calcData(dias, data){ //função para calcular datas no new e edit de quando muda a qtd de dias
            var from = data.split("-");
            var date = new Date(from[0], from[1] - 1, from[2]);
            date.setDate(date.getDate() + (parseInt(dias) - 1));
            var yyyy = date.getFullYear().toString();
            var mm = (date.getMonth()+1).toString();
            var dd  = date.getDate().toString();
            return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]);
        }
        function abreEdit(idPolicial, idFerias, dt_ini, dt_fim, nu_dias, st_anoreferencia, st_publicacao, st_obs){
            $('#editFerias #dt_inicio').val(dt_ini);
            $('#editFerias #dt_termino').val(dt_fim);
            $('#editFerias #nu_dias').val(nu_dias);
            $('#editFerias #st_anoreferencia').val(st_anoreferencia);
            $('#editFerias #st_publicacao').val(st_publicacao);
            $('#editFerias #st_obs').val(st_obs);
            $('#form_edit_ferias').attr('action', "{{url('rh/policiais/update/')}}" + '/' + idPolicial + '/' + idFerias + '/ferias');
            $('#editFerias').modal('show');
        }
    </script>
@endsection