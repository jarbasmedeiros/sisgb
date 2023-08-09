@extends('adminlte::page')
@section('title', 'Plano de Férias Turmas')
@section('content')
<style>
<style>
.nav-tabs-custom > .nav.nav-tabs > li.active {
    border-top-color: rgb(44, 103, 137);
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Turmas do Plano de Férias de {{$ano}}</div>
                    </br>
                    @can('PLANO_FERIAS')
                        <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Informações</legend>
                        Total efetivo: <b> {{$contagemEfetivo->nu_totalefetivo}} </b> ; No plano: <b>  {{$contagemEfetivo->nu_totalnoplano}}</b> ; 
                        Faltam: <a href="{{ route('efetivo_sem_plano_ferias', $ano) }}"><b>{{$contagemEfetivo->nu_totalrestante}}</b></a>
                        <br>
                        @if($planoFerias->st_status == 'ABERTO')
                        <a class="btn btn-warning" href="{{url('/rh/planoferias/'.$ano.'/distibuirefetivo')}}" >
                                <i class="fa fa-list"></i> Distribuir Efetivo
                        </a>
                        @endif

                        @if($planoFerias->st_status == 'ABERTO')
                        <!-- <a class="btn btn-danger" href="{{url('/rh/planoferias/'.$ano.'/finalizar')}}" >
                                <i class="fa fa-unlock-alt"></i> Finalizar plano de férias
                        </a>
    -->                         @if(!empty($planoFerias->st_portaria) && $contagemEfetivo->nu_totalnoplano >0)
                                    <button onclick="finalizarPlanoFerias({{$ano}})" data-toggle="tooltip" data-placement="top" 
                                    title='Finalizar plano férias' class="btn btn-danger unlock-alt"> <i class="fa fa-unlock-alt"></i>Finalizar plano férias</button> 
                                @endif
                        @endif
                        <form role="form" method="post" action="{{ url('rh/planoferias/'.$ano.'/turma/'.$st_turma.'/portaria') }}">
                        @if($planoFerias->st_status == 'ABERTO')
                            <textarea type="textarea" class="ckeditor form-control" rows="10" id="st_portaria" name="st_portaria" placeholder="Digite as informações da portaria..." required>{{$planoFerias->st_portaria}}</textarea>
                        @else
                        {!!$planoFerias->st_portaria!!}
                        @endif
                            {{csrf_field()}}
                            <div class="form-group col-md-1">
                            @if($planoFerias->st_status == 'ABERTO')
                                <button type="submit" class="btn btn-primary" id="btnSalvarPortaria"><i class="fa fa fa-save"></i> Salvar Portaria</button>   
                                @endif
                            </div>                                      
                        </form>  
                    </fieldset>
                        @endcan       
                <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Pesquisa de turma de férias</legend>
                        <form role="form" method="GET" action="{{ url('rh/planoferias/'.$ano.'/turma/'.$st_turma.'/pesquisar') }}">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="st_matricula">Policial</label>                      
                                    <input id="st_matricula" type="text" class="form-control" placeholder="Matrícula" name="st_matricula"  required> 
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="btnPesquisarMatricula"></label>
                                    <button type="submit" class="btn btn-primary" id="btnPesquisarMatricula"><i class="fa fa fa-search"></i> Pesquisar</button>   
                                </div>
                            </div>
                    </form>
                </fieldset>
                <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Efetivo por turma</legend>
                        </br>
                                {{csrf_field()}}
                                <div class="nav-tabs-custom">
                                
                                    @if(Request::segment(6)) 
                                        @php 
                                            if(count($efetivo)>0){
                                                $turmaPolicial =  $efetivo[0]->st_turma;
                                            }else{
                                                $turmaPolicial = 1;
                                            }
                                        @endphp
                                    @else
                                        @php 
                                            $turmaPolicial = Request::segment(5);
                                        @endphp
                                    @endif
                                    @can('PLANO_FERIAS')
                                        <ul class="nav nav-tabs">
                                            <li class="{{ ($turmaPolicial=='1')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '1') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/1')}}" ><b>1ª Turma</b></a>
                                            </li>
                                            <li class="{{ ($turmaPolicial=='2')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '2') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/2')}}" ><b>2ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='3')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '3') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/3')}}" ><b>3ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='4')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '4') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/4')}}" ><b>4ª Turma</b></a>
                                                    </li>        
                                            <li class="{{ ($turmaPolicial=='5')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '5') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/5')}}" ><b>5ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='6')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '6') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/6')}}" ><b>6ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='7')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '7') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/7')}}" ><b>7ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='8')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '8') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/8')}}" ><b>8ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='9')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '9') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/9')}}" ><b>9ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='10')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '10') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/10')}}" ><b>10ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='11')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '11') ? 'active' : '' }}" href="{{url('/rh/planoferias/'.$ano.'/turma/11')}}" ><b>11ª Turma</b></a>
                                            </li>
                                                     
                                        </ul>
                                    @else 
                                    <ul class="nav nav-tabs">
                                            <li class="{{ ($turmaPolicial=='1')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '1') ? 'active' : '' }}" href="#" ><b>1ª Turma</b></a>
                                            </li>
                                            <li class="{{ ($turmaPolicial=='2')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '2') ? 'active' : '' }}" href="#" ><b>2ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='3')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '3') ? 'active' : '' }}" href="#" ><b>3ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='4')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '4') ? 'active' : '' }}" href="#" ><b>4ª Turma</b></a>
                                                    </li>        
                                            <li class="{{ ($turmaPolicial=='5')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '5') ? 'active' : '' }}" href="#" ><b>5ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='6')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '6') ? 'active' : '' }}" href="#" ><b>6ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='7')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '7') ? 'active' : '' }}" href="#" ><b>7ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='8')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '8') ? 'active' : '' }}" href="#" ><b>8ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='9')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '9') ? 'active' : '' }}" href="#" ><b>9ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='10')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '10') ? 'active' : '' }}" href="#" ><b>10ª Turma</b></a>
                                                    </li>
                                            <li class="{{ ($turmaPolicial=='11')?'active':'' }}">
                                                <a class=" {{ ($turmaPolicial == '11') ? 'active' : '' }}" href="#" ><b>11ª Turma</b></a>
                                            </li>
                                                               
                                        </ul>
                                    @endcan
                                            <div class="tab-content">
                                                @yield('tabcontent')
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr class="bg-primary">
                                                                <th>Ord</th>
                                                                <th>Post / Grad</th>
                                                                <th>Nome</th>
                                                                <th>Matrícula</th>
                                                                <th>CPF</th>
                                                                <th>Unidade</th>
                                                                @if($planoFerias->st_status == 'ABERTO')
                                                                    <th>Ação</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($efetivo as $key => $e)
                                                                <tr>
                                                                    <td>{{$key+1}}</td>
                                                                    <td>{{$e->st_postograduacao}}</td>
                                                                    <td>{{$e->st_nome}}</td>
                                                                    <td>{{$e->st_matricula}}</td>
                                                                    <td>{{ $e->st_cpf }}</td>
                                                                    <td>{{ $e->st_unidade }}</td>
                                                                    @if($planoFerias->st_status == 'ABERTO')
                                                                    <td>
                                                                        @can('PLANO_FERIAS')
                                                                        <a class="btn btn-success my-2 my-sm-0" href="{{url('/rh/planoferias/'.$ano.'/trocarturma/'.$e->ce_policial)}}" style='margin-right: 10px;'>Mudar Turma</a></div>
                                                                        @endcan
                                                                    </td>
                                                                    @endif        
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                            </div>
                                             <!-- Paginação -->
                               
                                @if(isset($efetivo) && count($efetivo)>0)
                                    <div class="pagination pagination-centered">
                                    @if(isset($dadosForm))
                                         {{$efetivo->appends($dadosForm)->links()}}
                                    @else
                                        {{$efetivo->links()}}
                                    @endif
                                   
                                    </div>
                                @endif
                              
                            <!-- end Paginação -->
                                        
                                    </div>
                    </fieldset>                                           
                    <a class="btn btn-warning" href="{{url('/rh/planoferias')}}" style='margin-right: 10px;'>
                                    <i class="fa fa-arrow-left"></i> Voltar
                                </a>
            </div>
        </div>
       
    </div>
</div>


@endsection


<!---modal finalizar plano de férias --->
<div class="modal fade" id="modalFinalizarPlanoFerias" tabindex="-1" role="dialog" aria-labelledby="modalFinalizarPlanoFerias" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFinalizarPlanoFerias">Confirmar finalização do plano de férias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body alert-danger">
                    <h5>DESEJA REALMENTE FINALIZAR PLANO DE FÉRIAS?</h5>
                </div>
                <form id="form_finalizar_plano_ferias" method="POST" >
                    {{ csrf_field() }}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                        <button type="submit" class="btn btn-primary" >Finalizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 <!--- end modal finalizar plano de férias  --->


@section('css')
<style>
    th {text-align:center;}
    a, button{margin:5px;}
</style>
@endsection
@section('js')
<!-- Javascript abaixo -->
<!-- Script finalizar plano de férias-->
    <script>
        function finalizarPlanoFerias(ano){ 
            $('#modalFinalizarPlanoFerias').modal({
                show: 'true'
            }); 
            $("#form_finalizar_plano_ferias").attr("action",  "{{ url('rh/planoferias/')}}/" + ano + "/finalizar"); 
        }
 </script>
  <!-- end script finalizar plano de férias-->
    
@stop