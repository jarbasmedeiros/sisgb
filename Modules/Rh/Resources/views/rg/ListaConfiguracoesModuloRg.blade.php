@extends('adminlte::page')

@section('title', 'config RG')

@section('content')

             
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Parâmetros do módulo de identificação</div>
                <div class="panel-body">
                            
                   
                        <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th colspan = "12">Listagem de parâmetros da identificação</th>
                            </tr>
                            <tr>   
                                <th class = "col-md-2">Parâmetro</th>
                                <th class = "col-md-5">Valor</th>
                                <th class = "col-md-4">Observação</th>
                                <th class = "col-md-1">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                    @if(isset($configuracoes))
                        @forelse($configuracoes as $c)
                        <tr>
                            <form role="form" method="POST" action="{{ url('rh/rg/config/edit') }}">
                            {{ csrf_field() }}    
                                <td>
                                    <input id="st_chave" name="st_chave" type="hidden" class="form-control"   required value="{{$c->st_chave}}"> 
                                
                                {{$c->st_label}}</td>
                                <td>
                                    <input id="st_valor" name="st_valor" type="text" class="form-control" placeholder="Valor do parâmetro"   required value="{{$c->st_valor}}"> 
                                </td>
                                <td>
                                    <input id="st_obs" name="st_obs"  type="text" class="form-control" placeholder="Observação do parâmetro"  value="{{$c->st_obs}}"> 
                                    </td>                            
                                <td> 
                                    <button type="submit" id="btnSalvar" name="btnSalvar" class="btn btn-primary" ><i class="fa fa fa-save"></i> Salvar</button>                                                                 
                                </td>
                            </form>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">Nenhum parâmetro encontrado</td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
          

        </div>
    </div>
</div>
              



@endsection