<?php
	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Rule\IsUnique;

	class CooperativasTable extends Table
	{


		public function validationDefault(Validator $validator)
	    {
	       $validator
	       	->notEmpty('cooperativa_nome', "Campo obrigatório")
			->notEmpty('cooperativa_razaosocial', "Campo obrigatório")
			->notEmpty('cooperativa_inscricaoestadual', "Campo obrigatório")
			->notEmpty('cooperativa_cnpj', "Campo obrigatório")
			->notEmpty('cooperativa_cep', "Campo obrigatório")
			->notEmpty('cooperativa_estado', "Campo obrigatório")
			->notEmpty('cooperativa_cidade', "Campo obrigatório")
			->notEmpty('cooperativa_bairro', "Campo obrigatório")
			->notEmpty('cooperativa_endereco', "Campo obrigatório")
			->notEmpty('cooperativa_numero', "Campo obrigatório")
			->allowEmpty('cooperativa_complemento', "Campo obrigatório")
			->notEmpty('cooperativa_telefone', "Campo obrigatório")
			->notEmpty('cooperativa_email', "Campo obrigatório")
			->notEmpty('cooperativa_senha', "Campo obrigatório")
			->notEmpty('responsavel_nome', "Campo obrigatório")
			->notEmpty('responsavel_cpf', "Campo obrigatório")
			->notEmpty('responsavel_rg', "Campo obrigatório")
			->notEmpty('responsavel_email', "Campo obrigatório")
			->notEmpty('responsavel_telefone', "Campo obrigatório")
			->notEmpty('responsavel_celular', "Campo obrigatório")
		    ->add('cooperativa_email', [
		    		'unique' => [
		            'rule' => 'validateUnique',
		            'provider' => 'table',
		            'message' => 'Este e-mail já está cadastrado.',
		       	    ]])
		    ->add('cooperativa_cnpj', [
		    		'unique' => [
		            'rule' => 'validateUnique',
		            'provider' => 'table',
		            'message' => 'Este documento já está cadastrado.',
		       	    ]	
		    ]);

		    return $validator;
	    }
	}
?>