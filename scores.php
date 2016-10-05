<head>
<title>Sort Tetris: High Scores</title>
<style>
@import url("jquery.dynatable.css");
#my-ajax-table {width: 50%}

table {border: 1px solid black  }
#json-records { display: none }
#wrapper { width: 50% }
</style>
<script src="jquery.js"></script>
<script src="jquery.dynatable.js"></script>

<script>
$(document).ready(function() {
    $('#my-ajax-table').dynatable({
      });
    var $records = $('#json-records'),
      myRecords = JSON.parse($records.text());
    $('#my-final-table').dynatable({
      dataset: {
	records: myRecords,
	    perPageDefault: 100,
	    }
      });
});
</script>
</head>

<body>
<div id="wrapper">

<table id="my-final-table">
  <thead>
  <th data-dynatable-column="game_id">Game ID</th>
  <th data-dynatable-column="time_entry">Timestamp</th>
  <th data-dynatable-column="username">Player</th>
  <th>Score</th>
  <th>Percent</th>
  <th>Level</th>
  <th data-dynatable-column="config_file">Config</th>
  </thead>
  <tbody>
  </tbody>
</table>
</div>

<pre id="json-records">
<?
  $ajax_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/ajax.php?action=supervisor&config_file=bib';
print(file_get_contents($ajax_url));
?>
</pre>
</body>