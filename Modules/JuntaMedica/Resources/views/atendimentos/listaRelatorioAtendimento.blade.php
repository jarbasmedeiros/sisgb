@extends('adminlte::page')
@section('title', 'LISTA DE ATENDIMENTO JPMS')
@section('content')
<div class="container-fluid">
    <div class="row">
         <div class="scheduler-border">
              <table class="table table-bordered">
                             <thead>
                                <tr class="bg-primary">
                                
                                    <th colspan = "5">LISTA DE ATENDIMENTOS CONCLUÍDOS JPMS </th>                            
                                   
                                        <div class="md-9">
                                            <form  class="form-horizontal" role="form" action="{{url('juntamedica/relatorio/atendimentos/listagem/atendimento/excel') }}" method="get">   
                                                {{csrf_field()}}                
                                                @if (isset($dadosForm))
                                                  @foreach($dadosForm['ce_cid'] as $d)
                                                   
                                                        <input type="hidden" name="ce_cid[]" value="{{$d}}">
                                                    @endforeach  
                                                        <input type="hidden" name="dt_inicio" value="{{$dadosForm['dt_inicio']}}">
                                                        <input type="hidden" name="dt_termino" value="{{$dadosForm['dt_termino']}}">
                                                @endif
                                                <button type="submit" class="btn btn-primary" title="Baixar Excel"><span class="fa fa-file-excel-o"></span> Excel</button>                                                                                        
                                            </form>
                                        </div>
                                   
                                </tr>
                                    <tr>
                                        <th class="col-md-4">Post.Grad</th>
                                        <th class="col-md-4">Unidade</th>
                                        <th class="col-md-4">Nome</th>
                                        <th class="col-md-4">Matricula</th>
                                        <th class="col-md-4">Data de Nascimento</th>
                                        <th class="col-md-4">CID</th>
                                        
                                    </tr>
                            </thead>
                            
                            <tbody>
                            
                                @if(isset($dados))
                                    @forelse($dados as $a)
                                    <tr>
                                        <td>{{$a->st_postograduacao}}</td>
                                        <td>{{$a->st_unidade}}</td>
                                        <td>{{$a->st_nome}}</td>
                                        <td>{{$a->st_matricula}}</td>
                                        <td>{{\Carbon\Carbon::parse($a->dt_nascimento)->format('d/m/Y')}}</td>
                                        <td>{{$a->st_cid}}</td>
                                       
                                       
                                    </tr>
                                    @empty
                                   <tr>
                                        <td colspan="10">Nenhum atendimento encontrado.</td>
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


                           
