function addMaterial(material_id, material, quantidade)
{
	
	var values = $("input[name='material_id[]']")
              .map(function(){return $(this).val();}).get();

	var teste = values.indexOf('1');

	if(values.indexOf(material_id) > -1)
		alert('Material já cadastrado!');
	else
	{
		if(material_id > 0 && quantidade > 0)
		{
			indice = $("#lista-materiais li").size();
			item = "<li id='item-material_"+indice+"'>	\n"+		
					"	<div style='align:left;'> \n"+
					"		<input type='hidden' name='material_id[]' value='"+material_id+"'> \n"+
					"		Material: "+material+" \n"+
					"	</div> \n"+
					"	<div style='align:center;'> \n"+
					"		<input type='hidden' name='quantidade[]' value='"+quantidade+"'> \n"+
					"		Quantidade: "+quantidade+" KG\n"+
					"	</div> \n"+
					"	<div style='align:center;'> \n"+
					"		<input type='button' value='excluir' onclick='$(\"#item-material_"+indice+"\").remove();'> \n"+
					"	</div> \n"+
					"</li>";

			$("#lista-materiais").append(item);
		}
		else
		{
			alert('É nessário informar o material e a quantidade!');
		}
	}

}

function addMaterialValor(material_id, material, valor)
{
	
	var values = $("input[name='material_id[]']")
              .map(function(){return $(this).val();}).get();

	var teste = values.indexOf('1');

	if(valor == "" || isNaN(valor))
		valor = "0.00";

	if(values.indexOf(material_id) > -1)
		alert('Material já cadastrado!');
	else
	{
		if(material_id > 0)
		{
			indice = $("#lista-materiais li").size();
			item = "<li id='item-material_"+indice+"'>	\n"+		
					"	<div style='align:left;'> \n"+
					"		<input type='hidden' name='material_id[]' value='"+material_id+"'> \n"+
					"		Material: "+material+" \n"+
					"		<input type='hidden' name='material_valor[]' value='"+valor+"'> \n"+
					"		Valor: "+valor+" \n"+
					"	</div> \n"+
					"	<div style='align:center;'> \n"+
					"		<input type='button' value='excluir' onclick='$(\"#item-material_"+indice+"\").remove();'> \n"+
					"	</div> \n"+
					"</li>";

			$("#lista-materiais").append(item);

		}
		else
		{
			alert('É nessário informar o material!');
		}
	}

}

function addMaterialValorQtde(material_id, material, valor, qtde)
{
	
	var values = $("input[name='material_id[]']")
              .map(function(){return $(this).val();}).get();

	var teste = values.indexOf('1');

	if(valor == "" || isNaN(valor))
		valor = "0.00";

	if(values.indexOf(material_id) > -1)
		alert('Material já cadastrado!');
	else
	{
		if(material_id > 0 && qtde > 0)
		{
			indice = $("#lista-materiais li").size();
			item = "<li id='item-material_"+indice+"'>	\n"+		
					"	<div style='align:left;'> \n"+
					"		<input type='hidden' name='material_id[]' value='"+material_id+"'> \n"+
					"		Material: "+material+" \n"+
					"		<input type='hidden' name='material_valor[]' value='"+valor+"'> \n"+
					"		Valor: "+valor+" \n"+
					"		<input type='hidden' name='material_qtde[]' value='"+qtde+"'> \n"+
					"		Quantidade: "+qtde+" KG \n"+
					"	</div> \n"+
					"	<div style='align:center;'> \n"+
					"		<input type='button' value='excluir' onclick='$(\"#item-material_"+indice+"\").remove();'> \n"+
					"	</div> \n"+
					"</li>";

			$("#lista-materiais").append(item);

		}
		else
		{
			alert('É nessário informar o material e a quantidade coletada!');
		}
	}

}

function addDia()
{
 	hora = $('#horario_intervalo').val();

 	dia = $("input[name=dia_semana]:checked").val();

 	if(validaIntervalo(hora))
 		addDias(hora, dia);

}

function addDias(hora, dia)
{


	if(dia != undefined && hora != '')
	{
		indice = $("#lista-dias li").size();
		item = "<li id='item-dia_"+indice+"'>	\n"+		
				"	<div style='align:left;'> \n"+
				"		<input type='hidden' name='dia[]' value='"+dia+"'> \n"+
				"		Dia: "+dia+" \n"+
				"	</div> \n"+
				"	<div style='align:center;'> \n"+
				"		<input type='hidden' name='horario[]' value='"+hora+"'> \n"+
				"		Horário: "+hora+"\n"+
				"	</div> \n"+
				"	<div style='align:center;'> \n"+
				"		<input type='button' value='excluir' onclick='$(\"#item-dia_"+indice+"\").remove();'> \n"+
				"	</div> \n"+
				"</li>";

		$("#lista-dias").append(item);
		$("#horario_intervao").val('');
	}
	else
	{
		alert('É nessário informar o dia e horário!');
	}
}

function limpaPedido()
{
	$("#material_nome").val('');
	$("input[name=material_quantidade]").val("");
	$('#lista-materiais').empty();
	$("select[name=pedido_periodicidade]").val("");
	$("select[name=pedido_frequencia]").val("");
	$("#horario_hora").val('');
	$("#horario_minuto").val('');
	$('#lista-dias').empty();
	$("textarea[name=pedido_obs]").val("");
	$('input[name=dia_semana]').removeAttr('checked'); 
}

function buscaCep(cep)
{

	$("#bairro").val('');
	$("#logradouro").val('');
	$("#regiao").val('');

	$.ajax({
    // a url do xjsonml
        url : "../ws/busca_cep.php?cep="+cep,
    // o tipo de dados que é xml
        dataType : "json",
    // antes de enviar loga "Enviando"
        beforeSend : function(){
            $('#loadgif').show();
        },
    // se terminar com sucesso loga o retorno
        success : function(json){
        	if(json.regiao != undefined)
	    	{
		    	$("#bairro").val(json.bairro);
		    	$("#logradouro").val(json.logradouro);
		    	$("#regiao").val(json.regiao);
        	}
		    else
		    {
		    	alert("CEP Inválido ou fora da cidade de São Paulo");
		    }

		    $('#loadgif').hide();
        }
    });
}

function validaIntervalo(horas)
{
	var hora1 = horas.substring(3, 8);
	var hora2 = horas.substring(16, 21);

	hora1 = parseInt(hora1.replace('h',''));
	hora2 = parseInt(hora2.replace('h',''));

	if(hora1 >= hora2)
	{
		alert("Intervalo inválido");
		$('#horario_intervalo').val('');
		return false;
	}
	else
		return true;
}