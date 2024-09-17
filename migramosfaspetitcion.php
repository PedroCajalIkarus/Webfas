<?php

include("db_conect.php"); 


$query_lista ="SELECT *
FROM public.fas_petitions_server
where date > '2020-10-25' and instance = '03F' and parameters1 is not null
order by date";
    
    $elquery1="delete from fas_petitions_server_detailssfp";
    echo $elquery1;
    $connect->query($elquery1);


//echo $query_lista;
$vvmaxidproduct=0;
    $data = $connect->query($query_lista)->fetchAll();	
        foreach ($data as $row) {			
           echo " <hr><br>HOLA".$row['parameters1'];
           $objdd = json_decode($row['parameters1']);
         //  echo "<br>Obj snsdib:".   $objdd->snsdib;
           $obtsndib = json_decode( $objdd->snsdib ); 
         //  echo "<br>Obj snsdib 1 :".   $objdd->snsdib[0];
        //    echo "---------------";

           for ($x=0;$x<count($objdd->snsdib); $x++)
           {
                   echo "Idpetitios".$row['idpetition']."->".$objdd->snsdib[$x]."<br>";
                   // Buscamos los SN
               
        
           
           $idagrupado = 0;
           $idtempo = 0;
         
         // for ($xs=0;$xs<count($objdd->sns); $xs++)
         //  {
                 //  echo "<br>SN:".$objdd->sns[$xs]."<br>";
                   // Buscamos los SN
                   $xs=$x;
                   for ($xsm=0;$xsm<count($objdd->sns[$xs]); $xsm++)
                   {
                     
                     echo "<br>SN:".$objdd->sns[$xs][$xsm]."<br>";
                     $elquery= "INSERT INTO public.fas_petitions_server_detailssfp( idfasserverdetails, datetimedet, snsdib, sndet, measuretime, scripttime, idgroupby, idpetition)
                        VALUES ((select coalesce(max(idfasserverdetails),0)+1 from fas_petitions_server_detailssfp), '".$row['date']."', '".$objdd->snsdib[$x]."', '".$objdd->sns[$xs][$xsm]."',".$objdd->measuretime." ,".$objdd->scripttime." , ".$idagrupado.", ".$row['idpetition'].");";

                    echo $elquery;
                    $connect->query($elquery);
                    if (  $idtempo == 1 )
                    {
                    $idtempo =   0;
                    $idagrupado =  $idagrupado +1;
                    }
                    else
                    {
                      //  $idagrupado = 0;
                        $idtempo = 1 ;
                    }
                   }
                   
          // }
        }
        echo "<br>Obj snsdib sns :".count($objdd->sns)."-->".  $objdd->sns;     
      echo "<br>------------   FIN-------------------------------<br>";
        }


?>