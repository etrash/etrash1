<?php  

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

use Cake\View\CellTrait;
use Cake\Core\Configure;


class PedidoscoletaController extends AppController
{
	use CellTrait;
	public $components = array('RequestHandler');

    public function initialize()
	{
    	parent::initialize();

        $this->Auth->config(['unauthorizedRedirect' => '/pedidoscoleta/']);

        $this->Auth->deny();
    }

	public function index()
	{

		if($this->Auth->user('doador_id') == null)
			return $this->redirect(['action' => 'consultar']);

		$pedidos_coleta = $this->Pedidoscoleta->listaPedidos($this->Auth->user('doador_id'));
		
		$this->set('pedidos_coleta',$pedidos_coleta);
	}	

	public function cancelar($id = 0)
	{
		$Pedidoscoleta = $this->Pedidoscoleta->get($id);

	    //VERIFICA SE O PEDIDO PERTENCE AO USUÁRIO LOGADO
	    if($Pedidoscoleta->get('doador_id') != $this->Auth->user('doador_id'))
	    {
	    	$this->Flash->error('O pedido não pertence ao seu usuário.');
	        return $this->redirect(['action' => 'index']);
	    }
	    
		$this->set('pedidoColeta', $Pedidoscoleta);
		$this->set('id', $id);

		if ($this->request->is(['patch', 'post', 'put']))
		{
			if($this->Pedidoscoleta->cancelarPedido($id, $this->request->data('pedido_motivo'), $Pedidoscoleta))
			{
				$this->Flash->success('O pedido foi cancelado com sucesso.');
		        return $this->redirect(['action' => 'index']);
		    }
		    else
		    {
		    	$this->Flash->error('Ocorreu um erro. Por favor, tente novamente.');
		        return $this->redirect(['action' => 'index']);
		    }
	    }
	}

	public function consultar()
	{

		//VERIFICA SE É COOPERATIVA
		if($this->Auth->user('cooperativa_id') == null)
			return $this->redirect(['action' => 'index']);

    	//MONTA OPÇÕES DE MATERIAIS
    	$this->loadModel('Materiais');
		$materiais_options = $this->Materiais->montaCheck($this->request->data());			
		$this->set('materiais_options', $materiais_options);

		$pedidos_coleta = "";
		
        if ($this->request->is('post')) 
        {
        	if($this->request->data('regiao') == null && $this->request->data('material') == null)
	    		$this->Flash->error('É necessário preencher pelo menos um filtro.');
	    	else
	    	{
	    		$pedidos_coleta = $this->Pedidoscoleta->pesquisaPedidos($this->request->data());
				$this->set('pedidos_coleta',$pedidos_coleta);
	    	}

        }
	}

	public function gerenciar()
	{
		//VERIFICA SE É COOPERATIVA
		if($this->Auth->user('cooperativa_id') == null)
			return $this->redirect(['action' => 'index']);

		$pedidos_coleta = "";
		
		$pedidos_coleta = $this->Pedidoscoleta->listaPedidosCoop($this->Auth->user('cooperativa_id'));
		$this->set('pedidos_coleta',$pedidos_coleta);
	}

	public function visualizar($id)
	{
		$Pedidoscoleta = $this->Pedidoscoleta->get($id);

	    //VERIFICA SE O PEDIDO PERTENCE AO USUÁRIO LOGADO
	    if($Pedidoscoleta->get('doador_id') != $this->Auth->user('doador_id') && $Pedidoscoleta->get('cooperativa_id') != $this->Auth->user('cooperativa_id'))
	    {
	    	$this->Flash->error('O pedido não pertence ao seu usuário.');
	        return $this->redirect(['action' => 'index']);
	    }

        //MONTA DIVs do PEDIDO
		$pedido_div = $this->Pedidoscoleta->montaPedido($id, $this->Auth->user('cooperativa_id'));

		//MONTA GRÁFICO
        $this->loadModel('Coletas_materiais');
        $data = $this->Coletas_materiais->montaGrafico(6, $id);
        $this->set('data', $data);

		$this->set('pedido_div', $pedido_div);
		$this->set('id', $id);
	}



	public function pdf($id)
	{
		$Pedidoscoleta = $this->Pedidoscoleta->get($id);

	    //VERIFICA SE O PEDIDO PERTENCE AO USUÁRIO LOGADO
	    if($Pedidoscoleta->get('doador_id') != $this->Auth->user('doador_id') && $Pedidoscoleta->get('cooperativa_id') != $this->Auth->user('cooperativa_id'))
	    {
	    	$this->Flash->error('O pedido não pertence ao seu usuário.');
	        return $this->redirect(['action' => 'index']);
	    }

        //MONTA DIVs do PEDIDO
		$pedido_div = $this->Pedidoscoleta->montaPedido($id, $this->Auth->user('cooperativa_id'));

		//MONTA GRÁFICO
        $this->loadModel('Coletas_materiais');
        $data = $this->Coletas_materiais->montaGrafico(6, $id);
        $this->set('data', $data);
		$this->set('pedido_div', $pedido_div);
 		
	    $CakePdf = new \CakePdf\Pdf\CakePdf();
	    $CakePdf->template('pedido', 'default');
	    $CakePdf->viewVars(['data' => $data, 'pedido_div' => $pedido_div]);
	    //get the pdf string returned
	    $pdf = $CakePdf->output();
	    //or write it to file directly

	    $pdf = $CakePdf->write(WWW_ROOT . DS . 'files' . DS . 'pedido_'.$id.'.pdf');


		if($pdf)
        	return $this->redirect('/files/pedido_'.$id.'.pdf');
 		else
 		{
 			$this->Flash->error('Erro ao gerar PDF!');
        	return $this->redirect(['action' => 'visualizar', $id]);
 		}

	}

	public function ver($id)
	{
		
		//VERIFICA SE É COOPERATIVA
		if($this->Auth->user('cooperativa_id') == null)
			return $this->redirect(['action' => 'index']);
		
		$Pedidoscoleta = $this->Pedidoscoleta->get($id);

		//MONTA DIVs do PEDIDO
		$pedido_div = $this->Pedidoscoleta->montaPedido($id);

		$this->loadModel('Doadores');
		$this->loadModel('Pedidos_coleta_cooperativas');
		
		//CEP e Região
		$doador_endereco = 	$this->Doadores->montaEndereco($Pedidoscoleta->get('doador_id'));

	    //VERIFICA SE JÁ SE CANDIDATOU
	    $candidatou = $this->Pedidos_coleta_cooperativas->seCandidatou($Pedidoscoleta->get('pedido_id'), $this->Auth->user('cooperativa_id'));

		$google_maps = "https://www.google.com/maps/embed/v1/place?key=AIzaSyBfyrDLCLUT4J1gI0DUseA9QiAKwycwmnw&q=".$doador_endereco['doador_cep'];

	    $this->set('doador_endereco', $doador_endereco);
	    $this->set('Pedidoscoleta', $Pedidoscoleta);
	    $this->set('candidatou', $candidatou);
	    $this->set('google_maps', $google_maps);
	    $this->set('pedido_div', $pedido_div);
	}

	public function cadastrar()
	{
		$this->loadModel('Materiais');
		$this->loadModel('Pedidos_coleta_materiais');
		$this->loadModel('Pedidos_coleta_horarios');

		$materiais = $this->Materiais->find('all');

		$data = $materiais->toArray();

        //MONTA OPTIONS DO SELECT DE MATERIAIS
		$this->loadModel('Materiais');
		$materiais_options = $this->Materiais->montaSelect();
	 	$this->set('materiais_options',$materiais_options);
	       
	    $pedidocoleta = $this->Pedidoscoleta->newEntity();

		 if ($this->request->is('post'))
		 {
		 	$cadastrou = $this->Pedidoscoleta->cadastraNovo($this->Auth->user('doador_id'), $this->request->data());

		 	if($cadastrou)
		 	{
		 		$this->Flash->success('O pedido foi cadastrado com sucesso! Você será notificado sobre o interesse das cooperativas sobre este pedido.');
                return $this->redirect(['action' => 'index']);
            }
            else
                $this->Flash->error('Alguns campos obrigatórios não foram preenchidos. Por favor, tente novamente!');
        }
	}

	public function alterar($id)
	{
		$pedidoColeta = $this->Pedidoscoleta->get($id);
	    $this->set('pedidoColeta', $pedidoColeta);

	    //VERIFICA SE O PEDIDO PERTENCE AO USUÁRIO LOGADO
	    if($pedidoColeta->get('doador_id') != $this->Auth->user('doador_id'))
	    {
	    	$this->Flash->error('O pedido não pertence ao seu usuário.');
	        return $this->redirect(['action' => 'index']);
	    }
	    
		$this->loadModel('Cooperativas');
		$this->loadModel('Doadores');
		$this->loadModel('Materiais');
		$this->loadModel('Pedidos_coleta_materiais');
		$this->loadModel('Pedidos_coleta_horarios');

        //MONTA OPTIONS DO SELECT DE MATERIAIS
		$this->loadModel('Materiais');
		$materiais_options = $this->Materiais->montaSelect();
	 	$this->set('materiais_options',$materiais_options);

	 	//CARREGA OS MATERIAIS
		$this->loadModel('Pedidos_coleta_materiais');
		$addMateriais = $this->Pedidos_coleta_materiais->addMateriais($id);
		$this->set('addMateriais',$addMateriais);

	 	//CARREGA OS HORÁRIOS
		$this->loadModel('Pedidos_coleta_horarios');
		$addHorarios = $this->Pedidos_coleta_horarios->addHorarios($id);
		$this->set('addHorarios',$addHorarios);

		 if ($this->request->is(['patch', 'post', 'put'])) 
		 {
	            $alterou = $this->Pedidoscoleta->alteraCadastro($id, $pedidoColeta, $this->request->data());

				if($alterou)
				{
	                $this->Flash->success('O pedido foi alterado com sucesso.');
	                return $this->redirect(['action' => 'index']);
	            }
	            else
	                $this->Flash->error('Ocorreu um erro. Por favor, tente novamente.');
	     }
	}

	public function candidatar()
	{
		//VERIFICA SE É COOPERATIVA
		if($this->Auth->user('cooperativa_id') == null)
			return $this->redirect(['action' => 'index']);
		
		$this->loadModel('Pedidos_coleta_cooperativas');
		$pedido_id = $this->request->data('pedido_id');
		$Pedidoscoleta = $this->Pedidoscoleta->get($pedido_id);
		$cooperativa_id = $this->Auth->user('cooperativa_id');
		
		$candidatura = $this->Pedidos_coleta_cooperativas->seCandidatou($Pedidoscoleta->get('pedido_id'), $cooperativa_id);

		if($candidatura != null || $Pedidoscoleta->get('cooperativa_id') > 0)
		{
            $this->Flash->error('Infelizmente esse pedido não está mais disponível.');
            return $this->redirect(['action' => 'ver', 'id' => $pedido_id]);
		}			
		else
		{
			$coop = $this->Pedidos_coleta_cooperativas->newEntity();
			$coop->set('pedido_id', $pedido_id);
			$coop->set('cooperativa_id', $cooperativa_id);

			if($this->Pedidos_coleta_cooperativas->save($coop))
			{
				$this->loadModel('Doadores');
				$this->loadModel('Cooperativas');
				
				//ENVIA E-MAIL PARA O DOADOR
				$confirmar_url =  "http://" . Router::url(array('controller'=>'pedidoscoleta', 'action'=>'confirmar')) . "/" . $pedido_id;

				$doador = $this->Doadores->get($Pedidoscoleta->get('doador_id'));
				$cooperativa = $this->Cooperativas->get($cooperativa_id);

				$email = new Email('default');
						$email->from(['ueak21@gmail.com' => 'E-TRASH'])
							->template('candidatura_doador')
							->viewVars(['nome' => $doador->get('doador_nome'), 'pedido_id' => $pedido_id, 'link' => $confirmar_url, 'cooperativa_nome' => $cooperativa->get('cooperativa_nome')])
							->emailFormat('html')
						    ->to($doador->get('doador_email'))
						    ->subject('Cooperativa interessada em pedido de coleta')
						    ->send('My message');

				//ENVIA E-MAIL PARA A COOPERATIVA
				$email = new Email('default');
						$email->from(['ueak21@gmail.com' => 'E-TRASH'])
							->template('candidatura_coop')
							->viewVars(['nome' => $cooperativa->get('responsavel_nome'), 'pedido_id' => $pedido_id])
							->emailFormat('html')
						    ->to($doador->get('doador_email'))
						    ->subject('Confirmação de candidatura')
						    ->send('My message');

	            $this->Flash->success('Parabéns! Você acabou de se candidatar para um pedido de coleta.');
	         	return $this->redirect(['action' => 'consultar']);
			}
	        else
	        {
	            $this->Flash->error('Ops! Ocorreu algum erro. Por favor, tente novamente.');
	            return $this->redirect(['action' => 'ver', 'id' => $pedido_id]);
	        }
		}
	}

	public function confirmar($id)
	{
		//LISTA DE COOPERATIVAS
		$this->loadModel('Cooperativas');

		$cooperativas = $this->Cooperativas->listaCandidatas($id);

		//CHECA SE HÁ COOPERATIVAS INTERESSADAS
		if(is_null($cooperativas))
			$cooperativas_div = "Não há cooperativas interessadas no pedido de coleta.";
		else
			foreach ($cooperativas as $row) 
				$cooperativas_div .= $this->cell('Pedidoscoleta', ['nome' => $row['cooperativa_nome'], 'doacao' => $row['$cooperativa_doacao'], 'cooperativa_id' => $row['cooperativa_id'], 'pedido_id' => $id]);

		$this->set('cooperativas', $cooperativas_div);
	}

	public function eleger($id, $cooperativa_id)
	{
		$pedidoColeta = $this->Pedidoscoleta->get($id);
	    $this->set('pedidoColeta', $pedidoColeta);

	    //VERIFICA SE O PEDIDO PERTENCE AO USUÁRIO LOGADO
	    if($pedidoColeta->get('doador_id') != $this->Auth->user('doador_id'))
	    {
	    	$this->Flash->error('O pedido não pertence ao seu usuário.');
	        return $this->redirect(['action' => 'index']);
	    }
	    else
	    {
			$pedidoColeta->set('cooperativa_id', $cooperativa_id);
			$pedidoColeta->set('status_id', 2);
			if($this->Pedidoscoleta->save($pedidoColeta))
			{
				$this->loadModel('Doadores');
				$this->loadModel('Cooperativas');

				//ENVIA E-MAIL PARA A COOPERAITVA ELEITA E PARA O DOADOR
				$doador = $this->Doadores->get($pedidoColeta->get('doador_id'));
				$cooperativa = $this->Cooperativas->get($cooperativa_id);

				$cadastrar_url =  "http://" . Router::url(array('controller'=>'coletas', 'action'=>'cadastrar')) . "/" . $pedido_id;

				$email = new Email('default');
						$email->from(['ueak21@gmail.com' => 'E-TRASH'])
							->template('eleicao_doador')
							->viewVars(['nome' => $doador->get('doador_nome'), 'pedido_id' => $id, 'cooperativa_nome' => $cooperativa->get('cooperativa_nome')])
							->emailFormat('html')
						    ->to($doador->get('doador_email'))
						    ->subject('Cooperativa escolhida para pedido de coleta')
						    ->send('My message');

				//ENVIA E-MAIL PARA A COOPERATIVA
				$email = new Email('default');
						$email->from(['ueak21@gmail.com' => 'E-TRASH'])
							->template('eleicao_coop')
							->viewVars(['nome' => $cooperativa->get('responsavel_nome'), 'pedido_id' => $id, 'link' => $cadastrar_url])
							->emailFormat('html')
						    ->to($doador->get('doador_email'))
						    ->subject('Sua cooperativa foi escolhida!')
						    ->send('My message');

		    	$this->Flash->success('A operação foi efetuada com sucesso! A cooperativa será notificada.');
		        return $this->redirect(['action' => 'index']);
			}
			else
			{
		    	$this->Flash->error('Houve algum erro. Por favor, tente novamente.');
		        return $this->redirect(['action' => 'index']);
			}
	    }
	}

    public function isAuthorized($user)
    {
    	if($this->request->action === 'index' || $this->request->action === 'visualizar')
    		return true;

        if($this->Auth->user('doador_id') == null && $this->request->action != 'consultar' && $this->request->action != 'ver' && $this->request->action != 'candidatar'  && $this->request->action != 'gerenciar')
        	return false;
        elseif($this->Auth->user('cooperativa_id') == null && $this->request->action === 'consultar' && $this->request->action === 'ver'  && $this->request->action === 'candidatar')
        	return false;

        return true;
    }
}