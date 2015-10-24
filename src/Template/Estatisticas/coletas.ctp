<?= $this->Html->script('https://www.google.com/jsapi', ['block' => true]); ?>

<?php echo $this->Html->scriptBlock(
"
   // Load the Visualization API and the piechart package.
      google.load('visualization', '1', {packages: ['corechart', 'line']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawCurveTypes);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawCurveTypes() {

        // Create the data table.
         var data = new google.visualization.DataTable();
      data.addColumn('string', 'Data');
         ".$data['cols']."

         data.addRows([
         ".$data['data']."
         ]);

         var options = {
        hAxis: {
          title: 'Fata'
        },
        vAxis: {
          title: 'Quantidade (KG)'
        },
        series: {
          1: {curveType: 'function'}
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
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