<?php  

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

class PedidoscoletaController extends AppController
{

    public function initialize()
	{
    	parent::initialize();

        $this->Auth->config(['unauthorizedRedirect' => '/pedidoscoleta/']);

        $this->Auth->deny();
    
    }

	public function index()
	{

		$this->loadModel('Pedido_coleta_status');

		if($this->Auth->user('doador_id') == null)
			return $this->redirect(['action' => 'consultar']);

		$query = $this->Pedidoscoleta->find('all')
	    ->where(['doador_id = ' => $this->Auth->user('doador_id')]);

	    $PCs = $query->all();
	    $dataPC = $PCs->toArray();

	    $pedidos_coleta ="";
		// Iteration will execute the query.
		foreach ($dataPC as $row) 
		{
			$visualizar_url  =  Router::url(array('controller'=>'pedidoscoleta', 'action'=>'visualizar')) . "/".$row['pedido_id'];

			if($row['status_id'] != 4)
			{
				$alterar_url  =  Router::url(array('controller'=>'pedidoscoleta', 'action'=>'alterar'));
				$cancelar_url =  Router::url(array('controller'=>'pedidoscoleta', 'action'=>'cancelar'));

				$alterar  = "<div style='float:right'><a href='".$alterar_url."/".$row['pedido_id']."'>Alterar</a></div><br/>";
				$cancelar =  "<div style='float:right'><a href='".$cancelar_url."/".$row['pedido_id']."'>Cancelar</a></div>";
			}
			else
			{
				$alterar  = "";
				$cancelar = "";
			}

			$status = $this->Pedido_coleta_status->get($row['status_id']);
			
			$pedidos_coleta .= 
							"<fieldset>
								<legend>Pedido nº ".$row['pedido_id']."</legend>
								
								".$alterar.$cancelar."
								<div>Pedido realizado em ".$row['pedido_datahorainclusao']."</div><br />
								<div>Cooperativa: </div><br />
								<div>Status: ".$status['status_nome']."</div><br/>
								<a href='".$visualizar_url."'>Ver detalhes / Coletas</a>
							</fieldset>";
		}

		if(count($dataPC) == 0)
			$pedidos_coleta = "Não há pedidos de coleta cadastrado para sua conta.";

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
			$Pedidoscoleta->set('status_id',4);
			$Pedidoscoleta->set('pedido_motivo',$this->request->data('pedido_motivo'));
			
			if ($this->Pedidoscoleta->save($Pedidoscoleta)) 
		    {

				$this->loadModel('Cooperativas');
				$this->loadModel('Doadores');

            	//Carrega dados do doador
            	$doador = $this->Doadores->get($Pedidoscoleta->get('doador_id'));

				$email = new Email('default');
				$email->from(['ueak21@gmail.com' => 'E-TRASH'])
					->template('exclusao')
					->viewVars(['nome' => $doador->get('doador_nome'), 'pedido_id' => $Pedidoscoleta->get('pedido_id'), 'motivo' => $this->request->data('pedido_motivo')])
					->emailFormat('html')
				    ->to($doador->get('doador_email'))
				    ->subject('Cancelamento de pedido de coleta')
				    ->send('My message');

            	//Envia para a(s) cooperativa(s)
				if($Pedidoscoleta->get('cooperativa_id') > 0)
				{

	            	$cooperativa = $this->Cooperativas->get($Pedidoscoleta->get('cooperativa_id'));

					$email = new Email('default');
					$email->from(['ueak21@gmail.com' => 'E-TRASH'])
						->template('exclusao')
						->viewVars(['nome' => $cooperativa->get('cooperativa_nome'), 'pedido_id' => $Pedidoscoleta->get('pedido_id'), 'motivo' => $this->request->data('pedido_motivo')])
						->emailFormat('html')
					    ->to($cooperativa->get('cooperativa_email'))
					    ->subject('Cancelamento de pedido de coleta')
					    ->send('My message');
				}

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

	}

	public function visualizar($id)
	{
		$Pedidoscoleta = $this->Pedidoscoleta->get($id);

	    //VERIFICA SE O PEDIDO PERTENCE AO USUÁRIO LOGADO
	    if($Pedidoscoleta->get('doador_id') != $this->Auth->user('doador_id'))
	    {
	    	$this->Flash->error('O pedido não pertence ao seu usuário.');
	        return $this->redirect(['action' => 'index']);
	    }

		$this->loadModel('Cooperativas');
		$this->loadModel('Doadores');
		$this->loadModel('Materiais');
		$this->loadModel('Pedidos_coleta_materiais');
		$this->loadModel('Pedidos_coleta_horarios');
		$this->loadModel('Pedido_coleta_status');

		$materiais = $this->Materiais->find('all');

		$queryPCM = $this->Pedidos_coleta_materiais->find('all')
	    ->where(['Pedidos_coleta_materiais.pedido_id = ' => $id]);

	    $PCMs = $queryPCM->all();
	    $dataPCM = $PCMs->toArray();

		$queryPCH = $this->Pedidos_coleta_horarios->find('all')
	    ->where(['Pedidos_coleta_horarios.pedido_id = ' => $id]);

	    $PCHs = $queryPCH->all();
	    $dataPCH = $PCHs->toArray();

	    $materiais_div = "";
		$horarios_div = "";

		// Iteration will execute the query.
		foreach ($materiais as $row) 
		{
			$material_nome = $row['material_nome'];
			$material_id = $row['material_id'];
			$materiais_options[$material_id] = $material_nome;
		}

		// Iteration will execute the query.
		foreach ($dataPCM as $row) 
		{
			$materiais_div .= "Material: ".$materiais_options[$row['material_id']]." | Quantidade: ".$row['quantidade_material']."<br/>\n";
		}

		// Iteration will execute the query.
		foreach ($dataPCH as $row) 
		{
			$date = strtotime($row['horario']);
			$horarios_div .= "Dia da semana: ".$row['dia_semana']." | Horário: ".date('H', $date).":".date('i', $date)."<br/>\n";
		}

		$this->set('materiais_div', $materiais_div);
		$this->set('horarios_div', $horarios_div);

		//CARREGA DADOS DA TABELA PEDIDO
		$this->set('datahora_inclusao', $Pedidoscoleta->get('pedido_datahorainclusao'));

		$status = $this->Pedido_coleta_status->get($Pedidoscoleta->get('status_id'));
		$this->set('status', $status['status_nome']);

		$this->set('periodicidade', $Pedidoscoleta->get('pedido_periodicidade'));
		$this->set('frequencia', $Pedidoscoleta->get('pedido_frequencia'));
		$this->set('observacoes', $Pedidoscoleta->get('pedido_obs'));

		if($status['status_id'] == 4 && $Pedidoscoleta->get('pedido_motivo') != "")
		{
			$cancelamento_div = "<div>Motivo do cancelamento: <br/> ".$Pedidoscoleta->get('pedido_motivo')."</div>";
			$this->set('cancelamento_div',$cancelamento_div);
		}

		if($Pedidoscoleta->get('cooperativa_id') > 0)
		{
			$cooperativa = $this->Cooperativas->get($Pedidoscoleta->get('cooperativa_id'));
			$this->set('cooperativa_nome', $cooperativa->get('cooperativa_nome'));
			$this->set('cooperativa_email', $cooperativa->get('cooperativa_email'));
			$this->set('cooperativa_telefone', $cooperativa->get('cooperativa_telefone'));

			$cooperativa_div = "Nome: " . $cooperativa->get('cooperativa_nome') . "<br/>".
							   "E-mail: " .  $cooperativa->get('cooperativa_email') . "<br/>".
							   "Telefone: " .  $cooperativa->get('cooperativa_telefone');
		}
		else
			$cooperativa_div = "Ainda não há uma cooperativa contratada para este pedido.";

		$this->set('cooperativa_div',$cooperativa_div);

	}

	public function cadastrar()
	{
		$this->loadModel('Materiais');
		$this->loadModel('Pedidos_coleta_materiais');
		$this->loadModel('Pedidos_coleta_horarios');

		$materiais = $this->Materiais->find('all');

		$data = $materiais->toArray();

		// Iteration will execute the query.
		foreach ($materiais as $row) 
		{
			$material_nome = $row['material_nome'];
			$material_id = $row['material_id'];
			$materiais_options[$material_id] = $material_nome;
		}

		 $this->set('materiais_options',$materiais_options);
	       
	     $pedidocoleta = $this->Pedidoscoleta->newEntity();

		 if ($this->request->is('post'))
		 {
		 	$pedidocoleta->set('doador_id'         , $this->Auth->user('doador_id'));
		 	$pedidocoleta->set('status_id'         , 1);
		 	$pedidocoleta->set('pedido_periodicidade', $this->request->data('pedido_periodicidade'));
		 	$pedidocoleta->set('pedido_frequencia' , $this->request->data('pedido_frequencia'));
		 	$pedidocoleta->set('pedido_datahorainclusao'		   , date("Y-m-d H:i:s"));

		 	$materiais   = $this->request->data('material_id');
		 	$quantidades = $this->request->data('quantidade');

		 	$dias 	  = $this->request->data('dia');
		 	$horarios = $this->request->data('horario');

            if ($this->Pedidoscoleta->save($pedidocoleta)) 
            {
            	for ($i=0; $i < count($materiais); $i++) 
            	{ 
            		$material = $this->Pedidos_coleta_materiais->newEntity();
		 			$material->set('pedido_id', $pedidocoleta->get('pedido_id'));
		 			$material->set('material_id', $this->request->data('material_id')[$i]);
		 			$material->set('quantidade_material', $this->request->data('quantidade')[$i]);
		 			$this->Pedidos_coleta_materiais->save($material);
            	}

            	for ($i=0; $i < count($dias); $i++) 
            	{ 
            		$dia = $this->Pedidos_coleta_horarios->newEntity();
		 			$dia->set('pedido_id', $pedidocoleta->get('pedido_id'));
		 			$dia->set('dia_semana', $this->request->data('dia')[$i]);
		 			$dia->set('horario', $this->request->data('horario')[$i]);
		 			$this->Pedidos_coleta_horarios->save($dia);
            	}

                $this->Flash->success('O pedido foi cadastrado com sucesso! Você será notificado sobre o interesse das cooperativas sobre este pedido. O número do pedido é '. $pedidocoleta->get('pedido_id'));
                return $this->redirect(['action' => 'index']);
            }
            else 
            {
                $this->Flash->error('Ocorram os seguintes erros abaixo. Por favor, tente novamente!');
            }
        }
	}

	public function alterar($id = 0)
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

		$materiais = $this->Materiais->find('all');

		$queryPCM = $this->Pedidos_coleta_materiais->find('all')
	    ->where(['Pedidos_coleta_materiais.pedido_id = ' => $id]);

	    $PCMs = $queryPCM->all();
	    $dataPCM = $PCMs->toArray();

		$queryPCH = $this->Pedidos_coleta_horarios->find('all')
	    ->where(['Pedidos_coleta_horarios.pedido_id = ' => $id]);

	    $PCHs = $queryPCH->all();
	    $dataPCH = $PCHs->toArray();

	    $addMateriais = "";
		$addHorarios = "";

		// Iteration will execute the query.
		foreach ($materiais as $row) 
		{
			$material_nome = $row['material_nome'];
			$material_id = $row['material_id'];
			$materiais_options[$material_id] = $material_nome;
		}

		// Iteration will execute the query.
		foreach ($dataPCM as $row) 
		{
			$addMateriais .= "addMaterial(".$row['material_id'].", '".$materiais_options[$row['material_id']]."', ".$row['quantidade_material'].");\n";
		}

		// Iteration will execute the query.
		 foreach ($dataPCH as $row) 
		 {
		 	$date = strtotime($row['horario']);
		 	$addHorarios .= "addDias('".date('H', $date)."', '".date('i', $date)."', '".$row['dia_semana']."');\n";
		 }

		$this->set('materiais_options',$materiais_options);

		$this->set('addMateriais',$addMateriais);

		$this->set('addHorarios',$addHorarios);

		 if ($this->request->is(['patch', 'post', 'put'])) 
		 {
	        	//CHECA A SENHA
	            $Pedidoscoleta = $this->Pedidoscoleta->patchEntity($pedidoColeta, $this->request->data);

			 	$Pedidoscoleta->set('pedido_periodicidade', $this->request->data('pedido_periodicidade'));
			 	$Pedidoscoleta->set('pedido_frequencia' , $this->request->data('pedido_frequencia'));
			 	$Pedidoscoleta->set('pedido_datahoraalteracao'		   , date("Y-m-d H:i:s"));

	            if ($this->Pedidoscoleta->save($pedidoColeta)) 
	            {

					$this->Pedidos_coleta_materiais->deleteAll(['pedido_id' => $id]);
					$this->Pedidos_coleta_horarios->deleteAll(['pedido_id' => $id]);

				 	$materiais   = $this->request->data('material_id');
				 	$quantidades = $this->request->data('quantidade');

				 	$dias 	  = $this->request->data('dia');
				 	$horarios = $this->request->data('horario');

					for ($i=0; $i < count($materiais); $i++) 
	            	{ 
	            		$material = $this->Pedidos_coleta_materiais->newEntity();
			 			$material->set('pedido_id', $Pedidoscoleta->get('pedido_id'));
			 			$material->set('material_id', $this->request->data('material_id')[$i]);
			 			$material->set('quantidade_material', $this->request->data('quantidade')[$i]);
			 			$this->Pedidos_coleta_materiais->save($material);
	            	}

	            	for ($i=0; $i < count($dias); $i++) 
	            	{ 
	            		$dia = $this->Pedidos_coleta_horarios->newEntity();
			 			$dia->set('pedido_id', $Pedidoscoleta->get('pedido_id'));
			 			$dia->set('dia_semana', $this->request->data('dia')[$i]);
			 			$dia->set('horario', $this->request->data('horario')[$i]);
			 			$this->Pedidos_coleta_horarios->save($dia);
	            	}

	            	//Carrega dados do doador
	            	$doador = $this->Doadores->get($Pedidoscoleta->get('doador_id'));

					$visualizar_url =  "http://" . Router::url(array('controller'=>'pedidoscoleta', 'action'=>'visualizar')) . "/" . $Pedidoscoleta->get('pedido_id');

					$email = new Email('default');
					$email->from(['ueak21@gmail.com' => 'E-TRASH'])
						->template('alteracao')
						->viewVars(['nome' => $doador->get('doador_nome'), 'pedido_id' => $Pedidoscoleta->get('pedido_id'), 'link' => $visualizar_url])
						->emailFormat('html')
					    ->to($doador->get('doador_email'))
					    ->subject('Alteração de pedido de coleta')
					    ->send('My message');


	                $this->Flash->success('O pedido foi alterado com sucesso.');
	                return $this->redirect(['action' => 'index']);
	            } else {
	                $this->Flash->error('Ocorreu um erro. Por favor, tente novamente.');
	            }
	     }
	}


    public function isAuthorized($user)
    {
    	if($this->request->action === 'index')
    		return true;

        if($this->Auth->user('doador_id') == null && $this->request->action != 'consultar')
        	return false;
        elseif($this->Auth->user('cooperativa_id') == null && $this->request->action === 'consultar')
        	return false;

        return true;
    }
}