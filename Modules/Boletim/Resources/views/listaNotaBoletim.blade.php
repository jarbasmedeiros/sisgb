@extends('boletim::boletim.template_boletim')
@section('title', 'Listagem de Notas do Boletim')
@section('content_dinamic')




   <div class="container-fluid">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">LISTAGEM DE NOTAS DO BOLETIM</div>
                <div class="panel-body">
                <fieldset class="scheduler-border">
                    <table class="table table-bordered">
                            <thead>
                                    <tr class="bg-primary">
                                      
                                        <th style="width: 10%">Parte</th>
                                        <th style="width: 22.5%">Tipo</th>
                                        <th style="width: 22.5%">Tópico</th>
                                        <th style="width: 22.5%">Assunto</th>
                                        <th style="width: 22.5%">Ação</th>
                                    </tr>
                        
                            </thead>
                           
                @if(isset($notas))
                    @foreach($notas as $p)
                            <tr>
                                <td>{{$p->st_parte}}</td>
                                <td>{{$p->st_tipo}}</td>
                                <td>{{$p->st_topico}}</td>
                                <td>{{$p->st_assunto}}</td>
                                <td style="text-align: center">
                               @if($p->bo_ativo == 1)
                                <a href="{{url('boletim/nota/visualizar/'.$p->id)}}" class="btn btn-primary fa fa fa-eye" title="Visualizar Nota" target="_blank"></a>
                               @else
                               <button href="{{url('boletim/nota/visualizar/'.$p->id)}}" class="btn btn-primary fa fa fa-eye" title="Nota Excluida" disabled></button>
                               @endif
                            </tr>
                         </tr>
                     @endforeach                     
                @else
                     <tr>
                         <td colspan="7">Não há notas cadastradas para este boletim.</td>
                     </tr>
                @endif
                 
                 </tbody>   
                 </table>    
                </fieldset>
                <a href="{{url('boletim/consulta')}}" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar">
                                 <i class="glyphicon glyphicon-arrow-left"></i> Voltar
                        </a>
                       </div>
                 </div>
             </div>
        </div>   
    </div>

@stop