<?php
    namespace App\Model\Table;

    use Cake\ORM\Table;
    use Cake\ORM\TableRegistry;

    class PedidoscoletahorariosTable extends Table
    {
        
    	public function initialize(array $config)
	    {
	        $this->table('pedidos_coleta_horarios');
	    }

    	public function addHorarios($pedido_id)
	    {

			$queryPCH = $this->find('all')
		    ->where(['Pedidos_coleta_horarios.pedido_id = ' => $pedido_id]);

		    $PCHs = $queryPCH->all();
		    $dataPCH = $PCHs->toArray();

		    $addHorarios = "";

		    foreach ($dataPCH as $row) 
			{
			 	$addHorarios .= "addDias('".$row['horario_intervalo']."', '".$row['dia_semana']."');\n";
			}

            return $addHorarios;
	    }
    }
?>