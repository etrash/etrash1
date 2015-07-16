<div class="doadores form">
	<?= $this->Form->create($pedidoColeta); ?>
	<fieldset>
		<legend>Cancelamento do Pedido de Coleta de Nº <?php echo $id; ?></legend>	

	<div>Por favor, digite o motivo do cancelamento do pedido.</div>
	<?= $this->Form->label('Motivo'); ?>
	<?= $this->Form->textarea('pedido_motivo'); ?>


	</fieldset>

		<?= $this->Form->Submit('Cancelar Pedido'); ?>

    <?= $this->Form->end() ?>
</div>

</script>