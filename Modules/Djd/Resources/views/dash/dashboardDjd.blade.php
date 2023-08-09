@extends('adminlte::dashboardTemplate')


@section('title','Dashboard do DJD')
@can('Administrador')
@section('content_header')
<!--
    <a href="{{url('rh/orgao/create1')}}"><h1 class="btn btn-primary">Novo Órgão</h1></a>
    <a href="{{url('rh/orgaos/pdf')}}"><h1 class="btn btn-primary"><i class="fa fa-fw fa-print"></i> Imprimir listagem</h1></a>
    -->
@stop
@endcan

@section('conteudo')
    <div class="content">
        <div class="row">
            <section class="content" style="height: auto !important; min-height: 0px !important;">
 
                @component('components.DJD.cardInfo',['dadosDash'=>$dadosDash])
                    
                @endcomponent
            </section>
            <section class="content">
                    <div>
                        <div class="col-md-8">
                            <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Novos Procedimentos</legend>               
                            <br>
                            @component('components.DJD.graphNovosProcedimentos',['dadosDash'=>$dadosDash,'procedimentos'=>$procedimentos]))
                                
                            @endcomponent
                            <fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Total por tipo de Procedimento</legend>
                            <br>
                            @component('components.DJD.sideBar',['dadosDash'=>$dadosDash])
                                
                            @endcomponent
                            </fieldset>
                        </div>
                    </div>



                    
                </div>
            </section>

            
        </div>
    </div>


 



@stop
