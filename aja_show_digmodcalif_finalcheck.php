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
	
	<table id='myTablecalibfinalcheck' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped '>
		<?php
	
	
		foreach ($data as $row) 
		{
			$v_data_eq = explode("#",$row['a_agcinthr']);
			$v_b_gain = explode("#",$row['b_gain']);
			$v_cpwr = explode("#",$row['c_maxpwr']);
			
			$v_dnoisefig = explode("#",$row['d_nf']);
			$v_emaxinpfreq = explode("#",$row['e_maxinpwr']);
			$v_foip3 = explode("#",$row['f_oip3']);
			
			$v_gsqsetupfreq = explode("#",$row['g_sq']);
			
						
			$v_data_eq_ul = explode("|",$v_data_eq[0]);			
			$v_data_eq_ud = explode("|",$v_data_eq[1]);	
			
			$v_data_Bgain_ul = explode("|",$v_b_gain[0]);			
			$v_data_Bgain_ud = explode("|",$v_b_gain[1]);	
			
			$v_data_Cpwr_ul = explode("|",$v_cpwr[0]);			
			$v_data_Cpwrn_ud = explode("|",$v_cpwr[1]);	
			
			$v_data_dnoisefi_ul = explode("|",$v_dnoisefig[0]);			
			$v_data_dnoisefi_ud = explode("|",$v_dnoisefig[1]);	
			
			$v_data_emaxinpfreq_ul = explode("|",$v_emaxinpfreq[0]);			
			$v_data_emaxinpfreq_ud = explode("|",$v_emaxinpfreq[1]);	
			
			$v_data_foip3_ul = explode("|",$v_foip3[0]);			
			$v_data_foip3_ud = explode("|",$v_foip3[1]);	
			
			$v_data_gsqsetupfreq = explode("|",$v_gsqsetupfreq[0]);			
			$v_data_gsqsetupfreq = explode("|",$v_gsqsetupfreq[1]);	
			
				
			?>
			<tr data-rowa='0'>	
								<td data-rowa='1' data-cola='0' class="table-info"><b>PARAMETER</b></td>
								<?php
								$count_rows=0;
								foreach($data as $i =>$keyaa) 		
								{
									$count_rows=$count_rows+1;
									
									$tempabc=explode("#",$keyaa[0]);		
									${"ite".$count_rows}  = $tempabc;									
								
									$temp_bgain=explode("#",$keyaa[1]);		
									${"ite_bgain".$count_rows}  = $temp_bgain;	

									$temp_cpwr=explode("#",$keyaa[2]);		
									${"ite_cpwr".$count_rows}  = $temp_cpwr;

									$temp_dnoisefi=explode("#",$keyaa[3]);		
									${"ite_dnoisefi".$count_rows}  = $temp_dnoisefi;

									$temp_e_maxinpwr=explode("#",$keyaa[4]);		
									${"ite_e_maxinpwr".$count_rows}  = $temp_e_maxinpwr;

									$temp_f_oip3=explode("#",$keyaa[5]);		
									${"ite_f_oip3".$count_rows}  = $temp_f_oip3;	

									$temp_gsqsetupfreq=explode("#",$keyaa[6]);		
									${"ite_gsqsetupfreq".$count_rows}  = $temp_gsqsetupfreq;										
								
									
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>A_AGC Input Threshold freq</b><?php echo $i; ?> </td>				
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>A_AGC Input Threshold Meas </b> </td>				
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>A_AGC Input Threshold Reference </b> </td>				
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>A_AGC Input Threshold Tolerance </b> </td>				
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
	<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>A_AGC Input Threshold Temperature </b> </td>				
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
	<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>A_AGC Input Threshold pass </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										// $v_data_eq_ud = explode("|",$temul[1]);
											
										//echo var_dump( $v_data_eq_ul )."---".$i_itera."<br>";
										
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo "";?></td>
									<td data-rowa='1' data-cola='0'><?php echo ""; ?></td>
									<?php
								
								}
								
							?>
							
							</tr>									
							<?php
				}	
				break;
			}
			
			//// B GAIN
		    foreach($v_data_Bgain_ul as $i =>$key) 
			{
			//	$i >0;	
			$keyarray = explode(" ",$key );	
		//	echo "hola key.".$keyarray[0]."<br>".$key."<br>";
				if ($keyarray[0] !="null")
				{
				
				?>
							<tr data-rowa='1'>
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
							</tr>
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>B_Band Gain freq</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_bgain".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
						
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>B_Band Gain Meas  </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_bgain".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>B_Band Gain Reference </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_bgain".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>B_Band Gain Tolerance </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_bgain".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>B_Band Gain Temperature </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_bgain".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>B_Band Gain pass </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_bgain".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
																			 
									?>
									<td data-rowa='1' data-cola='0'><?php echo "";?></td>
									<td data-rowa='1' data-cola='0'><?php echo ""; ?></td>
									<?php
								
								}
								
							?>
							
							</tr>									
							<?php
				}	
				
			}
			
			//fin B Gain
			//// C MaxPWR
		    foreach($v_data_Cpwr_ul as $i =>$key) 
			{
			//	$i >0;	
			$keyarray = explode(" ",$key );	
		//	echo "hola key.".$keyarray[0]."<br>".$key."<br>";
				if ($keyarray[0] !="null")
				{
				
				?>
							<tr data-rowa='1'>
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
							</tr>
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>C_Max PWR freq</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_cpwr".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
						
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>C_Max PWR Meas value  </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_cpwr".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>C_Max PWR Reference </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_cpwr".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>C_Max PWR Tolerance </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_cpwr".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>C_Max PWR Temperature </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_cpwr".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>C_Max PWR pass </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_cpwr".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
																			 
									?>
									<td data-rowa='1' data-cola='0'><?php echo "";?></td>
									<td data-rowa='1' data-cola='0'><?php echo ""; ?></td>
									<?php
								
								}
								
							?>
							
							</tr>									
							<?php
				}	
				
			}
			
			//fin C MaxPWR
				//// Inicio D NoiseFig
		    foreach($v_data_dnoisefi_ul as $i =>$key) 
			{
			//	$i >0;	
			$keyarray = explode(" ",$key );	
		//	echo "hola key.".$keyarray[0]."<br>".$key."<br>";
				if ($keyarray[0] !="null")
				{
				
				?>
							<tr data-rowa='1'>
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
							</tr>
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>D_Noise Figure freq</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_dnoisefi".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
						
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>D_Noise Figure Meas value  </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_dnoisefi".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>D_Noise Figure Reference</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_dnoisefi".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>D_Noise Figure Tolerance </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_dnoisefi".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>D_Noise Figure pass </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_dnoisefi".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
														
							<?php
				}	
				
			}
			
			//fin D NoiseFig
					//// Inicio E Max Input  Pwr
		    foreach($v_data_emaxinpfreq_ul as $i =>$key) 
			{
			//	$i >0;	
			$keyarray = explode(" ",$key );	
		//	echo "hola key.".$keyarray[0]."<br>".$key."<br>";
				if ($keyarray[0] !="null")
				{
				
				?>
							<tr data-rowa='1'>
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
							</tr>
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>E_Max Input PWR freq</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_e_maxinpwr".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
						
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>E_Max Input PWR Meas value  </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_e_maxinpwr".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>E_Max Input PWR Reference</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_e_maxinpwr".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>E_Max Input PWR Tolerance </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_e_maxinpwr".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>E_Max Input PWR pass </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_e_maxinpwr".$i_itera};
																					 
									?>
									<td data-rowa='1' data-cola='0'></td>
									<td data-rowa='1' data-cola='0'></td>
									<?php
								
								}
								
							?>
							
							</tr>		
														
							<?php
				}	
				
			}
			
			//fin  E Max Input  Pwr
			//// Inicio F OIP3 Freq
		    foreach($v_data_foip3_ul as $i =>$key) 
			{
			//	$i >0;	
			$keyarray = explode(" ",$key );	
		//	echo "hola key.".$keyarray[0]."<br>".$key."<br>";
				if ($keyarray[0] !="null")
				{
				
				?>
							<tr data-rowa='1'>
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
							</tr>
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>F_OIP3 freq</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_f_oip3".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
						
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>F_OIP3 Meas value </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_f_oip3".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>F_OIP3 Reference</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_f_oip3".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>F_OIP3 Tolerance </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_f_oip3".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>F_OIP3 Temperature </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_f_oip3".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
														
							<?php
				}	
				
			}
			
			//fin  F_OIP3
			//// Inicio G_SQ Setup freq
		    foreach($v_data_gsqsetupfreq as $i =>$key) 
			{
			//	$i >0;	
			$keyarray = explode(" ",$key );	
		//	echo "hola key.".$keyarray[0]."<br>".$key."<br>";
				if ($keyarray[0] !="null")
				{
				
				?>
							<tr data-rowa='1'>
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
								<td data-rowa='1' data-cola='0'><BR>  </td>				
							</tr>
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>G_SQ Setup freq</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_gsqsetupfreq".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
						
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>G_SQ Setup Meas value </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_gsqsetupfreq".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>G_SQ Setup Reference</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_gsqsetupfreq".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>G_SQ Setup Tolerance </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_gsqsetupfreq".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
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
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>G_SQ Setup Pass </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite_gsqsetupfreq".$i_itera};
										
									 										 
									?>
									<td data-rowa='1' data-cola='0'></td>
									<td data-rowa='1' data-cola='0'></td>
									<?php
								
								}
								
							?>
							
							</tr>		
														
							<?php
				}	
				
			}
			
			//fin  F_OIP3
			?>
			
				<tr data-rowa='1'><td data-rowa='1' data-cola='0'><br><b>H_Manual att range pass </b> </td>										
									<td data-rowa='1' data-cola='0'></td>
									<td data-rowa='1' data-cola='0'></td>
				</tr>	
<tr data-rowa='1'><td data-rowa='1' data-cola='0'><br><b>I_Spurious pass </b> </td>										
									<td data-rowa='1' data-cola='0'></td>
									<td data-rowa='1' data-cola='0'></td>
				</tr>	
<tr data-rowa='1'><td data-rowa='1' data-cola='0'><br><b>J_HW Alarm pass pass </b> </td>										
									<td data-rowa='1' data-cola='0'></td>
									<td data-rowa='1' data-cola='0'></td>
				</tr>	
<tr data-rowa='1'><td data-rowa='1' data-cola='0'><br><b>K_LED Panel pass </b> </td>										
									<td data-rowa='1' data-cola='0'></td>
									<td data-rowa='1' data-cola='0'></td>
				</tr>	
				
			<?php
			break;
		}
		
		?>					
</table>