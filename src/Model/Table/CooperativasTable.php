<?php
	namespace App\Model\Table;

	use Cake\ORM\Table;
    use Cake\ORM\TableRegistry;
	use Cake\Validation\Validator;
	use Cake\ORM\RulesChecker;
	use Cake\ORM\Rule\IsUnique;
	use Cake\Routing\Router;

	class CooperativasTable extends Table
	{

		public function initialize(array $config)
	    {
	        $this->addBehavior('Timestamp', [
	            'events' => [
	                'Model.beforeSave' => [
	                    'cooperativa_datahorainclussao' => 'new',
	                    'cooperativa_datahoraalteracao' => 'always',
	                ]
	            ]
	        ]);
	    }

		public function validationDefault(Validator $validator)
	    {
	       $validator
	       	->notEmpty('cooperativa_nome', "Campo obrigatório")
			->notEmpty('cooperativa_razaosocial', "Campo obrigatório")
			->notEmpty('cooperativa_inscricaoestadual', "Campo obrigatório")
			->notEmpty('cooperativa_cnpj', "Campo obrigatório")
			->notEmpty('cooperativa_cep', "Campo obrigatório")
			->notEmpty('cooperativa_regiao', "Campo obrigatório")
			->notEmpty('cooperativa_estado', "Campo obrigatório")
			->notEmpty('cooperativa_cidade', "Campo obrigatório")
			->notEmpty('cooperativa_bairro', "Campo obrigatório")
			->notEmpty('cooperativa_endereco', "Campo obrigatório")
			->notEmpty('cooperativa_numero', "Campo obrigatório")
			->allowEmpty('cooperativa_complemento')
			->notEmpty('cooperativa_telefone', "Campo obrigatório")
			->notEmpty('cooperativa_horario', "Campo obrigatório")
			->notEmpty('cooperativa_email', "Campo obrigatório")
		    ->add('cooperativa_email', 'validFormat', [
		        'rule' => 'email',
		        'message' => 'O e-mail inserido é inválido.'
		    ])
			->notEmpty('cooperativa_senha', "Campo obrigatório")
			->notEmpty('cooperativa_doacao', "Campo obrigatório")
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
		    ])
		    ->add('cooperativa_senha', 'length', 
		    		[
		            'rule' =>  ['minLength', 8],
		            'message' => 'A senha deve ter no mínimo 8 caracteres.',
		       	    ]	
		    )
		    ->add('cooperativa_senha', 'custom', [
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

	    public function listaCooperativas($data)
    	{
	    		$join = array();
	    		$where = array();

	    		$where['Cooperativas.cooperativa_id > '] = 0;

	    		if($data['regiao'] != null)
	    			$where['cooperativa_regiao LIKE '] = $data['regiao'];

	    		if($data['material'] != null)
	    		{
	    			$whereM = array();

	    			$join['m'] = [
						            'table' => 'cooperativas_materiais',
						            'type' => 'INNER',
						            'conditions' => 'Cooperativas.cooperativa_id = m.cooperativa_id'
						         ];

					foreach ($data['material'] as $material_id)
						$whereM[] = array('material_id' => $material_id);

					$where['OR'] = $whereM;
	    		}

				$query = $this->find()
			    ->hydrate(false)
			    ->join($join)
			    ->where($where)
			    ->group('Cooperativas.cooperativa_id');

				$Coops = $query->all();
	    		$dataC = $Coops->toArray();

	    		$cooperativas ="";

				foreach ($dataC as $row) 
				{
					$ver_url  =  Router::url(array('controller'=>'Cooperativas', 'action'=>'ver')) . "/".$row['cooperativa_id'];

					//MATERIAIS DA COOPERATIVA
        			$this->Materiais = TableRegistry::get('Materiais');
					$queryM = $this->Materiais->find()
				    ->hydrate(false)
				    ->select(['material_nome'])
				    ->join(['cm' => [
						            'table' => 'cooperativas_materiais',
						            'type' => 'INNER',
						            'conditions' => 'Materiais.material_id = cm.material_id'
						         ]])
				    ->where(['cooperativa_id' => $row['cooperativa_id']])
				    ->group('Materiais.material_id');

					$materiais = $queryM->all();
		    		
		    		$materiais_cooperativa = "";

		    		foreach ($materiais as $rowM) 
						$materiais_cooperativa .= "<li>".$rowM['material_nome'] . "</li>";

					$cooperativas .= 
									"<fieldset>
										<legend>Cooperativa ".$row['cooperativa_nome']."</legend>
										<div><b>Localização:</b></div>
										<div>".$row['cooperativa_cidade']." - ".$row['cooperativa_estado']."</div>
										<div>Logradouro: ".$row['cooperativa_endereco'].", Número: ".$row['cooperativa_numero']."</div>
										<div>".$row['cooperativa_complemento']."</div><br />
										<div>Materiais aceitos:<br/><ul>".$materiais_cooperativa."</ul></div><br/>
										<div>Horário de funcionamento:".$row['cooperativa_horario']."</div><br/>
										<a href='".$ver_url."'>Ver mais informações</a>
									</fieldset>";
				}

				if(count($dataC) == 0)
					$cooperativas = "Nenhum ponto de coleta foi encontrado com os filtros selecionados.";
				else
				{
					$cooperativas = "
										<fieldset>
											<legend>Pontos de Coleta encontrados</legend>
											$cooperativas
										</fieldset>
										";
				}

				return $cooperativas;

		}

		public function listaCandidatas($pedido_id)
    	{
    		$join = array();

			$join['pcc'] = [
				            'table' => 'pedidos_coleta_cooperativas',
				            'type' => 'INNER',
				            'conditions' => 'Cooperativas.cooperativa_id = pcc.cooperativa_id'
				         ];

			$query = $this->find()
		    ->hydrate(false)
		    ->join($join)
		    ->where(['pcc.pedido_id' => $pedido_id])
		    ->group('Cooperativas.cooperativa_id');

			$Coops = $query->all();
    		$cooperativas = $Coops->toArray();


			if(count($cooperativas) == 0)
				return null;

			return $cooperativas;

		}

	    
	}
?>