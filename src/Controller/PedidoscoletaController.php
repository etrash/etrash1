<?php  

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Email\Email;

class PedidoscoletaController extends AppController
{
	public function enviaEmail($id,$text)
	{
		$email = new Email('default');
		$email->from(['me@example.com' => 'My Site'])
			->template('teste')
			->viewVars(['text' => $text])
			->emailFormat('html')
		    ->to('ueak21@gmail.com')
		    ->subject('About')
		    ->send('My message');
	}

	public function index()
	{
		$query = $this->Pedidoscoleta->find('all')
	    ->where(['doador_id = ' => $this->Auth->user('doador_id')]);

	    $PCs = $query->all();
	    $dataPC = $PCs->toArray();

	    $pedidos_coleta ="";
		// Iteration will execute the query.
		foreach ($dataPC as $row) 
		{
			if($row['status_id'] != 4)
			{
				$alterar  = "<div style='float:right'><a href='pedidoscoleta/alterar/".$row['pedido_id']."'>Alterar</a></div><br/>";
				$cancelar =  "<div style='float:right'><a href='pedidoscoleta/cancelar/".$row['pedido_id']."'>Cancelar</a></div>";
			}
			else
			{
				$alterar  = "";
				$cancelar = "";
			}

			$pedidos_coleta .= 
							"<fieldset>
								<legend>Pedido nº ".$row['pedido_id']."</legend>
								
								".$alterar.$cancelar."
								<div>Pedido realizado em ".$row['pedido_datahorainclusao']."</div><br />
								<div>Cooperativa: </div><br />
								<div>Status: ".$row['status_id']."</div><br/>
								<a href=''>Ver detalhes / Coleta</a>
							</fieldset>";
		}

		if(count($dataPC) == 0)
			$pedidos_coleta = "Não há pedidos de coleta cadastrado para sua conta.";

		$this->set('pedidos_coleta',$pedidos_coleta);
	}	

	public function cancelar($id = 0)
	{
		$pedidoColeta = $this->Pedidoscoleta->get($id);
		$this->set('pedidoColeta', $pedidoColeta);
		$this->set('id', $id);

		if ($this->request->is(['patch', 'post', 'put']))
		{
			$pedidoColeta->set('status_id',4);
			$pedidoColeta->set('pedido_motivo',$this->request->data('pedido_motivo'));
			
			if ($this->Pedidoscoleta->save($pedidoColeta)) 
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

		 if ($this->request->is(['patch', 'post', 'put'])) {

	        	//CHECA A SENHA
	            $pedidoColeta = $this->Pedidoscoleta->patchEntity($pedidoColeta, $this->request->data);

			 	$pedidoColeta->set('pedido_periodicidade', $this->request->data('pedido_periodicidade'));
			 	$pedidoColeta->set('pedido_frequencia' , $this->request->data('pedido_frequencia'));
			 	$pedidoColeta->set('pedido_datahoraalteracao'		   , date("Y-m-d H:i:s"));

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
			 			$material->set('pedido_id', $pedidoColeta->get('pedido_id'));
			 			$material->set('material_id', $this->request->data('material_id')[$i]);
			 			$material->set('quantidade_material', $this->request->data('quantidade')[$i]);
			 			$this->Pedidos_coleta_materiais->save($material);
	            	}

	            	for ($i=0; $i < count($dias); $i++) 
	            	{ 
	            		$dia = $this->Pedidos_coleta_horarios->newEntity();
			 			$dia->set('pedido_id', $pedidoColeta->get('pedido_id'));
			 			$dia->set('dia_semana', $this->request->data('dia')[$i]);
			 			$dia->set('horario', $this->request->data('horario')[$i]);
			 			$this->Pedidos_coleta_horarios->save($dia);
	            	}
				
					//$this->enviaEmail($pedidoColeta->get('pedido_id'));

	                $this->Flash->success('O pedido foi alterado com sucesso.');
	                return $this->redirect(['action' => 'index']);
	            } else {
	                $this->Flash->error('Ocorreu um erro. Por favor, tente novamente.');
	            }
	        }
	}
}