<?php

function esNumerico($string) {
    // Eliminar espacios en blanco
    $string = trim($string);
  
    // Validar que no esté vacío
    if (empty($string)) {
      return false;
    }
  
    // Validar que solo contenga caracteres numéricos
    if (!preg_match('/^[0-9]+$/', $string)) {
      return false;
    }
  
    return true;
  }

 //////////////////////////////////////////////////////////////////
// Función para validar el valor según las reglas
function validarValor($valor, $reglas) {
	$errores = [];
	$reglas = json_decode( trim( $reglas) );
	// Validar si no contiene la palabra "MDOEL"
	 
	//echo "<hr>HolaaMMM:".$reglas->contain."---<br>valor:".$valor."<br>---<hr>";
	if (isset($reglas->not_contain) && strpos($valor, $reglas->not_contain) !== false) {
	  $errores[] = "The value cannot contain the word \"" .$reglas->not_contain . "\".";
	}
  
	// Validar si contiene la palabra "FIP446"
	if (isset($reglas->contain) && strpos($valor, $reglas->contain) === false) {
	  $errores[] = "The value must contain the word \"" . $reglas->contain . "\".";
	}
  
	
	// Validar la longitud mínima
 
	if (isset( $reglas->min_longitud )  && strlen($valor) < $reglas->min_longitud ) {
	  $errores[] = "The value must have a minimum length of " . $reglas->min_longitud . " characters.";
	  
	}

    if (isset( $reglas->isnumeric ) &&  (esNumerico($valor)==false) ) {
        $errores[] = " the value entered must be numerical  .";
        
      }
	
  
	return $errores;
  }

  //////////////////////////////////////////////////////////////////
?>