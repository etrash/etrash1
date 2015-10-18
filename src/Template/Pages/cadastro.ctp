<div>

        <h1>Quero me cadastrar como:</h1><br/>
		 <?php 
            echo $this->Html->link(
                'Doador',
                ['controller' => 'doadores', 'action' => 'cadastrar']
                );?>
         <br/>
        <?php    echo $this->Html->link(
                'Cooperativa',
                ['controller' => 'cooperativas', 'action' => 'cadastrar']
                );
        ?>
</div>