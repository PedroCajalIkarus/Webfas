<?php 	  
 include("db_conect.php"); 
   /// echo "menuuuuuuuuuuuuuuuuuuuuuu";
  // echo "************************************************->".$_SESSION["a"]; 
  
  if($_SESSION["a"]=="")
	{
			session_unset();
            session_destroy();
            header("Location: https://".$ipservidorapache."/index.php");
			// echo "************************************************->".$_SESSION["a"]; 
        
	}
	
?>

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
		  <?php if ($_SESSION["f"]=="true")
		  {
			?>  <img src="imgusers/user<?php echo $_SESSION["a"]; ?>.jpg" class="img-circle elevation-2" alt="User Image"> <?php
		  }
		  else
		  {
			  ?>
			  <img src="imgusers/0.jpg" class="img-circle elevation-2" alt="User Image">
			  <?php			  
		  }
			?>
          
        </div>
        <div class="info">
          <a href="home.php" class="d-block"><?php echo $_SESSION["c"];?></a>
        </div>
      </div>

       <nav class="mt-2">
	      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<?php	
			$temp_namegroup	="";
			$eluserlogin = $_SESSION["a"];
			$query_lista="select distinct menu.* from menu inner join business_user_menu on business_user_menu.idmenu = menu.idmenu  where  iduserfas=$eluserlogin and   menu.active = 'Y' and barmenu = 'Y' order by ordershow , barmenugroup, namemenu  ";		
			echo "444444444444444444444444444444444".$query_lista; 
			$resultado = $connect->query($query_lista);		
			
				$cantregistros = $resultado->rowCount();
			if ($cantregistros>=1)
			{
				?>
				 <!-- Sidebar Menu -->
    
     
          <!-- Add icons to the links using the .nav-icon class
               <br /> with font-awesome or any other icon font library -->
			
				<?php
				$submenu =0;
					
				foreach ($resultado as $row) {
					$stylecolor = $row['menustyle'];
					$iconomenu = $row['iconmenu'];
					$namemenu = $row['namemenu'];
					$namegroup = $row['barmenugroup'];
					$linkmenu = $row['linkaccess'];
					$barmenugroup = $row['barmenugroup'];
						$iconmenuhead = $row['iconmenuhead'];
					
					if ($barmenugroup =="")
					{
					?>
					<!-- autogenerado:0 BOTON MENU-->		
						 <li class="nav-item has-treeview">
							<a href="<?php echo $linkmenu;?>" class="nav-link">
							  <i class="nav-icon <?php echo $iconomenu;?>"></i>
							  <p>
								<?php echo $namemenu;?>
							  
							  </p>
							</a>
						   
						  </li>
					<!-- autogenerado:0 BOTON MENU-->
					<?php
					}
					else
					{
						if ($namegroup != $temp_namegroup)
						{
							if ($temp_namegroup != "" || $namegroup != $temp_namegroup)
								{
									?>
									</ul>
								</li>
									<?php
								}
								$temp_namegroup = $namegroup;
								?>
								<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
								<i class="nav-icon <?php echo $iconmenuhead;?>"></i>
								<p>
								 <?php echo $barmenugroup ;?>
								<i class="fas fa-angle-left right"></i>
								</p>
								</a>
								<ul class="nav nav-treeview">
								<?php
						}
						$submenu =1;
						?>
							
								  <li class="nav-item">									
									<a href="<?php echo $linkmenu;?>" class="nav-link">
									 &nbsp;&nbsp; <i class="nav-icon <?php echo $iconomenu;?>"></i>
									  <p>
										<?php echo $namemenu;?>
									  
									  </p>
									</a>
								  </li>
								 
								
						<?php
					}
				}
				
				if (	$submenu ==1)
				{
					?>
					</ul>
							</li>
					<?php
				}
			?>
						
			
		
		  <?php 
		  }
		  
		  /// Prueba para Armar Grupos.
		  $query_lista="select distinct menu.* from menu inner join business_user_menu on business_user_menu.idmenu = menu.idmenu  where  iduserfas=$eluserlogin and   menu.active = 'Y' and barmenu = 'Y' and barmenugroup <> ''  order by ordershow , barmenugroup, namemenu  ";		
			
			$resultado = $connect->query($query_lista);	
			foreach ($resultado as $row) {
			}
		  ?>
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