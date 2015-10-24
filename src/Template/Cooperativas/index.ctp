<div>
	<fieldset>
		<legend> MENU</legend>	
		<ul class="inner-menu">
			<li>
				<?php 
				echo $this->Html->link(
				    'Meus Pedidos de Coleta',
				    ['controller' => 'pedidoscoleta' , 'action' => 'gerenciar']
				);
			 	?>
			</li>
			<li>
				<?php 
				echo $this->Html->link(
				    'Consultar Pedidos de Coleta',
				    ['controller' => 'pedidoscoleta' , 'action' => 'index']
				);
			 	?>
			</li>
			<li>
				<?php 
				echo $this->Html->link(
				    'Alterar Cadastro',
				    ['action' => 'editar']
				);
			 	?>
			</li>
			<li>
				<?php 
				echo $this->Html->link(
				    'Estatísticas',
				    ['controller' => 'estatisticas']
				);
			 	?>
			</li>
			<li>
			<?php 
				echo $this->Html->link(
				    'Excluir cadastro',
				    ['action' => 'excluir'],
				    ['confirm' => 'Você tem certeza que deseja excluir seu cadastro?']
				);
			 ?>
			</li>
		</ul>
	</fieldset>
    
</div>