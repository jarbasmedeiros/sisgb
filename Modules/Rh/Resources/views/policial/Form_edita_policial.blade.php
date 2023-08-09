@extends('adminlte::page')

<!--@section('title', 'Edição do prontuário policial')-->

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Prontuário Policial </div>
                <div class="panel-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="{{ (Request::segment(5)=='dados_pessoais')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/dados_pessoais')}}" class="fa fa-user" > Dados Pessoais</a>
                            </li>
                            <li class="{{ (Request::segment(5)=='dados_funcionais')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/dados_funcionais')}}" class="fa fa-user-md" > Dados Funcionais</a>
                            </li>
                            @can('ABA_INATIVIDADE')
                             <li class="{{ (Request::segment(5)=='inatividade')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/inatividade')}}" class="fa fa-hotel" > Inatividade</a>
                            </li>
                            @endcan
                            @can('Admin')
                            <li class="{{ (Request::segment(5)=='tempo_servico')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/tempo_servico')}}" class="fa fa-hourglass-2" > Tempo Serviço</a>
                            </li>
                            @endcan
                            <li class="{{ (Request::segment(5)=='uniformes')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/uniformes')}}" class="fa fa-black-tie" > Uniformes</a>
                            </li>
                            <li class="{{ (Request::segment(5)=='documentos')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/documentos')}}" class="fa fa-server" > Documentos</a>
                            </li>
                            <li class="{{ (Request::segment(5)=='dados_academicos')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/dados_academicos')}}" class="fa fa-mortar-board" > Dados Acadêmicos</a> 
                            </li>
                            <li class="{{ (Request::segment(5)=='cursos')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/cursos')}}" class="fa fa-institution" > Cursos</a>
                            </li>
                            <li class="{{ (Request::segment(5)=='ferias')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/ferias')}}" class="fa  fa-calendar-plus-o" > Férias</a>
                            </li>
                            <li class="{{ (Request::segment(5)=='dados_medalhas')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/dados_medalhas')}}" class="fa fa-shield" > Medalhas</a>
                            </li>
                            <li class="{{ (Request::segment(5)=='licencas')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/licencas')}}" class="fa fa-calendar-check-o" > Licenças</a>
                            </li>
                            <li class="{{ (Request::segment(5)=='promocoes')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/promocoes/listagem')}}" class="fa fa-star-o" > Promoções</a>
                            </li>
                            <li class="{{ (Request::segment(5)=='pensionistas')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/pensionistas')}}" class="fa fa-users" > Pensionistas</a>
                            </li>
                            <!--TODO trocar a permissão pra quando for entrar em produção -->
                            @can('DASHBOARD_DPS')
                            @if($policial->bo_ativo == "1")
                            <li class="{{ (Request::segment(5)=='beneficiarios')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/beneficiarios')}}" class="fa fa-users" > Beneficiarios</a>
                            </li>
                            @endif
                            @endcan

                            <li class="{{ (Request::segment(5)=='comportamento')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/comportamento')}}"  class=" fa fa-asterisk" >Comportamento</a>
                            </li>

                            <li class="{{ (Request::segment(5)=='dependentes')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/dependentes')}}" class="fa fa-users"> Dependentes</a>
                            </li>
                            @can('Admin')
                            @if($policial->bo_ativo == "0")
                            <li class="{{ (Request::segment(5)=='provadevida')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/provadevida')}}" class="fa fa-heartbeat" > Prova de Vida</a>
                            </li>
                            @endif
                            @endcan
                            @if($policial->ce_graduacao > 7)
                            @can('PUBLICACOES_RESERVADAS')
                             <li class="{{ (Request::segment(4)=='punicoes')?'active':'' }}">
                                <a href="{{url('rh/policiais/'.$policial->id.'/punicoes')}}" class="fa  fa-legal" > Punições</a>
                            </li>
                            @endcan
                            @else
                            <li class="{{ (Request::segment(4)=='punicoes')?'active':'' }}">
                                <a href="{{url('rh/policiais/'.$policial->id.'/punicoes')}}" class="fa  fa-legal" > Punições</a>
                            </li>
                            @endif
                            <li class="{{ (Request::segment(5)=='procedimentos')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/procedimentos')}}" class="fa   fa-balance-scale" > Procedimentos</a>
                            </li>

                            <li class="{{ (Request::segment(4)=='publicacoes')?'active':'' }}">
                                <a href="{{url('rh/policiais/'.$policial->id.'/publicacoes/listagem')}}" class="fa fa-newspaper-o" > Publicações</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='movimentacoes')?'active':'' }}">
                                <a href="{{url('rh/policiais/'.$policial->id.'/movimentacoes/listagem')}}" class="fa fa-plane" > Movimentações</a>
                            </li>
                            @can('PUBLICACOES_RESERVADAS')
                            <li class="{{ (Request::segment(4)=='publicacoesreservadas')?'active':'' }}">
                            <a href="{{url('rh/policiais/'.$policial->id.'/publicacoesreservadas/listagem')}}" class="fa fa-newspaper-o" > Publicações Reservadas</a>
                            </li>
                            @endcan
                            @if(false)
                            <li class="{{ (Request::segment(4)=='movimentacoes')?'active':'' }}">
                                <a href="{{url('rh/policiais/'.$policial->id.'/movimentacoes')}}" class="fa fa-exchange" > Movimentações</a>
                            </li>
                            @endif
                            @can('Edita_rh')
                            <li class="{{ (Request::segment(4)=='arquivo')?'active':'' }}">
                                <a href="{{url('rh/policiais/'.$policial->id.'/arquivo/listagem')}}" class="fa fa-paperclip" > Arquivos</a>
                            </li>
                            @endcan
                            @if (auth()->user()->can('EMITIR_RG') || auth()->user()->can('IDENTIFICAR_PM'))
                                <li class="{{ (Request::segment(5)=='prontuario')?'active':'' }}">
                                    <a href="{{url('rh/policiais/'.$policial->id.'/rg/prontuario')}}" class="fa fa-credit-card" > Identidades</a>
                                </li>
                            @endif
                            <li class="{{ (Request::segment(4)=='fichas')?'active':'' }}">
                                <a href="{{url('rh/policiais/'.$policial->id.'/fichas')}}" class="fa fa-paperclip" > Fichas</a>
                            </li>
                            <li class="{{ (Request::segment(4)=='censoreligioso')?'active':'' }}">
                                <a href="{{url('rh/policiais/'.$policial->id.'/censoreligioso')}}" class="fa fa-paperclip" > Opção Religiosa</a>
                            </li>
                            @can('ABAS_DJD')
                            <li class="{{ (Request::segment(5)=='certidao')?'active':'' }}">
                                <a href="{{url('rh/policiais/edita/'.$policial->id.'/certidao')}}" class="fa fa-file-archive-o" > Certidões</a>
                            </li>
                            @endcan
                            
                        </ul>
                        <div class="tab-content">
                            @yield('tabcontent')
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection