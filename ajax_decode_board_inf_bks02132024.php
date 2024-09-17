<?php
error_reporting(0);
  include("db_conect.php");
  	header('Content-Type: application/json');

//////////////////////////////////////////////////////////////////
// Función para validar el valor según las reglas
function validarValor($valor, $reglas) {
	$errores = [];
  
	// Validar si no contiene la palabra "MDOEL"
	if (isset($reglas['not_contain']) && strpos($valor, $reglas['not_contain']) !== false) {
	  $errores[] = "El valor no puede contener la palabra \"" . $reglas['not_contain'] . "\".";
	}
  
	// Validar si contiene la palabra "FIP446"
	if (isset($reglas['contain']) && strpos($valor, $reglas['contain']) === false) {
	  $errores[] = "El valor debe contener la palabra \"" . $reglas['contain'] . "\".";
	}
  
	// Validar la longitud mínima
	if (isset($reglas['min_longitud']) && strlen($valor) < $reglas['min_longitud']) {
	  $errores[] = "El valor debe tener una longitud mínima de " . $reglas['min_longitud'] . " caracteres.";
	}
  
	return $errores;
  }

  //////////////////////////////////////////////////////////////////

   
	  $simbolosaborrar = array("");

	$textoauditar= $_REQUEST['textoauditar'];  
    $v_txtdecode = $_REQUEST['txtdecode'];
	$sku_for_check = $_REQUEST['sku_for_check'];

	$datavvmm = json_decode( trim( $v_txtdecode) );
	if ($datavvmm === null) {
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
		$tiene_valudacion = 0;
		   //$return_result = str_replace('"', "", $rowqr[0]);
		   $return_result_valid = $rowqrvalid['v_string'];
	  }

	  if ( $tiene_valudacion == 1)
	  {
	  		$especificaciones = json_decode( $return_result_valid);
			// Validar los valores
			$errores = [];

			if ($especificaciones['CHECK_SN']) {
			$erroresSN = validarValor($sn, $especificaciones['SN']);
			$errores = array_merge($errores, $erroresSN);
			}

			if ($especificaciones['CHECK_REV']) {
			$erroresREV = validarValor($rev, $especificaciones['REV']);
			$errores = array_merge($errores, $erroresREV);
			}

			if ($especificaciones['CHECK_BATCH']) {
			$erroresBATCH = validarValor($batch, $especificaciones['BATCH']);
			$errores = array_merge($errores, $erroresBATCH);
			}

			// Mostrar los errores
			if (count($errores) > 0) {
			echo "Errores al validar los datos:\n";
			foreach ($errores as $error) {
				echo "- " . $error . "\n";
			}
			} else {
			echo "Los datos son válidos.";
			}
	  }
	  
	  // echo $queryskuvalid;
	$dataqr = $connect->query($query_lista)->fetchAll();	
	foreach ($dataqr as $rowqr) 
	{
	 	//$return_result = str_replace('"', "", $rowqr[0]);
		 $return_result = $rowqr[0];
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