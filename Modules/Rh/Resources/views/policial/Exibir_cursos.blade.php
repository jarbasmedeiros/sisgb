@extends('rh::policial.Form_edita_policial')
@section('title', 'SGPO - Cursos')
@section('tabcontent')
<div class="tab-pane active" id="cursos">
    <h4 class="tab-title">Cursos - {{ $policial->st_nome}}</h4>
    <hr class="separador">
   
    
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">

            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan="8">Cursos</th>
                    </tr>
                    <tr>
                        <th class="col-md-3">CURSO</th>
                        <th class="col-md-2">TIPO</th>
                        <th class="col-md-1">MÉDIA</th>
                        <th class="col-md-1">CONCLUSÃO</th>
                        <th class="col-md-2">INSTITUIÇÃO</th>
                        <th class="col-md-1">CARGA HORÁRIA</th>
                        <th class="col-md-1">PUBLICAÇÃO</th>
                        <th class="col-md-1">DATA PUBLICAÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($cursos))
                    @foreach($cursos as $c)
                        <tr>
                            <td>{{$c->st_curso}}</td>
                            <td>{{$c->st_categoria}}</td>
                            <td>{{$c->st_mediafinal}}</td>
                            <td>{{\Carbon\Carbon::parse($c->dt_conclusao)->format('d/m/Y')}}</td>      
                            <td>{{$c->st_instituicao}}</td>      
                            <td>{{$c->st_cargahoraria}}</td>      
                            <td>{{$c->st_boletim}}</td>      
                            <td>{{\Carbon\Carbon::parse($c->dt_publicacao)->format('d/m/Y')}}</td>      
                        </tr>
                    @endforeach
                    @endif
                </tbody>
                
            </table>
        </div>
    </div>
</div>
@endsection