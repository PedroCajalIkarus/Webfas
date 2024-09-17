<?php

error_reporting(E_ALL);
require 'aws/aws-autoloader.php';

use Aws\S3\S3Client;

define('AWS_KEY', 'F9GE351LYTJ9WONR7A1Q');
define('AWS_SECRET_KEY', '5Yc8SOkiie93CjbATTQuZLbWVOZL002PkxNnnz7A');
define('HOST', 'https://ewr1.vultrobjects.com/');
define('REGION', 'us-east-2');





// Establish connection with DreamObjects with an S3 client.
$client = new Aws\S3\S3Client([
    'version'     => 'latest',
    'region'      => REGION,
          'endpoint'    => HOST,
        'credentials' => [
        'key'      => AWS_KEY,
        'secret'   => AWS_SECRET_KEY,
    ]
]);

$buckets = $client->listBuckets();
try {
    foreach ($buckets['Buckets'] as $bucket){
        echo "{$bucket['Name']}\t{$bucket['CreationDate']}\n";

        $objects = $client->listObjectsV2([
            'Bucket' => $bucket['Name'],
        ]);
        echo "<br>".$bucket['Name']." - Cant Img:".count ($objects['Contents']);


    }
} catch (S3Exception $e) {
    echo $e->getMessage();
    echo "\n";
}
echo "<br>**********LIST*****************<br>";
$objects = $client->listObjectsV2([
    'Bucket' => 'fpxwebfas',
]);
echo "Cant Img".count ($objects['Contents']);
//foreach ($objects['Contents'] as $object){
//echo "{$object['Key']}\t{$object['LastModified']}\n<br> ver Img".HOST."/".$object['Key'];
//echo "<br> ver Img: ".HOST."/".$object['Key'];
//}




echo "<br>**********LIST*****************<br>";

//Get a command to GetObject
$cmd = $client->getCommand('GetObject', [
    'Bucket' => 'fpxwebfas',
    'Key'    => 'plots/0000000021004.png'
]);

//The period of availability
$request = $client->createPresignedRequest($cmd, '+20 minutes');

 //echo var_dump($request);
//Get the pre-signed URL
$signedUrl = (string) $request->getUri();
//echo "<br>a ver aqui:".$signedUrl;

/*
$url = $client->getObjectUrl('fpltest1', '0000000021004.png');


echo "<br>HOLA 2".$url;

*/
echo "<img src='".$signedUrl."' width='20%'>";



//Get a command to GetObject
$cmdaa = $client->getCommand('GetObject', [
    'Bucket' => 'fpxwebfas',
    'Key'    => 'Plots/31052005919/0000206418/004.png'
]);

//The period of availability
$requestmm = $client->createPresignedRequest($cmdaa, '+20 minutes');

 //echo var_dump($request);
//Get the pre-signed URL
$signedUrlmm = (string) $requestmm->getUri();
//echo "<br>a ver aqui:".$signedUrl;

/*
$url = $client->getObjectUrl('fpltest1', '0000000021004.png');


echo "<br>HOLA 2".$url;

*/
echo "<img src='".$signedUrlmm."' width='20%'>";

// Co

/*

define('AWS_KEY', 'F9GE351LYTJ9WONR7A1Q');
define('AWS_SECRET_KEY', '5Yc8SOkiie93CjbATTQuZLbWVOZL002PkxNnnz7A');
$ENDPOINT = 'ewr1.vultrobjects.com ';

// Print the body of the result by indexing into the result object.
echo $result['Body'];

// require the amazon sdk from your composer vendor dir

// Instantiate the S3 class and point it at the desired host
$clientS3amazon = new S3Client([
    'region' => '',
    'version' => '2006-03-01',
    'endpoint' => $ENDPOINT,
    'credentials' => [
        'key' => AWS_KEY,
        'secret' => AWS_SECRET_KEY
    ],
    // Set the S3 class to use objects.dreamhost.com/bucket
    // instead of bucket.objects.dreamhost.com
    'use_path_style_endpoint' => true
]);
*/
/*

$listResponse = $clientS3amazon->listBuckets();
$buckets = $listResponse['Buckets'];
foreach ($buckets as $bucket) {
    echo $bucket['Name'] . "\t" . $bucket['CreationDate'] . "\n";
}
*/
?>