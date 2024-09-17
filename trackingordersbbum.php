
<!DOCTYPE html>


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
 
  
    <link rel="stylesheet" href="cssfiplex.css">
    <style>
    .track {
     position: relative;
     background-color: #ddd;
     height: 7px;
     display: -webkit-box;
     display: -ms-flexbox;
     display: flex;
     margin-bottom: 60px;
     margin-top: 50px
 }

 .track .step {
     -webkit-box-flex: 1;
     -ms-flex-positive: 1;
     flex-grow: 1;
     width: 25%;
     margin-top: -18px;
     text-align: center;
     position: relative
 }

 .track .step.active:before {
     background: #FF5722
 }

 .track .step::before {
     height: 7px;
     position: absolute;
     content: "";
     width: 100%;
     left: 0;
     top: 18px
 }

 .track .step.active .icon {
     background: #ee5435;
     color: #fff
 }

 .track .icon {
     display: inline-block;
     width: 40px;
     height: 40px;
     line-height: 40px;
     position: relative;
     border-radius: 100%;
     background: #ddd
 }

 .track .step.active .text {
     font-weight: 400;
     color: #000
 }
 /** ** stepverde */
 .track .stepverde {
     -webkit-box-flex: 1;
     -ms-flex-positive: 1;
     flex-grow: 1;
     width: 25%;
     margin-top: -18px;
     text-align: center;
     position: relative
 }

 .track .stepverde.active:before {
     background: #28a745;
 }

 .track .stepverde::before {
     height: 7px;
     position: absolute;
     content: "";
     width: 100%;
     left: 0;
     top: 18px
 }

 .track .stepverde.active .icon {
     background:#28a745;
     color: #fff
 }

 .track .icon {
     display: inline-block;
     width: 40px;
     height: 40px;
     line-height: 40px;
     position: relative;
     border-radius: 100%;
     background: #ddd
 }

 .track .stepverde.active .text {
     font-weight: 400;
     color: #000
 }

 /** ** fin stepverde */

 /*///step azul//*/
 .track .stepazul {
     -webkit-box-flex: 1;
     -ms-flex-positive: 1;
     flex-grow: 1;
     width: 25%;
     margin-top: -18px;
     text-align: center;
     position: relative
 }

 .track .stepazul.active:before {
     background: #0053a1;
 }

 .track .stepazul::before {
     height: 7px;
     position: absolute;
     content: "";
     width: 100%;
     left: 0;
     top: 18px
 }

 .track .stepazul.active .icon {
     background: #0053a1;;
     color: #fff
 }

 .track .icon {
     display: inline-block;
     width: 40px;
     height: 40px;
     line-height: 40px;
     position: relative;
     border-radius: 100%;
     background: #ddd
 }

 .track .stepazul.active .text {
     font-weight: 400;
     color: #000
 }
 /*///fin step azul//*/

 .track .text {
     display: block;
     margin-top: 7px
 }

 .itemside {
     position: relative;
     display: -webkit-box;
     display: -ms-flexbox;
     display: flex;
     width: 100%
 }

 .itemside .aside {
     position: relative;
     -ms-flex-negative: 0;
     flex-shrink: 0
 }

 .img-sm {
     width: 80px;
     height: 80px;
     padding: 7px
 }

 ul.row,
 ul.row-sm {
     list-style: none;
     padding: 0
 }

 .itemside .info {
     padding-left: 15px;
     padding-right: 7px
 }

 .itemside .title {
     display: block;
     margin-bottom: 5px;
     color: #212529
 }


.vertical-timeline {
    width: 100%;
    position: relative;
    padding: 1.5rem 0 1rem
}

.vertical-timeline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 67px;
    height: 100%;
    width: 4px;
    background: #e9ecef;
    border-radius: .25rem
}

.vertical-timeline-element {
    position: relative;
    margin: 0 0 1rem
}

.vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
    visibility: visible;
    animation: cd-bounce-1 .8s
}

.vertical-timeline-element-icon {
    position: absolute;
    top: 0;
    left: 60px
}

.vertical-timeline-element-icon .badge-dot-xl {
    box-shadow: 0 0 0 5px #fff
}

.badge-dot-xl {
    width: 18px;
    height: 18px;
    position: relative
}

.badge:empty {
    display: none
}

.badge-dot-xl::before {
    content: '';
    width: 10px;
    height: 10px;
    border-radius: .25rem;
    position: absolute;
    left: 50%;
    top: 50%;
    margin: -5px 0 0 -5px;
    background: #fff
}

.vertical-timeline-element-content {
    position: relative;
    margin-left: 90px;
    font-size: .8rem
}

.vertical-timeline-element-content .timeline-title {
    font-size: .8rem;
    text-transform: uppercase;
    margin: 0 0 .5rem;
    padding: 2px 0 0;
    font-weight: bold
}

.vertical-timeline-element-content .vertical-timeline-element-date {
    display: block;
    position: absolute;
    left: -90px;
    top: 0;
    padding-right: 10px;
    text-align: right;
    color: #adb5bd;
    font-size: .7619rem;
    white-space: nowrap
}

.vertical-timeline-element-content:after {
    content: "";
    display: table;
    clear: both
}

h2 {
    display: block;
    font-size: 1.5em;
    margin-block-start: 0.83em;
    margin-block-end: 0.83em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
h3 {
    display: block;
    font-size: 1.17em;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
    </style>
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



  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home.php" class="brand-link">
      <img src="img/fiplexcirculo-012020.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin FAS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
		  			  <img src="imgusers/0.jpg" class="img-circle elevation-2" alt="User Image">
			            
        </div>
        <div class="info">
          <a href="home.php" class="d-block">Marco Moretti</a>
        </div>
      </div>

       <nav class="mt-2">
	      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
							 <!-- Sidebar Menu -->
    
     
          <!-- Add icons to the links using the .nav-icon class
               <br /> with font-awesome or any other icon font library -->
			
									<!-- autogenerado:0 BOTON MENU-->		
						 <li class="nav-item has-treeview">
							<a href="logdb.php" class="nav-link">
							  <i class="nav-icon fas fa-list-alt"></i>
							  <p>
								Activity Log							  
							  </p>
							</a>
						   
						  </li>
					<!-- autogenerado:0 BOTON MENU-->
										<!-- autogenerado:0 BOTON MENU-->		
						 <li class="nav-item has-treeview">
							<a href="ticketmanagerfiplex.php" class="nav-link">
							  <i class="nav-icon fas fa-user-cog"></i>
							  <p>
								Ticket Manager							  
							  </p>
							</a>
						   
						  </li>
					<!-- autogenerado:0 BOTON MENU-->
										<!-- autogenerado:0 BOTON MENU-->		
						 <li class="nav-item has-treeview">
							<a href="trackingorders.php" class="nav-link">
							  <i class="nav-icon fas fa-sitemap"></i>
							  <p>
								Tracking Orders							  
							  </p>
							</a>
						   
						  </li>
					<!-- autogenerado:0 BOTON MENU-->
										<!-- autogenerado:0 BOTON MENU-->		
						 <li class="nav-item has-treeview">
							<a href="changeuserfasdata.php" class="nav-link">
							  <i class="nav-icon fas fa-key"></i>
							  <p>
								Change Password							  
							  </p>
							</a>
						   
						  </li>
					<!-- autogenerado:0 BOTON MENU-->
										<!-- autogenerado:0 BOTON MENU-->		
						 <li class="nav-item has-treeview">
							<a href="crearpermisos.php" class="nav-link">
							  <i class="nav-icon fas fa-user-plus"></i>
							  <p>
								User Manager							  
							  </p>
							</a>
						   
						  </li>
					<!-- autogenerado:0 BOTON MENU-->
													<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
								<i class="nav-icon fas fa-magic"></i>
								<p>
								 Wizard								<i class="fas fa-angle-left right"></i>
								</p>
								</a>
								<ul class="nav nav-treeview">
															
								  <li class="nav-item">									
									<a href="wizardproductsspecs.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-magic"></i>
									  <p>
										Wizard Products Spec									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="wizardaddciu.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-magic"></i>
									  <p>
										Wizard Unit Creator									  
									  </p>
									</a>
								  </li>
								 
								
															</ul>
									</li>
																	<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
								<i class="nav-icon far fa-plus-square"></i>
								<p>
								 Production								<i class="fas fa-angle-left right"></i>
								</p>
								</a>
								<ul class="nav nav-treeview">
															
								  <li class="nav-item">									
									<a href="saleorders.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-box"></i>
									  <p>
										Sales Orders									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="listwordorder.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-cogs"></i>
									  <p>
										WO Generator									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="saleorders_rma.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-box-open"></i>
									  <p>
										RMA Sales Orders									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="stockwo.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-qrcode"></i>
									  <p>
										Stock WO									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="listpresales.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-shopping-cart"></i>
									  <p>
										SO Generator									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="acceptancefiberoptic.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-sliders-h"></i>
									  <p>
										SFP Acceptance									  
									  </p>
									</a>
								  </li>
								 
								
															</ul>
									</li>
																	<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
								<i class="nav-icon fas fa-toolbox"></i>
								<p>
								 Reports								<i class="fas fa-angle-left right"></i>
								</p>
								</a>
								<ul class="nav nav-treeview">
															
								  <li class="nav-item">									
									<a href="acceptance.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-check"></i>
									  <p>
										Acceptance									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="acceptanceftpmarco.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon 	far fa-file-alt"></i>
									  <p>
										SFP Report									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="reportlsgp.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fab fa-hotjar"></i>
									  <p>
										Report LSGP									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="reporte_so_ciu_customers.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon 	fas fa-chart-line"></i>
									  <p>
										Sales Report									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="liststationtimelinev1.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-stopwatch"></i>
									  <p>
										Activity Log TimeLine									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="stationactivity.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon far fa-clock"></i>
									  <p>
										Station Activity									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="qualityreportsurvery123.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-chart-line"></i>
									  <p>
										Quality survey report									  
									  </p>
									</a>
								  </li>
								 
								
															</ul>
									</li>
																	<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
								<i class="nav-icon fas fa-bug"></i>
								<p>
								 Developers								<i class="fas fa-angle-left right"></i>
								</p>
								</a>
								<ul class="nav nav-treeview">
															
								  <li class="nav-item">									
									<a href="abmproductsbranch.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-sitemap"></i>
									  <p>
										FAS Product Branch Type									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="listfrwtypeproducts.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-microchip"></i>
									  <p>
										Firmware List 									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="liststatiousermanager.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-database"></i>
									  <p>
										List Station Users									  
									  </p>
									</a>
								  </li>
								 
								
													
								  <li class="nav-item">									
									<a href="listastationfasclient.php" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon fas fa-database"></i>
									  <p>
										List Station FasClient									  
									  </p>
									</a>
								  </li>
								 
								
											</ul>
							</li>
											
			
		
		  	<!--<li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: block;">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li>-->
		  
		  
       
		  	      <li class="nav-item has-treeview">
					<a href="logout.php" class="nav-link">
						<i class="nav-icon fas fa-sign-out-alt"></i>
						<p>Logout </p>
					</a>
                  </li>
		  
		
      
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-F1RRLXMKS2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-F1RRLXMKS2');
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tracking Orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tracking Orders</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="" name="divscrolllog" id="divscrolllog" style="display.">
        <!-- Timelime example  -->
        <div class="row">
          <section class="col-lg-12 connectedSortable ui-sortable">
          <p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
             <div class="container-fluid">
             <br>
                <div class="form-group row" >
                
                            <label for="inputPassword" class="col-sm-1 col-form-label">Search:</label>
                            <div class="col-sm-12">	
                         				
                                <select class="js-example-basic-single col-sm-8"    id="txtlistcius" name="txtlistcius">

                                </select>	
                                
                         

                            </div>
                       
                            
                
                </div>     
                
                <p algin="right" class="col-4">
                 <button class="btn btn-primary btn-lg btn-block btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                 Custom Search
                </button>

                </p>
<div class="col-4 collapse" id="collapseExample">
  <div class="card card-body">
   <b>Step Activity </b> 
   <br>
   Steps:
      <select class="form-control form-control-sm" name="filterstep" id="filterstep">
         <option value="">All</option>
          <option value="finalcheckso">Final Check</option>
          <option value="finalinspection">Final Inspection</option>
      </select>
   <br>
  <b>Date Range:</b>  <input id="daterangem" name="daterangem">
  <hr>
  <b>Picking:</b> 
  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">CIU:</label>
                    <div class="col-sm-10">
                           <input type="text" id="txtsearchtxtciu" name="txtsearchtxtciu" class="form-control form-control-sm">
                    </div>
                    <label for="inputEmail3" class="col-sm-2 col-form-label">SN:</label>
                    <div class="col-sm-10">
                    <input type="text" id="txtsearchtxtsn" name="txtsearchtxtsn" class="form-control form-control-sm">
                    </div>
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Rev:</label>
                    <div class="col-sm-10">
                     <input type="text" id="txtsearchtxtrev" name="txtsearchtxtrev" class="form-control form-control-sm"> 
                    </div>

    </div>
    <div class="card-footer">
                 
                  <button type="submit" class="btn btn-block btn-outline-primary btn-xs float-right">Search</button>
                </div>
 </div>
</div>

           

       <hr>
   
                                                 
            <div class="card " id="artSO" name="artSO">
            
         
                  <div class="card-header">
                       <h3 class="card-title">  <h3 class="card-title">:: Tracking ::  </h3> 
					

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                 
                    </div>
                  </div>
                  <div class="card-body">  
                    
                  <div>
                  
                  </div>

                  <div class="track1">
                                    <div class="track">
                                               
                                            <div class="stepazul   active"> 
                                          
                                            <a href="#" onclick="show_info('orderinfo','21114307FU','1632','Order Detail :: WO:20210302WO - SN: 21114307FU',0,0)">
                                          
                                            <span class="icon"> <i class="fa fa-check"></i> </span>
                                                <span class="text text-left">
                                              
                                                <b>  Wo Info<br>   
                                                WO: [20210302WO]<br>CIU: [BTTY-100]</b> 
                                                <br><b> SN Generated: [21114307FU]</b><br><span class='badge bg-success'>FasClient Processed</span>                                              </a>
                                              <span class='text text-left'>
                                            <a href="#"  onclick="Call_printlabel('BTTY-100', '21114307FU' ,'1632')">&nbsp; <i class="fas fa-print"></i> - Print Label
                                            <br><br>
                                            </a>
                                          </span>
                                            </span> 
                                        
                                            </div>
                                                                                                                                                                <div class="step  ">
                                                                                                                  
                                                          <a href="#" onclick="show_info('picking','21114307FU','20210302WO','BTTY-100','Quality Calibration Precheck',0)">
                                                          <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                                          <span class="text">  <b>Picking  <br>SN [21114307FU] <br></b></span>
                                                        
                                                                                
                                                          </div>             
                                                          </a>     
                                                                                                                                                        <div class="stepverde  active">
                                              
                                              <a href="#" onclick="show_info('Precheck','21114307FU','20210302WO','BTTY-100','Quality Calibration Precheck',0)">
                                              <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                              <span class="text">  <b>Quality Precheck   <br>SN [21114307FU] <br></b></span>
                                                  <span class='badge bg-success'>Passed</span><br>
                                                                  
                                              </div>             
                                              </a>     
                                                                                                                                              <div class="stepverde  active">
                                                                                                
                                              <a href="#" onclick="show_info('Precheckultest','21114307FU','20210302WO','BTTY-100','Quality Calibration Precheck',0)">
                                                <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                              <span class="text">  <b>UL Test   <br>SN [21114307FU] <br></b></span>
                                                  <span class='badge bg-success'>Passed</span><br>                                          
                                                                    
                                                </div>             
                                              </a>     
                                              
                                            
                                                
                                                                                                      <a href="#" onclick="show_info('orderinfo','21114307FU','1622','Order Detail :: SO:20212143SO - SN: 21114307FU',0,0)">
                                                      <div class="stepazul active "><span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"><b>SO:20212143SO <br>CIU : GWBDA-BTTY-100100<br>SN Assign :  21114307FU</b></span>
                                                      </a>  
                                                      <a href="#" onclick="Call_printlabel('GWBDA-BTTY-100100', '21114307FU' ,'1622')">&nbsp; <i class="fas fa-print"></i> - Print Label</a>
                                                      </div>
             
                                           <div class="step active ">  <span class="icon">  <i class="fa fa-box"></i> </span> <span class="text">BBU FAS Calibration <br></span>
                                                         <a href="calibbburepotm.php?unitsn=21114300FU&amp;iduldl=0&amp;idmb=0" target="_blank">  <i class='fas fa-file-pdf'></i> - View Report</a>

                                          </div>
                                                                                                                                                             <div class="stepverde  active">
                                              
                                              <a href="#" onclick="show_info('PrecheckBBUscs','21114307FU','20210302WO','BTTY-100','Quality Calibration Precheck',0)">
                                              <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                              <span class="text">  <b>BBU Integration Checklist   <br>SN [21114307FU] <br></b></span>
                                                  <span class='badge bg-success'>Passed</span><br>
                                                                  
                                              </div>             
                                              </a>     
                                                                                                                                                <div class="stepverde  active">
                                                                                                  
                                               <a href="#" onclick="show_info('Precheckfinalcheck','21114307FU','20210302WO','BTTY-100','Quality Calibration Precheck',0)">
                                                 <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                               <span class="text">  <b>Final Inspection   <br>SN [21114307FU] <br></b></span>
                                                   <span class='badge bg-success'>Passed</span><br>                                           
                                                                     
                                                 </div>             
                                               </a>     
                                               </div>   
                            <br><br>                </div>
                <hr>
                <br><br><br><br>
                       

            </div>
        </div>
  



        </div>
				</div>

        <hr>
      

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


<script src="plugins/moment/moment.min.js"></script>



<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>




<script src="js/eModal.min.js" type="text/javascript" >
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>


<script src="jsdaterange/jquery.min183.js"></script>


  <link href="jsdaterange/jquery-ui.min.css" rel="stylesheet">  
    <script src="jsdaterange/jquery-ui.js"></script>
    <script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>    
 
    <link href="jsdaterange/jquery.comiseo.daterangepicker.css" rel="stylesheet">
  <script src="jsdaterange/jquery.comiseo.daterangepicker.js"></script>

  <script src="js/select2.min.js"></script>






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
			console.log( "ready!" );
			$('#msjwaitline ').hide();
			$('#divscrolllog').show(); 
			
			
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

                  $('.js-example-basic-single').select2();		

                  $(function() { $("#daterangem").daterangepicker({ dateFormat: "(yy-mm-dd)"}); });
                  	 // AutoComplete de CUIS version TOP

     

function formatRepo (repo) {
	
    if (repo.loading) {
      return repo.text;
    }
  
    var $container = $(
      "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'><img src='img/imgciu.jpg' /></div>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'></div>" +
          "<div class='select2-result-repository__description'></div>" +      
        "</div>" +
      "</div>"
    );
  
    $container.find(".select2-result-repository__title").text(repo.text);
    $container.find(".select2-result-repository__description").html(repo.description);
    $container.find(".select2-result-repository__avatar").html('<h2><b>'+repo.img+'</b></h2>');
    $container.find(".select2-result-repository__forks").append("101" + " Forks");
    $container.find(".select2-result-repository__stargazers").append("102" + " Stars");
    $container.find(".select2-result-repository__watchers").append("103" + " Watchers");
  //  console.log(repo.text);
    return $container;
  }
  
  function formatRepoSelection (repo) {
      // console.log('1' + repo.text);
    return repo.full_name || repo.text;
  }
  

     $('#txtlistcius').select2({
 ajax: {
    url: "ajax_list_searchalltracking.php",
    dataType: 'json',
    delay: 2,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data) {
      // Transforms the top-level key of the response object from 'items' to 'results'
      return {
        results: data.items
      };    
    },
    cache: false
  },
  placeholder: 'Search WO / SO / SN',
  minimumInputLength: 1 ,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

// fin// AutoComplete de CUIS version TOP	
			
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 30000,
                dialogWait: 100,
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


   $("#txtlistcius").change(function(){
				var datosmm = $("#txtlistcius").val().split("#");	
            console.log( $("#txtlistcius").val());
            window.location = 'trackingorders.php?isdo='+datosmm[0]+'&typeisdo='+datosmm[1]+'&encont='+datosmm[2];
   });


   function popuplogdb(idrunifno)
   {
    eModal.iframe('logdbonlydet.php?idab='+idrunifno,'Log Activity');
   }

   function show_info(desdedonde,snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning)
   {
     ///aca tenia un error
 ///   $("#artSO").CardWidget('collapse');
  //    $("#artSO").Widget("collapse"); 
 //     $("#artSO").collapse("hide"); 
    var armando_tabla_info='';
    $('#titudetalle').html('Searching');
    $('#divdetalles').html("");
    toastr["info"]("SN: "+snparam, "Searching")

    
       ///////////////////////////////////////////////////////////////////////////////////////
       ///show_info('calibrationyburchk','21076433FU','623','Calibration :: SN: 21076433FU','10954067627')
       if (desdedonde =='calibrationyburchk')
    {
      eModal.iframe('https://webfas.fiplex.com/autotestboxtimeline.php?hidmenu=Y&idr='+idruninfoparam,'Calibration & Burnin Check ');
     
    }
    ////////////////////////////////////////////////////////////////////////////////////////

     ///////////////////////////////////////////////////////////////////////////////////////
     if (desdedonde =='PrecheckBBUANN')
    {
      eModal.iframe('calibrationqualitychecklisallsurvery.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar,'BBU ANN Acceptance Test');
     
    }
    ////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde =='picking')
    {
      eModal.iframe('wopicking.php?elso='+soparam+'&elsn='+snparam+'&elciu='+sotextoamostrar,'Picking SN:' + snparam);
    }
    ////////////////////////////////////////////////////////////////////////////////////////
     if (desdedonde =='orderinfo')
     {

      eModal.iframe('show_tracking_orderinfo.php?soparam='+soparam+'&snparam='+snparam,sotextoamostrar);
    
        
        
     }
     ////////////////////////////////////////////////////////////////////////////////////////
     if (desdedonde =='acceptance')
     {
      eModal.iframe('acceptflex.php?idsndib='+snparam+'&logo=N',sotextoamostrar);
    
         
     }
//////////////////////////////////////////////////////////////////////////////////////////////////
if (desdedonde =='finalchk')
     {
      eModal.iframe('finalchkallband.php?dnd=WO&idsndib='+snparam+'&idmb=9&iduldl=9&idruninfo='+idruninfoparam,sotextoamostrar);
    
     
     }
     ////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
if (desdedonde =='calibration')
     {
      eModal.iframe('equalizeriir.php?idsndib='+snparam+'&idmb=0&iduldl=0&idruninfo='+idruninfoparam,sotextoamostrar);
     
       
     }
     ////////////////////////////////////////////////////////////////////////////////////////
     
     //////////////////////////////////////////////////////////////////////////////////////////////////
if (desdedonde =='finalchkso')
     {

      eModal.iframe('finalchkallband.php?dnd=SO&idsndib='+snparam+'&idmb=9&iduldl=9&idruninfo='+idruninfoparam+'&idrunaferbur='+idparamafterburning,sotextoamostrar);
     
     }

     if (desdedonde =='finalchksotemp')
     {

      eModal.iframe('finalchkallband.php?dnd=SO&tempso=OO&idsndib='+snparam+'&idmb=9&iduldl=9&idruninfo='+idparamafterburning+'&idrunaferbur='+idparamafterburning,sotextoamostrar);
     
     }
     ////////////////////////////////////////////////////////////////////////////////////////
     if (desdedonde =='Precheck')
     {

      eModal.iframe('calibrationqualitychecklist.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar,'Quality precheck');
     
     }
      
     if (desdedonde =='PrecheckBBUscs')
     {

      eModal.iframe('calibrationqualitychecklistbbuscs.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar,'BBU Integration Checklist');
     
     }

      ////////////////////////////////////////////////////////////////////////////////////////
      if (desdedonde =='Precheckultest')
     {

      eModal.iframe('electricstrengthchecklist.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar,'Quality UlTest');
     
     }
     
     if (desdedonde =='Precheckfinalcheck')
     {

      eModal.iframe('surveyfinalcheck.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar,'Final Inspection');
     
     }

      
           
  //   $("#artSO").CardWidget('collapse');

   }

function Assign_sn(idorders_a_setear, elsoamostrar)
{

eModal.iframe('show_tracking_assignsn.php?idso='+idorders_a_setear+'&elnomso='+elsoamostrar,'Assign SN to SO:' +elsoamostrar);
     
///show_tracking_assignsn.php

}

   function Call_printlabel(vpara_ciu,vparam_sn, vparamidorders)
	{
			var ipservidorapache= 'webfas.fiplex.com';	
		eModal.iframe('https://'+ipservidorapache+'/labelprintermultisn.php?vciu='+vpara_ciu+'&vsn='+vparam_sn+'&vidord='+vparamidorders,'Label printing');
		$('.embed-responsive-item').height(380);
	//	console.log('si');
		

				setTimeout(function() {
								$('.embed-responsive-item').height(620);
							},300);
							
							
	}	

  function savechristian(paramsndewo, numeroso)
  {
    alert('aaaaa');
  }
   
</script>

</html>
