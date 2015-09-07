<fieldset>
	<legend>Consulta de Pedido de Coleta</legend>
	<fieldset> 
		<legend>Região</legend>
		<?= $this->Form->create(null); ?>

		<?=  $this->Form->select(
									    'regiao',
									    ['Centro' => 'Centro','Norte' => 'Norte','Leste' => 'Leste','Sul' => 'Sul','Oeste' => 'Oeste'],
									    ['empty' => '(Escolha a região)']
									);
		 ?>
	</fieldset>

	<fieldset> 
		<legend>Materiais</legend>
		<?= $materiais_options; ?>
	</fieldset>
	<?= $this->Form->submit("Consultar"); ?>
</fieldset>
<?= $cooperativas; ?>