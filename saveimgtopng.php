<?php

  $imageData =  $_REQUEST['imgdata'];
                
 function generateRandomString($length = 10) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}
  
  $filteredData = substr($imageData, strpos($imageData, ",") + 1);
  $unencodedData = ($filteredData);
 echo "abc->".$filteredData;

// Specify the location where you want to save the image
$randomFileName = generateRandomString();
$fileName = "$randomFileName.png";
	$img_file = '/var/www/html/webfas/tempimgpdf/'.$fileName;




   $ifp = fopen( $img_file, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $imageData );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp,$imageData  );

    // clean up the file resource
    fclose( $ifp ); 
	
	
/*  $fp = fopen('/var/tmp/temppdf/file1.png', 'wb');

  fwrite($fp, $unencodedData);
  fclose($fp);
  */
 // $success = file_put_contents('/var/tmp/temppdf/file1.png', $unencodedData);
?>