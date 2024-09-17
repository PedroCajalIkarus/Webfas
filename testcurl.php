<?php
$curl = curl_init();
$paramurl= "https://webfas.honeywell.com//trackingorders_onlysnoldajax.php?isdo=487&typeisdo=WO&encont=21056241FU";

 
 
echo $paramurl."<br>";
curl_setopt($curl, CURLOPT_URL, $paramurl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
echo "<br>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
if (curl_errno($curl)) {
    echo 'Error: ' . curl_error($curl);
    exit;
} 
echo $response; 
echo "<br>bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb";

?>