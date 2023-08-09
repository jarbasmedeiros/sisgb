@extends('adminlte::page')

@section('title', 'Agendamentos')

@section('content')
    <div class="container-fluid">
        <div class="row align-item-start">
            <div class="panel panel-primary">
                <div class="panel-heading">Lista de integrações agendadas</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Data</th>
                                    <th>Boletim</th>
                                    <th>Status</th>
                                    <th>Observação</th>
                                    @can('Admin')
                                     <th class='col-md-1'>Ações</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($integracoes) && count($integracoes)>0)
                                    @foreach($integracoes as $integracao)
                                        <tr>
                                            <th>{{date('d/m/Y', strtotime($integracao->dt_cadastro))}}</th>
                                            <th>{{$integracao->st_boletim}}</th>
                                            <th>{{$integracao->st_status}}</th>
                                            <th style="text-align:justify;">{{$integracao->st_obs}}</th>
                                            @can('Admin')
                                            <th>
                                                <a href="{{url('boletim/integrador/integrarboletim/'.$integracao->id)}}"  class='btn btn-info' title='Integrar'>Integrar</a>
                                                {{--<a href="{{url('boletim/integrador/integrarboletim/'.$integracao->id.'/checagem')}}"  class='btn btn-warning' title='Checar'>Checar</a>
                                                --}}
                                            </th>
                                            @endcan
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <th colspan="4">Não há integrações agendadas.</th>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                                    
                    </div>
                    @if(isset($integracoes) && count($integracoes)>0)
                        <div class="pagination pagination-centered">
                            <tr>
                            <th>
                                {{$integracoes->links()}}
                            </th>
                            </tr>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
@stop
