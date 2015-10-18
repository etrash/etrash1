<?php
    namespace App\Model\Table;

    use Cake\ORM\Table;

    class PedidoscoletacooperativasTable extends Table
    {
    	public function initialize(array $config)
	    {
	        $this->table('pedidos_coleta_cooperativas');
	    }
        
		public function seCandidatou($pedido_id, $id)
		{

			$query = $this->find('all', [
		    'conditions' => ['pedido_id' => $pedido_id, 'cooperativa_id' => $id]
			]);

			$candidatura = $query->first();

			if($candidatura != null)
				return true;
			else
				return false;
		}
    }
?>