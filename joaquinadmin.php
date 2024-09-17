<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
 
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterangepicker -->
   <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
   <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">

  
  <!-- AdminLTE css -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
    <title>Admin PDFs (Joaquin)</title>
  </head>
  <body>
  <br>
 
	
	<div class="container">
  <div class="row"> 
      
      <div class="container">
        <div class="row">
     
            <div class="col-md">
            <h2>Admin PDFs (Joaquin)</h2>
            </div>
            <div class="col-md">
            
            </div>
            <div class="col-md">
            
            </div>
        
        </div>
        <hr>
        <div class="row">
     
     <div class="col-md">
     <button id="button" name="button" class="btn btn-primary">Search Pdfs</button>

     </div>
     <div class="col-md">
     
     </div>
     <div class="col-md">
      <button id="button" name="button" class="btn btn-success" onclick="copiar()">Copy Pdfs to WEBFAS </button>

     </div>
 
 </div>

    </div>

 
    <hr>
      <div class="container-FLIUD">
        <!-- Content here -->
    <hr>
        <table class="table table-bordered " name="tbl1" id="tbl1">
        <thead class="thead-dark">
          <tr>
            <th scope="col"> #</th>
            <th scope="col">File</th>
            <th scope="col">Last Modified</th>
            <th scope="col">Number of days unchanged</th>
         
          </tr>
        </thead>
        <tbody id="detallelog" name="detallelog">
       
        </tbody>
      </table>


      </div>
  </div>
</div>

    <!-- Optional JavaScript; choose one of the two! -->
 

 

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="/plugins/datatables/jquery.dataTables.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  </body>
</html>
<script type="text/javascript">
var htmltable='';
var restafec =0;
var diadehoytime = new Date().getTime();
const button = document.getElementById('button');
button.addEventListener('click', async () => {
  const out = {};
  const dirHandle = await showDirectoryPicker();  
  await handleDirectoryEntry( dirHandle, out );
  console.log( out );
 

  Object.entries(out).forEach(([key, value]) => {
  console.log(key +'--'+value);
  restafec = (diadehoytime - out[key]['lastModified']);
  var day_as_milliseconds = 86400000;
 
var diff_in_days =  (restafec / day_as_milliseconds);
diff_in_days = parseInt(diff_in_days);

var classnametbl='';
if (diff_in_days > 179)
{
  classnametbl='table-danger';
  
}
else
{
  if (diff_in_days > 120 )
  {

    classnametbl='table-warning';
    
  }
  else
  {
    if (diff_in_days > 120 )
    {
      classnametbl='table-info';
    }
    
  }
}
  if (key.indexOf('.pdf') > 0)
  {
    htmltable= htmltable+' <tr class='+classnametbl+'><td>  <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"></td><td>'+ key +'</td><td>'+out[key]['lastModifiedDate'] +'</td><td>'+diff_in_days+'</td></tr>';
  }
  
});
/*
  let claves = Object.keys(out); // claves = ["nombre", "color", "macho", "edad"]
for(let i=0; i< claves.length; i++){
  let clave = claves[i];
  console.log(out[clave]);
  //   htmltable= htmltable+' <tr><th scope="row">  <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"></th><td>'+out[i]+'</td><td>Otto</td></tr>';
}
*/
  /*for (i = 0; i < out.length; i++) {
      console.log(out[i]);
   //   htmltable= htmltable+' <tr><th scope="row">  <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"></th><td>'+out[i]+'</td><td>Otto</td></tr>';
    } */

    $("#detallelog").html( htmltable );

    $('#tbl1').DataTable({
      "paging": true,
      "pageLength": 25,
      "searching": true,
      "order": [[2,"asc"]],
      "info": true,
      "autoWidth": false,
    });

 

});
async function handleDirectoryEntry( dirHandle, out ) {
  for await (const entry of dirHandle.values()) {
    if (entry.kind === "file"){
      const file = await entry.getFile();
      out[ file.name ] = file;
    }
    if (entry.kind === "directory") {
      const newOut = out[ entry.name ] = {};
      await handleDirectoryEntry( entry, newOut );
    }
  }
}
/*
 
 const button = document.getElementById('button');
button.addEventListener('click', async () => {
  const dirHandle = await window.showDirectoryPicker();
  for await (const entry of dirHandle.values()) {
    console.log(entry.kind, entry.name);
  }
});
*/

function copiar()
{
  var myObject, newpath;
        myObject = new ActiveXObject("Scripting.FileSystemObject");
        myObject.CopyFile ("C:\\TEMP\\hoy.txt", "M:\\www\\Source\\hoy.txt");
}
</script>  