<?= $this->Html->script('https://www.google.com/jsapi', ['block' => true]); ?>

<?php echo $this->Html->scriptBlock(
"
   // Load the Visualization API and the piechart package.
      google.load('visualization', '1', {packages: ['corechart', 'line']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawCurveTypes);

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
          title: 'Evolução das coletas no tempo'
        },
        vAxis: {
          title: 'Quantidade (KG)'
        },
        series: {
          1: {curveType: 'function'}
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        //attach the error handler here, before draw()
        google.visualization.events.addListener(chart, 'error', errorHandler);  
        
      chart.draw(data, options);
    }

", ['block' => true]); ?>

</script>

<div>
	<div>
		<h1>Informações sobre a criação do pedido de coleta</h1><br/>
		Pedido realizado em <?= $pedido_div['datahora_inclusao']; ?><br/>
		Status: <?= $pedido_div['status']; ?><br/>
	</div>
	<div style='float:right;height:50px;width:50px;'>
        <?php 
			echo $this->Html->link($this->Html->image('excel-icon.png',
        						['alt' => 'Exportar para formato Excel',
        						'title' => 'Exportar para formato Excel']),
    			 ['action' => 'sheet', $id], ['escape' => false]);?>
	</div>
	<fieldset>
		<legend>Materiais do pedido</legend>
		<?= $pedido_div['materiais_div']; ?>
	</fieldset>
	Periodicidade: <?= $pedido_div['periodicidade']; ?><br/>
	Frequência: <?= $pedido_div['frequencia']; ?><br/>
	<fieldset>
		<legend>Dias e horários de preferência</legend>
		<?= $pedido_div['horarios_div']; ?>
	</fieldset>
	Observações:<br/>
	<?= $pedido_div['observacoes']; ?><br/>
	<?= $pedido_div['cancelamento_div']; ?><br/>
</div>

<div>
	<h1>Gráfico de evolução</h1><br/>
	<div class='row'>
	  <div class='col-xs-12'>
	    <!--Div do Grafico-->
	    <div id="chart_div"></div>
	  </div>
	</div>
</div>

<div>
	<h1>Informações da Cooperativa</h1><br/>
	<?= $pedido_div['cooperativa_div']; ?>
</div>

<?php 
	if(!is_null($user['cooperativa_id']))
		echo "<div>". 
			$this->Html->link(
		    'Cadastrar Coleta',
		    ['controller' => 'coletas', 'action' => 'cadastrar', $id]
		)."<div>";
	 
?>
<div>
	<h1>Informações efetivas sobre as coletas já realizadas</h1><br/>
	Remuneração Total: <?= $pedido_div['coletas_totalvalor']; ?><br/>
	Quantidade Total: <?= $pedido_div['coletas_totalqtde']; ?> KG<br/>
	<?= $pedido_div['coletas']; ?>
</div>
