@extends('adminlte::page')

@section('title', 'Vínculos de Usuarios')


@section('content')

<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Vículo de Usuário com unidades</div>
                    <div class="panel-body">
                    <div class="bg-primary">USUÁRIO:  {{$usuario->name}}</div></br>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/usuario/vinculos/'.$usuario->id) }}">
                            {{ csrf_field() }}
    

                             <fieldset class="scheduler-border" >
                            <legend class="scheduler-border">Unidades Vinculadas</legend>

                            <div class="col-md-12 form-inline">
                            @if(isset($unidades)&& count($unidades)>0)
                                @foreach($unidades as $unidade )
                                
                                @php    $chek = 0;@endphp

                                    <div class="col-md-6 form-inline">
                                        @foreach($unidadesvinculadas as $uv)
                                            @if($uv->id == $unidade->id)
                                            @php    $chek = 1;@endphp
                                            @endif
                                        @endforeach
                                    @if($chek == 1)
                                    <input    name="unidadesvinculadas[]" value="{{$unidade->id}}" type="checkbox" checked='true'> <strong>{{$unidade->st_nomepais}}</strong>
                                    @else
                                    <input  name="unidadesvinculadas[]" value="{{$unidade->id}}" type="checkbox" > <strong>{{$unidade->st_nomepais}}</strong>
                                    @endif
                                </div>
                                @endforeach
                             
                            </div>
                            @endif
                        </fieldset>
    
                            <div class="form-group ">
                                <div class="col-md-2  col-md-offset-4">
                                    <a href='{{ url("admin/usuarios") }}' class=" btn btn-danger"  title="Voltar">
                                        <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                    </a>
                                </div>
                                <button type="submit" class="col-md-2 btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Salvar
                                </button>
                            </div>
    
    
                        </form>
                       
                        
                    </div>
                </div>
            </div>
        </div>
    
@stop