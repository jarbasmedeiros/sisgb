@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Cursos')
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
                        <th  class="col-md-2">
                            @can('Edita')
                            <a href='{{url("rh/policiais/edita/".$policial->id."/curso/create")}}'><h1 class="btn btn-primary">Novo Curso</h1></a>
                            @endcan
                        </th>
                    </tr>
                    
                    <tr>
                        <th class="col-md-3">CURSO</th>
                        <th class="col-md-1">TIPO</th>
                        <th class="col-md-1">MÉDIA</th>
                        <th class="col-md-1">Conclusão</th>
                        <th class="col-md-1">INSTITUIÇÃO</th>
                        <th class="col-md-1">CARGA HORÁRIA</th>
                        <th class="col-md-1">PUBLICAÇÃO</th>
                        <th class="col-md-1">DATA PUBLICAÇÃO</th>
                        @can('Edita')
                            <th class="col-md-2">Ações</th>
                        @endcan
                    </tr>

                </thead>
                <tbody>
                        @if(isset($cursos) && count($cursos) > 0)
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
                        @can('Edita')
                        <td  class="col-md-2">
                        <a class="btn btn-warning fa fa-pencil" href="{{url('rh/policiais/'.$policial->id.'/edita/curso/'.$c->id)}}" title="Editar"></a> | 
                            <a onclick="modalDesativa({{$c->id}}, {{$policial->id}})" data-toggle="modal" data-placement="top" title="Excluir" class="btn btn-danger">
                            <i class="fa fa-trash"></i></a> 
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                    @endif
                </tbody>
                
            </table>
        </div>
    </div>
</div>




<!-- Modal Excluir curso -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR O CURSO?</b>
                </h4>
                <form class="form-inline" id="modalDesativa" method="get" > {{csrf_field()}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Excluir</button>
            </div>
            </form>
        </div>
    </div>
</div>
@section('js')
    <!-- Java script para o modulo boletim -->
    <script src="{{ asset('js/rh.js') }}"></script>
   
   
    @stack('js_boletim')
    @yield('js_boletim')
@stop
<script>



        function modalDesativa(idCurso, idpolicial){
            
            var url = idpolicial+'/curso/'+idCurso+'/deleta';                      
           $("#modalDesativa").attr("action", "{{ url('rh/policiais/')}}/"+url);
                $('#Modal').modal();        
            };
</script>

<!-- /.tab-pane -->
@endsection