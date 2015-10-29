<?php
    namespace App\Model\Table;

    use Cake\ORM\Table;
    use Cake\ORM\TableRegistry;

    class ColetamateriaisTable extends Table
    {
    	public function initialize(array $config)
	    {
	        $this->table('coletas_materiais');
	    }
        
        public function addMateriais($coleta_id)
        {
            $queryCM = $this->find('all')
            ->where(['Coleta_materiais.coleta_id = ' => $coleta_id]);

            $CMs = $queryCM->all();
            $dataCM = $CMs->toArray();

            $addMateriais = "";
            
            //MONTA OPTIONS DO SELECT DE MATERIAIS
            $this->Materiais = TableRegistry::get('Materiais');
            $materiais_options = $this->Materiais->montaSelect();

            foreach ($dataCM as $row) 
            {
                $addMateriais .= "addMaterial(".$row['material_id'].", '".$materiais_options[$row['material_id']]."', ".$row['material_valor'].", ".$row['material_quantidade'].");\n";
            }

            return $addMateriais;
        }
        
        public function materiaisPorColeta($coleta_id)
        {
            $queryCM = $this->find('all')
            ->where(['Coleta_materiais.coleta_id = ' => $coleta_id]);

            $CMs = $queryCM->all();
            $dataCM = $CMs->toArray();

            return $dataCM;
        }
    }
?>