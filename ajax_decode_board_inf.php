<?php
error_reporting(0);
  include("db_conect.php");
  	header('Content-Type: application/json');
// error_reporting(E_ALL);
include("validatorassyqr.php");
	  $msjerr="";


   
	  $simbolosaborrar = array("");

	$textoauditar= $_REQUEST['textoauditar'];  
    $v_txtdecode = $_REQUEST['txtdecode'];
	$sku_for_check = $_REQUEST['sku_for_check'];

	$continene_simboljson="N";
	if (strpos($v_txtdecode, "{") !== false) {
	//	echo "El string contiene el símbolo {";
			$continene_simboljson="S";
	  } else {
		//echo "El string no contiene el símbolo {";
			$continene_simboljson="N";
	  }

	$datavvmm = json_decode( trim( $v_txtdecode) );
	if ($datavvmm === null || 	$continene_simboljson=="N" ) {
		//echo "El string no tiene un formato JSON válido";
		$query_lista= "select * from fnt_decode_board_information('".trim( $v_txtdecode)."')";
	  } else {
		//echo "El string es un JSON válido";
		$query_lista= "select * from 	fnt_decode_board_information_json('".trim( $v_txtdecode)."')";
	  }

	  ////Buscamos los parametros de validacion del SKU.
	  $queryskuvalid="select * from products_attributes where idattribute =146 and idproduct in ( select distinct idproduct from products where modelciu = '".$sku_for_check."')";
	  
	  $dataqrvalid = $connect->query($queryskuvalid)->fetchAll();	
	  $tiene_valudacion = 0;
	  foreach ($dataqrvalid as $rowqrvalid) 
	  {
			$tiene_valudacion = 1;
		   //$return_result = str_replace('"', "", $rowqr[0]);
		   $return_result_valid = '['.trim($rowqrvalid['v_string']).']';
 
	  }
 
	  if ( $tiene_valudacion == 1)
	  {
//		echo "SI entre IF";
//	echo "<br>*". $return_result_valid."*<br>";
	///$jsonString = '[{"CHECK_SN":true,"CHECK_REV":false,"CHECK_BATCH":false,"SN":{"contain":"FU","min_longitud":8,}}]';
	//echo "<br>*". $jsonString."*<br>";	
 	
// Decodificar el JSON existente
	$data = json_decode($return_result_valid);
 
 
	//var_dump($data[0]->SN );

//var_dump($data[0] );
//echo "------------------------A".$data[0]->SN->contain."<br> ----b".$data[0]->SN->min_longitud."------------------------<br>";
//echo "<br>----------CHECK_SN:".$data[0]->CHECK_SN."<br> <br>";

	  // echo $queryskuvalid;
	  $dataqr = $connect->query($query_lista)->fetchAll();	
	  foreach ($dataqr as $rowqr) 
	  {
		   //$return_result = str_replace('"', "", $rowqr[0]);
		   $return_result = $rowqr[0];
	  }
  
	 /// echo "<br>return_result:".$return_result."<br>vevo:";
	  $decode_valijpostres= json_decode($return_result,true);
	    ///var_dump($decode_valijpostres);
		//echo "SN a controlar:::::".$decode_valijpostres['t_set'];
		
		  // Validar los valores
		  $errores = [];
		 // 	echo "<br>q tiene en CHECK_SN:".$data[0]->CHECK_SN."<br>".($data[0]->CHECK_REV);
			if ($data[0]->CHECK_SN=="1") {
				//echo "<br>CHECK SN es TRUE ************".json_encode($data[0]->SN);
				$sn=$decode_valijpostres['t_set'];
			$erroresSN = validarValor($sn, json_encode($data[0]->SN));
			$errores = array_merge($errores, $erroresSN);
			}
  
			if ( $data[0]->CHECK_REV ==1 ) {
			
				$rev=$decode_valijpostres['t_rev'];
				//	echo "<br>CHECK_REV es TRUE ****".$rev."********".json_encode($data[0]->REV);
			$erroresREV = validarValor($rev, json_encode($data[0]->REV));
			$errores = array_merge($errores, $erroresREV);
			}
  
			if ( $data[0]->CHECK_BATCH ==1   ) {
				$batch=$decode_valijpostres['t_lot'];
			$erroresBATCH = validarValor($batch, json_encode($data[0]->BATCH));
			$errores = array_merge($errores, $erroresBATCH);
			}

			if ( $data[0]->CHECK_SKU ==1   ) {
				$sn=$decode_valijpostres['t_set'];
				if ($sn !='')
				{
					$queryskuvalidsku ="select idorders from orders_sn where wo_serialnumber = '".$sn."' and idproduct in (select idproduct from products where modelciu = '".$sku_for_check."')";
					///echo $queryskuvalidsku;
					$dataqrvalidsku = $connect->query($queryskuvalidsku)->fetchAll();	
					$is_same_sku="N";
					foreach ($dataqrvalidsku as $rowqrvalid) 
					{
						$is_same_sku="Y";
					}
				 
					///$erroresBATCH = validarValor($batch, json_encode($data[0]->BATCH));
					if ($is_same_sku=="N")
					{
						$errores_sku[] = " SN enters is not a SKU:".$sku_for_check;
						$errores = array_merge($errores, $errores_sku);
					}
				}
				
			}
			
  
			// Mostrar los errores
			if (count($errores) > 0) {
				///echo "Errores al validar los datos:\n";
			foreach ($errores as $error) {
				//echo "- " . $error . "\n";
				$msjerr = $msjerr."- " . $error . "\n";
				$return_result= '{"status":"error"}';
			}
			} else {
			//echo "Los datos son válidos.";
			}
			 
	 
			 
		
	  }
	  else
	  {
		//no tiene validacion . sigue normal. version sin control.
		$dataqr = $connect->query($query_lista)->fetchAll();	
		foreach ($dataqr as $rowqr) 
		{
			 //$return_result = str_replace('"', "", $rowqr[0]);
			 $return_result = $rowqr[0];
		}
	  }
	  



				  // Insertamos Estado 
		///////////////////////////AUDIT MARCO SCAN//////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////
				  $vuserfas = $_SESSION["b"];
				  $typeregister="WO";
				  $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
				  $vaccionweb="SCANPICKING";
				  $vdescripaudit="Scan Qr-barcod:".$textoauditar."- user:".$vuserfas;
				  $vtextaudit = $textoauditar." - ".trim( $v_txtdecode);
				  
						  $sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
				/////////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////////

		
	//echo $sql."<br>";

 echo(json_encode(["result"=>$return_result,"erromsj"=>$msjerr]));
 

?>