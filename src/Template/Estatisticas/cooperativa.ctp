<?= $this->Html->script('https://www.google.com/jsapi', ['block' => true]); ?>

<?php echo $this->Html->scriptBlock(
"
   // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      function errorHandler(errorMessage) {
          //curisosity, check out the error in the console
          console.log(errorMessage);

          //simply remove the error, the user never see it
          google.visualization.errors.removeError(errorMessage.id);
          $( '#chart_div' ).html( '<b>Nenhum dado.</b>');
      }

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
         var data = google.visualization.arrayToDataTable([
         ['Material', 'Quantidade']".$data."
      ]);

        // Set chart options
         var options = {'title':'Quantidade total de materiais coletados pela cooperativa, em quilogramas (KG)',
                        'colors': ['#00B014'] };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

        //attach the error handler here, before draw()
        google.visualization.events.addListener(chart, 'error', errorHandler);  

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