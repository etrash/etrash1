<?php
	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;
    use Cake\ORM\TableRegistry;
	use Cake\Routing\Router;
	use Cake\Network\Email\Email;
	use Cake\I18n\Number;

	use Cake\View\CellTrait;

	class PedidoscoletaTable extends Table
	{
		use CellTrait;

		public function initialize(array $config)
	    {
	        $this->addBehavior('Timestamp', [
	            'events' => [
	                'Model.beforeSave' => [
	                    'pedido_datahorainclusao' => 'new',
	                    'pedido_datahoraalteracao' => 'always',
	                ]
	            ]
	        ]);
	    }

	    public function validationDefault(Validator $validator)
	    {
	       $validator
	        ->notEmpty('pedido_periodicidade', "Campo obrigatório")
			->notEmpty('pedido_frequencia', "Campo obrigatório");

		    return $validator;
		}

		public function listaPedidos($doador_id)
		{
			$query = $this->find('all')
		    ->where(['doador_id = ' => $doador_id]);

		    $PCs = $query->all();
		    $dataPC = $PCs->toArray();

		    $pedidos_coleta ="";
					
			$this->Cooperativas = TableRegistry::get('Cooperativas');


			foreach ($dataPC as $row) 
			{
				$visualizar_url  =  Router::url(array('controller'=>'pedidoscoleta', 'action'=>'visualizar')) . "/".$row['pedido_id'];

				if(is_null($row['cooperativa_id']))
					$cooperativa_nome = "";
				else
				{
					$cooperativa = $this->Cooperativas->get($row['cooperativa_id']);
					$cooperativa_nome = "<div><strong>Cooperativa: </strong>".$cooperativa->get('cooperativa_nome')."</div>";

				}

				if($row['status_id'] != 3)
				{
					$alterar_url  =  Router::url(array('controller'=>'pedidoscoleta', 'action'=>'alterar'));
					$cancelar_url =  Router::url(array('controller'=>'pedidoscoleta', 'action'=>'cancelar'));

					if(is_null($row['cooperativa_id']))
					{
						$confirmar_url =   Router::url(array('controller'=>'pedidoscoleta', 'action'=>'confirmar'));
						$confirmar =  "<a class='btn btn-sm btn-success' href='".$confirmar_url."/".$row['pedido_id']."'>Eleger Cooperativa</a>";
					}
					else
					{
						$confirmar_url = "";
						$confirmar =  "";
					}


					$alterar  = "<a class='btn btn-sm btn-warning' href='".$alterar_url."/".$row['pedido_id']."'>Alterar</a>";
					$cancelar = "<a class='btn btn-sm btn-danger' href='".$cancelar_url."/".$row['pedido_id']."'>Cancelar</a>";
				}
				else
				{
					$alterar  = "";
					$cancelar = "";
				}
				
				$this->Pedido_coleta_status = TableRegistry::get('Pedido_coleta_status');
				
				$status = $this->Pedido_coleta_status->get($row['status_id']);
				
				$pedidos_coleta .= 
								"<fieldset class='pedido'>
									<legend>Pedido <span class='number'>".$row['pedido_id']."</span></legend>
									<div class='float-right btn-group'>".$confirmar.$alterar.$cancelar."</div>
									<div><strong>Pedido cadastrado em </strong>".$row['pedido_datahorainclusao']."</div>
									".$cooperativa_nome."
									<div><strong>Status: </strong>".$status['status_nome']."</div>
									<a href='".$visualizar_url."' class='btn btn-default btn-success btn-xs'>Ver detalhes / Coletas</a>
								</fieldset>";
			}

			if(count($dataPC) == 0)
				$pedidos_coleta = "Não há pedidos de coleta cadastrado para sua conta.";

			return $pedidos_coleta;
		}

		public function cancelarPedido($id, $motivo)
		{
			$pedido = $this->get($id);
			$pedido->set('status_id',3);
			$pedido->set('pedido_motivo',$motivo);
			
			if ($this->save($pedido)) 
		    {

				$this->Cooperativas = TableRegistry::get('Cooperativas');
				$this->Doadores = TableRegistry::get('Doadores');

            	//Carrega dados do doador
            	$doador = $this->Doadores->get($pedido->get('doador_id'));

				$email = new Email('default');
				$email->from(['ueak21@gmail.com' => 'E-TRASH'])
					->template('exclusao')
					->viewVars(['nome' => $doador->get('doador_nome'), 'pedido_id' => $pedido->get('pedido_id'), 'motivo' => $motivo])
					->emailFormat('html')
				    ->to($doador->get('doador_email'))
				    ->subject('Cancelamento de pedido de coleta')
				    ->send('My message');

            	//Envia para a(s) cooperativa(s)
				if($pedido->get('cooperativa_id') > 0)
				{

	            	$cooperativa = $this->Cooperativas->get($pedido->get('cooperativa_id'));

					$email = new Email('default');
					$email->from(['ueak21@gmail.com' => 'E-TRASH'])
						->template('exclusao')
						->viewVars(['nome' => $cooperativa->get('cooperativa_nome'), 'pedido_id' => $pedido->get('pedido_id'), 'motivo' => $motivo])
						->emailFormat('html')
					    ->to($cooperativa->get('cooperativa_email'))
					    ->subject('Cancelamento de pedido de coleta')
					    ->send('My message');
				}

		        return true;
		    }
	        else 
	        {
		        return false;
	        }
		}

		public function pesquisaPedidos($data)
		{
			$join = array();
    		$where = array();

    		$where['Pedidoscoleta.status_id'] = 1;

    		if($data['regiao'] != null)
    		{
    			$join['d'] = [
					            'table' => 'doadores',
					            'type' => 'INNER',
					            'conditions' => 'Pedidoscoleta.doador_id = d.doador_id'
					         ];

				$where['doador_regiao'] = $data['regiao'];
    		}

    		if($data['material'] != null)
    		{
    			$whereM = array();

    			$join['m'] = [
					            'table' => 'pedidos_coleta_materiais',
					            'type' => 'INNER',
					            'conditions' => 'Pedidoscoleta.pedido_id = m.pedido_id'
					         ];

				//print_r($data['material'));

				foreach ($data['material'] as $material_id) {
					$whereM[] = array('material_id' => $material_id);
				}

				$where['OR'] = $whereM;
    		}

			$query = $this->find()
		    ->hydrate(false)
		    ->join($join)
		    ->where($where)
		    ->group('Pedidoscoleta.pedido_id');

			$PCs = $query->all();
    		$dataPC = $PCs->toArray();

    		$pedidos_coleta ="";

 			$this->Pedido_coleta_status = TableRegistry::get('Pedido_coleta_status');
 			$this->Doadores = TableRegistry::get('Doadores');
 			$this->Materiais = TableRegistry::get('Materiais');

			foreach ($dataPC as $row) 
			{
				$ver_url  =  Router::url(array('controller'=>'pedidoscoleta', 'action'=>'ver')) . "/".$row['pedido_id'];

				$status = $this->Pedido_coleta_status->get($row['status_id']);
				
				//MATERIAIS DO PEDIDO
				$queryM = $this->Materiais->find()
			    ->hydrate(false)
			    ->select(['material_nome'])
			    ->join(['pcm' => [
					            'table' => 'pedidos_coleta_materiais',
					            'type' => 'INNER',
					            'conditions' => 'Materiais.material_id = pcm.material_id'
					         ]])
			    ->where(['pedido_id' => $row['pedido_id']])
			    ->group('Materiais.material_id');

				$materiais = $queryM->all();
	    		
	    		$materiais_pedido = "";

	    		foreach ($materiais as $rowM) 
					$materiais_pedido .= "<li>".$rowM['material_nome'] . "</li>";

	    		$pedidos_coleta ="";

	    		//Região
	    		$queryD = $this->Doadores->find()
			    ->hydrate(false)
			    ->select(['doador_regiao'])
			    ->where(['doador_id' => $row['doador_id']]);

			    $regiao = $queryD->first()['doador_regiao'];

				$pedidos_coleta .= 
								"<fieldset>
									<legend>Pedido nº ".$row['pedido_id']."</legend>
									<div>Pedido cadastrado em ".$row['pedido_datahorainclusao']."</div><br />
									<div>Status: ".$status['status_nome']."</div><br/>
									<div>Materiais:<br/><ul>".$materiais_pedido."</ul></div><br/>
									<div>Região: ".$regiao."</div><br/>
									<a href='".$ver_url."'>Ver mais informações</a>
								</fieldset>";
			}

			if(count($dataPC) == 0)
				$pedidos_coleta = "Não há pedidos de coleta cadastrado com os filtros selecionados.";
			else
				$pedidos_coleta = "
									<fieldset>
										<legend>Pedidos de Coleta encontrados</legend>
										$pedidos_coleta
									</fieldset>
									";

			return $pedidos_coleta;
		}

		public function montaPedido($id, $user_cooperativa_id = null)
		{
			$pedido = $this->get($id);

	        //MONTA OPTIONS DO SELECT DE MATERIAIS
			$this->Materiais = TableRegistry::get('Materiais');
			$materiais_options = $this->Materiais->montaSelect();

			$this->Cooperativas 			= TableRegistry::get('Cooperativas');
			$this->Doadores 				= TableRegistry::get('Doadores');
			$this->Pedidos_coleta_materiais = TableRegistry::get('Pedidos_coleta_materiais');
			$this->Pedido_coleta_status 	= TableRegistry::get('Pedido_coleta_status');
			$this->Pedidos_coleta_horarios 	= TableRegistry::get('Pedidos_coleta_horarios');

			$queryPCM = $this->Pedidos_coleta_materiais->find('all')
		    ->where(['Pedidos_coleta_materiais.pedido_id = ' => $id]);

			$queryPCH = $this->Pedidos_coleta_horarios->find('all')
		    ->where(['Pedidos_coleta_horarios.pedido_id = ' => $id]);

		    $PCHs = $queryPCH->all();
		    $dataPCH = $PCHs->toArray();

		    $PCMs = $queryPCM->all();
		    $dataPCM = $PCMs->toArray();

		    $materiais_div = "";
			$horarios_div = "";

			$row = null;

			foreach ($dataPCM as $row) 
			{
				$materiais_div .= "Material: ".$materiais_options[$row['material_id']]." | Quantidade: ".$row['quantidade_material']." KG<br/>\n";
			}
			
			$row = null;

			foreach ($dataPCH as $row) 
			{
				$horarios_div .= "Dia da semana: ".$row['dia_semana']." | ".$row['horario_intervalo']."<br/>\n";
			}

			$pedido_div['materiais_div'] = $materiais_div;
			$pedido_div['horarios_div']  = $horarios_div;

			//CARREGA DADOS DA TABELA PEDIDO
			$pedido_div['datahora_inclusao'] = $pedido->get('pedido_datahorainclusao');

			$status = $this->Pedido_coleta_status->get($pedido->get('status_id'));
			$pedido_div['status'] = $status['status_nome'];

			$pedido_div['periodicidade']  =	$pedido->get('pedido_periodicidade');
			$pedido_div['frequencia'] 	  =	$pedido->get('pedido_frequencia');
			$pedido_div['observacoes'] 	  =	$pedido->get('pedido_obs');

			if($status['status_id'] == 3 && $pedido->get('pedido_motivo') != "")
			{
				$cancelamento_div = "<div>Motivo do cancelamento: <br/> ".$pedido->get('pedido_motivo')."</div>";
				$pedido_div['cancelamento_div'] = $cancelamento_div;
			}

			if($pedido->get('cooperativa_id') > 0)
			{
				$cooperativa = $this->Cooperativas->get($pedido->get('cooperativa_id'));

				$cooperativa_div = "Nome: " . $cooperativa->get('cooperativa_nome') . "<br/>".
								   "E-mail: " .  $cooperativa->get('cooperativa_email') . "<br/>".
								   "Telefone: " .  $cooperativa->get('cooperativa_telefone');
			}
			else
				$cooperativa_div = "Ainda não há uma cooperativa contratada para este pedido.";

			$pedido_div['cooperativa_div'] 	=	$cooperativa_div;

			$pedido_div['pedido_obs'] 	  	=	$pedido->get('pedido_obs');

			//MONTA COLETAS
			$this->Coletas 			= TableRegistry::get('Coletas');
			$pedido_div['coletas'] = $this->Coletas->listaColetas($id, $user_cooperativa_id);
			$pedido_div['coletas_totalvalor'] = Number::currency($this->Coletas->totalValor($id));
			$pedido_div['coletas_totalqtde'] = $this->Coletas->totalQtde($id);

			return $pedido_div;
		}

		public function cadastraNovo($doador_id, $data)
		{
	    	$pedidocoleta = $this->newEntity();

	    	$pedidocoleta->set('doador_id'         , $doador_id);
		 	$pedidocoleta->set('status_id'         , 1);
		 	$pedidocoleta->set('pedido_periodicidade', $data['pedido_periodicidade']);
		 	$pedidocoleta->set('pedido_frequencia' , $data['pedido_frequencia']);

		 	$materiais   = $data['material_id'];
		 	$quantidades = $data['quantidade'];

		 	$dias 	  = $data['dia'];
		 	$horarios = $data['horario'];

			$this->Pedidos_coleta_materiais = TableRegistry::get('Pedidos_coleta_materiais');
			$this->Pedidos_coleta_horarios  = TableRegistry::get('Pedidos_coleta_horarios');
            
            if(is_null($materiais) || $materiais == '')
            	return false;
            
            if ($this->save($pedidocoleta)) 
            {
            	for ($i=0; $i < count($materiais); $i++) 
            	{ 
            		$material = $this->Pedidos_coleta_materiais->newEntity();
		 			$material->set('pedido_id', $pedidocoleta->get('pedido_id'));
		 			$material->set('material_id', $data['material_id'][$i]);
		 			$material->set('quantidade_material', $data['quantidade'][$i]);
		 			$this->Pedidos_coleta_materiais->save($material);
            	}

            	for ($i=0; $i < count($dias); $i++) 
            	{ 
            		$dia = $this->Pedidos_coleta_horarios->newEntity();
		 			$dia->set('pedido_id', $pedidocoleta->get('pedido_id'));
		 			$dia->set('dia_semana', $data['dia'][$i]);
		 			$dia->set('horario_intervalo', $data['horario'][$i]);
		 			$this->Pedidos_coleta_horarios->save($dia);
            	}

            	return true;
            }
            else 
            {
            	return false;
            }
		}

		public function alteraCadastro($id, $pedidoColeta, $data)
		{
			$Pedidoscoleta = $this->patchEntity($pedidoColeta, $data);

			$this->Pedidos_coleta_materiais = TableRegistry::get('Pedidos_coleta_materiais');
			$this->Doadores  				= TableRegistry::get('Doadores');

			 	$Pedidoscoleta->set('pedido_periodicidade', $data['pedido_periodicidade']);
				$this->Pedidos_coleta_horarios  = TableRegistry::get('Pedidos_coleta_horarios');
			 	$Pedidoscoleta->set('pedido_frequencia' , $data['pedido_frequencia']);

	            if ($this->save($pedidoColeta)) 
	            {

					$this->Pedidos_coleta_materiais->deleteAll(['pedido_id' => $id]);

				 	$materiais   = $data['material_id'];
				 	$quantidades = $data['quantidade'];

				 	$dias 	  = $data['dia'];
				 	$horarios = $data['horario'];

					for ($i=0; $i < count($materiais); $i++) 
	            	{ 
	            		$material = $this->Pedidos_coleta_materiais->newEntity();
			 			$material->set('pedido_id', $Pedidoscoleta->get('pedido_id'));
			 			$material->set('material_id', $data['material_id'][$i]);
			 			$material->set('quantidade_material', $data['quantidade'][$i]);
			 			$this->Pedidos_coleta_materiais->save($material);
	            	}

	            	for ($i=0; $i < count($dias); $i++) 
	            	{ 
	            		$dia = $this->Pedidos_coleta_horarios->newEntity();
			 			$dia->set('pedido_id', $Pedidoscoleta->get('pedido_id'));
			 			$dia->set('dia_semana', $data['dia'][$i]);
			 			$dia->set('horario_intervalo', $data['horario'][$i]);
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

					    return true;
	            } else 
					    return false;
		}

		public function listaPedidosCoop($cooperativa_id)
		{
			$query = $this->find('all')
			->select($this)
			->hydrate(false)
			->select($this)
			->select(['d.doador_nome'])
            ->join(['d' => [
                            'table' => 'doadores',
                            'type' => 'INNER',
                            'conditions' => 'Pedidoscoleta.doador_id = d.doador_id'
                         ]
                    ])
		    ->where(['cooperativa_id = ' => $cooperativa_id]);

		    $PCs = $query->all();
		    $dataPC = $PCs->toArray();

		    $pedidos_coleta ="";

			foreach ($dataPC as $row) 
			{
				$visualizar_url  =  Router::url(array('controller'=>'pedidoscoleta', 'action'=>'visualizar')) . "/".$row['pedido_id'];

				if($row['status_id'] != 3)
				{
					$coleta_url  =  Router::url(array('controller'=>'coletas', 'action'=>'cadastrar'));;

					$coleta  = "<div style='float:right'><a href='".$coleta_url."/".$row['pedido_id']."'>Cadastrar Coleta</a></div><br/>";
				}
				else
				{
					$coleta  = "";
				}
				
				$this->Pedido_coleta_status = TableRegistry::get('Pedido_coleta_status');
				$status = $this->Pedido_coleta_status->get($row['status_id']);

				$pedidos_coleta .= 
								"<fieldset>
									<legend>Pedido nº ".$row['pedido_id']."</legend>
									".$coleta."
									<div>Pedido cadastrado em ".$row['pedido_datahorainclusao']."</div><br />
									<div>Doador: ".$row['d']['doador_nome']."</div><br />
									<div>Status: ".$status['status_nome']."</div><br/>
									<a href='".$visualizar_url."'>Ver detalhes / Coletas</a>
								</fieldset>";
			}

			if(count($dataPC) == 0)
				$pedidos_coleta = "Não há pedidos de coleta cadastrado para sua conta.";

			return $pedidos_coleta;
		}
		
	}
?>