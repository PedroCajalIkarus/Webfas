
														<div id="tablelabeling" >
					
						
					
					
					</div>
														<script>
											
											
											var table = new Tabulator("#tablelabeling", {													
					ajaxURL:"getdata_a000000002013014.php",
					ajaxProgressiveLoad:"scroll",
					placeholder:"No Data Set",	
					height:"500px",					
					layout:"fitColumns",  
						 rowFormatter:function(row){
								if(row.getData().active.toLowerCase()  == "false"){
									console.log ("aaaa" + row.getData().active);
									row.getElement().style.backgroundColor = "#ffcccc";
								}
								if(row.getData().active.toLowerCase()  == "erase"){
								
									row.getElement().style.backgroundColor = "#FF6565";
								}
							},
						columns:[
		
						
							{title:"CIU", field:"modelciu", width:130, sorter:"string",editor:false},						
							{title:"Description",width:200, field:"description", sorter:"string",  editor:false},	

							{title:"Band",width:100, field:"nombreband", sorter:"string",  editor:false},	
							{title:"Port IN UL",width:100, field:"idportinul", sorter:"string",  editor:false},	
							{title:"Port OUT UL",width:100, field:"idportoutul", sorter:"string",  editor:false},	
							{title:"UL Gain:",width:100, field:"ulgain", sorter:"string",  editor:false},	
							{title:"UL Max Pwr::",width:100, field:"ulmaxpwr", sorter:"string",  editor:false},	

							{title:"Port IN DL",width:100, field:"idportindl", sorter:"string",  editor:false},	
							{title:"Port OUT DL",width:100, field:"idportoutdl", sorter:"string",  editor:false},	
							{title:"DL Gain:",width:100, field:"dlgain", sorter:"string",  editor:false},	
							{title:"DL Max Pwr::",width:100, field:"dlmaxpwr", sorter:"string",  editor:false},	


						  

					

									{title:"Active", field:"active", width:100, sorter:"string", 
										formatter:function(cella, formatterParams){
											var valuea = cella.getValue();
											if( valuea =='Y'){
												return "<span style='color:green; font-weight:bold;'><i class='far fa-check-circle' style='font-size:20px;color:green'></i></span>";
											}else{
												return "<span style='color:black; font-weight:bold;'><i class='fas fas fa-ban' style='font-size:20px;color:red'></i></span>";
											}
										},  editor:false},												
														
						
					]	
					});
					
					///table.setFilter("ciu", "like", "BTTY");
				 table2 = table;
				///table2.setFilter("ciu", "like", "BTTY");
																		
														</script>
														

													