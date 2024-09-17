<?php
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the XML data from the request
    $xmlData = file_get_contents('php://input');

 

    // Check if XML data was received
    if ($xmlData) {
        // Process the XML data (you can parse, validate, and manipulate it as needed)
        // For example, let's just return the received XML as is
        echo $xmlData;
    } else {
        // Handle the case where no XML data was received
        echo '<response>No XML data received.</response>';
    }
} else {
    // Handle other request methods (e.g., GET)
    echo '<response>Invalid request method.</response>';
}


$elxmlrecibido = new SimpleXMLElement($xmlData);
//echo "a verr";
//echo $elxmlrecibido->Row->AUFNR;
 

 
$findme   = 'Fiplex_PrdOrdDetails';
$pos = strpos($xmlData, $findme);

// ONLY WO - PO
if ($pos === false) {
  ////  echo "La cadena '$findme' no fue encontrada en la cadena ";
} else {
  //  echo "La cadena '$findme' fue encontrada en la cadena ";
   // echo " y existe en la posición $pos";
	$name_file_po = "PRODORD_O_".$elxmlrecibido->Row->AUFNR.".xml";
	
	$content = $xmlData;
	$fp = fopen("D:\\Digboardlog\\Source\\SAPXMLTEST\\".$name_file_po,"wb");
	fwrite($fp,$content);
	fclose($fp);
	
}

// ONLY SO
$findme   = 'Fiplex_SaleOrdDetails';
$pos = strpos($xmlData, $findme);

// ONLY WO - PO
if ($pos === false) {
  ////  echo "La cadena '$findme' no fue encontrada en la cadena ";
} else {
  //  echo "La cadena '$findme' fue encontrada en la cadena ";
   // echo " y existe en la posición $pos";
	$name_file_po = "SORD_O_".$elxmlrecibido->Row->VBELN.$elxmlrecibido->Row->POSNR.".xml";
	
	$content = $xmlData;
	$fp = fopen("D:\\Digboardlog\\Source\\SAPXMLTEST\\".$name_file_po,"wb");
	fwrite($fp,$content);
	fclose($fp);
	
}

//ACKORD_O_101248920_0010_SC226L0122.xml
// ONLY SO
$findme   = 'ProdOrdResponse';
$pos = strpos($xmlData, $findme);

// ONLY WO - PO
if ($pos === false) {
  ////  echo "La cadena '$findme' no fue encontrada en la cadena ";
} else {
  //  echo "La cadena '$findme' fue encontrada en la cadena ";
   // echo " y existe en la posición $pos";
	$name_file_po = "ACKORD_O_".$elxmlrecibido->Row->AUFNR."_".$elxmlrecibido->Row->VORNR."_".$elxmlrecibido->Row->GERNR.".xml";
	
	$content = $xmlData;
	$fp = fopen("D:\\Digboardlog\\Source\\SAPXMLTEST\\".$name_file_po,"wb");
	fwrite($fp,$content);
	fclose($fp);
	
	
}

include("db_conect.php"); 
 
$xmlData= "STRESS.".$xmlData;

$sentenciach = $connect->prepare("INSERT INTO audit_xml_post(datetimereceived, textxml)	VALUES (now(),  :textxmlll);");
        $sentenciach->bindParam(':textxmlll', $xmlData);	 
        $sentenciach->execute();
        


?>