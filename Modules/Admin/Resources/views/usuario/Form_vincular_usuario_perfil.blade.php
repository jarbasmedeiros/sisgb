@extends('adminlte::page')

@section('title', 'Edita Usuarios')

@section('content')




<div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Vículo de Usuário com Perfil</div>
                    <div class="panel-body">
                    <div class="bg-primary">USUÁRIO:  {{$usuario->name}}</div></br>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/usuario/vinculos/'.$usuario->id.'/perfil') }}">
                            {{ csrf_field() }}
    

                             <fieldset class="scheduler-border" >
                            <legend class="scheduler-border">Perfis vinculados</legend>

                            <div class="col-md-12 form-inline">
                            @if(isset($perfis)&& count($perfis)>0)
                                @foreach($perfis as $p )
                                   @if($p->id != 1) 
                                    @php    $chek = 0;@endphp

                                        <div class="col-md-6 form-inline">

                                            @foreach($usuario->roles as $pu)
                                                @if($pu->id == $p->id)
                                                @php    $chek = 1;@endphp
                                                @endif
                                            @endforeach
                                        @if($chek == 1)
                                        <input    name="perfisVinculados[]" value="{{$p->id}}" type="checkbox" checked='true'> <strong>{{$p->st_nome}}</strong>
                                        @else
                                        <input  name="perfisVinculados[]" value="{{$p->id}}" type="checkbox" > <strong>{{$p->st_nome}}</strong>
                                        @endif
                                    </div>
                                @else 
                                @can('Admin')
                                    @php    $chek = 0;@endphp

                                    <div class="col-md-6 form-inline">

                                        @foreach($usuario->roles as $pu)
                                            @if($pu->id == $p->id)
                                            @php    $chek = 1;@endphp
                                            @endif
                                        @endforeach
                                    @if($chek == 1)
                                    <input    name="perfisVinculados[]" value="{{$p->id}}" type="checkbox" checked='true'> <strong>{{$p->st_nome}}</strong>
                                    @else
                                    <input  name="perfisVinculados[]" value="{{$p->id}}" type="checkbox" > <strong>{{$p->st_nome}}</strong>
                                    @endif
                                    </div>
                                @endcan
                                @endif

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