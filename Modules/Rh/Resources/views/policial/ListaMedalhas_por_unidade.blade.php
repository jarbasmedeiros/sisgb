@extends('adminlte::page')

@section('title', 'SISGP - Lista de Medalhas')

@php 
$contador = 0;
if(isset($contador_incial)){
    $contador = $contador + $contador_incial;
}
@endphp

@section('content')

<div class="row">
                        
    <div class="col-md-12">
        <form  class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/medalhas/unidade/paginado")}}' >
        {{csrf_field()}}
            <div class="form-inline{{ $errors->has('ce_unidade') ? ' has-error' : '' }}" class="col-md-12">
                <div class="col-md-10">
                    <select class="form-control select2" name="ce_unidade[]" data-placeholder="Selecione a unidade" style="width: 100%;" required>
                        <option value=""></option>
                        <option value="subordinadas">Todas as Unidade Subordinadas</option>    
                        @foreach($unidades as $u)
                            <option value="{{$u->id}}">{!!$u->st_nomepais!!}</option>
                        @endforeach
                    </select>
                </div>
            </div>                                                                            
                                                                    
            <button type="submit" class="btn btn-primary form-inline"><span class="fa fa-search"></span> Consultar</button>                                                                                        
        </form>
    </div>
        
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
               
                <tr class="bg-primary">
                    <th colspan = "9" class="centraliza-vertical">LISTA DE MEDALHAS</th>
                        <th>
                            <div class="col-md-1">
                            <form  class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/medalhas/unidade/excel")}}' >
                                {{csrf_field()}}
                                @if(isset($dados) && count($dados) > 0)
                                @foreach($dados['ce_unidade'] as $d)
                                            
                                            <input type="hidden" name="ce_unidade[]" value="{{$d}}">
                                                
                                    @endforeach
                            
                                @endif
                                <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>                                                                                        
                            </form>
                            </div>
                        </th>                     
                       
                </tr>
                <tr>
                    <th class="col-md-1">ORD</th>
                    <th class="col-md-1">POST/GRA</th>
                    <th class="col-md-3">NOME</th>
                    <th class="col-md-1">MATRÍCULA</th>
                    <th class="col-md-1">UNIDADE</th>
                    <th class="col-md-2">TIPO</th>
                    <th class="col-md-2">MEDALHA</th>
                    <th class="col-md-2">DATA DA MEDALHA</th>
                    <th class="col-md-1">PUBLICAÇÃO</th>
                    <th class="col-md-1">DATA DA PUBLICAÇÃO</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($medalhas))
                    @forelse($medalhas as $m)

                    @php $contador = $contador + 1; @endphp

                    <tr>
                        <td>{{$contador}}</td>
                        <td>{{$m->st_postograduacaosigla}}</td>
                        <td>{{$m->st_nome}}</td>
                        <td>{{$m->st_matricula}}</td>
                        <td>{{$m->st_unidade}}</td>
                        <td>{{$m->st_tipo}}</td>
                        <td>{{$m->st_nomeMedalha}}</td>
                        <td>{{\Carbon\Carbon::parse($m->dt_medalha)->format('d/m/Y')}}</td>
                        <td>{{$m->st_publicacao}}</td>
                        <td>{{\Carbon\Carbon::parse($m->dt_publicacao)->format('d/m/Y')}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center;">Nenhum policial com medalha encontrado.</td>
                    </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
        @if(isset($medalhas) && count($medalhas)>0 && (!is_array($medalhas)))
        @if(isset($dados))
                {{$medalhas->appends($dados)->links()}}
            @else
                {{$medalhas->links()}}
            @endif
        @endif
        
    </div>
</div>
    

@stop






