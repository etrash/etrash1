<fieldset>
	<legend>Meus pedidos de coleta</legend>
		<?= $this->Html->link('Novo pedido de coleta', ['action' => 'cadastrar'], ['class' => 'btn btn-default btn-success btn-xs']);?>
	
	
	<?= $pedidos_coleta; ?>
	
</fieldset>