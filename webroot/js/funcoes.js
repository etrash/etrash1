function addMaterial(material, quantidade)
{
	if(material != '' && quantidade > 0)
	{
		indice = $("#lista-materiais").size();
		item = "<li id='item-material_"+indice+"'>	\n"+		
				"	<div style='align:left;'> \n"+
				"		<input type='hidden' name='material[]' value='"+material+"'> \n"+
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
		alert('� ness�rio informar o material e a quantidade!');
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
				"		Hor�rio: "+horario_todo+"\n"+
				"	</div> \n"+
				"	<div style='align:center;'> \n"+
				"		<input type='button' value='excluir' onclick='$(\"#item-dia_"+indice+"\").remove();'> \n"+
				"	</div> \n"+
				"</li>";

		$("#lista-dias").append(item);
	}
	else
	{
		alert('� ness�rio informar o dia e hor�rio!');
	}
}