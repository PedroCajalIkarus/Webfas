<?php
//$output = exec("ipconfig /all");

$macAddress_server_bd = 'A0-36-9F-8E-1F-0F';

$output=null;
$retval=null;
exec('ipconfig /all', $output, $retval);

 
function buscar_string_en_array_multinivel_con_array_walk($array, $string ) {
    $found = false;

    array_walk($array, function ($value, $key) use (&$found, $string) {
     ///   echo "<br>*-valor:".$value;


        $pos = strpos($value, $string);

            // Note our use of ===.  Simply == would not work as expected
            // because the position of 'a' was the 0th (first) character.
            if ($pos === false) {
            //   echo "The string '$value' NO '$string'";
            
            } else {
            //   echo "The string '$value' SII '$string'";
            //   echo " and exists at position $pos";
                $found = true;
            }
                    
             

    });

    return $found;
}


$key = buscar_string_en_array_multinivel_con_array_walk($output, $macAddress_server_bd);

//echo "El string $macAddress_server_bd se encuentra en el array en la posición $key.";
if ($key !== false) {
    echo "<br>el string $macAddress_server_bd se encuentra en el array.";
} else {
    echo "<br>el string $macAddress_server_bd no se encuentra en el array.";
}