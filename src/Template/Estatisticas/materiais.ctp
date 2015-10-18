<?= $this->Html->script('https://www.google.com/jsapi', ['block' => true]); ?>

<?php echo $this->Html->scriptBlock(
"
   // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
         var data = google.visualization.arrayToDataTable([
         ['Material', 'Quantidade'],
         ".$data."
      ]);

        // Set chart options
         var options = {'title':'Os materiais mais coletados nos últimos 30 dias, em quilogramas (KG)',
                        'colors': ['#00B014'] };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
", ['block' => true]); ?>

   
    </script>
<div class='row'>
  <div class='col-xs-12'>
    <!--Div do Grafico-->
    <div id="chart_div"></div>
  </div>
</div>