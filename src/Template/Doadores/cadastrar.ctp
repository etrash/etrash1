<?php  

echo $this->Html->script('http://code.jquery.com/jquery.min.js', ['block' => true]);
echo $this->Html->script('jquery.maskedinput.min', ['block' => true]);
echo $this->Html->script('funcoes', ['block' => true]);

?>

 <div class="doadores form">
	<?= $this->Form->create($doador, ['id' => 'formDoadorCadastro', 'name' => 'formDoadorCadastro']); ?>
	<fieldset>
		<legend>Cadastrar</legend>
	<div class="row">

		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('doador_nome', ['required' => true,
												    'label' => [
												        'text' => 'Nome'
												    ]]);
		?>
		</div>
		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->label('Tipo');
			echo $this->Form->radio(
									    'doador_tipo',
									    [
									        ['value' => '1', 'text' => 'Pessoa Física', 'onchange' => 'mostraTipo(1);', 'checked' => 'true'],
									        ['value' => '2', 'text' => 'Pessoa Jurídica', 'onchange' => 'mostraTipo(2);'],
									    ]
									);
		?>
		</div>
		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('doador_cpfcnpj', [
														'required' => true,
													    'label' => [
													    'text' => 'CPF/CNPJ'
													    ]

													   ]);
		?>
		</div>
		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('doador_cep', [
														'required' => true,
														'onBlur' => 'buscaCep(this.value)',
													    'label' => [
													    'text' => 'CEP'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php

            echo $this->Html->image('site/load.gif', ['alt' => 'load', 'id' => 'loadgif', 'style' => 'display:none;height:30px;']);
			
			
			echo $this->Form->input('doador_estado', [
														'required' => true,
														'readonly' => true,
														'value' => 'São Paulo',
													    'label' => [
													    'text' => 'Estado'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php
			
			echo $this->Form->input('doador_cidade', [
														'required' => true,
														'readonly' => true,
														'value' => 'São Paulo',
													    'label' => [
													    'text' => 'Cidade'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php

			echo $this->Form->input('doador_regiao', [
														'required' => true,
														'readonly' => true,
														'id' => 'regiao',
													    'label' => [
													    'text' => 'Região'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php

			echo $this->Form->input('doador_bairro', [
														'required' => true,
														'readonly' => true,
														'id' => 'bairro',
													    'label' => [
													    'text' => 'Bairro'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php
			
			echo $this->Form->input('doador_endereco', [
														'required' => true,
														'readonly' => true,
														'id' => 'logradouro',
													    'label' => [
													    'text' => 'Logradouro'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php

			echo $this->Form->input('doador_numero', [
														'required' => true,
													    'label' => [
													    'text' => 'Número'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php
			
			echo $this->Form->input('doador_complemento', [
													    'label' => [
													    'text' => 'Complemento'
													   ]]);
		?>
		</div>
		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('doador_telefone', [
														'required' => true,
													    'label' => [
													    'text' => 'Telefone'
													   ]]);
		?>
		</div>
		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('doador_razaosocial', [
														'required' => true,
													    'label' => [
													    'text' => 'Razão Social'
													   ]]);
		?>
		</div>
		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('doador_inscricaoestadual', [
														'required' => true,
													    'label' => [
													    'text' => 'Inscrição Estadual'													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('doador_email', ['required' => true,'type' => 'email',
													    'label' => [
													    'text' => 'E-mail'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('doador_senha', ['required' => true,'type' => 'password',
													    'label' => [
													    'text' => 'Senha'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('responsavel_nome', [
														'required' => true,
													    'label' => [
													    'text' => 'Nome do Responsável'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('responsavel_rg', [
														'required' => true,
													    'label' => [
													    'text' => 'RG do Responsável'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('responsavel_cpf', [
														'required' => true,
													    'label' => [
													    'text' => 'CPF do Responsável'
													   ]
													    ]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('responsavel_email', [
														'required' => true,
														'type' => 'email',
													    'label' => [
													    'text' => 'E-mail do Responsável'
													   ]]);
		?>
		</div>

		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('responsavel_telefone', [
														'required' => true,
													    'label' => [
													    'text' => 'Telefone do Responsável'
													   ]]);
		?>
		</div>
	</div>
	</fieldset>
    <?= $this->Form->button('Criar Cadastro', ['type' => 'button', 'onclick' => 'sendForm();']) ?>
    <?= $this->Form->end() ?>
</div>
<?php 

echo $this->Html->scriptBlock(
    "
	    jQuery(function($){
		   $('#doador-cep').mask('99999-999');
		   $('#doador-telefone').mask('(99) 9999-9999?9');
		   $('#responsavel-telefone').mask('(99) 9999-9999?9');
		   $('#responsavel-cpf').mask('999.999.999-99');
		});

		
		function mostraTipo(tipo)
		{
			if(tipo == 1)
			{
				$('#doador-cpfcnpj').mask('999.999.999-99');
				$('#doador-razaosocial, label[for=\"doador-razaosocial\"]').hide();
				$('#doador-inscricaoestadual, label[for=\"doador-inscricaoestadual\"]').hide();
			}
			else if(tipo == 2)
			{

				$('#doador-cpfcnpj').mask('99.999.999/9999-99');
				$('#doador-razaosocial, label[for=\"doador-razaosocial\"]').show();
				$('#doador-inscricaoestadual, label[for=\"doador-inscricaoestadual\"]').show();
			}
		}

		mostraTipo($(\"[name='doador_tipo']:checked\").val());

		function validarCPF(cpf) {  
		    cpf = cpf.replace(/[^\d]+/g,'');    
		    if(cpf == '') return false; 
		    // Elimina CPFs invalidos conhecidos    
		    if (cpf.length != 11 || 
		        cpf == \"00000000000\" || 
		        cpf == \"11111111111\" || 
		        cpf == \"22222222222\" || 
		        cpf == \"33333333333\" || 
		        cpf == \"44444444444\" || 
		        cpf == \"55555555555\" || 
		        cpf == \"66666666666\" || 
		        cpf == \"77777777777\" || 
		        cpf == \"88888888888\" || 
		        cpf == \"99999999999\")
		            return false;       
		    // Valida 1o digito 
		    add = 0;    
		    for (i=0; i < 9; i ++)       
		        add += parseInt(cpf.charAt(i)) * (10 - i);  
		        rev = 11 - (add % 11);  
		        if (rev == 10 || rev == 11)     
		            rev = 0;    
		        if (rev != parseInt(cpf.charAt(9)))     
		            return false;       
		    // Valida 2o digito 
		    add = 0;    
		    for (i = 0; i < 10; i ++)        
		        add += parseInt(cpf.charAt(i)) * (11 - i);  
		    rev = 11 - (add % 11);  
		    if (rev == 10 || rev == 11) 
		        rev = 0;    
		    if (rev != parseInt(cpf.charAt(10)))
		        return false;       
		    return true;   
		}

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

        function validaDoc(data, tipo)
        {
			if(tipo == 1)
			{
				if(validarCPF(data))
					return true; //alert('O CPF é válido');
				else
					return false;//alert('O CPF é inválido');
			}
			else if(tipo == 2)
			{

				if(validarCNPJ(data))
					return true; //alert('O CNPJ é válido');
				else
					return false;//alert('O CNPJ é inválido');
			}

        }


        function sendForm()
        {
           if(!validaDoc($(\"#responsavel-cpf\").val(), 1))
           {
              alert(\"CPF do responsável inválido\");
              return false;
           }

           if (validaDoc($(\"#doador-cpfcnpj\").val(), $(\"input:radio[name=doador_tipo]:checked\").val()))
           {
              document.getElementById(\"formDoadorCadastro\").submit();
           } 
           else
           {
              alert(\"CPF/CNPJ Inválido\");
              return false;
           }
        }


	");
 ?>