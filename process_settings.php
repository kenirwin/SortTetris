<?php
$item_label_cap = ucfirst($item_label);
$json_buttons = json_encode($buttons);
if (empty($game_logo_file)) {
    $game_header = '<h1>'.$game_title.'</h1>';
}
else {
    $game_header = '<img src="'.$game_logo_file.'" />';
}

if (! (isset($colors_override) && is_array($colors_override))) {
$colors = [
    ['#00e427', '#bdffca', '#009c1a', '#00961a', '#2dff55'], //green
    ['#e4de00','#ffffbd','#a39c00','#968f00','#fff83a'], //yellow
    ['#00e4e4','#c4ffff','#00aaaa','#009696','#34ffff'], //lightblue
    ['#ff4500','#ffe4d8','#be3000','#b12c00','#ff8155'], //orange
    ['#ff00ff','#ffd8fe','#bb00be','#ad00b1','#fd55ff'], //pink
    ['#009fd4','#ade8ff','#007193','#006786','#2accff'], //blue
];
}
else {
    $colors = $colors_override;
}

?>
<script type="text/javascript">
var settings_buttons = <?php print($json_buttons); ?>;
var settings_dataFile = "<?php print($data_file); ?>";
var settings_audioOK = <?php if($audioOK) { print 'true'; } else print 'false'; ?>;
var settings_itemLabel = "<?php print($item_label_cap); ?>";
var settings_pointUnits = <?php print($point_units); ?>;
var settings_interval = <?php print($drop_delay); ?>;
var settings_intervalDecreasePerLevel = <?php print($delay_decrease_per_level); ?>;
var settings_height = <?php print($height); ?>;
var settings_correctPerLevel = <?php print($correct_per_level); ?>;
var settings_winAtLevel = <?php print($win_at_level); ?>;
var settings_config = "<?php print($_REQUEST['settings']);?>";
var settings_colors = <?php print(json_encode($colors));?>;
</script>

<?php
if (! empty($google_analytics_id)) {
    $google_analytics_block = <<<END
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '$google_analytics_id']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; 
ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 
'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; 
s.parentNode.insertBefore(ga, s);
  })();

</script>
END;
}
?>