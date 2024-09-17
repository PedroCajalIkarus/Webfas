
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
	 session_start();

	 $v_stringdatabb=  1;
	 $v_categoryoutcome=0;
	 $v_catidtype=13;
	 $_idruninfo_reference= $_REQUEST['idr'];



	 $sqlcheck="SELECT reference from fas_outcome_integral where reference = ".$_idruninfo_reference." and idfasoutcomecat = 0 and idtype = 13";
	 
	 	$have_totalpass= 0;
	 //	echo "test:".$sqldetectchkeo;
	   $datadetectprecheko = $connect->query($sqlcheck)->fetchAll();
	   foreach ($datadetectprecheko as $rowchequeo) 
	   {
		$have_totalpass= 1;
	   }

	   $mmstring ="Forced TRUE";
	   if (	$have_totalpass== 0)
	   {

			$sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, :v_boolean, null, null,:v_string, null);");
		//      echo "---tengo fail----".$v_statussn."hOLAAA ".$v_stringdatabb;
			 $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
			 $sentenciach->bindParam(':idtype', $v_catidtype);			
			 $sentenciach->bindParam(':reference', $_idruninfo_reference);								
			 $sentenciach->bindParam(':v_boolean', $v_stringdatabb); 
			 $sentenciach->bindParam(':v_string', $mmstring); 
			 
			 $sentenciach->execute();

			 $sqlcheck="update fas_outcome_integral set v_boolean= true, v_string = CONCAT('Forced TRUE - datetime: ',now()) where reference = ".$_idruninfo_reference." and idfasoutcomecat = 0 and idtype = 13";	 

			 $datadetectprecheko = $connect->query($sqlcheck)->fetchAll();
	   }
	   else
	   {

			$sqlcheck="update fas_outcome_integral set v_boolean= true, v_string = CONCAT('Forced TRUE - datetime: ',now()) where reference = ".$_idruninfo_reference." and idfasoutcomecat = 0 and idtype = 13";	 

	  		$datadetectprecheko = $connect->query($sqlcheck)->fetchAll();
	   }

	   echo "UPDATE OK";
	 ?>
