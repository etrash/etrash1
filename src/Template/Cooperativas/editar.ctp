<?php  

echo $this->Html->script('jquery.maskedinput.min', ['block' => true]);
echo $this->Html->script('funcoes', ['block' => true]);

?>

 <div class="cooperativa form">
	<?= $this->Form->create($cooperativa, ['id' => 'formCooperativaCadastro', 'name' => 'formCooperativaCadastro']); ?>
	<fieldset>
		<legend>Editar</legend>
		<?php
			echo $this->Form->input('cooperativa_nome', ['required' => true,
												    'label' => [
												        'text' => 'Nome Fantasia'
												    ]]);
			echo $this->Form->input('cooperativa_razaosocial', [
														'required' => true,
													    'label' => [
													    'text' => 'Razão Social'
													   ]]);
			echo $this->Form->input('cooperativa_inscricaoestadual', [
														'required' => true,
													    'label' => [
													    'text' => 'Inscrição Estadual'													   ]]);
			echo $this->Form->input('cooperativa_cnpj', [
														'required' => true,
													    'label' => [
													    'text' => 'CNPJ'
													    ]

													   ]);
			echo $this->Form->input('cooperativa_cep', [
														'required' => true,
													    'label' => [
													    'text' => 'CEP'
													   ]]);

			echo "<div class='input select required'>";

			echo $this->Form->label('cooperativa_regiao', 'Região');

			echo  $this->Form->select(
							    'cooperativa_regiao',
							    ['Centro' => 'Centro','Norte' => 'Norte','Leste' => 'Leste','Sul' => 'Sul','Oeste' => 'Oeste'],
							    ['empty' => '(Escolha a região)', 'id' => 'cooperativa-regiao','required' => true]
							);
			echo "</div>";

			echo $this->Form->input('cooperativa_estado', [
														'required' => true,
													    'label' => [
													    'text' => 'Estado'
													   ]]);
			echo $this->Form->input('cooperativa_cidade', [
														'required' => true,
													    'label' => [
													    'text' => 'Cidade'
													   ]]);
			echo $this->Form->input('cooperativa_bairro', [
														'required' => true,
													    'label' => [
													    'text' => 'Bairro'
													   ]]);
			echo $this->Form->input('cooperativa_endereco', [
														'required' => true,
													    'label' => [
													    'text' => 'Endereço'
													   ]]);
			echo $this->Form->input('cooperativa_numero', [
														'required' => true,
													    'label' => [
													    'text' => 'Número'
													   ]]);
			echo $this->Form->input('cooperativa_complemento', [
														'required' => true,
													    'label' => [
													    'text' => 'Complemento'
													   ]]);
			echo $this->Form->input('cooperativa_telefone', [
														'required' => true,
													    'label' => [
													    'text' => 'Telefone'
													   ]]);
			echo $this->Form->input('cooperativa_horario', [
														'required' => true,
													    'label' => [
													    'text' => 'Horário de funcionamento (com os dias da semana)'
													   ]]);
			echo $this->Form->input('cooperativa_email', ['required' => true,'type' => 'email',
													    'label' => [
													    'text' => 'E-mail'
													   ]]);
			echo $this->Form->input('cooperativa_senha', ['required' => true,'type' => 'password','value' => '',
													    'label' => [
													    'text' => 'Senha'
													   ]]);
			echo $this->Form->input('responsavel_nome', [
														'required' => true,
													    'label' => [
													    'text' => 'Nome do Responsável'
													   ]]);
			echo $this->Form->input('responsavel_rg', [
														'required' => true,
													    'label' => [
													    'text' => 'RG do Responsável'
													   ]]);
			echo $this->Form->input('responsavel_cpf', [
														'required' => true,
													    'label' => [
													    'text' => 'CPF do Responsável'
													   ]
													    ]);
			echo $this->Form->input('responsavel_email', [
														'required' => true,
														'type' => 'email',
													    'label' => [
													    'text' => 'E-mail do Responsável'
													   ]]);
			echo $this->Form->input('responsavel_telefone', [
														'required' => true,
													    'label' => [
													    'text' => 'Telefone do Responsável'
													   ]]);
			echo $this->Form->input('responsavel_celular', [
														'required' => true,
													    'label' => [
													    'text' => 'Celular do Responsável'
													   ]]);
		?>

		<fieldset>
				<legend>Materiais aceitos</legend>
					<?php
						echo  $this->Form->select(
										    'material_nome',
										    $materiais_options,
										    ['empty' => '(Escolha o tipo de material)', 'id' => 'material_nome']
										);

					?>
						<?= $this->Form->button('Adcionar', [
														    'name' => 'material_adicionar',
														    'type' => 'button',
														     'onclick' => 'addMaterial($(\'#material_nome\').val(), $(\'#material_nome option:selected\').text(), -1);'
														    ]); ?>
					<fieldset>
						<legend>Materiais inseridos</legend>
						<div style='overflow:auto; height:100px;'>
								<ul id='lista-materiais'>
								</ul>
						</div>
					</fieldset>	

			<?= $this->Form->input('cooperativa_material_outros', [
													    'label' => [
													    'text' => 'Outros materiais (separe por vírgulas)'
													   ]]);	?>
			</fieldset>		

	</fieldset>
    <?= $this->Form->button('Alterar Conta', ['type' => 'button', 'onclick' => 'sendForm();']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="actions">
	<h3>Ações</h3>
	<ul>
		<li><?php echo $this->Html->link('Listar', array('action' => 'index')); ?></li>
		<li>
			<?php 
				echo $this->Html->link(
				    'Excluir cadastro',
				    ['action' => 'delete'],
				    ['confirm' => 'Você tem certeza que deseja excluir seu cadastro?']
				);
			 ?>
		</li>
	</ul>
</div>

<script type="text/javascript">
	<?php echo $addMateriais; ?>
</script>

<?php 

echo $this->Html->scriptBlock(
    "
	    jQuery(function($){
		   $('#cooperativa-cep').mask('99999-999');
		   $('#cooperativa-telefone').mask('(99) 9999-9999?9');
		   $('#responsavel-telefone').mask('(99) 9999-9999?9');
		   $('#responsavel-celular').mask('(99) 9999-9999?9');
		   $('#cooperativa-cnpj').mask('99.999.999/9999-99');
		});

		function validarCNPJ(cnpj) {

		    cnpj = cnpj.replace(/[^\d]+/g,'');

		    if(cnpj == '') return false;

		    if (cnpj.length != 14)
		        return false;

		    // LINHA 10 - Elimina CNPJs invalidos conhecidos
		    if (cnpj == \"00000000000000\" || 
		        cnpj == \"11111111111111\" || 
		        cnpj == \"22222222222222\" || 
		        cnpj == \"33333333333333\" || 
		        cnpj == \"44444444444444\" || 
		        cnpj == \"55555555555555\" || 
		        cnpj == \"66666666666666\" || 
		        cnpj == \"77777777777777\" || 
		        cnpj == \"88888888888888\" || 
		        cnpj == \"99999999999999\")
		        return false; // LINHA 21

		    // Valida DVs LINHA 23 -
		    tamanho = cnpj.length - 2
		    numeros = cnpj.substring(0,tamanho);
		    digitos = cnpj.substring(tamanho);
		    soma = 0;
		    pos = tamanho - 7;
		    for (i = tamanho; i >= 1; i--) {
		      soma += numeros.charAt(tamanho - i) * pos--;
		      if (pos < 2)
		            pos = 9;
		    }
		    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		    if (resultado != digitos.charAt(0))
		        return false;

		    tamanho = tamanho + 1;
		    numeros = cnpj.substring(0,tamanho);
		    soma = 0;
		    pos = tamanho - 7;
		    for (i = tamanho; i >= 1; i--) {
		      soma += numeros.charAt(tamanho - i) * pos--;
		      if (pos < 2)
		            pos = 9;
		    }
		    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		    if (resultado != digitos.charAt(1))
		          return false; // LINHA 49

		    return true; // LINHA 51

		}

        function validaDoc(data)
        {

			if(validarCNPJ(data))
				return true; //alert('O CNPJ é válido');
			else
				return false;//alert('O CNPJ é inválido');
			

        }

        function sendForm()
        {
           if (validaDoc($(\"#cooperativa-cnpj\").val()))
           {
              document.getElementById(\"formCooperativaCadastro\").submit();
           } 
           else
           {
              alert(\"CNPJ Inválido\");
              return false;
           }
        }


	");
 ?>