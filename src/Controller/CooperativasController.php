<?php

namespace App\Controller;

use App\Controller\AppController;

   class CooperativasController extends AppController 
   {
      
	    public function index()
	    {

	    }

	    public function cadastrar()
		{

	        $cooperativa = $this->Cooperativas->newEntity();
	        if ($this->request->is('post')) {

	            $cooperativa = $this->Cooperativas->patchEntity($cooperativa, $this->request->data);

	            if ($this->Cooperativas->save($cooperativa, ['checkRules' => true])) 
	            {
	                $this->Flash->success('O cadastro foi efetuado com sucesso!');
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

		public function editar()
		{
	    	$id = $this->Auth->user('cooperativa_id');

			$cooperativa = $this->Cooperativas->get($id);
	        $this->set('cooperativa', $cooperativa);

	        if ($this->request->is(['patch', 'post', 'put'])) {

	        	//CHECA A SENHA
	            if($this->request->data['cooperativa_senha'] == "")
	            	unset($this->request->data['cooperativa_senha']);
	        	
	            $cooperativa = $this->Cooperativas->patchEntity($cooperativa, $this->request->data);

	            if ($this->Cooperativas->save($cooperativa)) {
	                $this->Flash->success('O cadastro foi alterado com sucesso.');
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
	        $this->request->allowMethod(['post', 'delete']);
	        $cooperativa = $this->Cooperativas->get($id);
	        if ($this->Cooperativas->delete($cooperativa)) {
	            $this->Flash->success('O cadastro foi excluído com sucesso.');
	        } else {
	            $this->Flash->error('O cadastro não pôde ser excluído. Por favor, tente novamente.');
	        }
	        return $this->redirect(['action' => 'visualizar']);
	    }


	    // public function initialize()
	    // {
	    //     $this->loadComponent('Auth', [
	    //         'authorize' => 'Controller',
     //        	'unauthorizedRedirect' => '/doadores'
	    //     ]);
	    // }

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
