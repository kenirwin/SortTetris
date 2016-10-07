<?
$url = 'http://www.sort-tetris.com/test/ajax.php?action=supervisor&config_file='.$_REQUEST['config'];
$json = file_get_contents($url);
$series_json = json2highcharts($json);
?>


<html>
<head>
		<script type="text/javascript" src="../lib/jquery.js"></script>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'spline'
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>

<?
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
    if (! is_array($players[$player])) { $players[$player] = array(); }
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