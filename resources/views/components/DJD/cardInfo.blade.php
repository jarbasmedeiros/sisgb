  <fieldset class="scheduler-border">
  <legend class="scheduler-border">Total por Situação</legend>
  <br>
 
    @component('components.dash.infoBox.infoBoxAqua')

        @slot('iconeCard')
            <i class="ion ion-pie-graph"></i>
        @endslot
        @slot('valorCard')
            {{$dadosDash->procedimentos_instaurados}}
        @endslot
        @slot('tituloCard')
            Procedimentos
        @endslot
        @slot('linkCard')
            <a href="#" id="idCard1" data-toggle="modal" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
        @endslot
    @endcomponent

    @component('components.dash.infoBox.infoBoxGreen')
        @slot('iconeCard')
            <i class="fa fa-folder-open"></i>
        @endslot
        @slot('valorCard')
            {{$dadosDash->procedimentos_situacao_aberto}}
        @endslot
        @slot('tituloCard')
            Abertos
        @endslot
        @slot('linkCard')
            <a href="#" id="idCard2" data-toggle="modal" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
        @endslot


    @endcomponent

    
    @component('components.dash.infoBox.infoBoxYellow')
        @slot('iconeCard')
            <i class="fa fa-exclamation-triangle"></i>
        @endslot
        @slot('valorCard')
            {{$dadosDash->procedimentos_situacao_prorrogado}}
        @endslot
        @slot('tituloCard')
            Prorrogados
        @endslot
        @slot('linkCard')
            <a href="#" id="idCard2" data-toggle="modal" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
        @endslot


    @endcomponent


    @component('components.dash.infoBox.infoBoxRed')
        @slot('iconeCard')
            <i class="fa fa-hourglass-end"></i>
        @endslot
        @slot('valorCard')
            {{$dadosDash->procedimentos_situacao_atrasado}}
        @endslot
        @slot('tituloCard')
            Atrasados
        @endslot
        @slot('linkCard')
            <a href="#" id="idCard4" data-toggle="modal" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
        @endslot
        
    @endcomponent

 
    
</fieldset>


{{-- Chamando os modals dos cards --}}
{{-- @component('components.modal.modalPadrao')
    @slot('tituloModal')
        TITULO DO MODAL DO SEGUNDO CARD
    @endslot
    @slot('modalId')
        {{'modal2'}}
    @endslot
@endcomponent --}}















 