
@component('components.dash.box')
    @slot('tituloBox')
        Novos Procedimentos Instaurados
    @endslot
    <div class="table-responsive">
        <table class="table no-margin">
            <thead>
                    <tr>
                        <th>TIPO</th>   
                        <th>N° SEI</th>
                        <th>Origem</th>
                        <th>Encarregado</th>
                        <th>Unidade</th>
                    </tr>
            </thead>
            <tbody>         
                @if(isset($procedimentos) && count($procedimentos)>0)                   
                    @foreach($procedimentos as $value)
                        <tr>
                            <td>{{$value->st_tipo}}</td>
                            <td>{{$value->st_numsei}}</td>
                            <td>{{$value->st_origem}}</td>   
                            <td>{{$value->st_nomeencarregado}}</td> 
                            <td>{{$value->unidade->st_sigla}}</td>                                          
                        </tr>
                    @endforeach 
                @else
                    <tr>
                        <th colspan='5' class="text-center" style="font-weight: normal;">Nenhum procedimento instaurado recentemente.</th>
                    </tr>
                @endif
                
            </tbody>
        </table>
        </div>

    
@endcomponent   
