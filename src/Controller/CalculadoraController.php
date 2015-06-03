<?php  

namespace App\Controller;

use App\Controller\AppController;

class CalculadoraController extends AppController
{

	public function index()
    {
        
    }

	public function calcular()
    {
        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $erro = false;
            $resultado = 0;
            $valor1 = $this->request->data('valor1');
            $valor2 = $this->request->data('valor2');
            $operacao = $this->request->data('operacao');

            switch ($operacao) 
            {
            	case '+':
            		$resultado = $valor1 + $valor2;
            		break;
            	case '-':
            		$resultado = $valor1 - $valor2;
            		break;
            	case '*':
            		$resultado = $valor1 * $valor2;
            		break;
            	case '/':
            		$resultado = $valor1 / $valor2;
            		break;
            	
            	default:
            		$erro = true;
            		break;

            }

            if($erro)
				$this->set('resultado', 'Operação inserida incorretamente');
			else
				$this->set('resultado', 'O resultado é: '.$resultado);
        }

    }


}