<?php
 

   for ($i = 1; $i <= 10000; $i++) {
    echo "<br>I connect with user ".$i.".";

    $data='<?xml version="1.0" encoding="utf-8"?>
    <n0:MT_Fiplex_PrdOrdDetails xmlns:n0="http://honeywell.com/sap/MF/Fiplex_ProdordDetails" xmlns:prx="urn:sap.com:proxy:BRP:/1SAI/TASF0E7168C8115752BAB6D:740">
      <Row>
        <AUFNR>101259874'.$i.'</AUFNR>
        <PLNBEZ>DH147S-RMA-MTHR</PLNBEZ>
        <GAMNG>5.000</GAMNG>
      </Row>
    </n0:MT_Fiplex_PrdOrdDetails>';

// Inicializamos la sesión cURL
$ch = curl_init();

// Establecemos la URL del destino
curl_setopt($ch, CURLOPT_URL, "https://webfas.honeywell.com/receiveddatasapbyconector2strees.php");

// Establecemos el método de la solicitud como POST
curl_setopt($ch, CURLOPT_POST, true);

// Establecemos los datos que deseamos enviar
 
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Ejecutamos la solicitud
$response = curl_exec($ch);

// Cerramos la sesión cURL
curl_close($ch);

// Imprimimos la respuesta
echo $response;


}

  ?>