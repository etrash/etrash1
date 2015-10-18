<div class="login form">
	<?= $this->Flash->render('auth') ?>
	<?= $this->Form->create() ?>
	<fieldset>
		<legend>Login</legend>
		<?php
			echo $this->Form->label('tipo', 'Perfil de Usuário');
			echo $this->Form->radio(
									    'tipo',
									    [
									        ['value' => '1', 'text' => 'Doador', 'onchange' => 'mostraTipo(1);', 'checked' => 'true'],
									        ['value' => '2', 'text' => 'Cooperativa', 'onchange' => 'mostraTipo(2);']
									    ]
									);

			echo $this->Form->input('doador_email', ['required' => true,'id' => 'email',
													    'label' => [
													    'text' => 'Login'
													    ]

													   ]);
			echo $this->Form->input('doador_senha', ['required' => true,'type' => 'password','id' => 'senha',													    'label' => [
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
<?php 

echo $this->Html->scriptBlock(
    "
		jQuery(function($)
		{
			mostraTipo($(\"input:radio[name=tipo]:checked\").val());
		});

		function mostraTipo(tipo)
		{
			if(tipo == 1)
			{
				$(\"#email\").attr(\"name\",\"doador_email\");
				$(\"#senha\").attr(\"name\",\"doador_senha\");
			}
			else if(tipo == 2)
			{
				$(\"#email\").attr(\"name\",\"cooperativa_email\");
				$(\"#senha\").attr(\"name\",\"cooperativa_senha\");
			}
		}


	");
 ?>