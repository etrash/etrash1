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
		else if(material_id > 0 && quantidade == -1)
		{
			indice = $("#lista-materiais li").size();
			item = "<li id='item-material_"+indice+"'>	\n"+		
					"	<div style='align:left;'> \n"+
					"		<input type='hidden' name='material_id[]' value='"+material_id+"'> \n"+
					"		Material: "+material+" \n"+
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

function addDia()
{
 	hora = $('#horario_hora option:selected').text();
 	minuto = $('#horario_minuto option:selected').text();

 	dia = $("input[name=dia_semana]:checked").val();

 	addDias(hora, minuto, dia);

}

function addDias(hora, minuto, dia)
{

	if(hora !='' && minuto != '')
		horario_todo = hora + ":" + minuto;
	else
		horario_todo = '';

	if(dia != undefined && horario_todo != '')
	{
		indice = $("#lista-dias").size();
		item = "<li id='item-dia_"+indice+"'>	\n"+		
				"	<div style='align:left;'> \n"+
				"		<input type='hidden' name='dia[]' value='"+dia+"'> \n"+
				"		Dia: "+dia+" \n"+
				"	</div> \n"+
				"	<div style='align:center;'> \n"+
				"		<input type='hidden' name='horario[]' value='"+horario_todo+"'> \n"+
				"		Horário: "+horario_todo+"\n"+
				"	</div> \n"+
				"	<div style='align:center;'> \n"+
				"		<input type='button' value='excluir' onclick='$(\"#item-dia_"+indice+"\").remove();'> \n"+
				"	</div> \n"+
				"</li>";

		$("#lista-dias").append(item);
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