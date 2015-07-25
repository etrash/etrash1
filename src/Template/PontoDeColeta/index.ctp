 <div class="PontoDeColeta form">
	<?= $this->Form->create(); ?>
	<fieldset>
		<legend>Consultar</legend>
		<?php
			
			echo $this->Form->select(
										    'regiao',
										    ['leste' => 'leste',
										    'norte' => 'norte',
										    'sul' => 'sul',
										    'oeste' => 'oeste',
										    'todas' => 'todas'],
										    ['empty' => '(todos)']
										);
			echo $this->Form->select(
										    'materialDeColeta',
										    ['papel' => 'papel',
										    'aluminio' => 'aluminio',
										    'papelao' => 'papelao',
										    'platico' => 'plastico',
										    'todos' => 'todos'],
										    ['empty' => '(todos)']
										);
			echo $this->Form->select(
										    'tipoDeColeta',
										    ['doação ' => 'doacao',
										    'venda' => 'venda',
										    'todos' => 'todos'],
										    ['empty' => '(todos)']
										);
			
		?>
	</fieldset>
    <?php
    	echo $this->Form->submit("Consultar")
    	?>

    <?= $this->Form->end() ?>

   
</div>