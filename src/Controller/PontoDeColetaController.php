<?php
namespace App\Controller;

use App\Controller\AppController;

   class PontoDeColetaController extends AppController {
   	
		public function index(){
			$regiao = $this->request->data("regiao");
			$materialDeColeta = $this->request->data("materialDeColeta");
			$tipoDeColeta = $this->request->data("tipoDeColeta");

			if($regiao = "todas" && $materialDeColeta = "todos"  && $tipoDeColeta = "todos")
			{
				$query = $this->Cooperativa->find('all');
			}
			elseif($regiao != "todas" && $materialDeColeta != "todos"  && $tipoDeColeta != "todos")
			{
				$query = $this->Cooperativa->find('all')
				->where(['Cooperativa.regiao = ' => $regiao]);
			}
			

	    $consulta = $query->all();
	    $dadosConsulta = $consulta->toArray();

		foreach ($dadosConsulta as $row) 
		{

		}
   }
 }
 ?>