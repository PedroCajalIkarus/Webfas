<?php 
// Jalamos las librerias de dompdf
error_reporting(E_ALL);
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

// instantiate and use the dompdf class



function getHtml($url, $post = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    if(!empty($post)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    } 
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

# Contenido HTML del documento que queremos generar en PDF.
$html="";
  $vparam_vnrounitsn = $_REQUEST['idsndib']; ///

$html = getHtml('http://192.168.60.26/webfas/calibrationtopdfconimg2.php?', 'idsndib=20066159FU&iduldl=0&idmb=0'); // GET & POST request


function generateFileName()
{
$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789_";
$name = "";
for($i=0; $i<12; $i++)
$name.= $chars[rand(0,strlen($chars))];
return $name;
}
//get a random name of the file here
$fileName = generateFileName();


# Instanciamos un objeto de la clase DOMPDF.
$mipdf = new DOMPDF();

# Definimos el tamaño y orientación del papel que queremos.
# O por defecto cogerá el que está en el fichero de configuración.
$mipdf ->set_paper("letter", "portrait");

# Cargamos el contenido HTML.
$mipdf ->load_html(utf8_decode($html));

# Renderizamos el documento PDF.
$mipdf ->render();

# Enviamos el fichero PDF al navegador.
$mipdf ->stream($fileName.'.pdf');

?>