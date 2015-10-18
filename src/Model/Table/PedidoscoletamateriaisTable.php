<?php
    namespace App\Model\Table;

    use Cake\ORM\Table;
    use Cake\ORM\TableRegistry;

    class PedidoscoletamateriaisTable extends Table
    {
    	public function initialize(array $config)
	    {
	        $this->table('pedidos_coleta_materiais');
	    }
        
        public function addMateriais($pedido_id)
        {
            $queryCM = $this->find('all')
            ->where(['Pedidos_coleta_materiais.pedido_id = ' => $pedido_id]);

            $CMs = $queryCM->all();
            $dataCM = $CMs->toArray();

            $addMateriais = "";
            
            //MONTA OPTIONS DO SELECT DE MATERIAIS
            $this->Materiais = TableRegistry::get('Materiais');
            $materiais_options = $this->Materiais->montaSelect();

            foreach ($dataCM as $row) 
            {
                $addMateriais .= "addMaterial(".$row['material_id'].", '".$materiais_options[$row['material_id']]."', ".$row['quantidade_material'].");\n";
            }

            return $addMateriais;
        }
    }
?>