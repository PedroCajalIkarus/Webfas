
														<div id="tablelabeling" >
					
						
					
					
					</div>
														<script>
											
											
											var table = new Tabulator("#tablelabeling", {													
					ajaxURL:"getdata_a0000000020006.php",
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
						  

							{title:"F.Start", field:"coupfstart", width:75,  sorter:"string",  editor:false	},								
							{title:"F.Stop", field:"coupfstop", width:75,  sorter:"string",  editor:false},								
							
							{title:"Coupling(dB)", field:"coupling", width:120, sorter:"string",  editor:false	},	
							{title:"Insertion Loss(dB):", field:"couplinginsertloss", width:150,  sorter:"string",  editor:false	},	
							
							{title:"Isolation(dB):", field:"couplingisolation", width:120,  sorter:"string",  editor:false	},	
																		
					

									{title:"Active", field:"active", width:100, sorter:"string", 
										formatter:function(cella, formatterParams){
											var valuea = cella.getValue();
											if( valuea =='Y'){
												return "<span style='color:green; font-weight:bold;'><i class='far fa-check-circle' style='font-size:20px;color:green'></i></span>";
											}else{
												return "<span style='color:black; font-weight:bold;'>-</span>";
											}
										},  editor:false},												
														
						
					]	
					});
					
					///table.setFilter("ciu", "like", "BTTY");
				 table2 = table;
				///table2.setFilter("ciu", "like", "BTTY");
																		
														</script>
														

													