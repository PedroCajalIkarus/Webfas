<!DOCTYPE HTML>
<html>
<head>
  <title>Timeline | Basic demo</title>

  <script src="vis-timeline-graph2d.min.js"></script>
  <link href="vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
    body, html {
      font-family: sans-serif;
    }

    .vis-item.red
    {
        border-color: red;
        color:red;
         background-color: red;
    }
    .itemyellow
    {
        border-color: yellow;
         background-color: yellow;
    }
    .itemorange
    {
        border-color: orange;
         background-color: orange;
    }
  </style>

</head>
<body>
<div id="visualization"></div>

<script type="text/javascript">

var item2 = document.createElement('div');
  item2.innerHTML = '<a href="#" onclick="openventana()"><span style="color:red">item 2 test rojo</span></a>';


  // create groups to highlight groupUpdate
  var groups = new vis.DataSet([
    {id: 1, content: 'Group 1'},
    {id: 2, content: 'Group 2'}
  ]);
  // create a DataSet with items
  var items = new vis.DataSet([
    {id: 1, content: 'Editable <span style="color:red">esgrupo1_mm</span>', editable: true, start: '2010-08-23', group: 1, className:'vis-item.red' },
    {id: 2, content: item2, editable: true, start: '2010-08-23T23:00:00', group: 2},
    {id: 3, content: 'Read-only esgrupo1', editable: false, start: '2010-08-24T16:00:00', group: 1},
    {id: 4, content: 'Read-only', editable: false, start: '2010-08-26', end: '2010-09-02', group: 2},
    {id: 5, content: 'Edit Time Only esgrupo1', editable: { updateTime: true, updateGroup: false, remove: false }, start: '2010-08-28', group: 1},
    {id: 6, content: 'Edit Group Only', editable: { updateTime: false, updateGroup: true, remove: false }, start: '2010-08-29', group: 2},
    {id: 7, content: 'Remove Only esgrupo1', editable: { updateTime: false, updateGroup: false, remove: false }, start: '2010-08-31', end: '2010-09-03', group: 1},
    {id: 8, content: 'Default', start: '2010-09-04T12:00:00', group: 2}
  ]);

  var container = document.getElementById('visualization');
  var options = {
    editable: true   // default for all items
  };

  var timeline = new vis.Timeline(container, items, groups, options);
  

function openventana()
{
    alert('a');
}

</script>
</body>
</html>