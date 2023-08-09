@extends('adminlte::page')

@section('title', 'Agendamentos')

@section('content')
    <div class="container-fluid">
        <div class="row align-item-start">
            <div class="panel panel-primary">
                <div class="panel-heading">Resultado da integração {{$integracoes->id}} do (BOLETIM ID-{{$integracoes->ce_boletim}} com {{$integracoes->nu_notas}} notas)</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Nº</th>
                                    <th>Nota(ID)</th>
                                    <th >Tipo</th>
                                    <th>Integrado</th>
                                    <th>Boletim</th>
                                    <th>Policiais</th>
                                    <th>Publicações</th>
                                    <th>Movimentações</th>
                                    
                                   
                                </tr>
                            </thead>
                            <tbody>
                           @php 
                           $contador = 1;
                           @endphp
                                @if(isset($integracoes->notas) && count($integracoes->notas)>0)
                                    @foreach($integracoes->notas as $key => $nota)
                                        <tr>
                                            <td>{{$contador}}</td>
                                            <td>{{$nota->id}}</td>
                                            <td>{{$nota->ce_tipo}}</td>
                                      
                                            @php 
                                            if(empty($nota->bo_integrada)){
                                                 echo '<td><small class="bg-red">0</small></td>';
                                            }elseif($nota->bo_integrada == 1){
                                                echo '<td><small class="label pull-center bg-green">'.$nota->bo_integrada.'</small></td>';
                                            }else {
                                                echo '<td><small class="label pull-center bg-red">'.$nota->bo_integrada.'</small></td>';
                                            }
                                          
                                            if(empty($nota->ce_boletimintegrado)){
                                                 echo '<td><small class="label pull-center bg-red">0</small></td>';
                                            }elseif($nota->ce_boletimintegrado == $integracoes->ce_boletim){
                                                echo '<td><small class="label pull-center bg-green">'.$nota->ce_boletimintegrado.'</small></td>';
                                            }else {
                                                echo '<td><small class="label pull-center bg-red">'.$nota->ce_boletimintegrado.'</small></td>';
                                            }
                                            @endphp

                                            
                                            @if($nota->ce_tipo == 1 && $nota->nu_policiais == 0 )
                                                <th><small class="label pull-center bg-green" >{{$nota->nu_policiais}}</small></th>
                                            @elseif($nota->ce_tipo != 1  && $nota->nu_policiais > 0)
                                                <th><small class="label pull-center bg-green" >{{$nota->nu_policiais}}</small></th>
                                            @else 
                                                <th><small class="label pull-center bg-red" >{{$nota->nu_policiais}}</small></th>
                                            @endif
                                            <td>
                                                @if($nota->ce_tipo == 1 && $nota->nu_publicacoes == 0 )
                                                    <small class="label pull-center bg-green" title="Previsto">{{$nota->nu_publicacoes}}</small>
                                                @elseif($nota->ce_tipo != 1  && $nota->nu_publicacoes > 0)
                                                    <small class="label pull-center bg-green" title="Previsto">{{$nota->nu_publicacoes}}</small>
                                                @else 
                                                    <small class="label pull-center bg-red" title="Previsto">{{$nota->nu_publicacoes}}</small>
                                                @endif
                                                | 
                                                @if($nota->nu_policiais == $nota->nu_publicacoes)
                                                    <small class="label pull-center bg-green" title="Existente">{{$nota->nu_publicacoes}}</small>
                                                @else 
                                                    <small class="label pull-center bg-red" title="Existente">{{$nota->nu_publicacoes}}</small>
                                                @endif
                                            </td>
                                            <td>
                                            @php 
                                            if(($nota->ce_tipo == 17 || $nota->ce_tipo == 18) && $nota->nu_movimentacoes == 0 ){
                                                 echo '<small class="label pull-center bg-red" title="Previsto">'.$nota->nu_movimentacoes.'</small>';
                                            }elseif(($nota->ce_tipo == 17 || $nota->ce_tipo == 18) && $nota->nu_movimentacoes > 0 ){
                                                echo '<small class="label pull-center bg-green" title="Previsto">'.$nota->nu_movimentacoes.'</small>';
                                            }elseif(($nota->ce_tipo != 17 && $nota->ce_tipo != 18) && $nota->nu_movimentacoes == 0 ){
                                                echo '<small class="label pull-center bg-green" title="Previsto">'.$nota->nu_movimentacoes.'</small>';
                                            }else {
                                                echo '<small class="label pull-center bg-yellow" title="Previsto">'.$nota->nu_movimentacoes.'</small>';
                                            }
                                            @endphp
                                            | 
                                                @if(($nota->ce_tipo == 17 || $nota->ce_tipo == 18) && $nota->nu_policiais == $nota->nu_movimentacoes )
                                                    <small class="label pull-center bg-green" title="Existente">{{$nota->nu_movimentacoes}}</small>
                                                @elseif(($nota->ce_tipo != 17 && $nota->ce_tipo != 18) && $nota->nu_movimentacoes == 0)
                                                    <small class="label pull-center bg-green" title="Existente">{{$nota->nu_movimentacoes}}</small>
                                                @else 
                                                    <small class="label pull-center bg-red" title="Existente">{{$nota->nu_movimentacoes}}</small>
                                                @endif
                                           </td>
                                            
                                            
                                        </tr>
                                        @php 
                                        $contador++;
                                        @endphp
                                    @endforeach
                                @else
                                    <tr>
                                        <th colspan="4">Não há integrações para verificar.</th>
                                    </tr>
                                @endif
                             
                            </tbody>
                        </table>
                                    
                    </div>
                    @if(isset($integracoes1) && count($integracoes1)>0)
                        <div class="pagination pagination-centered">
                            <tr>
                            <th>
                                {{$integracoes->links()}}
                            </th>
                            </tr>
                        </div>
                    @endif
                </div>
            </div>
            <a href="{{url('boletim/integrador/agendamentos')}}" class="btn btn-warning"  title="Voltar">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>
        </div>
    </div>
    
@stop
