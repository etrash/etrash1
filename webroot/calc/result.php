<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Calculadora Sustent�vel</title>
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<style>

	* {
		font-family: 'Roboto', sans-serif;
	}


	.go-back {
		background-color: #7BAA45;
		border: 0;
		color: #fff;
		padding: 10px;
		border-radius: 3px;
		text-transform: uppercase;
		font-weight: bold;
		font-size: 13px;
		text-decoration: none;
		margin-top: 10px;
		display: inline-block;
	}

	#div ul {
		padding: 0;
		list-style-type: none;
		margin: 10px 0;
	}

	#div ul li:before {
		content: "- ";
		display: inline-block;
	}

</style>
</head>
<body>
	<h2>Resultados*</h2>
<div id="div">
	<?php
		$material = $_POST["Material"];
		$quantidade = $_POST["Quantidade"];

		if ($material == "Papel") {
			echo 
					"<ul>".
					"<b> <li> � possivel poupar ".
							number_format(($quantidade * 540),2).
							" litros de �gua. </li>".
					"<b> <li> � possivel salvar ".
							number_format(($quantidade / 1000 * 12),2). " �rvore(s). </li>".
					"<b> <li> Evita o corte de aproximadamente ".
							number_format(($quantidade / 1000 * 30),2). " �rvore(s). </li>".
					"<b> <li> Essa $quantidade de papel � capaz de consumir ".
							number_format(($quantidade / 1000 * 55),2). " eucaliptos.</li>".
					"<b> <li> � possivel poupar ".
							number_format(($quantidade / 1000 * 100000),2).
							" litros de agu� </li>".
					"<b> <li> � possivel poupar ".
							number_format(($quantidade / 28000),2).
							" hect�re(s) de floresta. </li>".
					"<b> <li> � possivel poupar ".
							number_format(($quantidade / 1000 * 5),2).
							" mil KW/h de energia. </li>".
					"</ul>";
		}
		if ($material == "Papel Reciclado") {
			echo 
			"<ul>".
			"<b> <li> � possivel poupar ".
					number_format(($quantidade / 1000 * 2),2).
					" mil litros de �gua.</li>".
			"<b> <li> � possivel poupar ".
					number_format(($quantidade / 1000 * 1750),2).
					" KW/h de energia. </li></td>".
			"</ul>";
		}
		if ($material == "A�o") {
			echo 
			"<ul>".
			"<b> <li> � possivel recuperar ".
					number_format(($quantidade / 1000 * 1140),2).
					" Kg de min�rio de ferro.</li>".
			"<b> <li> � possivel poupar ".
					number_format(($quantidade / 1000 * 155),2).
					" Kg de carv�o.</li></td>".
			"<b> <li> � possivel poupar ".
					number_format(($quantidade / 1000 * 18),2).
					" Kg de cal. </li></td>".
			"</ul>";
		}
		if ($material == "Alum�nio") {

			echo 
			"<ul>".
			"<b> <li> � possivel poupar ".
					number_format(($quantidade / 1000 * 17.6),2).
					" mil kwh de energia el�trica [95% de economia contra o reciclado].</li></td>".
			"<b> <li> � possivel poupar ".
					number_format(($quantidade / 1000 * 5),2).
					" toneladas de bauxita. </li>".
			"</ul>";
		}
		if ($material == "Vidro") {
			echo 
			"<ul>".
			"<b> <li> � possivel recuper  ".
					number_format(($quantidade),2).
					" kg de vidro. [100% recicl�vel] </li>".
			"<b> <li> � possivel produzir vidro com essa mesma $quantidade de ".
					number_format(($quantidade),2).
					" Kg com vidro reciclado, utilizando 70% de energia a menos. </li>".
			"<b> <li> Evita o corte de aproximadamente ".
					number_format(($quantidade / 1000 * 1.3),2).
					" �rvore(s). </li>".
			"<b> <li> � possivel economizar 22% no consumo de barrilha. </li>".
			"<b> <li> � possivel reduzir em 50% o consumo de �gua. </li>".
			"</ul>";
		}
		if ($material == "Pl�sticos") {
			echo 
			"<ul>".
			"<b> <li> � possivel poupar ".
					number_format(($quantidade / 100000)).
					" tonelada(s) de petr�leo. </li>".
			"</ul>";

		}
	?>
	<div>
		*Dados obtidos no site da organiza��o WWF (http://www.wwf.org.br/?uNewsID=14001).
	</div>
</div>


	<a href="index.php" class="go-back">Voltar</a>
</body>
</html>