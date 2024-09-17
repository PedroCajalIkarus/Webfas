<!DOCTYPE html>
<html>
<head>
    <title>Connected jQuery Grids</title>
    <meta charset="utf-8" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="">
        <table id="grid1" data-primary-key="idlabel"></table>
        <br /><br />
       
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var grid1, grid2;
            grid1 = $('#grid1').grid({
                primaryKey: 'idlabel',
				    uiLibrary: 'bootstrap4',
                  dataSource: 'getdatalabeling.php',
                columns: [{ field: 'idlabel', width: 56 }, { field: 'ciu' }, { field: 'ulpwrrat' }]
               
            });
          
           
        });
    </script>
</body>
</html>