<?php

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

?>