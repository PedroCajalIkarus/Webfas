<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 

	$query_lista = list_digmodulecalif_finalcheck($_REQUEST['idsunit'] ,$_REQUEST['iddib_sn_modulo']);
    $return_arr = array();
 		
  	//echo $query_lista;				
	$data = $connect->query($query_lista)->fetchAll();						
	$letrasbuscadas = array("/", ".", ",", "-", );
	$vidfreqcant =0;
	
	$v_iteracion = 1;
	$vfreq = 0;
	?>
	
	<table id='myTablecalibscripttime' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped '>
		<?php
	
	
		foreach ($data as $row) 
		{
			$v_data_eq = explode("#",$row['timefinalchecksteps']);
								
			$v_data_eq_ul = explode("|",$v_data_eq[0]);			
			$v_data_eq_ud = explode("|",$v_data_eq[1]);	
			
		
				
			?>
			<tr data-rowa='0'>	
								<td data-rowa='1' data-cola='0' class="table-info"><b>PARAMETER</b></td>
								<?php
								$count_rows=0;
								foreach($data as $i =>$keyaa) 		
								{
									$count_rows=$count_rows+1;
									
									$tempabc=explode("#",$keyaa['timefinalchecksteps']);		
									${"ite".$count_rows}  = $tempabc;									
								
																
								
									
									?>
									<td data-rowa='1' data-cola='0' class="table-info"><b>Iteration <?php echo $count_rows; ?><BR></b><b> UL</b></td>
									<td data-rowa='1' data-cola='0' class="table-info"><b>Iteration <?php echo $count_rows; ?><BR></b><B> DL</B></td>
								   <?php
								  		
								}
								?>
								
								
							</tr>
		<?php
		    foreach($v_data_eq_ul as $i =>$key) 
			{
			//	$i >0;	
			$keyarray = explode(" ",$key );	
			//echo "hola key.".$keyarray[0]."<br>".($keyarray[0]=="null" ? "NODATA" : $keyarray[0])."<br>";
				if ($keyarray[0] !="null")
				{
				
				?>
				
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>A_AGCTh</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										// $v_data_eq_ud = explode("|",$temul[1]);
											
										//echo var_dump( $v_data_eq_ul )."---".$i_itera."<br>";
										
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[0]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[0]; ?></td>
									<?php
									
								}
								
							?>
							
							</tr>
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>B_BandGain </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										// $v_data_eq_ud = explode("|",$temul[1]);
											
										//echo var_dump( $v_data_eq_ul )."---".$i_itera."<br>";
										
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[1]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[1]; ?></td>
									<?php
								
								}
								
							?>
							
							</tr>	
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>C_BandMaxPwr </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										// $v_data_eq_ud = explode("|",$temul[1]);
											
										//echo var_dump( $v_data_eq_ul )."---".$i_itera."<br>";
										
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[2]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[2]; ?></td>
									<?php
								
								}
								
							?>
							
							</tr>	
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>D_NoiseFigurek</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										// $v_data_eq_ud = explode("|",$temul[1]);
											
										//echo var_dump( $v_data_eq_ul )."---".$i_itera."<br>";
										
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[3]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[3]; ?></td>
									<?php
								
								}
								
							?>
							
							</tr>		
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>F_OPI3 </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										// $v_data_eq_ud = explode("|",$temul[1]);
											
										//echo var_dump( $v_data_eq_ul )."---".$i_itera."<br>";
										
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[4]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[4]; ?></td>
									<?php
								
								}
								
							?>
							
							</tr>
<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>G_SquelchCheck </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										// $v_data_eq_ud = explode("|",$temul[1]);
											
										//echo var_dump( $v_data_eq_ul )."---".$i_itera."<br>";
										
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[5]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[5]; ?></td>
									<?php
								
								}
								
							?>
							
							</tr>	
<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>I_Spurious </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										// $v_data_eq_ud = explode("|",$temul[1]);
											
										//echo var_dump( $v_data_eq_ul )."---".$i_itera."<br>";
										
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[6]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[6]; ?></td>
									<?php
								
								}
								
							?>
							
							</tr>								
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>Total Time </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										// $v_data_eq_ud = explode("|",$temul[1]);
											
										//echo var_dump( $v_data_eq_ul )."---".$i_itera."<br>";
										
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'> </td>
									<td data-rowa='1' data-cola='0'> </td>
									<?php
								
								}
								
							?>
							
							</tr>									
							<?php
				}	
				break;
			}
			
			
			
	
			break;
		}
		
		?>					
</table>