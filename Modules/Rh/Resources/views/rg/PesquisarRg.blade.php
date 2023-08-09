@extends('adminlte::page')

@section('title', 'Pesquisa de RG')

@section('content')

             
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Pesquisa de Identidades</div>
                <div class="panel-body">
                    <form role="form" method="GET" action="{{ url('rh/rg/pesquisa') }}">
                        <div class="row">
                           <!--  <div class="form-group col-md-2">
                                <label for="st_filtro" class="control-label">Filtro</label>
                                <select id="st_filtro" name="st_filtro" class="form-control" required>
                                    <option value="CEDULA" >Cédula</option>
                                    <option value="RG" >Nª do RG</option>                        
                                </select>
                            </div> -->
                            <div class="form-group col-md-3">
                                <label for="st_criterio">Critério</label>                      
                                <input id="st_criterio" type="text" class="form-control" placeholder="Nº do RG ou da Cédula" name="st_criterio"  required> 
                            </div>
                            <div class="form-group col-md-1">
                                <label for="btnPesquisar"></label>
                                <button type="submit" id="btnSalvar"class="btn btn-primary" id="btnPesquisar"><i class="fa fa fa-search"></i> Pesquisar</button>   
                            </div>
                        </div>
                    </form>               
                    <fieldset class="scheduler-border">    	
                    <legend class="scheduler-border">Resultado da pesquisa</legend>
                        <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th colspan = "9">Listagem de Identidades</th>
                            </tr>
                            <tr>   
                                <th class = "col-md-1">Nº RG</th>
                                <th class = "col-md-1">Nº Cédula</th>
                                <th class = "col-md-3">Nome</th>
                            
                                <th class = "col-md-1">Mótivo</th>
                                <th class = "col-md-1">Impressao</th>
                                <th class = "col-md-1">Emissão</th>
                                <th class = "col-md-1">Entrega</th>
                                <th class = "col-md-1">Devolução</th>
                                
                                <th class = "col-md-1">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                    @if(isset($rgs))
                        @forelse($rgs as $rg)
                        <tr>
                            <td>{{$rg->st_rgmilitar}}</td>
                            <td>{{$rg->st_cedula}}</td>
                            <td>{{$rg->st_nome}}</td>
                            <td>{{$rg->st_motivo}}</td>                            
                            <td>{{$rg->st_impressao}}</td>                            
                            <td>{{$rg->dt_emissao}}</td>                            
                            <td>{{$rg->dt_entrega}}</td>                            
                            <td>{{$rg->dt_devolucao}}</td>                                                                                                                                                                                
                            <td>                                                               
                                <a class="btn btn-primary fa fa-eye" href="{{url('rh/policiais/'.$rg->ce_policial.'/rg/'.$rg->id.'/edit')}}" target="_blank" title="Abrir"><i ></i> </a> 
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">Nenhuma identidade encontrada</td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
            </fieldset>

        </div>
    </div>
</div>
              



@endsection