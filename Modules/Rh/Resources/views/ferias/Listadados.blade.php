@extends('funcionario.Form_edita_funcionario')

@section('tabcontent')
<div class="tab-pane active" id="dados_academicos">
    


@section('title', 'Férias')
@php $contador = 0;
    $id_crs  = null;
    $caderneta  =NULL;
    $id_crs = 1; 


 @endphp
 @can('Admin')
    <a href="{{url('/rh/registro/'.$servidor->id.'/'.$tiporegsitro)}}"><h1 class="btn btn-primary">Novo Registro</h1></a>
    <a href="{{url('/rh/listacrportipo/'.$servidor->id.'/'.$tiporegsitro.'/impressao')}}"><h1 class="btn btn-primary">Imprimir</h1></a>
@endcan

   
    <div class="content">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xs-12">

                    <table class="table table-bordered">
                        <thead>
                            
                            <tr>
                            @if(isset($registros))
                               
                                    @php   $nomesdositens =$registros[0]->registros;
                                       
                                    @endphp
                                    @foreach($nomesdositens  as  $item)
                                    <th class="col-md-2 col-lg-2 col-xs-2">{{$item->st_nomedoitem}}</th>

                                    @endforeach 
                           

                                @can('Admin')
                                <th class="col-md-2 col-lg-2 col-xs-2">AÇÕES</th>
                                @endcan
                            @endif   
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($registros))
                       
                                      
                        @foreach($registros as $r)
                       
                   
                          
                                <tr>

                                    <form method='post' action="{{url('/rh/editaferias/'.$servidor->id.'/'.$tiporegsitro)}}">
                                    {{ csrf_field() }}
                                    @php $caderneta = $r->registros;
                                         $id_crs =  $r->id;
                                     
                                  
                                     @endphp
                                    @foreach($caderneta  as  $valor)
                                   
                                    
                                        @if($valor->tipoitem == 'data')
                                        <th>{{\Carbon\Carbon::parse($valor->st_valor)->format('d/m/Y')}}<br/>
                                        <div  class= "{{ $id_crs}}" style="display: none;">
                                       
                                        <input   type="date" name= "{{$valor->id}}" value="{{$valor->st_valor}}"/>
                                            </div>                                       
                                        </th>
                                        @elseif($valor->tipoitem == "Texto longo")
                                        <th>{{$valor->st_valor}}
                                        <div  class= "{{ $id_crs}}" style="display: none;">
                                        <textarea  name= "{{$valor->id}}" rows="10" > {{$valor->st_valor}}</textarea>
                                        
                                        </div>
                                        </th>
                                        @else
                                        <th>{{$valor->st_valor}}
                                        <div  class= "{{ $id_crs}}" style="display: none;">
                                        <input   type="text"  name= "{{$valor->id}}" value="{{$valor->st_valor}}"/>
                                        </div>
                                        </th>

                                        @endif
                                    @endforeach
                                   
                                    @can('Admin')
                                    <th>
                                        <p class="btn btn-primary bt_edita" onclick = "modaledita({{$id_crs}})">Editar </p> 
                                        <input type="submit" value="Salvar" style="display: none;" id="{{$id_crs}}" class="btn btn-primary  $id_crs"> 
                                        <a onclick='modalDesativa({{$id_crs }})' data-toggle="modal" data-placement="top" title="Deletar" class="btn btn-danger">
                                        <i class="fa fa-trash"></i></a> 
                                    </th>
                                    @endcan
                                    </form>
                                </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Modal Desativa usuário -->
<div class="modal fade-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Férias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
    
                    <h4 class="modal-title" id="exampleModalLabel">
                        <b>DESEJA REALMENTE EXCLUIR A FÉRIAS?</b>
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
  
            function modalDesativa(id){
               
               $("#modalDesativa").attr("action", "{{ url('rh/cr/destroy')}}/"+id);
                    $('#Modal').modal();        
                };
                   
              
                   
            function modaledita(id){
                $(".bt_edita").hide();
                $('.'+id).show();
                $('#'+id).show();
               
               
             /*   $("#modalDesativa").attr("action", "{{ url('rh/cr/destroy')}}/"+id);
                    $('#Modal').modal();   */      
                };
            </script>

</div>
<!-- /.tab-pane -->
@endsection