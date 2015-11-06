<?php

$this->layout = 'sheet';
header ("Content-Disposition: attachment; filename=\"planilha.xls\"" );

?>
<table border='1'>
	<?= $coletas; ?>
	<tr>
		<td colspan="3"></td>
	</tr>
	<tr>
		<td><b>Remuneração Total</b></td>
		<td><b>Quantidade Total(KG)</b></td>
	</tr>
	<tr>
		<td><?= $total_valor; ?></td>
		<td><?= $total_qtde; ?></td>
	</tr>
</table>