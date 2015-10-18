<?php
    namespace App\Model\Table;

    use Cake\ORM\Table;
    use Cake\ORM\TableRegistry;

    class CooperativasmateriaisTable extends Table
    {
    	public function initialize(array $config)
	    {
	        $this->table('cooperativas_materiais');
	    }

        public function saveMateriais($cooperativa_id, $data)
        {
        	$materiais   = $data['material_id'];

            for ($i=0; $i < count($materiais); $i++) 
        	{ 
        		$material = $this->newEntity();
	 			$material->set('cooperativa_id', $cooperativa_id);
	 			$material->set('material_id', $data['material_id'][$i]);
                $material->set('material_valor', $data['material_valor'][$i]);
	 			$this->save($material);
        	}
        }

        public function addMateriais($coop_id)
        {
            $queryCM = $this->find('all')
            ->where(['Cooperativas_materiais.cooperativa_id = ' => $coop_id]);

            $CMs = $queryCM->all();
            $dataCM = $CMs->toArray();

            $addMateriais = "";
            
            //MONTA OPTIONS DO SELECT DE MATERIAIS
            $this->Materiais = TableRegistry::get('Materiais');
            $materiais_options = $this->Materiais->montaSelect();

            foreach ($dataCM as $row) 
            {
                $addMateriais .= "addMaterialValor(".$row['material_id'].", '".$materiais_options[$row['material_id']]."', '".$row['material_valor']."');\n";
            }

            return $addMateriais;
        }
    }
?>