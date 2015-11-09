<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Calculadora Sustentável</title>
<script src="/etrash1/js/bootstrap.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<style>

	* {
		font-family: 'Roboto', sans-serif;
	}

	#div1 {
		display: table;
	}
	
	.select-material,
	.field-quantidade,
	.submit {
		display: table-cell;
	}

	.select-material label,
	.field-quantidade label {
		display: block;
		margin-bottom: 4px;
		font-weight: bold;
		color: #333;
	}

	.field-quantidade label:after {
		content: "*";
		display: inline-block;
		color: red;
	}

	.field-quantidade label span {
		font-size: 12px;
		display: inline-block;
		vertical-align: top;
		padding-top: 2px
	}

	.select-material {
		padding-right: 20px;
	}

	select,
	input[type="text"] {
		border: 1px solid #ddd;
		border-radius: 4px;
		padding: 12px 18px;
	}

	select,
	input[type="text"] {
		width: 290px;
	}

	.submit {
		vertical-align: middle;
	}

	input[type="submit"] {
		background-color: #7BAA45;
		border: 0;
		color: #fff;
		padding: 10px;
		border-radius: 3px;
		text-transform: uppercase;
		font-weight: bold;
		margin-top: 22px;
		margin-left: 10px;
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
<body>
		<div id="div">
			<form method="post" action="result.php" name="Calculadora"
				onsubmit="return validateForm()">
				<div id="div1">
					<div class="select-material">
						<label>Material</label> 
						<select name="Material" class="form-control">
							<option value="Papel">Papel</option>
							<option value="Aço">Aço</option>
							<option value="Alumínio">Alumínio</option>
							<option value="Vidro">Vidro</option>
							<option value="Plásticos">Plásticos</option>
						</select>
					</div>
					<div class="field-quantidade">
						<label>Quantidade <span>(Kg)</span></label>
						<input type="text" pattern="[0-9]*" name="Quantidade" class="form-control">
					</div>
					<div class="submit">
						<input type="submit" value="Calcular" class="btn btn-default">
					</div>
				</div>
			</form>
		</div>

</body>
</html>