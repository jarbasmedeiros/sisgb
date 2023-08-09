@component('components.dash.infoBoxSideBar.infoBoxSideBarAqua')
    @slot('boxNum')
       {{$dadosDash->procedimentos_tipo_cj}}
    @endslot
    @slot('boxIcone')
        <i class="fa  fa-gavel"></i>
    @endslot
    @slot('boxText')
        CJ 
    @endslot
    @slot('boxDescription')
        Conselho de Justificação
    @endslot
@endcomponent

    @component('components.dash.infoBoxSideBar.infoBoxSideBarAqua')
    @slot('boxNum')
        {{$dadosDash->procedimentos_tipo_cd}}
    @endslot
    @slot('boxIcone')
        <i class="fa  fa-gavel"></i>
    @endslot
    @slot('boxText')
        CD
    @endslot
    @slot('boxDescription')
        Conselho de Disciplina
    @endslot
@endcomponent

@component('components.dash.infoBoxSideBar.infoBoxSideBarAqua')
    @slot('boxNum')
        {{$dadosDash->procedimentos_tipo_pad}}
    @endslot
    @slot('boxIcone')
        <i class="fa  fa-gavel"></i>
    @endslot
    @slot('boxText')
        PAD
    @endslot
    @slot('boxDescription')
        Processo Administrativo Disciplinar
    @endslot
@endcomponent

@component('components.dash.infoBoxSideBar.infoBoxSideBarYellow')
    @slot('boxNum')
        {{$dadosDash->procedimentos_tipo_pads}}
    @endslot
    @slot('boxIcone')
        <i class="fa fa-balance-scale"></i>
    @endslot
    @slot('boxText')
        PADS
    @endslot
    @slot('boxDescription')
        Processo Administrativo Disciplinas Sumário
    @endslot
@endcomponent



@component('components.dash.infoBoxSideBar.infoBoxSideBarYellow')
    @slot('boxNum')
        {{$dadosDash->procedimentos_tipo_ipm}}
    @endslot
    @slot('boxIcone')
        <i class="fa fa-balance-scale"></i>
    @endslot
    @slot('boxText')
        IPM
    @endslot
    @slot('boxDescription')
        Inquérito Policial Militar
    @endslot
@endcomponent

@component('components.dash.infoBoxSideBar.infoBoxSideBarYellow')
    @slot('boxNum')
        {{$dadosDash->procedimentos_tipo_sindicancia}}
    @endslot
    @slot('boxIcone')
        <i class="fa fa-balance-scale"></i>
    @endslot
    @slot('boxText')
        SINDICÂNCIA
    @endslot
    @slot('boxDescription')
        
    @endslot
@endcomponent
