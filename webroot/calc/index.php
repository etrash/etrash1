<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Calculadora Sustentável</title>
<script src="/etrash1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/etrash1/css/bootstrap.min.css"/> 

<style type="text/css">


#div {
	/* ou seja ele pega 50% da largura tela e diminui  metade do valor da largura no caso 250 */
	background-color: #4EEE94;
	font-size: 25px;
	border: solid 10px rgba(47, 79, 79, 0.8);
	border-radius: 10px;
}

#div1 {
}

input[type=submit] {
	background: #CDC9A5;
	color: #2E8B57;
	font-size: 25px;
}

input[type=text] {
	font-size: 20px;
	color: #008B45;
}

select {
	-webkit-appearance: none;
	font-size: 20px;
	color: #008B45;
}

select option {
	font-size: 20px;
	color: #008B45;
}
</style>

<script type="text/javascript">
	function validateForm() {
		var x = document.forms["Calculadora"]["Quantidade"].value;
		if (x == null || x == "") {
			alert("O campo Quantidade(Kg) é obrigatorio");
			return false;
		}
	}
</script>

</head>
<body bgcolor="#FFFFF0" text="#FFFFF0">
	<div class="container">
		<div id="div" class="row">
			<form method="post" action="result.php" name="Calculadora"
				onsubmit="return validateForm()">
				<div id="div1" class="col-md-12">
					Descubra como a sua ação pode fazer a diferença!
					<p>
						Material: 
						<select name="Material">
							<option value="Papel">Papel</option>
							<option value="Aço">Aço</option>
							<option value="Alumínio">Alumínio</option>
							<option value="Vidro">Vidro</option>
							<option value="Plásticos">Plásticos</option>
						</select> <br> <br>
						Quantidade(Kg):<font color="red">*</font> <input
							type="text" pattern="[0-9]*" name="Quantidade"> <br>
						<font color="red" size=1>* Digite apenas numeros no campo
							acima</font>
					</p>
					<center>
						<input type="submit" value="Calcular">
					</center>
			</form>
		</div>
	</div>



</body>
</html>