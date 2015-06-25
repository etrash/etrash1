<?php  

echo $this->Html->script('http://code.jquery.com/jquery.min.js', ['block' => true]);
echo $this->Html->script('jquery.maskedinput.min', ['block' => true]);


?>

 <div class="cooperativas form">
	<?= $this->Form->create($cooperativa, ['id' => 'formCooperativaCadastro', 'name' => 'formCooperativaCadastro']); ?>
	<fieldset>
		<legend>Cadastrar</legend>
		<?php
			echo $this->Form->input('cooperativa_nome', ['required' => true,
												    'label' => [
												        'text' => 'Nome Fantasia'
												    ]]);
			echo $this->Form->input('cooperativa_razaosocial', [
													    'label' => [
													    'text' => 'Razão Social'
													   ]]);
			echo $this->Form->input('cooperativa_inscricaoestadual', [
													    'label' => [
													    'text' => 'Inscrição Estadual'													   ]]);
			echo $this->Form->input('cooperativa_cnpj', [
													    'label' => [
													    'text' => 'CNPJ'
													    ]

													   ]);
			echo $this->Form->input('cooperativa_cep', [
													    'label' => [
													    'text' => 'CEP'
													   ]]);
			echo $this->Form->input('cooperativa_estado', [
													    'label' => [
													    'text' => 'Estado'
													   ]]);
			echo $this->Form->input('cooperativa_cidade', [
													    'label' => [
													    'text' => 'Cidade'
													   ]]);
			echo $this->Form->input('cooperativa_bairro', [
													    'label' => [
													    'text' => 'Bairro'
													   ]]);
			echo $this->Form->input('cooperativa_endereco', [
													    'label' => [
													    'text' => 'Endereço'
													   ]]);
			echo $this->Form->input('cooperativa_numero', [
													    'label' => [
													    'text' => 'Número'
													   ]]);
			echo $this->Form->input('cooperativa_complemento', [
													    'label' => [
													    'text' => 'Complemento'
													   ]]);
			echo $this->Form->input('cooperativa_telefone', [
													    'label' => [
													    'text' => 'Telefone'
													   ]]);
			echo $this->Form->input('cooperativa_email', ['required' => true,'type' => 'email',
													    'label' => [
													    'text' => 'E-mail'
													   ]]);
			echo $this->Form->input('cooperativa_senha', ['required' => true,'type' => 'password',
													    'label' => [
													    'text' => 'Senha'
													   ]]);
			echo $this->Form->input('responsavel_nome', [
													    'label' => [
													    'text' => 'Nome do Responsável'
													   ]]);
			echo $this->Form->input('responsavel_rg', [
													    'label' => [
													    'text' => 'RG do Responsável'
													   ]]);
			echo $this->Form->input('responsavel_cpf', [
													    'label' => [
													    'text' => 'CPF do Responsável'
													   ]
													    ]);
			echo $this->Form->input('responsavel_email', ['type' => 'email',
													    'label' => [
													    'text' => 'E-mail do Responsável'
													   ]]);
			echo $this->Form->input('responsavel_telefone', [
													    'label' => [
													    'text' => 'Telefone do Responsável'
													   ]]);
			echo $this->Form->input('responsavel_celular', [
													    'label' => [
													    'text' => 'Celular do Responsável'
													   ]]);
		?>
	</fieldset>
    <?= $this->Form->button('Criar Conta', ['type' => 'button', 'onclick' => 'sendForm();']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="actions">
	<h3>Ações</h3>
	<ul>
		<li><?php echo $this->Html->link('Listar', array('action' => 'index')); ?></li>
	</ul>
</div>
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