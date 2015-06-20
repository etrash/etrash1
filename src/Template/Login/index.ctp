<div class="login form">
	<?= $this->Flash->render('auth') ?>
	<?= $this->Form->create() ?>
	<fieldset>
		<legend>Login</legend>
		<?php
			echo $this->Form->label('Tipo');
			echo $this->Form->radio(
									    'tipo',
									    [
									        ['value' => '1', 'text' => 'Doador', 'checked' => 'true'],
									        ['value' => '2', 'text' => 'Cooperativa']
									    ]
									);

			echo $this->Form->input('doador_email', ['required' => true,
													    'label' => [
													    'text' => 'Login'
													    ]

													   ]);
			echo $this->Form->input('doador_senha', ['required' => true,'type' => 'password',
													    'label' => [
													    'text' => 'Senha'
													   ]]);
			echo $this->Form->submit('Entrar');

		?>
	</fieldset>
    <?= $this->Form->end() ?>
</div>
<div class="actions">
<h3>Ou clique nos links abaixo para fazer o cadastro como:</h3>
	<ul>
		<li><?php echo $this->Html->link('Doador', array('controller' => 'Doadores','action' => 'cadastrar')); ?></li>
		<li><?php echo $this->Html->link('Cooperativa', array('controller' => 'Cooperativas','action' => 'cadastrar')); ?></li>
	</ul>
</div>