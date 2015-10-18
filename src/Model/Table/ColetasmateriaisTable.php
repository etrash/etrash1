<?php
    namespace App\Model\Table;

    use Cake\ORM\Table;
    use Cake\ORM\TableRegistry;
    use Cake\I18n\Time;
    use Cake\Datasource\ConnectionManager;

    class ColetasmateriaisTable extends Table
    {
    	public function initialize(array $config)
	    {
	        $this->table('coletas_materiais');
	    }
        
        public function addMateriais($pedido_id)
        {
            $queryCM = $this->find('all')
            ->where(['Coletas_materiais.coleta_id = ' => $pedido_id]);

            $CMs = $queryCM->all();
            $dataCM = $CMs->toArray();

            $addMateriais = "";
            
            //MONTA OPTIONS DO SELECT DE MATERIAIS
            $this->Materiais = TableRegistry::get('Materiais');
            $materiais_options = $this->Materiais->montaSelect();

            foreach ($dataCM as $row) 
            {
                $addMateriais .= "addMaterialValorQtde(".$row['material_id'].", '".$materiais_options[$row['material_id']]."', ".$row['material_valor']." ,".$row['material_quantidade'].");\n";
            }

            return $addMateriais;
        }

        public function maisColetados()
        {
            $queryCM = $this->find('all', [
                'order' => ['tot_quantidade' => 'ASC']
            ])
            ->select(['m.material_nome', 'tot_quantidade' => 'sum(material_quantidade)'])
            ->join(['c' => [
                            'table' => 'coletas',
                            'type' => 'INNER',
                            'conditions' => 'Coletas_materiais.coleta_id = c.coleta_id'
                         ],
                    'm' => [
                       'table' => 'materiais',
                       'type' => 'INNER',
                       'conditions' => ['Coletas_materiais.material_id = m.material_id']
                    ]])
            ->where(['coleta_datahora >=' => new Time('30 days ago')])
            ->group(['Coletas_materiais.material_id'])
            ->limit(10);

            $CMs = $queryCM->all();
            $dataCM = $CMs->toArray();

            return $dataCM;
        }

        public function coletasPorRegiao()
        {
            $queryCM = $this->find('all')
            ->select(['d.doador_regiao', 'tot_quantidade' => 'sum(material_quantidade)'])
            ->join(['c' => [
                            'table' => 'coletas',
                            'type' => 'INNER',
                            'conditions' => 'Coletas_materiais.coleta_id = c.coleta_id'
                         ],
                    'pc' => [
                       'table' => 'pedidoscoleta',
                       'type' => 'INNER',
                       'conditions' => ['c.pedido_id = pc.pedido_id']
                    ],
                    'd' => [
                       'table' => 'doadores',
                       'type' => 'INNER',
                       'conditions' => ['pc.doador_id = d.doador_id']
                    ]])
            ->where(['coleta_datahora >=' => new Time('30 days ago')])
            ->group(['d.doador_regiao']);

            $CMs = $queryCM->all();
            $dataCM = $CMs->toArray();

            return $dataCM;
        }

        public function mediaDoadores($doador_id = 0)
        {
            $connection = ConnectionManager::get('default');

            if($doador_id != 0)
            {
                $results = $connection
                            ->execute('SELECT avg(tot_quantidade) FROM 
                                        (    
                                            SELECT AVG(material_quantidade) as tot_quantidade FROM coletas_materiais cm 
                                            inner join coletas c on c.coleta_id = cm.coleta_id
                                            inner join pedidoscoleta pc on pc.pedido_id = c.pedido_id
                                            where doador_id = '.$doador_id.'
                                        ) AS medias')
                            ->fetchAll();
            }
            else
            {
                $results = $connection
                            ->execute('SELECT avg(tot_quantidade) FROM 
                                        (    
                                            SELECT AVG(material_quantidade) as tot_quantidade FROM coletas_materiais cm 
                                            inner join coletas c on c.coleta_id = cm.coleta_id
                                            inner join pedidoscoleta pc on pc.pedido_id = c.pedido_id
                                            group by doador_id
                                        ) AS medias')
                            ->fetchAll();
            }

            return $results;

        }

        public function mediaCoops($periodo, $material_id)
        {
            $queryCM = $this->find('all')
            ->select(['coop.cooperativa_nome', 'tot_quantidade' => 'sum(material_quantidade)'])
            ->join(['c' => [
                            'table' => 'coletas',
                            'type' => 'INNER',
                            'conditions' => 'Coletas_materiais.coleta_id = c.coleta_id'
                         ],
                    'pc' => [
                       'table' => 'pedidoscoleta',
                       'type' => 'INNER',
                       'conditions' => ['c.pedido_id = pc.pedido_id']
                    ],
                    'coop' => [
                       'table' => 'cooperativas',
                       'type' => 'INNER',
                       'conditions' => ['coop.cooperativa_id = pc.cooperativa_id']
                    ]])
            ->where(['coleta_datahora >=' => new Time($periodo), 'material_id' => $material_id ])
            ->group(['pc.cooperativa_id']);

            $CMs = $queryCM->all();
            $dataCM = $CMs->toArray();

            return $dataCM;
        }

        public function coop($cooperativa_id)
        {
            $queryCM = $this->find('all')
            ->select(['m.material_nome', 'tot_quantidade' => 'sum(material_quantidade)'])
            ->join(['c' => [
                            'table' => 'coletas',
                            'type' => 'INNER',
                            'conditions' => 'Coletas_materiais.coleta_id = c.coleta_id'
                         ],
                    'pc' => [
                       'table' => 'pedidoscoleta',
                       'type' => 'INNER',
                       'conditions' => ['c.pedido_id = pc.pedido_id']
                    ],
                    'm' => [
                       'table' => 'materiais',
                       'type' => 'INNER',
                       'conditions' => ['m.material_id = Coletas_materiais.material_id']
                    ]])
            ->where(['pc.cooperativa_id' => $cooperativa_id ])
            ->group(['Coletas_materiais.material_id']);

            $CMs = $queryCM->all();
            $dataCM = $CMs->toArray();

            return $dataCM;
        } 

        public function montaGrafico($grafico, $param1 = null, $param2 = null)
        {
            switch ($grafico) {
                case 1:
                    
                    $dataArray = $this->maisColetados();
                    
                    foreach ($dataArray as $i=>$row) 
                    {
                        if($i != count($dataArray))
                            $data .= "['".$row['m']['material_nome']."', ".$row['tot_quantidade']."],\n";
                        else
                            $data .= "['".$row['m']['material_nome']."', ".$row['tot_quantidade']."]\n";
                    }

                    break;
                case 2:
                    
                    $dataArray = $this->coletasPorRegiao();
                    
                    foreach ($dataArray as $i=>$row) 
                    {
                        if($i != count($dataArray))
                            $data .= "['".$row['d']['doador_regiao']."', ".$row['tot_quantidade']."],\n";
                        else
                            $data .= "['".$row['d']['doador_regiao']."', ".$row['tot_quantidade']."]\n";
                    }

                    break;

                case 3:
                    
                    $data1 = $this->mediaDoadores();
                    $data2 = $this->mediaDoadores($param1);

                    $data .= "['Média dos Doadores', ".$data1[0][0]."],\n";
                  
                    $data .= "['Sua Média', ".$data2[0][0]."]\n";
                  
                    break;

                case 4:
                    
                    $dataArray = $this->mediaCoops($param1, $param2);

                    foreach ($dataArray as $i=>$row) 
                    {
                        if($i != count($dataArray))
                            $data .= "['".$row['coop']['cooperativa_nome']."', ".$row['tot_quantidade']."],\n";
                        else
                            $data .= "['".$row['coop']['cooperativa_nome']."', ".$row['tot_quantidade']."]\n";
                    }
                  
                    break;

                case 5:
                    
                    $dataArray = $this->coop($param1);
                    
                    foreach ($dataArray as $i=>$row) 
                    {
                        if($i != count($dataArray))
                            $data .= "['".$row['m']['material_nome']."', ".$row['tot_quantidade']."],\n";
                        else
                            $data .= "['".$row['m']['material_nome']."', ".$row['tot_quantidade']."]\n";
                    }

                    break;
                
                default:
                    # code...
                    break;
            }

            return $data;
        }


    }
?>