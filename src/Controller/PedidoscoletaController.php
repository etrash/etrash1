<?php  

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class PedidoscoletaController extends AppController
{
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
			$materiais_options[$material_nome] = $material_nome;
		}

		 $this->set('materiais_options',$materiais_options);
	       
	     $pedidocoleta = $this->Pedidoscoleta->newEntity();

		 if ($this->request->is('post'))
		 {
		 	$pedidocoleta->set('doador_id'         , $this->Auth->user('doador_id'));
		 	$pedidocoleta->set('status_id'         , 1);
		 	$pedidocoleta->set('pedido_periocidade', $this->request->data('pedido_periodicidade'));
		 	$pedidocoleta->set('pedido_frequencia' , $this->request->data('pedido_frequencia'));
		 	$pedidocoleta->set('pedido_obs'		   , $this->request->data('pedido_observacoes'));

		 	$materiais   = $this->request->data('material');
		 	$quantidades = $this->request->data('quantidade');

		 	$dias 	  = $this->request->data('dia');
		 	$horarios = $this->request->data('horario');

            if ($this->Pedidoscoleta->save($pedidocoleta)) 
            {
            	for ($i=0; $i < count($materiais); $i++) 
            	{ 
            		$material = $this->Pedidos_coleta_materiais->newEntity();
		 			$material->set('pedido_id', $pedidocoleta->get('pedido_id'));
		 			$material->set('nome_material', $this->request->data('material')[$i]);
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

                $this->Flash->success('O pedido foi cadastrado com sucesso! O número do pedido é '. $pedidocoleta->get('pedido_id'));
                //return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('Ocorram os seguintes erros abaixo. Por favor, tente novamente!');
            }
        }

	}
}