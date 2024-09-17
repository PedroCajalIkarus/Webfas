<?php

exec('java -version ', $output);
print_r("java version:".$output);

//exec('java -jar fas.jar ', $output);
//print_r($output);
?>