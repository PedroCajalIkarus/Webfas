
														<div id="tablelabelingedit" >
					
						
					
					
					</div>
														<script>
											
											
											var table = new Tabulator("#tablelabelingedit", {													
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
							{title:"Description",width:200, field:"description", sorter:"string",  editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
						cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},},	
						   	{title:"Band", field:"namegroup",width:100, sorter:"string",  editor:false },

							{title:"F.Start", field:"fstart", width:80,  sorter:"string",  editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
						cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},	},								
							{title:"F.Stop", field:"fstop", width:80,  sorter:"string",  editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
						cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								}, },								
							
							{title:"Gain", field:"gain", width:50, sorter:"string",  editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
						cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},	},	
							{title:"Gain Tolerance", field:"gaintolerance", width:80,  sorter:"string",  editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
						cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},	},	
							
							{title:"IMD 3 Test1", field:"imd3a", width:80,  sorter:"string",  editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
						cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								}, 	},	
							{title:"IMD 3 Test1 Limit", field:"imd3limita", width:80,  sorter:"string", editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
						cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},	},	
							{title:"IMD 3 Test2", field:"imd3b", width:80,  sorter:"string",  editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
						cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},	},	
							{title:"IMD 3 Test2 Limit", field:"imd3limitb", width:80,  sorter:"string",  editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
						cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},



																					},													
							{title:"IsETSI", field:"etsi", width:80, sorter:"string", 
										formatter:function(cella, formatterParams){
											var valuea = cella.getValue();
											if( valuea ==true){
												return "<span style='color:green; font-weight:bold;'><i class='far fa-check-circle' style='font-size:20px;color:green'></i></span>";
											}else{
												return "<span style='color:black; font-weight:bold;'>-</span>";
											}
										}, 
										editorParams:{values:{"true":"TRUE", "false":"FALSE"}},			
									editor:"select", 
								cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},	
										},		
							{title:"IsDual", field:"isdual",width:80,  sorter:"string", 
										formatter:function(cella, formatterParams){
											var valuea = cella.getValue();
											if( valuea ==true){
												return "<span style='color:green; font-weight:bold;'><i class='far fa-check-circle' style='font-size:20px;color:green'></i></span>";
											}else{
												return "<span style='color:black; font-weight:bold;'>-</span>";
											}
										},  
										editorParams:{values:{"true":"TRUE", "false":"FALSE"}},			
							editor:"select", 
								cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},	
										},
							{title:"Use LNA Setup", field:"uselnasetup",  width:80, sorter:"string", 
										formatter:function(cella, formatterParams){
											var valuea = cella.getValue();
											if( valuea ==true){
												return "<span style='color:green; font-weight:bold;'><i class='far fa-check-circle' style='font-size:20px;color:green'></i></span>";
											}else{
												return "<span style='color:black; font-weight:bold;'>-</span>";
											}
										},  editorParams:{values:{"true":"TRUE", "false":"FALSE"}},			
							editor:"select", 
								cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},	
								},	

									{title:"Active", field:"active", width:80, sorter:"string", 
										formatter:function(cella, formatterParams){
											var valuea = cella.getValue();
											if( valuea =='Y'){
												return "<span style='color:green; font-weight:bold;'><i class='far fa-check-circle' style='font-size:20px;color:green'></i></span>";
											}else{
												return "<span style='color:black; font-weight:bold;'>-</span>";
											}
										},  editorParams:{values:{"true":"TRUE", "false":"FALSE"}},			
							editor:"select", 
								cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},	
								},												
						
					
					
							/*{title:"Uselnasetup", field:"uselnasetup",  sorter:"string", 
						
										formatter:function(cella, formatterParams){
											var valuea = cella.getValue();
											if( valuea ==true){
												return "<span style='color:green; font-weight:bold;'><i class='far fa-check-circle' style='font-size:20px;color:green'></i></span>";
											}else{
												return "<span style='color:black; font-weight:bold;'>-</span>";
											}
										},  
										
								editorParams:{values:{"true":"TRUE", "false":"FALSE"}},			
							editor:"select", 
								cellEdited :function(datofila)
								{
									$.ajax({
											
											url: 'ajax_update_a00000000200270028.php',
											data: "idlabel="+datofila._cell.row.data.idproduct+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												primerpaso($("#idtablabelbranch").val());												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});				
								},											
						},*/
					]						
					});
					
					///table.setFilter("ciu", "like", "BTTY");
				 table2 = table;
				///table2.setFilter("ciu", "like", "BTTY");
																		
														</script>
														

													