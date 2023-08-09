<html>
  <head>
  <title>Organograma da PM</title>
   
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

  
    

      function getUnidades(){
        return [
        @foreach ($unidades as $opm)
        [{'v':'{{$opm->id}}', 'f':'{{$opm->id}}<div style="color:red; font-style:italic">{{$opm->st_sigla}}</div>'},
           '{{$opm->ce_pai}}', '{{$opm->st_nomepais}}'],
        @endforeach
        ];
      }

     function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');

        //set os dados
        data.addRows(this.getUnidades());

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {'allowHtml':true});

        //evento de click
        google.visualization.events.addListener(chart, 'select', selectHandler);

        function selectHandler(){
          var selection = chart.getSelection();
          var item = selection[0];
          //alert(data.getFormattedValue(item.row,0));
          text = data.getFormattedValue(item.row,0);
          const myArray = text.split("<");
          idFilho = myArray[0];
          text2 = myArray[1];
          const myArray2 = text2.split(">");
          NomeFilho = myArray2[1];          
        }


      }
      
   </script>
    </head>
  <body>
    <div id="chart_div"></div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
  </body>
</html>