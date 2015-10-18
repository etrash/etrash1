<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset('ISO-8859-1'); ?>

    <?= $this->Html->script('http://code.jquery.com/jquery.min.js'); ?>
    <?= $this->Html->script('bootstrap.min'); ?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <?= $this->Html->css('custom.css') ?>
</head>
<body>
<nav class="navbar">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?= $this->Html->image('logo-e-trash-portal.png', ['alt' => 'Portal E-Trash', 'url' => '/', 'class' => 'navbar-brand']); ?>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <?php 
                        echo $this->Html->link(
                            'Página Inicial',
                            '/'
                            );
                        ?>
                    </li>
                    <li>
                        <?php 
                        echo $this->Html->link(
                            'Anúncios',
                            ['controller' => 'pedidoscoleta', 'action' => 'consultar']
                            );
                        ?>
                    </li>
                    <li>
                        <?php 
                        echo $this->Html->link(
                            'Pontos de Coleta',
                            ['controller' => 'cooperativas', 'action' => 'consultar']
                            );
                        ?>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php echo $menu_superior_itens; ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    
    <div class="container">

            <?= $this->Flash->render(); ?>

            <div class="row">
                <?= $this->fetch('content') ?>
            </div>
    </div>

         <footer>
        <div class="top">
            <div class="container text-center">
                <ul class="list-inline">
                    <li>Copyright © 2015 etrash.com.br</li>
                    <li><a href="#">Termos e condiçõe</a></li>
                    <li><a href="#">Política de privacidade</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </div>
        </div>
        <div class="bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-2">
                        <?= $this->Html->image('logo-e-trash-portal.png', ['alt' => 'Portal E-Trash', 'height' => '30', 'url' => '/', 'class' => 'navbar-brand']); ?>
                    </div>
                    <div class="col-xs-12 col-sm-10">
                        <p>Apoiamos causas contra a divulgação de materiais ilegais, agressivos, caluniosos, abusivos, danosos, invasivos da privacidade de terceiros, terroristas, vulgares, obscenos ou ainda condenáveis de qualquer tipo ou natureza que sejam prejudiciais a menores e à preservação do meio ambiente. Anuncie com segurança: conheça seus Direitos de Consumidor.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    </div>
</body>
</html>
