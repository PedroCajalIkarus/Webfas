<?php
 
 $ipserver="127.0.0.1";
 $vuserdb="wfeibpulseexr";
 $vuserdb="bucardo";
 $vpassdb="EUT$Y6VdwvZx6-KJ";
 $vdbname="dbfiplexrepli";
 $vdbname="dbfiplex";
 
   $inactividad = 12000;
 
 $folderservidor = ''; 
 
  $connect = new PDO('pgsql:host='.$ipserver.';port=5432;dbname='.$vdbname.';user='.$vuserdb.';password='.$vpassdb.'');
  //$connect->setAttribute(PDO::ATTRR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  
  //Fecha del servidor de base de datos.
  $sql = $connect->prepare('SELECT fnt_list_servertime(1)' );
  $sql->execute();
  $resultado = $sql->fetchAll();
  foreach ($resultado as $row) {
  
        echo "<br>Hola:".$row[0];
  
   }

   for ($i = 1; $i <= 100; $i++) {
    echo "<br>I connect with user ".$i.".";
    ${"connect" . $i} = new PDO('pgsql:host='.$ipserver.';port=5432;dbname='.$vdbname.';user='.$vuserdb.';password='.$vpassdb.'');
    ${"connect" . $i}->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	   ${"sql".$i} =${"connect".$i}->prepare("SELECT * FROM runinfodb WHERE dateserver > current_date" );
  ${"sql".$i}->execute();
  $resultado =  ${"sql".$i}->fetchAll();
  foreach ($resultado as $row) {
  
        echo "<br> I read and insert {".$i." }:".$row[0];
		
		   $sqlinsrt="CALL sp_insert_fasclient_log('TEST STRESS MARCO - Bucardo".$i." - test day:".date("Y-m-d H:i:s")."******- ###erivera###Station 08 Erickson###192.168.60.173###Exception	ERROR: more than one row returned by a subquery used as an expression   Where: SQL statement  PL/pgSQL function sp_update_fas_petitionsserver_inituserstation(character varying,character varying) line 8 at assignment')";
   
      ${"sql".$i} =${"connect".$i}->prepare( $sqlinsrt );
  ${"sql".$i}->execute();
  
   }
   
   ///Insetamos y seguimos


}

  ?>