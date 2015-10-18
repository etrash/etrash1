<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

use Cake\Event\Event;
use Cake\Routing\Router;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    
    public function initialize()
    {
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'logoutRedirect' => '/',
            'loginAction' => [
                'controller' => 'Login',
                'action' => 'index'
            ],
                'authorize' => 'Controller'

        ]);

        $this->Auth->config('authError', "Ops! Você não está logado para acessar esta parte do site.");

        $this->Auth->allow();   
        // // Deny one action
        $this->Auth->deny(['editar','deletar', 'index', 'excluir']);

        //MENU SUPERIOR
        if(is_null($this->Auth->user()))
        {
            $cadastrar_url =  Router::url('/pages/cadastro');
            $login_url =  Router::url(['controller' => 'login']);

            $menu_superior_itens = "<li class='active'><a href='$cadastrar_url'>Cadastre-se</a></li>
                                    <li><a href='$login_url'>Login</a></li>";
        }
        elseif($this->Auth->user('doador_id') == null)
        {
            $menu_superior_itens = "<li class='active'><a href='".Router::url(['controller' => 'cooperativas'])."'>Meu Cadastro</a></li>";
        }
        else
        {
            $menu_superior_itens = "<li class='active'><a href='".Router::url(['controller' => 'doadores'])."'>Meu Cadastro</a></li>";
        }

        $this->set('menu_superior_itens', $menu_superior_itens);
    }






}
