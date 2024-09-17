<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Nombre del bucket de S3
$bucketName = 'mi-bucket';

// Ruta del archivo txt local
$filePath = '/ruta/al/archivo.txt';

// Clave del objeto en S3 (por ejemplo, 'archivos/archivo.txt')
$objectKey = 'archivos/archivo.txt';

try {
    $s3Client = new S3Client([
        'region' => 'us-east-1',
        'credentials' => [
            'key' => 'tu-clave-de-acceso',
            'secret' => 'tu-clave-secreta',
        ]
    ]);

    $result = $s3Client->putObject([
        'Bucket' => $bucketName,
        'Key' => $objectKey,
        'SourceFile' => $filePath,
    ]);

    echo 'Archivo subido correctamente.';
} catch (AwsException $e) {
    echo 'Error al subir el archivo: ' . $e->getMessage();
}

?>