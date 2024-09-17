<?php
// Desactivar toda notificación de error
error_reporting(0);
//control ataques de querystring
if( $_REQUEST['mkt_tok']<> '')
{
  echo "Error...";
  exit();
}

$idnroattach=0;

/*
if (($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/png")
    || ($_FILES["file"]["type"] == "image/gif")) {*/


        ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '101M');
ini_set('max_input_time', 320);
ini_set('memory_limit', '256M'); 



include("db_conect.php"); 
 
        $token = $_REQUEST['idt'];
        $vidord =  $_REQUEST['idord']; 
       
    if (move_uploaded_file($_FILES["file"]["tmp_name"], "attachso/".$token."_".$_FILES['file']['name'])) {
      //  echo 'qsi'. $token;

        $idnroattach= $idnroattach + 1;
        $sentenciahonwywell = $connect->prepare("INSERT INTO orders_fileattach_draft(idordersfileat, namefileattach, seedtemp,datemodif,active)  VALUES ((select coalesce(max(idordersfileat)+ 1,0) from orders_fileattach_draft ), :fileattach, :seedtemp,now(),'draft')");
               

        $thefilefull = $token."_".$_FILES['file']['name'];
        $sentenciahonwywell->bindParam(':fileattach', $thefilefull);
        $sentenciahonwywell->bindParam(':seedtemp', $token);
   
        $sentenciahonwywell->execute();   

        $sentenciahonwywell = $connect->prepare(" insert into orders_fileattach
        SELECT idordersfileat,:idordnn, namefileattach, seedtemp
            FROM public.orders_fileattach_draft
            where namefileattach =:fileattach and seedtemp = :seedtemp");

            $sentenciahonwywell->bindParam(':fileattach', $thefilefull);
            $sentenciahonwywell->bindParam(':seedtemp', $token);
            $sentenciahonwywell->bindParam(':idordnn', $vidord);
          
       
            $sentenciahonwywell->execute();   
          
       



        $vuserfas = $_SESSION["b"];
        $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
        $vaccionweb="Attach SO file";
        $vdescripaudit="Attach SO file:".$thefilefull;	
        $vtextaudit= "Attach SO file:?:".$thefilefull;	

        $sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
        $sentenciaudit->bindParam(':userfas', $vuserfas);								
        $sentenciaudit->bindParam(':menuweb', $vmenufas);
        $sentenciaudit->bindParam(':actionweb', $vaccionweb);
        $sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
        $sentenciaudit->bindParam(':textaudit', $vtextaudit);
        $sentenciaudit->execute();

    } else {
      //  echo 'no';
    }
// }
?>

<html>



  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/dropzone5/dropzone.js"></script>

<script src="js/jquery-ui.min.js"></script>
<style>
#previews {
  padding: 15px;
  padding-top: 0px;
  padding-bottom: 0px;
  margin-top: 15px;
  min-height: 220px;
  background-color: #EAE8E7;   
  /*#fbfbfb; */
}
 
.dropzone-here {
    text-align: center;
    padding-top: 60px;
    width: 100%;
    position: absolute;
    font-size: 18px;
    font-weight: bold;
    top: 50px;
}
 
#previews .file-row .delete {
    display: none;
}
 
#previews .file-row.dz-success .start,
#previews .file-row.dz-success .cancel {
    display: none;
}
 
#previews .file-row.dz-success .delete {
    display: block;
}
 
.dz-image-preview {
    border: 1px solid #d6d4d4;
    padding-top: 15px;
    padding-bottom: 15px;
    margin-bottom: 15px;
}
 
.preview {
    position: relative;
    background: #fff;
    border: 1px solid #dadada;
    text-align: center;
    display: table-cell;
    vertical-align: middle;
}
 
.preview img {
    cursor: pointer;
}
 
.progress {
    border: 1px solid #ccc;
    position: relative;
    display: block;
    height: 22px;
    padding: 0;
    min-width: 200px;
    margin:4px 0;
    background: #B6131F;
    background: -webkit-gradient(linear, left top, left bottom, from(#ccc), to(#e9e9e9));
    background: -moz-linear-gradient(top, #ccc, #e9e9e9);
    filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#cccccc', endColorstr='#e9e9e9');
    -moz-box-shadow:0 1px 0 #fff;
    -webkit-box-shadow:0 1px 0 #fff;
    box-shadow:0 1px 0 #fff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
}
 
.progress-bar {
    color: #ffffff;
    display: block;
    height: 20px;
    margin: 0;
    padding: 0;
    text-align:center;
    -moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
    -webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
    box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    border: 1px solid #0078a5;
    background-color: #B6131F;
    background: -moz-linear-gradient(top, #00adee 10%, #0078a5 90%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0.1, #00adee), color-stop(0.9, #0078a5));
}

	body {

  font-family: Arial;
    font-size: 12px;
}
  .tree
  { 
      margin: 6px;
      margin-left: -35px;
  }
  
  .tree li {
      list-style-type:none;
      margin:0;
      padding:6px 5px 0 5px;
      position:relative
  }
  .tree li::before, 
  .tree li::after {
      content:'';
      left:-20px;
      position:absolute;
      right:auto
  }
  .tree li::before {
      border-left:1px solid #000;
      bottom:50px;
      height:100%;
      top:0;
      width:1px
  }
  .tree li::after {
      border-top:1px solid #000;
      height:20px;
      top:25px;
      width:25px
  }
  
  .tree li span {
      -moz-border-radius:5px;
      -webkit-border-radius:5px;
      border:1px solid #000;
      border-radius:1px;
      display:inline-block;
      padding:1px 5px;
      text-decoration:none;
      cursor:pointer;
  }
  .tree>ul>li::before,
  .tree>ul>li::after {
      border:0
  }
  .tree li:last-child::before {
      height:27px
  }
  
  
  textarea.form-controlm {
        display: block;
      width: 100%;
      height: calc(2.25rem + 2px);
      padding: .375rem .75rem;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #495057;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      border-radius: .25rem;
      box-shadow: inset 0 0 0 transparent;
      transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
      height: 238px;
      font-size: 13px;
  
  }
  
  .btn-smm {
      display: inline-block;
      font-weight: 400;
      color: #212529;
      text-align: center;
      vertical-align: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background-color: transparent;
      border: 1px solid transparent;
      padding: .375rem .75rem;
       font-size: 10px;
      line-height: 1.5;
      border-radius: .25rem;
  
  }

  .colorazultitulo
  {
    color:#B6131F;
    font-size: 20px;
    font-weight: bolder;
  }

  hr.borderojo
  {
    border: 1px solid #B6131F;
  }

  .fondogris
  {
    background-color: #F3F3F3;
    
  }


  .small-box {
    border-radius: .25rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    display: block;
    margin-bottom: 20px;
    position: relative;
}
  

.form-control {
    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}


.btn {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    border-radius: 0rem;
    font-size: 1rem;
    line-height: 1.5;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

  
.btn-primary {
    color: #fff;
    background-color: #095488;
    border-color: #095488;
    box-shadow: none;
}

.btn-outline-primary {
    color: #095488;
    border-color: #095488;
}

.btn-outline-primary:hover {
    color: #fff;
    background-color: #095488;
    border-color: #095488;
}

.btn-outline-info {
  color: #000000;
  border-color: #095488;
 
}

.btn-outline-info:hover {
  color: #000000;   
  border-color: #095488;
    background-color:#D1E9FA;
}

.btn-outline-danger {
  color: #000000;
  border-color: #095488;
 
}

.btn-outline-danger:hover {
  color: #ffffff;   
  border-color: #095488;
    background-color:red;
}

.btn-info:hover {
  color: #000000;
  border-color: #095488;
}

.small-box {
    border-radius: 0rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    display: block;
    margin-bottom: 20px;
    position: relative;
}

.bg-azulhoneywell, .bg-azulhoneywell>a {
    color: #ffffff;
    background-color: #095488;
}


.bg-rojopopahoneywell, .bg-rojopopahoneywell>a {
    color: #ffffff;
    background-color: #B5131F;
}

.btn-danger{
  color: #ffffff;
  background-color: #B5131F;

}

.btn-info{
  color: #000000;
  background-color: #D1E9FA;

}

.btn-info:hover {
    color: #000000;
    background-color: #D1E9FA;
    border-color: #D1E9FA;
}

.colorazulhoneywell{
    color: #095488;
  
}

.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin-bottom: .5rem;
    font-family: inherit;
    font-weight: 500;
    line-height: 1.2;
    color: #095488;
}


.card-header {
    background-color: #095488;
    border-bottom: 1px solid rgba(0,0,0,.125);
    padding: .75rem 1.25rem;
    position: relative;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #ffffff;
}

.card-title {
    float: left;
    font-size: 1.1rem;
    font-weight: 400;
    margin: 0;
    color: #ffffff;
}

.fondolightgray
{
  color: #000000;
  background-color: #9C9C9C;
}

[class*=sidebar-dark-] {
    background-color: #303030;
}

.content-wrapper {
    background: #F3F3F3;
}


.btn-xs {
    padding: .125rem .25rem;
    font-size: .75rem;
    line-height: 1.5;
    border-radius: .15rem;
}

  </style>


<body class="hold-transition sidebar-mini layout-fixed">
 <p style="color:red">&nbsp;&nbsp;<b>NOTE: Individual file size limit is 30 MB and the file name length should be below 85 characters.<b><br></p>
<br>
<div class="container-fluid">
<form action="index.php?idord=<?php echo $vidord; ?>" method="post" enctype="multipart/form-data">

    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>
    <div id="actions" class="row">
        <div class="col-lg-7">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-outline-primary btn-xs  fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Add files...</span>
            </span>
            <button type="submit" class="btn btn-primary btn-xs start" style="display: none;">
                <i class="glyphicon glyphicon-upload"></i>
                <span>Start upload</span>
            </button>
            <button type="reset" class="btn btn-warning btn-xs cancel" style="display: none;">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Cancel upload</span>
            </button>
        </div>
 
        <div class="col-lg-5">
            <!-- The global file processing state -->
            <span class="fileupload-process">
                <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                </div>
            </span>
        </div>
    </div>
    <p align='center'>:: Drop files here to upload ::</p>
    <div class="table table-striped files" id="previews">
        <div id="template" class="file-row row">
            <!-- This is used as the file preview template -->
            <div class="col-xs-12 col-lg-3">
                <span class="preview" style="width:160px;height:160px;">
                    <img data-dz-thumbnail />
                </span>
                <br/>
                <button class="btn btn-primary btn-xs start" style="display:none;">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
                <button data-dz-remove class="btn btn-warning btn-xs cancel">
                    <i class="icon-ban-circle fa fa-ban-circle"></i> 
                    <span>Cancel</span>
                </button>
                <button data-dz-remove class="btn btn-danger btn-xs delete">
                    <i class="icon-trash fa fa-trash"></i> 
                    <span>Remove</span>
                </button>
            </div>
            <div class="col-xs-12 col-lg-9">
                <p class="name" data-dz-name></p>
                <p class="size" data-dz-size></p>
                <div>
                    <strong class="error text-danger" data-dz-errormessage></strong>
                </div>
                <div>
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                      <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="dropzone-here">Drop files here to upload.</div>
</form>
</div>
</body>
<script>
// Get the template HTML and remove it from the doument


$( window ).on( "load", function() {
        console.log( "Ha ocurrido window.load: ventana lista" );
        $('.dropzone-here').hide();
        
    });


var previewNode = document.querySelector("#template");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);
 
var vidtt =   (new URL(location.href)).searchParams.get('idt');

var vidp =   (new URL(location.href)).searchParams.get('idp');
var vidpr =   (new URL(location.href)).searchParams.get('idpr');
var voa =   (new URL(location.href)).searchParams.get('openattach');
var vidoor=   (new URL(location.href)).searchParams.get('idord');

var myDropzone = new Dropzone(document.body, {
    url: "attachfileprojectsoaddmore.php?idt="+vidtt+"&idp="+vidp+"&idpr="+vidpr+"&openattach="+voa+"&idord="+vidoor,
    paramName: "file",
  /*  acceptedFiles: 'image/*,application/pdf,.*',*/
    maxFilesize: 35,
    maxFiles: 35,
    thumbnailWidth: 160,
    thumbnailHeight: 160,
    thumbnailMethod: 'contain',
    parallelUploads: 2,
    previewTemplate: previewTemplate,
    autoQueue: true,
    timeout: 180000,
    previewsContainer: "#previews",
    clickable: ".fileinput-button",
          error: function(file, msg){
            console.log(msg);
        },
});
 
myDropzone.on("addedfile", function(file) {
    $('.dropzone-here').hide();

    // Hookup the start button
  
                    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
                
    
});
 
// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
});
 
myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1";
    // And disable the start button

console.log(file.name.length);
    if (file.name.length > 85) {
                    alert("Filename exceeds 85 characters!");
                    myDropzone.removeFile(file);    
                }
                else
                {
                    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
                }
    
});
 
// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
    //document.querySelector("#total-progress").style.opacity = "0";
});

myDropzone.on("complete", function(progress) {
   console.log('Submit ok marco');
});
 
// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
};
 
$('#previews').sortable({
    items:'.file-row',
    cursor: 'move',
    opacity: 0.5,
    containment: "parent",
    distance: 20,
    tolerance: 'pointer',
    update: function(e, ui){
        //actions when sorting
    }
});


</script>
</html>