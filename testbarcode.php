<?php
echo "HOLA";
///php-barcode.php

 

$barcodeText= "22014320FU";
echo '<img class="barcode" alt="'.$barcodeText.'" src="barcodephp/barcode.php?text='.$barcodeText.'&codetype=code128&orientation=horizontal&size=50&print=true"/>';

 

?>