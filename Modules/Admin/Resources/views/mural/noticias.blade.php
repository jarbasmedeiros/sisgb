@extends('adminlte::page')

@section('title', 'home')
@can('Administrador')
    @section('content_header')
    @stop
@endcan

@section('content')    
    <div class="panel panel-primary">
        <div class="panel-heading">Listagem do Mural</div>
        <div class="panel-body">
            <div class='col-12'>
            <!-- listagem  Unidade-->
                <div class="col-md-12">
                    <a href='{{url("/admin/noticia/criar")}}' class="btn btn-primary" style="float:right; margin-bottom:10px;">Nova Notícia</a>
                    <table class="table table-bordered">
                        <thead >
                            <tr class="bg-primary">
                                @if(isset($mural) && count($mural)>0)
                                    <th colspan="6"> Listagem com {{$mural->total()}} Notícias cadastrada(s)</th>
                                @else 
                                    <th colspan="6"> Listagem com 0 Notícias cadastrada</th>
                                @endif 
                            </tr>
                            <tr>
                                <th class="col-md-3">TÍTULO</th>
                                <th class="col-md-6">MENSAGEM</th>
                                <th class="col-md-1">INÍCIO</th>
                                <th class="col-md-1">TÉRMINO</th>
                                <th class="col-md-1">DIAS REST.</th>
                                @can('Administrador')
                                <th class="col-md-1">AÇÕES</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($mural))
                                @foreach($mural as $noticias)
                                <tr>
                                    <td>{{$noticias->st_titulo}}</td>
                                    <td>{{$noticias->st_msg}}</td>
                                    <td>{{\Carbon\Carbon::parse($noticias->dt_inicio)->format('d/m/Y')}}</td>
                                    <td>{{\Carbon\Carbon::parse($noticias->dt_termino)->format('d/m/Y')}}</td>
                                    <td>{{$noticias->nu_diasrestantes}}</td>
                                    @can('Administrador')
                                        <td><a class="btn btn-primary fa fa-pencil-square" href="{{url('admin/noticia/editar/'.$noticias->id)}}" title="Editar"></a> 
                                        </td>
                                    @endcan
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            <!-- end listagem Unidade-->
            <!-- Paginação --> 
            @if(isset($mural) && count($mural)>0)
            <div class="pagination pagination-centered">
                {{$mural->links()}}
            </div>
            @endif
            <!-- end Paginação -->
        </div>
    </div>
@stop