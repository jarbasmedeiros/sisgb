@extends('adminlte::page')

@section('title', 'Dashboard do DPS')
@can('Administrador')
@section('content_header')
<!--
    <a href="{{url('rh/orgao/create1')}}"><h1 class="btn btn-primary">Novo Órgão</h1></a>
    <a href="{{url('rh/orgaos/pdf')}}"><h1 class="btn btn-primary"><i class="fa fa-fw fa-print"></i> Imprimir listagem</h1></a>
    -->
@stop
@endcan

@section('content')
    <div class="content">
      <div class="row">
        <section class="content-header">
        <h1>
          Dashboard
          <small>Diretoria de Proteção Social</small>
        </h1>
        </section>
        <section class="content" style="height: auto !important; min-height: 0px !important;">

       
        <!-- Small boxes (Stat box) -->
        <fieldset class="scheduler-border">
        <legend class="scheduler-border">Estatísticas do pessoal inativo</legend>
        </br>
       
          <div class="row bg-light">
        
            <!-- ./col -->
            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{$dashboard->nu_inativos_total}}</h3>

                  <p>Inativos</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                @if($dashboard->nu_inativos_total >0)
                <a href="{{url('/dps/dash/prontuarios/inativos')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @else 
                <a href="#" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @endif
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                <h3>{{$dashboard->nu_inativos_reserva}}</h3>

                  <p>Reserva Remunerada</p>
                </div>
                <div class="icon">
                  <i class="fa fa-bed"></i>
                </div>
                @if($dashboard->nu_inativos_reserva >0)
                <a href="{{url('/dps/dash/prontuarios/reserva')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @else 
                <a href="#" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @endif
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{$dashboard->nu_inativos_reformados}}</h3>

                  <p>Reformados</p>
                </div>
                <div class="icon">
                  <i class="fa fa-wheelchair"></i>
                </div>
                @if($dashboard->nu_inativos_reformados >0)
                <a href="{{url('/dps/dash/prontuarios/reformados')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @else 
                <a href="#" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @endif
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                <h3>{{$dashboard->nu_inativos_mortos}}</h3>

                  <p>Falecidos</p>
                </div>
                <div class="icon">
                  <i class="fa fa-frown-o"></i>
                </div>
                @if($dashboard->nu_inativos_mortos >0)
                <a href="{{url('/dps/dash/prontuarios/mortos')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @else 
                <a href="#" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @endif
              </div>
            </div>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-gray">
                <div class="inner">
                  <h3>{{$dashboard->nu_inativos_outros}}</h3>

                  <p>Outros</p>
                </div>
                <div class="icon">
                  <i class="fa fa-chain-broken"></i>
                </div>
                
                @if($dashboard->inativos_outros>0)
                  <a href="#" id="outrosID" data-toggle="modal" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @else 
                  <a href="#" id="outrosID" data-toggle="modal" class="small-box-footer" >Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @endif
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
      </div>      
    <fieldset>
    
   
    
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Agendamento de Prova de Vida dos Inativos</legend>
      <br>    

    <!-- TABLE: LATEST ORDERS -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Agendamento de Prova de Vida dos Inativos - @php echo date("Y"); @endphp</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <!-- /.box-header -->

    {{-- Modal de outros --}}
  @component('components.modal.modalPadrao')
    @slot('tituloModal')
      DETALHAMENTO DOS OUTROS STATUS
    @endslot
    @slot('modalId')
      {{'modalIdDashDJD'}}
    @endslot
    <table class="table table-condensed">
        <tbody>
            <tr>
              <th style="width: 10px"></th>
              <th>Motivos de inatividade</th>
              <th style="width: 40px; align-items: center;">Quantidade</th>
            </tr>
            @if(isset($dashboard->inativos_outros)&& count($dashboard->inativos_outros)>0)
              @foreach($dashboard->inativos_outros as $value)
                <tr>
                  <td></td>
                  <td>{{$value->st_motivoinatividade}}</td>
                  <td style="text-align: center;">{{$value->nu_qtd}}<span class="badge badge-primary"></span></td>                      
                </tr>
              @endforeach
            @endif                      
        </tbody>
      </table>  
  @endcomponent
    



    <div class="box-body">
      <script src="{{ asset('js/charjs-3-7-0.js') }}"></script>

      <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


      <canvas id="myChart" width="400" height="150"></canvas>

      <script>

        $("#outrosID").click(function(){
          $("#modalIdDashDJD").modal();
        });

            var canvas = document.getElementById("myChart");
            var ctx = canvas.getContext("2d");

            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                      @foreach($dashboard->prova_vida_por_mes as $dados)
                        @php echo "'".$dados->st_mes."',"; @endphp
                      @endforeach
                    ],
                    datasets: [
                {
                  label               : 'Agendados',
                  borderColor         : 'rgba(30, 112, 204, 1)',
                  backgroundColor     : 'rgba(30, 112, 204, 1)',
                  data                : [
                  
                    @foreach($dashboard->prova_vida_por_mes as $dados)
                    @php echo $dados->nu_agendados.','; @endphp
                    @endforeach

                  ]
                },
                {
                  label               : 'Realizados',
                  borderColor         : 'rgba(30, 204, 85, 1)',
                  backgroundColor     : 'rgba(30, 204, 85, 1)',
                  data                : [
                  
                  @foreach($dashboard->prova_vida_por_mes as $dados)
                  @php echo $dados->nu_realizados.','; @endphp
                  @endforeach

                  ]
                },
                {
                  label               : 'Pendentes',
                  borderColor         : 'rgba(204, 30, 42, 1)',
                  backgroundColor     : 'rgba(204, 30, 42, 1)',
                  data                : [
                  
                  @foreach($dashboard->prova_vida_por_mes as $dados)
                  @php echo $dados->nu_pendentes.','; @endphp
                  @endforeach

                  ]
                }
              ]
                },
                options: {
                  responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },


                onClick:function(e){
            /*var activePoints = myChart.getElementsAtEvent(e);
            var selectedIndex = activePoints[0]._index; */
            /* alert(this.data.datasets[0].data[selectedIndex]);
            console.log(this.data.datasets[0].data[selectedIndex]);
            */
                }



            });


            document.getElementById("myChart").onclick = function (evt) {
                var activePoints = myChart.getElementsAtEventForMode(evt, 'point', myChart.options);
                var firstPoint = activePoints[0];
                var datasetIndex = firstPoint.datasetIndex;
                var indexmes = firstPoint.index+1;//api de jazon mes começa do 1
                var nameMes = nomeMes(firstPoint.index);
                var situacao = firstPoint.element.$context.dataset.label;
                //var label = myChart.data.labels[firstPoint._index];
                //var value = myChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
                //alert(label + ": " + value);
                //alert(firstPoint.element.$context.dataset.label);
                //console.log(indexmes);
                location.href = 'agendamentos/'+situacao.toLowerCase()+'/'+indexmes, '_blank';
            };


            function nomeMes(index){
              switch (index) {
                case 0:
                  return 'Janeiro';
                  break;

                case 1:
                  return 'Fevereiro';
                  break;

                case 2:
                  return 'Março';
                  break;

                case 3:
                  return 'Abril';
                  break;

                case 4:
                  return 'Maio';
                  break;

                case 5:
                  return 'Junho';
                  break;

                case 6:
                  return 'Julho';
                  break;

                case 7:
                  return 'Agosto';
                  break;

                case 8:
                  return 'Setembro';
                  break;

                case 9:
                  return 'Outubro';
                  break;

                case 10:
                  return 'Novembro';
                  break;

                case 11:
                  return 'Dezembro';
                  break;

                default:
                  break;
              }
            }  
      </script>       
    </div>     


  <!-- fim do grafico -->


    

    

@stop