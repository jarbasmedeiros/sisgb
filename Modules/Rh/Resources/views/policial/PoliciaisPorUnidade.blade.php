@extends('adminlte::page')
@section('title', 'Sumário de policiais')
@section('content')


<div class="container-fluid">
    <div class="row">
    <form method="get" action="{{url('rh/sumario/paginado')}}">
    {{csrf_field()}}
             <select class="form-control select2" name="ce_unidade"  data-placeholder="Selecione a unidade" style="width: 90%;" required>
                      
                        <option value="">Selecione a unidade </option>
                        @foreach($unidades as  $u)
                        <option value="{{$u->id}}">{{$u->st_nomepais}}</option>
                        @endforeach
            </select>
            <button type="submit" class="btn btn-primary" class="fa fa-search"  ><span></span> Consultar</button>
        </form>    
        <table class="table table-bordered">
            <thead>
               
                <tr class="bg-primary">
                    <th colspan = "7">SUMÁRIO</th>
                        
                            <div class="col-md-1">
                </thead>
                            <thead>
                            <th class="col-md-1">GRADUAÇÃO</th>
                                <th class="col-md-1">TOTAL</th>
                                @can('Edita')
                                <th class="col-md-1">AÇÕES</th>
                                @endcan
                            </thead>
                           <tbody>
                                @if(isset($policiaisagrupados))
                                    @forelse($policiaisagrupados as $a)
                                    <tr>
                                      <td>{{$a->st_postograduacao}}</td>
                                        <td>{{$a->total}}</td>

                                          @can('Edita')
                                        <th>
                                            <a href="{{url('rh/policiais/listaPoliciais/'.$a->ce_graduacao.'/unidade/'.$idUnidade.'/listagem')}}"  class='btn btn-primary fa fa-eye' title='Exibir'></a>
                                        </th>
                                        @endcan
                                      </tr>
                                    @empty
                                   <tr>
                                        <td colspan="10">Nenhum policial encontrado.</td>
                                    </tr>
                                    @endforelse
                                @endif
                            </tbody>                     
                            @stop               
@section('css')
    <style>
        th, td{text-align: center;}
        #a-voltar {margin-left: 10px;}
    </style>
@stop
