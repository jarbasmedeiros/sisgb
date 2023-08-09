@component('components.dash.infoBoxSideBar.infoBoxSideBarGreen')
    @slot('boxNum')
       {{$dadosDash->contadores->fichas_sem_pendencias}}
    @endslot
    @slot('boxIcone')
        <i class="fa   fa-file-text-o"></i>
    @endslot
    @slot('boxText')
        Sem pendências
    @endslot
    @slot('boxDescription')
        Fichas de Reconhecimento
    @endslot
@endcomponent

    @component('components.dash.infoBoxSideBar.infoBoxSideBarRed')
    @slot('boxNum')
    {{$dadosDash->contadores->fichas_com_pendencias}}
    @endslot
    @slot('boxIcone')
        <i class="fa  fa-file-text-o"></i>
    @endslot
    @slot('boxText')
        Com pendências
    @endslot
    @slot('boxDescription')
        Fichas de Reconhecimento
    @endslot
@endcomponent





