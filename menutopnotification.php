  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="http://srv-pgsql.fiplex.com/webfas/home.php" class="nav-link">Home</a>
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
		  <?php 
		  
		  	   $sql = $connect->prepare("select count(idnotice) as cc from notices_users where iduserfas = :iduserfas  and idbusiness = :idbusiness and dateview is null ");
					   $vvidpo = $vmaxid;
					$sql->bindParam(':iduserfas', $_SESSION["a"]);
					$sql->bindParam(':idbusiness', $_SESSION["i"]);
					$sql->execute();
					$resultado = $sql->fetchAll();
					$cant_notices=0;
					foreach ($resultado as $row) 
					{
					///	echo "MAX ID REV ".$row['maxidrev']."---------------".$vvidpo;
					$cant_notices=$row['cc']	;
					}
		  
		  ?>
          <span class="badge badge-warning navbar-badge"><?php echo $cant_notices;?></span>
        </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?php echo $cant_notices;?> Notifications</span>
          <div class="dropdown-divider"></div>
		  <?php 
		  
		   $sql = $connect->prepare("select * from notices_users where iduserfas = :iduserfas  and idbusiness = :idbusiness and dateview is null ");
					   $vvidpo = $vmaxid;
					$sql->bindParam(':iduserfas', $_SESSION["a"]);
					$sql->bindParam(':idbusiness', $_SESSION["i"]);
					$sql->execute();
					$resultado = $sql->fetchAll();
					$cant_notices=0;
					foreach ($resultado as $row) 
					{
					///	echo "MAX ID REV ".$row['maxidrev']."---------------".$vvidpo;
					?>
						<a href="#" class="dropdown-item dropdown-header"><i class="fas fa-shopping-cart mr-2"></i> <?php echo $row['messagenotice'];?>&nbsp;&nbsp		
					<?php
					}
		  
		  ?>
          
		  
          </a>
        
      </li>
    	  
      <!-- Notifications Dropdown Menu -->
    </ul>
  </nav>