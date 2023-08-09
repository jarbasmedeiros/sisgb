@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Licenças')
@section('tabcontent')
    <div class="tab-pane active" id="cursos">
        <h4 class="tab-title">Licenças - {{ $policial->st_nome}}</h4>
        <hr class="separador">
    </div>
    <div class="container-fluid">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan="6">Licenças</th>
                        <th>
                            <button data-toggle="modal" data-target="#criaLicenca" title="Nova Licença" class="btn btn-primary">Nova Licença</button>
                        </th>
                    </tr>
                    <tr>
                        <th>Início</th>
                        <th>Fim</th>
                        <th>Dias</th>
                        <th>Tipo</th>
                        <th>Situação</th>
                        <th>Observações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($licenca))
                        @foreach($licenca as $li)
                            <tr>
                                <td>{{date('d/m/Y', strtotime($li->dt_inicio))}}</td>
                                <td>{{date('d/m/Y', strtotime($li->dt_termino))}}</td>
                                <td>{{$li->nu_dias}}</td>
                                <td>{{$li->tipo->st_tipo}}</td>
                                <td>Foram usufruídos {{(empty($li->nu_dias_gozadas)) ? '0' : $li->nu_dias_gozadas}} dias</td>
                                <td>{{$li->st_obs}}</td>
                                <td>
                                    <a href="{{url('rh/historicolicenca/lista/' . $policial->id . '/' . $li->id)}}" title="Exibir Histórico de Licença"><i class="btn btn-success fa fa-list"></i></a>
                                    @if(count($li->historicos) <= 1)
                                        <button data-toggle="modal" onclick="abreEdit({{$policial->id}}, {{$li->id}}, {{$li->tipo->id}}, {{json_encode($li->dt_inicio)}}, {{json_encode($li->dt_termino)}}, {{$li->nu_dias}}, {{json_encode($li->st_publicacao)}}, {{json_encode($li->dt_publicacao)}}, {{json_encode($li->st_obs)}})" title="Editar " class="btn btn-warning fa fa-edit"></button>
                                    @endif
                                    <a onclick="modalDesativa({{$li->id}})" data-toggle="modal" data-placement="top" title="Excluir Licença" class="btn btn-danger fa fa-trash"></a>                                </td>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="7">Não há licença cadastradas</th>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Cria Licença -->
    <div class="modal fade" id="criaLicenca" tabindex="-1" role="dialog" aria-labelledby="salvarpromocao" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">            
                <div class="modal-header">
                    <h4 class="modal-title">Criar licença</h4>
                </div>
                <div class="modal-body bg-primary">
                    <form role="form" id="form_licenca" method="POST" action="{{url('rh/policiais/cria/' . $policial->id . '/licenca')}}"> 
                        {{csrf_field()}}  
                        <h4>Data da Início</h4>
                        <input id="dt_inicio" type="date" required class="form-control" name="dt_inicio" > 
                        <h4>Dias</h4>
                        <input id="nu_dias" type="integer" required class="form-control" name="nu_dias" value="30">
                        <h4>Data de Término</h4>
                        <input id="dt_termino" type="date" required class="form-control" name="dt_termino" readonly>
                        <h4>Tipo</h4>
                        <select name="ce_tipo" id="ce_tipo" class="form-control" required>
                            <option value="" selected>Selecione</option>
                            @foreach($tiposLicenca as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->st_tipo}}</option>
                            @endforeach
                        </select>
                        <h4>Publicação</h4>
                        <input id="st_publicacao" type="text" class="form-control" name="st_publicacao" required>
                        <h4>Data da publicação</h4>
                        <input id="dt_publicacao" type="date" class="form-control" name="dt_publicacao" required>
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

    <!-- Modal Edita Licenca -->
    <div class="modal fade" id="editLicenca" tabindex="-1" role="dialog" aria-labelledby="editLicenca" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">            
                <div class="modal-header">
                    <h4 class="modal-title">Editar Licença</h4>
                </div>
                <div class="modal-body bg-primary">
                    <form role="form" id="form_edit_licenca" method="POST" action="{{url('rh/policiais/cria/' . $policial->id . '/licenca')}}"> 
                        {{csrf_field()}}  
                        <h4>Data da Início</h4>
                        <input id="dt_inicio" type="date" required class="form-control" name="dt_inicio" > 
                        <h4>Dias</h4>
                        <input id="nu_dias" type="integer" required class="form-control" name="nu_dias">
                        <h4>Data de Término</h4>
                        <input id="dt_termino" type="date" required class="form-control" name="dt_termino" readonly>
                        <h4>Tipo</h4>
                        <select name="ce_tipo" id="ce_tipo" class="form-control" required>
                            <option value="">Selecione</option>
                            @foreach($tiposLicenca as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->st_tipo}}</option>
                            @endforeach
                        </select>
                        <h4>Publicação</h4>
                        <input id="st_publicacao" type="text" class="form-control" name="st_publicacao" required>
                        <h4>Data da publicação</h4>
                        <input id="dt_publicacao" type="date" class="form-control" name="dt_publicacao" required>
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


          <!-- Moldal Excluir Dependente -->

           <div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Excluir Licença</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form-inline" id="modalDesativa" method="post">
                         {{csrf_field()}}
                            <div class="modal-body bg-danger">
                                <h4 class="modal-title" id="exampleModalLabel">
                                <b>Motivo da Exclusão:</b>
                               <input id="st_motivoexclusao"  type="text"  required class="form-control" name="st_motivoexclusao" style="width:80%; "> 
                                </h4>
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
                function modalDesativa(id){
                    $("#modalDesativa").attr("action", "{{ url('rh/policiais/exclui/' . $policial->id . '/licenca')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>

<!-- Moldal Excluir Dependente -->


@endsection
@section('scripts')
    <script>
        $('#criaLicenca #dt_inicio').change(function(){
            var dt_ini = $('#criaLicenca #dt_inicio').val();
            var dias = $('#criaLicenca #nu_dias').val();
            if(dt_ini != '' && dias != ''){
                $('#criaLicenca #dt_termino').val(calcData(dias, dt_ini));
            }
        });
        $('#criaLicenca #nu_dias').change(function(){
            var dt_ini = $('#criaLicenca #dt_inicio').val();
            var dias = $('#criaLicenca #nu_dias').val();
            if(dt_ini != '' && dias != ''){
                $('#criaLicenca #dt_termino').val(calcData(dias, dt_ini));
            }
        });
        $('#editLicenca #dt_inicio').change(function(){
            var dt_ini = $('#editLicenca #dt_inicio').val();
            var dias = $('#editLicenca #nu_dias').val();
            if(dt_ini != '' && dias != ''){
                $('#editLicenca #dt_termino').val(calcData(dias, dt_ini));
            }
        });
        $('#editLicenca #nu_dias').change(function(){
            var dt_ini = $('#editLicenca #dt_inicio').val();
            var dias = $('#editLicenca #nu_dias').val();
            if(dt_ini != '' && dias != ''){
                $('#editLicenca #dt_termino').val(calcData(dias, dt_ini));
            }
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
        function abreEdit(idPolicial, idLicenca, idTipo, dt_ini, dt_fim, nu_dias, st_publicacao, dt_publicacao, st_obs){
            $('#editLicenca #dt_inicio').val(dt_ini);
            $('#editLicenca #dt_termino').val(dt_fim);
            $('#editLicenca #nu_dias').val(nu_dias);
            $("#editLicenca #ce_tipo").val(idTipo);
            $('#editLicenca #st_publicacao').val(st_publicacao);
            $('#editLicenca #dt_publicacao').val(dt_publicacao);
            $('#editLicenca #st_obs').val(st_obs);
            $('#form_edit_licenca').attr('action', "{{url('rh/policiais/update/')}}" + '/' + idPolicial + '/' + idLicenca + '/licenca');
            $('#editLicenca').modal('show');
        }
    </script>
@endsection