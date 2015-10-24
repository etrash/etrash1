<?= $this->Html->script('https://www.google.com/jsapi', ['block' => true]); ?>

<?php echo $this->Html->scriptBlock(
"
google.load('visualization', '1', {packages:['corechart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Material', 'Quantidade'],
          ".$data."
        ]);

        var options = {
          title: 'Materiais coletados',
          pieHole: 0.4,
          colors: ['yellow', 'blue', 'red', 'green'],
          pieSliceTextStyle: {
            color: 'black',
          },
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
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