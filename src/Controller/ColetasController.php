<?php  

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

class ColetasController extends AppController
{

	public function initialize()
	{
    	parent::initialize();

        $this->Auth->config(['unauthorizedRedirect' => '/']);
    
    }

    public function index()
    {
    	return $this->redirect(['controller' => 'pedidoscoleta', 'action' => 'gerenciar']);
    }

	public function cadastrar($pedido_id)
	{
		$this->loadModel('Materiais');

		$materiais = $this->Materiais->find('all');

		$data = $materiais->toArray();

        //MONTA OPTIONS DO SELECT DE MATERIAIS
		$this->loadModel('Materiais');
		$materiais_options = $this->Materiais->montaSelect();
	 	$this->set('materiais_options',$materiais_options);
	       
		 if ($this->request->is('post'))
		 {
		 	$cadastrou = $this->Coletas->cadastraNovo($this->request->data());

		 	if($cadastrou)
		 	{
		 		$this->Flash->success('A coleta foi cadastrada com sucesso!');
	            return $this->redirect(['controller' => 'pedidoscoleta', 'action' => 'visualizar', $this->request->data('pedido_id')]);
            }
            else
                $this->Flash->error('Alguns campos obrigatórios não foram preenchidos. Por favor, tente novamente!');
        }

        $this->set('pedido_id', $pedido_id);
	}

	public function alterar($id)
	{
		$coleta = $this->Coletas->get($id);
	    $this->set('coleta', $coleta);
		
		$this->loadModel('Pedidoscoleta');
		$pedidoColeta = $this->Pedidoscoleta->get($coleta->get('pedido_id'));

	    //VERIFICA SE O PEDIDO PERTENCE AO USUÁRIO LOGADO
	    if($pedidoColeta->get('cooperativa_id') != $this->Auth->user('cooperativa_id'))
	    {
	    	$this->Flash->error('Você não está autorizado a fazer alterações nesta coleta.');
	        return $this->redirect(['action' => 'index']);
	    }
	    
		$this->loadModel('Materiais');
		$this->loadModel('Coletas_materiais');

        //MONTA OPTIONS DO SELECT DE MATERIAIS
		$this->loadModel('Materiais');
		$materiais_options = $this->Materiais->montaSelect();
	 	$this->set('materiais_options',$materiais_options);

	 	//CARREGA OS MATERIAIS
		$this->loadModel('Coletas_materiais');
		$addMateriais = $this->Coletas_materiais->addMateriais($id);
		$this->set('addMateriais',$addMateriais);


		 if ($this->request->is(['patch', 'post', 'put'])) 
		 {
	            $alterou = $this->Coletas->alteraCadastro($id, $coleta, $this->request->data());

				if($alterou)
				{
	                $this->Flash->success('A coleta foi alterada com sucesso.');
	                return $this->redirect(['controller' => 'pedidoscoleta', 'action' => 'visualizar', $pedidoColeta->get('pedido_id')]);
	            }
	            else
	                $this->Flash->error('Ocorreu um erro. Por favor, tente novamente.');
	     }
	}

	public function excluir($id)
    {
		$coleta = $this->Coletas->get($id);
	    $this->set('coleta', $coleta);

		$this->loadModel('Pedidoscoleta');
		$this->loadModel('Coletas_materiais');

		$pedidoColeta = $this->Pedidoscoleta->get($coleta->get('pedido_id'));

    	//VERIFICA SE O PEDIDO PERTENCE AO USUÁRIO LOGADO
	    if($pedidoColeta->get('cooperativa_id') != $this->Auth->user('cooperativa_id'))
	    {
	    	$this->Flash->error('Você não está autorizado a fazer alterações nesta coleta.');
	        return $this->redirect(['controller' => 'pedidoscoleta', 'action' => 'gerenciar']);
	    }
    	
        if ($this->Coletas->delete($coleta)) {
			$this->Coletas_materiais->deleteAll(['coleta_id' => $id]);
            $this->Flash->success('A coleta foi excluída com sucesso.');
        } else {
            $this->Flash->error('A coleta não pôde ser excluída. Por favor, tente novamente.');
        }

        return $this->redirect(['controller' => 'pedidoscoleta', 'action' => 'visualizar', $coleta->get('pedido_id')]);
    }

    public function isAuthorized($user)
    {
        // APENAS COOPERATIVAS LOGADAS PODEM TER ACESSO AO CONTROLLER 
        // EXCETO O MÉTODO CADASTRAR QUE É LIBERADO PARA TODOS
        
        
        if ($this->Auth->user('cooperativa_id') == null)
        {
            return false;
        }
        else
        	return true;

        return false;
    }


}