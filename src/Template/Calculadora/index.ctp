<div class="doadores form">
	<?= $this->Form->create(null, ['action' => 'calcular']); ?>
	<fieldset>
		<legend>Cadastrar</legend>
		<?php
			echo $this->Form->input('valor1', [
													    'label' => [
													    'text' => '1º Valor'
													    ]

													   ]);
			echo $this->Form->input('operacao', [
													    'label' => [
													    'text' => 'Operação'
													    ],
													    'maxlength' => '1'

													   ]);
			echo $this->Form->input('valor2', [
													    'label' => [
													    'text' => '2º Valor'
													    ]

													   ]);
			echo $this->Form->submit();

		?>
	</fieldset>
    <?= $this->Form->end() ?>
</div>