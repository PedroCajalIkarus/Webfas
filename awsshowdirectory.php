<?php




// Desactivar toda notificación de error
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);

 include("db_conect.php"); 
 
 	session_start();

     require 'aws/aws-autoloader.php';
   //  require 'aws/fplmm.php';
     
  



echo "arrancando 17<br>"; 
$bucket_name ="fpxwebfas";


define('AWS_KEY', 'F9GE351LYTJ9WONR7A1Q');
define('AWS_SECRET_KEY', '5Yc8SOkiie93CjbATTQuZLbWVOZL002PkxNnnz7A');
define('HOST', 'https://ewr1.vultrobjects.com/');
define('REGION', 'us-east-2');

use Aws\S3\S3Client;

// Establish connection with DreamObjects with an S3 client.
$clientS3AWS = new Aws\S3\S3Client([
    'version'     => 'latest',
    'region'      => REGION,
         'endpoint'    => HOST,
        'credentials' => [
        'key'      => AWS_KEY,
        'secret'   => AWS_SECRET_KEY,
    ]
]);


try {
  $contents = $clientS3AWS->listObjects([
      'Bucket' => $bucket_name,
  ]);
  echo "The contents of your bucket are: \n";
  foreach ($contents['Contents'] as $content) {
      echo $content['Key'] . "\n";
  }
} catch (Exception $exception) {
  echo "Failed to list objects in $bucket_name with error: " . $exception->getMessage();
  exit("Please fix error with listing objects before continuing.");
}

echo "Finnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn".$buckets ."<br>";


?>