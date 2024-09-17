<html lang="en" itemscope itemtype="http://schema.org/WebSite">

<head>

  <title>Tabulator</title>


  
<link href="css/tabulator_site.css" rel="stylesheet">
<link href="css/tabulator.css" rel="stylesheet">
<link href="css/tabulator_midnight.css" rel="stylesheet">
<link href="css/tabulator_modern.css" rel="stylesheet">
<link href="css/tabulator_simple.css" rel="stylesheet">
<link href="css/bootstrap/tabulator_bootstrap.css" rel="stylesheet">
<link href="css/bootstrap/tabulator_bootstrap4.css" rel="stylesheet">
<link href="css/semantic-ui/tabulator_semantic-ui.css" rel="stylesheet">
<link href="css/bulma/tabulator_bulma.css" rel="stylesheet">
<link href="css/materialize/tabulator_materialize.css" rel="stylesheet">
<link href="css/jquery-ui.theme.min.css" rel="stylesheet">

<script type="text/javascript" src="js/tabulator.min.js"></script>

<script src="js/sparkline.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
<script type="text/javascript" src="https://oss.sheetjs.com/sheetjs/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.5/jspdf.plugin.autotable.js"></script>

<link href="https://unpkg.com/tabulator-tables@4.5.2/dist/css/tabulator.min.css" rel="stylesheet">
<script type="text/javascript" src="https://unpkg.com/tabulator-tables@4.5.2/dist/js/tabulator.min.js"></script>


<script src="js/faker.js"></script>
<script src="js/touchpunch.js"></script>

<script type="text/javascript">
	window.TableLoader = {
		tables:{},
		register:function(table, func){
			this.tables[table] = func;
		},
		trigger:function(key){
			var self = this;

			if(this.tables[key]){
				this.tables[key]();
				this.tables[key] = function(){};

				var keys = Object.keys(this.tables);
				var index = keys.indexOf(key);

				if(index){
					this.tables[keys[index - 1]]();
					this.tables[keys[index - 1]] = function(){};
				}

				if(index < keys.length - 1){
					this.tables[keys[index + 1]]();
					this.tables[keys[index + 1]] = function(){};
				}
			}

			if(key == "theming"){
				var themes = Object.keys(this.tables).slice(-9);

				themes.forEach(function(item){
					self.trigger(item);
				})
			}
		},
		loadFirst:function(){
			first = Object.keys(this.tables)[0];

			if(first){
				this.trigger(first);
			}
		}
	}
</script>

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:800,400,700,400italic,700italic|Bevan' rel='stylesheet' type='text/css'>
<!--   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->

<link rel="stylesheet" href="/css/fontawesome.min.css">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">




  <link href="/css/app.css?id=a241cad31afa7e21582f" rel="stylesheet">
<!--   <link href="css/home.css" rel="stylesheet">
  <link href="css/prettyprint.css" rel="stylesheet"> -->

  <link rel="icon" type="image/png" href="/images/tabulator_favicon_simple.png">
  <link rel="stylesheet" href="/js/docsearchbackup/docsearch.css" />
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.css" /> -->
</head>

<body data-page='examples'>

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
   

 aaaa  
    </div>

  </nav>

  
  <main class="container" data-page='examples'>
    
<div class="row">

	<div class="col-md-3" role="complementary">
		<nav class="docs-sidebar docs-sidebar-detailed hidden-print hidden-xs hidden-sm affix">

			<div class="docs-sidenav-detailed">
				<div id="version-select-detailed">
 
</div>				<div class="docs-sidenav-detailed-list">
				<ul>
 
        <li class="open">
        <h2>Data<i class="fa closed fa-chevron-right"></i><i class="fa open fa-chevron-down"></i></h2>
        <ul class="nav">
                        <li><a href="#ajax">AJAX Data Loading</a></li>
                        <li><a href="#ajax-progressive">AJAX Progressive Loading</a></li>
                        <li><a href="#file-load">Data From Local File</a></li>
                        <li><a href="#table-load">Create From Table Element</a></li>
                        <li><a href="#reactivity">Data Reactivity</a></li>
                        <li><a href="#editable">Editable Data</a></li>
                        <li><a href="#validation">Validate Input</a></li>
                        <li><a href="#filter">Filter Data</a></li>
                        <li><a href="#filter-header">Filter Data In Column Header</a></li>
                        <li><a href="#sorters">Sorters</a></li>
                        <li><a href="#grouping">Grouping Data</a></li>
                        <li><a href="#pagination">Pagination</a></li>
                    </ul>
    </li>
     			</div>

			<div class="share">
	<a data-type="facebook" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//olifolkerd.github.io/tabulator/" onclick="window.open(this.href, 'share','left=20,top=20,width=500,height=400,toolbar=1,resizable=0'); return false;" title="Share On Facebook"><i class="fab fa-fw fa-facebook-square"></i></a>
	<a data-type="twitter" href="https://twitter.com/home?status=http%3A//olifolkerd.github.io/tabulator/" onclick="window.open(this.href, 'share','left=20,top=20,width=500,height=260,toolbar=1,resizable=0'); return false;"  title="Share On Twitter"><i class="fab fa-fw fa-twitter"></i></a>
	<a data-type="google" href="https://plus.google.com/share?url=http%3A//olifolkerd.github.io/tabulator/" onclick="window.open(this.href, 'share','left=20,top=20,width=500,height=510,toolbar=1,resizable=0'); return false;"  title="Share On Google+"><i class="fab fa-fw fa-google-plus-g"></i></a>
	<a data-type="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=http%3A//olifolkerd.github.io/tabulator/&title=Tabulator%20-%20Interactive%20JavaScript%20Tables&summary=Create%20interactive%20data%20tables%20in%20seconds%20with%20Tabulator.%20A%20lightweight,%20fully%20featured%20JQuery%20table%20generation%20plugin&source=" onclick="window.open(this.href, 'share','left=20,top=20,width=500,height=510,toolbar=1,resizable=0'); return false;"  title="Share On LinkedIn"><i class="fab fa-fw fa-linkedin"></i></a>
</div>			<a class="support-patreon" href="/support" target="_blank">
	<button type="button">
		<span><i class="fas fa-donate"></i> Support Tabulator <i class="fas fa-donate"></i></span>
	</button>
</a>			</div>


		</nav>
	</div>

	<div class="col-md-9 col-xs-12 content" role="main">
		
		
<script type="text/javascript">
    //sample data to be used in all tabulators
    var tabledata = [
    {id:1, name:"Oli Bob", progress:12, location:"United Kingdom", gender:"male", rating:1, col:"red", dob:"14/04/1984", car:1, lucky_no:5, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
    {id:2, name:"Mary May", progress:1, location:"Germany", gender:"female", rating:2, col:"blue", dob:"14/05/1982", car:true, lucky_no:10, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
    {id:3, name:"Christine Lobowski", progress:42, location:"France", gender:"female", rating:0, col:"green", dob:"22/05/1982", car:"true", lucky_no:12, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
    {id:4, name:"Brendon Philips", progress:100, location:"USA", gender:"male", rating:1, col:"orange", dob:"01/08/1980", car:false, lucky_no:18, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
    {id:5, name:"Margret Marmajuke", progress:16, location:"Canada", gender:"female", rating:5, col:"yellow", dob:"31/01/1999", car:false, lucky_no:33, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
    {id:6, name:"Frank Harbours", progress:38, location:"Russia", gender:"male", rating:4, col:"red", dob:"12/05/1966", car:1, lucky_no:2, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
    {id:7, name:"Jamie Newhart", progress:23, location:"India", gender:"male", rating:3, col:"green", dob:"14/05/1985", car:true, lucky_no:63, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
    {id:8, name:"Gemma Jane", progress:60, location:"China", gender:"female", rating:0, col:"red", dob:"22/05/1982", car:"true", lucky_no:72, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
    {id:9, name:"Emily Sykes", progress:42, location:"South Korea", gender:"female", rating:1, col:"maroon", dob:"11/11/1970", car:false, lucky_no:44, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
    {id:10, name:"James Newman", progress:73, location:"Japan", gender:"male", rating:5, col:"red", dob:"22/03/1998", car:false, lucky_no:9, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
    ];


    var tabledatasimple = [
    {id:1, name:"Oli Bob", location:"United Kingdom", gender:"male", rating:1, col:"red", dob:"14/04/1984"},
    {id:2, name:"Mary May", location:"Germany", gender:"female", rating:2, col:"blue", dob:"14/05/1982"},
    {id:3, name:"Christine Lobowski", location:"France", gender:"female", rating:0, col:"green", dob:"22/05/1982"},
    {id:4, name:"Brendon Philips", location:"USA", gender:"male", rating:1, col:"orange", dob:"01/08/1980"},
    {id:5, name:"Margret Marmajuke", location:"Canada", gender:"female", rating:5, col:"yellow", dob:"31/01/1999"},
    {id:6, name:"Frank Harbours", location:"Russia", gender:"male", rating:4, col:"red", dob:"12/05/1966"},
    {id:7, name:"Jamie Newhart", location:"India", gender:"male", rating:3, col:"green", dob:"14/05/1985"},
    {id:8, name:"Gemma Jane", location:"China", gender:"female", rating:0, col:"red", dob:"22/05/1982"},
    {id:9, name:"Emily Sykes", location:"South Korea", gender:"female", rating:1, col:"maroon", dob:"11/11/1970"},
    {id:10, name:"James Newman", location:"Japan", gender:"male", rating:5, col:"red", dob:"22/03/1998"},
    ];


    var tableDataNested = [
    {id:1, name:"Oli Bob", location:"United Kingdom", gender:"male", rating:1, col:"red", dob:"14/04/1984", car:1, lucky_no:5, _children:[
    {id:2, name:"Mary May", progress:1, location:"Germany", gender:"female", rating:2, col:"blue", dob:"14/05/1982", car:true, lucky_no:10},
    {id:3, name:"Christine Lobowski", progress:42, location:"France", gender:"female", rating:0, col:"green", dob:"22/05/1982", car:"true", lucky_no:12},
    {id:4, name:"Brendon Philips", progress:100, location:"USA", gender:"male", rating:1, col:"orange", dob:"01/08/1980", lucky_no:18, _children:[
    {id:5, name:"Margret Marmajuke", progress:16, location:"Canada", gender:"female", rating:5, col:"yellow", dob:"31/01/1999", lucky_no:33},
    {id:6, name:"Frank Harbours", progress:38, location:"Russia", gender:"male", rating:4, col:"red", dob:"12/05/1966", car:1, lucky_no:2},
    ]},
    ]},
    {id:7, name:"Jamie Newhart", progress:23, location:"India", gender:"male", rating:3, col:"green", dob:"14/05/1985", car:true, lucky_no:63},
    {id:8, name:"Gemma Jane", progress:60, location:"China", gender:"female", rating:0, col:"red", dob:"22/05/1982", car:"true", lucky_no:72, _children:[
    {id:9, name:"Emily Sykes", progress:42, location:"South Korea", gender:"female", rating:1, col:"maroon", dob:"11/11/1970", lucky_no:44},
    ]},
    {id:10, name:"James Newman", progress:73, location:"Japan", gender:"male", rating:5, col:"red", dob:"22/03/1998", lucky_no:9},
    ];

    var tabledatabig = [
    {id:1, name:"Oli Bob", progress:12, gender:"male", rating:1, col:"red", dob:"14/04/1984", car:1, lucky_no:5},
    {id:2, name:"Mary May", progress:1, gender:"female", rating:2, col:"blue", dob:"14/05/1982", car:true, lucky_no:10},
    {id:3, name:"Christine Lobowski", progress:42, gender:"female", rating:0, col:"green", dob:"22/05/1982", car:"true", lucky_no:12},
    {id:4, name:"Brendon Philips", progress:100, gender:"male", rating:1, col:"orange", dob:"01/08/1980", lucky_no:18},
    {id:5, name:"Margret Marmajuke", progress:16, gender:"female", rating:5, col:"yellow", dob:"31/01/1999", lucky_no:33},
    {id:6, name:"Frank Harbours", progress:38, gender:"male", rating:4, col:"red", dob:"12/05/1966", car:1, lucky_no:2},
    {id:7, name:"Jamie Newhart", progress:23, gender:"male", rating:3, col:"green", dob:"14/05/1985", car:true, lucky_no:63},
    {id:8, name:"Gemma Jane", progress:60, gender:"female", rating:0, col:"red", dob:"22/05/1982", car:"true", lucky_no:72},
    {id:9, name:"Emily Sykes", progress:42, gender:"female", rating:1, col:"maroon", dob:"11/11/1970", lucky_no:44},
    {id:10, name:"James Newman", progress:73, gender:"male", rating:5, col:"red", dob:"22/03/1998", lucky_no:9},
    {id:11, name:"Martin Barryman", progress:20, gender:"male", rating:5, col:"violet", dob:"04/04/2001"},
    {id:12, name:"Jenny Green", progress:56, gender:"female", rating:4, col:"indigo", dob:"12/11/1998", car:true},
    {id:13, name:"Alan Francis", progress:90, gender:"male", rating:3, col:"blue", dob:"07/08/1972", car:true},
    {id:14, name:"John Phillips", progress:80, gender:"male", rating:1, col:"green", dob:"24/09/1950", car:true},
    {id:15, name:"Ed White", progress:70, gender:"male", rating:0, col:"yellow", dob:"19/06/1976"},
    {id:16, name:"Paul Branderson", progress:60, gender:"male", rating:5, col:"orange", dob:"01/01/1982"},
    {id:17, name:"Gemma Jane", progress:50, gender:"female", rating:2, col:"red", dob:"14/04/1983", car:true},
    {id:18, name:"Emma Netwon", progress:40, gender:"female", rating:4, col:"brown", dob:"07/10/1963", car:true},
    {id:19, name:"Hannah Farnsworth", progress:30, gender:"female", rating:1, col:"pink", dob:"11/02/1991"},
    {id:20, name:"Victoria Bath", progress:20, gender:"female", rating:2, col:"purple", dob:"22/03/1986"},
    ];
</script>



<a class="anchor" id="ajax"></a>
<article>
    <h1>AJAX Data Loading <a class="doc-link" href="/docs/4.5/data#ajax"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>Data can be loaded into the table from a remote URL using a JSON formatted string.</p>

    <p>If you always request the same URL for your data then you can set it in the <span class='param'>ajaxURL</span> option when you create your Tabulator</p>

    <p>Click the button below to load sample data via AJAX.</p>

    <div class="table-controls-legend">AJAX Controls</div>

<div class="table-controls">
      <button id="ajax-trigger">Load Data via AJAX</button>
</div>

<div class="example-table" id="example-table-ajax">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    placeholder:"No Data Set",
    columns:[
        {title:"Name", field:"name", sorter:"string", width:200},
        {title:"Progress", field:"progress", sorter:"number", formatter:"progress"},
        {title:"Gender", field:"gender", sorter:"string"},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col", sorter:"string"},
        {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross", sorter:"boolean"},
    ],
});

//trigger AJAX load on "Load Data via AJAX" button click
$("#ajax-trigger").click(function(){
    table.setData("/exampledata/ajax");
});</pre>
    <h3>Server Side PHP</h3>
    <pre class="prettyprint lang-php">//build data array
$data = [
    [id=>1, name=>"Billy Bob", progress=>"12", gender=>"male", height=>1, col=>"red", dob=>"", driver=>1],
    [id=>2, name=>"Mary May", progress=>"1", gender=>"female", height=>2, col=>"blue", dob=>"14/05/1982", driver=>true],
    [id=>3, name=>"Christine Lobowski", progress=>"42", height=>0, col=>"green", dob=>"22/05/1982", driver=>"true"],
    [id=>4, name=>"Brendon Philips", progress=>"125", gender=>"male", height=>1, col=>"orange", dob=>"01/08/1980"],
    [id=>5, name=>"Margret Marmajuke", progress=>"16", gender=>"female", height=>5, col=>"yellow", dob=>"31/01/1999"],
];

//return JSON formatted data
echo(json_encode($data));</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("ajax", function(){
    var example_table_ajax = new Tabulator("#example-table-ajax", {
        height:"311px",
        layout:"fitColumns",
        placeholder:"No Data Set",
        columns:[
        {title:"Name", field:"name", sorter:"string", width:200},
        {title:"Progress", field:"progress", sorter:"number", formatter:"progress"},
        {title:"Gender", field:"gender", sorter:"string"},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col", sorter:"string"},
        {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross", sorter:"boolean"},
        ],
    });

    $("#ajax-trigger").click(function(){
        example_table_ajax.setData("/exampledata/ajax");
    })
})
</script></article>

<a class="anchor" id="ajax-progressive"></a>
<article>
    <h1>AJAX Progressive Loading <a class="doc-link" href="/docs/4.5/data#ajax-progressive"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>You can use the <span class='param'>ajaxProgressiveLoad</span> option along with <span class='param'>ajaxURL</span> to progressivly load pages of data as the user scrolls down the table.</p>

    <div class="example-table" id="example-table-ajax-progressive">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    ajaxURL:"/exampledata/ajaxprogressive",
    ajaxProgressiveLoad:"scroll",
    paginationSize:20,
    placeholder:"No Data Set",
    columns:[
        {title:"Name", field:"name", sorter:"string", width:200},
        {title:"Progress", field:"progress", sorter:"number", formatter:"progress"},
        {title:"Gender", field:"gender", sorter:"string"},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col", sorter:"string"},
        {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross", sorter:"boolean"},
    ],
});</pre>
    <h3>Server Side PHP</h3>
    <pre class="prettyprint lang-php">//build data array
$data = [
    [id=>1, name=>"Billy Bob", progress=>"12", gender=>"male", height=>1, col=>"red", dob=>"", driver=>1],
    [id=>2, name=>"Mary May", progress=>"1", gender=>"female", height=>2, col=>"blue", dob=>"14/05/1982", driver=>true],
    [id=>3, name=>"Christine Lobowski", progress=>"42", height=>0, col=>"green", dob=>"22/05/1982", driver=>"true"],
    [id=>4, name=>"Brendon Philips", progress=>"125", gender=>"male", height=>1, col=>"orange", dob=>"01/08/1980"],
    [id=>5, name=>"Margret Marmajuke", progress=>"16", gender=>"female", height=>5, col=>"yellow", dob=>"31/01/1999"],
];

//return JSON formatted data
echo(json_encode(["last_page"=>30, "data"=>$data]));</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("ajax-progressive", function(){
    var example_table_ajax_progressive = new Tabulator("#example-table-ajax-progressive", {
        height:"311px",
        layout:"fitColumns",
        ajaxURL:"/exampledata/ajaxprogressive",
        ajaxProgressiveLoad:"scroll",
        paginationSize:20,
        placeholder:"No Data Set",
        columns:[
        {title:"Name", field:"name", sorter:"string", width:200},
        {title:"Progress", field:"progress", sorter:"number", formatter:"progress"},
        {title:"Gender", field:"gender", sorter:"string"},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col", sorter:"string"},
        {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross", sorter:"boolean"},
        ],
    });

})
</script></article>

<a class="anchor" id="file-load"></a>
<article>
    <h1>Load Table Data From Local File<a class="doc-link" href="/docs/4.5/data#local"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>Data can be loaded into the table from a local file using the <span class='param'>setDataFromLocalFile</span> function.</p>

    <p>In the example below we also use the <span class='param'>autoColumns</span> feature to generate the column headers from the data as well, but you could just as easily predefine the columns</p>

    <p>To start this example <a href="/sample_data/file_load/data.json" download>download the sample table data json file to your local computer</a>.</p>

    <p>Then click the button below to load sample data file.</p>

    <div class="table-controls-legend">Table Controls</div>

<div class="table-controls">
      <button id="file-load-trigger">Open File</button>
</div>

<div class="example-table" id="example-table-file-load">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:311,
    layout:"fitColumns",
    autoColumns:true,
    placeholder:"Awaiting Data, Please Load File",
});

//trigger AJAX load on "Load Data via AJAX" button click
$("#file-load-trigger").click(function(){
    table.setDataFromLocalFile();
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("file-load", function(){
    var example_table_file_load = new Tabulator("#example-table-file-load", {
        height:311,
        layout:"fitColumns",
        autoColumns:true,
        placeholder:"Awaiting Data, Please Load File",
    });

    $("#file-load-trigger").click(function(){
        example_table_file_load.setDataFromLocalFile();
    })
})
</script></article>

<a class="anchor" id="table-load"></a>
<article>
    <h1>Create from HTML Table Element <a class="doc-link" href="/docs/4.5/data#table"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>
        It is possible to convert a standard HTML Table element into a tabulator, pulling all the data directly from the table into the tabulator when it is created.
    </p>
    <p>
        If you want to pull the column headers in from the table, you need to make sure that you have defiend a <span class='param'>thead</span> element with each column header in a <span class='param'>th</span> element. If you specify the <span class='param'>width</span> attribute on a header, then this will be set as the width of the column in the tabulator.
    </p>
    <p>
        You can set any of the standard Tabulator options when you create your table this way, so can easily convert old tables to take advantage of the many features Tabulator has to offer.
    </p>

    <h3>Standard HTML Table:</h3>
    <table id="plain-table" tabulator-layout="fitColumns" class="plain">
        <thead>
            <tr>
                <th width="200">Name</th>
                <th tabulator-align="center">Age</th>
                <th>Gender</th>
                <th>Height</th>
                <th width="150">Favourite Color</th>
                <th>Date of Birth</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Billy Bob</td>
                <td>12</td>
                <td>male</td>
                <td>1</td>
                <td>red</td>
                <td>22/04/1994</td>
            </tr>
            <tr>
                <td>Mary May</td>
                <td>1</td>
                <td>female</td>
                <td>2</td>
                <td>blue</td>
                <td>14/05/1982</td>
            </tr>
        </tbody>
    </table>

    <h3>Converted to Tabulator:</h3>

    <table id="example-table-table" tabulator-layout="fitColumns">
    <thead>
        <tr>
            <th width="200">Name</th>
            <th tabulator-align="center">Age</th>
            <th>Gender</th>
            <th>Height</th>
            <th width="150">Favourite Color</th>
            <th>Date of Birth</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Billy Bob</td>
            <td>12</td>
            <td>male</td>
            <td>1</td>
            <td>red</td>
            <td>22/04/1994</td>
        </tr>
        <tr>
            <td>Mary May</td>
            <td>1</td>
            <td>female</td>
            <td>2</td>
            <td>blue</td>
            <td>14/05/1982</td>
        </tr>
    </tbody>
</table>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;table id="example-table"&gt;
    &lt;thead&gt;
        &lt;tr&gt;
            &lt;th width="200"&gt;Name&lt;/th&gt;
            &lt;th tabulator-align="center"&gt;Age&lt;/th&gt;
            &lt;th&gt;Gender&lt;/th&gt;
            &lt;th&gt;Height&lt;/th&gt;
            &lt;th width="150"&gt;Favourite Color&lt;/th&gt;
            &lt;th&gt;Date of Birth&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody&gt;
        &lt;tr&gt;
            &lt;td&gt;Billy Bob&lt;/td&gt;
            &lt;td&gt;12&lt;/td&gt;
            &lt;td&gt;male&lt;/td&gt;
            &lt;td&gt;1&lt;/td&gt;
            &lt;td&gt;red&lt;/td&gt;
            &lt;td&gt;22/04/1994&lt;/td&gt;
        &lt;/tr&gt;
        &lt;tr&gt;
            &lt;td&gt;Mary May&lt;/td&gt;
            &lt;td&gt;1&lt;/td&gt;
            &lt;td&gt;female&lt;/td&gt;
            &lt;td&gt;2&lt;/td&gt;
            &lt;td&gt;blue&lt;/td&gt;
            &lt;td&gt;14/05/1982&lt;/td&gt;
        &lt;/tr&gt;
    &lt;/tbody&gt;
&lt;/table&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js"> var table = new Tabulator("#example-table", {});</pre>
</fieldset>

<script type="text/javascript">
     TableLoader.register("table-load", function(){
    var example_table_table = new Tabulator("#example-table-table");
})
</script></article>

<a class="anchor" id="reactivity"></a>
<article>
    <h1>Data Reactivity <a class="doc-link" href="/docs/4.5/reactivity"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>Data can be loaded into the table from a remote URL using a JSON formatted string.</p>

    <p>If you always request the same URL for your data then you can set it in the <span class='param'>ajaxURL</span> option when you create your Tabulator</p>

    <p>Click the button below to load sample data via AJAX.</p>

    <div class="table-controls-legend">Example Reactivity Controls</div>

<div class="table-controls">
  <button id="reactivity-add">Add New Row</button>
  <button id="reactivity-delete">Remove Row</button>
  <button id="reactivity-update">Update First Row Name</button>
</div>

<div class="example-table" id="example-table-reactivity">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//define data
var tabledata = [
    {id:1, name:"Oli Bob", progress:12, gender:"male", rating:1, col:"red" },
    {id:2, name:"Mary May", progress:1, gender:"female", rating:2, col:"blue" },
    {id:3, name:"Christine Lobowski", progress:42, gender:"female", rating:0, col:"green" },
    {id:4, name:"Brendon Philips", progress:100, gender:"male", rating:1, col:"orange" },
    {id:5, name:"Margret Marmajuke", progress:16, gender:"female", rating:5, col:"yellow"},
];

//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    reactiveData:true, //turn on data reactivity
    data:tabledata, //load data into table
    columns:[
        {title:"Name", field:"name", sorter:"string", width:200},
        {title:"Progress", field:"progress", sorter:"number", formatter:"progress"},
        {title:"Gender", field:"gender", sorter:"string"},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col", sorter:"string"},
    ],
});

//add row to bottom of table on button click
document.getElementById("reactivity-add").addEventListener("click", function(){
    tabledata.push({name:"IM A NEW ROW", progress:100, gender:"male"});
});

//remove bottom row from table on button click
document.getElementById("reactivity-delete").addEventListener("click", function(){
    tabledata.pop();
});

//update name on first row in table on button click
document.getElementById("reactivity-update").addEventListener("click", function(){
    tabledata[0].name = "IVE BEEN UPDATED";
});

</pre>
</fieldset>

<script type="text/javascript">


    TableLoader.register("reactivity", function(){

        var reactiveTableData = [
        {id:1, name:"Oli Bob", progress:12, gender:"male", rating:1, col:"red" },
        {id:2, name:"Mary May", progress:1, gender:"female", rating:2, col:"blue" },
        {id:3, name:"Christine Lobowski", progress:42, gender:"female", rating:0, col:"green" },
        {id:4, name:"Brendon Philips", progress:100, gender:"male", rating:1, col:"orange" },
        {id:5, name:"Margret Marmajuke", progress:16, gender:"female", rating:5, col:"yellow"},
        ];

        var example_table_reactivity = new Tabulator("#example-table-reactivity", {
            height:"311px",
            layout:"fitColumns",
            reactiveData:true,
            data:reactiveTableData,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:200},
            {title:"Progress", field:"progress", sorter:"number", formatter:"progress"},
            {title:"Gender", field:"gender", sorter:"string"},
            {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
            {title:"Favourite Color", field:"col", sorter:"string"},
            ],
        });

        $("#reactivity-add").click(function(){
            reactiveTableData.push({name:"IM A NEW ROW", progress:100, gender:"male"});
        });

        $("#reactivity-delete").click(function(){
            reactiveTableData.pop();
        });

        $("#reactivity-update").click(function(){
            reactiveTableData[0].name = "IVE BEEN UPDATED";
        });
    });
</script></article>

<a class="anchor" id="editable"></a>
<article>
    <h1>Editable Data <a class="doc-link" href="/docs/4.5/edit"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>
        Using the <span class='param'>editable</span> setting on each column, you can make a user editable table.
    </p>
    <p>
        Any time a cell is edited it triggers the <span class='param'>cellEdited</span> callback, to allow you to process any changes.
    </p>
    <p>
        You can call the <span class='param'>getData</span> method to get an array of all of the tables data, including any edits
    </p>

    <p>This table features a custom date editor on the <span class='param'>Date of Birth</span> column.</p>


    <div class="example-table" id="example-table-editable">
<div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<style type="text/css">
ul.ui-autocomplete{
    list-style-type: none !important;
    padding:0;
    margin:0;

    li{

    }
}
</style>

<button class="view-source">View Source</button>
<fieldset class="source">
<legend>Source Code</legend>
<h3>HTML</h3>
<pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

<h3>JavaScript</h3>
<pre class="prettyprint lang-js">//Create Date Editor
var dateEditor = function(cell, onRendered, success, cancel){
    //cell - the cell component for the editable cell
    //onRendered - function to call when the editor has been rendered
    //success - function to call to pass the successfuly updated value to Tabulator
    //cancel - function to call to abort the edit and return to a normal cell

    //create and style input
    var cellValue = moment(cell.getValue(), "DD/MM/YYYY").format("YYYY-MM-DD"),
    input = document.createElement("input");

    input.setAttribute("type", "date");

    input.style.padding = "4px";
    input.style.width = "100%";
    input.style.boxSizing = "border-box";

    input.value = cellValue;

    onRendered(function(){
        input.focus();
        input.style.height = "100%";
    });

    function onChange(){
        if(input.value != cellValue){
            success(moment(input.value, "YYYY-MM-DD").format("DD/MM/YYYY"));
        }else{
            cancel();
        }
    }

    //submit new value on blur or change
    input.addEventListener("blur", onChange);

    //submit new value on enter
    input.addEventListener("keydown", function(e){
        if(e.keyCode == 13){
            onChange();
        }

        if(e.keyCode == 27){
            cancel();
        }
    });

    return input;
};


//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    columns:[
        {title:"Name", field:"name", width:150, editor:"input"},
        {title:"Location", field:"location", width:130, editor:"autocomplete", editorParams:{allowEmpty:true, showListOnEmpty:true, values:true}},
        {title:"Progress", field:"progress", sorter:"number", align:"left", formatter:"progress", width:140, editor:true},
        {title:"Gender", field:"gender", editor:"select", editorParams:{values:{"male":"Male", "female":"Female", "unknown":"Unknown"}}},
        {title:"Rating", field:"rating",  formatter:"star", align:"center", width:100, editor:true},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date", width:140, editor:dateEditor},
        {title:"Driver", field:"car", align:"center", editor:true, formatter:"tickCross"},
    ],
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("editable", function(){

             //Editable Example
             //custom editor
             var dateEditor = function(cell, onRendered, success, cancel){
                //cell - the cell component for the editable cell
                //onRendered - function to call when the editor has been rendered
                //success - function to call to pass the successfuly updated value to Tabulator
                //cancel - function to call to abort the edit and return to a normal cell

                //create and style input
                var cellValue = moment(cell.getValue(), "DD/MM/YYYY").format("YYYY-MM-DD"),
                input = document.createElement("input");

                input.setAttribute("type", "date");

                input.style.padding = "4px";
                input.style.width = "100%";
                input.style.boxSizing = "border-box";

                input.value = cellValue;

                onRendered(function(){
                    input.focus();
                    input.style.height = "100%";
                });

                function onChange(){
                    if(input.value != cellValue){
                        success(moment(input.value, "YYYY-MM-DD").format("DD/MM/YYYY"));
                    }else{
                        cancel();
                    }
                }

                //submit new value on blur or change
                input.addEventListener("blur", onChange);

                //submit new value on enter
                input.addEventListener("keydown", function(e){
                    if(e.keyCode == 13){
                        onChange();
                    }

                    if(e.keyCode == 27){
                        cancel();
                    }
                });

                return input;
            };


        var example_table_editable = new Tabulator("#example-table-editable", {
            height:"311px",
            data:tabledata,
            columns:[
            {title:"Name", field:"name", width:150, editor:"input"},
            {title:"Location", field:"location", width:130, editor:"autocomplete", editorParams:{allowEmpty:true, showListOnEmpty:true, values:true}},
            {title:"Progress", field:"progress", sorter:"number", align:"left", formatter:"progress", width:140, editor:true},
            {title:"Gender", field:"gender", editor:"select", editorParams:{values:{"male":"Male", "female":"Female", "unknown":"Unknown"}}},
            {title:"Rating", field:"rating",  formatter:"star", align:"center", width:100, editor:true},
            {title:"Date Of Birth", field:"dob", align:"center", sorter:"date", width:140, editor:dateEditor},
            {title:"Driver", field:"car", align:"center", editor:true, formatter:"tickCross"},
            ],
            cellEdited:function(cell){

            },
        });
    })
</script></article>
<a class="anchor" id="validation"></a>
<article>
    <h1>Validate User Input <a class="doc-link" href="/docs/4.5/validate"><i class="fa fa-external-link"></i> Documentation</a></h1>

    <p>You can set validators on columns to ensure that any user input into your editable cells matches your requirements.</p>

    <p>Validators can be applied by using the <span class='param'>validator</span> property in a columns definition object.</p>

    <p>If the validation fails the <span class='param'>tabulator-validation-fail</span> class will be applied to the cell and the <span class='param'>validationFailed</span> callback will be triggered. The user will not be able to leave the cell until they input a valid value or cancel  the edit <i>(press escape)</i>.</p>

    <p>The table below has the following validators applied to its columns:
        <ul>
            <li><strong>Name</strong> - the field is required, it must have a value</li>
            <li><strong>Progress</strong> - minimum value of 0, maximum value of 100, must be a valid  number</li>
            <li><strong>Gender</strong> - value must be either "male" or "female" and is required</li>
            <li><strong>Rating</strong> - minimum value of 0, maximum value of 5, must be a valid integer</li>
            <li><strong>Favourite Colour</strong> - minimum string length of 3, maximum string length of 10, bust be a string not a number</li>
        </ul>
    </p>

    <div class="example-table" id="example-table-validation">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    columns:[
        {title:"Name", field:"name", width:150, editor:"input", validator:"required"},
        {title:"Progress", field:"progress", sorter:"number", align:"left", editor:"input", editor:true,  validator:["min:0", "max:100", "numeric"]},
        {title:"Gender", field:"gender", editor:"input", validator:["required", "in:male|female"]},
        {title:"Rating", field:"rating",  editor:"input", align:"center", width:100, editor:"input", validator:["min:0", "max:5", "integer"]},
        {title:"Favourite Color", field:"col", editor:"input", validator:["minLength:3", "maxLength:10", "string"]},
    ],
    validationFailed:function(cell, value, validators){
        //cell - cell component for the edited cell
        //value - the value that failed validation
        //validatiors - an array of validator objects that failed

        //take action on validation fail
    },
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("validation", function(){
    var example_table_validation = new Tabulator("#example-table-validation", {
        height:"311px",
        layout:"fitColumns",
        data:tabledata,
        columns:[
        {title:"Name", field:"name", width:150, editor:"input", validator:"required"},
        {title:"Progress", field:"progress", sorter:"number", align:"left", editor:"input", editor:true,  validator:["min:0", "max:100", "numeric"]},
        {title:"Gender", field:"gender", editor:"input", validator:["required", "in:male|female"]},
        {title:"Rating", field:"rating",  editor:"input", align:"center", width:100, editor:"input", validator:["min:0", "max:5", "integer"]},
        {title:"Favourite Color", field:"col", editor:"input", validator:["minLength:3", "maxLength:10", "string"]},
        ],
        validationFailed:function(cell, value, validators){

        },
    });
})
</script></article>

<a class="anchor" id="filter"></a>
<article>
    <h1>Filter Data <a class="doc-link" href="/docs/4.5/filter"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>Tabulator allows you to filter the table data by any field in the data set.</p>

    <p>To set a filter you need to call the <span class='param'>setFilter</span> method, passing the field you wish to filter, the comparison type and the value to filter for</p>

    <p>
        Tabulator comes with a number of filter comparison types including:
        <ul>
            <li><strong>=</strong> - Displays only rows with data that is the same as the filter</li>
            <li><strong>&lt;</strong> - displays rows with a value less than the filter value</li>
            <li><strong>&lt;=</strong> - displays rows with a value less than or qual to the filter value</li>
            <li><strong>&gt;</strong> - displays rows with a value greater than the filter value</li>
            <li><strong>&gt;=</strong> - displays rows with a value greater than or qual to the filter value</li>
            <li><strong>!=</strong> - displays rows with a value that is not equal to the filter value</li>
            <li><strong>like</strong> - displays any rows with data that contains the specified string anywhere in the specified field. (case insensitive)</li>
        </ul>
    </p>

    <p>

    <div class="table-controls-legend">Filter Parameters</div>

    <div class="table-controls">
        <span>
          <label>Field: </label>
          <select id="filter-field">
              <option></option>
              <option value="name">Name</option>
              <option value="progress">Progress</option>
              <option value="gender">Gender</option>
              <option value="rating">Rating</option>
              <option value="col">Favourite Colour</option>
              <option value="dob">Date Of Birth</option>
              <option value="car">Drives</option>
              <option value="function">Drives &amp;Rating &lt; 3</option>
          </select>
        </span>

        <span>
          <label>Type: </label>
          <select id="filter-type">
              <option value="=">=</option>
              <option value="<">&lt;</option>
              <option value="<=">&lt;=</option>
              <option value=">">&gt;</option>
              <option value=">=">&gt;=</option>
              <option value="!=">!=</option>
              <option value="like">like</option>
          </select>
        </span>

          <span><label>Value: </label> <input id="filter-value" type="text" placeholder="value to filter"></span>

          <button id="filter-clear">Clear Filter</button>
    </div>

</p>

<div class="example-table" id="example-table-filters">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Custom filter example
function customFilter(data){
    return data.car &amp;&amp; data.rating &lt; 3;
}

//Trigger setFilter function with correct parameters
function updateFilter(){

    var filter = $("#filter-field").val() == "function" ? customFilter : $("#filter-field").val();

    if($("#filter-field").val() == "function" ){
        $("#filter-type").prop("disabled", true);
        $("#filter-value").prop("disabled", true);
    }else{
        $("#filter-type").prop("disabled", false);
        $("#filter-value").prop("disabled", false);
    }

    table.setFilter(filter, $("#filter-type").val(), $("#filter-value").val());
}

//Update filters on value change
$("#filter-field, #filter-type").change(updateFilter);
$("#filter-value").keyup(updateFilter);

//Clear filters on "Clear Filters" button click
$("#filter-clear").click(function(){
    $("#filter-field").val("");
    $("#filter-type").val("=");
    $("#filter-value").val("");

    table.clearFilter();
});

//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    columns:[
        {title:"Name", field:"name", width:200},
        {title:"Progress", field:"progress", formatter:"progress", sorter:"number"},
        {title:"Gender", field:"gender"},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
    ],
});</pre>
</fieldset>

<script type="text/javascript">
  TableLoader.register("filter", function(){
       //Filtering Example
       function customFilter(data){
           return data.car && data.rating < 3;
       }

       function updateFilter(){

           var filter = $("#filter-field").val() == "function" ? customFilter : $("#filter-field").val();

           if($("#filter-field").val() == "function" ){
               $("#filter-type").prop("disabled", true);
               $("#filter-value").prop("disabled", true);
           }else{
               $("#filter-type").prop("disabled", false);
               $("#filter-value").prop("disabled", false);
           }

             if($("#filter-field").val()){

              example_table_filters.setFilter(filter, $("#filter-type").val(), $("#filter-value").val());
             }
       }

       $("#filter-field, #filter-type").change(updateFilter);
       $("#filter-value").keyup(updateFilter);

       $("#filter-clear").click(function(){
           $("#filter-field").val("");
           $("#filter-type").val("=");
           $("#filter-value").val("");

           example_table_filters.clearFilter();
       });



       var example_table_filters = new Tabulator("#example-table-filters", {
           height:"311px",
           data:tabledata,
           layout:"fitColumns",
           columns:[
           {title:"Name", field:"name", width:200},
           {title:"Progress", field:"progress", formatter:"progress", sorter:"number"},
           {title:"Gender", field:"gender"},
           {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
           {title:"Favourite Color", field:"col"},
           {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
           {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
           ],
       });
  })
</script></article>
<a class="anchor" id="filter-header"></a>
<article>
    <h1>Filter Data In Header<a class="doc-link" href="/docs/4.5/filter#header"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>By settting the <span class='param'>headerFilter</span> parameter for a column you can add column based filtering directly into your table.</p>

    <p>See the documentation for <a href="/docs/4.5/filter#header-filters">Header Filtering</a> for more information.</p>

    <div class="example-table" id="example-table-filters-header">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//custom max min header filter
var minMaxFilterEditor = function(cell, onRendered, success, cancel, editorParams){

    var end;

    var container = document.createElement("span");

    //create and style inputs
    var start = document.createElement("input");
    start.setAttribute("type", "number");
    start.setAttribute("placeholder", "Min");
    start.setAttribute("min", 0);
    start.setAttribute("max", 100);
    start.style.padding = "4px";
    start.style.width = "50%";
    start.style.boxSizing = "border-box";

    start.value = cell.getValue();

    function buildValues(){
        success({
            start:start.value,
            end:end.value,
        });
    }

    function keypress(e){
        if(e.keyCode == 13){
            buildValues();
        }

        if(e.keyCode == 27){
            cancel();
        }
    }

    end = start.cloneNode();
    end.setAttribute("placeholder", "Max");

    start.addEventListener("change", buildValues);
    start.addEventListener("blur", buildValues);
    start.addEventListener("keydown", keypress);

    end.addEventListener("change", buildValues);
    end.addEventListener("blur", buildValues);
    end.addEventListener("keydown", keypress);


    container.appendChild(start);
    container.appendChild(end);

    return container;
 }

//custom max min filter function
function minMaxFilterFunction(headerValue, rowValue, rowData, filterParams){
    //headerValue - the value of the header filter element
    //rowValue - the value of the column in this row
    //rowData - the data for the row being filtered
    //filterParams - params object passed to the headerFilterFuncParams property

        if(rowValue){
            if(headerValue.start != ""){
                if(headerValue.end != ""){
                    return rowValue >= headerValue.start && rowValue &lt;= headerValue.end;
                }else{
                    return rowValue >= headerValue.start;
                }
            }else{
                if(headerValue.end != ""){
                    return rowValue <= headerValue.end;
                }
            }
        }

    return false; //must return a boolean, true if it passes the filter.
}


var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    columns:[
        {title:"Name", field:"name", width:150, headerFilter:"input"},
        {title:"Progress", field:"progress", width:150, formatter:"progress", sorter:"number", headerFilter:minMaxFilterEditor, headerFilterFunc:minMaxFilterFunction},
        {title:"Gender", field:"gender", editor:"select", editorParams:{values:{"male":"Male", "female":"Female"}}, headerFilter:true, headerFilterParams:{values:{"male":"Male", "female":"Female", "":""}}},
        {title:"Rating", field:"rating", editor:"star", align:"center", width:100, headerFilter:"number", headerFilterPlaceholder:"at least...", headerFilterFunc:">="},
        {title:"Favourite Color", field:"col", editor:"input", headerFilter:"select", headerFilterParams:{values:true}},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date",  headerFilter:"input"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross",  headerFilter:"tickCross",  headerFilterParams:{"tristate":true},headerFilterEmptyCheck:function(value){return value === null}},
    ],
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("filter-header", function(){
             /////// filter data in column headers ///////

             //custom header filter
             var minMaxFilterEditor = function(cell, onRendered, success, cancel, editorParams){
                var end;

                var container = document.createElement("span");

                //create and style inputs
                var start = document.createElement("input");
                start.setAttribute("type", "number");
                start.setAttribute("placeholder", "Min");
                start.setAttribute("min", 0);
                start.setAttribute("max", 100);
                start.style.padding = "4px";
                start.style.width = "50%";
                start.style.boxSizing = "border-box";

                start.value = cell.getValue();

                function buildValues(){
                    success({
                        start:start.value,
                        end:end.value,
                    });
                }

                function keypress(e){
                    if(e.keyCode == 13){
                        buildValues();
                    }

                    if(e.keyCode == 27){
                        cancel();
                    }
                }

                end = start.cloneNode();
                end.setAttribute("placeholder", "Max");

                start.addEventListener("change", buildValues);
                start.addEventListener("blur", buildValues);
                start.addEventListener("keydown", keypress);

                end.addEventListener("change", buildValues);
                end.addEventListener("blur", buildValues);
                end.addEventListener("keydown", keypress);


                container.appendChild(start);
                container.appendChild(end);

                return container;
             }

             //custom filter function
             function minMaxFilterFunction(headerValue, rowValue, rowData, filterParams){
                 //headerValue - the value of the header filter element
                 //rowValue - the value of the column in this row
                 //rowData - the data for the row being filtered
                 //filterParams - params object passed to the headerFilterFuncParams property

                    if(rowValue){
                        if(headerValue.start != ""){
                            if(headerValue.end != ""){
                                return rowValue >= headerValue.start && rowValue <= headerValue.end;
                            }else{
                                return rowValue >= headerValue.start;
                            }
                        }else{
                            if(headerValue.end != ""){
                                return rowValue <= headerValue.end;
                            }
                        }
                    }

                 return false; //must return a boolean, true if it passes the filter.
             }

             var example_table_filters_header = new Tabulator("#example-table-filters-header", {
                 height:"311px",
                 data:tabledata,
                 layout:"fitColumns",
                 columns:[
                 {title:"Name", field:"name", width:150, headerFilter:"input"},
                 {title:"Progress", field:"progress", width:150, formatter:"progress", sorter:"number", headerFilter:minMaxFilterEditor, headerFilterFunc:minMaxFilterFunction},
                 {title:"Gender", field:"gender", editor:"select", editorParams:{values:{"male":"Male", "female":"Female"}}, headerFilter:true, headerFilterParams:{values:{"female":"Female", "male":"Male"}}},
                 {title:"Rating", field:"rating", editor:"star", align:"center", width:100, headerFilter:"number", headerFilterPlaceholder:"at least...", headerFilterFunc:">="},
                 {title:"Favourite Color", field:"col", editor:"input", headerFilter:"select", headerFilterParams:{values:true}},
                 {title:"Date Of Birth", field:"dob", align:"center", sorter:"date",  headerFilter:"input"},
                 {title:"Driver", field:"car", align:"center", formatter:"tickCross",  headerFilter:"tickCross",  headerFilterParams:{"tristate":true},headerFilterEmptyCheck:function(value){return value === null}},
                 ],
             });
    })
</script></article>
<a class="anchor" id="sorters"></a>
<article>
    <h1>Sorters <a class="doc-link" href="/docs/4.5/sort"><i class="fa fa-external-link"></i> Documentation</a></h1>

    <p>By default Tabulator will attempt to guess which sorter should be applied to a column based on the data contained in the first row. It can determine sorters for strings, numbers, alphanumeric sequences and booleans, anything else will be treated as a string.</p>

    <ul>
        <li><strong>string</strong> - sorts column as strings of characters</li>
        <li><strong>number</strong> - sorts column as numbers (integer or float, will also handle numbers using "," separators)</li>
        <li><strong>alphanum</strong> - sorts column as alpha numeric code</li>
        <li><strong>boolean</strong> - sorts column as booleans</li>
        <li><strong>date</strong> - sorts column as dates</li>
        <li><strong>time</strong> - sorts column as times</li>
    </ul>

</p>

<p>To specify a sorter to be used on a column use the <span class='param'>param</span> property in the columns definition object</p>

<p>You can define a custom sorter functions in the sorter option if you need bespoke sorting functionality.</p>

<p>You can programmatically trigger a sort using the <span class='param'>sort</span> function.</p>

<p>Clicking on a column header will also trigger a sort of that column. You can sort by multiple columns by holding the <span class='param'>ctrl</span> or <span class='param'>shift</span> key when clicking on column headers.</p>

<div class="table-controls-legend">Programmatic Sort Parameters</div>

<div class="table-controls">
      <span>
       <label>Field: </label>
       <select id="sort-field">
          <option value="name" selected>Name</option>
          <option value="progress">Progress</option>
          <option value="gender">Gender</option>
          <option value="rating">Rating</option>
          <option value="col">Favourite Colour</option>
          <option value="dob">Date Of Birth</option>
          <option value="car">Driver</option>
      </select>
      </span>

    <span>
      <label>Direction:</label>
      <select id="sort-direction">
          <option value="asc" selected>asc</option>
          <option value="desc">desc</option>
      </select>
    </span>


      <button id="sort-trigger">Trigger Sort</button>
</div>


<div class="example-table" id="example-table-sorting">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    columns:[
        {title:"Name", field:"name", width:200},
        {title:"Progress", field:"progress", align:"right", headerSortTristate:true},
        {title:"Gender", field:"gender", sorter:"string"},
        {title:"Rating", field:"rating",  align:"center", width:100},
        {title:"Favourite Color", field:"col", sorter:function(a,b){
            return String(a).toLowerCase().localeCompare(String(b).toLowerCase());
        }},
        {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
        {title:"Driver", field:"car", align:"center", sorter:"boolean"},
    ],
});

//Trigger sort when "Trigger Sort" button is clicked
$("#sort-trigger").click(function(){
   table.setSort($("#sort-field").val(), $("#sort-direction").val());
});</pre>
</fieldset>

<script type="text/javascript">
  TableLoader.register("sorters", function(){

   var example_table_sorting = new Tabulator("#example-table-sorting", {
     height:"311px",
     data:tabledata,
     layout:"fitColumns",
     columns:[
     {title:"Name", field:"name", width:200},
     {title:"Progress", field:"progress", align:"right", headerSortTristate:true},
     {title:"Gender", field:"gender", sorter:"string"},
     {title:"Rating", field:"rating",  align:"center", width:100},
     {title:"Favourite Color", field:"col", sorter:function(a,b){
       return String(a).toLowerCase().localeCompare(String(b).toLowerCase());
     }},
     {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
     {title:"Driver", field:"car", align:"center", sorter:"boolean"},
     ],
   });

   $("#sort-trigger").click(function(){
     example_table_sorting.setSort($("#sort-field").val(), $("#sort-direction").val());
   })
  })
</script></article>
<a class="anchor" id="grouping"></a>
<article>
    <h1>Grouping Data <a class="doc-link" href="/docs/4.5/group"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>You can group rows together using the <span class='param'>groupBy</span> option. To group by a field, set this option to the name of the field.</p>
    <p>To group by more complex operations you should pass a function that returns a string that represents the group.</p>

    <div class="example-table" id="example-table-grouping">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    movableRows:true,
    groupBy:"gender",
    columns:[
        {title:"Name", field:"name", width:200},
        {title:"Progress", field:"progress", formatter:"progress", sorter:"number"},
        {title:"Gender", field:"gender"},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
    ],
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("grouping", function(){
     var example_table_grouping = new Tabulator("#example-table-grouping", {
         height:"311px",
         data:tabledata,
         layout:"fitColumns",
         movableRows:true,
         groupBy:"gender",
         columns:[
         {title:"Name", field:"name", width:200},
         {title:"Progress", field:"progress", formatter:"progress", sorter:"number"},
         {title:"Gender", field:"gender"},
         {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
         {title:"Favourite Color", field:"col"},
         {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
         {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
         ],
     });
 })
</script></article>

<a class="anchor" id="pagination"></a>
<article>
    <h1>Pagination <a class="doc-link" href="/docs/4.5/page"><i class="fa fa-external-link"></i> Documentation</a></h1>

    <p>Tabulator allows you to paginate your data. simply set the <span class='param'>pagination</span> property to true.</p>

    <p>If you have set the height of the table then the data will be automatically paginated to fit within the table.</p>

    <p>If you wish to define how many rows should be shown on a page, set this in the <span class='param'>paginationSize</span> property. If you set the paginationSize without setting the height, the Tabulator will automatically resize to fit the data</p>

    <div class="example-table" id="example-table-pagination">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"292px",
    layout:"fitColumns",
    pagination:"local",
    paginationSize:6,
    paginationSizeSelector:[3, 6, 8, 10],
    movableColumns:true,
    columns:[
        {title:"Name", field:"name", width:200},
        {title:"Progress", field:"progress", formatter:"progress", sorter:"number"},
        {title:"Gender", field:"gender"},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
    ],
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("pagination", function(){
    var example_table_pagination = new Tabulator("#example-table-pagination", {
        height:"292px",
        layout:"fitColumns",
        data:tabledata,
        pagination:"local",
        paginationSize:6,
        paginationSizeSelector:[3, 6, 8, 10],
        columns:[
        {title:"Name", field:"name", width:200},
        {title:"Progress", field:"progress", formatter:"progress", sorter:"number"},
        {title:"Gender", field:"gender"},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
        ],
    });
})
</script></article>


<a class="anchor" id="selectable"></a>
<article>
    <h1>Selectable Rows <a class="doc-link" href="/docs/4.5/select"><i class="fa fa-external-link"></i> Documentation</a></h1>

    <p>Using the <span class='param'>selectable</span> option, you can allow users to select rows in the table via a number of different routes:
       <ul>
           <li>
              Clicking on a row, to toggle its state.
          </li>
          <li>
              Holding down the shift key and click dragging over a number of rows to toggle the state of all rows the cursor passes over.
          </li>
          <li>
              Programmatically with the <span class='param'>selectRow</span> and <span class='param'>deselectRow</span> functions.
          </li>
      </ul></p>
      <div class="table-controls-legend">Selection Controls</div>

<div class="table-controls">
      <button id="select-row">Select "Oli Bob"</button>
      <button id="deselect-row">Deselect "Oli Bob"</button>
      <button id="select-all">Select All</button>
      <button id="deselect-all">Deselect All</button>

      <span id="select-stats" style="margin:20px 20px 0 20px; font-size: 1em;"><strong>Selected: <span class="highlight">0</span></strong></span>
</div>

<div class="example-table" id="example-table-selectable">
  <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
  <legend>Source Code</legend>
  <h3>HTML</h3>
  <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

  <h3>JavaScript</h3>
  <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    selectable:true, //make rows selectable
    columns:[
	    {title:"Name", field:"name", width:200},
	    {title:"Progress", field:"progress", width:100, align:"right", sorter:"number"},
	    {title:"Gender", field:"gender", width:100},
	    {title:"Rating", field:"rating", align:"center", width:80},
	    {title:"Favourite Color", field:"col"},
	    {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
	    {title:"Driver", field:"car", align:"center", width:100},
    ],
    rowSelectionChanged:function(data, rows){
        //update selected row counter on selection change
    	$("#select-stats span").text(data.length);
    },
});

//select row on "select" button click
$("#select-row").click(function(){
    table.selectRow(1);
});

//deselect row on "deselect" button click
$("#deselect-row").click(function(){
    table.deselectRow(1);
});

//select row on "select all" button click
$("#select-all").click(function(){
    table.selectRow();
});

//deselect row on "deselect all" button click
$("#deselect-all").click(function(){
    table.deselectRow();
});</pre>

</fieldset>

<script type="text/javascript">
  TableLoader.register("selectable", function(){
    $("#select-row").click(function(){
        example_table_selectable.selectRow(1);
    })

    $("#deselect-row").click(function(){
        example_table_selectable.deselectRow(1);
    })

    $("#select-all").click(function(){
        example_table_selectable.selectRow();
    })

    $("#deselect-all").click(function(){
        example_table_selectable.deselectRow();
    })

    var example_table_selectable = new Tabulator("#example-table-selectable", {
        height:"311px",
        data:tabledata,
        selectable:true,
        columns:[
        {title:"Name", field:"name", width:200},
        {title:"Progress", field:"progress", width:100, align:"right", sorter:"number"},
        {title:"Gender", field:"gender", width:100},
        {title:"Rating", field:"rating", align:"center", width:80},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", width:100},
        ],
        rowSelectionChanged:function(data, rows){
          $("#select-stats span").text(data.length);
        },
    });
  })
</script>  </article>

  <a class="anchor" id="selectable-tick"></a>
  <article>
      <h1>Selectable Rows With Tickbox <a class="doc-link" href="/docs/4.5/select"><i class="fa fa-external-link"></i> Documentation</a></h1>

      <p>Using the <span class='param'>rowSelection</span> formatter you can create a table with rows selectable using a tickbox. The tickbox in the column header allows for toggling the selection of all rows in the table.</p>

        <div class="example-table" id="example-table-selectable-tick">
  <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
  <legend>Source Code</legend>
  <h3>HTML</h3>
  <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

  <h3>JavaScript</h3>
  <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    columns:[
      {formatter:"rowSelection", titleFormatter:"rowSelection", align:"center", headerSort:false, cellClick:function(e, cell){
        cell.getRow().toggleSelect();
      }},
      {title:"Name", field:"name", width:200},
      {title:"Progress", field:"progress", width:100, align:"right", sorter:"number"},
      {title:"Gender", field:"gender", width:100},
      {title:"Rating", field:"rating", align:"center", width:80},
      {title:"Favourite Color", field:"col"},
      {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
      {title:"Driver", field:"car", align:"center", width:100},
    ],
});
</pre>

</fieldset>

<script type="text/javascript">
  TableLoader.register("selectable-tick", function(){
    var example_table_selectable_tick = new Tabulator("#example-table-selectable-tick", {
        height:"311px",
        data:tabledata,
        columns:[
        {formatter:"rowSelection", titleFormatter:"rowSelection", align:"center", headerSort:false, cellClick:function(e, cell){
          cell.getRow().toggleSelect();
        }},
        {title:"Name", field:"name", width:200},
        {title:"Progress", field:"progress", width:100, align:"right", sorter:"number"},
        {title:"Gender", field:"gender", width:100},
        {title:"Rating", field:"rating", align:"center", width:80},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", width:100},
        ],
        rowSelectionChanged:function(data, rows){
          $("#select-stats span").text(data.length);
        },
    });
  })
</script>    </article>


  <a class="anchor" id="adddel"></a>
  <article>
    <h1>Add / Delete Rows <a class="doc-link" href="/docs/4.5/update#row"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>
        Tablulator allows you to add new rows, delete existing rows and cleat all table data with ease.
    </p>

    <div class="table-controls-legend">Row Controls</div>

<div class="table-controls">
      <button id="add-row">Add Blank Row to bottom</button>
      <button id="del-row">Remove Row "Oli Bob"</button>
      <button id="clear">Empty the table</button>
      <button id="reset">Reset</button>
</div>

<div class="example-table" id="example-table-adddel">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    addRowPos:"bottom",
    columns:[
        {title:"Name", field:"name", width:200, editor:"input"},
        {title:"Progress", field:"progress", width:100, align:"right", sorter:"number", editor:"input"},
        {title:"Gender", field:"gender", editor:"input"},
        {title:"Rating", field:"rating", align:"center", width:80, editor:"input"},
        {title:"Favourite Color", field:"col", editor:"input"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date", editor:"input"},
        {title:"Driver", field:"car", align:"center", editor:"input"},
    ],
});

//Add row on "Add Row" button click
$("#add-row").click(function(){
    table.addRow({});
});

//Delete row on "Delete Row" button click
$("#del-row").click(function(){
    table.deleteRow(1);
});

//Clear table on "Empty the table" button click
$("#clear").click(function(){
    table.clearData()
});

//Reset table contents on "Reset the table" button click
$("#reset").click(function(){
    table.setData(tabledata);
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("adddel", function(){
        $("#add-row").click(function(){
            example_table_adddel.addRow({});
        })

        $("#del-row").click(function(){
            example_table_adddel.deleteRow(1);
        })

        $("#clear").click(function(){
            example_table_adddel.clearData();
        })

        $("#reset").click(function(){
            example_table_adddel.setData(tabledata);
        })

        var example_table_adddel = new Tabulator("#example-table-adddel", {
            height:"311px",
            data:tabledata,
            addRowPos:"bottom",
            columns:[
            {title:"Name", field:"name", width:200, editor:"input"},
            {title:"Progress", field:"progress", width:100, align:"right", sorter:"number", editor:"input"},
            {title:"Gender", field:"gender", editor:"input"},
            {title:"Rating", field:"rating", align:"center", width:80, editor:"input"},
            {title:"Favourite Color", field:"col", editor:"input"},
            {title:"Date Of Birth", field:"dob", align:"center", sorter:"date", editor:"input"},
            {title:"Driver", field:"car", align:"center", editor:"input"},
            ],
            cellEdited:function(cell){

            },
        });
    })
</script></article>
<a class="anchor" id="movable"></a>
<article>
    <h1>Movable Rows <a class="doc-link" href="/docs/4.5/move"><i class="fa fa-external-link"></i> Documentation</a></h1>

    <p>Using the <span class='param'>movableRows</span> property you can allow the user to move rows around the table by clicking and dragging.</p>

    <p>By default this allows the user to drag anywhere on the row, in this example we use the <span class='param'>rowHandle</span> property in a column definition to create a row handle that can be used for dragging rows.</p>

    <div class="example-table" id="example-table-movable-rows">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">var table = new Tabulator("#example-table", {
    height:"311px",
    movableRows:true,
    columns:[
        {rowHandle:true, formatter:"handle", headerSort:false, frozen:true, width:30, minWidth:30},
        {title:"Name", field:"name", width:150},
        {title:"Progress", field:"progress", formatter:"progress", sorter:"number"},
        {title:"Gender", field:"gender"},
        {title:"Rating", field:"rating", formatter:"star", formatterParams:{stars:6}, align:"center", width:120},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
    ],
    rowMoved:function(row){
        console.log("Row: " + row.getData().name + " has been moved");
    }
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("movable", function(){
    var example_table_movable_rows = new Tabulator("#example-table-movable-rows", {
        height:"311px",
        data:tabledata,
        movableRows:true,
        columns:[
        {rowHandle:true, formatter:"handle", headerSort:false, frozen:true, width:30, minWidth:30},
        {title:"Name", field:"name", width:150},
        {title:"Progress", field:"progress", formatter:"progress", sorter:"number"},
        {title:"Gender", field:"gender"},
        {title:"Rating", field:"rating", formatter:"star", formatterParams:{stars:6}, align:"center", width:120},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
        ],
        rowMoved:function(row){
            console.log("Row: " + row.getData().name + " has been moved");
        },
    });
})
</script></article>
<a class="anchor" id="movable-groups"></a>
<article>
    <h1>Movable Rows With Row Groups<a class="doc-link" href="/docs/4.5/move"><i class="fa fa-external-link"></i> Documentation</a></h1>

    <p>By using the <span class='param'>groupValues</span> property to define a series of groups, you can create a table that allows users to drag rows between groups, including empty groups.</p>

    <div class="example-table" id="example-table-movable-rows-groups">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">var table = new Tabulator("#example-table", {
    height:"311px",
    movableRows:true,
    groupBy:"col",
    groupValues:[["green", "blue", "purple"]]
    columns:[
        {rowHandle:true, formatter:"handle", headerSort:false, frozen:true, width:30, minWidth:30},
        {title:"Name", field:"name", width:150},
        {title:"Progress", field:"progress", formatter:"progress", sorter:"number"},
        {title:"Gender", field:"gender"},
        {title:"Rating", field:"rating", formatter:"star", formatterParams:{stars:6}, align:"center", width:120},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
    ],
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("movable-groups", function(){
    var example_table_movable_rows_groups = new Tabulator("#example-table-movable-rows-groups", {
        height:"311px",
        data:tabledata,
        movableRows:true,
        groupBy:"col",
        groupValues:[["green", "blue", "purple"]],
        columns:[
        {rowHandle:true, formatter:"handle", headerSort:false, frozen:true, width:30, minWidth:30},
        {title:"Name", field:"name", width:150},
        {title:"Progress", field:"progress", formatter:"progress", sorter:"number"},
        {title:"Gender", field:"gender"},
        {title:"Rating", field:"rating", formatter:"star", formatterParams:{stars:6}, align:"center", width:120},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
        ],
    });
})
</script></article>
<a class="anchor" id="movable-between-tables"></a>
<article>
    <h1>Movable Rows Between Tables<a class="doc-link" href="/docs/4.5/move#rows-table"><i class="fa fa-external-link"></i> Documentation</a></h1>

    <p>Using the <span class='param'>movableRowsConnectedTables</span> property you can set the tables that can receive rows from another table.</p>

    <p>In the example below, try dragging rows from the left table to the right table.</p>

    <style type="text/css">
	#movable-between-tables-holder{
	    text-align: center;
	}

	#example-table-movable-rows-between-tables2{
	    margin-left:40px;
	}
</style>

<div id="movable-between-tables-holder">
<div class="example-table intertable" id="example-table-movable-rows-between-tables1">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
<div class="example-table intertable" id="example-table-movable-rows-between-tables2">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Table to move rows from
var table = new Tabulator("#example-table-sender", {{
    height:311,
    layout:"fitColumns",
    movableRows:true,
    movableRowsConnectedTables:"#example-table-receiver",
    movableRowsReceiver: "add",
    movableRowsSender: "delete",
    placeholder:"All Rows Moved",
    data:tabledata,
    columns:[
        {title:"Name", field:"name"},
    ],
});

//Table to move rows to
var table = new Tabulator("#example-table-receiver", {
    height:311,
    layout:"fitColumns",
    placeholder:"Drag Rows Here",
    data:[],
    columns:[
        {title:"Name", field:"name"},
    ],
});</pre>
</fieldset>

<script type="text/javascript">
	TableLoader.register("move-between-tables", function(){
		//Movable Rows From Table
		var example_table_movable_rows_between_tables1 = new Tabulator("#example-table-movable-rows-between-tables1", {
		    height:311,
		    layout:"fitColumns",
		    movableRows:true,
		    movableRowsConnectedTables:"#example-table-movable-rows-between-tables2",
		    movableRowsReceiver: "add",
		    movableRowsSender: "delete",
		    placeholder:"All Rows Moved",
		    data:tabledata,
		    columns:[
		    {title:"Name", field:"name"},
		    ],
		});

		//Movable Rows To Table
		var example_table_movable_rows_between_tables2 = new Tabulator("#example-table-movable-rows-between-tables2", {
		    height:311,
		    layout:"fitColumns",
		    placeholder:"Drag Rows Here",
		    data:[],
		    columns:[
		    {title:"Name", field:"name"},
		    ],
		});

	})
</script></article>
<a class="anchor" id="download"></a>
<article>
    <h1>Download Table Data<a class="doc-link" href="/docs/4.5/download"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>Tabulator allows you to download the table data as a file directly from your browser, no server needed.</p>

    <p>The download will contain the text values of all data currently visible in the table, matching the current column layout, column titles, sorting and filtering.</p>

    <div class="table-controls-legend">Download Controls</div>

<div class="table-controls">
      <button id="download-csv">Download CSV</button>
      <button id="download-json">Download JSON</button>
      <button id="download-xlsx">Download XLSX</button>
      <button id="download-pdf">Download PDF</button>
      <button id="download-html">Download HTML</button>
</div>

<div class="example-table" id="example-table-download">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>

    <h3>XLSX Script Includes</h3>
    <pre class="prettyprint lang-html">&lt;script type="text/javascript" src="https://oss.sheetjs.com/sheetjs/xlsx.full.min.js"&gt;&lt;/script&gt;</pre>

    <h3>PDF Script Includes</h3>
    <pre class="prettyprint lang-html">&lt;script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"&gt;&lt;/script&gt;
&lt;script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.5/jspdf.plugin.autotable.js"&gt;&lt;/script&gt;</pre>

    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>
    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    columns:[
        {title:"Name", field:"name", width:200},
        {title:"Progress", field:"progress", width:100, sorter:"number"},
        {title:"Gender", field:"gender"},
        {title:"Rating", field:"rating", width:80},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
    ],
});

//trigger download of data.csv file
$("#download-csv").click(function(){
    table.download("csv", "data.csv");
});

//trigger download of data.json file
$("#download-json").click(function(){
    table.download("json", "data.json");
});

//trigger download of data.xlsx file
$("#download-xlsx").click(function(){
    table.download("xlsx", "data.xlsx", {sheetName:"My Data"});
});

//trigger download of data.pdf file
$("#download-pdf").click(function(){
    table.download("pdf", "data.pdf", {
        orientation:"portrait", //set page orientation to portrait
        title:"Example Report", //add title to report
    });
});

//trigger download of data.html file
$("#download-html").click(function(){
    table.download("html", "data.html", {style:true});
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("download", function(){
       $("#download-csv").click(function(){
           example_table_download.download("csv", "data.csv");
       })

       $("#download-json").click(function(){
           example_table_download.download("json", "data.json");
       });

       $("#download-xlsx").click(function(){
           example_table_download.download("xlsx", "data.xlsx");
       });

       $("#download-pdf").click(function(){
        example_table_download.download("pdf", "data.pdf", {
            orientation:"portrait",
            title:"Dynamics Quotation Report",
        });

        $("#download-html").click(function(){
            example_table_download.download("html", "data.html", {style:true});
        });
    });

       var example_table_download = new Tabulator("#example-table-download", {
           height:"311px",
           data:tabledata,
           columns:[
           {title:"Name", field:"name", width:200},
           {title:"Progress", field:"progress", width:100, sorter:"number"},
           {title:"Gender", field:"gender"},
           {title:"Rating", field:"rating", width:80},
           {title:"Favourite Color", field:"col"},
           {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
           {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
           ],
       });
   })
</script></article>

<a class="anchor" id="clipboard"></a>
<article>
    <h1>Clipboard<a class="doc-link" href="/docs/4.5/clipboard"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>Using the <span class='param'>clipboard</span> option, you can allow users to copy and paste from your table</p>

    <p>In the example below, try clciking anywhere in the table then using the <span class='param'>ctrl + c</span> key combination to copy the table, then pase into any spreadsheet application like Excel or Google sheets.</p>

    <p>Then try changing that data, copying it then pasting it back into this table with the<span class='param'>ctrl + v</span> key combination. You should see it replace the existing table data with your updated data set.</p>

    <div class="example-table" id="example-table-clipboard">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
     height:"311px",
     data:tabledata,
     clipboard:true,
     clipboardPasteAction:"replace",
     columns:[
         {title:"Name", field:"name", width:200},
         {title:"Progress", field:"progress", width:100, sorter:"number"},
         {title:"Gender", field:"gender"},
         {title:"Rating", field:"rating", width:80},
         {title:"Favourite Color", field:"col"},
         {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
         {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
     ],
 });</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("clipboard", function(){
        var example_table_clipboard = new Tabulator("#example-table-clipboard", {
            height:"311px",
            data:tabledata,
            clipboard:true,
            clipboardPasteAction:"replace",
            columns:[
            {title:"Name", field:"name", width:200},
            {title:"Progress", field:"progress", width:100, sorter:"number"},
            {title:"Gender", field:"gender"},
            {title:"Rating", field:"rating", width:80},
            {title:"Favourite Color", field:"col"},
            {title:"Date Of Birth", field:"dob", align:"center", sorter:"date"},
            {title:"Driver", field:"car", align:"center", formatter:"tickCross"},
            ],
        });
    })
</script></article>


<a class="anchor" id="history"></a>
<article>
    <h1>Interaction History <a class="doc-link" href="/docs/4.5/history"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>
        By setting the <span class='param'>history</span> option to <span class='param'>true</span>, you can make the table track any user changes to the table.
    </p>
    <p>
        You can use the <span class='param'>undo</span> and <span class='param'>redo</span> functions to move through the users interaction history, undoing cell edits, row additions or deletions.
    </p>
    <p>
     As long as the table is in focus (but not being edited) you can also use the <span class='param'>ctrl + z</span> and <span class='param'>ctrl + y</span> keyboard shortcuts to undo and redo actions.
 </p>

 <p>The example below has an editable names column, try making some changes to soe of the names and then use the history functions to undo and redo the changes.</p>

 <div class="table-controls-legend">History Controls</div>

<div class="table-controls">
      <button id="history-undo">Undo Edit</button>
      <button id="history-redo">Redo Edit</button>
      <span id="history-msg" style="margin-left:10px; font-weight:bold;"></span>
</div>

<div class="example-table" id="example-table-history">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    history:true,
    columns:[
    {title:"Name", field:"name", width:200, editor:"input"},
    {title:"Progress", field:"progress", align:"right", editor:"input"},
    {title:"Gender", field:"gender", editor:"input"},
    {title:"Rating", field:"rating",  align:"center", width:100},
    {title:"Favourite Color", field:"col"},
    {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
    {title:"Driver", field:"car", align:"center", sorter:"boolean"},
    ],
});

//undo button
$("#history-undo").on("click", function(){
  table.undo();
});

//redo button
$("#history-redo").on("click", function(){
   table.redo();
});
</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("history", function(){
        //history Examples
        var example_table_history = new Tabulator("#example-table-history", {
            height:"311px",
            data:tabledata,
            layout:"fitColumns",
            history:true,
            columns:[
            {title:"Name", field:"name", width:200, editor:"input"},
            {title:"Progress", field:"progress", align:"right", editor:"input"},
            {title:"Gender", field:"gender", editor:"input"},
            {title:"Rating", field:"rating",  align:"center", width:100},
            {title:"Favourite Color", field:"col"},
            {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
            {title:"Driver", field:"car", align:"center", sorter:"boolean"},
            ],
        });

        var msgResetTimer = null;

        $("#history-undo").on("click", function(){
           $("#history-msg").text("");

           if(!example_table_history.undo()){
               clearTimeout(msgResetTimer);

               $("#history-msg").text("No edits left to undo!");

               msgResetTimer = setTimeout(function(){
                   $("#history-msg").text("");
               }, 2000);
           }
        });

        $("#history-redo").on("click", function(){

           $("#history-msg").text("");

            if(!example_table_history.redo()){
                clearTimeout(msgResetTimer);

                $("#history-msg").text("No more edits left to redo!");

                msgResetTimer = setTimeout(function(){
                    $("#history-msg").text("");
                }, 2000);
            }
        });
    })
</script></article>


<a class="anchor" id="print"></a>
<article>
    <h1>Printing <a class="doc-link" href="/docs/4.5/print"><i class="fa fa-external-link"></i> Documentation</a></h1>

 <p>Tabulator provides a range of options for handling styling of table output when printing</p>

 <p>The example below is set to provide a style HTML table when printed and also ass a button for a fullscreen printout of the table</p>

 <div class="table-controls-legend">Print Controls</div>

<div class="table-controls">
      <button id="print-table">Print Table</button>
</div>

<div class="example-table" id="example-table-print">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>CSS</h3>
      <pre class="prettyprint lang-css">/*Horizontally center header and footer*/
.tabulator-print-header, tabulator-print-footer{
    text-align:center;
}</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    printAsHtml:true,
    printHeader:"&lt;h1&gt;Example Table Header&lt;h1&gt;",
    printFooter:"&lt;h2&gt;Example Table Footer&lt;h2&gt;",
    columns:[
    {title:"Name", field:"name", width:200, editor:"input"},
    {title:"Progress", field:"progress", align:"right", editor:"input"},
    {title:"Gender", field:"gender", editor:"input"},
    {title:"Rating", field:"rating",  align:"center", width:100},
    {title:"Favourite Color", field:"col"},
    {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
    {title:"Driver", field:"car", align:"center", sorter:"boolean"},
    ],
});

//print button
$("#print-table").on("click", function(){
   table.print(false, true);
});
</pre>
</fieldset>

<style type="text/css">
    .tabulator-print-header{
        text-align:center;
    }

    .tabulator-print-footer{
        text-align:center;
    }

    .tabulator-print-table thead th{
        background:#000 !important;
        color:#fff !important;
    }

    .tabulator-print-table thead{
        border-bottom:3px solid #3FB449 !important;
    }

   /* .tabulator-print-table, .tabulator-print-table tr .tabulator-print-table tr tr:last-of-type{
        border-right:none !important;
    }*/

    .tabulator-print-table{
        border-left:1px solid #000 !important;
    }

</style>

<script type="text/javascript">
    TableLoader.register("print", function(){
        //print Examples
        var example_table_print = new Tabulator("#example-table-print", {
            height:"311px",
            data:tabledata,
            layout:"fitColumns",
            printAsHtml:true,
            printHeader:"<h1>Example Table Header<h1>",
            printFooter:"<h2>Example Table Footer<h2>",
            columns:[
            {title:"Name", field:"name", width:200, editor:"input"},
            {title:"Progress", field:"progress", align:"right", editor:"input"},
            {title:"Gender", field:"gender", editor:"input"},
            {title:"Rating", field:"rating",  align:"center", width:100},
            {title:"Favourite Color", field:"col"},
            {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
            {title:"Driver", field:"car", align:"center", sorter:"boolean"},
            ],
        });

        $("#print-table").on("click", function(){
            example_table_print.print(false, true);
        });
    });
</script></article>


<a class="anchor" id="localization"></a>
<article>
    <h1>Localization <a class="doc-link" href="/docs/4.5/localize"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>
        You can localize the content of your tables to meet the needs of your regional users. Any number of language options can be configured for column headers and pagination controls.
    </p>

    <div class="table-controls-legend">Language Controls</div>

<div class="table-controls">
      <button id="lang-french">French</button>
      <button id="lang-german">German</button>
      <button id="lang-default">Default (English)</button>
</div>

<div class="example-table" id="example-table-localization">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>
    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">//Build Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    pagination:"local",
    langs:{
        "fr-fr":{ //French language definition
            "columns":{
                "name":"Nom",
                "progress":"Progression",
                "gender":"Genre",
                "rating":"Évaluation",
                "col":"Couleur",
                "dob":"Date de Naissance",
            },
            "pagination":{
                "first":"Premier",
                "first_title":"Première Page",
                "last":"Dernier",
                "last_title":"Dernière Page",
                "prev":"Précédent",
                "prev_title":"Page Précédente",
                "next":"Suivant",
                "next_title":"Page Suivante",
            },
        },
        "de-de":{ //German language definition
            "columns":{
                "name":"Name",
                "progress":"Fortschritt",
                "gender":"Genre",
                "rating":"Geschlecht",
                "col":"Farbe",
                "dob":"Geburtsdatum",
            },
            "pagination":{
                "first":"Zuerst",
                "first_title":"Zuerst Seite",
                "last":"Last",
                "last_title":"Letzte Seite",
                "prev":"Zurück",
                "prev_title":"Zurück Seite",
                "next":"Nächster",
                "next_title":"Nächster Seite",
            },
        },
    },
    columns:[
        {title:"Name", field:"name"},
        {title:"Progress", field:"progress", sorter:"number"},
        {title:"Gender", field:"gender"},
        {title:"Rating", field:"rating"},
        {title:"Favourite Color", field:"col"},
        {title:"Date Of Birth", field:"dob"},
    ],
});

//set locale to French
$("#lang-french").click(function(){
    table.setLocale("fr-fr");
});

//set locale to German
$("#lang-german").click(function(){
    table.setLocale("de-de");
});

//set default locale
$("#lang-default").click(function(){
    table.setLocale("");
});</pre>
</fieldset>

<script type="text/javascript">
   TableLoader.register("localization", function(){
        $("#lang-french").click(function(){
            example_table_localization.setLocale("fr-fr");
        })

        $("#lang-german").click(function(){
            example_table_localization.setLocale("de-de");
        })

        $("#lang-default").click(function(){
            example_table_localization.setLocale("");
        })

        var example_table_localization = new Tabulator("#example-table-localization", {
            height:"311px",
            data:tabledata,
            pagination:"local",
            layout:"fitColumns",
            langs:{
                "fr-fr":{
                    "columns":{
                        "name":"Nom",
                        "progress":"Progression",
                        "gender":"Genre",
                        "rating":"Évaluation",
                        "col":"Couleur",
                        "dob":"Date de Naissance",
                    },
                    "pagination":{
                        "first":"Premier",
                        "first_title":"Premier Page",
                        "last":"Dernier",
                        "last_title":"Dernier Page",
                        "prev":"Précédent",
                        "prev_title":"Précédent Page",
                        "next":"Prochain",
                        "next_title":"Prochain Page",
                    },
                },
                "de-de":{
                    "columns":{
                        "name":"Name",
                        "progress":"Fortschritt",
                        "gender":"Genre",
                        "rating":"Geschlecht",
                        "col":"Farbe",
                        "dob":"Geburtsdatum",
                    },
                    "pagination":{
                        "first":"Zuerst",
                        "first_title":"Zuerst Seite",
                        "last":"Last",
                        "last_title":"Letzte Seite",
                        "prev":"Zurück",
                        "prev_title":"Zurück Seite",
                        "next":"Nächster",
                        "next_title":"Nächster Seite",
                    },
                },
            },
            columns:[
            {title:"Name", field:"name", width:200},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100},
            {title:"Rating", field:"rating", width:100},
            {title:"Favourite Color", field:"col"},
            {title:"Date Of Birth", field:"dob"},
            ],
        });
    })
</script></article>
<a class="anchor" id="callbacks"></a>
<article>
    <h1>Callbacks <a class="doc-link" href="/docs/4.5/callbacks"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>Tabulator features a range of callbacks to allow you to handle user interaction.</p>

    <ul>
        <li><strong>Cell Click</strong> - The cell click callback is triggered when a user left clicks on a cell, it can be set on a per column basis using the <span><strong>cellClick</strong></span> option in the columns data. (left click any cell in the gender column in this example)</li>
        <li><strong>Row Click</strong> - The row click callback is triggered when a user clicks on a row, it can be set globally, by setting the<span><strong>rowClick</strong></span>option when you create your Tabulator. (left click any row in this example)</li>
        <li><strong>Row Context Menu</strong> - The row context callback is triggered when a user right clicks on a row, it can be set globally, by setting the <span class='param'>rowContext</span> option when you create your Tabulator. (right click any row in this example)</li>
        <li><strong>Data Loaded</strong> - The data loaded callback is triggered when a new set of data is loaded into the table, it can be set globally, by setting the <span class='param'>dataLoaded</span> option when you create your</li>
    </ul>

    <div class="example-table" id="example-table-callbacks">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>

<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;div id="example-table"&gt;&lt;/div&gt;</pre>

    <h3>JavaScript</h3>
    <pre class="prettyprint lang-js">var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    columns:[
        {title:"Name", field:"name", sorter:"string", width:150},
        {title:"Progress", field:"progress", sorter:"number", align:"right", formatter:"progress"},
        {title:"Gender", field:"gender", width:100, sorter:"string", cellClick:function(e, cell){alert("cell clicked - " + cell.getValue())}},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col", sorter:"string"},
        {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross", sorter:"boolean"},
    ],
    rowClick:function(e, row){
        alert("Row " + row.getIndex() + " Clicked!!!!")
    },
    rowContext:function(e, row){
        alert("Row " + row.getIndex() + " Context Clicked!!!!")
    },
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("callbacks", function(){
        var example_table_callbacks = new Tabulator("#example-table-callbacks", {
            height:"311px",
            data:tabledata,
            layout:"fitColumns",
            columns:[
            {title:"Name", field:"name", sorter:"string", width:150},
            {title:"Progress", field:"progress", sorter:"number", align:"right", formatter:"progress"},
            {title:"Gender", field:"gender", width:100, sorter:"string", cellClick:function(e, cell){alert("cell clicked - " + cell.getValue())}},
            {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
            {title:"Favourite Color", field:"col", sorter:"string"},
            {title:"Date Of Birth", field:"dob", sorter:"date", align:"center"},
            {title:"Driver", field:"car", align:"center", formatter:"tickCross", sorter:"boolean"},
            ],
            rowClick:function(e, row){
                alert("Row " + row.getIndex() + " Clicked!!!!")
            },
            rowContext:function(e, row){
                alert("Row " + row.getIndex() + " Context Clicked!!!!")
            },
        });
    })
</script></article>
<a class="anchor" id="theming"></a>
<article>
    <h1>Theming <a class="doc-link" href="/docs/4.5/theme"><i class="fa fa-external-link"></i> Documentation</a></h1>
    <p>Tabulator is styled using a full set of CSS classes, making theming of the table very simple. A full list of these can be found <a href="/docs/4.5/style">here.</a></p>

    <p>A <span class='param'>LESS</span> file is also provided, containing a set of variables to make generating your own theme even easier. This can be found in <span class='param'>tabulator.less</span></p>

    <p>Tabulator comes with a number of packaged themes in the <span class='param'>/dist/css/</span> directory of the package. To use one of these simply include the matching css file instead of the default <span class='param'>tabulator.css</span></p>

    <a class="anchor" id="theming-standard"></a>
    <h2>Standard Theme</h2>
    <p>The standard generic table theme. This can be found in <span class='param'>/dist/css/tabulator.min.css</span></p>
    <div id="example-table-theme-standard" class="example-themes">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;link href="css/tabulator.min.css" rel="stylesheet"&gt;</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("theme-standard", function(){
        var table = new Tabulator("#example-table-theme-standard", {
            tooltipsHeader: false,
            data:tabledata,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:226},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100, sorter:"string"},
            {title:"Rating", field:"rating", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:150, sorter:"string"},
            {title:"Date Of Birth", field:"dob", width:150, sorter:"date", align:"center"},
            ],
        });
    })
</script>
    <a class="anchor" id="theming-simple"></a>
    <h2>Simple Theme</h2>
    <p>A plain, simplistic layout showing only basic grid lines. This can be found in <span class='param'>/dist/css/tabulator_simple.min.css</span></p>

    <div id="example-table-theme-simple" class="example-themes">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;link href="css/tabulator_simple.min.css" rel="stylesheet"&gt;</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("theme-simple", function(){
        var table = new Tabulator("#example-table-theme-simple", {
            tooltipsHeader: false,
            data:tabledata,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:226},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100, sorter:"string"},
            {title:"Rating", field:"rating", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:150, sorter:"string"},
            {title:"Date Of Birth", field:"dob", width:150, sorter:"date", align:"center"},
            ],
        });
    })
</script>
    <a class="anchor" id="theming-midnight"></a>
    <h2>Midnight Theme</h2>
    <p>A dark, stylish layout using simple shades of grey. This can be found in <span class='param'>/dist/css/tabulator_midnight.min.css</span></p>

    <div id="example-table-theme-midnight" class="example-themes">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;link href="css/tabulator_midnight.min.css" rel="stylesheet"&gt;</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("theme-midnight", function(){
        var table = new Tabulator("#example-table-theme-midnight", {
            tooltipsHeader: false,
            data:tabledata,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:226},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100, sorter:"string"},
            {title:"Rating", field:"rating", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:150, sorter:"string"},
            {title:"Date Of Birth", field:"dob", width:150, sorter:"date", align:"center"},
            ],
        });
    })
</script>
    <a class="anchor" id="theming-modern"></a>
    <h2>Modern Theme</h2>
    <p>A neat, stylish layout using one primary color. This color can be set in the <span class='param'>@primary</span> variable in the <span class='param'>/dist/css/tabulator_modern.less</span> file to alter the style to match your colour scheme. This can be found in <span class='param'>/dist/css/tabulator_modern.min.css</span></p>

    <div id="example-table-theme-modern" class="example-themes">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;link href="css/tabulator_modern.min.css" rel="stylesheet"&gt;</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("theme-modern", function(){
        var table = new Tabulator("#example-table-theme-modern", {
            tooltipsHeader: false,
            data:tabledata,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:226},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100, sorter:"string"},
            {title:"Rating", field:"rating", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:150, sorter:"string"},
            {title:"Date Of Birth", field:"dob", width:150, sorter:"date", align:"center"},
            ],
        });
    })
</script>
    <a class="anchor" id="theming-bootstrap"></a>
    <h2>Bootstrap 3 Theme</h2>
    <p>Match Tabulator to the standard Bootstrap 3 theme <span class='param'>/dist/css/bootstrap/tabulator_bootstrap.min.css</span></p>

    <div id="example-table-theme-bootstrap" class="example-themes bootstrap">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;link href="css/bootstrap/tabulator_bootstrap.min.css" rel="stylesheet"&gt;</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("theme-bootstrap3", function(){
        var table = new Tabulator("#example-table-theme-bootstrap", {
            tooltipsHeader: false,
            data:tabledata,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:226},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100, sorter:"string"},
            {title:"Rating", field:"rating", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:150, sorter:"string"},
            {title:"Date Of Birth", field:"dob", width:150, sorter:"date", align:"center"},
            ],
        });
    })
</script>
    <a class="anchor" id="theming-boostrap4"></a>
    <h2>Bootstrap 4 Theme</h2>
    <p>Match Tabulator to the standard Bootstrap 4 theme <span class='param'>/dist/css/bootstrap/tabulator_bootstrap4.min.css</span></p>

    <div id="example-table-theme-bootstrap4" class="example-themes bootstrap">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;link href="css/bootstrap/tabulator_bootstrap4.min.css" rel="stylesheet"&gt;</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("theme-bootstrap4", function(){
        var table = new Tabulator("#example-table-theme-bootstrap4", {
            tooltipsHeader: false,
            data:tabledata,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:226},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100, sorter:"string"},
            {title:"Rating", field:"rating", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:150, sorter:"string"},
            {title:"Date Of Birth", field:"dob", width:150, sorter:"date", align:"center"},
            ],
        });
    })
</script>
    <a class="anchor" id="theming-semantic-ui"></a>
    <h2>Semantic UI Theme</h2>
    <p>Match Tabulator to the standard Semantic UI theme <span class='param'>/dist/css/semantic-ui/tabulator_semantic-ui.min.css</span></p>

    <div id="example-table-theme-semantic-ui" class="example-themes">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;link href="css/semantic-ui/tabulator_semantic-ui.min.css" rel="stylesheet"&gt;</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("theme-semanticui", function(){
        var table = new Tabulator("#example-table-theme-semantic-ui", {
            tooltipsHeader: false,
            data:tabledata,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:226},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100, sorter:"string"},
            {title:"Rating", field:"rating", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:150, sorter:"string"},
            {title:"Date Of Birth", field:"dob", width:150, sorter:"date", align:"center"},
            ],
        });
    })
</script>
    <a class="anchor" id="theming-bulma"></a>
    <h2>Bulma Theme</h2>
    <p>Match Tabulator to the standard Bulma theme <span class='param'>/dist/css/bulma/tabulator_bulma.min.css</span></p>

    <style>
       /*Theme the Tabulator element*/
       #example-table-theme-bulma{
           font-size:14px;
           border:none;
       }

       #example-table-theme-bulma .tabulator-col {
        border-right:none;
       }
</style>

<div id="example-table-theme-bulma" class="example-themes bulma">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;link href="css/bulma/tabulator_bulma.min.css" rel="stylesheet"&gt;</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("theme-bulma", function(){
        var table = new Tabulator("#example-table-theme-bulma", {
            tooltipsHeader: false,
            data:tabledata,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:226},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100, sorter:"string"},
            {title:"Rating", field:"rating", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:150, sorter:"string"},
            {title:"Date Of Birth", field:"dob", width:150, sorter:"date", align:"center"},
            ],
        });
    })
</script>
    <a class="anchor" id="theming-materialize"></a>
    <h2>Materialize Theme</h2>
    <p>Match Tabulator to the standard Materialize theme <span class='param'>/dist/css/materialize/tabulator_materialize.min.css</span></p>

    <style>
       /*Theme the Tabulator element*/

       #example-table-theme-materialize{
        border:none;
       }

       #example-table-theme-materialize .tabulator-header,  #example-table-theme-materialize .tabulator-tableHolder .tabulator-table{
           color:rgba(0,0,0,0.6);
       }

       #example-table-theme-materialize .tabulator-col, #example-table-theme-materialize .tabulator-row .tabulator-cell{
          border-right:none;
       }
</style>

<div id="example-table-theme-materialize" class="example-themes materialize">
    <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
</div>
<button class="view-source">View Source</button>
<fieldset class="source">
    <legend>Source Code</legend>
    <h3>HTML</h3>
    <pre class="prettyprint lang-html">&lt;link href="css/materialize/tabulator_materialize.min.css" rel="stylesheet"&gt;</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("theme-materialize", function(){
        var example_table_theme_materialize = new Tabulator("#example-table-theme-materialize", {
            tooltipsHeader: false,
            data:tabledata,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:226},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100, sorter:"string"},
            {title:"Rating", field:"rating", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:150, sorter:"string"},
            {title:"Date Of Birth", field:"dob", width:150, sorter:"date", align:"center"},
            ],
        });
    })
</script>
    <a class="anchor" id="theming-manual"></a>
    <h2>Manually Adjusted Theme</h2>
    <p>You can override the default  tabulator styling in document, or simply edit the provided <span class='param'>tabulator.min.css</span> file to make your own custom theme.</p>

    <style>
        /*Theme the Tabulator element*/
        #example-table-theme{
            background-color:#ccc;
            border: 1px solid #333;
            border-radius: 10px;
        }

        /*Theme the header*/
        #example-table-theme .tabulator-header {
            background-color:#333;
            color:#fff;
        }

        /*Allow column header names to wrap lines*/
        #example-table-theme .tabulator-header .tabulator-col,
        #example-table-theme .tabulator-header .tabulator-col-row-handle {
            white-space: normal;
        }

        /*Color the table rows*/
        #example-table-theme .tabulator-tableHolder .tabulator-table .tabulator-row{
            color:#fff;
            background-color: #666;
        }

        /*Color even rows*/
        #example-table-theme .tabulator-tableHolder .tabulator-table .tabulator-row:nth-child(even) {
            background-color: #444;
        }


        #example-table-theme-bootstrap4 .tabulator-header{
            font-size:14px !important;
        }

        #example-table-theme-bootstrap4 .tabulator-row .tabulator-cell{
            font-size:14px !important;
        }

        #example-table-theme-simple{
            border:1px solid #ddd;
        }


        .bootstrap.tabulator{
            border-bottom:none !important;
        }

        .bootstrap.tabulator .tabulator-header{
            background:#fff !important;
            color:#000 !important;
        }

        .bootstrap .tabulator-header .tabulator-col{
            background:#fff !important;
            color:#000 !important;
            border-left:none !important;
            border-right:none !important;
        }

        .bootstrap .tabulator-row{
            border-bottom:1px solid #ddd !important;
        }

        .bootstrap .tabulator-cell{
            background:#fff !important;
            color:#000 !important;
            border-left:none !important;
            border-right:none !important;
        }

        .tabulator .tabulator-row .tabulator-responsive-collapse table{
            border: none !important;
            width:auto !important;
        }

        .tabulator .tabulator-row .tabulator-responsive-collapse table tr{
            position: relative !important;
            border: none !important;
        }

        .tabulator .tabulator-row .tabulator-responsive-collapse table tr td{
            position: relative !important;
            border: none !important;
        }

        .tabulator .tabulator-row .tabulator-responsive-collapse table tr td:first-of-type{
            padding-right:10px !important;
        }

        .example-table.intertable{
            display: inline-block;
            width:40%;
        }

    </style>


    <div id="example-table-theme">
        <div class="loader"><i class="fa fa-spinner fa-pulse fa-fw"></i><div>Loading Example...</div></div>
    </div>

    <button class="view-source">View Source</button>
    <fieldset class="source">
      <legend>Source Code</legend>
      <h3>HTML</h3>
      <pre class="prettyprint lang-html">&lt;div id="example-table-theme"&gt;&lt;/div&gt;</pre>

      <h3>CSS</h3>
      <pre class="prettyprint lang-css">/*Theme the Tabulator element*/
#example-table-theme{
    background-color:#ccc;
    border: 1px solid #333;
    border-radius: 10px;
}

/*Theme the header*/
#example-table-theme .tabulator-header {
    background-color:#333;
    color:#fff;
}

/*Allow column header names to wrap lines*/
#example-table-theme .tabulator-header .tabulator-col,
#example-table-theme .tabulator-header .tabulator-col-row-handle {
    white-space: normal;
}

/*Color the table rows*/
#example-table-theme .tabulator-tableHolder .tabulator-table .tabulator-row{
    color:#fff;
    background-color: #666;
}

/*Color even rows*/
    #example-table-theme .tabulator-tableHolder .tabulator-table .tabulator-row:nth-child(even) {
    background-color: #444;
}</pre>

<h3>JavaScript</h3>
<pre class="prettyprint lang-js">var table = new Tabulator("#example-table-theme", {
    height:"331px",
    layout:"fitColumns",
    tooltipsHeader: false,
    columns:[
        {title:"Name", field:"name", sorter:"string", width:150},
        {title:"Progress", field:"progress", sorter:"number", align:"right", formatter:"progress"},
        {title:"Gender", field:"gender", width:100, sorter:"string", cellClick:function(e, cell){alert("cell clicked - " + cell.getValue())}},
        {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
        {title:"Favourite Color", field:"col", width:100, sorter:"string"},
        {title:"Date Of Birth", field:"dob", width:100, sorter:"date", align:"center"},
        {title:"Driver", field:"car", align:"center", formatter:"tickCross", sorter:"boolean"},
    ],
    rowClick:function(e, id, data, row){
        alert("Row " + id + " Clicked!!!!")
    },
    rowContext:function(e, id, data, row){
        alert("Row " + id + " Context Clicked!!!!")
    },
});</pre>
</fieldset>

<script type="text/javascript">
    TableLoader.register("theme-manual", function(){
        var table = new Tabulator("#example-table-theme", {
            height:"331px",
            layout:"fitColumns",
            tooltipsHeader: false,
            data:tabledata,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:150},
            {title:"Progress", field:"progress", sorter:"number", align:"right", formatter:"progress"},
            {title:"Gender", field:"gender", width:100, sorter:"string", cellClick:function(e, cell){alert("cell clicked - " + cell.getValue())}},
            {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:100, sorter:"string"},
            {title:"Date Of Birth", field:"dob", width:100, sorter:"date", align:"center"},
            {title:"Driver", field:"car", align:"center", formatter:"tickCross", sorter:"boolean"},
            ],
        });
    })
</script>
</article>
	</div>


</div>


    <hr>

    <footer>
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright &copy; Oli Folkerd 2016 - 2019</p>
        </div>
      </div>
    </footer>
  </main>





  <!-- Bootstrap Core JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
  <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?style=desert"></script>
  <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/lang-css.js"></script>

  <script type="text/javascript">

	$tables = [];

	$(".view-source").on("click", function(){
		$(this).next(".source").slideToggle();
	});




</script>
  
  <script type="text/javascript">

    //google analytics tracking code
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-77206751-1', 'auto');
    ga('send', 'pageview');

    $("#github-link").click(function(){
      ga('send', 'event', {
        eventCategory: 'Github Link',
        eventAction: 'click',
        eventLabel: 'Github Link',
        transport: 'beacon'
      })
    });

    //track social shares
    $(".share a").on("click", function(){
      ga('send', 'event', {
        eventCategory: 'Social Share',
        eventAction: 'click',
        eventLabel: $(this).data("type"),
        transport: 'beacon'
      })
    });

    //track source views
    $(".view-source").on("click", function(){
        ga('send', 'event', {
            eventCategory: 'View Source',
            eventAction: 'click',
            eventLabel: $(this).closest("article").prev(".anchor").attr("id"),
            transport: 'beacon'
        })
    });

    //track example lookups
    $(".example-link").on("click", function(){
        ga('send', 'event', {
            eventCategory: 'Interactive Demo',
            eventAction: 'click',
            eventLabel: $(this).attr("href").split("#")[1],
            transport: 'beacon'
        })
    });

    //track documentation lookups
    $(".doc-link").on("click", function(){
        ga('send', 'event', {
            eventCategory: 'Documentation Lookup',
            eventAction: 'click',
            eventLabel: $(this).attr("href").split("#")[1],
            transport: 'beacon'
        })
    });

    //track sidebar navigation
    $(".docs-sidenav li a").on("click", function(){
        ga('send', 'event', {
            eventCategory: 'Sidebar Nav - Documentation',
            eventAction: 'click',
            eventLabel: $(this).attr("href").split("#")[1],
            transport: 'beacon'
        });
    });

  </script>

  <script type="text/javascript">

	$('body').scrollspy({
		target: '.docs-sidenav-detailed',
		offset: 40
	});

	$( document ).ready(function(){

		if($(".docs-sidenav-detailed ul.nav li.active a").length){
			TableLoader.trigger($(".docs-sidenav-detailed ul.nav li.active a").attr("href").substr(1));
		}else{
			TableLoader.loadFirst();
		}

		//trigger table loads on focus
		$('body').on('activate.bs.scrollspy', 'li', function (e) {
			var id = $(this).find("a").attr("href").split("#")[1];

			TableLoader.trigger(id);
		});

	});

	$(".docs-sidenav-detailed h2").click(function(){
		$(this).closest("li").toggleClass("open");
	});

</script>

  <script type="text/javascript">
/*   $("#example-table-theme").closest("article").on("build", function(){

     $("#example-table-theme").tabulator({
         height:"331px",
         layout:"fitColumns",
         tooltipsHeader: false,
         columns:[
         {title:"Name", field:"name", sorter:"string", width:150},
         {title:"Progress", field:"progress", sorter:"number", align:"right", formatter:"progress"},
         {title:"Gender", field:"gender", width:100, sorter:"string", cellClick:function(e, cell){alert("cell clicked - " + cell.getValue())}},
         {title:"Rating", field:"rating", formatter:"star", align:"center", width:100},
         {title:"Favourite Color", field:"col", width:100, sorter:"string", sortable:false},
         {title:"Date Of Birth", field:"dob", width:100, sorter:"date", align:"center"},
         {title:"Driver", field:"car", align:"center", formatter:"tickCross", sorter:"boolean"},
         ],
     });

     // $("#example-table-theme").tabulator("setData", tabledata);

     function initializeThemeTables(i){

        var table = $(".example-themes:eq(" + i + ")");

        table.tabulator({
            tooltipsHeader: false,
            columns:[
            {title:"Name", field:"name", sorter:"string", width:226},
            {title:"Progress", field:"progress", width:120, sorter:"number"},
            {title:"Gender", field:"gender", width:100, sorter:"string"},
            {title:"Rating", field:"rating", align:"center", width:100},
            {title:"Favourite Color", field:"col", width:150, sorter:"string", sortable:false},
            {title:"Date Of Birth", field:"dob", width:150, sorter:"date", align:"center"},
            ],
        });

        table.tabulator("setData", tabledata);

        setTimeout(function(){
            initializeThemeTables(++i);
        }, 100);
     }

     initializeThemeTables(0);

 });*/
</script>

  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.js"></script> -->
  <script type="text/javascript" src="js/docsearchbackup/docsearch.js"></script>
  <script type="text/javascript"> docsearch({
    apiKey: '116ec31aae70c056b3267e2e05932dde',
    indexName: 'tabulator',
    inputSelector: '#sidebar-search-input',
    debug: true, // Set debug to true if you want to inspect the dropdown
    transformData: function(suggestions) {
      suggestions.forEach(function(sug){
        for(var i = 0; i <= 6; i++){
          var key = "lvl" + i;
          if(sug._highlightResult.hierarchy[key] && sug._highlightResult.hierarchy[key].value){
            sug._highlightResult.hierarchy[key].value = sug._highlightResult.hierarchy[key].value.replace("Try Interactive Demo", "")
          }
        }
      });

      return suggestions;
    },
    algoliaOptions:{
      clickAnalytics: true,
    },
    autocompleteOptions: {
        // dropdownMenuContainer :"#use-me",
    }
  });
  </script>

</body>

</html>

