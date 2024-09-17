<?php 
$url = 'https://webfasdev.honeywell.com/';

$protocols = [
    'TLS1.0' => ['protocol' => CURL_SSLVERSION_TLSv1_0, 'sec' => false],
    'TLS1.1' => ['protocol' => CURL_SSLVERSION_TLSv1_1, 'sec' => false],
    'TLS1.2' => ['protocol' => CURL_SSLVERSION_TLSv1_2, 'sec' => true],
    'TLS1.3' => ['protocol' => CURL_SSLVERSION_TLSv1_3, 'sec' => true],
];

foreach ($protocols as $name => $value) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSLVERSION, $value['protocol']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch) !== false;

    if ($value['sec'] && !$response) {
        echo "<br>Secure $name not supported <br>";
    } elseif ($value['sec'] && $response) {
        echo "<br>Ok! Secure $name supported <br>";
    } elseif (!$value['sec'] && $response) {
        echo "<br>Insecure $name supported <br>";
    } elseif (!$value['sec'] && !$response) {
        echo "<br>Ok! Insecure $name not supported <br>";
    }
}
?>