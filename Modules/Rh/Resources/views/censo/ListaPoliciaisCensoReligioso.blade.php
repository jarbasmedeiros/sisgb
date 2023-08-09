@extends('adminlte::page')

@section('title', 'Lista de Policiais')

@section('css')
<style>
     #ficha, #cr {
        margin-top: 2px;
    }
    th, td {
        text-align: center;
    }
</style>
@endsection


@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-primary">
        <div class="panel-body">
        <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                    @php    
                        $contador = 0;

                        if(isset($contador_inicial)){
                            $contador = $contador + $contador_inicial;
                        }
                    
                    @endphp 
                        <tr class="bg-primary">
                            <th colspan = "11"> {{$titulo}} </th>                                                   
                        </tr>
                        <tr>
                            <th class="col-md-1">ORDEM</th>
                            <th class="col-md-1">POSTO / GRADUAÇÃO</th>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-1">MATRÍCULA</th>
                            @if ($realizaram == 'sim')
                                <th class="col-md-3">UNIDADE</th>
                                <th class="col-md-3">RELIGIÃO</th>
                            @else
                                <th class="col-md-6">UNIDADE</th>
                            @endif
                            
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($policiais))
                            @forelse($policiais as $p)
                            @php 
                                $contador ++;
                            @endphp 
                                <tr>
                                    <td>{{$contador}}</td>
                                    <td>{{$p->st_postograduacaosigla}}</td>
                                    <td>{{$p->st_nome}}</td>
                                    <td>{{$p->st_matricula}}</td>
                                    <td>{{$p->st_unidade}}</td>
                                    @if ($realizaram == 'sim')
                                        <td>{{$p->st_denominacaoreligiosa}}</td>
                                    @endif
                                    
                                </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">Nenhum policial encontrado.</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
                @if(isset($policiais) && count($policiais) > 0 && (!is_array($policiais)))
                    {{$policiais->links()}}
                @endif
        </div>
        </div>
        </div>

        <a href="javascript:history.back()" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar">
            <i class="glyphicon glyphicon-arrow-left"></i> Voltar
        </a>

    </div>
</div>

    
@stop






