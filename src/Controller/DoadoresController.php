<?php
namespace App\Controller;

use App\Controller\AppController;

   class DoadoresController extends AppController 
   {

	    public function cadastrar()
		{
	        $doador = $this->Doadores->newEntity();
	        if ($this->request->is('post')) {


	            $doador = $this->Doadores->patchEntity($doador, $this->request->data);

	            if ($this->Doadores->save($doador, ['checkRules' => true])) 
	            {
	                $this->Flash->success('O cadastro foi efetuado com sucesso!');
	                return $this->redirect(['action' => 'index']);
	            } else {
	                $this->Flash->error('Ocorram os seguintes erros abaixo. Por favor, tente novamente!');
	            }
	        }
        	$this->set(compact('doador'));
		}

		public function visualizar()
		{
			$id = $this->Auth->user('doador_id');
	        $doador = $this->Doadores->get($id);
	        $this->set('doador', $doador);
		}

		public function editar()
		{
			$id = $this->Auth->user('doador_id');
			$doador = $this->Doadores->get($id);
	        $this->set('doador', $doador);
	        if ($this->request->is(['patch', 'post', 'put'])) {
	        	//CHECA A SENHA
	            if($this->request->data['doador_senha'] == "")
	            	unset($this->request->data['doador_senha']);

	            $doador = $this->Doadores->patchEntity($doador, $this->request->data);

	            if ($this->Doadores->save($doador)) {
	                $this->Flash->success('O cadastro foi alterado com sucesso.');
	                return $this->redirect(['action' => 'index']);
	            } else {
	                $this->Flash->error('Ocorreu um erro. Por favor, tente novamente.');
	            }
	        }
        	$this->set(compact('doador'));
		}

	    public function delete()
	    {
			$id = $this->Auth->user('doador_id');
	        $doador = $this->Doadores->get($id);
	        if ($this->Doadores->delete($doador)) {
	            $this->Flash->success('O cadastro foi excluído com sucesso.');
	        } else {
	            $this->Flash->error('O cadastro não pôde ser excluído. Por favor, tente novamente.');
	        }
	        return $this->redirect(['action' => 'visualizar']);
	    }


		public function isAuthorized($user)
		{
		    // All registered users can add articles
		    if ($this->request->action === 'cadastrar') {
		        return true;
		    }

		    return parent::isAuthorized($user);
		}
   }
?>
