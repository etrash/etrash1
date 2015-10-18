<div>
	<fieldset>
		<legend> Menu de Estatísticas<legend>	
		<ul>
			<li>
				<?php 
				echo $this->Html->link(
				    'Materiais mais coletados',
				    ['controller' => 'estatisticas', 'action' => 'materiais']
				);
			 	?>
			</li>
			<li>
				<?php 
				echo $this->Html->link(
				    'Coletas por regiões',
				    ['controller' => 'estatisticas', 'action' => 'regioes']
				);
			 	?>
			</li>
			<li>
				<?php 
				echo $this->Html->link(
				    'Média - Para doadores',
				    ['controller' => 'estatisticas', 'action' => 'media']
				);
			 	?>
			</li>
			<li>
				<?php 
				echo $this->Html->link(
				    'Ranking de cooperativas por material',
				    ['controller' => 'estatisticas', 'action' => 'media_cooperativas']
				);
			 	?>
			</li>
			<li>
				<?php 
				echo $this->Html->link(
				    'Quantidade total coletada por material pela cooperativa',
				    ['controller' => 'estatisticas', 'action' => 'cooperativa']
				);
			 	?>
			</li>
		</ul>
	</fieldset>
    
</div>