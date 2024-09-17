
														<div id="tablelabeling" >
					
						
					
					
					</div>
														<script>
											
											
											var table = new Tabulator("#tablelabeling", {													
					ajaxURL:"getdata_a00000000200270029.php",
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
					     
						
							{title:"CIU", field:"modelciu", width:100, sorter:"string",editor:false},						
							{title:"Description",width:200, field:"description", sorter:"string",  editor:false},	
						   	{title:"Band", field:"namegroup",width:100, sorter:"string",  editor:false },

							{title:"F.Start", field:"fstart", width:80,  sorter:"string",  editor:false	},								
							{title:"F.Stop", field:"fstop", width:80,  sorter:"string",  editor:false},								
							
							{title:"Gain", field:"gain", width:80, sorter:"string",  editor:false	},	
							{title:"Gain Tolerance", field:"gaintolerance", width:100,  sorter:"string",  editor:false	},	
							
							{title:"IMD Test1", field:"imd3a", width:100,  sorter:"string",  editor:false	},	
							{title:"IMD Test1 Limit", field:"imd3limita", width:100,  sorter:"string",  editor:false	},	
							{title:"IMD Test2", field:"imd3b", width:100,  sorter:"string",  editor:false	},	
							{title:"IMD Test2 Limit", field:"imd3limitb", width:100,  sorter:"string",  editor:false	},													
							{title:"IsETSI", field:"etsi", width:100, sorter:"string", 
										formatter:function(cella, formatterParams){
											var valuea = cella.getValue();
											if( valuea ==true){
												return "<span style='color:green; font-weight:bold;'><i class='far fa-check-circle' style='font-size:20px;color:green'></i></span>";
											}else{
												return "<span style='color:black; font-weight:bold;'>-</span>";
											}
										},  editor:false},		
							{title:"IsDual", field:"isdual",width:100,  sorter:"string", 
										formatter:function(cella, formatterParams){
											var valuea = cella.getValue();
											if( valuea ==true){
												return "<span style='color:green; font-weight:bold;'><i class='far fa-check-circle' style='font-size:20px;color:green'></i></span>";
											}else{
												return "<span style='color:black; font-weight:bold;'>-</span>";
											}
										},  editor:false},
							{title:"Use LNA Setup", field:"uselnasetup",  width:100, sorter:"string", 
										formatter:function(cella, formatterParams){
											var valuea = cella.getValue();
											if( valuea ==true){
												return "<span style='color:green; font-weight:bold;'><i class='far fa-check-circle' style='font-size:20px;color:green'></i></span>";
											}else{
												return "<span style='color:black; font-weight:bold;'>-</span>";
											}
										},  editor:false},	

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
														

													