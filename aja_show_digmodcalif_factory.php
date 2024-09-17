<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 

	$query_lista = list_digmodulecalif_factory($_REQUEST['idsunit'] ,$_REQUEST['iddib_sn_modulo']);
    $return_arr = array();
 		
  	//echo $query_lista;				
	$data = $connect->query($query_lista)->fetchAll();						
	$letrasbuscadas = array("/", ".", ",", "-", );
	$vidfreqcant =0;
	
	$v_iteracion = 1;
	$vfreq = 0;
	?>
	
	<table id='myTablecalibeq' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped '>
			<tr data-rowa='0'>	
								<td data-rowa='1' data-cola='0' class="table-info"><b>PARAMETER</b></td>
							
									<td data-rowa='1' data-cola='0' class="table-info"><b>Iteration  <BR></b><b> UL</b></td>
									<td data-rowa='1' data-cola='0' class="table-info"><b>Iteration  <BR></b><B> DL</B></td>
								 
							</tr>	
</table>