<?php
$item_label_cap = ucfirst($item_label);
$json_buttons = json_encode($buttons);
if (empty($game_logo_file)) {
    $game_header = '<h1>'.$game_title.'</h1>';
}
else {
    $game_header = '<img src="'.$game_logo_file.'" />';
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
var settings_colors = <?print(json_encode($colors));?>
</script>

