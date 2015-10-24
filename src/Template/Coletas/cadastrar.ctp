<?= $this->Html->script('jquery.maskedinput.min', ['block' => true]); ?>
<?= $this->Html->script('funcoes', ['block' => true]);?>
<?= $this->Html->script('moment', ['block' => true]);?>
<?= $this->Html->script('bootstrap-datetimepicker.min', ['block' => true]);?>
<?= $this->Html->css('bootstrap-datetimepicker.css', ['block' => true]);?>

<div class="coletas form">
	<?= $this->Form->create(null, ['id' => 'coletaForm']); ?>
	<fieldset>
		<legend>Nova Coleta</legend>

	            <div class="form-group">
	                <div class='input-group date' id='pedido_datahora'>
	                    <input type='text' name="pedido_datahora" class="form-control" />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>
		        <script type="text/javascript">
		            $(function () {
		                $('#pedido_datahora').datetimepicker();
		                locale: 'pt-br'
		            });
		        </script>
			<fieldset>

				<legend>Informações dos materiais</legend>
					<?php
					    echo $this->Form->hidden('pedido_id', ['value' => $pedido_id]);

						echo  $this->Form->select(
										    'material_nome',
										    $materiais_options,
										    ['empty' => '(Escolha o tipo de material)', 'id' => 'material_nome']
										);

						echo $this->Form->input('material_valor', [
																	'id' => 'material_valor',
																    'label' => [
																    'text' => 'Valor'
																   ]]);


						echo $this->Form->input('material_quantidade', [
							'type' => 'number',
							'min' => '1',
														    'label' => [
														    'text' => 'Quantidade média (KG)', 
														    ]]);

					?>
						<?= $this->Form->button('Adicionar', [
														    'name' => 'material_adicionar',
														    'type' => 'button',
														    'onclick' => 'addMaterialValorQtde($(\'#material_nome\').val(), $(\'#material_nome option:selected\').text(), $(\'#material_valor\').val(),$(\'#material-quantidade\').val());'
														    ]); ?>
					<fieldset>
						<legend>Materiais inseridos</legend>
						<div style='overflow:auto; height:100px;'>
								<ul id='lista-materiais'>
								</ul>
						</div>
					</fieldset>		
			</fieldset>		

	<?= $this->Form->label('coleta_obs', 'Observações'); ?>
	<?= $this->Form->textarea('coleta_obs'); ?>

	</fieldset>

	<?= $this->Form->submit('Cadastrar Coleta'); ?>

    <?= $this->Form->end() ?>
</div>
<?php echo $this->Html->scriptBlock(
"
jQuery(function($){
		   $('#material_valor').mask('99.99');
		});
"
)
?>
