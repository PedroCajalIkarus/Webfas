<?php

echo "--- CALL File Jar Console.....<br>";
exec('java -jar /var/www/html/webfas/Print_Label_zebra.jar DHS00-M6-001#19096043FU  ', $output2);
print_r($output2);
?>		