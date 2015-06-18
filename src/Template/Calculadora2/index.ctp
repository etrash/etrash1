<div class="doadores form">
<?php 
 ?>
	<?= $this->Form->create(null, ['action' => 'calcular', 'name' => 'formCalc']); ?>
	<fieldset>
		<legend>Cadastrar</legend>

		<?php
			echo $this->Form->input('valor12', [
													    'label' => [
													    'text' => '1º Valor'
													    ], 'type' =>'radio'
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