<?php  

echo $this->Html->script('jquery.maskedinput.min', ['block' => true]);
echo $this->Html->script('funcoes', ['block' => true]);

?>

 <div class="cooperativas form">
	<?= $this->Form->create($cooperativa, ['id' => 'formCooperativaCadastro', 'name' => 'formCooperativaCadastro']); ?>
	<fieldset>
		<legend>Cadastrar</legend>
		<div class="row">
		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('cooperativa_nome', ['required' => true,
												    'label' => [
												        'text' => 'Nome Fantasia'
												    ]]);
			?>
		</div>
    	<div class="col-xs-12 col-sm-6">
    	<?php
			echo $this->Form->input('cooperativa_razaosocial', [
														'required' => true,
													    'label' => [
													    'text' => 'Razão Social'
													   ]]);
			?>
		</div>
		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('cooperativa_inscricaoestadual', [
													    'label' => [
													    'text' => 'Inscrição Estadual'													   
													    ]]);
			?>
		</div>
		<div class="col-xs-12 col-sm-6">
													    <?php
			echo $this->Form->input('cooperativa_cnpj', [
														'required' => true,
													    'label' => [
													    'text' => 'CNPJ'
													    ]]);
			?>
		</div>
		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('cooperativa_cep', [
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
			?>
			
			<?php
			echo $this->Form->input('cooperativa_estado', [
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
			echo $this->Form->input('cooperativa_cidade', [
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
			echo $this->Form->input('cooperativa_regiao', [
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
			echo $this->Form->input('cooperativa_bairro', [
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
			echo $this->Form->input('cooperativa_endereco', [
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
			echo $this->Form->input('cooperativa_numero', [
														'required' => true,
													    'label' => [
													    'text' => 'Número'
													   ]]);
			?>

		</div>
			
		<div class="col-xs-12 col-sm-6">
		<?php
			echo $this->Form->input('cooperativa_complemento', [
													    'label' => [
													    'text' => 'Complemento'
													   ]]);
			?>
			</div>

		<div class="col-xs-12 col-sm-6">
			<?php
			echo $this->Form->input('cooperativa_telefone', [
														'required' => true,
													    'label' => [
													    'text' => 'Telefone'
													   ]]);
			?>
			</div>

			<div class="col-xs-12 col-sm-6">
													   <?php
			echo $this->Form->input('cooperativa_horario', [
														'required' => true,
													    'label' => [
													    'text' => 'Horário de funcionamento (com os dias da semana)'
													   ]]);
			?>
			</div>

			<div class="col-xs-12 col-sm-6">
													   <?php
			echo $this->Form->input('cooperativa_email', ['required' => true,'type' => 'email',
													    'label' => [
													    'text' => 'E-mail'
													   ]]);
			?>
			</div>
			<div class="col-xs-12 col-sm-6">
													   <?php
			echo $this->Form->input('cooperativa_senha', ['required' => true,'type' => 'password',
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
													   ]]);
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
			
			<div class="col-xs-12 col-sm-6">
													   <?php
			echo $this->Form->input('responsavel_celular', [
														'required' => true,
													    'label' => [
													    'text' => 'Celular do Responsável'
													   ]]);
			?>
			</div>
		</div>
		
		<fieldset>
				<legend>Informações sobre a coleta</legend>
				<?= $this->Form->label('cooperativa_doacao', 'A cooperativa realiza coletas por:') ?>
				<?= $this->Form->radio('cooperativa_doacao', ['true' => 'Doação','false' => 'Compra'],['hiddenField' => false, 'required' => true]);?>

		</fieldset>

		<fieldset>
				<legend>Materiais aceitos</legend>
				<div class="row">
				<div class="col-xs-12 col-sm-6">
					<label for="">Escolha o tipo de material</label>
					<?php
						echo  $this->Form->select(
										    'material_nome',
										    $materiais_options,
										    ['empty' => '(Escolha o tipo de material)', 'id' => 'material_nome']
										);
					?>
				</div>
				<div class="col-xs-12 col-sm-6">
					<?php 
						echo $this->Form->input('material_valor', [
																	'id' => 'material_valor',
																    'label' => [
																    'text' => 'Valor'
																   ]]);

					?>
				</div>
				</div>
						<?= $this->Form->button('Adicionar', [
														    'name' => 'material_adicionar',
														    'type' => 'button',
														     'onclick' => 'addMaterialValor($(\'#material_nome\').val(), $(\'#material_nome option:selected\').text(), $(\'#material_valor\').val());'
														    ]); ?>
					<fieldset>
						<legend>Materiais inseridos</legend>
						<div style='overflow:auto; height:100px;'>
								<ul id='lista-materiais'>
								</ul>
						</div>
					</fieldset>	
			</fieldset>		

	</fieldset>
    <?= $this->Form->button('Criar Cadastro', ['type' => 'button', 'onclick' => 'sendForm();']) ?>
    <?= $this->Form->end() ?>
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
		   $('#material_valor').mask('99.99');
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
           if(!validaDoc($(\"#responsavel-cpf\").val(), 1))
           {
              alert(\"CPF do responsável inválido\");
              return false;
           }

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