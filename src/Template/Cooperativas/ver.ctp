<h1>Cooperativa</h1>
<div class="cooperativas view">
	<b>Nome da cooperativa:</b> <?=  h($cooperativa->cooperativa_nome) ?><br/>
	<b>Cidade:</b> <?= h($cooperativa->cooperativa_cidade) ?> - <?= h($cooperativa->cooperativa_estado) ?><br/>
	<b>Região:</b> <?= h($cooperativa->cooperativa_regiao) ?><br/>
	<b>CEP:</b> <?= h($cooperativa->cooperativa_cep) ?><br/>
	<b>Logradouro:</b> <?= h($cooperativa->cooperativa_endereco) ?>
	<b>Número:</b> <?= h($cooperativa->cooperativa_numero) ?><br/>
	<b>Complemento:</b> <?= h($cooperativa->cooperativa_complemento) ?><br/>
	<b>Bairro:</b> <?= h($cooperativa->cooperativa_bairro) ?><br/>
	<b>Telefone:</b> <?= h($cooperativa->cooperativa_telefone) ?><br/>
	<b>Horário:</b> <?= h($cooperativa->cooperativa_horario) ?><br/>
	<b>Materiais aceitos: </b><ul><?= $materiais_cooperativa ?><br/></ul>
	<!-- <b>CNPJ:</b> <?= h($cooperativa->cooperativa_cnpj) ?><br/> -->
</div>
<div class="responsavel">
<h2>Responsável</h2>
	<b>Nome:</b> <?= h($cooperativa->responsavel_nome) ?><br/>
	<b>E-mail:</b> <?= h($cooperativa->responsavel_email) ?><br/>
</div>