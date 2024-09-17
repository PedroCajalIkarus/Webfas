<?php

    error_reporting(0);
    //control ataques de querystring
    if( $_REQUEST['mkt_tok']<> '')
    {
    echo "Error...";
    exit();
    }

    // Desactivar toda notificación de error
    error_reporting(0);

    include("db_conect.php"); 
        header('Content-Type: application/json');
        
        session_start();

    //FIXME: Change connection
    $connection = pg_connect("host=localhost dbname=dbfiplex user=postgres password=Cajal69709901");
    if(!$connection){
        echo "Connection error<br>";
        exit;
    }
    function is_ajax_request() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }

    $namefirmware = isset($_POST['namefirmware']) ? $_POST['namefirmware'] : '';
    $idrev = isset($_POST['idrev']) ? (int) $_POST['idrev'] : '';

    if(is_ajax_request()) {
        $query = "DELETE FROM fas_firmwarelist WHERE namefirmware = '$namefirmware' AND idrev = $idrev";
        $result = pg_query($connection, $query);
        if($result) {

            $vuserfas = $_SESSION["b"];
            $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
            $vaccionweb="deletefirmware";
                $vdescripaudit="deletefirmware-Name:".$namefirmware."-Idrev:".$idrev;
            $vtextaudit="";
            
            $sentenciach = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
                            $sentenciach->bindParam(':userfas', $vuserfas);								
                            $sentenciach->bindParam(':menuweb', $vmenufas);
                            $sentenciach->bindParam(':actionweb', $vaccionweb);
                            $sentenciach->bindParam(':descripaudit', $vdescripaudit);
                            $sentenciach->bindParam(':textaudit', $vtextaudit);
                            $sentenciach->execute();
        }
    } else {
        echo "Invalid request. Please provide both 'namefirmware' and 'idrev'.";
    }
?>

