<?= $this->Html->script('funcoes', ['block' => true]);?>

<div class="doadores form">
	<?= $this->Form->create($pedidoColeta); ?>
	<fieldset>
		<legend>Pedido de Coleta</legend>
			<fieldset>
				<legend>Informações dos materiais</legend>
					<?php
						echo  $this->Form->select(
										    'material_nome',
										    $materiais_options,
										    ['empty' => '(Escolha o tipo de material)', 'id' => 'material_nome']
										);

						echo $this->Form->input('material_quantidade', [
							'type' => 'number',
							'min' => '1',
														    'label' => [
														    'text' => 'Quantidade média (KG)', 
														    ]]);

					?>
						<?= $this->Form->button('Adcionar', [
														    'name' => 'material_adicionar',
														    'type' => 'button',
														     'onclick' => 'addMaterial($(\'#material_nome\').val(), $(\'#material_nome option:selected\').text(), $(\'#material-quantidade\').val());'
														    ]); ?>
					<fieldset>
						<legend>Materiais inseridos</legend>
						<div style='overflow:auto; height:100px;'>
								<ul id='lista-materiais'>
								</ul>
						</div>
					</fieldset>		
			</fieldset>		

	
	<fieldset>
		<legend>Informações da Coleta</legend>
		<?php
						echo  $this->Form->select(
										    'pedido_periodicidade',
										    ['avulsa' => 'avulsa','diária' => 'diária','bissemanal' => 'bissemanal','semanal' => 'semanal','quinzenal' => 'quinzenal','bimensal' => 'bimensal','mensal' => 'mensal','bimestral' => 'bimestral'],
										    ['empty' => '(Escolha a periodicidade)']
										);
						echo  $this->Form->select(
										    'pedido_frequencia',
										    ['1 vez' => '1 vez','2 vezes' => '2 vezes','3 vezes' => '3 vezes','4 vezes' => '4 vezes','5 vezes' => '5 vezes','6 vezes' => '6 vezes'],
										    ['empty' => '(Escolha a frequência)']
										);

						echo $this->Form->radio('dia_semana', ['Segunda-feira' => 'Segunda-feira','Terça-feira' => 'Terça-feira','Quarta-feira' => 'Quarta-feira','Quinta-feira' => 'Quinta-feira','Sexta-feira' => 'Sexta-feira','Sábado' => 'Sábado','Domingo' => 'Domingo'],['hiddenField' => false]);

						echo $this->Form->time('horario', [ 
															'hour' => [
														        'id' => 'horario_hora',
														    ],
															'minute' => [
														        'id' => 'horario_minuto',
														    ],
															 'label' => ['text' => 'Horário de Preferência'] ]);
						
						echo $this->Form->button('Adcionar', [
														    'name' => 'horario_adicionar',
														    'type' => 'button',
														    'onclick' => 'addDia();'
														    ]);

		?>



			<fieldset>
				<legend>Dias e horários inseridos</legend>
				<ul id='lista-dias'>
				</ul>
			</fieldset>	

		</fieldset>

	<?= $this->Form->label('Observações'); ?>
	<?= $this->Form->textarea('pedido_obs'); ?>


	</fieldset>

		<?= $this->Form->button('Limpar', [
										    'name' => 'limpar',
										    'type' => 'button'
										    ]); ?>

		<?= $this->Form->Submit('Publicar Pedido'); ?>

    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
	<?php echo $addMateriais; ?>
	<?php echo $addHorarios; ?>

</script>