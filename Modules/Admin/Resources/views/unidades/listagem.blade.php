@extends('adminlte::page')

@section('title', 'Unidades')
@can('Administrador')
    @section('content_header')
   
    @stop
@endcan


@section('content')
             
    <div class="panel panel-primary">
        <div class="panel-heading">Listagem de Unidade</div>
        <div class="panel-body">
        <div class='form-group col-12'>
            <!-- form consultar Unidade-->
                <form role="form" method="POST" action='{{ url("admin/unidade/consulta") }}' >
                    {{csrf_field()}}
                    <div  class="col-md-3">
                        <input id="st_consulta" type="text" class="form-control" placeholder="Pesquisar por sigla ou nome da unidade" name="st_consulta"  required> 
                        @if ($errors->has('st_consulta'))
                            <span class="help-block">
                            <strong>{{$errors->first('st_consulta') }}</strong>
                        </span>
                        @endif
                    </div>        
                    <div class='col-md-0'>
                        <button type="submit" class="btn btn-primary"><span class="fa fa-fw fa-search "></span> Consultar</button>                                                                                        
                    </div>
                </form>
            </div>
            <!-- end form consultar Unidade-->
            <!-- listagem  Unidade-->
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead >
                            <tr class="bg-primary">
                        
                                @if(isset($unidades) && count($unidades)>0)
                                    <th colspan="6"> Listagem com {{$unidades->total()}} Unidades cadastrada(s)</th>
                                @else 
                                    <th colspan="6"> Listagem com 0 Unidade cadastrada</th>
                                @endif 
                            </tr>
                            <tr>
                                <th class="col-md-1">SIGLA</th>
                                <th class="col-md-2">NOME</th>
                                
                                <th class="col-md-1">TIPO</th>
                                <th class="col-md-1">MUNICÍPIO</th>
                                <th class="col-md-3">PAI</th>
                                
                                
                                <th class="col-md-1">AÇÕES</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($unidades))
                                @foreach($unidades as $unidade)
                                <tr>
                                    <td>{{$unidade->st_sigla}}</td>
                                    <td>{{$unidade->st_descricao}}</td>
                                    
                                    <td>{{$unidade->st_tipo}}</td>
                                    <td>{{$unidade->st_cidade}}</td>
                                    <td>{{$unidade->st_nomepais}}</td>                                    
                                    <td class="text-center">
                                        <a class="btn btn-warning fa fa fa-eye" href="{{url('admin/unidades/detalhes/'.$unidade->id)}}" title="Detalhes"></a>
                                        @can('Relatorios_rh')
                                            <a class="btn btn-primary fa fa-pencil-square" href="{{url('admin/unidades/edit/'.$unidade->id)}}"title="Editar"></a>                                                           
                                        @endcan
                                        
                                        @can('Administrador')
                                            <a class="btn btn-primary fa fa-pencil-square" href="{{url('admin/unidades/edit/'.$unidade->id)}}"title="Editar"></a>                                                           
                                        @endcan
                                    </td> 
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            <!-- end listagem Unidade-->
            <!-- Paginação -->
                
                @if(isset($unidades) && count($unidades)>0)
                    <div class="pagination pagination-centered">
                    @if(isset($dadosForm))
                            {{$unidades->appends($dadosForm)->links()}}
                    @else
                        {{$unidades->links()}}
                    @endif
                    
                    </div>
                @endif
                
            <!-- end Paginação -->
        </div>
    </div>
          




@stop