<?php
session_start();
include('functions.php');
if (!isset($_SESSION['institution_id'])) {
  header('Location: login.php');
  die();
}
?>
<head>
<title>Sort Tetris: High Scores - <?php print $_REQUEST['title']; ?></title>
<style>
@import url("../style.css");
@import url("../lib/jquery.dynatable.css");
#my-ajax-table {width: 50%}

table {border: 1px solid black  }
#json-records { display: none }
#wrapper { width: 50% }
</style>
<script src="../lib/jquery.js"></script>
<script src="../lib/jquery.dynatable.js"></script>
<?php
  $path = $_SERVER['REQUEST_SCHEME'] .'://'.$_SERVER['HTTP_HOST']. preg_replace('/\/supervisor\/.*/','/',$_SERVER['REQUEST_URI']);
$ajax_url = $path.'ajax.php?action=supervisor&config_file='.$_REQUEST['config'].'&inst_id='.$_SESSION['institution_id'];
$json = CurlGet($ajax_url);
$series_json = json2highcharts($json);
?>
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
	    perPageOptions: [10,20,50,100,500,1000],
	    sortTypes: {
	    'game_id': 'number',
	      'score': 'number',
	      'percent': 'number',
	      'level': 'number'
	  },
	    }
      });

    $('#container').highcharts({
        title: {
	  text: 'User Scores over Time',
	  x: -20
	},
	chart: {
	  type: 'spline',
        },
        xAxis: {
            title: {
                text: 'Game #'
            }
        },
        yAxis: {
            title: {
                text: 'Score'
            },
            min: 0
        },
        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },
series : 
	<?php echo($series_json);?>

    });


});
</script>
</head>

<body>
<h1>Scores: <? print $_REQUEST['title']; ?></h1>
<?php include("display_login.php"); ?>
<p><a href="./">Return to Main Supervisor Screen</a></p>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


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
  print ($json);
?>
</pre>
</body>
<?php
function json2highcharts ($json) {
  $array = json_decode($json);
  $players = array();
  $series = array();
  foreach (array_reverse($array) as $obj) {
    $player = $obj->username;
    if (! isset($counts[$player])) {
      $counts[$player] = 0;
    }
    else { $counts[$player]++; }
    //    $data = array(intval($obj->game_id), intval($obj->score));
    $data = array($counts[$player], intval($obj->score));
    if (! isset($players[$player])) { $players[$player] = array(); }
    array_push($players[$player], $data);
  }
  
  foreach($players as $name=>$data) {
    $o = new stdClass();
    $o->name = $name;
    $o->data = $data;
    array_push($series, $o);
  }
  
  return (json_encode($series));
}
?>

<?php include('../license.php'); ?>
<?php
include('../global_settings.php');
if (isset($google_analytics_id)) {
  include_once('../google_analytics.php');
}
?>