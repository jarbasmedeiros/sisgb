@section('css')
<style>
    h4 { margin-left: 15px; }
    fieldset { margin: 15px; }
    #voltar, #salvar { margin-left: 30px; 
                       margin-bottom: 15px; }
    .mt5 {margin-top: 5px;}
    .m5 {margin: 5px 0px;}
    .centraliza-texto {text-align: center;}
    th, td { text-align: center; }
    .borda{border: 1px solid #B0C4DE;}
    .center
    {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@endsection

@extends('rh::policial.Form_edita_policial')

@section('title', 'SISGP - Uniformes')

@section('tabcontent')

<div class="tab-pane active" id="uniformes">
    <h4 class="tab-title">Uniformes - {{ $policial->st_nome }}</h4>
    <hr class="separador">
    <fieldset class="scheduler-border">
    <legend class="scheduler-border">Tamanho do Fardamento</legend>
        <div class="row">
            <div class="form-group col-md-2">
                <label for="st_cobertura">Cobertura <br> ( cm )</label>
                <input class="form-control" id="st_cobertura" name="st_cobertura" style="width: 100%;" value="{{$policial->st_cobertura or ''}}" readonly>           
            </div>
            <div class="form-group col-md-2">
                <label for="st_gandolacanicola">Gandola e Canícula (numeração)</label>
                <input class="form-control" id="st_gandolacanicola" name="st_gandolacanicola" style="width: 100%;" value="{{$policial->st_gandolacanicola or ''}}" readonly>           
            </div>
            <div class="form-group col-md-2">
                <label for="st_camisainterna">Camisa Interna </br></br></label>
                <input class="form-control" id="st_camisainterna" name="st_camisainterna" style="width: 100%;" value="{{$policial->st_camisainterna or ''}}" readonly>           
            </div>
            <div class="form-group col-md-2">
                <label for="st_calcasaia">Calça e Saia <br>(numeração)</label>
                <input class="form-control" id="st_calcasaia" name="st_calcasaia" style="width: 100%;" value="{{$policial->st_calcasaia or ''}}" readonly>           
            </div>
            <div class="form-group col-md-2">
                <label for="st_coturnosapato">Coturno e Sapato <br>(numeração)</label>
                <input class="form-control" id="st_coturnosapato" name="st_coturnosapato" style="width: 100%;" value="{{$policial->st_coturnosapato or ''}}" readonly>           
            </div>
            <div class="form-group col-md-2">
                <label for="st_cinto">Cinto <br>( cm )</label>
                <input class="form-control" id="st_cinto" name="st_cinto" style="width: 100%;" value="{{$policial->st_cinto or ''}}" readonly>           
            </div>
        </div>
    </fieldset>
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Fardamentos Recebidos</legend>
        <div class="col-md-12 mt5">
            @if(isset($cautelasFardamento) & count($cautelasFardamento) > 0)
            @php $idAnterior = -1 @endphp
            @foreach($cautelasFardamento as $c)
                @if($c->id != $idAnterior)
                <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th colspan="12" class="centraliza-texto">Cautela {{$c->st_numsequencial}}/{{$c->st_ano}}. Realizada em {{\Carbon\Carbon::parse($c->dt_entrega)->format('d/m/Y')}}</th>
                            </tr>
                            @php $count = 0 @endphp
                            <tr>
                                <th class="col-md-1">ORD</th>
                                <th class="col-md-1">TIPO</th>
                                <th class="col-md-2">ENTREGA</th>
                                <th class="col-md-4">DESCRIÇÃO</th>
                                <th class="col-md-1">MATERIAL</th>
                                <th class="col-md-1">MODELO</th>
                                <th class="col-md-1">TAMANHO</th>
                                <th class="col-md-1">QUANTIDADE</th>
                            </tr>
                        </thead>
                    @endif
                        <tbody>
                            @php $count++ @endphp
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$c->st_tipo}}</td>
                                <td>{{\Carbon\Carbon::parse($c->dt_entrega)->format('d/m/Y')}}</td>
                                <td>{{$c->st_descricao}}</td>
                                <td>{{$c->st_material}}</td>
                                <td>{{$c->st_modelo}}</td>
                                <td>{{$c->st_tamanho}}</td>
                                <td>{{$c->nu_quantidade}}</td>
                            </tr>
                        </tbody>
                        @php $idAnterior = $c->id @endphp
                @endforeach
            @else
                <tr>
                    <td class="centraliza-texto">Nenhuma cautela de fardamento encontrada.</td>
                </tr>
            @endif
            </table>
        </div>
    </fieldset>
</div>

@endsection
