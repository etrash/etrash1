
<?php
if(!$candidatou)
	echo $this->Form->postLink('Candidatar-se', array('action' => 'candidatar'), array('confirm' => 'Você confirma seu interesse em realizar esta coleta?', 'data' => array('pedido_id' => $Pedidoscoleta->pedido_id))); 
else
	echo "Você já se candidatou para este pedido."
?>
<div>
	<h1>Informações da coleta</h1><br/>
	Pedido realizado em <?= $datahora_inclusao; ?><br/>
	Status: <?= $status; ?><br/>
	<fieldset>
		<legend>Informações do Doador</legend>
		Região do Doador: <?= $doador_endereco['doador_regiao']; ?><br/>
		CEP do Doador: <?= $doador_endereco['doador_cep']; ?><br/>
		Mapa do endereço aproximado: <br/>
<iframe
  width="600"
  height="450"
  frameborder="0" style="border:0"
  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBfyrDLCLUT4J1gI0DUseA9QiAKwycwmnw
    &q=<?= $doador_endereco['doador_cep']; ?>" allowfullscreen>
</iframe>
	</fieldset>
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
</div>
<?= $this->Form->end() ?>
