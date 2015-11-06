
<?php
if(!$candidatou)
	echo $this->Form->postLink('Candidatar-se', array('action' => 'candidatar'), array('confirm' => 'Você confirma seu interesse em realizar esta coleta?', 'data' => array('pedido_id' => $Pedidoscoleta->pedido_id))); 
else
	echo "Você já se candidatou para este pedido."
?>
<div>
	<h1>Informações da coleta</h1><br/>
	Pedido realizado em <?= $pedido_div['datahora_inclusao']; ?><br/>
	Status: <?= $pedido_div['status']; ?><br/>
	<fieldset>
		<legend>Informações do Doador</legend>
		Cidade/Estado: <?= $doador_endereco['doador_cidade']; ?>/<?= $doador_endereco['doador_estado']; ?><br/>
		Região: <?= $doador_endereco['doador_regiao']; ?><br/>
		CEP: <?= $doador_endereco['doador_cep']; ?><br/>
		Mapa do endereço aproximado: <br/>
<iframe
  width="600"
  height="450"
  frameborder="0" style="border:0"
  src="<?=$google_maps; ?>" allowfullscreen>
</iframe>
	</fieldset>
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
</div>
<?= $this->Form->end() ?>
