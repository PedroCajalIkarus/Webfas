<!DOCTYPE HTML> 
<html> 

<head> 
	<title> 
		How to convert JSON data to a 
		html table using JavaScript ? 
	</title> 

	<?php
	
	echo "Hola::".date("m/d/Y");
	
$fecha_actual = date("m/d/Y");
	echo "HOLA".date("m/d/Y",strtotime($fecha_actual."+ 7 days")); 
	///10/15/2021 10:32 AM

	?>
	
	<script src= 
"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> 
	</script> 
</head> 

<body style = "text-align:center;" id = "body"> 
	
	<h1 style = "color:green;" > 
		Pruebas Marco 
	</h1> 
	
	<p id = "GFG_UP" style = 
		"font-size: 15px; font-weight: bold;"> 
	</p> 
	
	<button onclick = "constructTable('#table')"> 
		click here 
	</button> 
	
	<br><br> 
	
	<table align = "center"
			id="table" border="1"> 
	</table> 
	
	<script> 
		var el_up = document.getElementById("GFG_UP"); 
		
		var list = [ 
			{"Ch": 1, "rev0_ban0": "1"   } ,
			{"Ch": 2, "rev0_ban0": "1" , "rev0_ban1": "2"}, 
			{"Ch": 3, "rev0_ban2": "3"}, 
			{"Ch": 4, "rev0_ban4": "4", "rev0_ban2": "3.1"},
				
			
		]; 
		
	//var list = [{"ch":1,"Bandrev02":"155.775"},{"ch":2,"Bandrev02":"155.625"},{"ch":1,"Bandrev01":"0.0"},{"ch":2,"Bandrev01":"0.0"}];
	//var list =[{"f1":1,"f2":"0.0","f3":"0.0"},{"f1":1,"f2":"0.0","f3":"0.0"},{"f1":1,"f2":"0.0","f3":"0.0"},{"f1":2,"f2":"0.0","f3":"0.0"},{"f1":2,"f2":"0.0","f3":"0.0"},{"f1":2,"f2":"0.0","f3":"0.0"},{"f1":3,"f2":"0.0","f3":"0.0"},{"f1":3,"f2":"0.0","f3":"0.0"},{"f1":3,"f2":"0.0","f3":"0.0"},{"f1":4,"f2":"0.0","f3":"0.0"},{"f1":4,"f2":"0.0","f3":"0.0"},{"f1":4,"f2":"0.0","f3":"0.0"},{"f1":5,"f2":"0.0","f3":"0.0"},{"f1":5,"f2":"0.0","f3":"0.0"},{"f1":5,"f2":"0.0","f3":"0.0"}];
		
			var list =[{"idch":1,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":1,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":1,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":2,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":2,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":2,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":3,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":3,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":3,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":4,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":4,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":4,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":5,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":5,"concat":"Band0-Rev2","ul_ch_fr":"0.0"},{"idch":5,"concat":"Band0-Rev2","ul_ch_fr":"0.0"}];

		
		el_up.innerHTML = "Click on the button to create " 
				+ "the table from the JSON data.<br><br>" 
				+ JSON.stringify(list[0]) + "<br>" 
				+ JSON.stringify(list[1]) + "<br>" 
				+ JSON.stringify(list[2]); 
			
		function constructTable(selector) { 
			
			// Getting the all column names 
			var cols = Headers(list, selector); 

			// Traversing the JSON data 
			for (var i = 0; i < list.length; i++) { 
				var row = $('<tr/>'); 
				for (var colIndex = 0; colIndex < cols.length; colIndex++) 
				{ 
				
					var val = list[i][cols[colIndex]]; 
				//	console.log('valor'+val);
					// If there is any key, which is matching 
					// with the column name 
					if (val == null) val = ""; 
						row.append($('<td/>').html(val)); 
				} 
				
				// Adding each row to the table 
				$(selector).append(row); 
			} 
		} 
		
		function Headers(list, selector) { 
			var columns = []; 
			var header = $('<tr/>'); 
			
			for (var i = 0; i < list.length; i++) { 
				var row = list[i]; 
				
				for (var k in row) {
					
					if ($.inArray(k, columns) == -1) { 
						columns.push(k); 
						
						// Creating the header 
						header.append($('<th/>').html(k)); 
					} 
				} 
			} 
			
			// Appending the header to the table 
			$(selector).append(header); 
				return columns; 
		}	 
	</script> 
	
	<?php echo phpinfo(); ?>
</body> 

</html> 
