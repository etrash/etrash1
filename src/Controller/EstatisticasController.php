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
        $this->loadModel('Coletas_materiais');
        
        $data = $this->Coletas_materiais->montaGrafico(5, $this->Auth->user('cooperativa_id'));

        $this->set('data', $data);
    }

    public function isAuthorized($user)
    {

        return true;
    }

}