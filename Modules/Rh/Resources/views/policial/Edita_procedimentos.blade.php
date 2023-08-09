@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP -  Procedimentos')
@section('tabcontent')

    <div class="tab-pane active" id="cursos">
        <h4 class="tab-title">Procedimentos - {{ $policial->st_nome}}</h4>
        <hr class="separador">
    </div>
    <div class="container-fluid">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary">
                        <th colspan="12">Procedimentos</th>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>N° SEI</th>
                        <th>Status</th>
                        <th>Unidade</th>
                        <th>Responsável</th>
                        <th>Solução</th>
                        <th>Ação</th>
                    </tr>
                </thead>
              
                <tbody>  
               
               
                @if(count($procedimentos)>0)
                
                    @foreach($procedimentos as $p) 
                    <tr>
                        <td>{{$p->st_tipo}}</td>
                        <td>{{\Carbon\Carbon::parse($p->dt_publicacaoboletim)->format('d/m/Y')}}</td>
                        <td>{{$p->st_numsei}}</td>
                        <td>{{$p->st_status}}</td>
                        <td>{{$p->st_unidade}}</td>
                        <td>{{$p->st_postgradencarregado}} - {{$p->st_nomeencarregado}}</td>
                        <td>{{$p->st_solucao}}</td>

                        <td class="text-center">
                                <a class='btn btn-success fa fa fa-file-pdf-o' title='Abrir' target="_blank" href='{{url("boletim/nota/visualizar/".$p->ce_nota)}}'    title="Editar Movimentação"></a>
                        </td>
                        </tr>
                    @endforeach 
                 
                @else
                <tr>
                    <td colspan="6" class="text-center">Não há procedimentos vinculados a este policial.</td>
                 </tr>
                @endif              
                   </tbody>
            </table>
        </div>
    </div>  

           

    
@endsection
