<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 

	$query_lista = list_digmodulecalif_eq($_REQUEST['idsunit'] ,$_REQUEST['iddib_sn_modulo']);
    $return_arr = array();
 		
  	//echo $query_lista;				
	$data = $connect->query($query_lista)->fetchAll();						
	$letrasbuscadas = array("/", ".", ",", "-", );
	$vidfreqcant =0;
	
	$v_iteracion = 1;
	$vfreq = 0;
	?>
	
	<table id='myTablecalibeq' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped '>
						
							
														
						
	<?php
	
	
		foreach ($data as $row) 
		{
			$v_data_eq = explode("#",$row['eqbda']);
			$v_data_eqripple = explode("#",$row['eqripple']);
						
			$v_data_eq_ul = explode("|",$v_data_eq[0]);			
			$v_data_eq_ud = explode("|",$v_data_eq[1]);	
			
			$v_data_eqripple_ul = explode("|",$v_data_eqripple[0]);
			$v_data_eqripple_dl = explode("|",$v_data_eqripple[1]);
			
			
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
									
									$tempabcd=explode("#",$keyaa[1]);
																	
									${"iteriple".$count_rows}  = $tempabcd
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
		
				
				?>
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>Freq <?php echo $vfreq; ?> </b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
									//	echo var_dump( $temul[0] )."---".$i_itera."<br>";
										
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[0]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[0]; ?></td>
									<?php
								}
								
							?>
							
							</tr>			
							
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>Level In [<?php echo $i; ?>]</b></td>
							<?php
						
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
								
									    $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[1]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[1]; ?></td>
									<?php
								}
									
							?>
							
							</tr>
							
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>Level Out [<?php echo $i; ?>]</b></td>
							<?php
							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
								
									   $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[2]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[2]; ?></td>
									<?php
								}
								
								
							?>
							
							</tr>
							
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>CorrectRx [<?php echo $i; ?>]</b></td>
							<?php
							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
								
									   $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[3]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[3]; ?></td>
									<?php
								}
								
								
							?>
							</tr>
							
							<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>CorrectTx [<?php echo $i; ?>]</b></td>
							<?php
							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
								
									   $temul = ${"ite".$i_itera};
										
									     $v_data_eq_ul = explode("|",$temul[0]);											
										 $v_data_eq_ud = explode("|",$temul[1]);
											
											$vdatkey = explode(" ",$v_data_eq_ul[$i]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud[$i]);											 
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[4]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[4]; ?></td>
									<?php
								}
								
								
							?>
							</tr>
							
									
							
							
							<tr data-rowa='1'>
							<td data-rowa='1' data-cola='0'> <br></td>
				<?php
								foreach($data as $i =>$keyaa) 		
								{
									
									?>
									<td data-rowa='1' data-cola='0'><br> </td>
									<td data-rowa='1' data-cola='0'><br>	 </td>
								
								   <?php
								  		
								}
				
				
				
				
			$vfreq = $vfreq + 1;
			}	
			$idripl=1;
			
			
			
		?>
							</tr>
		<?php	
			break;
				
		}
		
	
		
		?>	
		<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>Ripple Rx not EQ</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temulrip = ${"iteriple".$i_itera};
											
									     $v_data_eq_ul_r = explode("|",$temulrip[0]);											
										 $v_data_eq_ud_r = explode("|",$temulrip[1]);
																									
											
											$vdatkey = explode(" ",$v_data_eq_ul_r[0]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud_r[0]);	
																	
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[0]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[0]; ?></td>
									<?php
								}
								
							?>
							
							</tr>	
								<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>Ripple Rx EQ</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temulrip = ${"iteriple".$i_itera};
											
									     $v_data_eq_ul_r = explode("|",$temulrip[0]);											
										 $v_data_eq_ud_r = explode("|",$temulrip[1]);
																									
											
											$vdatkey = explode(" ",$v_data_eq_ul_r[0]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud_r[0]);	
																	
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[1]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[1]; ?></td>
									<?php
								}
								
							?>
							
							</tr>	
								<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>Ripple Tx not EQ</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temulrip = ${"iteriple".$i_itera};
											
									     $v_data_eq_ul_r = explode("|",$temulrip[0]);											
										 $v_data_eq_ud_r = explode("|",$temulrip[1]);
																									
											
											$vdatkey = explode(" ",$v_data_eq_ul_r[1]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud_r[1]);	
																	
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[0]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[0]; ?></td>
									<?php
								}
								
							?>
							
							</tr>	
								<tr data-rowa='1'><td data-rowa='1' data-cola='0'><b>Ripple Tx EQ</b> </td>				
							<?php							
								for ($i_itera = 1; $i_itera <= $count_rows; $i_itera++) {
									
										 $temulrip = ${"iteriple".$i_itera};
											
									     $v_data_eq_ul_r = explode("|",$temulrip[0]);											
										 $v_data_eq_ud_r = explode("|",$temulrip[1]);
																									
											
											$vdatkey = explode(" ",$v_data_eq_ul_r[1]);			
											$vdatkeydl = explode(" ",$v_data_eq_ud_r[1]);	
																	
									?>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkey[1]; ?></td>
									<td data-rowa='1' data-cola='0'><?php echo $vdatkeydl[1]; ?></td>
									<?php
								}
								
							?>
							
							</tr>	
							<tr data-rowa='0'>	
								<th data-rowa='1' data-cola='0' class="table-info">PARAMETER</th>
								<?php
								$count_rows=0;
								foreach($data as $i =>$keyaa) 		
								{
									$count_rows=$count_rows+1;
									
									$tempabc=explode("#",$keyaa[0]);		
									${"ite".$count_rows}  = $tempabc;
									
									$tempabcd=explode("#",$keyaa[1]);
																	
									${"iteriple".$count_rows}  = $tempabcd
									?>
									<th data-rowa='1' data-cola='0' class="table-info">Iteration <?php echo $count_rows; ?><BR> UL</th>
									<th data-rowa='1' data-cola='0' class="table-info" >Iteration <?php echo $count_rows; ?><BR> DL</th>
								   <?php
								  		
								}
								?>
								
								
							</tr>	
</table>