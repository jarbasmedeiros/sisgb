@extends('adminlte::page')

@section('title', 'Auditoria')


@section('content')
@php 
$contador = 0;
@endphp

<div class="row">
<div class="col-md-12">
    <fieldset class="scheduler-border">    	
        <legend class="scheduler-border">Parêmtros para consulta</legend>
                            <div class="col-md-12">
                                <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/diarias/listapoliciaisferias")}}' >
                                    {{csrf_field()}}
                                    <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }}" class="col-md-12">
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="st_tipo" id="st_tipo" style="width: 100%;" required>
                                                    @if(isset($dados) && count($dados)>0  && !empty($dados['st_tipo']))
                                                        <option value="{{$dados['st_tipo']}}">{{$dados['st_tipo']}}</option>
                                                    @endif
                                                    <option value="">Selecione o parâmetro da consulta</option>
                                                    <option value="ferias">Férias</option>
                                                    <option value="licenca">Licenças</option>
                                                    <option value="unidade">Unidades</option>
                                               
                                            </select>
                                        </div>
                                    </div>                                                                            
                                    <div class="form-group{{ $errors->has('ce_unidade') ? ' has-error' : '' }}" class="col-md-12">
                                        <div class="col-md-12">
                                       <!--  <input type="text" id="st_matricula" name="st_matricula" placeholder="Informe as matrículas seperadas por vírgula, sem pontos e sem espaços" class="form-inline col-md-12" required="true" value='1666886,1761480'> -->
                                        <textarea class="col-md-12" id="st_matricula"  placeholder="Informe as matrículas seperadas por vírgula, sem pontos e sem espaços" name="st_matricula" rows="4" >{{$dados['st_matricula']}}</textarea>
                                            @if ($errors->has('st_matricula'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('st_matricula') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                            
                                        </div>
                                    </div>                                                                            
                                    <div class="col-md-4" id="dt_inicio">
                                        <label for="dt_inicio" class="col-md-2 ">Data Inicial:</label>
                                        <div class="col-md-2">
                                            <input type="date" id="dt_inicio" name="dt_inicio" class="form-inline" value="{{$dados['dt_inicio']}}">
                                            @if ($errors->has('dt_inicio'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dt_inicio') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>                                                                            
                                    <div class="col-md-4" id="dt_final">
                                        <label for="dt_final"  class="col-md-2 ">Data Final:</label>
                                        <div class="col-md-2">
                                            <input type="date" id="dt_final" name="dt_final" class="form-inline" value="{{$dados['dt_final']}}" >
                                            @if ($errors->has('dt_inicio'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dt_final') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>                                                                            
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Consultar</button>                                                                                        
                                </form>
                            </div>
                        </fildset>
</div>









        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                
                    <tr class="bg-primary">
                        <th colspan = "7">LISTA DE FÉRIAS</th>

                        <th>
                            <div class="col-md-1">
                                @if(isset($consulta) && count($consulta) >0)
                               
                                <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="POST" action='{{url("rh/diarias/listapoliciaisferias")}}' >
                                    {{csrf_field()}}
                                  
                               
                                                
                                    <input type="hidden" name="st_matricula" value="{{$dados['st_matricula']}}">
                                    <input type="hidden" name="st_tipo" value="{{$dados['st_tipo']}}">
                                    <input type="hidden" name="renderizacao" value="excel">
                                                    
                                   
                                   
                                
                                    <input type="hidden" id="inicio" name="dt_inicio" value="{{$dados['dt_inicio']}}">
                                    <input type="hidden" id="dt_final" name="dt_final" value="{{$dados['dt_final']}}" >
                                
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Gerar Excel</button>                                                                                        
                                    @endif
                                </form>
                            </div>
                        </th>   
                                
                        
                    </tr>
                    
                </thead>
                @if(isset($dados) && count($dados)>0)
                    
                    @if($dados['st_tipo'] == 'ferias')
                        <tbody>
                        <tr>
                        <th class="col-md-1">ORD</th>
                        <th class="col-md-1">POST/GRAD</th>
                        <th class="col-md-2">NUM/PRAÇA</th>
                        <th class="col-md-4">NOME</th>
                        <th class="col-md-2">MATRÍCULA</th>
                        <th class="col-md-1">QTD DE DIAS</th>
                        <th class="col-md-1">INÍCIO</th>
                        <th class="col-md-1">FIM</th>
                        <th class="col-md-1">REFERENTE AO ANO</th>
                    </tr>
                            @if(isset($consulta))
                                @forelse($consulta as $f)
                                @php 
                                    $contador = $contador+1;
                                @endphp
                                <tr>
                                    <th>{{$contador}}</th>
                                    <th>{{$f->st_postograduacaosigla}}</th>
                                    <th>{{$f->st_numpraca}}</th>
                                    <th>{{$f->st_nome}}</th>
                                    <th>{{$f->st_matricula}}</th>
                                    <th>{{$f->nu_dias}}</th>
                                    <th>{{\Carbon\Carbon::parse($f->dt_inicio)->format('d/m/Y')}}</th>
                                    <th>{{\Carbon\Carbon::parse($f->dt_fim)->format('d/m/Y')}}</th>
                                    <th>{{$f->nu_ano}}</th>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="text-align: center;">Nenhum policial com férias ativas encontrado.</td>
                                </tr>
                                @endforelse
                            @endif
                        </tbody>
            </table>
           
        </div>
    @elseif($dados['st_tipo'] == 'licenca')
    <div class="col-md-12">
                            
                    <tr>
                        <th class="col-md-1">ORD</th>
                        <th class="col-md-1">POST/GRAD</th>
                        <th class="col-md-2">NUM/PRAÇA</th>
                        <th class="col-md-4">NOME</th>
                        <th class="col-md-1">MATRÍCULA</th>
                        <th class="col-md-1">QTD DE DIAS</th>
                        <th class="col-md-1">INÍCIO</th>
                        <th class="col-md-1">FIM</th>
                        <th class="col-md-2">TIPO</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($consulta))
                        @forelse($consulta as $f)
                        @php 
                            $contador = $contador+1;
                        @endphp
                        <tr>
                            <th>{{$contador}}</th>
                            <th>{{$f->st_postograduacaosigla}}</th>
                            <th>{{$f->st_numpraca}}</th>
                            <th>{{$f->st_nome}}</th>
                            <th>{{$f->st_matricula}}</th>
                            <th>{{$f->nu_dias}}</th>
                            <th>{{\Carbon\Carbon::parse($f->dt_inicio)->format('d/m/Y')}}</th>
                            <th>{{\Carbon\Carbon::parse($f->dt_fim)->format('d/m/Y')}}</th>
                            <th>{{$f->st_tipoLicenca}}</th>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Nenhum policial com licença ativas encontrado.</td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
          
            
        </div>
    @else
    <div class="col-md-12">
           
                    <tr>
                        <th class="col-md-1">ORD</th>
                        <th class="col-md-1">POST/GRAD</th>
                        <th class="col-md-2">NUM/PRAÇA</th>
                        <th class="col-md-4">NOME</th>
                        <th class="col-md-2">MATRÍCULA</th>
                        <th class="col-md-4">UNIDADE</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @if(isset($consulta))
                        @forelse($consulta as $f)
                        @php 
                            $contador = $contador+1;
                        @endphp
                        <tr>
                            <th>{{$contador}}</th>
                            <th>{{$f->st_postograduacaosigla}}</th>
                            <th>{{$f->st_numpraca}}</th>
                            <th>{{$f->st_nome}}</th>
                            <th>{{$f->st_matricula}}</th>
                            <th>{{$f->st_nomepais}}</th>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Nenhum policial encontrado com as matrículas informadas.</td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
          
            
        </div>

    @endif

@endif





    
</div>







<script>
$('#st_tipo').on('change', function() {
    if( this.value == 'unidade'){
        $('#dt_inicio').hide();
        $('#dt_inicio').remove('required');
        $('#dt_final').hide();
        $('#dt_final').remove('required');
    }else{
        $( '#'+$( this ).val() ).show('fast').attr('required', 'required');;
        $('#dt_inicio').show();
        $('#dt_inicio').attr('required', 'required');
        $('#dt_final').attr('required', 'required');
    }
  });
</script>


    

@stop

@section('scripts')
    <script>

  
        $(document).ready(function(){
         if($('#st_tipo').val() == 'unidade'){
             $('#dt_inicio').hide();
             $('#dt_final').hide();
         }
        });


    $('#st_tipo').on('change', function() {
    if( this.value == 'unidade'){
        $('#dt_inicio').hide();
        $('#dt_inicio').remove('required');
        $('#dt_final').hide();
        $('#dt_final').remove('required');
    }else{
        $( '#'+$( this ).val() ).show('fast').attr('required', 'required');;
        $('#dt_inicio').show();
        $('#dt_final').show();
        $('#dt_inicio').attr('required', 'required');
        $('#dt_final').attr('required', 'required');
    }
  });


    </script>


@stop



