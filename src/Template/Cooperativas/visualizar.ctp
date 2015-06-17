<div class="cooperativas view">
	<h2>Visualizar</h2>
	<dl>
		<?php $i = 0; $class = ' class="altrow"'; ?>
		<dt<?php if($i % 2 == 0) echo $class; ?>>Código</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_id) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Nome</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_nome) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Tipo</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_tipo) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>CPF/CNPJ</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_cpfcnpj) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>CEP</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_cep) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Complemento</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_complemento) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Número</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_numero) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Bairro</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_bairro) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Estado</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_estado) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Cidade</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_cidade) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Telefone</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_telefone) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Razão Social</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_razaosocial) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Inscrição Estadual</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_inscricaoestadual) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>E-mail</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->cooperativa_email) ?>
		</dd>
		
		<dt<?php if($i % 2 == 0) echo $class; ?>>Nome do Responsável</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->responsavel_nome) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>RG do Responsável</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->responsavel_rg) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>CPF do Responsável</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->responsavel_cpf) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>E-mail do Responsável</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->responsavel_email) ?>
		</dd>

		<dt<?php if($i % 2 == 0) echo $class; ?>>Telefone do Responsável</dt>
		<dd<?php if($i++ % 2 == 0) echo $class; ?>>
			<?= h($cooperativa->responsavel_telefone) ?>
		</dd>

	</dl>
</div>
<div class="actions">
	<h3>Actions</h3>
	<ul>    
            <li><?php echo $this->Html->link('Adicionar', array('action' => 'adicionar')); ?></li>
            <li><?php echo $this->Html->link('Editar', array('action' => 'editar', $cooperativa->cooperativa_id )); ?></li>
            <li><?php echo $this->Form->postLink('Deletar', array('action' => 'delete', $cooperativa->cooperativa_id), array('confirm' => 'Você tem certeza que quer excluir seu cadastro?')); ?></li>
	</ul>
</div>
