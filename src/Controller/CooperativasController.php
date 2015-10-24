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

	        //MONTA OPTIONS DO SELECT DE MATERIAIS
			$this->loadModel('Materiais');
			$materiais_options = $this->Materiais->montaSelect();
		 	$this->set('materiais_options',$materiais_options);

	        if ($this->request->is('post')) 
	        {

	            $cooperativa = $this->Cooperativas->patchEntity($cooperativa, $this->request->data);

	            if ($this->Cooperativas->save($cooperativa, ['checkRules' => true])) 
	            {
	            	//LOGA O USUÁRIO RECÉM-CADASTRADO
					$this->Auth->setUser($cooperativa->toArray());

	                $this->Flash->success('O cadastro foi efetuado com sucesso!');

	                //SALVA OS MATERIAIS
					$this->loadModel('Cooperativas_materiais');
	                $this->Cooperativas_materiais->saveMateriais($cooperativa->get('cooperativa_id'), $this->request->data());
           	
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
	        $cooperativa = $this->Cooperativas->get($id);

	        //MATERIAIS DA COOPERATIVA
	    	$this->loadModel('Materiais');
			$materiais_cooperativa = $this->Materiais->listaMateriaisCoop($id);
				
	        $this->set('cooperativa', $cooperativa);
	        $this->set('materiais_cooperativa', $materiais_cooperativa);
		}

		public function editar()
		{
	    	$id = $this->Auth->user('cooperativa_id');

			$cooperativa = $this->Cooperativas->get($id);
	        $this->set('cooperativa', $cooperativa);

	        //MONTA OPTIONS DO SELECT DE MATERIAIS
			$this->loadModel('Materiais');
			$materiais_options = $this->Materiais->montaSelect();
		 	$this->set('materiais_options',$materiais_options);

		 	//CARREGA OS MATERIAIS
			$this->loadModel('Cooperativas_materiais');
			$addMateriais = $this->Cooperativas_materiais->addMateriais($id);
			$this->set('addMateriais',$addMateriais);

	        if ($this->request->is(['patch', 'post', 'put']))
	        {
	        	//DELETA MATERIAIS
				$this->Cooperativas_materiais->deleteAll(['cooperativa_id' => $id]);

	        	//CHECA A SENHA
	            if($this->request->data['cooperativa_senha'] == "")
	            	unset($this->request->data['cooperativa_senha']);
	        	
	            $cooperativa = $this->Cooperativas->patchEntity($cooperativa, $this->request->data);

	            if ($this->Cooperativas->save($cooperativa)) 
	            {
	                $this->Flash->success('O cadastro foi alterado com sucesso.');
	                
	                //SALVA OS MATERIAIS
					$this->loadModel('Cooperativas_materiais');
	                $this->Cooperativas_materiais->saveMateriais($id, $this->request->data());
           	
	                return $this->redirect(['action' => 'index']);
	            } else {
	                $this->Flash->error('Ocorreu um erro. Por favor, tente novamente.');
	            }
	        }
        	$this->set(compact('cooperativa'));
		}

	    public function excluir()
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
	    	//MONTA OPÇÕES DE MATERIAIS
	    	$this->loadModel('Materiais');
			$materiais_options = $this->Materiais->montaCheck($this->request->data());			
			$this->set('materiais_options', $materiais_options);

			$cooperativas = "";

			if ($this->request->is('post')) 
	        {
	        	if($this->request->data('regiao') == null && $this->request->data('material') == null)
		    		$this->Flash->error('É necessário preencher um filtro.');
		    	else
		    	{
		    		$cooperativas = $this->Cooperativas->listaCooperativas($this->request->data());
					$this->set('cooperativas',$cooperativas);
		    	}

	        }
	    }

        public function isAuthorized($user)
        {
            // APENAS COOPERATIVAS LOGADAS PODEM TER ACESSO AO CONTROLLER 
            // EXCETO O MÉTODO CADASTRAR QUE É LIBERADO PARA TODOS
            
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
