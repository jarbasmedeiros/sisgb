@extends('adminlte::page')

@section('title', 'Lista de Policiais')

@section('content')

<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="get" action='{{ url("rh/policiais/unidade/perfis/listagem") }}' >
                    <div class="form-group{{ $errors->has('st_assunto') ? ' has-error' : '' }} col-md-4">
                        <select id="ce_unidade" class="form-control"  name="ce_unidade"> 
                        <option value="" >Selecione</option>          
                         @foreach($unidadesFilhas as $u)
                        <option value="{{$u->id}}" >{{$u->st_nomepais}}</option>          
                         @endforeach
                        </select>
                        @if ($errors->has('st_assunto'))
                        <span class="help-block">
                            <strong>{{ $errors->first('st_assunto') }}</strong>
                        </span>
                        @endif
                    </div>                
                                             {{csrf_field()}}
                                            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>                                                                                        
            </form>
                <table class="table table-bordered">
                    <thead>
                    @php
                    $contador = 0;
                    $policialatual = null;
                    $perfil = null;
                   
                    
                    @endphp 
                        <tr class="bg-primary">
                      
                        <th colspan = "6">LISTA DE POLICIAIS  </th>
                        <th colspan = "1">
                            <form id="listaFuncionarioFilterExcel" class="form-horizontal" role="form" method="get" target="_blank" action='{{ url("rh/policiais/unidade/perfis/pdf") }}' >
                                @if(isset($idUnidade))
                                <input type="hidden" name="ce_unidade" value="{{$idUnidade}}" >
                                @endif
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-primary"><span class="fa fa file-pdf"></span> Gerar PDF</button>                                                                                        
                                    
                            </form>                                                                    
                        </th>
                        </tr>
                        <tr>
                            <th class="col-md-1">ORDEM</th>
                            <th class="col-md-1">POST/GRAD</th>
                            <th class="col-md-3">NOME</th>
                            <th class="col-md-1">MATRÍCULA</th>
                            <th class="col-md-1">CPF</th>
                            <th class="col-md-1">UNIDADE</th>
                            <th class="col-md-1">PERFIL</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    @php 
                    $cpf = preg_replace('/[^0-9]/', '', Auth::user()->st_cpf);
                    @endphp
                        @if(isset($policiais))
                            @forelse($policiais as $p)
                            @php 
                                $contador ++;
                            @endphp 
                            <tr>
                                <td>{{$contador}}</td>
                                <td>{{$p->st_postograduacaosigla}}</td>
                                <td>{{$p->st_nome}}</td>
                                <td>{{$p->st_matricula}}</td>
                                <td>{{$p->st_cpf}}</td>
                                <td>{{$p->st_unidade}}</td>
                                <td>
                                @php $contadorPerfil = 0; @endphp
                                    @if(!empty($p->st_perfil)) 
                                   
                                    @foreach($p->st_perfil->roles as $perfil)
                                    @php $contadorPerfil++ @endphp

                                    {{$perfil->st_nome}}@if($contadorPerfil < count($p->st_perfil->roles)),@endif 
                                    @endforeach
                                    @endif

                                </td>
                              
                          
                            
                            </tr>
                        
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">Nenhum policial encontrado.</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
                @if(isset($policiais) && count($policiais)>0 && (!is_array($policiais)))
                    {{$policiais->links()}}
                @endif
               
            </div>
        </div>
        <a href="javascript:history.back()" id="a-voltar" class="col-md-1 btn btn-warning"  title="Voltar">
                                 <i class="glyphicon glyphicon-arrow-left"></i> Voltar
                        </a>
    </div>
</div>
@stop






