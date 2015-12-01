<?php
	namespace App\Model\Table;

	use Cake\ORM\Table;

	class MateriaisTable extends Table
	{
		public function montaSelect()
		{
			$materiais_options = array();

			$materiais = $this->find('all');

			foreach ($materiais as $row) 
			{
				$material_nome = $row['material_nome'];
				$material_id = $row['material_id'];
				$materiais_options[$material_id] = $material_nome;
			}

			return $materiais_options;
		}

		public function montaCheck($data)
		{
			$materiais = $this->find('all');

			$materiais_options = "";

			foreach ($materiais as $row) 
			{
				$material_nome = $row['material_nome'];
				$material_id = $row['material_id'];

				//VERIFICA MATERIAIS SELECIONADOS
				$material_checked = "";
				
				if($data['material'] != null)
				{
					if(in_array($material_id, $data['material']))
						$material_checked = "checked='checked'";
					else
						$material_checked = "";
				}

				$materiais_options .= "<label><input type='checkbox' name='material[]' value='$material_id' $material_checked >$material_nome</label>\n";
			}
			
			return $materiais_options;
		}

		public function listaMateriaisCoop($id)
		{
			$queryM = $this->find()
		    ->hydrate(false)
		    ->select(['material_nome', 'cm.material_valor'])
		    ->join(['cm' => [
				            'table' => 'cooperativas_materiais',
				            'type' => 'INNER',
				            'conditions' => 'Materiais.material_id = cm.material_id'
				         ]])
		    ->where(['cooperativa_id' => $id])
		    ->group('Materiais.material_id');

			$materiais = $queryM->all();
    		
    		$materiais_cooperativa = "";

	    		foreach ($materiais as $rowM) 
	    		{
					$materiais_cooperativa .= "<li><strong>Material: </strong>".$rowM['material_nome']." | Valor: ".$rowM['cm']['material_valor']."</li>";
				}

			return $materiais_cooperativa;
		}
	}
?>