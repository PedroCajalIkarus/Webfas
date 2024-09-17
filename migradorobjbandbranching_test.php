<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
include("db_conect.php"); 
 include("db_conect_srv20.php"); 
 
 	session_start();
 
  if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	//	echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php");
        }
			if ($_SESSION["a"] =="")
		{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php");
		}
		
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php");
        
	}
	
		/// DETECTO PERMISOS EN PAG!
		 $sql = $connect->prepare("select bum.idmenu, menu_action.idmenu_action,  menu_action.nameaction from business_user_menu as bum inner join menu on menu.idmenu = bum.idmenu left join business_user_menu_action as buma on buma.idbusiness = bum.idbusiness and buma.iduserfas =  bum.iduserfas and buma.idmenu =  bum.idmenu left join menu_action on menu_action.idmenu_action = buma.idaction where menu.linkaccess  =  '".array_pop(explode('/', $_SERVER['PHP_SELF']))."' and bum.iduserfas = ".$_SESSION["a"]." and bum.idbusiness = ".$_SESSION["i"]);
		$sql->execute();
		$resultado = $sql->fetchAll();							
		$pag_habilitada = "N";
		
		$permiso_create_edit_po = "N";
		$permiso_param_po = "N";
		$permiso_assing_so = "N";
		$permiso_assing_sn = "N";
		
		foreach ($resultado as $row) 
		{
			$pag_habilitada = "Y";
					

		}
 
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	
//****************************************************************	
	function marco_encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}

function marco_decrypt($string, $key) {
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}
//****************************************************************	
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIPLEX</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterangepicker -->
   <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
   <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">

  
  <!-- AdminLTE css -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 <link rel="stylesheet" href="cssfiplexsintextareaslog.css">
 

<link href="css/select2.css" rel="stylesheet" />
<link href="css/testcssselector.css" rel="stylesheet" />
<link rel="stylesheet" href="themestreecss/default2/style.css">
  
    <link rel="stylesheet" href="cssfiplex.css">
</head>
<form name="frma" id="frma">
<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="http://webfas.fiplex.com/index.php" class="nav-link">Home</a>
      </li>
      
    </ul>

 

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu --> 
   <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">      
         
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"></span>
        </a>
      
      </li>
    	  
      <!-- Notifications Dropdown Menu -->
    </ul>
  </nav>
  <!-- /.navbar -->
<?php 	  

 include("menu.php"); 
 include("funcionesstores.php"); 
 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();
        
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ObjBand Vs Brancking Diego - SRV 10.4.253.20 TEST </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">template web</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <!-- Timelime example  -->
        <div class="row">
          <section class="col-lg-6 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
        <div class="container-fluid">
					<?php
       
         

        $sqllinea="select ppp.idproduct,  ppp.modelciu,  losobjband.*, fas_branching_sku_ref.branching_sku_ref,
        vhf_full_band, vhf_nro_band, uhf_450512_band, uhf_450470_band, uhf_470512_band ,   products_attributes.idattribute , public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch,fas_branching_sku_ref.*
        from fas_branching_sku
        inner join fas_branching_sku_ref
        on fas_branching_sku.branchingref  = fas_branching_sku_ref.branching_sku_ref
        inner join fnt_select_allproducts_maxrev() as ppp
        on ppp.fiplexsku   = fas_branching_sku.skuref
        left join 
          (
            select ciu, maxidrev, ARRAY_AGG (idband || '#' ||description || '#' || ccc) losdatosobjband
            from
            (
                select  ciu, idband.idband,  idband.description,count( objband.idband)::text as  ccc, max(idrev) as maxidrev
            from fnt_select_objectband_maxrev() as objband
            inner join idband
            on idband.idband	= objband.idband
            group by ciu, idband.description,idband.idband
            order by ciu
            ) as fff
            group by ciu,maxidrev
          
          ) as losobjband
          on losobjband.ciu   = ppp.modelciu
          left join products_attributes
          on products_attributes.idproduct   = ppp.idproduct and
          products_attributes.idattribute = 22 and
          products_attributes.v_boolean = TRUE

        
          order by modelciu  ";
  
        //  $sql = $connect->prepare("");
          $sql = $connect20->prepare($sqllinea);
      
        $sql->execute();
        $resultado = $sql->fetchAll();
       $return_arr = array();
       $mmm=0;

       $v_cant_bandas_tiene_objband=0;
       $v_cant_bandas_tiene_excel=0;

       $vv_dlgain =-1;
       $vv_ulgain = -1;
       $vv_dlmaxpwr =0;
       $vv_ulmaxpwr =24;
       /*
       SI  BDA = Columna AO y AP  gain
       SI  DAS PSC = 85 y 85  --  DAS ENTER 80 - 80 gain 
       ulmaxpwr = 24 siempre
       dl max pwr --  -- idattribute = 22
       */

    
       foreach ($resultado as $row) 
       {
         echo  $mmm."-namebranch:".$row['namebranch']."<br>";

         
$cadena_de_texto = $row['namebranch'];
$cadena_buscada   = 'BDA';
$posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
 
//se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='

     ///   echo  "-Exec:".$row['losdatosobjband']."<br>";

     $v_cant_bandas_tiene_objband=0;
     $v_cant_bandas_tiene_excel=0;
     $v_elmaxidrev_by_product= 0;

            if ($row['maxidrev'] =="")
            {
              $v_elmaxidrev_by_product= 1;
              echo "a verrr:".$v_elmaxidrev_by_product;
            
            }
            else
            {
              $v_elmaxidrev_by_product= $row['maxidrev']+1;
              echo "a verrr2:".$v_elmaxidrev_by_product;
            }

          

             if ($row['losdatosobjband'] !="")
            {
            

                  $vowels = array('{','}','"');
                  $losdatossincaractereslocos = str_replace($vowels, "", $row['losdatosobjband']); 
                  $v_losdatosobjband = explode(",",$losdatossincaractereslocos);

                  ///      echo "<br>catttt:". count( $v_losdatosobjband);
               
                  for ($i = 0; $i < count( $v_losdatosobjband); ++$i)
                  {
                  ///   echo "<br>a:". $v_losdatosobjband[$i];
                    $v_cant_bandas_tiene_objband= $v_cant_bandas_tiene_objband + 1 ;
                  }
            }


        
         

            // vhf_full_band, vhf_nro_band, uhf_450512_band, uhf_450470_band, uhf_470512_band
            //////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////
            if ( $row['vhf_full_band'] >= 1)
              {
                if ( $row['idattribute'] == 22)
                {
                   $vv_dlmaxpwr =$row['post_vhf_dl_high'] ;
                }
                else
                {
                 $vv_dlmaxpwr =$row['post_vhf_dl_stand'] ;  
                }

                $v_cant_bandas_tiene_excel =  $v_cant_bandas_tiene_excel + $row['vhf_full_band'];

                  ////////// BUSCAMOS GAIN
                if ($posicion_coincidencia === false) {
                  echo "<br>888 *NO  BDA ";
                  $cadena_buscada2   = 'DAS';
                  $posicion_coincidencia2 = strpos($cadena_de_texto, $cadena_buscada2);
                  if ($posicion_coincidencia2 === false) 
                  {
                    $vv_dlgain =-1;
                    $vv_ulgain = -1;
                  echo "HOLA._8_".$cadena_de_texto."--".$cadena_buscada2."-->".$posicion_coincidencia2;
                 
                  }
                  else
                  {
                    echo "<br>elseHOLA._8_".$cadena_de_texto."--".$cadena_buscada2."-->".$posicion_coincidencia2;
                 
                    ///////////////////////////////////
                        /*
                        SI  BDA = Columna AO y AP  gain
                        SI  DAS PSC = 85 y 85  --  DAS ENTER 80 - 80 gain 
                        ulmaxpwr = 24 siempre
                        dl max pwr --  -- idattribute = 22
                        */

                    $cadena_buscada3   = 'PSC';
                    $posicion_coincidencia3 = strpos($cadena_de_texto, $cadena_buscada3);
                    if ($posicion_coincidencia3 === false) 
                    {
                        $cadena_buscada4   = 'ENTERPRISE';
                        $posicion_coincidencia4 = strpos($cadena_de_texto, $cadena_buscada4);
                        if ($posicion_coincidencia4 === false) 
                        {
                          $vv_dlgain =85;
                          $vv_ulgain = 85;
                        }
                        else
                        {
                            ////////////////SI ENTERPRISE////////////
                            $vv_dlgain =80;
                            $vv_ulgain = 80;
                            
                        }
                    }
                    else
                    {
                      $vv_dlgain =85;
                      $vv_ulgain = 85;
                        ////////////////SI PSC////////////
                        ///////////////////////////////////
                        
                    }
                  }

                  } else {
                  echo "<brSI BDA: ".$posicion_coincidencia;

                  $vv_dlgain =$row['gain_uhf_dh14'];
                  $vv_ulgain = $row['gain_uhf_dh14'];

                  }
                  ////////// BUSCAMOS GAIN


                echo "<hr>";     
                $sqlobjband = "INSERT INTO public.objectband( ciu, idband, idportinul, idportoutul, idportindl, idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule, idproduct, idrev)
                  VALUES ('".$row['modelciu']."', 0, 
                   (select distinct idportinul from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                   (select distinct idportoutul from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")), 
                   (select distinct idportindl from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                   (select distinct idportoutdl from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                    ".$vv_dlgain.", ".$vv_ulgain.", ".$vv_dlmaxpwr.", ".$vv_ulmaxpwr.", 'A', FALSE,".$row['idproduct']." ,". $v_elmaxidrev_by_product.");";
                  echo $sqlobjband."<br>";
                 $sqlmas = $connect20->prepare($sqlobjband );      
                 $sqlmas->execute();

                  //// Insertamos Attributos para n band
                  $sqlinsertattriband = "INSERT INTO public.products_attributes(idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)  
                  VALUES (".$row['idproduct'].", 72, now(), TRUE, 0, 1, null, null) ;";
                  echo "<br>".$sqlinsertattriband;
                 $sqlmas = $connect20->prepare($sqlinsertattriband);      
                  $sqlmas->execute();


              }
              //////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////

              if ( $row['vhf_nro_band'] >= 1)
              {
                if ( $row['idattribute'] == 22)
                {
                   $vv_dlmaxpwr =$row['post_vhf_dl_high'] ;
                }
                else
                {
                 $vv_dlmaxpwr =$row['post_vhf_dl_stand'] ;  
                }

                $v_cant_bandas_tiene_excel =  $v_cant_bandas_tiene_excel + $row['vhf_nro_band'];

                 ////////// BUSCAMOS GAIN
                 if ($posicion_coincidencia === false) {
                  echo "<br>888 *NO  BDA ";
                  $cadena_buscada2   = 'DAS';
                  $posicion_coincidencia2 = strpos($cadena_de_texto, $cadena_buscada2);
                  if ($posicion_coincidencia2 === false) 
                  {
                  $vv_dlgain =-1;
                  $vv_ulgain = -1;
                //  echo "HOLA._8_".$cadena_de_texto."--".$cadena_buscada2."-->".$posicion_coincidencia2;
                 
                  }
                  else
                  {
                 //   echo "<br>elseHOLA._8_".$cadena_de_texto."--".$cadena_buscada2."-->".$posicion_coincidencia2;
                 
                    ///////////////////////////////////
                        /*
                        SI  BDA = Columna AO y AP  gain
                        SI  DAS PSC = 85 y 85  --  DAS ENTER 80 - 80 gain 
                        ulmaxpwr = 24 siempre
                        dl max pwr --  -- idattribute = 22
                        */

                    $cadena_buscada3   = 'PSC';
                    $posicion_coincidencia3 = strpos($cadena_de_texto, $cadena_buscada3);
                    if ($posicion_coincidencia3 === false) 
                    {
                        $cadena_buscada4   = 'ENTERPRISE';
                        $posicion_coincidencia4 = strpos($cadena_de_texto, $cadena_buscada4);
                        if ($posicion_coincidencia4 === false) 
                        {
                          $vv_dlgain =85;
                          $vv_ulgain = 85;
                        }
                        else
                        {
                            ////////////////SI ENTERPRISE////////////
                            $vv_dlgain =80;
                            $vv_ulgain = 80;
                        }
                    }
                    else
                    {
                      $vv_dlgain =85;
                      $vv_ulgain = 85;
                        ////////////////SI PSC////////////
                        ///////////////////////////////////
                        
                    }
                  }

                  } else {
                  echo "<brSI BDA: ".$posicion_coincidencia;

                  $vv_dlgain =$row['gain_uhf_dh14'];
                  $vv_ulgain = $row['gain_uhf_dh14'];

                  }
                  ////////// BUSCAMOS GAIN

 

                    echo "<hr>";     
                    $sqlobjband="INSERT INTO public.objectband( ciu, idband, idportinul, idportoutul, idportindl, idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule, idproduct, idrev)
                      VALUES ('".$row['modelciu']."', 0, 
                      (select distinct idportinul from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                   (select distinct idportoutul from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")), 
                   (select distinct idportindl from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                   (select distinct idportoutdl from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                        ".$vv_dlgain.", ".$vv_ulgain.", ".$vv_dlmaxpwr.", ".$vv_ulmaxpwr.", 'A', FALSE,".$row['idproduct']." ,". $v_elmaxidrev_by_product.");";
                   
                        echo $sqlobjband."<br>";
                        $sqlmas = $connect20->prepare($sqlobjband );      
                        $sqlmas->execute();
                        /*
                        id attribute 72 -- Booleano para FULL BAND -- Integer para relacionar la banda - double _ cant de subban a pedir a luciana en la carga.
                        */
                           //// Insertamos Attributos para n band
                  $sqlinsertattriband = "INSERT INTO public.products_attributes(idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)  
                  VALUES (".$row['idproduct'].", 72, now(), FALSE, 0, 1, null, null) ;";
                echo "<br>".$sqlinsertattriband;
                  $sqlmas = $connect20->prepare($sqlinsertattriband);      
                  $sqlmas->execute();

              }

              //////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////
              if ( $row['uhf_450512_band'] >= 1)
              {
                if ( $row['idattribute'] == 22)
                {
                   $vv_dlmaxpwr =$row['post_uhf_dl_high'] ;
                }
                else
                {
                 $vv_dlmaxpwr =$row['post_uhf_dl_stand'] ;  
                }

                $v_cant_bandas_tiene_excel =  $v_cant_bandas_tiene_excel + $row['uhf_450512_band'];

                ////////// BUSCAMOS GAIN
                if ($posicion_coincidencia === false) {
                  echo "<br>888 *NO  BDA ";
                  $cadena_buscada2   = 'DAS';
                  $posicion_coincidencia2 = strpos($cadena_de_texto, $cadena_buscada2);
                  if ($posicion_coincidencia2 === false) 
                  {
                  $vv_dlgain =-1;
                  $vv_ulgain = -1;
                //  echo "HOLA._8_".$cadena_de_texto."--".$cadena_buscada2."-->".$posicion_coincidencia2;
                 
                  }
                  else
                  {
                 //   echo "<br>elseHOLA._8_".$cadena_de_texto."--".$cadena_buscada2."-->".$posicion_coincidencia2;
                 
                    ///////////////////////////////////
                        /*
                        SI  BDA = Columna AO y AP  gain
                        SI  DAS PSC = 85 y 85  --  DAS ENTER 80 - 80 gain 
                        ulmaxpwr = 24 siempre
                        dl max pwr --  -- idattribute = 22
                        */

                    $cadena_buscada3   = 'PSC';
                    $posicion_coincidencia3 = strpos($cadena_de_texto, $cadena_buscada3);
                    if ($posicion_coincidencia3 === false) 
                    {
                        $cadena_buscada4   = 'ENTERPRISE';
                        $posicion_coincidencia4 = strpos($cadena_de_texto, $cadena_buscada4);
                        if ($posicion_coincidencia4 === false) 
                        {
                          $vv_dlgain =85;
                          $vv_ulgain = 85;
                        }
                        else
                        {
                            ////////////////SI ENTERPRISE////////////
                            $vv_dlgain =80;
                            $vv_ulgain = 80;
                        }
                    }
                    else
                    {
                      $vv_dlgain =85;
                      $vv_ulgain = 85;
                        ////////////////SI PSC////////////
                        ///////////////////////////////////
                        
                    }
                  }

                  } else {
                  echo "<brSI BDA: ".$posicion_coincidencia;

                  $vv_dlgain =$row['gain_uhf_dh14'];
                  $vv_ulgain = $row['gain_uhf_dh14'];

                  }
                  ////////// BUSCAMOS GAIN

                  echo "<hr>";     
                  $sqlobjband = "INSERT INTO public.objectband( ciu, idband, idportinul, idportoutul, idportindl, idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule, idproduct, idrev)
                    VALUES ('".$row['modelciu']."', 8, 
                    (select distinct idportinul from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                    (select distinct idportoutul from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")), 
                    (select distinct idportindl from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                    (select distinct idportoutdl from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                      ".$vv_dlgain.", ".$vv_ulgain.", ".$vv_dlmaxpwr.", ".$vv_ulmaxpwr.", 'A', FALSE,".$row['idproduct']." ,". $v_elmaxidrev_by_product.");";
                      
                      echo $sqlobjband."<br>";
                      $sqlmas = $connect20->prepare($sqlobjband );      
                      $sqlmas->execute();

                          //// Insertamos Attributos para n band
                  $sqlinsertattriband = "INSERT INTO public.products_attributes(idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)  
                  VALUES (".$row['idproduct'].", 72, now(), FALSE, 8, ".$row['uhf_450512_band'].", null, null) ;";
               //   echo "<br>".$sqlinsertattriband;
                  $sqlmas = $connect20->prepare($sqlinsertattriband);      
                 $sqlmas->execute();

              }
              //////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////

            

              if ( $row['uhf_450470_band'] >= 1)
              {
                if ( $row['idattribute'] == 22)
                {
                   $vv_dlmaxpwr =$row['post_uhf_dl_high'] ;
                }
                else
                {
                 $vv_dlmaxpwr =$row['post_uhf_dl_stand'] ;  
                }

                $v_cant_bandas_tiene_excel =  $v_cant_bandas_tiene_excel + $row['uhf_450470_band'];

                ////////// BUSCAMOS GAIN
                if ($posicion_coincidencia === false) {
                  echo "<br>888 *NO  BDA ";
                  $cadena_buscada2   = 'DAS';
                  $posicion_coincidencia2 = strpos($cadena_de_texto, $cadena_buscada2);
                  if ($posicion_coincidencia2 === false) 
                  {
                  $vv_dlgain =-1;
                  $vv_ulgain = -1;
                //  echo "HOLA._8_".$cadena_de_texto."--".$cadena_buscada2."-->".$posicion_coincidencia2;
                 
                  }
                  else
                  {
                 //   echo "<br>elseHOLA._8_".$cadena_de_texto."--".$cadena_buscada2."-->".$posicion_coincidencia2;
                 
                    ///////////////////////////////////
                        /*
                        SI  BDA = Columna AO y AP  gain
                        SI  DAS PSC = 85 y 85  --  DAS ENTER 80 - 80 gain 
                        ulmaxpwr = 24 siempre
                        dl max pwr --  -- idattribute = 22
                        */

                    $cadena_buscada3   = 'PSC';
                    $posicion_coincidencia3 = strpos($cadena_de_texto, $cadena_buscada3);
                    if ($posicion_coincidencia3 === false) 
                    {
                        $cadena_buscada4   = 'ENTERPRISE';
                        $posicion_coincidencia4 = strpos($cadena_de_texto, $cadena_buscada4);
                        if ($posicion_coincidencia4 === false) 
                        {
                          $vv_dlgain =85;
                          $vv_ulgain = 85;
                        }
                        else
                        {
                            ////////////////SI ENTERPRISE////////////
                            $vv_dlgain =80;
                            $vv_ulgain = 80;
                        }
                    }
                    else
                    {
                      $vv_dlgain =85;
                      $vv_ulgain = 85;
                        ////////////////SI PSC////////////
                        ///////////////////////////////////
                        
                    }
                  }

                  } else {
                  echo "<brSI BDA: ".$posicion_coincidencia;

                  $vv_dlgain =$row['gain_uhf_dh14'];
                  $vv_ulgain = $row['gain_uhf_dh14'];

                  }
                  ////////// BUSCAMOS GAIN


                  echo "<hr>";     
                  $sqlobjband = "INSERT INTO public.objectband( ciu, idband, idportinul, idportoutul, idportindl, idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule, idproduct, idrev)
                    VALUES ('".$row['modelciu']."', 1, 
                    (select distinct idportinul from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                   (select distinct idportoutul from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")), 
                   (select distinct idportindl from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                   (select distinct idportoutdl from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                      ".$vv_dlgain.", ".$vv_ulgain.", ".$vv_dlmaxpwr.", ".$vv_ulmaxpwr.", 'A', FALSE,".$row['idproduct']." ,". $v_elmaxidrev_by_product.");";
                      echo "<br>";

                     echo $sqlobjband."<br>";
                      $sqlmas = $connect20->prepare($sqlobjband );      
                      $sqlmas->execute();


                         //// Insertamos Attributos para n band
               $sqlinsertattriband = "INSERT INTO public.products_attributes(idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)  
               VALUES (".$row['idproduct'].", 72, now(), FALSE, 1, ".$row['uhf_450470_band'].", null, null) ;";
             //  echo "<br>".$sqlinsertattriband;
               $sqlmas = $connect20->prepare($sqlinsertattriband);      
               $sqlmas->execute();

              }

              //////////////////////////////////////////////////////////////////////////////

                

              if ( $row['uhf_470512_band'] >= 1)
              {
                if ( $row['idattribute'] == 22)
                {
                   $vv_dlmaxpwr =$row['post_uhf_dl_high'] ;
                }
                else
                {
                  $vv_dlmaxpwr =$row['post_uhf_dl_stand'] ;  
                }

                $v_cant_bandas_tiene_excel =  $v_cant_bandas_tiene_excel + $row['uhf_470512_band'];

                ////////// BUSCAMOS GAIN
                if ($posicion_coincidencia === false) {
                  echo "<br>888 *NO  BDA ";
                  $cadena_buscada2   = 'DAS';
                  $posicion_coincidencia2 = strpos($cadena_de_texto, $cadena_buscada2);
                  if ($posicion_coincidencia2 === false) 
                  {
                  $vv_dlgain =-1;
                  $vv_ulgain = -1;
                //  echo "HOLA._8_".$cadena_de_texto."--".$cadena_buscada2."-->".$posicion_coincidencia2;
                 
                  }
                  else
                  {
                 //   echo "<br>elseHOLA._8_".$cadena_de_texto."--".$cadena_buscada2."-->".$posicion_coincidencia2;
                 
                    ///////////////////////////////////
                        /*
                        SI  BDA = Columna AO y AP  gain
                        SI  DAS PSC = 85 y 85  --  DAS ENTER 80 - 80 gain 
                        ulmaxpwr = 24 siempre
                        dl max pwr --  -- idattribute = 22
                        */

                    $cadena_buscada3   = 'PSC';
                    $posicion_coincidencia3 = strpos($cadena_de_texto, $cadena_buscada3);
                    if ($posicion_coincidencia3 === false) 
                    {
                        $cadena_buscada4   = 'ENTERPRISE';
                        $posicion_coincidencia4 = strpos($cadena_de_texto, $cadena_buscada4);
                        if ($posicion_coincidencia4 === false) 
                        {
                          $vv_dlgain =85;
                          $vv_ulgain = 85;
                        }
                        else
                        {
                            ////////////////SI ENTERPRISE////////////
                            $vv_dlgain =80;
                            $vv_ulgain = 80;
                        }
                    }
                    else
                    {
                      $vv_dlgain =85;
                      $vv_ulgain = 85;
                        ////////////////SI PSC////////////
                        ///////////////////////////////////
                        
                    }
                  }

                  } else {
                  echo "<brSI BDA: ".$posicion_coincidencia;

                  $vv_dlgain =$row['gain_uhf_dh14'];
                  $vv_ulgain = $row['gain_uhf_dh14'];

                  }
                  ////////// BUSCAMOS GAIN


                  echo "<hr>";     
                  $sqlobjband = "INSERT INTO public.objectband( ciu, idband, idportinul, idportoutul, idportindl, idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule, idproduct, idrev)
                    VALUES ('".$row['modelciu']."', 7, 
                    (select distinct idportinul from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                   (select distinct idportoutul from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")), 
                   (select distinct idportindl from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                   (select distinct idportoutdl from objectband where idproduct = ".$row['idproduct']." and idrev in( select max(idrev) from objectband where idproduct =  ".$row['idproduct'].")),
                      ".$vv_dlgain.", ".$vv_ulgain.", ".$vv_dlmaxpwr.", ".$vv_ulmaxpwr.", 'A', FALSE,".$row['idproduct']." ,". $v_elmaxidrev_by_product.");";
                   
                      echo $sqlobjband."<br>";
                      $sqlmas = $connect20->prepare($sqlobjband );      
                      $sqlmas->execute();

                      
                         //// Insertamos Attributos para n band
                   $sqlinsertattriband = "INSERT INTO public.products_attributes(idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)  
                   VALUES (".$row['idproduct'].", 72, now(), FALSE, 7, ".$row['uhf_470512_band'].", null, null) ;";
                  // echo "<br>".$sqlinsertattriband;
                   $sqlmas = $connect20->prepare($sqlinsertattriband);      
                   $sqlmas->execute();
                   
              }


              echo  "<br>".$row['modelciu']." °°°°°°°° SKU:".$row['branching_sku_ref']." ::::::- cant_bandas_tiene_objband: ".$v_cant_bandas_tiene_objband." - cant_bandas_tiene_excel ". $v_cant_bandas_tiene_excel;
            
              if ($v_cant_bandas_tiene_objband ==$v_cant_bandas_tiene_excel)
              {
                echo "----> <span style='color:green'><b>ok</b></span>";
              }
              if ($v_cant_bandas_tiene_objband ==0)
              {
                echo "----> <span style='color:red'><b>Missing ObjBand</b></span>";
              }

            



                $sqlinsertattri = "INSERT INTO public.products_attributes(idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)  VALUES (".$row['idproduct'].", 71, now(), null, null, null, '".trim($row['branching_sku_ref'])."', null) ;";
               echo "<br>".$sqlinsertattri;
             ////  select idrev+1 from objectband where idproduct = 
               $sqlmas = $connect20->prepare($sqlinsertattri);      
                $sqlmas->execute();
              echo "<hr>";   
   
          }
           
       
          
          ?>
				</div>
        </div>
			</div>
					

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" style="cursor: move;">
               		
				<div class="card">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i>Log Details :: </h3>
							<i class="fa fa-fw fa-user"></i> <label  name="lblvuser" id="lblvuser"> </label>
							<i class="fa fa-fw fa-tv"></i> <label  name="lblvdevice" id="lblvdevice"> </label>
							<i class="fa fa-fw fa-inbox"></i> <label  name="lblvstationr" id="lblvstationr"> </label>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    <textarea class="form-control form-controltamanio" rows="18" id="detallelog" name="detallelog"></textarea>
					<p name="detallelog1" id="detallelog1" ></p>						
					<p name="msjwait" id="msjwait" align="center"><img src="img/waitazul.gif" width="100px" ></p>						
                  </div>
              
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
				  
				  
              
				</div>	
				</div>	
		 </section>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->
	
	
	
  </div>
  <!-- /.content-wrapper -->
  
  </form>

<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Server Time:</b> 
<span name="date-part" id="date-part"></span>
<span name="time-part" id="time-part"></span>
    </div>
    <strong>Copyright &copy; 2020 Admin Fas FIPLEX</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->


<!-- AdminLTE for daterangepickers -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>

<script src="crypto-js.js"></script><!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>

<script src="plugins/jquery-knob/jquery.knob.min.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>

</body>

<script type="text/javascript">

   
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live
		  
			$('#msjwaitline ').hide();
			$('#divscrolllog').show(); 
			$('#p-b0').hide();
			$('#p-b0').CardWidget('toggle');		
			$("#detallelog").hide();
			$("#detallelog").text("");
			$("#msjwait").hide();			

				toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": true,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "300",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};				
			
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
		
	  
   
   function show_log(idlog_view)
   {
	 	   
	 $("#detallelog").fadeOut('fast');  
	  $("#msjwait").fadeIn('slow');   
		
		 $("#uso").val(1);
		 
	    $.ajax
			({ 
				url: 'readlogbyruninfo.php',
				data: "idlog="+idlog_view,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
					//detallelog
					 $("#msjwait").hide();
					 	$("#detallelog").fadeIn(100);						
						//var re = /<TERM>/g; 						
						$("#detallelog").html(datax.data.replace(/<br>/g,' \r\n'));
						
						if ($( window ).height()>800)
						{
							$("#detallelog").height(585);
						}
						
						
						$( window ).height();
						
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log2('+anex	+')") ><i class="fas fa-bug" style="color:blue"></i></a>');
					
				}
			});
   }
     function show_log2(idlog_view)
   {
	 	   
	 	 	   
	 $("#detallelog").fadeOut('fast');  
	  $("#msjwait").fadeIn('slow');   
		
		 $("#uso").val(1);
		 
	    $.ajax
			({ 
				url: 'readlogbyruninfodebug.php',
				data: "idlog="+idlog_view,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
					//detallelog
					 $("#msjwait").hide();
					 	$("#detallelog").fadeIn(100);						
						//var re = /<TERM>/g; 						
						$("#detallelog").html(datax.data.replace(/<br>/g,' \r\n'));
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log('+anex	+')") ><i class="fas fa-bug" style="color:green"></i></a>');
					
				}
			});
			
   }
   
</script>

</html>
<?php
	/////////////////////////////////////////////////////////////////////////////////////
				//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
				$vuserfas = $_SESSION["b"];
				$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
				$vaccionweb="visitweb";
					$vdescripaudit="visitweb#".$_SERVER['SERVER_ADDR'];
				$vtextaudit="";
				
				$sentenciach = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciach->bindParam(':userfas', $vuserfas);								
								$sentenciach->bindParam(':menuweb', $vmenufas);
								$sentenciach->bindParam(':actionweb', $vaccionweb);
								$sentenciach->bindParam(':descripaudit', $vdescripaudit);
								$sentenciach->bindParam(':textaudit', $vtextaudit);
								$sentenciach->execute();
								
							
				/////////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////////
?>