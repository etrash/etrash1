<?php
	namespace App\Model\Table;

	use Cake\ORM\Table;

	class EstadosTable extends Table
	{

		public function montaSelect()
		{
			$estados_options = array();

			$estados = $this->find('all');

			foreach ($estados as $row) 
			{
				$estado_sigla = $row['sigla'];
				$estados_options[$estado_sigla] = $estado_sigla;
			}

			return $estados_options;
		}
		
	}
?>