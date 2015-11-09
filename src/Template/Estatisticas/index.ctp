<div>
	<fieldset>
		<legend> Menu de Estatísticas</legend>	
		<ul class="inner-menu">
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
			<?php 
			if(!is_null($user['doador_id']))
				echo "<li>".$this->Html->link(
				    'Média - Para doadores',
				    ['controller' => 'estatisticas', 'action' => 'media']
				)."</li>";
		 	?>
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
				    'Distribuição de materias por suas coletas',
				    ['controller' => 'estatisticas', 'action' => 'materiais_coleta']
				);
			 	?>
			</li>
			<?php 
			if(!is_null($user['cooperativa_id']))
				echo "<li>".$this->Html->link(
				    'Quantidade total coletada por material pela cooperativa',
				    ['controller' => 'estatisticas', 'action' => 'cooperativa']
				)."</li>";
		 	?>
		</ul>
	</fieldset>
    
</div>