<fieldset>
	<legend>Meus pedidos de coleta</legend>
	
	<?= $this->Html->link('Anunciar um pedido', ['action' => 'cadastrar']);?>
	
	<?= $pedidos_coleta; ?>
	
</fieldset>