@extends('rh::policial.Form_edita_policial')
@section('title', 'SISGP - Fichas')

@section('css')
<style>
    .mt-30 {
        margin-top: 30px;
    }
    .mr-30 {
        margin-right: 30px;
    }
</style>
@endsection

@section('tabcontent')
<div class="tab-pane active" id="publicacoes">
    <h4 class="tab-title">Fichas - {{ $policial->st_nome}}</h4>
    <hr class="separador">
    {{ csrf_field() }}
    <div class="row">
        <div class="content">
            <div class="row">
                <div class="col-md-12 well">
                    @if(auth()->user()->can('Edita') || auth()->user()->can('CONSULTA_QUALQUER _UNIDADE'))
                        @if($policial->ce_graduacao < 8 )
                            <div class="col-md-3">
                                <a href='{{url("rh/policiais/".$policial->id."/fichaDisciplinarPdf")}}' target="_blank" class="btn btn-primary col-md-12" title="PDF">
                                    <i class="fa fa-file-pdf-o"></i> Ficha Disciplinar
                                </a> 
                            </div>
                        @endif
                    @endif
                    <div class="col-md-3">
                        <a href='{{url("rh/policiais/".$policial->id."/cadernetaDeRegistro")}}' target="_blank" class="btn btn-primary col-md-12" title="PDF">
                            <i class="fa fa-file-pdf-o"></i> Caderneta de Registros (CR)
                        </a> 
                    </div>
                    @can('PUBLICACOES_RESERVADAS')
                        <div class="col-md-3">
                            <a href='{{route('geraCadernetaDeRegistroReservadoPdf', $policial->id)}}' target="_blank" class="btn btn-primary col-md-12" title="PDF">
                                <i class="fa fa-file-pdf-o"></i> Caderneta de Registros Reservados (CR-R)
                            </a> 
                        </div>
                    @endcan
                    @can('Admin')
                        {{-- variável para saber que a certidão de tempo de serviço existe --}}
                        @php $CTS = true; @endphp
                        @if (isset($regrasFichas->assinaturas) && count($regrasFichas->assinaturas) == 2)
                            <div class="col-md-3">
                                <a href='{{route('geraCertidaoDeTempoDeServicoPdf', $policial->id)}}' target="_blank" class="btn btn-primary col-md-12" title="PDF">
                                    <i class="fa fa-file-pdf-o"></i> Certidão de Tempo de Serviço
                                </a> 
                            </div>
                        @else
                            <div class="col-md-3">
                                <a target="_blank" class="btn btn-warning col-md-12" title="Aguardando Assinaturas">
                                    <i class="fa fa-file-pdf-o"></i> Certidão de Tempo de Serviço
                                </a> 
                            </div>
                        @endif
                    @endcan
                    @can('ABA_DEPENDENTES')
                        {{-- se a certidão existe e foi setada para true, o botão extratos de assentamentos recebe uma margem superior de 30px --}}
                        @if (isset($CTS) && $CTS == true)
                            <div class="col-md-3 mt-30">
                        {{-- se não, ele não recebe margem --}}
                        @else
                            <div class="col-md-3">
                        @endif
                            <a href='{{route('geraExtratoDeAssentamentosPdf', $policial->id)}}' target="_blank" class="btn btn-primary col-md-12" title="PDF">
                                <i class="fa fa-file-pdf-o"></i> Extrato de Assentamentos
                            </a> 
                        </div>
                    @endcan
                </div>
            </div> 
        </div>
    </div>
</div>




@endsection