@extends('adminlte::page')

@section('title', 'Lista de policiais')
@can('Edita')
@section('content_header')
    <form action="{{ url('dps/relatorios/filtro') }}" method="POST" >
        {{ csrf_field() }}
        <input type="hidden" name="excel" value="true" />
        <input type="hidden" name="dados_form" value="{{$response}}"/>
        <button class="btn btn-primary" type="submit"><i class="fa fa-file-excel-o"></i> Baixar Excel</button>
    </form>
@stop
@endcan

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                        @php  $contador = 0;@endphp
                            <th colspan="{{count($nome_colunas)+1}}">{{$nome_tabela}}</th>
                        </tr>
                        <tr>@php $contador = 0;@endphp
                            <th>Ord</th>
                            @if(isset($nome_colunas))
                                @foreach($nome_colunas as $c)
                                    <th>{{$colunas->$c}}</th>
                                @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($funcionarios))
                            @forelse($funcionarios as $f)
                            <tr>
                           
                                    @php $contador++ @endphp
                                <td>{{$contador}}</td>
                                @foreach($f as $key =>  $c)
                                    @if(substr($key, 0, 2) == 'dt' && $c != null)
                                        <td>{{ \Carbon\Carbon::parse($c)->format('d/m/Y') }}</td>
                                    @else
                                        <td>{{$c}}</td>
                                    @endif
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{count($nome_colunas)}}" style="text-align: center;">Nenhum policial encontrado</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
@stop