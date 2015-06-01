<?php  

echo $this->Html->script('http://code.jquery.com/jquery.min.js', ['block' => true]);
echo $this->Html->script('jquery.maskedinput.min', ['block' => true]);


?>

 <div class="doadores form">
	<?= $this->Form->create($doador, ['id' => 'formDoadorCadastro', 'name' => 'formDoadorCadastro']); ?>
	<fieldset>
		<legend>Cadastrar</legend>
		<?php
			echo $this->Form->input('doador_nome', ['required' => true,
												    'label' => [
												        'text' => 'Nomes'
												    ]]);
			echo $this->Form->label('Tipo');
			echo $this->Form->radio(
									    'doador_tipo',
									    [
									        ['value' => '1', 'text' => 'Pessoa Física', 'onchange' => 'mostraTipo(1);', 'checked' => 'true'],
									        ['value' => '2', 'text' => 'Pessoa Jurídica', 'onchange' => 'mostraTipo(2);'],
									    ]
									);
			echo $this->Form->input('doador_cpfcnpj', [
													    'label' => [
													    'text' => 'CPF/CNPJ'
													    ]

													   ]);
			echo $this->Form->input('doador_cep', [
													    'label' => [
													    'text' => 'CEP'
													   ]]);
			echo $this->Form->input('doador_complemento', [
													    'label' => [
													    'text' => 'Complemento'
													   ]]);
			echo $this->Form->input('doador_numero', [
													    'label' => [
													    'text' => 'Número'
													   ]]);
			echo $this->Form->input('doador_bairro', [
													    'label' => [
													    'text' => 'Bairro'
													   ]]);
			echo $this->Form->input('doador_estado', [
													    'label' => [
													    'text' => 'Estado'
													   ]]);
			echo $this->Form->input('doador_cidade', [
													    'label' => [
													    'text' => 'Cidade'
													   ]]);
			echo $this->Form->input('doador_telefone', [
													    'label' => [
													    'text' => 'Telefone'
													   ]]);
			echo $this->Form->input('doador_razaosocial', [
													    'label' => [
													    'text' => 'Razão Social'
													   ]]);
			echo $this->Form->input('doador_inscricaoestadual', [
													    'label' => [
													    'text' => 'Inscrição Estadual'													   ]]);
			echo $this->Form->input('doador_email', ['required' => true,'type' => 'email',
													    'label' => [
													    'text' => 'E-mail'
													   ]]);
			echo $this->Form->input('doador_senha', ['required' => true,'type' => 'password',
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

		mostraTipo(1);

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