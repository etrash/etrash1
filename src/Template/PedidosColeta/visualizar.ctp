<div>
	<h1>Informações da coleta</h1><br/>
	Pedido realizado em <?= $datahora_inclusao; ?><br/>
	Status: <?= $status; ?><br/>
	<fieldset>
		<legend>Materiais do pedido</legend>
		<?= $materiais_div; ?>
	</fieldset>
	Periodicidade: <?= $periodicidade; ?><br/>
	Frequência: <?= $frequencia; ?><br/>
	<fieldset>
		<legend>Dias e horários de preferência</legend>
		<?= $horarios_div; ?>
	</fieldset>
	Observações:<br/>
	<?= $observacoes; ?><br/>
	<?= $cancelamento_div; ?><br/>
</div>
<div>
	<h1>Informações da Cooperativa</h1><br/>
	<?= $cooperativa_div; ?>
</div>
