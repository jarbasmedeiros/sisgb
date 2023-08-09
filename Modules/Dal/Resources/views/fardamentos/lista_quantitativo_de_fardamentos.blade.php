@extends('adminlte::page')

@section('title', 'Quantitativo de Fardamentos')

@section('css')
<style>
    fieldset { margin: 15px; }
    #voltar { margin-left: 30px; 
                       margin-bottom: 15px; }
    .mt5 {margin-top: 5px;}
    .mtb10 {margin-top: 10px;
           margin-bottom: 10px;}
    th, td { text-align: center; }
</style>
@stop

@section('content')

<div class="content-fluid">
    <div class="row">
        <div class="panel panel-primary">

            <form action="{{url('dal/fardamentos/quantitativo/lista')}}" class="form-horizontal" method="POST">
                {{ csrf_field() }}
                <div class="form-inline{{ $errors->has('ce_unidade') ? ' has-error' : '' }}">
                    <div class="col-md-8 mtb10">
                        <select class="form-control select2" name="ce_unidade[]" data-placeholder="Selecione a unidade" style="width: 100%;" required>
                            <option value=""></option>
                            <option value="subordinadas">Todas as Unidade Subordinadas</option>    
                            @foreach($unidades as $u)
                                <option value="{{$u->id}}">{!!$u->st_nomepais!!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  
                <div class="col-md-2 mtb10">
                    <button type="submit" class="btn btn-primary form-inline"><span class="fa fa-search"></span> Consultar</button>
                </div>                                                                                                                          
            </form>     

            <div class="col-md-2 mtb10">
                <form action="{{url('dal/fardamentos/quantitativo/pdf')}}" method="POST" class="form" target="_blank" >
                {{ csrf_field() }}
                @if(isset($dados))
                    @foreach($dados['ce_unidade'] as $d)
                            <input type="hidden" name="ce_unidade[]" value="{{$d}}">    
                    @endforeach
                @endif
                    <button type="submit" class="form btn btn-primary" ><span class="fa fa-file-pdf-o"></span> Imprimir PDF</button>
                </form>
            </div>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border"> 
                    @if(isset($unidadeConsultada) & $unidadeConsultada == 'todas')
                        <span class="text-center"> Quantitativo de Fardamentos de Todas as Unidades </span>
                    @elseif(isset($unidadeConsultada))
                        <span class="text-center"> Quantitativo de Fardamentos - {{$unidadeConsultada}} </span>
                    @endif
                </legend>
                <div class="col-md-12 mt5">
                    @if(isset($quantitativoFardamentos))
                        <div class="col-md-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="2"> Coberturas </th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-1">Tamanho</th>
                                        <th class="col-md-1">Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($quantitativoFardamentos->cobertura as $c)
                                        <tr>
                                            <td>{{ $c->st_cobertura }}</td>
                                            <td>{{ $c->qtd_cobertura }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Nenhum cadastro de quantidade de cobertura encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="2"> Gandolas e Canículas </th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-1">Tamanho</th>
                                        <th class="col-md-1">Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($quantitativoFardamentos->gandolacanicola as $g)
                                        <tr>
                                            <td>{{ $g->st_gandolacanicola }}</td>
                                            <td>{{ $g->qtd_gandolacanicola }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Nenhum cadastro de quantidade de Gandolas e Canículas encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="2"> Camisas Internas </th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-1">Tamanho</th>
                                        <th class="col-md-1">Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($quantitativoFardamentos->camisainterna as $c)
                                        <tr>
                                            <td>{{ $c->st_camisainterna }}</td>
                                            <td>{{ $c->qtd_camisainterna }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Nenhum cadastro de quantidade de Camisas Internas encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="2"> Calças e Saias </th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-1">Tamanho</th>
                                        <th class="col-md-1">Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($quantitativoFardamentos->calcasaia as $c)
                                        <tr>
                                            <td>{{ $c->st_calcasaia }}</td>
                                            <td>{{ $c->qtd_calcasaia }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Nenhum cadastro de quantidade de Calças e Saias encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="2"> Coturnos e Sapatos </th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-1">Tamanho</th>
                                        <th class="col-md-1">Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($quantitativoFardamentos->coturnosapato as $c)
                                        <tr>
                                            <td>{{ $c->st_coturnosapato }}</td>
                                            <td>{{ $c->qtd_coturnosapato }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Nenhum cadastro de quantidade de Coturnos e Sapatos encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="2"> Cintos </th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-1">Tamanho</th>
                                        <th class="col-md-1">Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($quantitativoFardamentos->cinto as $g)
                                        <tr>
                                            <td>{{ $g->st_cinto }}</td>
                                            <td>{{ $g->qtd_cinto }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Nenhum cadastro de quantidade de Cintos encontrado.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </fieldset>

            <div class="row">
                <a href="{{ url('/') }}" id="voltar" class="btn btn-warning">
                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                </a>                                                           
            </div>

        </div>
    </div>
</div>

@stop

