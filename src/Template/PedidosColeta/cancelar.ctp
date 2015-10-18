<div class="doadores form">
	<?= $this->Form->create($pedidoColeta, ['id' => 'pedidoForm']); ?>
	<fieldset>
		<legend>Cancelamento do Pedido de Coleta de Nº <?php echo $id; ?></legend>	

	<div>Por favor, digite o motivo do cancelamento do pedido.</div>
	<?= $this->Form->label('Motivo'); ?>
	<?= $this->Form->textarea('pedido_motivo', ['required' => true]); ?>


	</fieldset>

		<?= $this->Form->button('Cancelar Pedido', ['onclick' => "if(confirm('Tem certeza que deseja excluir este pedido?')){document.getElementById('pedidoForm').submit();}", 'type' => 'button']); ?>

    <?= $this->Form->end() ?>
</div>

</script>