<?php  

namespace App\Controller;

use App\Controller\AppController;

class EstatisticasController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->Auth->config(['unauthorizedRedirect' => '/']);
    
    }

    public function index()
    {
        $this->set('user', $this->Auth->user());
    }

    public function materiais()
    {
        $this->loadModel('Coletas_materiais');
        
        $data = $this->Coletas_materiais->montaGrafico(1);

        $this->set('data', $data);
    }

    public function regioes()
    {

        $this->loadModel('Coletas_materiais');
        
        $data = $this->Coletas_materiais->montaGrafico(2);

        $this->set('data', $data);
    }

    public function media()
    {

        if(is_null($this->Auth->user('doador_id')))
        {       
            $this->Flash->error('Você não possui acesso a este gráfico.');
            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('Coletas_materiais');
        
        $data = $this->Coletas_materiais->montaGrafico(3, $this->Auth->user('doador_id'));

        $this->set('data', $data);
    }

    public function media_cooperativas()
    {
        //MONTA OPÇÕES DE MATERIAIS
        $this->loadModel('Materiais');
        $materiais_options = $this->Materiais->montaSelect($this->request->data());          
        $this->set('materiais_options', $materiais_options); 

        $periodo = $this->request->data('periodo');
        $material_id = $this->request->data('material');

        if ($this->request->is('post')) 
        {
            if($periodo == null|| $material_id == null)
                $this->Flash->error('É necessário preencher todos os filtros.');
            else
            {
                 $this->loadModel('Coletas_materiais');

                $data = $this->Coletas_materiais->montaGrafico(4, $periodo, $material_id);
                $this->set('data',$data);
                $this->set('material_id',$material_id);
                $this->set('draw', 'chart.draw(data, options);');
            }

        }
    }

    public function cooperativa()
    {
        if(is_null($this->Auth->user('cooperativa_id')))
        {       
            $this->Flash->error('Você não possui acesso a este gráfico.');
            return $this->redirect(['action' => 'index']);
        }

        $this->loadModel('Coletas_materiais');
        
        $data = $this->Coletas_materiais->montaGrafico(5, $this->Auth->user('cooperativa_id'));

        $this->set('data', $data);
    }


    public function coletas($pedido_id)
    {
        $this->loadModel('Coletas_materiais');
        
        $data = $this->Coletas_materiais->montaGrafico(6, $pedido_id);

        $this->set('data', $data);
    }

    public function materiais_coleta()
    {

        if($this->Auth->user('doador_id') > 0)
        {       
            $user_id = $this->Auth->user('doador_id');
            $user_tipo = "doador_id";
        }
        else
        {
            $user_id = $this->Auth->user('cooperativa_id');
            $user_tipo = "cooperativa_id";
        }

        $this->loadModel('Coletas_materiais');
        
        $data = $this->Coletas_materiais->montaGrafico(7, $user_id, $user_tipo);

        $this->set('data', $data);
    }

    public function isAuthorized($user)
    {   
        return true;
    }

}