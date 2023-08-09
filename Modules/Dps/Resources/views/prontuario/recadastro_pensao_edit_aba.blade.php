@extends('dps::prontuario.abas_prontuario_pensionista')

@section('title', 'SISGP - Dados do Pensionista')

@section('tabcontent')

<div class="tab-pane active" id="dados_pensao">
    <div class="row">
        <div class="col-md-9">
            <h4 class="tab-title">Provas de Vida de {{ $dadosAba->pessoa->st_nome }}</h4>
        </div>
        <div style="" class="col-md-2">
            <div class="col-md-1" style='text-align: center;'>
                <a class="btn btn-primary" href="{{ URL::route('prontuario_pensionista', [
                    'pensionistaId' => $dadosAba->id,
                    'aba' => 'recadastro',
                    'acao' => 'editar'
                ]) }} ">
                    <i class="fa fa-plus fa-lg"></i> Nova Prova de Vida
                </a>                
            </div> 
        </div>
    </div>
    <hr class="separador">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">
                Provas de vida Realizadas
            </legend>
            <div class="row">
                <table class="table col-md-12">
                    <thead class="bg-primary">
                        <th>
                            Ano Referência
                        </th>
                        <th>
                            Data Recadastramento
                        </th>
                        <th>
                            Responsável
                        </th>
                        <th>
                            Unidade
                        </th>
                        <th class="col-md-2">
                            Ações
                        </th>
                    </thead>
                    <tbody>
                    @empty($provasDeVida)
                    @else
                        @foreach ($provasDeVida as $p)
                        <tr>
                            <td>                            
                                {{ $p->nu_ano }}
                            </td>
                            <td>
                                {{ date('d/m/Y H:m:s', strtotime($p->dt_cadastro)) }}
                            </td>
                            <td>
                                {{ $p->usuario->name }}
                            </td>
                            <td>
                                {{ $p->st_unidaderecadastramento }}
                            </td>
                            <td>
                                @if($p->st_tiporesponsavellegal == 'PENSIONISTA')
                                    @if(empty($p->st_comprovante))
                                        @if($p->nu_ano == date("Y"))
                                        <a target="_blank" data-toggle="tooltip" title="Comprovante de Recadastramento de Pensionista" class="btn btn-primary" href=" {{
                                            //URL::route('comprovante_pensionista')
                                            URL::route('prontuario_pensionista_id', [
                                                'idRegistro' => $p->id,
                                                'pensionistaId' => $dadosAba->id,
                                                'aba' => 'recadastro',
                                                'acao' => 'consultarRegistro'
                                            ])
                                        }}">
                                        <span class="icon fa fa-print fa-lg">
                                        </span>
                                        </a>

                                        <!-- UPLOAD QUANDO NAO TIVER ARQUIVO AINDA -->
                                        <a data-toggle="tooltip" title="Upload" class="btn btn-success" href="{{ URL::route('prontuario_pensionista_id', [
                                                    'pensionistaId' => $dadosAba->id,
                                                    'aba' => 'recadastro',
                                                    'acao' => 'listaupload',
                                                    'idRegistro' => $p->id
                                                ]) }}">
                                        <span class="icon fa fa-upload fa-lg">
                                        </span>
                                        </a>
                                        @endif
                                    @else
                                    <a target='_blank' data-toggle="tooltip" title="Comprovante de Recadastramento de Pensionista Por {{ $p->st_tiporesponsavellegal }}" class="btn btn-warning" href="{{ URL::route('prontuario_pensionista_id', [
                                            'pensionistaId' => $dadosAba->id,
                                            'aba' => 'recadastro',
                                            'acao' => 'consultarComprovante',
                                            'idRegistro' => $p->id
                                        ]) }}">
                                    <span class="icon fa fa-download fa-lg">
                                    </span>
                                    </a>
                                    @endif
                                @else
                                    @if($p->st_tiporesponsavellegal != 'PENSIONISTA' && !isset($p->st_comprovante))
                                        @if($p->nu_ano == date("Y"))
                                        <!-- UPLOAD QUANDO NAO PENSIONISTA -->
                                        <a data-toggle="tooltip" title="Upload" class="btn btn-success" href="{{ URL::route('prontuario_pensionista_id', [
                                                'pensionistaId' => $dadosAba->id,
                                                'aba' => 'recadastro',
                                                'acao' => 'listaupload',
                                                'idRegistro' => $p->id
                                            ]) }}">
                                        <span class="icon fa fa-upload fa-lg">
                                        </span>
                                        </a>
                                        @endif
                                    @elseif($p->st_tiporesponsavellegal != 'PENSIONISTA' && isset($p->st_comprovante)) 
                                        <a target='_blank' data-toggle="tooltip" title="Comprovante de Recadastramento de Pensionista Por {{ $p->st_tiporesponsavellegal }}" class="btn btn-warning" href="{{ URL::route('prontuario_pensionista_id', [
                                                'pensionistaId' => $dadosAba->id,
                                                'aba' => 'recadastro',
                                                'acao' => 'consultarComprovante',
                                                'idRegistro' => $p->id
                                            ]) }}">
                                        <span class="icon fa fa-download fa-lg">
                                        </span>
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endempty
                    </tbody>
                    <tfoot>
                    @empty($provasDeVida)
                        <td colspan="3">
                            <p class="col-md-12" style="text-align: center;">
                                <strong>
                                    Não há provas de vida cadastradas.
                                </strong>
                            </p>
                        </td>
                    @endempty
                    </tfoot>
                </table>
            </div>
        </fieldset>
</div>
<!-- /.tab-pane -->
@endsection