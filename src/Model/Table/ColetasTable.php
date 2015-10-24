<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Network\Email\Email;
use Cake\I18n\Time;
use Cake\I18n\Number;

	class ColetasTable extends Table
	{
		public function initialize(array $config)
	    {
	        $this->addBehavior('Timestamp', [
	            'events' => [
	                'Model.beforeSave' => [
	                    'datahora_inclusao' => 'new',
	                    'datahora_alteracao' => 'always',
	                ]
	            ]
	        ]);
	    }

		public function cadastraNovo($data)
		{
	    	$coleta = $this->newEntity();
	    	
 	    	$datahora = Time::createFromFormat('d/m/Y H:i', $data['pedido_datahora']);

	    	$coleta->set('pedido_id'         , $data['pedido_id']);
		 	$coleta->set('coleta_datahora', $datahora->i18nFormat('YYYY-MM-dd HH:mm:ss'));
		 	$coleta->set('coleta_obs' , $data['coleta_obs']);

		 	$materiais   = $data['material_id'];
		 	$valores 	 = $data['material_valor'];
		 	$quantidades = $data['material_qtde'];
            if(is_null($materiais) || $materiais == '')
            	return false;
            
			$this->Coletas_materiais = TableRegistry::get('Coletas_materiais');

            if ($this->save($coleta)) 
            {
            	for ($i=0; $i < count($materiais); $i++) 
            	{ 
            		$material = $this->Coletas_materiais->newEntity();
		 			$material->set('coleta_id', $coleta->get('coleta_id'));
		 			$material->set('material_id', $data['material_id'][$i]);
		 			$material->set('material_valor', $data['material_valor'][$i]);
		 			$material->set('material_quantidade', $data['material_qtde'][$i]);

		 			$this->Coletas_materiais->save($material);
            	}
            	return true;
            }
            else 
            {
            	return false;
            }
		}


		public function listaColetas($pedido_id, $cooperativa_id)
		{
			$query = $this->find('all', [
			    'order' => ['coleta_datahora' => 'DESC']
			])
		    ->where(['pedido_id = ' => $pedido_id]);

		    $Cs = $query->all();
		    $dataC = $Cs->toArray();

		    $coletas ="";

			foreach ($dataC as $row) 
			{
				if($cooperativa_id > 0)
				{
					$alterar_url  =  Router::url(array('controller'=>'coletas', 'action'=>'alterar'));
					$alterar  = "<div style='float:right'><a href='".$alterar_url."/".$row['coleta_id']."'>Alterar Coleta</a></div><br/>";

					$excluir_url  =  Router::url(array('controller'=>'coletas', 'action'=>'excluir'));
					$excluir  = "<div style='float:right'><a href='".$excluir_url."/".$row['coleta_id']."' onclick='if (confirm(\"Voc&ecirc tem certeza que deseja excluir esta coleta?\")) {return true;} return false;' >Excluir Coleta</a></div><br/>";
				}
				else
					$alterar  = "";

            	$this->Coletas_materiais = TableRegistry::get('Coletas_materiais');

            	$materiais_coleta = $this->Coletas_materiais->materiaisPorColeta($row['coleta_id']);

	            //MONTA OPTIONS DO SELECT DE MATERIAIS
	            $this->Materiais = TableRegistry::get('Materiais');
	            $materiais_options = $this->Materiais->montaSelect();

            	$materiais_div = "";
            	$material_valor_total = 0;
            	$material_qtde_total = 0;

            	foreach ($materiais_coleta as $rowM) 
	            {
	            	$materiais_div .= "
	            	<div class='row'>
	            		<div class='col-md-4'>
	            		Material: ".$materiais_options[$rowM['material_id']]."
						</div>
	            		<div class='col-md-4'>
	            		Valor pago: ".Number::currency($rowM['material_valor'])." (por KG)
						</div>
	            		<div class='col-md-4'>
	            		Quantidade: ".$rowM['material_quantidade']." KG
						</div>
	            	</div>";

	            	$material_valor_total += ($rowM['material_valor'] * $rowM['material_quantidade']);
	            	$material_qtde_total += $rowM['material_quantidade'];
	            }
						
				if($row['coleta_obs'] != "")	
					$obs = 	"<div class='row'>Observações: ".$row['coleta_obs']."</div>";
				else 
					$obs = "";

				$coletas .= 
								"<fieldset>
									<legend>Coleta nº ".$row['coleta_id']."</legend>
									".$alterar."
									".$excluir."
									<div class='row'>Coleta realizada em ".$row['coleta_datahora']."</div>
									<div class='row'>Materiais coletados:$materiais_div</div>
									<div class='row'>Remunetação Total de Resíduo Coletado:  ".Number::currency($material_valor_total)."</div>
									<div class='row'>Quantidade Total Arrecadada: $material_qtde_total KG</div>
									$obs
								</fieldset>";
			}

			if(count($dataC) == 0)
				$coletas = "Nenhuma coleta foi cadastrada para este pedido";

			return $coletas;
		}

		public function alteraCadastro($id, $coleta, $data)
		{
			//FORMATA DATA/HORA
			$data['coleta_datahora'] = Time::parseDateTime($data['coleta_datahora']);
			debug($data['coleta_datahora']);
			//die;
			$coleta = $this->patchEntity($coleta, $data);

			$this->Coletas_materiais = TableRegistry::get('Coletas_materiais');

	            if ($this->save($coleta)) 
	            {

					$this->Coletas_materiais->deleteAll(['coleta_id' => $id]);

				 	$materiais   = $data['material_id'];
				 	$valores 	 = $data['material_valor'];
				 	$quantidades = $data['material_qtde'];


					for ($i=0; $i < count($materiais); $i++) 
	            	{ 
	            		$material = $this->Coletas_materiais->newEntity();
			 			$material->set('coleta_id', $coleta->get('coleta_id'));
			 			$material->set('material_id', $data['material_id'][$i]);
			 			$material->set('material_valor', $data['material_valor'][$i]);
			 			$material->set('material_quantidade', $data['material_qtde'][$i]);
		 			
		 				$this->Coletas_materiais->save($material);
	            	}

					    return true;
	            } else 
					    return false;
		}

		public function totalValor($pedido_id)
		{
			$query = $this->find('all')
			->select(['TotalValor' => 'sum(material_valor*material_quantidade)'])
			->join(['cm' => [
					            'table' => 'coletas_materiais',
					            'type' => 'INNER',
					            'conditions' => 'Coletas.coleta_id = cm.coleta_id'
					         ]
					])
			->where(['pedido_id' => $pedido_id])
			;

			$row = $query->first();

			return $row['TotalValor'];
		}

		public function totalQtde($pedido_id)
		{
			
			$query = $this->find('all')
			->select(['TotalQtde' => 'sum(material_quantidade)'])
			->join(['cm' => [
					            'table' => 'coletas_materiais',
					            'type' => 'INNER',
					            'conditions' => 'Coletas.coleta_id = cm.coleta_id'
					         ]
					])
			->where(['pedido_id' => $pedido_id])
			;

			$row = $query->first();

			return $row['TotalQtde'];
		}
	}