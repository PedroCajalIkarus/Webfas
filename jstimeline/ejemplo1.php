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
        color:white;
         background-color: red;
    }

    .vis-item.tttt
    {
         border-color: #202020;
         color:white;
         background-color: #202020;
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

    body, html {
      font-family: arial, sans-serif;
      font-size: 11pt;
    }

    textarea {
      width: 800px;
      height: 200px;
    }

    .buttons {
      margin: 20px 0;
    }

    .buttons input {
      padding: 10px;
    }
  </style>



 

<h1>Serialization and deserialization</h1>

<p>This example shows how to serialize and deserialize JSON data, and load this in the Timeline via a DataSet. Serialization and deserialization is needed when loading or saving data from a server.</p>

<textarea id="data">
[
{"id":1,"content":"item 2 en rojo","start":"2021-05-24 12:50:05","end":"2021-05-24 12:50:05","className":"tttt","editable":"false","selectable":"false","group":1},{"id":2,"content":"item 2 en rojo","start":"2021-05-24 12:51:09","end":"2021-05-24 12:52:54","className":" red","editable":"false","selectable":"false","group":1},{"id":3,"content":"item 2 en rojo","start":"2021-05-24 12:55:36","end":"2021-05-24 12:57:20","className":" red","editable":"false","selectable":"false","group":1},{"id":4,"content":"item 2 en rojo","start":"2021-05-24 13:00:26","end":"2021-05-24 13:15:37","className":" red","editable":"false","selectable":"false","group":1},{"id":5,"content":"item 2 en rojo","start":"2021-05-24 13:58:55","end":"2021-05-24 13:58:55","className":" red","editable":"false","selectable":"false","group":1},{"id":6,"content":"item 2 en rojo","start":"2021-05-24 14:00:03","end":"2021-05-24 14:01:42","className":" red","editable":"false","selectable":"false","group":1},{"id":7,"content":"item 2 en rojo","start":"2021-05-24 07:23:32","end":"2021-05-24 07:25:14","className":" red","editable":"false","selectable":"false","group":2},{"id":8,"content":"item 2 en rojo","start":"2021-05-24 07:26:36","end":"2021-05-24 07:36:27","className":" red","editable":"false","selectable":"false","group":2},{"id":9,"content":"item 2 en rojo","start":"2021-05-24 07:40:49","end":"2021-05-24 07:57:34","className":" red","editable":"false","selectable":"false","group":2},{"id":10,"content":"item 2 en rojo","start":"2021-05-24 07:59:52","end":"2021-05-24 08:13:39","className":" red","editable":"false","selectable":"false","group":2},{"id":11,"content":"item 2 en rojo","start":"2021-05-24 08:15:53","end":"2021-05-24 08:25:01","className":" red","editable":"false","selectable":"false","group":2},{"id":12,"content":"item 2 en rojo","start":"2021-05-24 08:58:35","end":"2021-05-24 08:58:35","className":" red","editable":"false","selectable":"false","group":2},{"id":13,"content":"item 2 en rojo","start":"2021-05-24 09:02:23","end":"2021-05-24 09:02:23","className":" red","editable":"false","selectable":"false","group":2},{"id":14,"content":"item 2 en rojo","start":"2021-05-24 09:03:04","end":"2021-05-24 09:03:04","className":" red","editable":"false","selectable":"false","group":2},{"id":15,"content":"item 2 en rojo","start":"2021-05-24 09:54:24","end":"2021-05-24 09:54:24","className":" red","editable":"false","selectable":"false","group":2},{"id":16,"content":"item 2 en rojo","start":"2021-05-24 11:13:14","end":"2021-05-24 11:13:14","className":" red","editable":"false","selectable":"false","group":2},{"id":17,"content":"item 2 en rojo","start":"2021-05-24 12:03:34","end":"2021-05-24 12:03:34","className":" red","editable":"false","selectable":"false","group":2},{"id":18,"content":"item 2 en rojo","start":"2021-05-24 12:04:43","end":"2021-05-24 12:04:43","className":" red","editable":"false","selectable":"false","group":2},{"id":19,"content":"item 2 en rojo","start":"2021-05-24 13:02:25","end":"2021-05-24 13:05:05","className":" red","editable":"false","selectable":"false","group":2},{"id":20,"content":"item 2 en rojo","start":"2021-05-24 13:11:49","end":"2021-05-24 13:16:28","className":" red","editable":"false","selectable":"false","group":2},{"id":21,"content":"item 2 en rojo","start":"2021-05-24 13:24:00","end":"2021-05-24 13:54:00","className":" red","editable":"false","selectable":"false","group":2},{"id":22,"content":"item 2 en rojo","start":"2021-05-24 07:37:05","end":"2021-05-24 07:43:31","className":" red","editable":"false","selectable":"false","group":3},{"id":23,"content":"item 2 en rojo","start":"2021-05-24 07:46:40","end":"2021-05-24 08:19:28","className":" red","editable":"false","selectable":"false","group":3},{"id":24,"content":"item 2 en rojo","start":"2021-05-24 09:02:55","end":"2021-05-24 09:02:55","className":" red","editable":"false","selectable":"false","group":3},{"id":25,"content":"item 2 en rojo","start":"2021-05-24 09:14:00","end":"2021-05-24 09:14:00","className":" red","editable":"false","selectable":"false","group":3},{"id":26,"content":"item 2 en rojo","start":"2021-05-24 09:15:02","end":"2021-05-24 09:50:29","className":" red","editable":"false","selectable":"false","group":3},{"id":27,"content":"item 2 en rojo","start":"2021-05-24 10:11:45","end":"2021-05-24 10:45:20","className":" red","editable":"false","selectable":"false","group":3},{"id":28,"content":"item 2 en rojo","start":"2021-05-24 11:35:17","end":"2021-05-24 11:35:17","className":" red","editable":"false","selectable":"false","group":3},{"id":29,"content":"item 2 en rojo","start":"2021-05-24 12:23:35","end":"2021-05-24 12:23:35","className":" red","editable":"false","selectable":"false","group":3},{"id":30,"content":"item 2 en rojo","start":"2021-05-24 13:32:34","end":"2021-05-24 13:32:34","className":" red","editable":"false","selectable":"false","group":3},{"id":31,"content":"item 2 en rojo","start":"2021-05-24 13:35:26","end":"2021-05-24 13:35:26","className":" red","editable":"false","selectable":"false","group":3},{"id":32,"content":"item 2 en rojo","start":"2021-05-24 14:03:04","end":"2021-05-24 14:03:04","className":" red","editable":"false","selectable":"false","group":3},{"id":33,"content":"item 2 en rojo","start":"2021-05-24 08:15:04","end":"2021-05-24 08:15:04","className":" red","editable":"false","selectable":"false","group":4},{"id":34,"content":"item 2 en rojo","start":"2021-05-24 08:15:43","end":"2021-05-24 08:15:43","className":" red","editable":"false","selectable":"false","group":4},{"id":35,"content":"item 2 en rojo","start":"2021-05-24 08:20:21","end":"2021-05-24 08:20:21","className":" red","editable":"false","selectable":"false","group":4},{"id":36,"content":"item 2 en rojo","start":"2021-05-24 08:35:17","end":"2021-05-24 08:35:17","className":" red","editable":"false","selectable":"false","group":4},{"id":37,"content":"item 2 en rojo","start":"2021-05-24 08:40:33","end":"2021-05-24 08:40:33","className":" red","editable":"false","selectable":"false","group":4},{"id":38,"content":"item 2 en rojo","start":"2021-05-24 08:58:16","end":"2021-05-24 08:58:16","className":" red","editable":"false","selectable":"false","group":4},{"id":39,"content":"item 2 en rojo","start":"2021-05-24 09:29:49","end":"2021-05-24 09:29:49","className":" red","editable":"false","selectable":"false","group":4},{"id":40,"content":"item 2 en rojo","start":"2021-05-24 09:55:38","end":"2021-05-24 09:55:38","className":" red","editable":"false","selectable":"false","group":4},{"id":41,"content":"item 2 en rojo","start":"2021-05-24 10:37:56","end":"2021-05-24 10:37:56","className":" red","editable":"false","selectable":"false","group":4},{"id":42,"content":"item 2 en rojo","start":"2021-05-24 11:22:39","end":"2021-05-24 11:22:39","className":" red","editable":"false","selectable":"false","group":4},{"id":43,"content":"item 2 en rojo","start":"2021-05-24 11:46:03","end":"2021-05-24 12:34:40","className":" red","editable":"false","selectable":"false","group":4},{"id":44,"content":"item 2 en rojo","start":"2021-05-24 11:50:58","end":"2021-05-24 11:50:58","className":" red","editable":"false","selectable":"false","group":4},{"id":45,"content":"item 2 en rojo","start":"2021-05-24 13:16:50","end":"2021-05-24 13:19:26","className":" red","editable":"false","selectable":"false","group":4},{"id":46,"content":"item 2 en rojo","start":"2021-05-24 13:27:45","end":"2021-05-24 14:16:45","className":" red","editable":"false","selectable":"false","group":4},{"id":47,"content":"item 2 en rojo","start":"2021-05-24 13:33:50","end":"2021-05-24 14:21:27","className":" red","editable":"false","selectable":"false","group":4},{"id":48,"content":"item 2 en rojo","start":"2021-05-24 08:40:51","end":"2021-05-24 08:40:51","className":" red","editable":"false","selectable":"false","group":5},{"id":49,"content":"item 2 en rojo","start":"2021-05-24 09:00:21","end":"2021-05-24 09:00:21","className":" red","editable":"false","selectable":"false","group":5},{"id":50,"content":"item 2 en rojo","start":"2021-05-24 09:38:42","end":"2021-05-24 09:38:42","className":" red","editable":"false","selectable":"false","group":5},{"id":51,"content":"item 2 en rojo","start":"2021-05-24 10:29:20","end":"2021-05-24 10:29:20","className":" red","editable":"false","selectable":"false","group":5},{"id":52,"content":"item 2 en rojo","start":"2021-05-24 10:57:31","end":"2021-05-24 10:57:31","className":" red","editable":"false","selectable":"false","group":5},{"id":53,"content":"item 2 en rojo","start":"2021-05-24 11:20:48","end":"2021-05-24 11:20:48","className":" red","editable":"false","selectable":"false","group":5},{"id":54,"content":"item 2 en rojo","start":"2021-05-24 12:24:48","end":"2021-05-24 12:24:48","className":" red","editable":"false","selectable":"false","group":5},{"id":55,"content":"item 2 en rojo","start":"2021-05-24 12:52:51","end":"2021-05-24 12:52:51","className":" red","editable":"false","selectable":"false","group":5},{"id":56,"content":"item 2 en rojo","start":"2021-05-24 08:22:00","end":"2021-05-24 08:22:00","className":" red","editable":"false","selectable":"false","group":6},{"id":57,"content":"item 2 en rojo","start":"2021-05-24 09:25:31","end":"2021-05-24 09:25:31","className":" red","editable":"false","selectable":"false","group":6},{"id":58,"content":"item 2 en rojo","start":"2021-05-24 09:54:16","end":"2021-05-24 09:54:16","className":" red","editable":"false","selectable":"false","group":6},{"id":59,"content":"item 2 en rojo","start":"2021-05-24 11:08:35","end":"2021-05-24 11:08:35","className":" red","editable":"false","selectable":"false","group":6},{"id":60,"content":"item 2 en rojo","start":"2021-05-24 11:54:26","end":"2021-05-24 11:54:26","className":" red","editable":"false","selectable":"false","group":6},{"id":61,"content":"item 2 en rojo","start":"2021-05-24 13:44:24","end":"2021-05-24 13:44:24","className":" red","editable":"false","selectable":"false","group":6},{"id":62,"content":"item 2 en rojo","start":"2021-05-24 13:46:33","end":"2021-05-24 14:19:12","className":" red","editable":"false","selectable":"false","group":6}]

</textarea>

<div class="buttons">
  <input type="button" id="load" value="&darr; Load" title="Load data from textarea into the Timeline">
  <input type="button" id="save" value="&uarr; Save" title="Save data from the Timeline into the textarea">
</div>

<div id="visualization"></div>

<script>
  var txtData = document.getElementById('data');
  var btnLoad = document.getElementById('load');
  var btnSave = document.getElementById('save');

  // Create an empty DataSet.
  // This DataSet is used for two way data binding with the Timeline.
  var items = new vis.DataSet();

  var groups = new vis.DataSet();

  /*
  var groups = new vis.DataSet([
    {id: 1, content: 'Group 1'},
    {id: 2, content: 'Group 2'}
  ]);*/

    // create groups to highlight groupUpdate
 var datax='[{"id":1,"content":"Uknown"},{"id":2,"content":"Station 03"},{"id":3,"content":"Station 06"},{"id":4,"content":"Station 07"},{"id":5,"content":"Station 02 FUSA JC"},{"id":6,"content":"Station 08"}]';
 var datax2 = JSON.parse(datax);
 groups.clear();
 groups.add(datax2);

  // create a timeline
  var container = document.getElementById('visualization');
  var options = {
    editable: false
  };
  var timeline = new vis.Timeline(container, items,groups, options);
 // var timeline = new vis.Timeline(container, items, options);

  function loadData () {
    // get and deserialize the data
    var data = JSON.parse(txtData.value);

    // update the data in the DataSet
    //
    // Note: when retrieving updated data from a server instead of a complete
    // new set of data, one can simply update the existing data like:
    //
    //   items.update(data);
    //
    // Existing items will then be updated, and new items will be added.
    items.clear();
    items.add(data);

    // adjust the timeline window such that we see the loaded data
    timeline.fit();
  }
  btnLoad.onclick = loadData;

  function saveData() {
    // get the data from the DataSet
    //
    // Note that we specify the output type of the fields start and end
    // as "ISODate", which is safely serializable. Other serializable types
    // are "Number" (unix timestamp), "ASPDate" or "String" (without timezone!).
    //
    // Alternatively, it is possible to configure the DataSet to convert
    // the output automatically to ISODates like:
    //
    //   var options = {
    //     type: {start: 'ISODate', end: 'ISODate'}
    //   };
    //   var items = new vis.DataSet(options);
    //   // now items.get() will automatically convert start and end to ISO dates.
    //
    var data = items.get({
      type: {
        start: 'ISODate',
        end: 'ISODate'
      }
    });

    // serialize the data and put it in the textarea
    txtData.value = JSON.stringify(data, null, 2);
  }
  btnSave.onclick = saveData;

  // load the initial data
  loadData();

  document.getElementById('visualization').onclick = function (event) {
  var props = timeline.getEventProperties(event)
  console.log(props.item);
}
  

</script>
</body>
</html>