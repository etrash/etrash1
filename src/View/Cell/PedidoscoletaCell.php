<?php
namespace App\View\Cell;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

class PedidoscoletaCell extends Cell
{

    public function display($nome, $doacao, $cooperativa_id, $pedido_id)
    {
    	if($doacao)
		{
			$cooperativa_doacao = "Doação";
			$materiais_valor = "";
		}
		else
		{
			$cooperativa_doacao = "Compra";

			//MATERIAIS DA COOPERATIVA
			$this->Materiais = TableRegistry::get('Materiais');
			$materiais_valor =  "<div>Valores pagos (por KG): ".
									"<ul>".
										$this->Materiais->listaMateriaisCoop($cooperativa_id).
									"</ul>".
								"</div>";
		}

		$this->set('nome', $nome);
		$this->set('cooperativa_doacao', $cooperativa_doacao);
		$this->set('cooperativa_id', $cooperativa_id);
		$this->set('materiais_valor', $materiais_valor);
		$this->set('pedido_id', $pedido_id);
    }

}

?>