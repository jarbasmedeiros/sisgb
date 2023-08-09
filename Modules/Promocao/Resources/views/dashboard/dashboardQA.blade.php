@extends('adminlte::dashboardTemplate')


@section('title','Dashboard do Quadro de Acesso')

@section('conteudo')
    <div class="content-fluid">
        <div class="row">
                    <section class="content" style="height: auto !important; min-height: 0px !important;">
        
                        @component('components.Promocao.cardInfo',['dadosDash'=>$dadosDash])
                            
                        @endcomponent
                    </section>
                    <section class="content">
                            <div>
                                <div class="col-md-8">
                                    <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">???????????</legend>               
                                    <br>
                                    @component('components.Promocao.graphNovosProcedimentos',[]))
                                        
                                    @endcomponent
                                    <fieldset>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Resultado do Processamento</legend>
                                    <br>
                                    @component('components.Promocao.sideBar',['dadosDash'=>$dadosDash])
                                        
                                    @endcomponent
                                    </fieldset>
                                </div>
                            </div>                      
            </section>

        </div>
    </div>


 



@stop
