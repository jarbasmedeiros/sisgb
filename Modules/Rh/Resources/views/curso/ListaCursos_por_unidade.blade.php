@extends('adminlte::page')

@section('title', 'Lista de Cursos')


@section('content')

<div class="row"><div class="col-md-12">
                                <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/cursos/unidade/nome/paginado")}}' >
                                    {{csrf_field()}}
                                    <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }}" class="col-md-12">
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="ce_unidade[]" data-placeholder="Selecione a unidade curso" style="width: 100%;" required>
                                                @foreach($unidade as $u)
                                                    <option value="">Selecione a unidade para qual deseja consultar o curso</option>
                                                    <option value="{{$u->id}}">{!!$u->st_nomepais!!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                                                                            
                                    <div class="col-md-4">
                                        <label for="st_curso" class="col-md-2 ">Curso:</label>
                                        <div class="col-md-2">
                                            <input type="text" id="st_curso" name="st_curso" placeholder="Informe o nome do curso" class="form-inline" required="true">
                                            @if ($errors->has('st_curso'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('st_curso') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>                                                                            
                                                                                                             
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Consultar</button>                                                                                        
                                </form>
                            </div>
                       
                       









    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
               
                <tr class="bg-primary">
                    <th colspan = "7">LISTA DE CURSOS</th>
                        <th>
                            <div class="col-md-1">
                            @if(isset($dados))
                                <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/relatorios/cursos/unidade/nome/excel")}}' >
                            @else
                                <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="get" action='{{url("rh/relatorios/cursos/unidade/excel")}}' >
                            @endif
                                    {{csrf_field()}}
                                    @if(isset($dados))
                                  
                                    @foreach($dados['ce_unidade'] as $d)
                                                
                                                <input type="hidden" name="ce_unidade[]" value="{{$d}}">
                                                    
                                        @endforeach
                                   
                                
                                    <input type="hidden" id="st_curso" name="st_curso" value="{{$dados['st_curso']}}">
                                
                                    @endif
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>                                                                                        
                                </form>
                            </div>
                        </th>                     
                       
                </tr>
                <tr>
                    <th class="col-md-1">Ord</th>
                    <th class="col-md-1">POST/GRAD</th>
                    <th class="col-md-6">NOME</th>
                    <th class="col-md-2">MATRÍCULA</th>
                    <th class="col-md-2">CURSO</th>
                    <th class="col-md-2">TIPO</th>
                    <th class="col-md-2">DATA DA PUBLICAÇÃO</th>
                    <th class="col-md-1">PUBLICAÇÃO</th>
                </tr>
            </thead>
            <tbody>
            @php
            $contador = 0;
            @endphp
                @if(isset($cursos))
                    @forelse($cursos as $c)
                    @php
                    $contador = $contador+1;
                    @endphp
                    <tr>
                        <td>{{$contador}}</td>
                        <td>{{$c->st_postograduacaosigla}}</td>
                        <td>{{$c->st_nome}}</td>
                        <td>{{$c->st_matricula}}</td>
                        <td>{{$c->st_curso}}</td>
                        <td>{{$c->st_tipo}}</td>
                        <td>{{\Carbon\Carbon::parse($c->dt_publicacao)->format('d/m/Y')}}</td>
                        <td>{{$c->st_boletim}}</td>
                       
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Nenhum policial curso encontrado.</td>
                    </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
        @if(isset($cursos) && count($cursos)>0 && (!is_array($cursos)))
            @if(isset($dados))
            {{$cursos->appends($dados)->links()}}
            @else
            {{$cursos->links()}}
            @endif
        @endif

    </div>
</div>
    

@stop






