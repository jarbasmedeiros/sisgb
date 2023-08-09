@extends('adminlte::page')
@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
  <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
@stop
@section('title', 'Dashboard do RH')
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
          <small>Diretoria Pessoal</small>
        </h1>
        </section>
        <section class="content" style="height: auto !important; min-height: 0px !important;">

        <!-- Small boxes (Stat box) -->
        <fieldset class="scheduler-border">
        <legend class="scheduler-border">Estatísticas do Mapa de Força</legend>
        </br>
          <div class="row">
        
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                <h3>{{$dashboard->nu_ativos}}
                  @php 
                    $valor =   ($dashboard->nu_prontos/$dashboard->nu_ativos)*100;  
                    
                    $indiceDisponibilidade = round($valor,2);
                   
                  @endphp
                <sup style="font-size: 20px">Ativos</sup>
                </h3>

                <p> <strong>Índice de Disponibilidade {{$indiceDisponibilidade}} %</strong></p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                @if($dashboard->nu_ativos >0)
                <a href="{{url('#')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @else 
                <a href="#" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @endif
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                <h3>{{$dashboard->nu_prontos}}</h3>

                  <p>Prontos</p>
                </div>
                <div class="icon">
                  <i class="fa fa-group"></i>
                </div>
                @if($dashboard->nu_prontos >0)
                <a href="{{url('#')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @else 
                <a href="#" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @endif
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$dashboard->nu_junta}}</h3>

                  <p>Junta Médica</p>
                </div>
                <div class="icon">
                  <i class="fa fa-wheelchair"></i>
                </div>
                @if($dashboard->nu_junta >0)
                <a href="{{url('#')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @else 
                <a href="#" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @endif
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                <h3>{{$dashboard->nu_outros}}</h3>

                  <p>Outros</p>
                </div>
                <div class="icon">
                  <i class="fa fa-bed"></i>
                </div>
                @if($dashboard->nu_outros>0)
                  <a href="#" id="btn-mensagem" data-toggle="modal" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @else 
                  <a href="#" id="btn-mensagem" data-toggle="modal" class="small-box-footer" >Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
                @endif

              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
      </div>      
    <fieldset>

    {{-- Modal de outros --}}
    <div class="modal fade" id="modal-mensagem">
      <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header bg-primary">
                   <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                   <h4 class="modal-title">DETALHAMENTO DOS OUTROS STATUS </h4>
               </div>
               <div class="modal-body">
                   <table class="table table-condensed">
                      <tbody>
                          <tr>
                            <th style="width: 10px"></th>
                            <th>Status</th>
                            <th style="width: 40px; align-items: center;">Quantidade</th>
                          </tr>
                          @if(isset($dashboard->descricao_outros) &&count($dashboard->descricao_outros)>0)
                            @foreach($dashboard->descricao_outros as $value)
                              <tr>
                                <td></td>
                                <td>{{$value->st_status}}</td>

                                <td style="text-align: center;">{{$value->nu_qtd}}<span class="badge badge-primary"></span></td>                      
                              </tr>
                            @endforeach
                          @endif            
                      </tbody>
                  </table>  
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-primary center-block" data-dismiss="modal">Fechar</button>
               </div>
           </div>
       </div>
    </div>
       
    
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Estatística da Diretoria Pessoal</legend>
        </br>

        <!-------------------------------- Idade da tropa ----------------------------->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Quantitativo por Idade - @php echo date("Y"); @endphp</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
        
          <!-- grafico mapa de Força-->
          <div class="box-body">      
            <div id="chart_div3"></div>
          </div>          
        </div>

        <!-------------------------------- Tempo de serviço -------------------------------->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Quantitativo de Tempo de Serviço - @php echo date("Y"); @endphp</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
        
          <!-- grafico tempo de serviço-->
          <div class="box-body">      
            <div id="chart_div"></div>
          </div>
        </div>

        <!-------------------------------- Mapa de Força ----------------------------->
        <div class='row'>
          <div class='col-sm-6'>

            <!--  Gráfico dos Praças -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Quantitativo dos Praças por Graduação - @php echo date("Y"); @endphp</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
            
              <!-- grafico mapa de Força-->
              <div class="box-body">      
                <div id="chart_div2"></div>
              </div>          
            </div>
          </div>

          <div class='col-sm-6'>

            <!-- Gráfico dos Oficiais -->
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Quantitativo dos Oficiais por Posto - @php echo date("Y"); @endphp</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
              
                <!-- grafico mapa de Força-->
                <div class="box-body">      
                  <div id="chart_div5"></div>
                </div>          
              </div>
            </div>

          </div>
        </div>        

        <!-------------------------------- Sexo ----------------------------->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Quantitativo por Sexo - @php echo date("Y"); @endphp</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
        
          <!-- grafico mapa de Força-->
          <div class="box-body">      
            <div id="chart_div4" style="width: 500px"></div>
          </div>          
        </div>


    
    <fieldset>

      <!--Load the AJAX API-->
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">






        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

          //tempo de serviço
          var data_temposervico = new google.visualization.DataTable();
          data_temposervico.addColumn('string', 'Topping');
          data_temposervico.addColumn('number', 'Policiais');         
          data_temposervico.addRows([
          @foreach($dashboard->total_por_tempodeservico as $dados)
          @if($dados->nu_temposervico==1)
          ['{{$dados->nu_temposervico}} ano de serviço', {{$dados->nu_total}}],
          @else 
          ['{{$dados->nu_temposervico}} anos de serviço', {{$dados->nu_total}}],
          @endif
          @endforeach
          ]);

          //mapa força praça
          var data_graduacao = google.visualization.arrayToDataTable([
            ['Element', 'Quantitativo', { role: 'style' }],
            @foreach ($dashboard->total_por_graduacao as $dados)
              @if($dados->ce_graduacao<=7)
              ['{{$dados->st_postograduacaosigla}}', {{$dados->nu_total}}, 'green'],
              @endif
            @endforeach
          ]);

          //mapa força oficial
          var data_posto = google.visualization.arrayToDataTable([
            ['Element', 'Quantitativo', { role: 'style' }],
            @foreach ($dashboard->total_por_graduacao as $dados)
              @if($dados->ce_graduacao>7)
              ['{{$dados->st_postograduacaosigla}}', {{$dados->nu_total}}, 'green'],
              @endif
            @endforeach
          ]);

          //idade da tropa
          var data_idade = google.visualization.arrayToDataTable([
            ['Element', 'Quantitativo', { role: 'style' }],
            @foreach ($dashboard->total_por_idade as $dados)
              ['{{$dados->nu_idade}} anos de idade', {{$dados->nu_total}}, 'orange'],
            @endforeach
          ]);

          //sexo
          var data_sexo = google.visualization.arrayToDataTable([
            ['Element', 'Sexo'],
            @foreach($dashboard->total_por_sexo as $dados)
            ['{{$dados->st_sexo}}', {{$dados->nu_total}}],
            @endforeach
          ]);          

          // Tempo de serviço
          var options_temposervico = {
            'title':'Tempo de Serviço',
            'width':'auto', 
            'height':'auto',
            'legend':'left',
          };

          // mapa de força dos praças
          var options_graduacao = {
            'title':'Quantitativo dos Praças',
            'width':'auto', 
            'height':'auto',
            'legend':'left',
          };

          // mapa de força dos oficiais
          var options_posto = {
            'title':'Quantitativo dos Oficiais',
            'width':'auto', 
            'height':'auto',
            'legend':'left',
          };

          // idade da tropa
          var options_idade = {
            'title':'Idade da Tropa',
            'width':'auto', 
            'height':'auto',
            'legend':'left'
          };

          // idade da tropa
          var options_sexo = {
            'title':'Sexo',
          };

          
          // grafico de tempo de serviço
          var chart_temposervico = new google.visualization.ColumnChart(document.getElementById('chart_div'));
          chart_temposervico.draw(data_temposervico, options_temposervico);

          //gráfico de mapa força dos praças
          var chart_graduacao = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
          chart_graduacao.draw(data_graduacao, options_graduacao);

          //gráfico de mapa força dos oficiais
          var chart_posto = new google.visualization.ColumnChart(document.getElementById('chart_div5'));
          chart_posto.draw(data_posto, options_posto);

          // grafico de idade da tropa
          var chart_idade = new google.visualization.ColumnChart(document.getElementById('chart_div3'));
          chart_idade.draw(data_idade, options_idade);

          //gráfico de sexo
          var chart_sexo = new google.visualization.PieChart(document.getElementById('chart_div4'));
          chart_sexo.draw(data_sexo, options_sexo);

        }

        
        
      </script>
    </fieldset>
      <!-- fim do grafico -->

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
    //Chamando o Modal 
      $("#btn-mensagem").click(function(){
        $("#modal-mensagem").modal();
      });
    </script>



      
      

    

    



@stop