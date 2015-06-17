<?php
	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Rule\IsUnique;

	class DoadoresTable extends Table
	{
		public function validationDefault(Validator $validator)
	    {
	       $validator
		    ->add('cooperativa_email', [
		    		'unique' => [
		            'rule' => 'validateUnique',
		            'provider' => 'table',
		            'message' => 'Este e-mail já está cadastrado.',
		       	    ]])
		    ->add('cooperativa_cpfcnpj', [
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