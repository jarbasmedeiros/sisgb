<form action="{{ url('/rh/policial/edita/'.$policial->id.'/fardamentos/'.$renderizacao) }}" method="post" role="form">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    @include('rh::policial/formEditaFardamento')
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
    <div class="row text-center">     
        <button type="submit" id="salvar" class="btn btn-primary">
            <i class="fa fa-fw fa-save"></i> Salvar
        </button>                                            
    </div>
</form>