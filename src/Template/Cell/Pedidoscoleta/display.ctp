<fieldset>
	<legend>Cooperativa <?= $nome; ?>
		<div style='float:right;'>
			<?php 
				echo $this->Html->link(
				    'Eleger Cooperativa',
				    ['action' => 'eleger', $pedido_id, $cooperativa_id],
				    ['confirm' => 'Você tem certeza que deseja eleger esta cooperativa?']
				);
			 ?>
		</div>
	</legend>
	<div>Realiza coletas por: <?=$cooperativa_doacao?></div>
	<?= $materiais_valor; ?>
	<?php 
		echo $this->Html->link(
		    'Ver mais informações',
		    ['controller' => 'cooperativas' , 'action' => 'ver', $cooperativa_id],
		    ['target' => '_blank']
		);
	?>
</fieldset>