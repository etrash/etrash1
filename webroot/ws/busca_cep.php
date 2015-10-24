<?php
$cep = $_GET["cep"];

$url="http://cep.republicavirtual.com.br/web_cep.php?cep=$cep&formato=json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

$data = curl_exec($ch); // execute curl request
$dataJson = json_decode($data, true);
curl_close($ch);
$regiao = '';

if(utf8_decode($dataJson['cidade']) === 'São Paulo')
{
	//PEGA REGIÃO
	$faixa_cep = intval(substr($cep, 0,5));
	if($faixa_cep >= 1000 && $faixa_cep <= 1599)
		$regiao = 'Centro';
	elseif($faixa_cep >= 2000 && $faixa_cep <= 2999)
		$regiao = 'Norte';
	elseif($faixa_cep >= 3000 && $faixa_cep <= 3999)
		$regiao = 'Leste';
	elseif($faixa_cep >= 8000 && $faixa_cep <= 8499)
		$regiao = 'Leste';
	elseif($faixa_cep >= 4000 && $faixa_cep <= 4999)
		$regiao = 'Sul';
	elseif($faixa_cep >= 5000 && $faixa_cep <= 5899)
		$regiao = 'Oeste';

	$dataJson['regiao'] = $regiao;

}

$dataJson = json_encode($dataJson);
print_r($dataJson);

?>