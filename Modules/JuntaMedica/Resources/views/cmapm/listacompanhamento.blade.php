@extends('adminlte::page')
@section('title', 'Relatorio de Acompanhamento JPMS')
@section('content')
<div class="container-fluid">
    <div class="row">
         <div class="scheduler-border">
              <table class="table table-bordered">
                             <thead>
                                <tr class="bg-primary">
                                    <th colspan = "5">LISTA DE POLICIAIS EM ACOMPANHAMENTO PELA JPMS </th>                            
                                        <th>
                                            <div class="md-9">
                                                <a href="{{url('juntamedica/listacompanhamentojpms/'.$idGraduacao.'/excel')}}" class="btn btn-primary" title="Gerar Excel">
                                                    <i class="fa fa-file-excel-o"></i> Gerar Excel
                                                </a>
                                            </div>
                                        </th> 
                                </tr>
                                    <tr>
                                        <th class="col-md-2">POST/GRAD</th>
                                        <th class="col-md-2">Número Praça</th>
                                        <th class="col-md-2">Matrícula</th>
                                        <th class="col-md-2">Cpf</th>
                                        <th class="col-md-4">Nome</th>
                                        <th class="col-md-4">Ações</th>
                                    </tr>
                            </thead>
                            
                            <tbody>
                            
                                @if(isset($policiaisEmAcompanhamento))
                                    @forelse($policiaisEmAcompanhamento as $a)
                                    <tr>
                                        <td>{{$a->st_postograduacaosigla}}</td>
                                            @if($a->ce_graduacao > 6)
                                            <td>{{$a->st_numpraca}}</td>
                                            @else
                                                <th></th>
                                            @endif
                                            <td>{{$a->st_matricula}}</td> 
                                            <td>{{$a->st_cpf}}</td>
                                            <td>{{$a->st_nome}}</td>
                                            @can('CMAPM')
                                            <th>
                                                 <a class="btn btn-primary" href="{{url('rh/policiais/edita/'.$a->id.'/dados_pessoais')}}">Abrir</a>
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
                </table>
                        <a href="javascript:history.back()" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar">
                                 <i class="glyphicon glyphicon-arrow-left"></i> Voltar
                        </a>
            </div>
          </div>
      </div>                   
@stop               


                           
