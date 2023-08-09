@extends('adminlte::page')
@section('content')
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <div id="chart_div"></div>
</head>
<body>
</body>
    <div class="content">
        <div class="row">
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Censo Religioso</small>
                </h1>
            </section>
            <section class="content" style="height: auto !important; min-height: 0px !important;">
                <!-- Small boxes (Stat box) -->
                <fieldset class="scheduler-border">
                <legend class="scheduler-border">Dados grais referentes à informação religiosa do efetivo da PM-RN</legend>
                <td class="text-center">
                                
                        </td>
                <br>

                <div class="row ">       
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3>{{$dashboard->totalEfetivo}}</h3>
                   
                    <p>Total do Efetivo </p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                 
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">
                  <h3>{{$dashboard->totalCensoRealizado}}</h3>
                    <p>Com informação religiosa</p>
                  </div>
                  <div class="icon">
                  
                    <i class="fa fa-folder-open"></i>
                  </div>
                 
                </div>
                </div>
            
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                  <div class="inner">
                  
                  <h3>{{$dashboard->totalFaltaRealziarCenso}}</h3>
                    <p>Sem informação religiosa</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-hourglass-end"></i>
                  </div>

                 
                </div>
                </div>
 
              </fieldset>         
    </section>
    <section class="content" style="height: auto !important; min-height: 0px !important;">
                <!-- Small boxes (Stat box) -->
                <fieldset class="scheduler-border">

                <div class='row'>
                  <div class='col-sm-12'>
                    <div class="box box-info">
                      <div class="box-header with-border">
                        <!-- <h3 class="box-title">QUANTITATIVO DE POLICIAIS POR DENOMINAÇÃO RELIGIOSA</h3> -->
                        <a target="_blank" href="{{url('rh/censoreligioso/pdf/donominacoes')}}" class="btn btn-primary">DETALHAR</a>

                        <div class="box-tools pull-right" >
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                    
                     
                      <div class="box-body">      
                        <div id="denominacaoreligiosa"></div>
                      </div>          
                    </div>
                  </div>

                </div>  
                <div class='row'>
                  <div class='col-sm-12'>
                    <div class="box box-info">
                      <div class="box-header with-border">
                        <!-- <h3 class="box-title">QUANTITATIVO DE POLICIAIS POR DENOMINAÇÃO RELIGIOSA</h3> -->
                        <a target="_blank" href="{{url('rh/censoreligioso/pdf/categorias')}}" class="btn btn-primary">DETALHAR</a>

                        <div class="box-tools pull-right" >
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                    
                      <!-- grafico mapa de Força-->
                      <div class="box-body">      
                        <div id="categoriaReligiosa"></div>
                      </div>
                      <div style='padding: 20px'>
                      @if(isset($dashboard->totalCategoriasReligiosas) && count($dashboard->totalCategoriasReligiosas)>0)
                        @foreach($dashboard->totalCategoriasReligiosas as $religiao)
                          <a target="_blank" href="{{ url('rh/religiao/censocensoreligiosodetalhado/'.$religiao->id) }}" class='btn btn-lg btn-primary' style='margin-right: 10px'>Detalhar Segmentação Religiosa ({{ $religiao->st_categoria }})</a><br><br>
                        @endforeach
                      @endif
                      
                      </div>
                    </div>
                  </div>

                </div>  
                <div class='row'>
                  <div class='col-sm-12'>
                    <div class="box box-info">
                      <div class="box-header with-border">
                        <!-- <h3 class="box-title">QUANTITATIVO DE POLICIAIS POR DENOMINAÇÃO RELIGIOSA</h3> -->
                        <a target="_blank" href="{{url('rh/religiao/censocensoreligiosodetalhado/2')}}" class="btn btn-primary">DETALHAR</a>

                        <div class="box-tools pull-right" >
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                    
                     
                      <div class="box-body">      
                        <div id="denominacaoreligiosaevangelica"></div>
                      </div>          
                    </div>
                  </div>

                </div>  

                </fieldset>
    </section>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data_denominacaoreligiosa = new google.visualization.arrayToDataTable([
         
          ['Cursos', "Total de servidores", { role: "style" }, { role: 'annotation' }],
          @if(count($dashboard->totalDenomincoesReligiosas))
            @foreach($dashboard->totalDenomincoesReligiosas as $d)
              
                    ["{{$d->st_denominacaoreligiosa}}",{{$d->total}}, "#1266F1", '3'],
            
            @endforeach
          @endif
        ]);
        var view = new google.visualization.DataView(data_denominacaoreligiosa);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
        var options_denominacaoreligiosa = {
            'title':"QUANTITATIVO DE POLICIAIS POR DENOMINAÇÃO RELIGIOSA",
            'width':'auto', 
            'height': '1000',
            'legend': { position: "none" },
            'bar': {groupWidth: "95%"},
          };
          var chart_cursosPosGraduacao = new google.visualization.BarChart(document.getElementById("denominacaoreligiosa"));
          chart_cursosPosGraduacao.draw(view, options_denominacaoreligiosa);
          

       /*  var chart_cursosPosGraduacao = new google.charts.Bar(document.getElementById('cursosPosGraduacao'));
        chart_cursosPosGraduacao.draw(data_cursosPosGraducacao, options_cursosPosGraducacao); */
        
      };
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data_denominacaoreligiosaevangelica = new google.visualization.arrayToDataTable([
         
          ['Cursos', "Total de servidores", { role: "style" }, { role: 'annotation' }],
          @if(count($dashboard->totalDenomincoesReligiosasEvangelicos))
            @foreach($dashboard->totalDenomincoesReligiosasEvangelicos as $d)
              
                    ["{{$d->st_denominacaoreligiosa}}",{{$d->total}}, "#1266F1", '3'],
            
            @endforeach
          @endif
        ]);
        var view = new google.visualization.DataView(data_denominacaoreligiosaevangelica);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
        var options_denominacaoreligiosaevangelica = {
            'title':"QUANTITATIVO DE POLICIAIS POR IGREJA EVANGÉLICA",
            'width':'auto', 
            'height': '1000',
            'legend': { position: "none" },
            'bar': {groupWidth: "95%"},
          };
          var chart_denominacaoevangelica= new google.visualization.BarChart(document.getElementById("denominacaoreligiosaevangelica"));
          chart_denominacaoevangelica.draw(view, options_denominacaoreligiosaevangelica);
          

       /*  var chart_cursosPosGraduacao = new google.charts.Bar(document.getElementById('cursosPosGraduacao'));
        chart_cursosPosGraduacao.draw(data_cursosPosGraducacao, options_cursosPosGraducacao); */
        
      };
    </script>
        <script type="text/javascript">
    
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
      var data_titulo = new google.visualization.arrayToDataTable([
       
        ['Total de policiais', 'Total'],
        @if(count($dashboard->totalCategoriasReligiosas))
            @foreach($dashboard->totalCategoriasReligiosas as $c)
              ["{{$c->st_categoria}}",{{$c->total}}],
            @endforeach
        @endif
      ]);

      var options_titulo = {
          'title':'POLICIAIS POR SEGMENTAÇÃO RELIGIOSA',
          'width':'auto', 
          'height': 500,
          'legend':'left',
        };

      var chart = new  google.visualization.PieChart(document.getElementById('categoriaReligiosa'));
      chart.draw(data_titulo, options_titulo);
      
    };
  </script>
<!-- 
          
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data_pos = new google.visualization.arrayToDataTable([


          ['Pós Graduação', 'Total', { role: "style" }],
          @foreach($dashboard->totalDenomincoesReligiosas as $p)
          
                ["{{$p->st_denominacaoreligiosa}}",{{$p->total}}, "#1266F1"],

         @endforeach
        ]);

        var view_pos = new google.visualization.DataView(data_pos);
      view_pos.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

        var options_pos = {
            'title':'Gráfico de Pós Graduação por Nível',
            'width':'auto', 
            'height': 500,
            'legend':'left',
          };
         


        var chart = new google.visualization.ColumnChart(document.getElementById('denominacaoreligiosa'));
        chart.draw(view_pos, options_pos);
        
      };
    </script> -->

@endsection