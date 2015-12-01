<fieldset>
	<legend>Cooperativa: <?= $nome; ?></legend>
		<div class='float-right btn-group'>
			<?php 
				echo $this->Html->link(
				    'Eleger Cooperativa',
				    ['action' => 'eleger', $pedido_id, $cooperativa_id],
				    ['confirm' => 'Você tem certeza que deseja eleger esta cooperativa?',  'class'=>'btn btn-sm btn-success']
				);
			 ?>
		</div>
	<div><strong>Realiza coletas por: </strong><?=$cooperativa_doacao?></div>
	<?= $materiais_valor; ?>
	<?php 
		echo $this->Html->link(
		    'Ver mais informações',
		    ['controller' => 'cooperativas' , 'action' => 'ver', $cooperativa_id],
		    ['target' => '_blank', 'class' => 'btn btn-default btn-success btn-xs']
		);
	?>
</fieldset>