<?php
	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Rule\IsUnique;

	class DoadoresTable extends Table
	{ 
		public function initialize(array $config)
	    {
	        $this->addBehavior('Timestamp', [
	            'events' => [
	                'Model.beforeSave' => [
	                    'doador_datahorainclussao' => 'new',
	                    'doador_datahoraalteracao' => 'always',
	                ]
	            ]
	        ]);
	    }

		public function validationDefault(Validator $validator)
	    {
	       $validator
	        ->notEmpty('doador_nome', "Campo obrigatório")
			->notEmpty('doador_cpfcnpj', "Campo obrigatório")
			->notEmpty('doador_cep', "Campo obrigatório")
			->notEmpty('doador_regiao', "Campo obrigatório")
			->allowEmpty('doador_complemento', "Campo obrigatório")
			->notEmpty('doador_endereco', "Campo obrigatório")
			->notEmpty('doador_numero', "Campo obrigatório")
			->notEmpty('doador_bairro', "Campo obrigatório")
			->notEmpty('doador_cidade', "Campo obrigatório")
			->notEmpty('doador_telefone', "Campo obrigatório")
			->notEmpty('doador_razaosocial','Campo obrigatório', function ($context) {
				if($context['data']['doador_tipo'] == 1)
					return false;
				else
					return true;
				})
			->notEmpty('doador_inscricaoestadual','Campo obrigatório', function ($context) {
				if($context['data']['doador_tipo'] == 1)
					return false;
				else
					return true;
				})
			->notEmpty('doador_email', "Campo obrigatório")
		    ->add('doador_email', 'validFormat', [
		        'rule' => 'email',
		        'message' => 'O e-mail inserido é inválido.'
		    ])
			->notEmpty('doador_senha', "Campo obrigatório")
			->notEmpty('responsavel_nome', "Campo obrigatório")
			->notEmpty('responsavel_rg', "Campo obrigatório")
			->notEmpty('responsavel_cpf', "Campo obrigatório")
			->notEmpty('responsavel_email', "Campo obrigatório")
		    ->add('responsavel_email', 'validFormat', [
		        'rule' => 'email',
		        'message' => 'O e-mail inserido é inválido.'
		    ])
			->notEmpty('responsavel_telefone', "Campo obrigatório")
			->notEmpty('doador_tipo', "Campo obrigatório")
			->notEmpty('doador_estado', "Campo obrigatório")
		    ->add('doador_email', [
		    		'unique' => [
		            'rule' => 'validateUnique',
		            'provider' => 'table',
		            'message' => 'Este e-mail já está cadastrado.',
		       	    ]])
		    ->add('doador_cpfcnpj', [
		    		'unique' => [
		            'rule' => 'validateUnique',
		            'provider' => 'table',
		            'message' => 'Este documento já está cadastrado.',
		       	    ]	
		    ])
		    ->add('doador_senha', 'length', 
		    		[
		            'rule' =>  ['minLength', 8],
		            'message' => 'A senha deve ter no mínimo 8 caracteres.',
		       	    ]	
		    )
		    ->add('doador_senha', 'custom', [
		        'rule' => function ($value, $context) {
		        	$containsLetter  = preg_match('/[a-zA-Z]/',    $value);
		        	$containsDigit   = preg_match('/\d/',          $value);

		        	if($containsLetter && $containsDigit)
		            	return true;
		            else
		            	return false;

		        },
		        'message' => 'A senha deve conter números e letras.',
		    ]);

		    return $validator;
	    }

	    public function montaEndereco($id)
	    {
	    	$queryD = $this->find()
		    ->hydrate(false)
		    ->select(['doador_regiao', 'doador_cep', 'doador_cidade', 'doador_estado'])
		    ->where(['doador_id' => $id]);

		    return $queryD->first();
	    }

	    
	}
?>