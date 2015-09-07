<div class="cooperativas view">
	Nome da cooperativa: <?=  h($cooperativa->cooperativa_nome) ?>
	CNPJ <?= h($cooperativa->cooperativa_cnpj) ?>
	Estado <?= h($cooperativa->cooperativa_estado) ?>
	Cidade <?= h($cooperativa->cooperativa_cidade) ?>
	Região <?= h($cooperativa->cooperativa_regiao) ?>
	Bairro <?= h($cooperativa->cooperativa_bairro) ?>
	CEP <?= h($cooperativa->cooperativa_cep) ?>
	Enderço <?= h($cooperativa->cooperativa_endereco) ?>
	Número <?= h($cooperativa->cooperativa_numero) ?>
	Complemento <?= h($cooperativa->cooperativa_complemento) ?>
	Telefone <?= h($cooperativa->cooperativa_telefone) ?>
	Horário <?= h($cooperativa->cooperativa_horario) ?>
	Materiais aceitos: <ul><?= h($materiais_cooperativa) ?></ul>
	Outros materiais aceitos: <ul><?= h($cooperativa->cooperativa_material_outros) ?></ul>
</div>
