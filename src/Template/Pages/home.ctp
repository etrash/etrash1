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
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')):
    throw new NotFoundException();
endif;

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('bootstrap.min.css') ?>
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

    <div id="carousel-example-generic" class="carousel slide background-banner" data-ride="carousel">

        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="images/banner-01.png" alt="">
            </div>
            <div class="item">
                <img src="images/banner-02.png" alt="">
            </div>
        </div>

    </div>

    <div class="section-search">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 text-center">
                    <h1>Encontre um ponto de coleta perto de você dentre os <?= $n_cooperativas; ?> pontos cadastrados</h1>
                    <p>
                        procure por <?= $this->Html->link(
                            'Centro',
                            ['controller' => 'cooperativas', 'action' => 'consultar?regiao=Centro#coops']
                            );
                        ?>, <?= $this->Html->link(
                            'Zona Leste',
                            ['controller' => 'cooperativas', 'action' => 'consultar?regiao=Leste#coops']
                            );
                        ?>, <?= $this->Html->link(
                            'Zona Sul',
                            ['controller' => 'cooperativas', 'action' => 'consultar?regiao=Sul#coops']
                            );
                        ?>, <?= $this->Html->link(
                            'Zona Norte',
                            ['controller' => 'cooperativas', 'action' => 'consultar?regiao=Norte#coops']
                            );
                        ?>, <?= $this->Html->link(
                            'Zona Oeste',
                            ['controller' => 'cooperativas', 'action' => 'consultar?regiao=Oeste#coops']
                            );
                        ?><br>ou digite escolha o tipo de material no campo abaixo
                    </p>
                    <?= $this->Form->create(null,['url' => ['controller' => 'Cooperativas', 'action' => 'consultar/?#coops'], 'id' => 'formBuscaCoop']); ?>
                        <div class="input-group input-group-lg">
                            <!-- <input type="text" class="form-control" placeholder="Ex.: Mooca" aria-describedby="basic-addon2"> -->
                            <?php
                        echo  $this->Form->select(
                                            'material[]',
                                            $materiais_options,
                                            ['empty' => '(Escolha o tipo de material)', 'id' => 'material_nome',
                                            'class' => 'form-control', 'aria-describedby' => 'basic-addon2']
                                        );
                    ?>
                            <span class="input-group-addon" id="basic-addon2" onclick="document.getElementById('formBuscaCoop').submit();"><span class="glyphicon glyphicon-search"></span></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row" style="margin-top: 15px;">
            <div class="text-center col-xs-12 col-sm-8 col-sm-offset-2">
                <iframe src="calc/index.php" frameborder="0" style="height: 332px;">
                  <p>Seu navegador não suporta iframes.</p>
                </iframe>
            </div>
        </div>
    </div>
<!--
    <div class="section-list">
        <div class="container">
            <h2 class="text-center col-xs-12 col-sm-8 col-sm-offset-2">Cooperativa, localize coletas que encaixem em sua rotina e aumente seu faturamento!</h2>
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                    <ul class="list-unstyled">
                        <li><a href="">Alto de Pinheiros</a></li>
                        <li><a href="">Butantã</a></li>
                        <li><a href="">Freguesia do Ó</a></li>
                        <li><a href="">Mandaqui</a></li>
                        <li><a href="">República</a></li>
                        <li><a href="">Tatuapé</a></li>
                        <li><a href="">Vila Madalena</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="">Barra Funda</a></li>
                        <li><a href="">Campo Belo</a></li>
                        <li><a href="">Ipiranga</a></li>
                        <li><a href="">Mooca</a></li>
                        <li><a href="">Santa Cecília</a></li>
                        <li><a href="">Tucuruvi</a></li>
                        <li><a href="">Vila Mariana</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="">Bela Vista</a></li>
                        <li><a href="">Campo Grande</a></li>
                        <li><a href="">Itaim Bibi</a></li>
                        <li><a href="">Morumbi</a></li>
                        <li><a href="">Santana</a></li>
                        <li><a href="">Vila Andrade</a></li>
                        <li><a href="">Vila Olímpia</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="">Belém</a></li>
                        <li><a href="">Cerqueira Cesar</a></li>
                        <li><a href="">Jabaquara</a></li>
                        <li><a href="">Paraíso</a></li>
                        <li><a href="">Santo Amaro</a></li>
                        <li><a href="">Vila Formosa</a></li>
                        <li><a href="">Vila Prudente</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="">Bom Retiro</a></li>
                        <li><a href="">Consolação</a></li>
                        <li><a href="">Lapa</a></li>
                        <li><a href="">Penha</a></li>
                        <li><a href="">Saúde</a></li>
                        <li><a href="">Vila Guilherme</a></li>
                        <li><a href="">Brás</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        <li><a href="">Cursino</a></li>
                        <li><a href="">Liberdade</a></li>
                        <li><a href="">Perdizes</a></li>
                        <li><a href="">Sé</a></li>
                        <li><a href="">Vila Leopoldina</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
-->
    <div class="section-media text-center">
        <div class="container">
            <h2><span>E-Trash na mídia</span></h2>
            <div class="list-media">
                <a href="#" title="News"></a>
                <a href="#" title="Valor"></a>
                <a href="#" title="Forbes"></a>
                <a href="#" title="Tech Crunch"></a>
                <a href="#" title="PME"></a>
                <a href="#" title="Negócios"></a>
            </div>
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


    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
