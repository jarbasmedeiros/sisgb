@extends('adminlte::page')

@section('title', 'Plano de Férias')

@section('css')
<style>
    th, td {
        text-align: center;
    }
</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
            @if (isset($efetivo))
                <div class="panel-heading">  {{ count($efetivo) }} Policiais fora do Plano de Férias {{$ano}}</div>
            @else
                <div class="panel-heading"> Policiais fora do Plano de Férias {{$ano}}</div>
            @endif
                <br>
                @can('PLANO_FERIAS')
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th class="col-md-1">Ord</th>
                                <th class="col-md-1">Post/Grad</th>
                                <th class="col-md-4">Nome</th>
                                <th class="col-md-1">Matrícula</th>
                                <th class="col-md-5">Unidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($efetivo))
                                @forelse ($efetivo as $key => $e)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $e->st_postograduacaosigla }}</td>
                                        <td>{{ $e->st_nome }}</td>
                                        <td>{{ $e->st_matricula }}</td>
                                        <td>{{ $e->st_unidade }}</td>      
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"><strong> Nenhum Policial sem Plano de Férias foi encontrado. </strong></td>
                                    </tr>
                                @endforelse  
                            @endif
                        </tbody>
                    </table>
                @endcan
        </div>
        <a href="javascript:history.back()" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar">
            <i class="glyphicon glyphicon-arrow-left"></i> Voltar
        </a>
    </div>
</div>

@endsection