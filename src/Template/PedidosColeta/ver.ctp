
<?php
if(!$candidatou)
	echo $this->Form->postLink('Candidatar-se', array('action' => 'candidatar'), array('class'=>'btn btn-sm btn-success', 'confirm' => 'Você confirma seu interesse em realizar esta coleta?', 'data' => array('pedido_id' => $Pedidoscoleta->pedido_id))); 
else
	echo "Você já se candidatou para este pedido."
?>
	<fieldset>
		<legend>Informações do pedido</legend>
		<div><strong>Pedido realizado em </strong><?= $pedido_div['datahora_inclusao']; ?></div>
		<div><strong>Status: </strong><?= $pedido_div['status']; ?></div>
		<div><strong>Periodicidade: </strong><?= $pedido_div['periodicidade']; ?></div>
		<div><strong>Frequência: </strong><?= $pedido_div['frequencia']; ?></div>
	</fieldset>

	<fieldset>
		<legend>Informações do Doador</legend>
		<div><strong>Cidade/Estado: </strong><?= $doador_endereco['doador_cidade']; ?>/<?= $doador_endereco['doador_estado']; ?></div>
		<div><strong>Região: </strong><?= $doador_endereco['doador_regiao']; ?></div>
		<div><strong>CEP: </strong><?= $doador_endereco['doador_cep']; ?></div>
		<div><strong>Mapa do endereço aproximado: </strong></div>
		<div><iframe
		  width="600"
		  height="450"
		  frameborder="0" style="border:0"
		  src="<?=$google_maps; ?>" allowfullscreen>
		</iframe></div>
	</fieldset>

	<fieldset>
		<legend>Materiais do pedido</legend>
		<?= $pedido_div['materiais_div']; ?>
	</fieldset>

	<fieldset>
		<legend>Dias e horários de preferência</legend>
		<?= $pedido_div['horarios_div']; ?>
	</fieldset>

<?= $this->Form->end() ?>
