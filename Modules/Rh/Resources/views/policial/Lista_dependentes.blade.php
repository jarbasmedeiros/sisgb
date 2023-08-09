@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP -  Dependentes')
@section('tabcontent')

    <div class="tab-pane active" id="cursos">
        <h4 class="tab-title">Dependentes - {{ $policial->st_nome}}</h4>
        <hr class="separador">
    </div>
    <div class="container-fluid">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                
                    <tr class="bg-primary">
                        @can('Edita_rh')
                            <th colspan="5">Dependentes</th>
                            <th class="text-center">
                                <a class="btn btn-primary" href='{{url("rh/policiais/" . $policial->id ."/cadastra/dependentes")}}' title="Adicionar Dependente"> 
                                   &nbsp Adicionar Dependente
                                </a>
                            </th>
                        @endcan
                        @cannot('Edita_rh')
                            <th colspan="6">Dependentes</th>
                        @endcannot
                    </tr>
                   
                    <tr>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>CPF</th>
                        <th>Parentesco</th>
                        <th>Observação</th>
                        @can('Edita_rh')
                            <th class="text-center">Ações</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                 
                    @if (isset($dependentes) && count($dependentes) > 0)
                        @foreach($dependentes as $li)
                            <tr>
                                <td> {{ $li->st_nome }}</td>
                                <td>{{\Carbon\Carbon::parse($li->dt_nascimento)->format('d/m/Y')}}</td>
                                <td> {{ $li->st_cpf }}</td>
                                <td> {{ $li->st_parentesco}}</td>
                                <td> {{ $li->st_obs }}</td>
                                @can('Edita_rh')
                                    <td class="text-center">
                                        <a class="btn btn-warning fa fa-pencil" href='{{url("rh/policiais/edita/" . $policial->id ."/dependente/" .$li->id)}}' title="Editar"></a>
                                        |
                                        <a onclick="modalDesativa({{$li->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger fa fa-trash"></a>                                
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Não há dependentes cadastrados.</td>
                        </tr>
                    @endif
                    
                </tbody>
            </table>
        </div>
    </div>  
<!-- Modal Cria Licença -->
<div class="modal fade" id="adicionadependente" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="criaSessao">Adicionar Dependente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form"  > 
                {{csrf_field()}}
                <fieldset class="scheduler-border">    	
                    <legend class="scheduler-border">ADICIONAR DEPENDENTE</legend>
                    <div class="row">
                    <div class="form-group col-md-12">
                        <h4>Nome</h4>
                        <input id="st_nome"  type="text" required class="form-control" name="st_nome" > 
                        <h4>Data de Nascimento</h4>
                        <input id="dt_nascimento" type="date" required class="form-control" name="dt_nascimento" value="30">
                        <h4>CPF</h4>
                        <input id="st_cpf" type="text" required class="form-control" name="st_cpf" >
                        <h4>Grau de Dependência</h4>
                        <select name="st_dependencia" id="ce_tipo" class="form-control" required>
                            <option value="" selected>Selecione</option>
                            <option >Cônjuge</option>
                            <option >Filho(a)</option>
                            <option >Irmão(ã)</option>
                            <option >Pais</option>
                            <option >Avós</option>
                            <option >Bisavós</option>
                            <option >Neto</option>
                            <option >Bisneto(a)</option>

                        </select>
                        <h4>Observação</h4>
                        <input id="st_obs"  type="text" class="form-control" name="st_obs">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"  >Salvar</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
    <!-- Moldal Excluir Dependente -->

           <div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Excluir Dependente</h5>
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
                    $("#modalDesativa").attr("action", "{{ url('rh/policiais/exclui/' . $policial->id . '/dependentes')}}/"+id);
                    $('#Modal').modal();        
                };
            </script>

<!-- Moldal Excluir Dependente -->


            </div>
        </div>
    </div>
            </div>
            
        </div>
    </div>
    
@endsection
