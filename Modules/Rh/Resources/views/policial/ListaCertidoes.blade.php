@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP -  Certidões')
@section('tabcontent')
                
    <div class="tab-pane active" id="cursos">
        <h4 class="tab-title">Certidões - {{ $policial->st_nome}} </h4>
        <hr class="separador">
    
    </div>
    <div class="container-fluid">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                
                    <tr class="bg-primary">
                            <th colspan="4">Certidões</th>
                            <th class="text-center">
                            <button data-toggle="modal" data-target="#criacertidao" title="Nova Certidao" class="btn btn-primary">Nova Certidão</button>
                                </a>
                            </th>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <th>Nº Certidão</th>
                        <th>Data de Emissão</th>
                        <th>Validade</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                    <tbody>
                    @if(isset($certidao) && count($certidao) > 0)
                                    @forelse($certidao as $a)
                                    @php
                                   
                                        $atual = date('Y/m/d');
                                        //converte o tipo para data
                                        $hj = new DateTime($atual);
                                        $temp_emissao = new DateTime($a->dt_emissao);
                                        $diff=date_diff($hj,$temp_emissao);
                                        $diferenca =  $diff->format("%a");
                                    @endphp
                                    <tr>
                                    <td>{{$a->st_tipo}}</td>
                                    <td>{{$a->st_sequencial}}/{{$a->st_ano}}</td>
                                    <td>{{\Carbon\Carbon::parse($a->dt_emissao)->format('d/m/Y')}}</td>
                                    @if($diferenca > 30)
                                        <td style="color:red;"> EXPIRADO</td> 
                                    @else  
                                         <td style="color:green;" >VÁLIDO</td>
                                    @endif
                                        <td class="text-center">
                                       @if($diferenca >30)
                                       <a></a>
                                       @else
                                        <a href='{{url("rh/policiais/edita/" . $policial->id ."/certidoes/" .$a->id)}}' target="_blank" class="btn btn-primary " title="Visualizar">
                                         <i class="fa fa-eye"></i> 
                                        </a>
                                        
                                          @if(($a->ce_assinaturachefia == null))
                                            <a  onclick="Assina({{$a->id}}, {{$policial->id}})"  data-toggle="modal" data-target="#assinarModal" data-idCertidao="{{$a->id}}" data-idPolicial="{{$policial->id}}" class="btn btn-success " title="Assinatura do Chefe">
                                                <i class="fa fa-edit"></i> 
                                            </a>                   
                                       
                                       
                                         @endif 
                                       @endif
                          
                               </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">Nenhuma certidão encontrada.</td>
                                    </tr>
                                    @endforelse
                        </tbody>
            </table>
        </div>
    </div>  
      
     <!-- Moldal para botão assinar -->
 
<div class="modal fade" id="assinarModal">
      <div class="modal-dialog">
           <div class="modal-content" style="width:60%;">
               <div class="modal-header bg-primary">
                   <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                   <h4 class="modal-title">ASSINAR CERTIDÃO</h4>
               </div>
               <div class="modal-body w-100 text-center">
                   <table class="table table-condensed" >
                  
                   <form  name="assinar_form" role="form" type="submit" id="form_assina_certidao" method="POST">
                   {{csrf_field()}} 
                    <div class="form-group">
                        <strong> DESEJA REALMENTE ASSINAR A CERTIDÃO? </strong>
                            <br>
                            <label for="st_password" class="control-label">Senha</label>
                            <input type="password" class="control-form" name="st_password" required>
                           
                    </div>
                </div>
                  </table>  
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button  type="submit" class="btn btn-primary">Sim</a>
               </div>
               </form>
           </div>
       </div>
    </div>
 <!-- Moldal para botão assinar -->
 
 @endif


<!-- Modal Cria Licença -->
<div class="modal fade" id="criacertidao" tabindex="-1" role="dialog" aria-labelledby="criacertidao" aria-hidden="true">

        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">            
                <div class="modal-header  bg-primary">
                    <h4 class="modal-title " >Nova Certidão</h4>
                </div>
     
                <div class="modal-body bg-">
                    <form role="form" id="form_licenca" method="POST" action="{{ url('rh/policiais/'.$policial->id.'/cadastra/certidao') }}"> 
                        {{csrf_field()}}  
                        <div class="form-group col-md-12">
                            <label>Tipo</label>
                            <select name="st_tipo" id="st_tipo" class="form-control"  required  style="width:80%;">
                                <option value="">Selecione</option>
                                <option>Nada Consta(Procedimentos)</option>
                            </select>
                            @if ($errors->has('st_tipo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('st_tipo') }}</strong>
                                </span>
                            @endif
                          
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success salvar">Gerar</button>
                        </div>
                    </form>
                </div> 
            </div>
            </div>
        </div>
    </div>
   
    <script>
            function Assina(idCertidao, idPolicial ){
               
               var url = idPolicial+'/assinacertidao/'+idCertidao;                      
               $("#form_assina_certidao").attr("action", "{{ url('rh/policiais/')}}/"+url);
                
            }
    </script>
@endsection
