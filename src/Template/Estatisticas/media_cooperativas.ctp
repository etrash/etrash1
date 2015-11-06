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
         ['Cooperativa', 'Quantidade de ".$materiais_options[$material_id]."'],
         ".$data."
      ]);

        // Set chart options
         var options = {'title':'Quantidade coletada pelas cooperativas, em quilogramas (KG)',
                        'colors': ['#00B014'] };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

        //attach the error handler here, before draw()
        google.visualization.events.addListener(chart, 'error', errorHandler);  
        
        ".$draw."
      }
", ['block' => true]); ?>

   
    </script>

<div class='row'>
  <div class='col-xs-12'>
    <fieldset>
    <legend>Parâmetros do relatório</legend>
    <fieldset> 
      <legend>Período</legend>
      <?= $this->Form->create(null); ?>

      <?=  $this->Form->select(
                        'periodo',
                        ['30 days ago' => 'Últimos 30 dias','3 months ago' => 'Últimos 3 meses','6 months ago' => 'Últimos 6 meses','1 year ago' => 'Último ano'],
                        ['empty' => '(Escolha o período)']
                    );
       ?>
    </fieldset>

    <fieldset> 
      <legend>Materiais</legend>

      <?= 
          $this->Form->select(
                            'material',
                            $materiais_options,
                            ['empty' => '(Escolha o tipo de material)', 'id' => 'material_nome']
                        );
      ?>
    </fieldset>
    <?= $this->Form->submit("Gerar relatório"); ?>
  </fieldset>
  </div>
</div>

<div class='row'>
  <div class='col-xs-12'>
    <!--Div do Grafico-->
    <div id="chart_div"></div>
  </div>
</div>