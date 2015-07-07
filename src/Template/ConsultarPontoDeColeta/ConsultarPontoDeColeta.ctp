<?php  

echo $this->Html->script('http://code.jquery.com/jquery.min.js', ['block' => true]);
echo $this->Html->script('jquery.maskedinput.min', ['block' => true]);


?>

 <div class="consultarPontoDeColeta form">
	<fieldset>
		<legend>Consultar</legend>
		<?php
			echo $this->Form->select(
										    'regiao',
										    ['leste' => '1 vez',
										    'norte' => '2 vezes',
										    'sul' => '3 vezes',
										    'oeste' => '4 vezes',
										    'todas' => '5 vezes'],
										    ['empty' => '(Escolha uma região)']
										);
		?>
	</fieldset>
    <?= $this->Form->button('Consultar', ['type' => 'button', 'onclick' => 'sendForm();']) ?>
    <?= $this->Form->end() ?>
</div>
