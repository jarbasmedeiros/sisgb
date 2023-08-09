@extends('boletim::boletim.template_boletim')

@section('title', 'Notas recebidas')

@section('content_dinamic')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Lista de Notas enviadas para Boletim</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th class='col-md-1'>Data</th>
                                <th class='col-md-3'>Assunto</th>
                                <th class='col-md-1'>Status</th>
                                <th class='col-md-3'>Origem</th>
                                <th class='col-md-1'>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($notas) && count($notas)>0)
                                @foreach($notas as $nota)
                              
                                    <tr>
                                        <td>{{date('d/m/Y', strtotime($nota->dt_cadastro))}}</td>
                                        <td>{{$nota->st_assunto}}</td>
                                        <td>{{$nota->st_status}}</td>
                                        <td>{{$nota->unidade}}</td>
                                        <td>
                                            <a href="{{url('boletim/nota/edit/'. $nota->id . '/' . $nota->ce_tipo)}}" data-toggle="tooltip" class='btn btn-primary fa fa-eye' title='Abrir'></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th colspan="6">Nenhuma nota encontrada</th>
                                </tr>

                            @endif
                        </tbody>
                    </table>
                    @if(isset($notas) && count($notas)>0)
                        {{$notas->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        $('.accordion-toggle').click(function(){
            $(this).text(function(i,old){
                return old=='Ver mais...' ?  'Ver menos...' : 'Ver mais...';
            });
        });
    </script>
@endsection