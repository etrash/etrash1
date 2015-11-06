<fieldset>
	<legend>Consulta de Pontos de Coleta</legend>
	<fieldset> 
		<legend>Região</legend>
		<?= $this->Form->create(null,['action' => 'consultar/#coops']); ?>
		<input type="hidden" name='requested' value="1" />
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
	<?= $this->Form->end(); ?>
</fieldset>

<a name='coops'></a>
<?= $cooperativas; ?>