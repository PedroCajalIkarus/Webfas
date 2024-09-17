<?php

use Aws\S3\S3Client;

define('AWS_KEY', 'F9GE351LYTJ9WONR7A1Q');
define('AWS_SECRET_KEY', '5Yc8SOkiie93CjbATTQuZLbWVOZL002PkxNnnz7A');
$ENDPOINT = 'ewr1.vultrobjects.com ';

// require the amazon sdk from your composer vendor dir
require 'aws/vendor/autoload.php';

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


$listResponse = $clientS3amazon->listBuckets();
$buckets = $listResponse['Buckets'];
foreach ($buckets as $bucket) {
    echo $bucket['Name'] . "\t" . $bucket['CreationDate'] . "\n";
}

?>