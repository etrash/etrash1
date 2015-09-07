<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;

   class CooperativasController extends AppController 
   {
        public function initialize()
    	{
        	parent::initialize();

            $this->Auth->config(['unauthorizedRedirect' => '/doadores/editar']);
        
        }

	    public function index()
	    {

	    }

	    public function cadastrar()
		{
	        $cooperativa = $this->Cooperativas->newEntity();

			$this->loadModel('Materiais');
			$materiais = $this->Materiais->find('all');

			// Iteration will execute the query.
			foreach ($materiais as $row) 
			{
				$material_nome = $row['material_nome'];
				$material_id = $row['material_id'];
				$materiais_options[$material_id] = $material_nome;
			}

		 	$this->set('materiais_options',$materiais_options);

	        if ($this->request->is('post')) 
	        {

	            $cooperativa = $this->Cooperativas->patchEntity($cooperativa, $this->request->data);
			 	$cooperativa->set('cooperativa_datahorainclussao'		   , date("Y-m-d H:i:s"));

	            if ($this->Cooperativas->save($cooperativa, ['checkRules' => true])) 
	            {
	            	//LOGA O USUÁRIO RECÉM-CADASTRADO
					$this->Auth->setUser($cooperativa->toArray());

	                $this->Flash->success('O cadastro foi efetuado com sucesso!');

	                //SALVA OS MATERIAIS
	                $materiais   = $this->request->data('material_id');
	                for ($i=0; $i < count($materiais); $i++) 
	            	{ 
	            		$material = $this->Cooperativas_materiais->newEntity();
			 			$material->set('cooperativa_id', $cooperativa->get('cooperativa_id'));
			 			$material->set('material_id', $this->request->data('material_id')[$i]);
			 			$this->Cooperativas_materiais->save($material);
	            	}
	            	
	                return $this->redirect(['action' => 'index']);
	            } else {
	                $this->Flash->error('Ocorram os seguintes erros abaixo. Por favor, tente novamente!');
	            }
	        }
        	$this->set(compact('cooperativa'));
		}

		public function visualizar()
		{
	    	$id = $this->Auth->user('cooperativa_id');
	        $cooperativa = $this->Cooperativas->get($id);
	        $this->set('cooperativa', $cooperativa);
		}

		public function ver($id)
		{
	    	$id = $this->Auth->user('cooperativa_id');
	        $cooperativa = $this->Cooperativas->get($id);

	        //MATERIAIS DA COOPERATIVA
	    	$this->loadModel('Materiais');
			$queryM = $this->Materiais->find()
		    ->hydrate(false)
		    ->select(['material_nome'])
		    ->join(['cm' => [
				            'table' => 'cooperativas_materiais',
				            'type' => 'INNER',
				            'conditions' => 'materiais.material_id = cm.material_id'
				         ]])
		    ->where(['cooperativa_id' => $id])
		    ->group('materiais.material_id');

			$materiais = $queryM->all();
    		
    		$materiais_cooperativa = "";

	    		foreach ($materiais as $rowM) 
					$materiais_cooperativa .= "<li>".$rowM['material_nome'] . "</li>";
				
	        $this->set('cooperativa', $cooperativa);
		}

		public function editar()
		{
	    	$id = $this->Auth->user('cooperativa_id');

			$cooperativa = $this->Cooperativas->get($id);
	        $this->set('cooperativa', $cooperativa);

			$this->loadModel('Materiais');
			$materiais = $this->Materiais->find('all');

			// Iteration will execute the query.
			foreach ($materiais as $row) 
			{
				$material_nome = $row['material_nome'];
				$material_id = $row['material_id'];
				$materiais_options[$material_id] = $material_nome;
			}

		 	$this->set('materiais_options',$materiais_options);

		 	//CARREGA OS MATERIAIS
			$this->loadModel('Cooperativas_materiais');

			$queryCM = $this->Cooperativas_materiais->find('all')
		    ->where(['Cooperativas_materiais.cooperativa_id = ' => $id]);

		    $CMs = $queryCM->all();
		    $dataCM = $CMs->toArray();

		    $addMateriais = "";

		    // Iteration will execute the query.
			foreach ($dataCM as $row) 
			{
				$addMateriais .= "addMaterial(".$row['material_id'].", '".$materiais_options[$row['material_id']]."', -1);\n";
			}

			$this->set('addMateriais',$addMateriais);

	        if ($this->request->is(['patch', 'post', 'put']))
	        {
	        	//DELETA MATERIAIS
				$this->Cooperativas_materiais->deleteAll(['cooperativa_id' => $id]);

	        	//CHECA A SENHA
	            if($this->request->data['cooperativa_senha'] == "")
	            	unset($this->request->data['cooperativa_senha']);
	        	
	            $cooperativa = $this->Cooperativas->patchEntity($cooperativa, $this->request->data);
			 	$cooperativa->set('cooperativa_dahoraalteracao', date("Y-m-d H:i:s"));

	            if ($this->Cooperativas->save($cooperativa)) 
	            {
	                $this->Flash->success('O cadastro foi alterado com sucesso.');
	                
	                //SALVA OS MATERIAIS
	                $materiais   = $this->request->data('material_id');
	                for ($i=0; $i < count($materiais); $i++) 
	            	{ 
	            		$material = $this->Cooperativas_materiais->newEntity();
			 			$material->set('cooperativa_id', $cooperativa->get('cooperativa_id'));
			 			$material->set('material_id', $this->request->data('material_id')[$i]);
			 			$this->Cooperativas_materiais->save($material);
	            	}

	                return $this->redirect(['action' => 'index']);
	            } else {
	                $this->Flash->error('Ocorreu um erro. Por favor, tente novamente.');
	            }
	        }
        	$this->set(compact('cooperativa'));
		}

	    public function delete()
	    {
	    	$id = $this->Auth->user('cooperativa_id');
	    	
	        $cooperativa = $this->Cooperativas->get($id);
	        if ($this->Cooperativas->delete($cooperativa)) {
	            $this->Flash->success('O cadastro foi excluído com sucesso.');
	        } else {
	            $this->Flash->error('O cadastro não pôde ser excluído. Por favor, tente novamente.');
	        	return $this->redirect(['action' => 'visualizar']);
	        }
	        return $this->redirect($this->Auth->logout());
	    }

	    public function consultar()
	    {
	    	$this->loadModel('Materiais');

			$materiais = $this->Materiais->find('all');

			$materiais_options = "";

			// Iteration will execute the query.
			foreach ($materiais as $row) 
			{
				$material_nome = $row['material_nome'];
				$material_id = $row['material_id'];


				//VERIFICA MATERIAIS SELECIONADOS
				$material_checked = "";
				if($this->request->data('material') != null)
				{
					if(in_array($material_id, $this->request->data('material')))
						$material_checked = "checked='checked'";
					else
						$material_checked = "";
				}

				$materiais_options .= "<label><input type='checkbox' name='material[]' value='$material_id' $material_checked >$material_nome</label>\n";
			}
			
			$this->set('materiais_options', $materiais_options);

			$cooperativas = "";

			if ($this->request->is('post')) 
	        {
	        	if($this->request->data('regiao') == null && $this->request->data('material') == null)
		    		$this->Flash->error('É necessário preencher um filtro.');
		    	else
		    	{
		    		$join = array();
		    		$where = array();

		    		$where['cooperativas.cooperativa_id > '] = 0;

		    		if($this->request->data('regiao') != null)
		    			$where['cooperativa_regiao LIKE '] = $this->request->data('regiao');

		    		if($this->request->data('material') != null)
		    		{
		    			$whereM = array();

		    			$join['m'] = [
							            'table' => 'cooperativas_materiais',
							            'type' => 'INNER',
							            'conditions' => 'cooperativas.cooperativa_id = m.cooperativa_id'
							         ];

						//print_r($this->request->data('material'));

						foreach ($this->request->data('material') as $material_id) {
							$whereM[] = array('material_id' => $material_id);
						}

						$where['OR'] = $whereM;
		    		}

					$query = $this->Cooperativas->find()
				    ->hydrate(false)
				    ->join($join)
				    ->where($where)
				    ->group('cooperativas.cooperativa_id');

					$Coops = $query->all();
		    		$dataC = $Coops->toArray();

		    		$cooperativas ="";

					// Iteration will execute the query.
					foreach ($dataC as $row) 
					{
						$ver_url  =  Router::url(array('controller'=>'Cooperativas', 'action'=>'ver')) . "/".$row['cooperativa_id'];

						//MATERIAIS DA COOPERATIVA
						$queryM = $this->Materiais->find()
					    ->hydrate(false)
					    ->select(['material_nome'])
					    ->join(['cm' => [
							            'table' => 'cooperativas_materiais',
							            'type' => 'INNER',
							            'conditions' => 'materiais.material_id = cm.material_id'
							         ]])
					    ->where(['cooperativa_id' => $row['cooperativa_id']])
					    ->group('materiais.material_id');

						$materiais = $queryM->all();
			    		
			    		$materiais_cooperativa = "";

			    		foreach ($materiais as $rowM) 
							$materiais_cooperativa .= "<li>".$rowM['material_nome'] . "</li>";

						$cooperativas .= 
										"<fieldset>
											<legend>Cooperativa ".$row['cooperativa_nome']."</legend>
											<div><b>Locãlização:</b></div><br />
											<div>".$row['cooperativa_cidade']." - ".$row['cooperativa_estado']."</div><br />
											<div>Região: ".$row['cooperativa_regiao']."</div><br/>
											<div>Endereço: ".$row['cooperativa_endereco'].", Número: ".$row['cooperativa_numero']."</div><br/>
											<div>".$row['cooperativa_complemento']."</div><br />
											<div>Materiais aceitos:<br/><ul>".$materiais_cooperativa."</ul></div><br/>
											<div>Outros materiais aceitos:".$row['cooperativa_material_outros']."</div><br/>
											<div>Horário de funcionamento:".$row['cooperativa_horario']."</div><br/>
											<a href='".$ver_url."'>Ver mais informações</a>
										</fieldset>";
					}

					if(count($dataC) == 0)
						$cooperativas = "Não foi encontrado nenhum ponto de coleta com os filtros selecionados.";
					else
						$cooperativas = "
											<fieldset>
												<legend>Pontos de Coleta encontrados</legend>
												$cooperativas
											</fieldset>
											";

					$this->set('cooperativas',$cooperativas);
		    	}

	        }
	    }

        public function isAuthorized($user)
        {
            // All registered users can add articles
            if ($this->request->action === 'cadastrar') {
                return true;
            }
            elseif ($this->Auth->user('cooperativa_id') == null)
            {
                return false;
            }
            else
            	return true;

            return false;
        }


   }

?>
