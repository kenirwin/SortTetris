<?php
$item_label_cap = ucfirst($item_label);
$json_buttons = json_encode($buttons);
if (empty($game_logo_file)) {
    $game_header = '<h1>'.$game_title.'</h1>';
}
else {
    $game_header = '<img src="'.$game_logo_file.'" />';
}

$game_header .= '<div id="links"><span id="choose-game"><a href="./">Choose another game</a></span>';
if (isset($infopage) && file_exists('infopages/'.$infopage) && $infopage != '') {
  $game_header.=' | <span id="infopage">Need help identifying items? <a href="infopages/'.$infopage.'">Here is a helpful guide</a>';
  if ($mysql_connected && $display_supervisor_reg_links && $allow_supervisor_registration) {
    $game_header.='| <a href="supervisor">For supervisors</a>';
  }
  $game_header .= '</span>';
}
$game_header .= '</div>'.PHP_EOL;

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
var settings_audioOK = <?php if(isset($audioOK) && $audioOK) { print 'true'; } else print 'false'; ?>;
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
