<?php
// Configura��es header para for�ar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Description: PHP Generated Data" );
?>

<!-- Here's where I want my views to be displayed -->
<?= $this->fetch('content') ?>
