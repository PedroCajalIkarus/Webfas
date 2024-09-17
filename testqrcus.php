<?php

// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);

// Notificar todos los errores de PHP
error_reporting(-1);

// Lo mismo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

/*
$curl = curl_init();
$queryString='-H "Content-Type: application/json" -d "{\"user\": \"marco\", \"password\": \"marcopass\", \"outcome_data\": [{\"type\": 1, \"category\": 15, \"v_string\": \"ip_test\"}, {\"type\": 2, \"category\": 15, \"v_string\": \"ip_test_mm\"}]}';
curl_setopt($curl, CURLOPT_URL, "http://10.173.148.243:10000/get_outcome_connections"); // Replace with your target URL
curl_setopt($curl, CURLOPT_POST, true); // Set method to POST
curl_setopt($curl, CURLOPT_POSTFIELDS, $queryString); // Set POST data
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Capture response

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo "cURL Error: " . curl_error($curl);
    exit;
  }
  */
      ///    http://10.173.148.243:10000/test_db_connection

  $url = "http://10.173.148.243:10000/get_run_id_save_outcome";
  echo $url."<br>";
$data = [
  "user" => "marco",
  "password" => "marcopass",
  "outcome_data" => [
    [
      "type" => 1,
      "category" => 19,
      "v_string" => "ip_test2"
    ],
    [
      "type" => 2,
      "category" => 15,
      "v_string" => "ip_test_mm3"
    ]
  ]
];

$jsonData = json_encode($data); // Convert data to JSON string

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);            // Set method to POST
//curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Set POST data as JSON string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Capture response
curl_setopt($ch, CURLOPT_HTTPHEADER, [          // Set headers
  'Content-Type: application/json'
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
  echo "cURL Error: " . curl_error($ch);
  exit;
}
echo "cURL : ".$response;
// Process response as needed (e.g., decode JSON)

curl_close($ch);

?>