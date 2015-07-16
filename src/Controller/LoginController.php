<?php  

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class LoginController extends AppController
{
    private $_perfil = 1;

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        if ($this->request->is('post')) 
            $this->_perfil = $this->request->data('tipo');        

        if($this->_perfil == 1)
        {
            $this->Auth->config('authenticate', [
                                            'Form' => ['userModel' => 'Doadores', 'fields' => ['username' => 'doador_email', 'password' => 'doador_senha']]
                                            
                                ]); 

            $this->Auth->config(['loginRedirect' => '/doadores/editar']);

        }
        elseif($this->_perfil == 2)
        {
            $this->Auth->config('authenticate', [
                                            'Form' => ['userModel' => 'Cooperativas', 'fields' => ['username' => 'cooperativa_email', 'password' => 'cooperativa_senha']]
                                            
                                ]);  

            $this->Auth->config(['loginRedirect' => '/cooperativas/editar']);
        }


    }

	public function index()
	{
	    if ($this->request->is('post')) {
	        $user = $this->Auth->identify();
	        if ($user) {
	            $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
	        }
	        $this->Flash->error(__('E-mail ou senha inválidos, por favor, tente novamente.'));
	    }
	}

	public function logout()
	{
	    return $this->redirect($this->Auth->logout());
	}
}