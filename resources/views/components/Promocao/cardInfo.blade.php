  <fieldset class="scheduler-border">
  <legend class="scheduler-border">Visão Geral</legend>
  <br>
 
    @component('components.dash.infoBox.infoBoxAqua')

        @slot('iconeCard')
            <i class="ion ion-pie-graph"></i>
        @endslot
        @slot('valorCard')
            {{$dadosDash->contadores->policiais_no_qa}}
        @endslot
        @slot('tituloCard')
            Cadastradas
        @endslot
        @slot('linkCard')
            <a href="#" id="idCard1" data-toggle="modal" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
        @endslot
    @endcomponent

    @component('components.dash.infoBox.infoBoxYellow')
        @slot('iconeCard')
            <i class="fa fa-send"></i>
        @endslot
        @slot('valorCard')
            {{$dadosDash->contadores->fichas_enviadas}} Enviadas
        @endslot
        @slot('tituloCard')
        {{$dadosDash->contadores->fichas_nao_enviadas}} Não enviadas
        @endslot
        @slot('linkCard')
            <a href="#" id="idCard2" data-toggle="modal" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
        @endslot
    @endcomponent
 
    @component('components.dash.infoBox.infoBoxGreen')
        @slot('iconeCard')
            <i class="fa fa-check-square-o"></i>
        @endslot
        @slot('valorCard')
            {{$dadosDash->contadores->fichas_enviadas_homologadas}} Homologadas
        @endslot
        @slot('tituloCard')
            {{$dadosDash->contadores->fichas_enviadas_nao_homologadas}} Não homologadas
        @endslot
        @slot('linkCard')
            <a href="#" id="idCard2" data-toggle="modal" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
        @endslot
    @endcomponent


    @component('components.dash.infoBox.infoBoxRed')
        @slot('iconeCard')
            <i class="fa fa-balance-scale"></i>
        @endslot
        @slot('valorCard')
            {{$dadosDash->contadores->fichas_recurso_analisado}} Analisados
        @endslot
        @slot('tituloCard')
            {{$dadosDash->contadores->fichas_recurso}} Recursos /  
            {{$dadosDash->contadores->fichas_recurso_enviado}} Não Analisados
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















 