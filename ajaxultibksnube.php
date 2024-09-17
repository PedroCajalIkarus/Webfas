<?php 
			
			$path  = '/var/backups/pgsql'; 
			$ultdiaconbks_srvusa="";
			// Arreglo con todos los nombres de los archivos
			$files = array_diff(scandir($path), array('.', '..')); 
			
			foreach($files as $file){
					// Divides en dos el nombre de tu archivo utilizando el . 
					$data          = explode(".", $file);
					// Nombre del archivo
					$fileName      = $data[0];
					// Extensión del archivo 
					$fileExtension = $data[1];

					 $ultdiaconbks_srvusa= $fileName;
						// Realizamos un break para que el ciclo se interrumpa
					
				}
echo  $ultdiaconbks_srvusa;
			?>