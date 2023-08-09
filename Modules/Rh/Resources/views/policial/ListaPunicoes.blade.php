@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Punicoes')
@section('tabcontent')
<div class="tab-pane active" id="publicacoes">
    <h4 class="tab-title">Punições - {{ $policial->st_nome}}</h4>
    <hr class="separador">
    {{ csrf_field() }}
        <div class="row">
        <div class="content">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th colspan="8">Punições</th>
                            <th>
                                <div class="col-md-1">
                                    <form id="novaMovimentacao" class="form-horizontal" role="form" method="GET" action='{{url("rh/policiais/".$policial->id."/punicao/create")}}'>
                                        @can('Edita')
                                            <button type="submit" class="btn btn-primary " title="Adicionar Nova Punição">Nova Punição</button>                                                                                        
                                        @endcan
                                    </form>
                                </div>                                
                            </th>
                        </tr>
                        <tr>
                            <th class="col-md-1">TIPO</th>
                            <th class="col-md-1">DATA</th>
                            <th class="col-md-3">DESCRIÇÃO</th>
                            <th class="col-md-1">PUBLICAÇÃO</th>
                            <th class="col-md-1">DATA DA PUBLICAÇÃO</th>
                            <th class="col-md-1">COMPORTAMENTO</th>
                            <th class="col-md-1">STATUS</th>
                            <th class="col-md-2">OBSERVAÇÃO</th>
                            @can('Edita')
                                <th class="col-md-1">AÇÕES</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($punicoes) && count($punicoes) > 0)
                            @forelse($punicoes as $p)
                                @if ($p->st_status == 'ANULADA')
                                    @can('PUNICAO_ANULADA')
                                        <tr >
                                            <td>{{$p->st_tipo}}</td>
                                            <td>{{\Carbon\Carbon::parse($p->dt_punicao)->format('d/m/Y')}}</td>
                                            <td>{!!$p->st_materia!!}</td>
                                            <td>{{$p->st_boletim}}</td>
                                            <td>@if(!empty($p->dt_boletim)){{\Carbon\Carbon::parse($p->dt_boletim)->format('d/m/Y')}}@endif</td>
                                            <td>{{$p->st_comportamento}}</td>
                                            <td>{{$p->st_status}}</td>
                                            @if($p->st_status != 'ATIVA')
                                                @php 
                                                    if(!empty($p->dt_cancelamentoanulacao)){
                                                        $dataCancelamento = \Carbon\Carbon::parse($p->dt_boletim)->format('d/m/Y');
                                                    }else{
                                                        $dataCancelamento = ('NÃO INFORMADO');
                                                    }
                                                    if(!empty($p->st_boletimcancelamentoanulacao)){
                                                        $boletimCancelamento = $p->st_boletimcancelamentoanulacao;
                                                    }else{
                                                        $boletimCancelamento = ('NÃO INFORMADO');
                                                    }
                                                    if(!empty($p->dt_boletimcancelamentoanulacao)){
                                                        $dataBoletimCancelamento = \Carbon\Carbon::parse($p->dt_boletimcancelamentoanulacao)->format('d/m/Y');
                                                    }else{
                                                        $dataBoletimCancelamento = ('NÃO INFORMADO');
                                                    }
                                                @endphp
                                                <td> Punição {{$p->st_status}} no dia {{$dataCancelamento}}, conforme Boletim {{$boletimCancelamento}} de {{$dataBoletimCancelamento}} </td>
                                            @else
                                                <td> </td>
                                            @endif
                                            <td>
                                                @can('Edita')
                                                    <a class="btn btn-warning  fa fa fa-pencil-square" href='{{url("rh/policiais/".$policial->id."/punicao/edita/".$p->id)}}' title="Editar Punição"></a> 
                                                @endcan

                                                @can('EXCLUIR_PUNICAO')
                                                |
                                                <a onclick="modalDesativa({{$p->id}}, {{$policial->id}})" data-toggle="modal" data-placement="top" title="Deletar Punição" class="btn btn-danger  fa fa fa-trash"></a> 

                                                @endcan 
                                            </td>
                                        </tr>
                                    @endcan
                                @else
                                    <tr >
                                        <td>{{$p->st_tipo}}</td>
                                        <td>{{\Carbon\Carbon::parse($p->dt_punicao)->format('d/m/Y')}}</td>
                                        @if ($p->st_status == 'CANCELADA')
                                            <td> <div class="bg-black text-black">CANCELADA</div></td>
                                        @else
                                            <td>{!!$p->st_materia!!}</td>
                                        @endif
                                        <td>{{$p->st_boletim}}</td>
                                        <td>@if(!empty($p->dt_boletim)){{\Carbon\Carbon::parse($p->dt_boletim)->format('d/m/Y')}}@endif</td>
                                        <td>{{$p->st_comportamento}}</td>
                                        <td>{{$p->st_status}}</td>
                                        @if($p->st_status != 'ATIVA')
                                            @php 
                                                if(!empty($p->dt_cancelamentoanulacao)){
                                                    $dataCancelamento = \Carbon\Carbon::parse($p->dt_boletim)->format('d/m/Y');
                                                }else{
                                                    $dataCancelamento = ('NÃO INFORMADO');
                                                }
                                                if(!empty($p->st_boletimcancelamentoanulacao)){
                                                    $boletimCancelamento = $p->st_boletimcancelamentoanulacao;
                                                }else{
                                                    $boletimCancelamento = ('NÃO INFORMADO');
                                                }
                                                if(!empty($p->dt_boletimcancelamentoanulacao)){
                                                    $dataBoletimCancelamento = \Carbon\Carbon::parse($p->dt_boletimcancelamentoanulacao)->format('d/m/Y');
                                                }else{
                                                    $dataBoletimCancelamento = ('NÃO INFORMADO');
                                                }
                                            @endphp
                                            <td> Punição {{$p->st_status}} no dia {{$dataCancelamento}}, conforme Boletim {{$boletimCancelamento}} de {{$dataBoletimCancelamento}} </td>
                                        @else
                                            <td> </td>
                                        @endif
                                        <td>
                                            @can('Edita')
                                                <a class="btn btn-warning  fa fa fa-pencil-square" href='{{url("rh/policiais/".$policial->id."/punicao/edita/".$p->id)}}' title="Editar Punição"></a> 
                                            @endcan

                                            @can('EXCLUIR_PUNICAO')
                                            |
                                            <a onclick="modalDesativa({{$p->id}}, {{$policial->id}})" data-toggle="modal" data-placement="top" title="Deletar Punição" class="btn btn-danger  fa fa fa-trash"></a> 

                                            @endcan 
                                        </td>
                                    </tr>
                                @endif
                               
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center;">Nenhuma Punição Encontrada.</td>
                                </tr>
                            @endforelse
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
                <h5 class="modal-title" id="exampleModalLabel">Excluir Punição</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body alert-danger">

                <h4 class="modal-title" id="exampleModalLabel">
                    <b>DESEJA REALMENTE EXCLUIR A PUNIÇÃO?</b>
                </h4>
                <form class="form-inline" id="modalDesativa" method="post" > {{csrf_field()}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Excluir</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function modalDesativa(idPunicao, idpolicial){
        var url = idpolicial+'/exclui/'+idPunicao+'/punicao';                      
        $("#modalDesativa").attr("action", "{{ url('rh/policiais/')}}/"+url);
        $('#Modal').modal();        
    };
</script>




@endsection